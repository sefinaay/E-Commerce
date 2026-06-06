@extends('frontend.layout')
@section('title', 'Discover — GlowMart')

@section('head')
<style>
/* ── Map old CSS vars ke new vars dari layout ── */
:root {
    --pink-deep:     #e8637a;
    --rose:          #ffb0c1;
    --rose-light:    #ffb0c1;
    --gold:          #c9a96e;
    --charcoal:      #1a1a1a;
    --charcoal-mid:  #333333;
    --dark-muted:    #666666;
    --warm-gray:     #999999;
    --border-light:  #eeeeee;
    --soft-bg:       #fff0f5;
    --cream:         #fafafa;
    --max-width:     1320px;
}

/* ── API Badge strip ── */
.api-notice {
    background: #fff8fa;
    border-bottom: 1px solid #f5e6eb;
    padding: 10px 32px;
    text-align: center;
    font-family: var(--font-sans);
    font-size: 12px;
    color: #666;
}
.api-notice a {
    color: var(--pink);
    font-weight: 600;
    text-decoration: none;
}
.api-notice strong { color: var(--dark); }

/* ── HERO ── */
.hero {
    position: relative;
    min-height: 520px;
    background: linear-gradient(135deg, #f9dde3 0%, #fce8ec 40%, #ffe4ea 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
}
.hero-bg-img {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.5;
}
.hero-content {
    position: relative;
    z-index: 2;
    padding: 80px 48px;
    max-width: 560px;
}
.hero-overline {
    font-family: var(--font-sans);
    font-size: 11px; font-weight: 700;
    letter-spacing: .2em; text-transform: uppercase;
    color: var(--pink-deep);
    margin-bottom: 20px;
    opacity: 0;
    animation: fadeUp .8s .2s forwards;
}
.hero-title {
    font-family: var(--font-serif);
    font-size: clamp(38px, 5vw, 60px);
    font-weight: 400; line-height: 1.1;
    color: var(--charcoal);
    margin-bottom: 20px;
    opacity: 0;
    animation: fadeUp .8s .4s forwards;
}
.hero-title em { font-style: italic; color: var(--pink-deep); }
.hero-subtitle {
    font-family: var(--font-sans);
    font-size: 15px; font-weight: 300;
    color: var(--dark-muted); line-height: 1.7;
    margin-bottom: 36px; max-width: 380px;
    opacity: 0;
    animation: fadeUp .8s .6s forwards;
}
.hero-actions {
    display: flex; gap: 16px; align-items: center; flex-wrap: wrap;
    opacity: 0;
    animation: fadeUp .8s .8s forwards;
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.btn-hero-dark {
    padding: 14px 32px;
    background: var(--charcoal); color: white;
    border: none; border-radius: 50px;
    font-family: var(--font-sans);
    font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    cursor: pointer; transition: all .25s;
}
.btn-hero-dark:hover { background: #333; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(0,0,0,.2); }
.btn-hero-outline {
    padding: 13px 28px;
    background: transparent; color: var(--charcoal);
    border: 1.5px solid rgba(26,26,26,.3); border-radius: 50px;
    font-family: var(--font-sans);
    font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    cursor: pointer; transition: all .25s;
    text-decoration: none; display: inline-flex; align-items: center;
}
.btn-hero-outline:hover { border-color: var(--charcoal); background: rgba(26,26,26,.05); }

.hero-scroll-hint {
    position: absolute; bottom: 2rem; left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex; flex-direction: column; align-items: center; gap: .4rem;
    color: var(--warm-gray); font-family: var(--font-sans);
    font-size: .7rem; letter-spacing: .12em; text-transform: uppercase;
    animation: bobble 2s ease-in-out infinite;
}
@keyframes bobble {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(6px); }
}

/* ── FILTER TAB BAR ── */
.filter-bar-wrap {
    background: white;
    border-bottom: 1px solid var(--border-light);
    position: sticky; top: 64px; z-index: 99;
}
.filter-bar {
    max-width: 1280px; margin: 0 auto;
    padding: 0 48px;
    display: flex; align-items: center;
    justify-content: space-between; height: 52px;
}
.filter-tabs { display: flex; gap: 4px; align-items: center; }
.filter-tab {
    padding: 6px 16px;
    font-family: var(--font-sans);
    font-size: 12px; font-weight: 500;
    letter-spacing: .04em;
    color: var(--warm-gray);
    cursor: pointer; border: none; background: none;
    border-radius: 50px; transition: all .18s;
    white-space: nowrap;
}
.filter-tab:hover { color: var(--charcoal); background: #f5f5f5; }
.filter-tab.active {
    background: var(--charcoal); color: white; font-weight: 600;
}
.filter-right {
    display: flex; align-items: center; gap: 6px;
    font-family: var(--font-sans);
    font-size: 11px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--charcoal-mid);
    cursor: pointer; border: none; background: none;
}

/* ── FILTER PANEL ── */
#filter-panel {
    display: none;
    background: white;
    border-bottom: 1px solid var(--border-light);
}
#filter-panel > div {
    max-width: 1280px; margin: 0 auto;
    padding: 20px 48px;
    display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;
}
#filter-panel label {
    font-family: var(--font-sans);
    font-size: 10px; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--warm-gray); display: block; margin-bottom: 6px;
}
#filter-panel select {
    padding: 9px 14px;
    border: 1.5px solid var(--border-light); border-radius: 8px;
    font-family: var(--font-sans); font-size: 13px;
    color: var(--charcoal); outline: none;
    transition: border-color .2s; background: white;
}
#filter-panel select:focus { border-color: var(--rose); }
.btn-filter-apply {
    padding: 9px 20px;
    background: var(--charcoal); color: white;
    border: none; border-radius: 8px;
    font-family: var(--font-sans); font-size: 12px; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    cursor: pointer; transition: background .2s;
}
.btn-filter-apply:hover { background: #333; }
.btn-filter-reset {
    padding: 9px 20px;
    background: white; color: var(--charcoal-mid);
    border: 1.5px solid var(--border-light); border-radius: 8px;
    font-family: var(--font-sans); font-size: 12px; font-weight: 600;
    cursor: pointer; transition: all .2s;
}
.btn-filter-reset:hover { border-color: var(--charcoal); }

/* ── PRODUCTS GRID ── */
.discover-products {
    max-width: 1280px; margin: 0 auto;
    padding: 40px 48px;
}
.product-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* Product card */
.disc-card {
    background: white;
    border: 1px solid var(--border-light);
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: transform .25s, box-shadow .25s;
    position: relative;
}
.disc-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(255,176,193,.2);
}
.disc-card-img {
    position: relative; height: 240px; overflow: hidden;
    background: #fff0f5;
}
.disc-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .4s;
}
.disc-card:hover .disc-card-img img { transform: scale(1.05); }
.disc-badge {
    position: absolute; top: 10px; left: 10px;
    font-family: var(--font-sans);
    font-size: 10px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    padding: 4px 10px; border-radius: 50px;
}
.badge-trending { background: var(--charcoal); color: white; }
.badge-new      { background: var(--pink-deep); color: white; }
.badge-limited  { background: var(--gold); color: white; }

/* External API badge */
.badge-external {
    position: absolute; top: 10px; left: 10px;
    background: rgba(255,255,255,.92);
    border: 1px solid var(--border-light);
    font-family: var(--font-sans);
    font-size: 9px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    padding: 3px 8px; border-radius: 50px;
    color: var(--pink-deep);
}

.disc-wishlist {
    position: absolute; top: 10px; right: 10px;
    width: 32px; height: 32px;
    background: white; border: none; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; opacity: 0; transition: opacity .2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}
.disc-card:hover .disc-wishlist { opacity: 1; }
.disc-wishlist:hover { color: var(--pink-deep); }

.disc-card-body { padding: 14px 16px 18px; }
.disc-brand {
    font-family: var(--font-sans);
    font-size: 10px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 5px;
}
.disc-name {
    font-family: var(--font-serif);
    font-size: 15px; font-weight: 400;
    color: var(--charcoal); margin-bottom: 6px; line-height: 1.35;
}
.disc-stars { display: flex; align-items: center; gap: 5px; }
.stars { color: #E8A800; font-size: 12px; letter-spacing: 1px; }
.disc-price {
    font-family: var(--font-sans);
    font-size: 14px; font-weight: 600;
    color: var(--charcoal); margin-top: 6px;
}

/* Skeleton */
.skeleton {
    background: linear-gradient(90deg, #f5e6eb 25%, #fce9ef 50%, #f5e6eb 75%);
    background-size: 200% 100%;
    border-radius: 16px;
    animation: shimmer 1.4s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* ── SHOP BY RITUAL ── */
.ritual-section {
    background: white;
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
}
.ritual-inner {
    max-width: 1280px; margin: 0 auto; padding: 64px 48px;
}
.ritual-heading {
    font-family: var(--font-serif);
    font-size: 32px; font-weight: 400;
    text-align: center; color: var(--charcoal); margin-bottom: 8px;
}
.ritual-underline {
    width: 40px; height: 2px;
    background: var(--rose); margin: 0 auto 40px; border-radius: 1px;
}
.ritual-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
}
.ritual-card {
    position: relative; overflow: hidden;
    border-radius: 16px; height: 320px; cursor: pointer;
}
.ritual-card img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .5s;
}
.ritual-card:hover img { transform: scale(1.06); }
.ritual-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 30%, rgba(20,10,12,.72) 100%);
    transition: background .3s;
}
.ritual-card:hover .ritual-overlay {
    background: linear-gradient(180deg, transparent 20%, rgba(20,10,12,.82) 100%);
}
.ritual-content {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 22px 20px; color: white;
}
.ritual-category {
    font-family: var(--font-sans);
    font-size: 10px; letter-spacing: .18em; text-transform: uppercase;
    color: rgba(255,255,255,.6); margin-bottom: 5px;
}
.ritual-title {
    font-family: var(--font-serif);
    font-size: 20px; font-weight: 400; margin-bottom: 4px;
}
.ritual-subtitle {
    font-family: var(--font-sans);
    font-size: 11px; color: rgba(255,255,255,.55); margin-bottom: 14px;
}
.ritual-link {
    font-family: var(--font-sans);
    font-size: 10px; letter-spacing: .14em; text-transform: uppercase;
    color: white; border-bottom: 1px solid rgba(255,255,255,.5);
    padding-bottom: 1px; transition: border-color .2s;
}
.ritual-card:hover .ritual-link { border-color: white; }

/* ── BUNDLE SECTION ── */
.bundle-section { background: var(--cream); }
.bundle-inner {
    max-width: 1280px; margin: 0 auto; padding: 80px 48px;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: center;
}
.bundle-img-wrap { position: relative; }
.bundle-img-wrap img {
    width: 100%; border-radius: 20px; display: block; height: 480px; object-fit: cover;
}
.bundle-pill {
    position: absolute; bottom: -16px; right: -16px;
    background: white; border: 1px solid var(--border-light);
    border-radius: 16px; padding: 18px 22px;
    box-shadow: 0 8px 28px rgba(0,0,0,.1);
}
.pill-tag {
    font-family: var(--font-sans);
    font-size: 10px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase; color: var(--pink-deep);
    display: flex; align-items: center; gap: 6px; margin-bottom: 4px;
}
.pill-tag::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: var(--pink-deep);
}
.pill-name {
    font-family: var(--font-serif);
    font-size: 17px; color: var(--charcoal); margin-bottom: 14px;
}
.btn-pill {
    padding: 10px 18px;
    background: var(--charcoal); color: white; border: none;
    border-radius: 50px; font-family: var(--font-sans);
    font-size: 11px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    cursor: pointer; transition: background .2s;
}
.btn-pill:hover { background: #333; }

.bundle-eyebrow {
    font-family: var(--font-sans);
    font-size: 10px; letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold); font-weight: 700; margin-bottom: 16px;
}
.bundle-title {
    font-family: var(--font-serif);
    font-size: clamp(28px, 3vw, 42px);
    font-weight: 400; line-height: 1.15;
    color: var(--charcoal); margin-bottom: 18px;
}
.bundle-desc {
    font-family: var(--font-sans);
    font-size: 14px; color: var(--warm-gray);
    line-height: 1.85; margin-bottom: 28px;
}
.bundle-includes { margin-bottom: 32px; }
.bundle-includes-label {
    font-family: var(--font-sans);
    font-size: 11px; letter-spacing: .1em; text-transform: uppercase;
    color: var(--warm-gray); font-weight: 600; margin-bottom: 12px;
}
.bundle-item {
    display: flex; align-items: center; gap: 10px;
    font-family: var(--font-sans);
    font-size: 14px; color: var(--charcoal-mid); margin-bottom: 10px;
}
.bundle-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--rose); flex-shrink: 0;
}
.btn-bundle-cta {
    padding: 15px 36px;
    background: var(--charcoal); color: white; border: none;
    border-radius: 50px; font-family: var(--font-sans);
    font-size: 12px; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    cursor: pointer; transition: all .25s;
}
.btn-bundle-cta:hover { background: #333; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(0,0,0,.2); }

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .product-grid-4  { grid-template-columns: repeat(2, 1fr); }
    .ritual-grid     { grid-template-columns: repeat(2, 1fr); }
    .bundle-inner    { grid-template-columns: 1fr; gap: 40px; padding: 48px 24px; }
    .bundle-img-wrap img { height: 360px; }
}
@media (max-width: 768px) {
    .hero-content     { padding: 60px 24px; }
    .filter-bar       { padding: 0 20px; overflow-x: auto; }
    .discover-products{ padding: 28px 20px; }
    .ritual-inner     { padding: 48px 20px; }
}
@media (max-width: 540px) {
    .product-grid-4   { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .disc-card-img    { height: 180px; }
    .ritual-grid      { grid-template-columns: 1fr 1fr; }
    .ritual-card      { height: 240px; }
}
</style>
@endsection

@section('content')

{{-- API Notice Banner --}}
<div class="api-notice">
    🌐 Produk di halaman ini diambil <strong>real-time</strong> dari
    <a href="https://makeup-api.herokuapp.com" target="_blank">makeup-api.herokuapp.com</a>
    — Integrasi Third-party API
</div>

{{-- HERO --}}
<section class="hero">
    <img class="hero-bg-img"
         src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1400&q=80"
         alt="Discover GlowMart"
         onerror="this.onerror=null;this.style.opacity='.08'">
    <div class="hero-content">
        <p class="hero-overline">Summer Radiance 2024</p>
        <h1 class="hero-title">Reveal Your <em>Natural Glow</em></h1>
        <p class="hero-subtitle">
            Experience the transformative power of clean beauty.
            Crafted with rare botanicals to nourish your skin from within.
        </p>
        <div class="hero-actions">
            <button class="btn-hero-dark"
                onclick="document.getElementById('products-anchor').scrollIntoView({behavior:'smooth'})">
                Shop Now
            </button>
            <a href="/journal" class="btn-hero-outline">Our Story</a>
        </div>
    </div>
    <div class="hero-scroll-hint">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
        Scroll
    </div>
</section>

{{-- FILTER TAB BAR --}}
<div class="filter-bar-wrap">
    <div class="filter-bar">
        <div class="filter-tabs" id="filter-tabs">
            <button class="filter-tab active" onclick="setTab(this,'')">Trending</button>
            <button class="filter-tab" onclick="setTab(this,'lipstick')">Lipstick</button>
            <button class="filter-tab" onclick="setTab(this,'foundation')">Foundation</button>
            <button class="filter-tab" onclick="setTab(this,'eyeshadow')">Eyeshadow</button>
            <button class="filter-tab" onclick="setTab(this,'mascara')">Mascara</button>
            <button class="filter-tab" onclick="setTab(this,'blush')">Blush</button>
        </div>
        <button class="filter-right" onclick="toggleFiltersPanel()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="4" y1="6" x2="20" y2="6"/>
                <line x1="8" y1="12" x2="16" y2="12"/>
                <line x1="11" y1="18" x2="13" y2="18"/>
            </svg>
            Filters
        </button>
    </div>
</div>

{{-- Filter Panel --}}
<div id="filter-panel">
    <div>
        <div>
            <label>Brand</label>
            <select id="d-brand" onchange="loadProducts()">
                <option value="">All Brands</option>
            </select>
        </div>
        <div>
            <label>Product Type</label>
            <select id="d-type" onchange="loadProducts()">
                <option value="">All Types</option>
                <option value="lipstick">Lipstick</option>
                <option value="foundation">Foundation</option>
                <option value="eyeshadow">Eyeshadow</option>
                <option value="blush">Blush</option>
                <option value="mascara">Mascara</option>
                <option value="bronzer">Bronzer</option>
                <option value="eyeliner">Eyeliner</option>
                <option value="lip_liner">Lip Liner</option>
            </select>
        </div>
        <button class="btn-filter-apply" onclick="loadProducts()">Apply</button>
        <button class="btn-filter-reset" onclick="resetFilters()">Reset</button>
    </div>
</div>

{{-- PRODUCTS --}}
<div class="discover-products" id="products-anchor">
    <div class="product-grid-4" id="product-grid">
        @for($i = 0; $i < 8; $i++)
            <div class="skeleton" style="height:340px;"></div>
        @endfor
    </div>
</div>

{{-- SHOP BY RITUAL --}}
<section class="ritual-section">
    <div class="ritual-inner">
        <h2 class="ritual-heading">Shop by Ritual</h2>
        <div class="ritual-underline"></div>
        <div class="ritual-grid">
            <div class="ritual-card" onclick="window.location='/shop'">
                <img src="https://images.unsplash.com/photo-1614850523296-d8c1af93d400?w=600&q=80"
                     alt="Skincare" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="ritual-overlay"></div>
                <div class="ritual-content">
                    <p class="ritual-category">Skincare</p>
                    <h3 class="ritual-title">Nourish your canvas.</h3>
                    <p class="ritual-subtitle">Serums reinvented</p>
                    <span class="ritual-link">Shop Collection</span>
                </div>
            </div>
            <div class="ritual-card" onclick="window.location='/shop'">
                <img src="https://images.unsplash.com/photo-1596704017254-9b121068fb31?w=600&q=80"
                     alt="Makeup" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="ritual-overlay"></div>
                <div class="ritual-content">
                    <p class="ritual-category">Makeup</p>
                    <h3 class="ritual-title">Artistry defined.</h3>
                    <p class="ritual-subtitle">Beauty reimagined</p>
                    <span class="ritual-link">Shop Collection</span>
                </div>
            </div>
            <div class="ritual-card" onclick="window.location='/shop'">
                <img src="https://images.unsplash.com/photo-1563170351-be82bc888aa4?w=600&q=80"
                     alt="Fragrance" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="ritual-overlay"></div>
                <div class="ritual-content">
                    <p class="ritual-category">Fragrance</p>
                    <h3 class="ritual-title">Your scent signature.</h3>
                    <p class="ritual-subtitle">Scent as identity</p>
                    <span class="ritual-link">Shop Collection</span>
                </div>
            </div>
            <div class="ritual-card" onclick="window.location='/shop'">
                <img src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=600&q=80"
                     alt="Haircare" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="ritual-overlay"></div>
                <div class="ritual-content">
                    <p class="ritual-category">Haircare</p>
                    <h3 class="ritual-title">The ultimate shine.</h3>
                    <p class="ritual-subtitle">Hair perfected</p>
                    <span class="ritual-link">Shop Collection</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BUNDLE SECTION --}}
<section class="bundle-section">
    <div class="bundle-inner">
        <div class="bundle-img-wrap">
            <img src="https://images.unsplash.com/photo-1607006344380-b6775a0824a7?w=700&q=80"
                 alt="Complete Glow Kit"
                 onerror="this.onerror=null;this.src='/img/placeholder.svg'">
            <div class="bundle-pill">
                <div class="pill-tag">Best Seller 2024</div>
                <div class="pill-name">Complete Glow Kit</div>
                <button class="btn-pill" onclick="window.location='/shop'">Get the Set — Rp 145rb</button>
            </div>
        </div>
        <div>
            <p class="bundle-eyebrow">The Gold Standard</p>
            <h2 class="bundle-title">The Best-Selling<br>Ritual<br>For All Skin Types</h2>
            <p class="bundle-desc">
                Our award-winning Glow Kit has helped over 50,000 women achieve
                their dream skin. Dermatologist-tested, vegan, and cruelty-free.
            </p>
            <div class="bundle-includes">
                <p class="bundle-includes-label">Includes</p>
                <div class="bundle-item"><span class="bundle-dot"></span>Silk Peptide Cleanser (Full Size)</div>
                <div class="bundle-item"><span class="bundle-dot"></span>Radiance Nectar Serum (Full Size)</div>
                <div class="bundle-item"><span class="bundle-dot"></span>Rose Quartz Soufflé (Travel Size)</div>
            </div>
            <button class="btn-bundle-cta" onclick="window.location='/shop'">Shop Best Sellers</button>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
let activeType = '';

/* ── Tab switching ── */
function setTab(el, type) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    activeType = type;

    // Sync ke select filter juga
    const sel = document.getElementById('d-type');
    if (sel) sel.value = type;

    loadProducts();
}

/* ── Filter panel toggle ── */
function toggleFiltersPanel() {
    const p = document.getElementById('filter-panel');
    p.style.display = p.style.display === 'none' ? 'block' : 'none';
}

/* ── Load products dari Makeup API ── */
async function loadProducts() {
    const grid = document.getElementById('product-grid');
    grid.innerHTML = Array(8).fill(`<div class="skeleton" style="height:340px;"></div>`).join('');

    try {
        const brand = document.getElementById('d-brand')?.value || '';
        const type  = document.getElementById('d-type')?.value || activeType || '';

        const params = new URLSearchParams();
        if (brand) params.set('brand', brand);
        if (type)  params.set('product_type', type);

        const r = await axios.get(`/api/external/makeup/search?${params.toString()}`);
        const products = r.data.data || [];

        if (!products.length) {
            grid.innerHTML = `
                <p style="grid-column:1/-1;text-align:center;padding:60px 0;
                   font-family:var(--font-sans);color:var(--warm-gray);">
                    No products found. Try a different filter.
                </p>`;
            return;
        }

        const badgeCls = ['badge-trending','badge-new','badge-limited','','badge-new','','badge-trending','badge-limited'];
        const badgeTxt = ['Trending','New','Limited','','New','','Trending','Limited'];

        grid.innerHTML = products.slice(0, 8).map((p, i) => {
            const stars  = Math.round(p.reviews_avg_rating || 0);
            const rating = p.reviews_avg_rating ? Number(p.reviews_avg_rating).toFixed(1) : '—';
            const img    = p.image_link || '/img/placeholder.svg';
            const price  = p.price ? 'Rp ' + Math.round(parseFloat(p.price) * 15500).toLocaleString('id-ID') : 'N/A';
            const url    = p.source_url || '#';
            const bClass = badgeCls[i] || '';
            const bLabel = badgeTxt[i] || '';

            return `
                <div class="disc-card" onclick="window.open('${url}','_blank')">
                    <div class="disc-card-img">
                        <img src="${img}" alt="${p.name || ''}" loading="lazy"
                             onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                        <span class="badge-external">🌐 API</span>
                        ${bLabel ? `<span class="disc-badge ${bClass}" style="top:10px;left:auto;right:10px">${bLabel}</span>` : ''}
                        <button class="disc-wishlist"
                                onclick="event.stopPropagation();handleWishlist()"
                                title="Save to wishlist">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="disc-card-body">
                        ${p.brand ? `<div class="disc-brand">${p.brand}</div>` : ''}
                        <div class="disc-name">${p.name || ''}</div>
                        <div class="disc-stars">
                            <span class="stars">${'★'.repeat(stars)}${'☆'.repeat(5-stars)}</span>
                            <span style="color:var(--warm-gray);font-size:11px;">(${rating})</span>
                        </div>
                        <div class="disc-price">${price}</div>
                    </div>
                </div>`;
        }).join('');

    } catch(e) {
        grid.innerHTML = `
            <p style="grid-column:1/-1;text-align:center;padding:60px 0;
               font-family:var(--font-sans);color:var(--warm-gray);">
                Gagal memuat dari Makeup API. Coba lagi nanti.
            </p>`;
    }
}

/* ── Load brands ── */
async function loadBrands() {
    try {
        const r = await axios.get('/api/external/makeup/brands');
        const sel = document.getElementById('d-brand');
        if (!sel) return;
        (r.data.data || []).slice(0, 30).forEach(b => {
            sel.innerHTML += `<option value="${b}">${b}</option>`;
        });
    } catch {}
}

function resetFilters() {
    const b = document.getElementById('d-brand');
    const t = document.getElementById('d-type');
    if (b) b.value = '';
    if (t) t.value = '';
    activeType = '';
    document.querySelectorAll('.filter-tab').forEach((tab, i) => {
        tab.classList.toggle('active', i === 0);
    });
    loadProducts();
}

function handleWishlist() {
    if (!getUser()) { toast('Please sign in to save items', 'error'); return; }
    toast('Saved to wishlist ♡', 'success');
}

/* ── Init ── */
loadBrands();
loadProducts();
</script>
@endsection
