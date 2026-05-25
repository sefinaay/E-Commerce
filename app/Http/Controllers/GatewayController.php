<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GatewayController extends Controller
{
    private array $routeMap = [
        'GET:products'         => 'api.products.index',
        'GET:products/{id}'    => 'api.products.show',
        'GET:categories'       => 'api.categories.index',
        'POST:auth/login'      => 'api.auth.login',
        'POST:auth/register'   => 'api.auth.register',
        'GET:cart'             => 'api.cart.index',
        'POST:orders'          => 'api.orders.store',
    ];

    public function handle(Request $request, $path = '')
    {
        // Rate limiting check
        $ip  = $request->ip();
        $key = 'gateway_'.$ip;
        $hits = \Cache::get($key, 0);

        if ($hits > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Rate limit exceeded. Coba lagi nanti.',
                'gateway' => 'GlowMart API Gateway v1.0',
            ], 429);
        }

        \Cache::put($key, $hits + 1, 60);

        // Log request
        \Log::info('Gateway Request', [
            'ip'     => $ip,
            'method' => $request->method(),
            'path'   => $path,
            'user'   => auth()->id(),
        ]);

        // Forward request (proxy sederhana dalam Laravel)
        $response = app()->handle(
            Request::create(
                '/api/'.$path,
                $request->method(),
                $request->all(),
                $request->cookies->all(),
                [],
                $request->server->all(),
                $request->getContent()
            )
        );

        // Tambah header gateway
        $response->headers->set('X-Gateway', 'GlowMart-Gateway-v1');
        $response->headers->set('X-Request-Id', uniqid('gw-'));
        $response->headers->set('X-RateLimit-Remaining', 100 - $hits);

        return $response;
    }
}