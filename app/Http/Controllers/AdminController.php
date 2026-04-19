<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $admin = DB::table('admins')->where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Email atau password salah!');
        }

        session(['admin' => $admin->id, 'admin_name' => $admin->name]);
        return redirect('/admin/dashboard');
    }

    public function dashboard(Request $request)
    {
        if (!session('admin')) return redirect('/admin/login');

        $query = Order::orderBy('created_at', 'desc');

        if ($request->status) {
            $paymentStatuses = ['pending', 'paid', 'failed'];
            if (in_array($request->status, $paymentStatuses)) {
                $query->where('payment_status', $request->status);
            } else {
                $query->where('order_status', $request->status);
            }
        }

        $orders = $query->paginate(10)->appends(request()->query());
        $totalOrders    = Order::count();
        $paidOrders     = Order::where('payment_status', 'paid')->count();
        $pendingOrders  = Order::where('payment_status', 'pending')->count();
        $totalRevenue   = Order::where('payment_status', 'paid')->sum('total_amount');
        $waitingOrders  = Order::where('order_status', 'waiting')->count();
        $processOrders  = Order::where('order_status', 'process')->count();
        $readyOrders    = Order::where('order_status', 'ready')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();

        return view('admin.dashboard', compact(
            'orders', 'totalOrders', 'paidOrders', 'pendingOrders', 'totalRevenue',
            'waitingOrders', 'processOrders', 'readyOrders', 'deliveredOrders'
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
        
        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }
}

