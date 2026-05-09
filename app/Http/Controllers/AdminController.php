<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function loginPage()
    {
        if (session('admin')) return redirect('/admin/dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = DB::table('admins')->where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Email atau password salah!');
        }

        session()->regenerate();
        session(['admin' => $admin->id, 'admin_name' => $admin->name]);
        return redirect('/admin/dashboard');
    }

    public function dashboard(Request $request)
    {
        if (!session('admin')) return redirect('/admin/login');

        $query = Order::orderBy('created_at', 'desc');

        if ($request->status) {
            $paymentStatuses = ['unchecked', 'paid'];
            if (in_array($request->status, $paymentStatuses)) {
                $query->where('payment_status', $request->status);
            } else {
                $query->where('order_status', $request->status);
            }
        }

        $orders          = $query->paginate(10)->appends(request()->query());
        $totalOrders     = Order::count();
        $paidOrders      = Order::where('payment_status', 'paid')->count();
        $uncheckedOrders = Order::where('payment_status', 'unchecked')->count();
        $totalRevenue    = Order::where('payment_status', 'paid')->sum('total_amount');
        $waitingOrders   = Order::where('order_status', 'waiting')->count();
        $processOrders   = Order::where('order_status', 'process')->count();
        $readyOrders     = Order::where('order_status', 'ready')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();

        $recapFrom = $request->recap_from;
        $recapTo   = $request->recap_to;

        $productSummary = OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->when($recapFrom, fn($q) => $q->whereHas('order', fn($o) => $o->whereDate('created_at', '>=', $recapFrom)))
            ->when($recapTo,   fn($q) => $q->whereHas('order', fn($o) => $o->whereDate('created_at', '<=', $recapTo)))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->get();

        return view('admin.dashboard', compact(
            'orders', 'totalOrders', 'paidOrders', 'uncheckedOrders', 'totalRevenue',
            'waitingOrders', 'processOrders', 'readyOrders', 'deliveredOrders',
            'productSummary', 'recapFrom', 'recapTo'
        ));
    }

    public function orderDetail($id)
    {
        if (!session('admin')) return redirect('/admin/login');
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }

    public function logout()
    {
        session()->forget(['admin', 'admin_name']);
        return redirect('/admin/login');
    }

    public function updateStatus(Request $request, $id)
    {
        if (!session('admin')) return redirect('/admin/login');

        $request->validate([
            'order_status' => 'required|in:waiting,process,ready,delivered',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        if (!session('admin')) return redirect('/admin/login');

        $request->validate([
            'payment_status' => 'required|in:unchecked,paid',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate!');
    }

    public function deleteOrder($id)
    {
        if (!session('admin')) return redirect('/admin/login');

        $order = Order::findOrFail($id);
        $order->delete();

        return redirect('/admin/dashboard')->with('success', 'Order berhasil dihapus!');
    }
}
