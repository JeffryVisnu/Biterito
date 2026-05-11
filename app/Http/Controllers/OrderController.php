<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'delivery_session' => 'required|in:sesi1,sesi2',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|integer|exists:products,id',
            'items.*.qty'      => 'required|integer|min:1|max:99',
        ]);

        $items = [];
        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;
            $total += $product->price * $item['qty'];
            $items[] = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'quantity'     => $item['qty'],
                'price'        => $product->price,
                'notes'        => $item['notes'] ?? '',
            ];
        }

        session([
            'pending_order' => [
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'delivery_address' => $request->delivery_address,
                'delivery_session' => $request->delivery_session,
                'items'            => $items,
                'total'            => $total,
            ]
        ]);

        return response()->json(['success' => true]);
    }

    public function pendingPayment()
    {
        $pending = session('pending_order');
        if (!$pending) return redirect('/');
        return view('payment.index', ['pending' => $pending, 'order' => null]);
    }

    public function payment($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return view('payment.index', ['order' => $order, 'pending' => null]);
    }

    public function proofSent($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return view('payment.proof-sent', compact('order'));
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ]);

        $pending = session('pending_order');
        if (!$pending) return redirect('/');

        $orderCode = 'BITERITO-' . strtoupper(uniqid());

        $order = Order::create([
            'order_code'       => $orderCode,
            'customer_name'    => $pending['customer_name'],
            'customer_phone'   => $pending['customer_phone'],
            'customer_email'   => '',
            'delivery_address' => $pending['delivery_address'],
            'order_type'       => 'preorder',
            'total_amount'     => $pending['total'],
            'payment_status'   => 'unchecked',
            'order_status'     => 'waiting',
            'delivery_session' => $pending['delivery_session'],
            'delivery_date'    => 'Kamis, 14 Mei 2026',
        ]);

        foreach ($pending['items'] as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'notes'      => $item['notes'],
            ]);
        }

        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
        $result = $cloudinary->uploadApi()->upload($request->file('proof')->getRealPath(), [
            'folder'        => 'biterito/payment-proofs',
            'resource_type' => 'auto',
        ]);
        $order->update(['payment_proof' => $result['secure_url']]);

        session()->forget('pending_order');

        return redirect()->route('payment.proof-sent', $orderCode);
    }
}
