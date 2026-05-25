@extends('frontend.layout')

@section('title', 'Shop All Products — GlowMart')

@push('styles')
<style>
    .shop-page { padding: 48px 0 80px; }

    /* ---- PAGE HEADER ---- */
    .shop-header {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 0 32px 32px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 48px;
    }
    .shop-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--dark-light);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .shop-breadcrumb a { color: var(--dark-light); text-decoration: none; }
    .shop-breadcrumb a:hover { color: var(--pink-primary); }
    .shop-breadcrumb i { font-size: 10px; }
    .shop-title-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .shop-page-title {
        font-family: var(--font-serif);
        font-size: 40px;
        font-weight: 500;
        color: var(--dark);
    }
    .shop-meta-row {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .shop-count {
        font-size: 12px;
        color: var(--dark-muted);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* Category Chips */
    .category-chips {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .chip {
        padding: 8px 18px;
        border-radius: var(--radius-full);
        font-size: 12px;
        font-weight: 500;
        border: 1.5px solid var(--border);
        background: white;
        cursor: pointer;
        text-decoration: none;
        color: var(--dark-muted);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
    }
    .chip:hover { border-color: var(--pink-primary); color: var(--pink-primary); }
    .chip.active {
        background: var(--pink-primary);
        border-color: var(--pink-primary);
        color: white;
    }

    /* Sort */
    .sort-select {
        appearance: none;
        background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 12px center;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 9px 36px 9px 14px;
        font-family: var(--font-sans);
        font-size: 12px;
        font-weight: 500;
        color: var(--dark);
        cursor: pointer;
        outline: none;
        letter-spacing: 0.04em;
    }
    .sort-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--dark-light);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ---- LAYOUT ---- */
    .shop-layout {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 0 32px;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 48px;
        align-items: start;
    }

    /* ---- SIDEBAR ---- */
    .shop-sidebar {
        position: sticky;
        top: 90px;
    }
    .filter-section {
        border-bottom: 1px solid var(--border);
        padding: 0 0 24px 0;
        margin-bottom: 24px;
    }
    .filter-section:last-child { border-bottom: none; }
    .filter-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }
    .filter-title i { font-size: 10px; color: var(--dark-light); }
    .filter-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .filter-option-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--dark-muted);
        cursor: pointer;
    }
    .filter-option-label input[type="checkbox"] {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        accent-color: var(--pink-primary);
        cursor: pointer;
    }
    .filter-option-count {
        font-size: 11px;
        color: var(--dark-light);
    }
    .filter-option.active .filter-option-label { color: var(--pink-primary); font-weight: 500; }

    /* Price Range */
    .price-range-display {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--dark-muted);
        margin-bottom: 8px;
    }
    .price-slider {
        width: 100%;
        appearance: none;
        height: 3px;
        background: linear-gradient(to right, var(--pink-primary) 0%, var(--pink-primary) 60%, var(--border) 60%);
        border-radius: 2px;
        outline: none;
        cursor: pointer;
    }
    .price-slider::-webkit-slider-thumb {
        appearance: none;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--pink-primary);
        cursor: pointer;
        box-shadow: 0 1px 4px rgba(255,141,161,0.4);
    }

    /* Stars filter */
    .star-filter {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        color: var(--dark-light);
        font-size: 13px;
        transition: var(--transition);
    }
    .star-filter:hover { color: var(--dark); }
    .star-filter .stars { font-size: 13px; }

    /* Summer Sale Banner */
    .sidebar-banner {
        background: linear-gradient(135deg, var(--pink-primary), var(--pink-deep));
        border-radius: var(--radius-lg);
        padding: 24px 20px;
        text-align: center;
        margin-top: 8px;
    }
    .sidebar-banner h4 {
        font-family: var(--font-serif);
        font-size: 20px;
        font-weight: 500;
        color: white;
        margin-bottom: 8px;
    }
    .sidebar-banner p {
        font-size: 12px;
        color: rgba(255,255,255,0.85);
        margin-bottom: 16px;
    }
    .sidebar-banner a {
        display: inline-block;
        background: white;
        color: var(--pink-deep);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 9px 20px;
        border-radius: var(--radius-full);
        text-decoration: none;
        transition: var(--transition);
    }

    /* ---- PRODUCT GRID ---- */
    .shop-products {}
    .shop-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .products-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-bottom: 48px;
    }
    .product-card .product-card-add {
        width: 100%;
        background: var(--pink-pale);
        color: var(--pink-deep);
        border: none;
        padding: 10px;
        font-family: var(--font-sans);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 12px;
        border-radius: var(--radius-sm);
    }
    .product-card .product-card-add:hover {
        background: var(--pink-primary);
        color: white;
    }

    /* ---- PAGINATION ---- */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        padding: 20px 0;
    }
    .page-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 500;
        border: 1.5px solid var(--border);
        background: white;
        color: var(--dark-muted);
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
    }
    .page-btn:hover { border-color: var(--pink-primary); color: var(--pink-primary); }
    .page-btn.active {
        background: var(--pink-primary);
        border-color: var(--pink-primary);
        color: white;
    }
    .page-btn.prev-next { width: auto; padding: 0 16px; font-size: 12px; }
    .page-ellipsis { color: var(--dark-light); font-size: 16px; padding: 0 4px; }

    @media (max-width: 1024px) {
        .shop-layout { grid-template-columns: 200px 1fr; gap: 32px; }
        .products-grid-3 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .shop-layout { grid-template-columns: 1fr; }
        .shop-sidebar { position: static; display: none; }
        .products-grid-3 { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .shop-header { padding: 0 16px 28px; }
        .shop-layout { padding: 0 16px; }
    }
</style>
@endpush

@section('content')
<div class="shop-page">

    {{-- Page Header --}}
    <div class="shop-header">
        <div class="shop-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>All Products</span>
        </div>
        <div class="shop-title-row">
            <h1 class="shop-page-title">All Products</h1>
            <div class="sort-label">
                Sort by:
                <select class="sort-select" name="sort" onchange="window.location.href='{{ route('shop') }}?sort='+this.value+'&category={{ request('category') }}'">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Best Sellers</option>
                </select>
            </div>
        </div>
        <div class="shop-meta-row">
            <p class="shop-count">Showing 1–{{ isset($products) ? $products->count() : 9 }} of {{ isset($products) ? $products->total() : 48 }} products</p>
        </div>

        {{-- Category Chips --}}
        <div class="category-chips" style="margin-top:20px;">
            <a href="{{ route('shop') }}" class="chip {{ !request('category') ? 'active' : '' }}">All Products</a>
            <a href="{{ route('shop', ['category' => 'skincare']) }}" class="chip {{ request('category') == 'skincare' ? 'active' : '' }}">Serums</a>
            <a href="{{ route('shop', ['category' => 'moisturizers']) }}" class="chip {{ request('category') == 'moisturizers' ? 'active' : '' }}">Moisturizers</a>
            <a href="{{ route('shop', ['category' => 'cleansers']) }}" class="chip {{ request('category') == 'cleansers' ? 'active' : '' }}">Cleansers</a>
            <a href="{{ route('shop', ['category' => 'makeup']) }}" class="chip {{ request('category') == 'makeup' ? 'active' : '' }}">Makeup</a>
            <a href="{{ route('shop', ['category' => 'fragrance']) }}" class="chip {{ request('category') == 'fragrance' ? 'active' : '' }}">Fragrance</a>
        </div>
    </div>

    {{-- Shop Layout --}}
    <div class="shop-layout">

        {{-- Sidebar --}}
        <aside class="shop-sidebar">
            <div class="filter-section">
                <h3 class="filter-title">Category <i class="fas fa-minus"></i></h3>
                @php
                    $categories = [
                        ['slug'=>'skincare','label'=>'Skincare','count'=>124],
                        ['slug'=>'makeup','label'=>'Makeup','count'=>84],
                        ['slug'=>'fragrance','label'=>'Fragrance','count'=>41],
                        ['slug'=>'haircare','label'=>'Haircare','count'=>39],
                    ];
                @endphp
                @foreach($categories as $cat)
                    <div class="filter-option {{ request('category') == $cat['slug'] ? 'active' : '' }}">
                        <label class="filter-option-label">
                            <input type="checkbox" {{ request('category') == $cat['slug'] ? 'checked' : '' }} onchange="window.location.href='{{ route('shop', ['category' => $cat['slug']]) }}'">
                            {{ $cat['label'] }}
                        </label>
                        <span class="filter-option-count">({{ $cat['count'] }})</span>
                    </div>
                @endforeach
            </div>

            <div class="filter-section">
                <h3 class="filter-title">Brand <i class="fas fa-plus"></i></h3>
                @foreach(['Lumina Botanics','Aura Skincare','Pure Elements','Glacé Fragrance'] as $brand)
                    <div class="filter-option">
                        <label class="filter-option-label">
                            <input type="checkbox">
                            {{ $brand }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="filter-section">
                <h3 class="filter-title">Price Range <i class="fas fa-minus"></i></h3>
                <div class="price-range-display">
                    <span>$0</span>
                    <span>$500+</span>
                </div>
                <input type="range" class="price-slider" min="0" max="500" value="300">
            </div>

            <div class="filter-section">
                <h3 class="filter-title">Rating <i class="fas fa-minus"></i></h3>
                <div class="star-filter"><span class="stars">★★★★★</span> & Up</div>
                <div class="star-filter"><span class="stars">★★★★</span>☆ & Up</div>
            </div>

            <div class="sidebar-banner">
                <h4>Summer Sale</h4>
                <p>Up to 40% off on select moisturizers.</p>
                <a href="{{ route('shop', ['category' => 'skincare', 'sale' => '1']) }}">Shop Now</a>
            </div>
        </aside>

        {{-- Products --}}
        <div class="shop-products">
            <div class="products-grid-3">
                @isset($products)
                    @foreach($products as $product)
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
                                <div class="product-stars">★★★★★ <span>({{ $product->reviews_count ?? 0 }})</span></div>
                                <p class="product-price">${{ number_format($product->price, 2) }}
                                    @if($product->old_price ?? false)
                                        <span class="product-price-old">${{ number_format($product->old_price, 2) }}</span>
                                    @endif
                                </p>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button class="product-card-add" type="submit">Add to Bag</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Demo products --}}
                    @php
                        $demoProducts = [
                            ['name'=>'Glow-Infusion Elixir','brand'=>'Lumina Botanics','price'=>'48.00','badge'=>'trending','img'=>'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400&q=80','reviews'=>'(124)'],
                            ['name'=>'Rose Quartz Soufflé','brand'=>'Aura Skincare','price'=>'62.00','badge'=>null,'img'=>'https://images.unsplash.com/photo-1556228578-626d20b83545?w=400&q=80','reviews'=>'(86)'],
                            ['name'=>'Silk Peptide Cleanser','brand'=>'Pure Elements','price'=>'35.00','badge'=>null,'img'=>'https://images.unsplash.com/photo-1570194065650-d99fb4d72a9a?w=400&q=80','reviews'=>'(210)'],
                            ['name'=>'Morning Dew Eau de Parfum','brand'=>'Glacé Fragrance','price'=>'120.00','badge'=>'limited','img'=>'https://images.unsplash.com/photo-1541643600914-78b084683702?w=400&q=80','reviews'=>'(56)'],
                            ['name'=>'Liquid Gold Repair Oil','brand'=>'Lumina Botanics','price'=>'78.00','badge'=>null,'img'=>'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=400&q=80','reviews'=>'(142)'],
                            ['name'=>'Brightening Eye Soufflé','brand'=>'Aura Skincare','price'=>'52.00','badge'=>null,'img'=>'https://images.unsplash.com/photo-1621224663977-b025ba9c0e32?w=400&q=80','reviews'=>'(76)'],
                        ];
                    @endphp
                    @foreach($demoProducts as $p)
                        <div class="product-card">
                            <div class="product-card-image">
                                <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}">
                                @if($p['badge'])
                                    <span class="product-badge badge-{{ $p['badge'] == 'trending' ? 'new' : $p['badge'] }}">{{ ucfirst($p['badge']) }}</span>
                                @endif
                                <a href="#" class="product-wishlist-btn"><i class="far fa-heart"></i></a>
                            </div>
                            <div class="product-card-body">
                                <p class="product-brand">{{ $p['brand'] }}</p>
                                <a href="{{ route('product', 'demo') }}" class="product-name">{{ $p['name'] }}</a>
                                <div class="product-stars">★★★★★ <span>{{ $p['reviews'] }}</span></div>
                                <p class="product-price">${{ $p['price'] }}</p>
                                <button class="product-card-add">Add to Bag</button>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrap">
                <a href="#" class="page-btn prev-next"><i class="fas fa-chevron-left"></i> Prev</a>
                @isset($products)
                    {{ $products->links() }}
                @else
                    <a href="#" class="page-btn active">1</a>
                    <a href="#" class="page-btn">2</a>
                    <a href="#" class="page-btn">3</a>
                    <span class="page-ellipsis">...</span>
                    <a href="#" class="page-btn">8</a>
                @endisset
                <a href="#" class="page-btn prev-next">Next <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection