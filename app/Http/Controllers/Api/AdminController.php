<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json(['success'=>true,'data'=>[
            'total_users'    => User::where('role','customer')->count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::where('payment_status','paid')->sum('total'),
            'recent_orders'  => Order::with('user')->latest()->take(5)->get(),
            'low_stock'      => Product::where('stock','<',5)->get(),
        ]]);
    }

    public function allOrders()
    {
        $orders = Order::with(['user','items.product'])->latest()->paginate(15);
        return response()->json(['success'=>true,'data'=>$orders]);
    }

    public function updateOrderStatus(\Illuminate\Http\Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $v = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'status'         => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|in:unpaid,paid,refunded',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $order->update($request->only('status','payment_status'));
        return response()->json(['success'=>true,'data'=>$order]);
    }

    public function allUsers()
    {
        $users = User::latest()->paginate(15);
        return response()->json(['success'=>true,'data'=>$users]);
    }
}