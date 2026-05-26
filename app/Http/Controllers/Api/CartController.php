<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product.category')
            ->where('user_id', auth()->id())
            ->get();

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);
        return response()->json(['success'=>true,'data'=>['items'=>$items,'total'=>$total]]);
    }

    public function add(Request $request)
    {
        $v = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            return response()->json(['success'=>false,'message'=>'Stok tidak cukup'], 400);
        }

        $item = CartItem::updateOrCreate(
            ['user_id'=>auth()->id(), 'product_id'=>$request->product_id],
            ['quantity' => \DB::raw("quantity + {$request->quantity}")]
        );

        return response()->json(['success'=>true,'message'=>'Ditambahkan ke keranjang','data'=>$item]);
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::where('user_id', auth()->id())->findOrFail($id);
        $v = Validator::make($request->all(), ['quantity' => 'required|integer|min:1']);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $item->update(['quantity' => $request->quantity]);
        return response()->json(['success'=>true,'data'=>$item]);
    }

    public function remove($id)
    {
        CartItem::where('user_id', auth()->id())->findOrFail($id)->delete();
        return response()->json(['success'=>true,'message'=>'Item dihapus dari keranjang']);
    }

    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();
        return response()->json(['success'=>true,'message'=>'Keranjang dikosongkan']);
    }
}