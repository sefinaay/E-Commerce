<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function calculate(Request $request)
    {
        $v = Validator::make($request->all(), [
            'origin'      => 'required|string',
            'destination' => 'required|string',
            'weight'      => 'required|integer|min:1',
            'courier'     => 'required|in:jne,tiki,pos',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);

        $apiKey = config('app.rajaongkir_key');

        if (!$apiKey) {
            // Demo fallback jika tidak ada API key
            $couriers = [
                'jne' => ['REG'=>15000,'YES'=>35000,'OKE'=>12000],
                'tiki'=>['REG'=>14000,'ONS'=>40000],
                'pos' =>['Kilat Khusus'=>18000,'Biasa'=>10000],
            ];
            $services = $couriers[$request->courier] ?? [];
            $results  = collect($services)->map(fn($cost, $service) => [
                'service'     => $service,
                'description' => $service,
                'cost'        => $cost + ($request->weight * 1000),
                'etd'         => rand(1,5).' hari',
            ])->values();

            return response()->json(['success'=>true,'source'=>'demo_fallback','data'=>$results]);
        }

        try {
            $response = Http::withHeaders(['key'=>$apiKey])
                ->post('https://api.rajaongkir.com/starter/cost', [
                    'origin'      => $request->origin,
                    'destination' => $request->destination,
                    'weight'      => $request->weight,
                    'courier'     => $request->courier,
                ]);

            $data = $response->json('rajaongkir.results.0.costs');
            return response()->json(['success'=>true,'source'=>'rajaongkir','data'=>$data]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'message'=>'Gagal menghitung ongkir'], 500);
        }
    }
}