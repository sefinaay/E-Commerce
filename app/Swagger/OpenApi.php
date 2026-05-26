<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "GlowMart API",
    description: "REST API E-Commerce Makeup GlowMart — JWT Auth, Role-based Access, API Gateway, Third-party Makeup API Integration",
    contact: new OA\Contact(email: "admin@glowmart.com")
)]

#[OA\Server(
    url: "http://localhost:8000",
    description: "Local Dev"
)]

#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT",
    in: "header"
)]

#[OA\Tag(name: "Auth", description: "Authentication endpoints")]
#[OA\Tag(name: "Products", description: "Produk endpoints")]
#[OA\Tag(name: "Categories", description: "Kategori endpoints")]
#[OA\Tag(name: "Cart", description: "Keranjang belanja")]
#[OA\Tag(name: "Orders", description: "Pesanan")]
#[OA\Tag(name: "Reviews", description: "Ulasan produk")]
#[OA\Tag(name: "Admin", description: "Admin only endpoints")]
#[OA\Tag(name: "External", description: "Third-party API integrations")]
#[OA\Tag(name: "Shipping", description: "Kalkulasi ongkos kirim")]
class OpenApi {}