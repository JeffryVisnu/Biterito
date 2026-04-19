<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout(Request $request)
    {
        // Validasi input
        $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'delivery_address' => 'required|string',
            'items' => 'required|array|min:1',
        ]);

        // Hitung total
        $total = 0;
        $itemDetails = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;

            $subtotal = $product->price * $item['qty'];
            $total += $subtotal;

            $itemDetails[] = [
                'id' => $product->id,
                'price' => (int) $product->price,
                'quantity' => $item['qty'],
                'name' => $product->name,
            ];
        }

        // Buat order code unik
        $orderCode = 'BITERITO-' . strtoupper(uniqid());

        // Simpan order ke database
        $order = Order::create([
            'order_code' => $orderCode,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email ?? '',
            'delivery_address' => $request->delivery_address,
            'order_type' => 'preorder',
            'total_amount' => $total,
            'payment_status' => 'pending',
            'order_status' => 'waiting',
        ]);

        // Simpan order items
        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['qty'],
                'price' => $product->price,
                'notes' => $item['notes'] ?? '',
            ]);
        }

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderCode,
                'gross_amount' => (int) $total,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email ?? '',
            ],
            'enabled_payments' => ['gopay'],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan snap token
        $order->update(['midtrans_snap_token' => $snapToken]);

        return response()->json([
            'success' => true,
            'order_code' => $orderCode,
            'snap_token' => $snapToken,
        ]);
    }

    public function payment($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return view('payment.index', compact('order'));
    }

    public function webhook(Request $request)
    {
        // $serverKey = config('midtrans.server_key');
        // $hashed = hash('sha512',
        //     $request->order_id .
        //     $request->status_code .
        //     $request->gross_amount .
        //     $serverKey
        // );

        // if ($hashed !== $request->signature_key) {
        //     return response()->json(['message' => 'Invalid signature'], 403);
        // }

        $order = Order::where('order_code', $request->order_id)->first();
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $order->update(['payment_status' => 'paid', 'order_status' => 'waiting']);
        } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }

    public function checkStatus($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return response()->json(['status' => $order->payment_status]);
    }
}