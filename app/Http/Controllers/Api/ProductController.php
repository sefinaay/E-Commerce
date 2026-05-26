<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with('category')
            ->withAvg('reviews','rating');

        if ($request->category_id) $q->where('category_id', $request->category_id);
        if ($request->brand)       $q->where('brand', 'like', "%{$request->brand}%");
        if ($request->search)      $q->where('name', 'like', "%{$request->search}%");
        if ($request->min_price)   $q->where('price', '>=', $request->min_price);
        if ($request->max_price)   $q->where('price', '<=', $request->max_price);
        $q->where('status', 'active');

        $sort  = $request->sort ?? 'created_at';
        $order = $request->order ?? 'desc';
        $q->orderBy($sort, $order);

        $products = $q->paginate($request->per_page ?? 12);
        return response()->json(['success'=>true,'data'=>$products]);
    }

    public function show($id)
    {
        $product = Product::with(['category','reviews.user'])->withAvg('reviews','rating')->findOrFail($id);
        return response()->json(['success'=>true,'data'=>$product]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:200',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'brand'       => 'nullable|string',
            'image'       => 'nullable|url',
        ]);
        if ($v->fails()) return $this->fail($v->errors());

        $product = Product::create(array_merge($request->all(), [
            'slug' => Str::slug($request->name).'-'.uniqid(),
        ]));

        return response()->json(['success'=>true,'message'=>'Produk berhasil dibuat','data'=>$product], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $v = Validator::make($request->all(), [
            'category_id' => 'sometimes|exists:categories,id',
            'name'        => 'sometimes|string|max:200',
            'price'       => 'sometimes|numeric|min:0',
            'stock'       => 'sometimes|integer|min:0',
        ]);
        if ($v->fails()) return $this->fail($v->errors());

        if ($request->name) $request->merge(['slug' => Str::slug($request->name).'-'.uniqid()]);
        $product->update($request->all());
        return response()->json(['success'=>true,'message'=>'Produk diperbarui','data'=>$product]);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['success'=>true,'message'=>'Produk dihapus']);
    }

    private function fail($errors)
    {
        return response()->json(['success'=>false,'message'=>'Validasi gagal','errors'=>$errors], 422);
    }
}