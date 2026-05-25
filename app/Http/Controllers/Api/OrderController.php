<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()->paginate(10);
        return response()->json(['success'=>true,'data'=>$orders]);
    }

    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return response()->json(['success'=>true,'data'=>$order]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string',
            'payment_method'   => 'required|in:transfer,cod,ewallet',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['success'=>false,'message'=>'Keranjang kosong'], 400);
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
            $shipping = $request->shipping_cost ?? 15000;
            $total    = $subtotal + $shipping;

            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => 'GM-'.strtoupper(uniqid()),
                'status'           => 'pending',
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shipping,
                'total'            => $total,
                'shipping_address' => $request->shipping_address,
                'shipping_city'    => $request->shipping_city,
                'payment_method'   => $request->payment_method,
                'notes'            => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'subtotal'   => $item->product->price * $item->quantity,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            CartItem::where('user_id', auth()->id())->delete();
            DB::commit();

            return response()->json(['success'=>true,'message'=>'Pesanan berhasil dibuat','data'=>$order->load('items.product')], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>'Gagal membuat pesanan: '.$e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        if (!in_array($order->status, ['pending','processing'])) {
            return response()->json(['success'=>false,'message'=>'Pesanan tidak bisa dibatalkan'], 400);
        }
        $order->update(['status'=>'cancelled']);
        return response()->json(['success'=>true,'message'=>'Pesanan dibatalkan']);
    }
}