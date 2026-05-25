<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MakeupApiController extends Controller
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.makeup_api_url', 'http://makeup-api.herokuapp.com/api/v1');
    }

    public function search(Request $request)
    {
        $cacheKey = 'makeup_'.md5(json_encode($request->all()));

        $data = Cache::remember($cacheKey, 300, function () use ($request) {
            $params = array_filter([
                'brand'        => $request->brand,
                'product_type' => $request->product_type,
                'product_tags' => $request->product_tags,
            ]);

            $response = Http::timeout(10)->get($this->baseUrl.'/products.json', $params);

            if ($response->failed()) {
                throw new \Exception('Makeup API tidak tersedia');
            }
            return $response->json();
        });

        $products = collect($data)->take(20)->map(fn($p) => [
            'id'          => $p['id'],
            'brand'       => $p['brand'],
            'name'        => $p['name'],
            'price'       => $p['price'],
            'image_link'  => $p['image_link'],
            'description' => $p['description'],
            'category'    => $p['product_type'],
            'rating'      => $p['rating'],
            'source_url'  => $p['product_link'],
        ]);

        return response()->json(['success'=>true,'source'=>'makeup-api.herokuapp.com','data'=>$products]);
    }

    public function brands()
    {
        $brands = Cache::remember('makeup_brands', 3600, function () {
            $r = Http::timeout(10)->get($this->baseUrl.'/products.json');
            return collect($r->json())->pluck('brand')->unique()->filter()->values();
        });
        return response()->json(['success'=>true,'data'=>$brands]);
    }

    public function importToLocal(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return response()->json(['success'=>false,'message'=>'Akses ditolak'], 403);
        }

        $v = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'brand'       => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $response = Http::timeout(10)->get($this->baseUrl.'/products.json', ['brand' => $request->brand]);
        $items = collect($response->json())->take(10);

        $imported = [];
        foreach ($items as $item) {
            $product = \App\Models\Product::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['name']).'-'.$item['id']],
                [
                    'category_id' => $request->category_id,
                    'name'        => $item['name'],
                    'description' => $item['description'] ?? '-',
                    'price'       => (float)($item['price'] ?? 0) * 15000,
                    'stock'       => rand(10, 100),
                    'image'       => $item['image_link'],
                    'brand'       => $item['brand'],
                    'status'      => 'active',
                ]
            );
            $imported[] = $product;
        }

        return response()->json(['success'=>true,'message'=>count($imported).' produk berhasil diimport','data'=>$imported]);
    }
}