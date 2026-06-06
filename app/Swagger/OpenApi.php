<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "GlowMart API",
    description: "REST API E-Commerce Makeup GlowMart — JWT Auth, Role-based Access, API Gateway, Makeup API Integration",
    contact: new OA\Contact(email: "admin@glowmart.com")
)]

#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local Development Server"
)]

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    in: "header",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    description: "Masukkan token JWT: Bearer {token}"
)]

#[OA\Tag(name: "Authentication", description: "Login, Register, Profile, Logout")]
#[OA\Tag(name: "Products", description: "CRUD Produk")]
#[OA\Tag(name: "Categories", description: "Kategori produk")]
#[OA\Tag(name: "Cart", description: "Keranjang belanja")]
#[OA\Tag(name: "Orders", description: "Pemesanan")]
#[OA\Tag(name: "Reviews", description: "Ulasan produk")]
#[OA\Tag(name: "Admin", description: "Endpoint khusus admin")]
#[OA\Tag(name: "External API", description: "Integrasi Makeup API pihak ketiga")]
#[OA\Tag(name: "Shipping", description: "Kalkulasi ongkos kirim")]
#[OA\Tag(name: "Journal", description: "Artikel beauty journal")]
#[OA\Tag(name: "Gateway", description: "API Gateway endpoint")]

// ============================================
// AUTH ENDPOINTS
// ============================================

#[OA\Post(
    path: "/api/auth/register",
    tags: ["Authentication"],
    summary: "Registrasi akun baru",
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "email", "password", "password_confirmation"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Sefina Ayu"),
                new OA\Property(property: "email", type: "string", example: "sefina@email.com"),
                new OA\Property(property: "phone", type: "string", example: "08123456789"),
                new OA\Property(property: "password", type: "string", example: "password123"),
                new OA\Property(property: "password_confirmation", type: "string", example: "password123")
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: "Registrasi berhasil",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                    new OA\Property(
                        property: "data",
                        type: "object",
                        properties: [
                            new OA\Property(property: "access_token", type: "string"),
                            new OA\Property(property: "token_type", type: "string", example: "bearer"),
                            new OA\Property(property: "expires_in", type: "integer", example: 3600),
                            new OA\Property(property: "user", type: "object")
                        ]
                    )
                ]
            )
        ),
        new OA\Response(response: 422, description: "Validasi gagal")
    ]
)]

#[OA\Post(
    path: "/api/auth/login",
    tags: ["Authentication"],
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
        new OA\Response(response: 401, description: "Email atau password salah"),
        new OA\Response(response: 422, description: "Validasi gagal")
    ]
)]

#[OA\Get(
    path: "/api/auth/profile",
    tags: ["Authentication"],
    summary: "Ambil profil user yang sedang login",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 401, description: "Token tidak valid")
    ]
)]

#[OA\Put(
    path: "/api/auth/profile",
    tags: ["Authentication"],
    summary: "Update profil user",
    security: [["bearerAuth" => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string", example: "Nama Baru"),
                new OA\Property(property: "phone", type: "string", example: "08999999999"),
                new OA\Property(property: "address", type: "string", example: "Jl. Baru No. 1")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Profil diperbarui"),
        new OA\Response(response: 401, description: "Unauthorized")
    ]
)]

#[OA\Post(
    path: "/api/auth/logout",
    tags: ["Authentication"],
    summary: "Logout dan invalidate token",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(response: 200, description: "Logout berhasil"),
        new OA\Response(response: 401, description: "Unauthorized")
    ]
)]

// ============================================
// PRODUCT ENDPOINTS
// ============================================

#[OA\Get(
    path: "/api/products",
    tags: ["Products"],
    summary: "Daftar semua produk aktif (public)",
    parameters: [
        new OA\Parameter(name: "search", in: "query", description: "Cari nama produk", schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "category_id", in: "query", description: "Filter by kategori", schema: new OA\Schema(type: "integer")),
        new OA\Parameter(name: "brand", in: "query", description: "Filter by brand", schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "min_price", in: "query", description: "Harga minimum", schema: new OA\Schema(type: "number")),
        new OA\Parameter(name: "max_price", in: "query", description: "Harga maksimum", schema: new OA\Schema(type: "number")),
        new OA\Parameter(name: "sort", in: "query", description: "Kolom sorting", schema: new OA\Schema(type: "string", enum: ["created_at", "price", "name"])),
        new OA\Parameter(name: "order", in: "query", description: "Arah sorting", schema: new OA\Schema(type: "string", enum: ["asc", "desc"])),
        new OA\Parameter(name: "per_page", in: "query", description: "Jumlah per halaman", schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Berhasil")
    ]
)]

#[OA\Get(
    path: "/api/products/{id}",
    tags: ["Products"],
    summary: "Detail produk beserta kategori dan review",
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 404, description: "Produk tidak ditemukan")
    ]
)]

#[OA\Post(
    path: "/api/admin/products",
    tags: ["Products"],
    summary: "Tambah produk baru (Admin only)",
    security: [["bearerAuth" => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["category_id", "name", "price", "stock"],
            properties: [
                new OA\Property(property: "category_id", type: "integer", example: 1),
                new OA\Property(property: "name", type: "string", example: "Rose Velvet Lipstick"),
                new OA\Property(property: "price", type: "number", example: 89000),
                new OA\Property(property: "stock", type: "integer", example: 50),
                new OA\Property(property: "brand", type: "string", example: "Maybelline"),
                new OA\Property(property: "description", type: "string"),
                new OA\Property(property: "image", type: "string", example: "https://example.com/img.jpg")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Produk berhasil dibuat"),
        new OA\Response(response: 403, description: "Akses ditolak - bukan admin"),
        new OA\Response(response: 422, description: "Validasi gagal")
    ]
)]

#[OA\Put(
    path: "/api/admin/products/{id}",
    tags: ["Products"],
    summary: "Update produk (Admin only)",
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "name", type: "string"),
                new OA\Property(property: "price", type: "number"),
                new OA\Property(property: "stock", type: "integer")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Produk diperbarui"),
        new OA\Response(response: 403, description: "Akses ditolak"),
        new OA\Response(response: 404, description: "Tidak ditemukan")
    ]
)]

#[OA\Delete(
    path: "/api/admin/products/{id}",
    tags: ["Products"],
    summary: "Hapus produk (Admin only)",
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Produk dihapus"),
        new OA\Response(response: 403, description: "Akses ditolak")
    ]
)]

// ============================================
// CART ENDPOINTS
// ============================================

#[OA\Get(
    path: "/api/cart",
    tags: ["Cart"],
    summary: "Lihat isi keranjang belanja",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 401, description: "Unauthorized")
    ]
)]

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
        new OA\Response(response: 200, description: "Ditambahkan ke keranjang"),
        new OA\Response(response: 400, description: "Stok tidak cukup"),
        new OA\Response(response: 401, description: "Unauthorized"),
        new OA\Response(response: 422, description: "Validasi gagal")
    ]
)]

#[OA\Put(
    path: "/api/cart/{id}",
    tags: ["Cart"],
    summary: "Update quantity item di keranjang",
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["quantity"],
            properties: [
                new OA\Property(property: "quantity", type: "integer", example: 3)
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Berhasil diupdate"),
        new OA\Response(response: 401, description: "Unauthorized")
    ]
)]

#[OA\Delete(
    path: "/api/cart/{id}",
    tags: ["Cart"],
    summary: "Hapus item dari keranjang",
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Item dihapus"),
        new OA\Response(response: 401, description: "Unauthorized")
    ]
)]

// ============================================
// ORDER ENDPOINTS
// ============================================

#[OA\Get(
    path: "/api/orders",
    tags: ["Orders"],
    summary: "Daftar pesanan milik user yang login",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 401, description: "Unauthorized")
    ]
)]

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
                new OA\Property(property: "shipping_address", type: "string", example: "Jl. Contoh No. 123"),
                new OA\Property(property: "shipping_city", type: "string", example: "Malang"),
                new OA\Property(property: "payment_method", type: "string", enum: ["transfer", "cod", "ewallet"]),
                new OA\Property(property: "shipping_cost", type: "number", example: 15000),
                new OA\Property(property: "notes", type: "string", example: "Ketuk pintu 2x")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Pesanan berhasil dibuat"),
        new OA\Response(response: 400, description: "Keranjang kosong"),
        new OA\Response(response: 401, description: "Unauthorized"),
        new OA\Response(response: 422, description: "Validasi gagal")
    ]
)]

#[OA\Post(
    path: "/api/orders/{id}/cancel",
    tags: ["Orders"],
    summary: "Batalkan pesanan",
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Pesanan dibatalkan"),
        new OA\Response(response: 400, description: "Pesanan tidak bisa dibatalkan")
    ]
)]

// ============================================
// ADMIN ENDPOINTS
// ============================================

#[OA\Get(
    path: "/api/admin/dashboard",
    tags: ["Admin"],
    summary: "Statistik dashboard admin (Admin only)",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(
            response: 200,
            description: "Berhasil",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                    new OA\Property(
                        property: "data",
                        type: "object",
                        properties: [
                            new OA\Property(property: "total_users", type: "integer"),
                            new OA\Property(property: "total_products", type: "integer"),
                            new OA\Property(property: "total_orders", type: "integer"),
                            new OA\Property(property: "total_revenue", type: "number"),
                            new OA\Property(property: "recent_orders", type: "array", items: new OA\Items(type: "object"))
                        ]
                    )
                ]
            )
        ),
        new OA\Response(response: 403, description: "Akses ditolak — bukan admin")
    ]
)]

#[OA\Get(
    path: "/api/admin/orders",
    tags: ["Admin"],
    summary: "Semua pesanan (Admin only)",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 403, description: "Akses ditolak")
    ]
)]

#[OA\Put(
    path: "/api/admin/orders/{id}/status",
    tags: ["Admin"],
    summary: "Update status pesanan (Admin only)",
    security: [["bearerAuth" => []]],
    parameters: [
        new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
    ],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["status"],
            properties: [
                new OA\Property(property: "status", type: "string", enum: ["pending", "processing", "shipped", "delivered", "cancelled"])
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: "Status diperbarui"),
        new OA\Response(response: 403, description: "Akses ditolak")
    ]
)]

#[OA\Get(
    path: "/api/admin/users",
    tags: ["Admin"],
    summary: "Semua pengguna (Admin only)",
    security: [["bearerAuth" => []]],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 403, description: "Akses ditolak")
    ]
)]

// ============================================
// EXTERNAL API & SHIPPING
// ============================================

#[OA\Get(
    path: "/api/external/makeup/search",
    tags: ["External API"],
    summary: "Cari produk dari Makeup API eksternal (makeup-api.herokuapp.com)",
    parameters: [
        new OA\Parameter(name: "brand", in: "query", description: "Filter by brand", schema: new OA\Schema(type: "string", example: "maybelline")),
        new OA\Parameter(name: "product_type", in: "query", description: "Filter by tipe produk", schema: new OA\Schema(type: "string", example: "lipstick"))
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Berhasil dari API eksternal atau fallback database",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                    new OA\Property(property: "source", type: "string", example: "local-database-fallback"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items(type: "object"))
                ]
            )
        )
    ]
)]

#[OA\Get(
    path: "/api/external/makeup/brands",
    tags: ["External API"],
    summary: "Daftar brand dari Makeup API",
    responses: [
        new OA\Response(response: 200, description: "Berhasil")
    ]
)]

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
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 422, description: "Validasi gagal")
    ]
)]

// ============================================
// GATEWAY ENDPOINT
// ============================================

#[OA\Get(
    path: "/gateway/products",
    tags: ["Gateway"],
    summary: "Akses produk melalui API Gateway",
    description: "API Gateway sebagai pintu masuk utama. Menambahkan rate limiting, logging, dan header X-Gateway.",
    parameters: [
        new OA\Parameter(name: "search", in: "query", schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "category_id", in: "query", schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Berhasil",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                    new OA\Property(property: "data", type: "object")
                ]
            )
        ),
        new OA\Response(response: 429, description: "Rate limit exceeded")
    ]
)]

// ============================================
// JOURNAL ENDPOINTS
// ============================================

#[OA\Get(
    path: "/api/journal",
    tags: ["Journal"],
    summary: "Daftar artikel journal yang published (public)",
    parameters: [
        new OA\Parameter(name: "category", in: "query", schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "search", in: "query", schema: new OA\Schema(type: "string")),
        new OA\Parameter(name: "per_page", in: "query", schema: new OA\Schema(type: "integer"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Berhasil")
    ]
)]

#[OA\Get(
    path: "/api/journal/{slug}",
    tags: ["Journal"],
    summary: "Detail artikel journal",
    parameters: [
        new OA\Parameter(name: "slug", in: "path", required: true, schema: new OA\Schema(type: "string"))
    ],
    responses: [
        new OA\Response(response: 200, description: "Berhasil"),
        new OA\Response(response: 404, description: "Artikel tidak ditemukan")
    ]
)]

#[OA\Post(
    path: "/api/admin/journals",
    tags: ["Journal"],
    summary: "Buat artikel baru (Admin only)",
    security: [["bearerAuth" => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["title", "content", "category", "status"],
            properties: [
                new OA\Property(property: "title", type: "string", example: "Glass Skin Guide"),
                new OA\Property(property: "content", type: "string", example: "<p>Content here...</p>"),
                new OA\Property(property: "excerpt", type: "string"),
                new OA\Property(property: "cover_image", type: "string"),
                new OA\Property(property: "category", type: "string", example: "Skincare"),
                new OA\Property(property: "read_time", type: "integer", example: 5),
                new OA\Property(property: "status", type: "string", enum: ["draft", "published"])
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Artikel berhasil dibuat"),
        new OA\Response(response: 403, description: "Akses ditolak")
    ]
)]

class OpenApi {}
