<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Journal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@glowmart.com'],
            [
                'name'     => 'Admin GlowMart',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'phone'    => '08100000001',
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer@glowmart.com'],
            [
                'name'     => 'Customer Demo',
                'password' => Hash::make('password'),
                'role'     => 'customer',
                'phone'    => '08200000002',
            ]
        );

        // ── Categories ────────────────────────────────────
        $categoryMap = [
            'lipstick'    => 'Lipstick',
            'foundation'  => 'Foundation',
            'eyeshadow'   => 'Eyeshadow',
            'mascara'     => 'Mascara',
            'blush'       => 'Blush',
            'bronzer'     => 'Bronzer',
            'eyeliner'    => 'Eyeliner',
            'lip_liner'   => 'Lip Liner',
            'nail_polish' => 'Nail Polish',
        ];

        foreach ($categoryMap as $slug => $name) {
            Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $name,
                    'description' => "Koleksi $name terbaik pilihan GlowMart",
                ]
            );
        }

        $this->command->info('✅ Categories created');

        // ── Products dari Makeup API ───────────────────────
        $this->seedFromMakeupApi($categoryMap);

        // ── Journal Articles ──────────────────────────────
        $this->seedJournals($admin);  // ← pakai $admin yang sudah ada di atas
    }

    // ── Seed Products ─────────────────────────────────────
    private function seedFromMakeupApi(array $categoryMap): void
    {
        $baseUrl = 'https://makeup-api.herokuapp.com/api/v1/products.json';

        foreach ($categoryMap as $type => $categoryName) {
            $this->command->info("Fetching $categoryName from Makeup API...");

            try {
                $response = Http::timeout(60)->retry(2, 1000)->get($baseUrl, [
                    'product_type' => $type,
                ]);

                if ($response->failed()) {
                    $this->command->warn("  ⚠ Failed to fetch $type");
                    continue;
                }

                $products = $response->json();

                if (empty($products)) {
                    $this->command->warn("  ⚠ No products found for $type");
                    continue;
                }

                $category = Category::where('slug', $type)->first();
                if (!$category) continue;

                $count = 0;
                foreach ($products as $item) {
                    if (empty($item['name']) || empty($item['price'])) continue;

                    $exists = Product::where('name', $item['name'])->exists();
                    if ($exists) continue;

                    $priceUsd = (float) ($item['price'] ?? 0);
                    $priceIdr = $priceUsd > 0
                        ? round($priceUsd * 15500)
                        : rand(50000, 350000);

                    // Potong URL image kalau terlalu panjang
                    $image = $item['image_link'] ?? null;
                    if ($image && strlen($image) > 500) $image = null;

                    Product::create([
                        'category_id' => $category->id,
                        'name'        => $item['name'],
                        'slug'        => Str::slug($item['name']) . '-' . $item['id'],
                        'description' => $item['description'] ?? "Produk {$categoryName} berkualitas tinggi dari {$item['brand']}.",
                        'price'       => $priceIdr,
                        'stock'       => rand(10, 100),
                        'image'       => $image,
                        'brand'       => $item['brand'] ?? null,
                        'status'      => 'active',
                        'tags'        => !empty($item['tag_list']) ? json_encode($item['tag_list']) : null,
                    ]);

                    $count++;
                }

                $this->command->info("  ✅ $count products imported for $categoryName");

            } catch (\Exception $e) {
                $this->command->error("  ❌ Error fetching $type: " . $e->getMessage());
            }
        }

        $this->command->info('🎉 Total products: ' . Product::count());
    }

    // ── Seed Journal Articles ─────────────────────────────
    private function seedJournals(User $admin): void
    {
        $articles = [
            [
                'title'       => 'The Ultimate Guide to Glass Skin',
                'excerpt'     => 'Discover the 5-step Korean skincare routine that gives you that coveted dewy, luminous complexion.',
                'content'     => '<p>Glass skin is the beauty trend that took over social media and never left.</p><h2>What is Glass Skin?</h2><p>Glass skin refers to a complexion that is extremely smooth, poreless, and luminous.</p><h2>Step 1: Double Cleanse</h2><p>Start with an oil cleanser to remove makeup and sunscreen, followed by a gentle foam cleanser.</p><h2>Step 2: Exfoliate</h2><p>Use a gentle chemical exfoliant 2-3 times per week to remove dead skin cells.</p><h2>Step 3: Toner</h2><p>Apply a hydrating toner to balance your skin pH and prep it for the next steps.</p><blockquote>The secret to glass skin is consistency and layering hydration.</blockquote><h2>Step 4: Essence and Serum</h2><p>Layer a hydrating essence followed by a brightening serum packed with Vitamin C or niacinamide.</p><h2>Step 5: Moisturize and Protect</h2><p>Lock everything in with a rich moisturizer and finish with SPF during the day.</p>',
                'category'    => 'Skincare',
                'cover_image' => null,
                'read_time'   => 6,
                'status'      => 'published',
            ],
            [
                'title'       => '10 Lipstick Shades Every Woman Should Own',
                'excerpt'     => 'From your perfect everyday nude to a bold evening red — these are the shades that complete any makeup look.',
                'content'     => '<p>A great lipstick can transform your entire look in seconds.</p><h2>The Essential Nudes</h2><p>Every woman needs at least two nude shades for a fresh daytime look.</p><h2>The Classic Red</h2><p>No collection is complete without a classic red lipstick.</p><blockquote>Red lipstick is not just a color, it is an attitude.</blockquote><h2>The Berry</h2><p>A deep berry shade bridges the gap between your everyday nude and a dramatic evening look.</p><h2>The Pink</h2><p>A bright pink lipstick is the fastest way to look put-together with minimal effort.</p>',
                'category'    => 'Makeup',
                'cover_image' => null,
                'read_time'   => 5,
                'status'      => 'published',
            ],
            [
                'title'       => 'How to Build Your Perfect Fragrance Wardrobe',
                'excerpt'     => 'Just like clothing, your fragrance should change with your mood, the season, and the occasion.',
                'content'     => '<p>Fragrance is the invisible accessory that completes your personal style.</p><h2>Understanding Fragrance Families</h2><p>Fragrances fall into several families: floral, oriental, woody, and fresh.</p><h2>Your Signature Daytime Scent</h2><p>For daytime wear, opt for lighter, fresher fragrances with citrus and light floral notes.</p><h2>Evening Glamour</h2><p>Evening calls for something richer. Oriental fragrances with amber, musk, and vanilla create a memorable impression.</p><blockquote>Perfume is the art that makes memory speak.</blockquote>',
                'category'    => 'Fragrance',
                'cover_image' => null,
                'read_time'   => 7,
                'status'      => 'published',
            ],
            [
                'title'       => 'Morning Skincare Rituals That Actually Work',
                'excerpt'     => 'Start your day right with these evidence-based morning skincare steps for healthy, glowing skin.',
                'content'     => '<p>Your morning skincare routine sets the tone for your skin for the entire day.</p><h2>Cleanse Gently</h2><p>In the morning, your skin does not need a heavy cleanse. A gentle water rinse or mild cleanser is enough.</p><h2>Vitamin C Serum</h2><p>Apply a Vitamin C serum every morning to protect against free radical damage and brighten your complexion.</p><h2>Moisturize</h2><p>Even oily skin needs moisture. Choose a lightweight, non-comedogenic moisturizer.</p><h2>Never Skip SPF</h2><p>Sunscreen is the single most effective anti-aging product you can use. Never skip it.</p>',
                'category'    => 'Beauty Tips',
                'cover_image' => null,
                'read_time'   => 4,
                'status'      => 'published',
            ],
            [
                'title'       => 'Clean Beauty: What It Really Means',
                'excerpt'     => 'The clean beauty movement has taken the industry by storm — but what does it actually mean for your routine?',
                'content'     => '<p>Clean beauty has become one of the most talked-about topics in the beauty industry.</p><h2>What Clean Really Means</h2><p>Clean beauty refers to products formulated without ingredients that are potentially harmful to your health or the environment.</p><h2>Ingredients to Watch</h2><p>Common ingredients that clean beauty advocates avoid include parabens, sulfates, and synthetic fragrances.</p><blockquote>Clean beauty is not about fear. It is about making informed choices for your skin and the planet.</blockquote><h2>GlowMart Commitment</h2><p>At GlowMart, we carefully vet every product in our collection for transparency and sustainability.</p>',
                'category'    => 'Lifestyle',
                'cover_image' => null,
                'read_time'   => 5,
                'status'      => 'published',
            ],
            [
                'title'       => 'The Science Behind Hyaluronic Acid',
                'excerpt'     => 'Why is hyaluronic acid in almost every skincare product? We break down the science in simple terms.',
                'content'     => '<p>If there is one ingredient that appears in nearly every modern skincare product, it is hyaluronic acid.</p><h2>What Is Hyaluronic Acid?</h2><p>Hyaluronic acid is a naturally occurring substance in your body found in your skin, connective tissue, and eyes. Its main function is to retain water.</p><h2>Why It Works</h2><p>One gram of hyaluronic acid can hold up to six liters of water, making it a powerhouse hydrating ingredient.</p><h2>How to Use It</h2><p>Apply HA to damp skin and follow immediately with a moisturizer to seal the hydration in.</p>',
                'category'    => 'Skincare',
                'cover_image' => null,
                'read_time'   => 6,
                'status'      => 'published',
            ],
        ];

        foreach ($articles as $article) {
            // Cek duplikat supaya tidak error kalau dijalankan ulang
            $exists = Journal::where('title', $article['title'])->exists();
            if ($exists) continue;

            Journal::create(array_merge($article, [
                'user_id'      => $admin->id,
                'slug'         => Str::slug($article['title']) . '-' . uniqid(),
                'published_at' => now()->subDays(rand(1, 60)),
            ]));
        }

        $this->command->info('✅ Journal articles seeded: ' . Journal::count() . ' articles');
    }
}
