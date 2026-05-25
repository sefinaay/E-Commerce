<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $v = Validator::make($request->all(), [
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $exists = Review::where('user_id', auth()->id())->where('product_id', $productId)->exists();
        if ($exists) return response()->json(['success'=>false,'message'=>'Anda sudah memberi ulasan'], 409);

        $review = Review::create([
            'user_id'    => auth()->id(),
            'product_id' => $productId,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return response()->json(['success'=>true,'data'=>$review->load('user')], 201);
    }

    public function index($productId)
    {
        $reviews = Review::with('user')->where('product_id', $productId)->latest()->get();
        return response()->json(['success'=>true,'data'=>$reviews]);
    }
}