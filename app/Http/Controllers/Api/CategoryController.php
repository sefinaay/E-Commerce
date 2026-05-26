<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return response()->json(['success'=>true,'data'=>$categories]);
    }

    public function show($id)
    {
        $cat = Category::with('products')->findOrFail($id);
        return response()->json(['success'=>true,'data'=>$cat]);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $cat = Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'image'       => $request->image,
        ]);
        return response()->json(['success'=>true,'data'=>$cat], 201);
    }

    public function update(Request $request, $id)
    {
        $cat = Category::findOrFail($id);
        $cat->update($request->all());
        return response()->json(['success'=>true,'data'=>$cat]);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['success'=>true,'message'=>'Kategori dihapus']);
    }
}