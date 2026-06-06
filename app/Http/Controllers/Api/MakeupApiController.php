<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MakeupApiController extends Controller
{
    public function search(Request $request)
    {
        $cacheKey = 'makeup_search_' . md5(json_encode($request->all()));

        $data = Cache::remember($cacheKey, 300, function () use ($request) {

            // ── Coba API dulu ──
            try {
                $response = Http::timeout(4)->get(
                    'https://makeup-api.herokuapp.com/api/v1/products.json',
                    array_filter([
                        'brand'        => $request->brand,
                        'product_type' => $request->product_type,
                    ])
                );

                if ($response->successful() && !empty($response->json())) {
                    return collect($response->json())->take(20)->map(fn($p) => [
                        'id'          => $p['id'],
                        'brand'       => $p['brand'] ?? '',
                        'name'        => $p['name'] ?? '',
                        'price'       => $p['price'] ?? '0',
                        'image_link'  => $p['image_link'] ?? null,
                        'description' => $p['description'] ?? '',
                        'category'    => $p['product_type'] ?? '',
                        'rating'      => $p['rating'] ?? null,
                        'source_url'  => $p['product_link'] ?? '#',
                        'source'      => 'makeup-api.herokuapp.com',
                    ])->values()->toArray();
                }
            } catch (\Exception $e) {
                // API down — lanjut ke fallback
            }

            // ── Fallback: database lokal ──
            $query = Product::with('category')->where('status', 'active');

            if ($request->brand) {
                $query->where('brand', 'like', "%{$request->brand}%");
            }
            if ($request->product_type) {
                $query->whereHas('category', fn($q) =>
                    $q->where('slug', $request->product_type)
                      ->orWhere('name', 'like', "%{$request->product_type}%")
                );
            }

            return $query->inRandomOrder()->take(20)->get()->map(fn($p) => [
                'id'          => $p->id,
                'brand'       => $p->brand ?? 'GlowMart',
                'name'        => $p->name,
                'price'       => number_format($p->price / 15500, 2),
                'image_link'  => $p->image,
                'description' => $p->description,
                'category'    => $p->category?->name ?? '',
                'rating'      => round(rand(38, 50) / 10, 1),
                'source_url'  => url('/product/' . $p->id),
                'source'      => 'local-database',
            ])->values()->toArray();
        });

        return response()->json([
            'success' => true,
            'source'  => collect($data)->first()['source'] ?? 'local-database',
            'data'    => $data,
        ]);
    }

    public function brands()
    {
        $brands = Cache::remember('makeup_brands', 3600, function () {

            // Coba API dulu
            try {
                $response = Http::timeout(4)->get(
                    'https://makeup-api.herokuapp.com/api/v1/products.json'
                );
                if ($response->successful() && !empty($response->json())) {
                    return collect($response->json())
                        ->pluck('brand')
                        ->unique()
                        ->filter()
                        ->values();
                }
            } catch (\Exception $e) {}

            // Fallback: brand dari database
            return Product::whereNotNull('brand')
                ->where('status', 'active')
                ->distinct()
                ->pluck('brand')
                ->filter()
                ->values();
        });

        return response()->json(['success' => true, 'data' => $brands]);
    }

    public function importToLocal(Request $request)
    {
        if (!auth()->user()?->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        return response()->json([
            'success' => false,
            'message' => 'Makeup API sedang tidak tersedia. Data produk sudah ada di database lokal.',
        ], 503);
    }
}
