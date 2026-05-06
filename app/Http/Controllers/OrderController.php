<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|integer|exists:products,id',
            'items.*.qty'      => 'required|integer|min:1|max:99',
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;
            $total += $product->price * $item['qty'];
        }

        $orderCode = 'BITERITO-' . strtoupper(uniqid());

        $order = Order::create([
            'order_code'       => $orderCode,
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'customer_email'   => $request->customer_email ?? '',
            'delivery_address' => $request->delivery_address,
            'order_type'       => 'preorder',
            'total_amount'     => $total,
            'payment_status'   => 'unchecked',
            'order_status'     => 'waiting',
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $item['qty'],
                'price'      => $product->price,
                'notes'      => $item['notes'] ?? '',
            ]);
        }

        return response()->json([
            'success'    => true,
            'order_code' => $orderCode,
        ]);
    }

    public function payment($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return view('payment.index', compact('order'));
    }

    public function proofSent($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();
        return view('payment.proof-sent', compact('order'));
    }

    public function uploadProof(Request $request, $orderCode)
    {
        $request->validate([
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ]);

        $order = Order::where('order_code', $orderCode)->firstOrFail();

        $path = $request->file('proof')->store('payment-proofs', 'public');
        $order->update(['payment_proof' => $path]);

        return redirect()->route('payment.proof-sent', $orderCode);
    }
}
