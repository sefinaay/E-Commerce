@extends('frontend.layout')
@section('title', 'GlowMart - Beauty Store')
@section('head')
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
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-scroll-hint {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            color: var(--warm-gray);
            font-size: .7rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            animation: bobble 2s ease-in-out infinite;
        }

        @keyframes bobble {

            0%,
            100% {
                transform: translateX(-50%) translateY(0);
            }

            50% {
                transform: translateX(-50%) translateY(6px);
            }
        }

        .hero-scroll-hint svg {
            opacity: .5;
        }

        /* ─── Brand Strip ──────────────────────────────────── */
        .brands-strip {
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            background: var(--white);
            padding: 1.1rem 3rem;
        }

        .brands-inner {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-label {
            font-size: .68rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--warm-gray);
            white-space: nowrap;
            margin-right: 2rem;
        }

        .brand-list {
            display: flex;
            align-items: center;
            gap: 3rem;
            flex: 1;
            justify-content: space-around;
        }

        .brand-item {
            font-family: 'Playfair Display', serif;
            font-size: .95rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #B0A8AE;
            font-weight: 400;
            transition: color .2s;
            cursor: default;
        }

        .brand-item:hover {
            color: var(--charcoal);
        }

        /* ─── Trending Products ─────────────────────────────── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.75rem;
        }

        .product-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 20px;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            cursor: pointer;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(200, 80, 106, .1);
        }

        .product-card-img {
            position: relative;
            overflow: hidden;
            height: 280px;
            background: var(--soft-bg);
        }

        .product-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }

        .product-card:hover .product-card-img img {
            transform: scale(1.04);
        }

        .product-badge {
            position: absolute;
            top: .75rem;
            left: .75rem;
            font-size: .65rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 600;
            padding: .25rem .65rem;
            border-radius: 10px;
        }

        .badge-trending {
            background: var(--charcoal);
            color: white;
        }

        .badge-new {
            background: var(--rose);
            color: white;
        }

        .badge-limited {
            background: var(--gold);
            color: white;
        }

        .product-wishlist {
            position: absolute;
            top: .75rem;
            right: .75rem;
            width: 32px;
            height: 32px;
            background: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity .2s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .product-card:hover .product-wishlist {
            opacity: 1;
        }

        .product-info {
            padding: 1rem 1.1rem 1.25rem;
        }

        .product-brand-tag {
            font-size: .68rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 500;
            margin-bottom: .3rem;
        }

        .product-name {
            font-size: .92rem;
            font-weight: 500;
            color: var(--charcoal);
            margin-bottom: .4rem;
            line-height: 1.4;
        }

        .product-price {
            color: var(--charcoal);
            font-weight: 600;
            font-size: .92rem;
        }

        .product-stars {
            font-size: .75rem;
            color: #E8A800;
            margin-top: .3rem;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        .product-stars span {
            color: var(--warm-gray);
            font-size: .72rem;
        }

        /* ─── Shop by Ritual ────────────────────────────────── */
        .ritual-section {
            background: var(--white);
        }

        .ritual-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        .ritual-card {
            position: relative;
            overflow: hidden;
            border-radius: 4px;
            height: 360px;
            cursor: pointer;
            border-radius: 15px;
        }

        .ritual-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s;
        }

        .ritual-card:hover img {
            transform: scale(1.06);
        }

        .ritual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(20, 10, 12, .72) 100%);
            transition: background .3s;
        }

        .ritual-card:hover .ritual-overlay {
            background: linear-gradient(180deg, transparent 20%, rgba(20, 10, 12, .82) 100%);
        }

        .ritual-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem 1.25rem;
            color: white;
        }

        .ritual-category {
            font-size: .65rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .65);
            margin-bottom: .4rem;
        }

        .ritual-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 400;
            margin-bottom: .25rem;
        }

        .ritual-desc {
            font-size: .75rem;
            color: rgba(255, 255, 255, .6);
            margin-bottom: 1rem;
        }

        .ritual-link {
            font-size: .68rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, .5);
            padding-bottom: 1px;
            transition: border-color .2s;
        }

        .ritual-card:hover .ritual-link {
            border-color: white;
        }

        /* ─── Best Seller Bundle ────────────────────────────── */
        .bundle-section {
            background: var(--cream);
        }

        .bundle-inner {
            max-width: 1320px;
            margin: 0 auto;
            padding: 5rem 3rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .bundle-image-wrap {
            position: relative;
            border-radius: 12px;
            overflow: visible;
            aspect-ratio: 1 / 1;
            height: 500px;
            width: 100%;
        }

        .bundle-image-wrap img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            display: block;
            object-fit: cover;
            animation: bobble 2s ease-in-out infinite;
        }

        @keyframes bobble {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(6px);
            }
        }


        .bundle-badge-pill {
            position: absolute;
            bottom: -1rem;
            right: -1rem;
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .75rem 1.25rem;
            font-size: .72rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        }

        .bundle-badge-pill strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 500;
            color: var(--charcoal);
            letter-spacing: 0;
            text-transform: none;
            margin-top: .15rem;
        }


        .feature-badge {
            position: absolute;
            bottom: 1rem;
            right: -4rem;
            background: white;
            font-size: .72rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
            font-weight: 600;
            border-radius: var(--radius-md);
            padding: 14px 20px;
            box-shadow: var(--shadow-md);
            z-index: 10;
            white-space: nowrap;
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

        .bundle-eyebrow {
            font-size: .7rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .bundle-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 400;
            line-height: 1.15;
            color: var(--charcoal);
            margin-bottom: 1.25rem;
        }

        .bundle-desc {
            color: var(--warm-gray);
            font-size: .88rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .bundle-includes {
            margin-bottom: 2rem;
        }

        .bundle-includes p {
            font-size: .75rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
            font-weight: 600;
            margin-bottom: .75rem;
        }

        .bundle-item {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .85rem;
            color: var(--charcoal-mid);
            margin-bottom: .5rem;
        }

        .bundle-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--rose);
            flex-shrink: 0;
        }

        .bundle-cta {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .bundle-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--charcoal);
            font-weight: 500;
        }

        /* ---- TESTIMONIALS ---- */
        .testimonials-section {
            padding: 80px 0;
            background: var(--white);
        }

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

        .testimonial-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-sm);
        }

        .testimonial-stars {
            color: var(--pink-primary);
            font-size: 14px;
            margin-bottom: 16px;
        }

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

        .testimonial-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .testimonial-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
        }

        .testimonial-label {
            font-size: 11px;
            color: var(--dark-light);
        }

        /* ─── Category chips ────────────────────────────────── */
        .categories {
            display: flex;
            gap: .75rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }

        .cat-chip {
            padding: .45rem 1.25rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            white-space: nowrap;
            font-size: .75rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-weight: 500;
            transition: all .2s;
            color: var(--charcoal-mid);
        }

        .cat-chip:hover,
        .cat-chip.active {
            background: var(--charcoal);
            color: white;
            border-color: var(--charcoal);
        }

        @media (max-width: 1024px) {
            .ritual-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .bundle-inner {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .hero {
                height: 85vh;
            }

            .hero-image {
                width: 100%;
                opacity: .25;
            }

            .hero-overlay {
                background: rgba(249, 232, 237, .92);
            }

            .hero-content {
                padding: 0 1.25rem;
            }

            .ritual-grid {
                grid-template-columns: 1fr 1fr;
                gap: .75rem;
            }

            .ritual-card {
                height: 260px;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .bundle-inner {
                padding: 3rem 1.25rem;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .brands-strip {
                padding: 1rem 1.25rem;
            }

            .brand-list {
                gap: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero">
        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1400&q=80" alt="GlowMart — Clean Beauty"
            class="hero-bg-img">
        <div class="container">
            <div class="hero-content" style="max-width:560px; padding:80px 0;">
                <p class="hero-overline">Summer Radiance 2025</p>
                <h1 class="hero-title">Reveal Your <em>Natural Glow</em></h1>
                <p class="hero-subtitle">Experience the transformative power of clean beauty. Crafted with rare botanicals
                    to nourish your skin from within.</p>
                <div class="hero-actions">
                    <a href="{{ route('shop') }}" class="btn-primary">Shop Now</a>
                    <a href="{{ route('discover') }}" class="btn-secondary">Discover</a>
                </div>
            </div>
        </div>
        <div class="hero-scroll-hint">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="6 9 12 15 18 9" />
            </svg>
            Scroll
        </div>
    </section>

    {{-- ── Brand Strip ── --}}
    <div class="brands-strip">
        <div class="brands-inner">
            <span class="brand-label">Curating the world's finest</span>
            <div class="brand-list">
                <span class="brand-item">Lumina</span>
                <span class="brand-item">Aura</span>
                <span class="brand-item">Verve Beauty</span>
                <span class="brand-item">Esthé</span>
                <span class="brand-item">Pure.</span>
                <span class="brand-item">Glacé</span>
            </div>
        </div>
    </div>

    {{-- ── Trending Now ── --}}
    <div class="section">
        <div class="section-header">
            <div>
                <h2 class="section-title">Trending Now</h2>
                <p class="section-subtitle" style="margin-bottom:0">Editor's picks this season</p>
            </div>
            <a href="/shop" class="explore-link">Explore All Products</a>
        </div>

        <div class="categories" id="cat-list">
            <div class="cat-chip active" onclick="filterCat(null,this)">Semua</div>
        </div>

        <div class="product-grid" id="product-grid">
            {{-- skeleton placeholders --}}
            @for($i = 0; $i < 4; $i++)
                <div
                    style="background:var(--border-light);height:380px;border-radius:4px;animation:pulse 1.5s ease-in-out infinite;">
                </div>
            @endfor
        </div>
    </div>

    {{-- ── Shop by Ritual ── --}}
    <div class="ritual-section">
        <div class="section">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Shop by Ritual</h2>
                    <p class="section-subtitle" style="margin-bottom:0">Find your perfect routine</p>
                </div>
            </div>
            <div class="ritual-grid">
                <div class="ritual-card" onclick="window.location='/shop?cat=skincare'">
                    <img src="https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&q=80" alt="Skincare"
                        onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                    <div class="ritual-overlay"></div>
                    <div class="ritual-content">
                        <p class="ritual-category">Skincare</p>
                        <h3 class="ritual-title">Radiant, Refined.</h3>
                        <p class="ritual-desc">Serums reinvented</p>
                        <span class="ritual-link">Shop Collection</span>
                    </div>
                </div>
                <div class="ritual-card" onclick="window.location='/shop?cat=makeup'">
                    <img src="https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=600&q=80" alt="Makeup"
                        onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                    <div class="ritual-overlay"></div>
                    <div class="ritual-content">
                        <p class="ritual-category">Makeup</p>
                        <h3 class="ritual-title">Boldly Defined.</h3>
                        <p class="ritual-desc">Beauty redefined</p>
                        <span class="ritual-link">Shop Collection</span>
                    </div>
                </div>
                <div class="ritual-card" onclick="window.location='/shop?cat=fragrance'">
                    <img src="https://images.unsplash.com/photo-1724157073080-fcffb8d6c956?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Fragrance" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                    <div class="ritual-overlay"></div>
                    <div class="ritual-content">
                        <p class="ritual-category">Fragrance</p>
                        <h3 class="ritual-title">Your Signature.</h3>
                        <p class="ritual-desc">Scent as identity</p>
                        <span class="ritual-link">Shop Collection</span>
                    </div>
                </div>
                <div class="ritual-card" onclick="window.location='/shop?cat=haircare'">
                    <img src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=600&q=80" alt="Haircare"
                        onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                    <div class="ritual-overlay"></div>
                    <div class="ritual-content">
                        <p class="ritual-category">Haircare</p>
                        <h3 class="ritual-title">The Ultimate Shine.</h3>
                        <p class="ritual-desc">Hair perfected</p>
                        <span class="ritual-link">Shop Collection</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Best Seller Bundle ── --}}
    <div class="bundle-section">
        <div class="bundle-inner">
            <div class="bundle-image-wrap">
                <img src="https://images.unsplash.com/photo-1679623100266-db82be84f5f3?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D=80"
                    alt="Complete Glow Kit" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="feature-badge ">
                    <p class="feature-badge-label">Best Seller 2024</p>
                    <p class="feature-badge-name">Complete Glow Kit</p>
                </div>
            </div>
            <div>
                <p class="bundle-eyebrow">The Gold Standard</p>
                <h2 class="bundle-title">The Best-Selling Ritual<br>For All Skin Types</h2>
                <p class="bundle-desc">
                    Our award-winning Glow Kit has helped over 50,000 women achieve
                    their dream skin. Dermatologist-tested, vegan, and cruelty-free.
                </p>
                <div class="bundle-includes">
                    <p>Includes</p>
                    <div class="bundle-item"><span class="bundle-dot"></span> Silk Peptide Cleanser (Full Size)</div>
                    <div class="bundle-item"><span class="bundle-dot"></span> Radiance Nectar Serum (Full Size)</div>
                    <div class="bundle-item"><span class="bundle-dot"></span> Rose Quartz Soufflé (Travel Size)</div>
                </div>
                <div class="bundle-cta">
                    <a href="/product/glow-kit" class="btn btn-primary" style="padding:.75rem 2rem;font-size:.8rem;">Get The
                        Set</a>
                    <a href="/shop/bestsellers" class="btn btn-secondary" style="padding:.75rem 2rem;font-size:.8rem;">Shop
                        Best Sellers</a>
                </div>
            </div>
        </div>
    </div>

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
                    <p class="testimonial-text">"I've struggled with dull skin for years, but the Lumina Serum changed
                        everything. My skin has never looked more radiant and healthy. Truly worth every penny!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80"
                                alt="Sarah Jenkins">
                        </div>
                        <div>
                            <p class="testimonial-name">Sarah Jenkins</p>
                            <p class="testimonial-label">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"The Morning Dew Fragrance is my signature scent. It's light, fresh, and
                        stays all day. I get compliments everywhere I go! Shipping was also super fast."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=80&q=80"
                                alt="Elena Rodriguez">
                        </div>
                        <div>
                            <p class="testimonial-name">Elena Rodriguez</p>
                            <p class="testimonial-label">Verified Buyer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"Customer service is absolutely elite. They helped me pick the perfect shade
                        for my foundation, and it matches perfectly. Forever a GlowMart girl!"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?w=80&q=80"
                                alt="Maya Thompson">
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


@endsection

@section('scripts')
    <style>
        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .5
            }
        }
    </style>
    <script>
        let currentCat = null;

        async function loadCategories() {
            try {
                const r = await axios.get(API + '/categories');
                r.data.data.forEach(cat => {
                    document.getElementById('cat-list').innerHTML +=
                        `<div class="cat-chip" onclick="filterCat(${cat.id},this)">${cat.name} (${cat.products_count})</div>`;
                });
            } catch { }
        }

        async function filterCat(catId, el) {
            document.querySelectorAll('.cat-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            currentCat = catId;
            await loadProducts(catId);
        }

        async function loadProducts(catId = null) {
            const grid = document.getElementById('product-grid');
            grid.innerHTML = [1, 2, 3, 4].map(() =>
                `<div style="background:var(--border-light);height:380px;border-radius:4px;animation:pulse 1.5s ease-in-out infinite;"></div>`
            ).join('');

            try {
                const params = catId ? `?category_id=${catId}` : '';
                const r = await axios.get(GW + '/products' + params);
                const products = r.data.data.data || [];

                if (!products.length) {
                    grid.innerHTML = '<p style="color:var(--warm-gray);grid-column:1/-1;text-align:center;padding:3rem 0;">Produk tidak ditemukan.</p>';
                    return;
                }

                const badges = ['badge-trending', 'badge-new', 'badge-limited', ''];
                const badgeLabels = ['Trending', 'New', 'Limited', ''];

                grid.innerHTML = products.map((p, i) => {
                    const badgeClass = badges[i % 4];
                    const badgeLabel = badgeLabels[i % 4];
                    const stars = Math.round(p.reviews_avg_rating || 0);
                    const rating = p.reviews_avg_rating ? Number(p.reviews_avg_rating).toFixed(1) : '—';
                    const img = p.image || `https://via.placeholder.com/400x280?text=${encodeURIComponent(p.name)}`;
                    const brand = p.brand || p.category?.name || '';

                    return `
                                            <div class="product-card" onclick="window.location='/product/${p.id}'">
                                              <div class="product-card-img">
                                                <img src="${img}" alt="${p.name}" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                                                ${badgeLabel ? `<span class="product-badge ${badgeClass}">${badgeLabel}</span>` : ''}
                                                <button class="product-wishlist" onclick="event.stopPropagation();addToWishlist(${p.id})" title="Wishlist">
                                                  <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                                  </svg>
                                                </button>
                                              </div>
                                              <div class="product-info">
                                                ${brand ? `<div class="product-brand-tag">${brand}</div>` : ''}
                                                <div class="product-name">${p.name}</div>
                                                <div class="product-price">${formatRp(p.price)}</div>
                                                <div class="product-stars">
                                                  ${'★'.repeat(stars)}${'☆'.repeat(5 - stars)}
                                                  <span>(${rating})</span>
                                                </div>
                                              </div>
                                            </div>`;
                }).join('');
            } catch {
                grid.innerHTML = '<p style="color:var(--warm-gray);grid-column:1/-1;text-align:center;padding:3rem 0;">Gagal memuat produk.</p>';
            }
        }

        function addToWishlist(id) {
            const user = getUser();
            if (!user) { window.location.href = '/login'; return; }

            const pid = Number(id);
            let items = JSON.parse(localStorage.getItem('gm_wishlist') || '[]').map(Number);

            if (items.includes(pid)) {
                items = items.filter(i => i !== pid);
                localStorage.setItem('gm_wishlist', JSON.stringify(items));
                toast('Dihapus dari wishlist', '');
            } else {
                items.push(pid);
                localStorage.setItem('gm_wishlist', JSON.stringify(items));
                toast('Ditambahkan ke wishlist ❤️', 'success');
            }
        }

        loadCategories();
        loadProducts();
    </script>
@endsection
