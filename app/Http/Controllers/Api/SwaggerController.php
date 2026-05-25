<?php
namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="GlowMart API",
 *     description="REST API E-Commerce Makeup GlowMart — JWT Auth, Role-based Access, API Gateway, Third-party Makeup API Integration",
 *     @OA\Contact(email="admin@glowmart.com")
 * )
 * @OA\Server(url="http://localhost:8000", description="Local Dev")
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     in="header", type="http", scheme="bearer", bearerFormat="JWT"
 * )
 *
 * @OA\Tag(name="Auth", description="Authentication endpoints")
 * @OA\Tag(name="Products", description="Produk endpoints")
 * @OA\Tag(name="Categories", description="Kategori endpoints")
 * @OA\Tag(name="Cart", description="Keranjang belanja")
 * @OA\Tag(name="Orders", description="Pesanan")
 * @OA\Tag(name="Reviews", description="Ulasan produk")
 * @OA\Tag(name="Admin", description="Admin only endpoints")
 * @OA\Tag(name="External", description="Third-party API integrations")
 * @OA\Tag(name="Shipping", description="Kalkulasi ongkos kirim")
 *
 * @OA\Post(
 *     path="/api/auth/login",
 *     tags={"Auth"},
 *     summary="Login dan dapatkan JWT token",
 *     @OA\RequestBody(required=true,
 *         @OA\JsonContent(required={"email","password"},
 *             @OA\Property(property="email",type="string",example="admin@glowmart.com"),
 *             @OA\Property(property="password",type="string",example="password")
 *         )
 *     ),
 *     @OA\Response(response=200,description="Login berhasil",
 *         @OA\JsonContent(@OA\Property(property="success",type="boolean",example=true),
 *             @OA\Property(property="data",type="object",
 *                 @OA\Property(property="access_token",type="string"),
 *                 @OA\Property(property="token_type",type="string",example="bearer"),
 *                 @OA\Property(property="expires_in",type="integer"),
 *                 @OA\Property(property="user",type="object")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401,description="Kredensial salah"),
 *     @OA\Response(response=422,description="Validasi gagal")
 * )
 *
 * @OA\Post(
 *     path="/api/auth/register",
 *     tags={"Auth"},
 *     summary="Registrasi akun baru",
 *     @OA\RequestBody(required=true,
 *         @OA\JsonContent(required={"name","email","password","password_confirmation"},
 *             @OA\Property(property="name",type="string",example="Siti Aminah"),
 *             @OA\Property(property="email",type="string",example="siti@email.com"),
 *             @OA\Property(property="password",type="string",example="password123"),
 *             @OA\Property(property="password_confirmation",type="string",example="password123")
 *         )
 *     ),
 *     @OA\Response(response=201,description="Registrasi berhasil"),
 *     @OA\Response(response=422,description="Validasi gagal")
 * )
 *
 * @OA\Get(
 *     path="/api/auth/profile",
 *     tags={"Auth"},
 *     summary="Ambil profil user yang sedang login",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=200,description="Berhasil"),
 *     @OA\Response(response=401,description="Unauthorized")
 * )
 *
 * @OA\Get(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Daftar semua produk aktif (public)",
 *     @OA\Parameter(name="search",in="query",@OA\Schema(type="string")),
 *     @OA\Parameter(name="category_id",in="query",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="brand",in="query",@OA\Schema(type="string")),
 *     @OA\Parameter(name="min_price",in="query",@OA\Schema(type="number")),
 *     @OA\Parameter(name="max_price",in="query",@OA\Schema(type="number")),
 *     @OA\Parameter(name="sort",in="query",@OA\Schema(type="string",enum={"created_at","price","name"})),
 *     @OA\Parameter(name="per_page",in="query",@OA\Schema(type="integer")),
 *     @OA\Response(response=200,description="Berhasil")
 * )
 *
 * @OA\Post(
 *     path="/api/cart/add",
 *     tags={"Cart"},
 *     summary="Tambah produk ke keranjang",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *         @OA\JsonContent(required={"product_id","quantity"},
 *             @OA\Property(property="product_id",type="integer",example=1),
 *             @OA\Property(property="quantity",type="integer",example=2)
 *         )
 *     ),
 *     @OA\Response(response=200,description="Berhasil ditambahkan"),
 *     @OA\Response(response=400,description="Stok tidak cukup"),
 *     @OA\Response(response=401,description="Unauthorized")
 * )
 *
 * @OA\Post(
 *     path="/api/orders",
 *     tags={"Orders"},
 *     summary="Buat pesanan baru dari keranjang",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *         @OA\JsonContent(required={"shipping_address","shipping_city","payment_method"},
 *             @OA\Property(property="shipping_address",type="string",example="Jl. Contoh No. 1"),
 *             @OA\Property(property="shipping_city",type="string",example="Malang"),
 *             @OA\Property(property="payment_method",type="string",enum={"transfer","cod","ewallet"})
 *         )
 *     ),
 *     @OA\Response(response=201,description="Pesanan berhasil dibuat"),
 *     @OA\Response(response=400,description="Keranjang kosong")
 * )
 *
 * @OA\Get(
 *     path="/api/external/makeup/search",
 *     tags={"External"},
 *     summary="Cari produk dari Makeup API (makeup-api.herokuapp.com)",
 *     @OA\Parameter(name="brand",in="query",@OA\Schema(type="string",example="maybelline")),
 *     @OA\Parameter(name="product_type",in="query",@OA\Schema(type="string",example="lipstick")),
 *     @OA\Response(response=200,description="Berhasil dari API eksternal")
 * )
 *
 * @OA\Get(
 *     path="/api/admin/dashboard",
 *     tags={"Admin"},
 *     summary="Statistik dashboard admin (admin only)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(response=200,description="Berhasil"),
 *     @OA\Response(response=403,description="Akses ditolak — bukan admin")
 * )
 *
 * @OA\Post(
 *     path="/api/shipping/calculate",
 *     tags={"Shipping"},
 *     summary="Kalkulasi ongkos kirim",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *         @OA\JsonContent(required={"origin","destination","weight","courier"},
 *             @OA\Property(property="origin",type="string",example="455"),
 *             @OA\Property(property="destination",type="string",example="455"),
 *             @OA\Property(property="weight",type="integer",example=500),
 *             @OA\Property(property="courier",type="string",enum={"jne","tiki","pos"})
 *         )
 *     ),
 *     @OA\Response(response=200,description="Berhasil")
 * )
 */
class SwaggerController extends \App\Http\Controllers\Controller {}