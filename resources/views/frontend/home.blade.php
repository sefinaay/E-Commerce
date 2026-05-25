@extends('frontend.layout')

@section('title', 'GlowMart — Elevate Your Ritual')

@push('styles')
<style>
    /* ---- HERO ---- */
    .hero {
        position: relative;
        min-height: 580px;
        background: linear-gradient(135deg, #f9dde3 0%, #fce8ec 40%, #ffe4ea 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
    }
    .hero-bg-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.55;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 80px 32px;
        max-width: 560px;
    }
    .hero-overline {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--pink-deep);
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeUp 0.8s 0.2s forwards;
    }
    .hero-title {
        font-family: var(--font-serif);
        font-size: clamp(40px, 6vw, 64px);
        font-weight: 500;
        line-height: 1.1;
        color: var(--dark);
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeUp 0.8s 0.4s forwards;
    }
    .hero-title em {
        font-style: italic;
        color: var(--pink-deep);
    }
    .hero-subtitle {
        font-size: 15px;
        font-weight: 300;
        color: var(--dark-muted);
        line-height: 1.7;
        margin-bottom: 36px;
        max-width: 380px;
        opacity: 0;
        animation: fadeUp 0.8s 0.6s forwards;
    }
    .hero-actions {
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
        opacity: 0;
        animation: fadeUp 0.8s 0.8s forwards;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ---- BRAND STRIP ---- */
    .brand-strip {
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 20px 0;
        background: var(--white);
    }
    .brand-strip-inner {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 0 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 56px;
        flex-wrap: wrap;
    }
    .brand-strip-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--dark-light);
        flex-shrink: 0;
    }
    .brand-strip-names {
        display: flex;
        gap: 48px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .brand-strip-names span {
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 500;
        color: var(--dark-muted);
        letter-spacing: 0.06em;
    }
    .brand-strip-names span.featured-brand {
        font-weight: 700;
        color: var(--dark);
        text-decoration: underline;
        text-underline-offset: 4px;
        text-decoration-color: var(--pink-primary);
    }

    /* ---- SECTION HEADER ---- */
    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 36px;
    }
    .section-header .section-title { margin-bottom: 0; }

    /* ---- TRENDING / PRODUCTS GRID ---- */
    .products-section { padding: 72px 0; }
    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    /* ---- SHOP BY RITUAL ---- */
    .ritual-section {
        padding: 72px 0;
        background: var(--pink-pale);
    }
    .ritual-section .section-header {
        text-align: center;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin-bottom: 48px;
    }
    .ritual-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .ritual-card {
        position: relative;
        border-radius: var(--radius-lg);
        overflow: hidden;
        aspect-ratio: 3/4;
        cursor: pointer;
        group: true;
    }
    .ritual-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .ritual-card:hover img { transform: scale(1.08); }
    .ritual-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 24px;
    }
    .ritual-card-title {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 500;
        color: white;
        margin-bottom: 4px;
    }
    .ritual-card-sub {
        font-size: 11px;
        color: rgba(255,255,255,0.75);
        font-style: italic;
        margin-bottom: 14px;
    }
    .ritual-card-link {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0.9;
    }
    .ritual-card-link:hover { gap: 10px; opacity: 1; }

    /* ---- BESTSELLER FEATURE ---- */
    .feature-section { padding: 80px 0; }
    .feature-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }
    .feature-image {
        position: relative;
        border-radius: var(--radius-xl);
        overflow: hidden;
        aspect-ratio: 4/5;
        background: var(--pink-pale);
    }
    .feature-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .feature-badge {
        position: absolute;
        bottom: 28px;
        left: 28px;
        background: white;
        border-radius: var(--radius-md);
        padding: 14px 20px;
        box-shadow: var(--shadow-md);
    }
    .feature-badge-label {
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--pink-primary);
        margin-bottom: 4px;
    }
    .feature-badge-name {
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 500;
        color: var(--dark);
    }
    .feature-content { padding: 20px 0; }
    .feature-overline {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--pink-primary);
        margin-bottom: 16px;
    }
    .feature-title {
        font-family: var(--font-serif);
        font-size: clamp(32px, 4vw, 48px);
        font-weight: 500;
        line-height: 1.15;
        color: var(--dark);
        margin-bottom: 20px;
    }
    .feature-desc {
        font-size: 14px;
        font-weight: 300;
        color: var(--dark-muted);
        line-height: 1.8;
        margin-bottom: 32px;
        max-width: 420px;
    }
    .feature-includes {
        margin-bottom: 36px;
    }
    .feature-includes p {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--dark-light);
        margin-bottom: 14px;
    }
    .feature-include-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        color: var(--dark-muted);
    }
    .feature-include-item::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--pink-primary);
        flex-shrink: 0;
    }

    /* ---- TESTIMONIALS ---- */
    .testimonials-section { padding: 80px 0; background: var(--white); }
    .testimonials-section .section-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .testimonials-section .section-header p {
        font-size: 14px;
        color: var(--dark-muted);
        margin-top: 12px;
    }
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 48px;
    }
    .testimonial-card {
        background: var(--pink-pale);
        border-radius: var(--radius-lg);
        padding: 32px;
        transition: var(--transition);
    }
    .testimonial-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-sm); }
    .testimonial-stars { color: var(--pink-primary); font-size: 14px; margin-bottom: 16px; }
    .testimonial-text {
        font-family: var(--font-serif);
        font-size: 15px;
        font-style: italic;
        color: var(--dark);
        line-height: 1.7;
        margin-bottom: 24px;
    }
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .testimonial-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--pink-soft);
        overflow: hidden;
        flex-shrink: 0;
    }
    .testimonial-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .testimonial-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
    }
    .testimonial-label {
        font-size: 11px;
        color: var(--dark-light);
    }

    /* ---- NEWSLETTER BANNER ---- */
    .newsletter-section {
        margin: 0 32px 80px;
        border-radius: var(--radius-xl);
        background: linear-gradient(135deg, var(--pink-primary) 0%, #e8637a 100%);
        padding: 72px 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .newsletter-section::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        background: rgba(255,255,255,0.12);
        border-radius: 50%;
    }
    .newsletter-section::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: -40px;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .newsletter-section h2 {
        font-family: var(--font-serif);
        font-size: clamp(28px, 4vw, 44px);
        font-weight: 500;
        color: white;
        margin-bottom: 12px;
        position: relative;
        z-index: 1;
    }
    .newsletter-section p {
        font-size: 14px;
        color: rgba(255,255,255,0.85);
        margin-bottom: 36px;
        position: relative;
        z-index: 1;
    }
    .newsletter-form {
        display: flex;
        max-width: 460px;
        margin: 0 auto;
        gap: 0;
        border-radius: var(--radius-full);
        overflow: hidden;
        background: white;
        padding: 4px;
        position: relative;
        z-index: 1;
    }
    .newsletter-form input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 12px 20px;
        font-family: var(--font-sans);
        font-size: 13px;
        outline: none;
    }
    .newsletter-form button {
        background: var(--dark);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: var(--radius-full);
        font-family: var(--font-sans);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        transition: var(--transition);
    }
    .newsletter-form button:hover { background: var(--pink-deep); }

    @media (max-width: 1024px) {
        .products-grid { grid-template-columns: repeat(2, 1fr); }
        .ritual-grid { grid-template-columns: repeat(2, 1fr); }
        .testimonials-grid { grid-template-columns: 1fr 1fr; }
        .feature-grid { grid-template-columns: 1fr; gap: 40px; }
        .feature-image { aspect-ratio: 16/9; max-height: 420px; }
    }
    @media (max-width: 768px) {
        .products-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .ritual-grid { grid-template-columns: repeat(2, 1fr); }
        .testimonials-grid { grid-template-columns: 1fr; }
        .newsletter-section { margin: 0 16px 60px; padding: 48px 24px; }
        .brand-strip-inner { gap: 24px; }
        .brand-strip-names { gap: 24px; }
    }
</style>
@endpush

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero">
        <img
            src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1400&q=80"
            alt="GlowMart — Clean Beauty"
            class="hero-bg-img"
        >
        <div class="container">
            <div class="hero-content" style="max-width:560px; padding:80px 0;">
                <p class="hero-overline">Summer Radiance 2025</p>
                <h1 class="hero-title">Reveal Your <em>Natural Glow</em></h1>
                <p class="hero-subtitle">Experience the transformative power of clean beauty. Crafted with rare botanicals to nourish your skin from within.</p>
                <div class="hero-actions">
                    <a href="{{ route('shop') }}" class="btn-primary">Shop Now</a>
                    <a href="{{ route('discover') }}" class="btn-secondary">Discover</a>
                </div>
            </div>
        </div>
    </section>

    {{-- BRAND STRIP --}}
    <div class="brand-strip">
        <div class="brand-strip-inner">
            <span class="brand-strip-label">Curating the world's finest</span>
            <div class="brand-strip-names">
                <span>Lumina</span>
                <span>Aura</span>
                <span>Verve Beauty</span>
                <span class="featured-brand">Esthé</span>
                <span>Pure.</span>
                <span>Glacé</span>
            </div>
        </div>
    </div>

    {{-- TRENDING NOW --}}
    <section class="products-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Trending Now</h2>
                </div>
                <a href="{{ route('shop') }}" class="btn-ghost">Explore All Products <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="products-grid">
                @isset($trendingProducts)
                    @foreach($trendingProducts as $product)
                        <div class="product-card">
                            <div class="product-card-image">
                                <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400&q=80' }}" alt="{{ $product->name }}">
                                @if($product->badge ?? false)
                                    <span class="product-badge badge-{{ strtolower($product->badge) }}">{{ $product->badge }}</span>
                                @endif
                                <a href="#" class="product-wishlist-btn"><i class="far fa-heart"></i></a>
                            </div>
                            <div class="product-card-body">
                                <p class="product-brand">{{ $product->brand ?? 'GlowMart' }}</p>
                                <a href="{{ route('product', $product->slug) }}" class="product-name">{{ $product->name }}</a>
                                <div class="product-stars">
                                    ★★★★★ <span>({{ $product->reviews_count ?? 0 }})</span>
                                </div>
                                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Demo products --}}
                    @php
                        $demos = [
                            ['name'=>'Glow-Infusion Elixir','brand'=>'Lumina Botanics','price'=>'48.00','badge'=>'new','img'=>'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400&q=80','reviews'=>'(124)'],
                            ['name'=>'Rose Quartz Soufflé','brand'=>'Aura Skincare','price'=>'62.00','badge'=>'bestseller','img'=>'https://images.unsplash.com/photo-1556228578-626d20b83545?w=400&q=80','reviews'=>'(86)'],
                            ['name'=>'Silk Peptide Cleanser','brand'=>'Pure Elements','price'=>'35.00','badge'=>null,'img'=>'https://images.unsplash.com/photo-1570194065650-d99fb4d72a9a?w=400&q=80','reviews'=>'(210)'],
                            ['name'=>'Morning Dew Eau de Parfum','brand'=>'Glacé Fragrance','price'=>'120.00','badge'=>'limited','img'=>'https://images.unsplash.com/photo-1541643600914-78b084683702?w=400&q=80','reviews'=>'(56)'],
                        ];
                    @endphp
                    @foreach($demos as $p)
                        <div class="product-card">
                            <div class="product-card-image">
                                <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}">
                                @if($p['badge'])
                                    <span class="product-badge badge-{{ $p['badge'] }}">{{ $p['badge'] }}</span>
                                @endif
                                <a href="#" class="product-wishlist-btn"><i class="far fa-heart"></i></a>
                            </div>
                            <div class="product-card-body">
                                <p class="product-brand">{{ $p['brand'] }}</p>
                                <a href="{{ route('product', 'demo') }}" class="product-name">{{ $p['name'] }}</a>
                                <div class="product-stars">★★★★★ <span>{{ $p['reviews'] }}</span></div>
                                <p class="product-price">${{ $p['price'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </section>

    {{-- SHOP BY RITUAL --}}
    <section class="ritual-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Shop by Ritual</h2>
            </div>
            <div class="ritual-grid">
                <a href="{{ route('shop', ['category' => 'skincare']) }}" class="ritual-card" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&q=80" alt="Skincare">
                    <div class="ritual-card-overlay">
                        <h3 class="ritual-card-title">Skincare</h3>
                        <p class="ritual-card-sub">Nourish your canvas</p>
                        <span class="ritual-card-link">Shop Collection <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="{{ route('shop', ['category' => 'makeup']) }}" class="ritual-card" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1588514912908-c4378f61be62?w=600&q=80" alt="Makeup">
                    <div class="ritual-card-overlay">
                        <h3 class="ritual-card-title">Makeup</h3>
                        <p class="ritual-card-sub">Artistry defined</p>
                        <span class="ritual-card-link">Shop Collection <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="{{ route('shop', ['category' => 'fragrance']) }}" class="ritual-card" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=600&q=80" alt="Fragrance">
                    <div class="ritual-card-overlay">
                        <h3 class="ritual-card-title">Fragrance</h3>
                        <p class="ritual-card-sub">Your scent signature</p>
                        <span class="ritual-card-link">Shop Collection <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="{{ route('shop', ['category' => 'haircare']) }}" class="ritual-card" style="text-decoration:none;">
                    <img src="https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388?w=600&q=80" alt="Haircare">
                    <div class="ritual-card-overlay">
                        <h3 class="ritual-card-title">Haircare</h3>
                        <p class="ritual-card-sub">The ultimate ritual</p>
                        <span class="ritual-card-link">Shop Collection <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- BESTSELLER FEATURE --}}
    <section class="feature-section">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1619451334792-150fd785ee74?w=700&q=80" alt="Complete Glow Kit">
                    <div class="feature-badge">
                        <p class="feature-badge-label">Best Seller 2024</p>
                        <p class="feature-badge-name">Complete Glow Kit</p>
                    </div>
                </div>
                <div class="feature-content">
                    <p class="feature-overline">The Glow Standard</p>
                    <h2 class="feature-title">The Best-Selling Ritual For All Skin Types</h2>
                    <p class="feature-desc">Our award-winning Glow Kit has helped over 50,000 women achieve their dream skin. Dermatologist-tested, vegan, and cruelty-free.</p>
                    <div class="feature-includes">
                        <p>Includes:</p>
                        <div class="feature-include-item">Silk Peptide Cleanser (Full Size)</div>
                        <div class="feature-include-item">Radiance Nectar Serum (Full Size)</div>
                        <div class="feature-include-item">Rose Quartz Soufflé (Travel Size)</div>
                    </div>
                    <a href="{{ route('shop') }}" class="btn-primary">Shop Best Sellers</a>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Real Results, Real Glow</h2>
                    <p>Join thousands of women who have transformed their skincare journey with GlowMart.</p>
                </div>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"I've struggled with dull skin for years, but the Lumina Serum changed everything. My skin has never looked more radiant and healthy. Truly worth every penny!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80" alt="Sarah Jenkins">
                        </div>
                        <div>
                            <p class="testimonial-name">Sarah Jenkins</p>
                            <p class="testimonial-label">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"The Morning Dew Fragrance is my signature scent. It's light, fresh, and stays all day. I get compliments everywhere I go! Shipping was also super fast."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=80&q=80" alt="Elena Rodriguez">
                        </div>
                        <div>
                            <p class="testimonial-name">Elena Rodriguez</p>
                            <p class="testimonial-label">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"Customer service is absolutely elite. They helped me pick the perfect shade for my foundation, and it matches perfectly. Forever a GlowMart girl!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=80&q=80" alt="Maya Thompson">
                        </div>
                        <div>
                            <p class="testimonial-name">Maya Thompson</p>
                            <p class="testimonial-label">Verified Buyer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- NEWSLETTER --}}
    <div class="newsletter-section">
        <h2>Join the Glow Club</h2>
        <p>Be the first to access new drops, secret sales, and beauty tips from our editors.<br>Get 15% off your first order.</p>
        <form class="newsletter-form" action="#" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Enter your email">
            <button type="submit">Subscribe</button>
        </form>
    </div>

@endsection