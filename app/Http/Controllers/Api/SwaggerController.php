<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class SwaggerController extends Controller
{
    #[OA\Post(
        path: "/api/auth/login",
        tags: ["Auth"],
        summary: "Login dan dapatkan JWT token",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", example: "admin@glowmart.com"),
                    new OA\Property(property: "password", type: "string", example: "password")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login berhasil"),
            new OA\Response(response: 401, description: "Kredensial salah"),
            new OA\Response(response: 422, description: "Validasi gagal")
        ]
    )]
    public function login() {}

    #[OA\Post(
        path: "/api/auth/register",
        tags: ["Auth"],
        summary: "Registrasi akun baru",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Siti Aminah"),
                    new OA\Property(property: "email", type: "string", example: "siti@email.com"),
                    new OA\Property(property: "password", type: "string", example: "password123"),
                    new OA\Property(property: "password_confirmation", type: "string", example: "password123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Registrasi berhasil"),
            new OA\Response(response: 422, description: "Validasi gagal")
        ]
    )]
    public function register() {}

    #[OA\Get(
        path: "/api/auth/profile",
        tags: ["Auth"],
        summary: "Ambil profil user yang sedang login",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Berhasil"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function profile() {}

    #[OA\Get(
        path: "/api/products",
        tags: ["Products"],
        summary: "Daftar semua produk aktif (public)",
        parameters: [
            new OA\Parameter(name: "search", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "category_id", in: "query", schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "brand", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "min_price", in: "query", schema: new OA\Schema(type: "number")),
            new OA\Parameter(name: "max_price", in: "query", schema: new OA\Schema(type: "number")),
            new OA\Parameter(name: "sort", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "per_page", in: "query", schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Berhasil")
        ]
    )]
    public function products() {}

    #[OA\Post(
        path: "/api/cart/add",
        tags: ["Cart"],
        summary: "Tambah produk ke keranjang",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["product_id", "quantity"],
                properties: [
                    new OA\Property(property: "product_id", type: "integer", example: 1),
                    new OA\Property(property: "quantity", type: "integer", example: 2)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Berhasil ditambahkan"),
            new OA\Response(response: 400, description: "Stok tidak cukup"),
            new OA\Response(response: 401, description: "Unauthorized")
        ]
    )]
    public function addToCart() {}

    #[OA\Post(
        path: "/api/orders",
        tags: ["Orders"],
        summary: "Buat pesanan baru dari keranjang",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["shipping_address", "shipping_city", "payment_method"],
                properties: [
                    new OA\Property(property: "shipping_address", type: "string", example: "Jl. Contoh No. 1"),
                    new OA\Property(property: "shipping_city", type: "string", example: "Malang"),
                    new OA\Property(property: "payment_method", type: "string", enum: ["transfer", "cod", "ewallet"])
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Pesanan berhasil dibuat"),
            new OA\Response(response: 400, description: "Keranjang kosong")
        ]
    )]
    public function createOrder() {}

    #[OA\Get(
        path: "/api/external/makeup/search",
        tags: ["External"],
        summary: "Cari produk dari Makeup API",
        parameters: [
            new OA\Parameter(name: "brand", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "product_type", in: "query", schema: new OA\Schema(type: "string")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Berhasil dari API eksternal")
        ]
    )]
    public function externalSearch() {}

    #[OA\Get(
        path: "/api/admin/dashboard",
        tags: ["Admin"],
        summary: "Statistik dashboard admin",
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(response: 200, description: "Berhasil"),
            new OA\Response(response: 403, description: "Akses ditolak")
        ]
    )]
    public function adminDashboard() {}

    #[OA\Post(
        path: "/api/shipping/calculate",
        tags: ["Shipping"],
        summary: "Kalkulasi ongkos kirim",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["origin", "destination", "weight", "courier"],
                properties: [
                    new OA\Property(property: "origin", type: "string", example: "455"),
                    new OA\Property(property: "destination", type: "string", example: "455"),
                    new OA\Property(property: "weight", type: "integer", example: 500),
                    new OA\Property(property: "courier", type: "string", enum: ["jne", "tiki", "pos"])
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Berhasil")
        ]
    )]
    public function shippingCalculate() {}
}