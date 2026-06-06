@extends('frontend.layout')
@section('title', 'All Products - GlowMart')
@section('head')
    <style>
        /* ── Page wrapper ── */
        .shop-page {
            max-width: 1320px;
            margin: 0 auto;
            padding: 2.5rem 3rem;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        /* ══════════════════════════════
       SIDEBAR
    ══════════════════════════════ */
        .sidebar {
            position: sticky;
            top: 80px;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .filter-section {
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--border-light);
        }

        .filter-section:first-child {
            padding-top: 0;
        }

        .filter-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            margin-bottom: .9rem;
        }

        .filter-section-head h4 {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--charcoal);
        }

        .filter-toggle {
            font-size: 1rem;
            color: var(--warm-gray);
            line-height: 1;
            transition: transform .2s;
        }

        .filter-toggle.open {
            transform: rotate(45deg);
        }

        /* Checkbox filters */
        .filter-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .35rem 0;
            cursor: pointer;
            gap: .5rem;
        }

        .filter-option:hover .filter-label {
            color: var(--rose);
        }

        .filter-checkbox {
            width: 15px;
            height: 15px;
            border: 1.5px solid var(--border);
            border-radius: 3px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }

        .filter-checkbox.checked {
            background: var(--rose);
            border-color: var(--rose);
        }

        .filter-checkbox.checked::after {
            content: '';
            width: 8px;
            height: 5px;
            border-left: 1.5px solid white;
            border-bottom: 1.5px solid white;
            transform: rotate(-45deg) translateY(-1px);
            display: block;
        }

        .filter-label {
            font-size: .83rem;
            color: var(--charcoal-mid);
            flex: 1;
            transition: color .15s;
        }

        .filter-count {
            font-size: .72rem;
            color: var(--warm-gray);
        }

        /* Price range */
        .price-range-wrap {
            padding: .5rem 0 .25rem;
        }

        .price-slider {
            width: 100%;
            height: 3px;
            -webkit-appearance: none;
            appearance: none;
            background: var(--border);
            border-radius: 2px;
            outline: none;
            cursor: pointer;
            margin: .75rem 0 .5rem;
        }

        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--rose);
            border: 2px solid white;
            box-shadow: 0 1px 4px rgba(200, 80, 106, .35);
            cursor: pointer;
        }

        .price-labels {
            display: flex;
            justify-content: space-between;
            font-size: .75rem;
            color: var(--warm-gray);
        }

        .price-labels span {
            font-weight: 500;
            color: var(--charcoal-mid);
        }

        /* Rating filter */
        .rating-option {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .35rem 0;
            cursor: pointer;
            font-size: .83rem;
            color: var(--charcoal-mid);
            transition: color .15s;
        }

        .rating-option:hover {
            color: var(--rose);
        }

        .rating-option.active .stars-text {
            color: var(--rose);
        }

        .stars-text {
            color: #E8A800;
            font-size: .85rem;
            letter-spacing: 1px;
        }

        /* Promo banner di sidebar */
        .sidebar-promo {
            margin-top: 1.75rem;
            background: linear-gradient(135deg, #f7e0e6 0%, #fce8ef 100%);
            border-radius: 6px;
            padding: 1.5rem 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar-promo::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(200, 80, 106, .12);
        }

        .sidebar-promo .promo-tag {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: .5rem;
        }

        .sidebar-promo h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--charcoal);
            line-height: 1.25;
            margin-bottom: .5rem;
        }

        .sidebar-promo p {
            font-size: .75rem;
            color: var(--charcoal-mid);
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        /* ══════════════════════════════
       MAIN CONTENT
    ══════════════════════════════ */
        .products-main {}

        .products-topbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .products-topbar-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--charcoal);
            line-height: 1;
            margin-bottom: .35rem;
        }

        .products-topbar-left .showing-txt {
            font-size: .75rem;
            color: var(--warm-gray);
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .products-topbar-right {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap input {
            padding: .55rem 1rem .55rem 2.4rem;
            border: 1px solid var(--border);
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .8rem;
            color: var(--charcoal);
            background: white;
            width: 200px;
            transition: border-color .2s;
            outline: none;
        }

        .search-wrap input:focus {
            border-color: var(--charcoal);
        }

        .search-wrap input::placeholder {
            color: var(--warm-gray);
        }

        .search-wrap svg {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--warm-gray);
            pointer-events: none;
        }

        .sort-select-wrap {
            position: relative;
        }

        .sort-select-wrap::after {
            content: '';
            position: absolute;
            right: .85rem;
            top: 50%;
            transform: translateY(-50%);
            border: 4px solid transparent;
            border-top: 5px solid var(--charcoal-mid);
            pointer-events: none;
        }

        .sort-select {
            padding: .55rem 2.25rem .55rem 1rem;
            border: 1px solid var(--border);
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .75rem;
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--charcoal);
            background: white;
            appearance: none;
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
            white-space: nowrap;
        }

        .sort-select:focus {
            border-color: var(--charcoal);
        }

        .sort-label {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
            white-space: nowrap;
        }

        /* ── Product Grid ── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .product-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 3px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(200, 80, 106, .1);
        }

        .product-card-img {
            position: relative;
            height: 260px;
            overflow: hidden;
            background: var(--soft-bg);
        }

        .product-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }

        .product-card:hover .product-card-img img {
            transform: scale(1.05);
        }

        .card-badge {
            position: absolute;
            top: .75rem;
            left: .75rem;
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: .25rem .65rem;
            border-radius: 2px;
            z-index: 1;
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

        .card-wishlist {
            position: absolute;
            top: .75rem;
            right: .75rem;
            z-index: 1;
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        .product-card:hover .card-wishlist {
            opacity: 1;
        }

        .card-wishlist:hover svg {
            stroke: var(--rose);
            fill: var(--rose-pale);
        }

        .product-card-body {
            padding: 1rem 1rem 1.25rem;
        }

        .card-brand {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .3rem;
        }

        .card-name {
            font-size: .92rem;
            font-weight: 400;
            color: var(--charcoal);
            line-height: 1.35;
            margin-bottom: .5rem;
        }

        .card-stars {
            display: flex;
            align-items: center;
            gap: .3rem;
            font-size: .8rem;
        }

        .stars {
            color: #E8A800;
            letter-spacing: 1px;
        }

        .review-count {
            color: var(--warm-gray);
            font-size: .72rem;
        }

        .card-price {
            font-size: .9rem;
            font-weight: 600;
            color: var(--charcoal);
            margin-top: .4rem;
        }

        /* skeleton */
        .skeleton {
            background: var(--border-light);
            border-radius: 3px;
            animation: pulse 1.4s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .45
            }
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            margin-top: 3rem;
        }

        .page-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: white;
            font-size: .82rem;
            font-family: 'Jost', sans-serif;
            color: var(--charcoal-mid);
            cursor: pointer;
            transition: all .18s;
        }

        .page-btn:hover {
            border-color: var(--charcoal);
            color: var(--charcoal);
        }

        .page-btn.active {
            background: var(--charcoal);
            border-color: var(--charcoal);
            color: white;
            font-weight: 600;
        }

        .page-btn.ellipsis {
            border: none;
            background: none;
            cursor: default;
            color: var(--warm-gray);
            pointer-events: none;
        }

        .page-btn.arrow {
            font-size: 1rem;
        }

        .page-btn.arrow:hover {
            background: var(--charcoal);
            color: white;
        }

        @media (max-width: 1024px) {
            .shop-page {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .shop-page {
                padding: 1.5rem 1rem;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: .75rem;
            }

            .product-card-img {
                height: 180px;
            }

            .products-topbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="shop-page">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="sidebar">

            {{-- Category --}}
            <div class="filter-section" id="sec-cat">
                <div class="filter-section-head" onclick="toggleSection('sec-cat')">
                    <h4>Category</h4>
                    <span class="filter-toggle open" id="tog-sec-cat">+</span>
                </div>
                <div id="body-sec-cat">
                    <div class="filter-option" onclick="toggleCat(null,this)" id="cat-all">
                        <div class="filter-checkbox checked" id="cb-cat-all"></div>
                        <span class="filter-label">All</span>
                    </div>
                    {{-- filled by JS --}}
                    <div id="cat-options"></div>
                </div>
            </div>

            {{-- Brand --}}
            <div class="filter-section" id="sec-brand">
                <div class="filter-section-head" onclick="toggleSection('sec-brand')">
                    <h4>Brand</h4>
                    <span class="filter-toggle open" id="tog-sec-brand">+</span>
                </div>
                <div id="body-sec-brand">
                    <div id="brand-options">
                        <p style="font-size:.8rem;color:var(--warm-gray)">Memuat...</p>
                    </div>
                </div>
            </div>

            {{-- Price range --}}
            <div class="filter-section" id="sec-price">
                <div class="filter-section-head" onclick="toggleSection('sec-price')">
                    <h4>Price Range</h4>
                    <span class="filter-toggle open" id="tog-sec-price">+</span>
                </div>
                <div id="body-sec-price">
                    <div class="price-range-wrap">
                        <input type="range" class="price-slider" id="price-max-slider" min="0" max="2000000" step="50000"
                            value="2000000" oninput="onPriceSlide(this.value)">
                        <div class="price-labels">
                            <span>$0</span>
                            <span id="price-max-label">$500+</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rating --}}
            <div class="filter-section" id="sec-rating">
                <div class="filter-section-head" onclick="toggleSection('sec-rating')">
                    <h4>Rating</h4>
                    <span class="filter-toggle open" id="tog-sec-rating">+</span>
                </div>
                <div id="body-sec-rating">
                    <div class="rating-option" onclick="setRating(4,this)">
                        <span class="stars-text">★★★★☆</span> <span style="font-size:.78rem;color:var(--warm-gray)">&amp;
                            Up</span>
                    </div>
                    <div class="rating-option" onclick="setRating(3,this)">
                        <span class="stars-text">★★★☆☆</span> <span style="font-size:.78rem;color:var(--warm-gray)">&amp;
                            Up</span>
                    </div>
                </div>
            </div>

            {{-- Promo banner --}}
            <div class="sidebar-promo">
                <p class="promo-tag">Summer Sale</p>
                <h3>Up to<br>30% Off</h3>
                <p>On selected skincare &amp; makeup products</p>
                <a href="/shop?sale=1" class="btn btn-primary" style="font-size:.72rem;padding:.5rem 1.1rem;">Shop Now</a>
            </div>

        </aside>

        {{-- ══ MAIN ══ --}}
        <div class="products-main">

            <div class="products-topbar">
                <div class="products-topbar-left">
                    <h1>All Products</h1>
                    <p class="showing-txt" id="showing-txt">Memuat produk...</p>
                </div>
                <div class="products-topbar-right">
                    <div class="search-wrap">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input type="text" id="f-search" placeholder="Search products..." oninput="debounceFilter()">
                    </div>
                    <span class="sort-label">Sort by:</span>
                    <div class="sort-select-wrap">
                        <select class="sort-select" id="f-sort" onchange="applyFilters()">
                            <option value="created_at">Featured</option>
                            <option value="price_asc">Price: Low</option>
                            <option value="price_desc">Price: High</option>
                            <option value="rating">Top Rated</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="product-grid" id="product-grid">
                {{-- skeletons --}}
                @for($i = 0; $i < 9; $i++)
                    <div class="skeleton" style="height:360px;"></div>
                @endfor
            </div>

            <div class="pagination" id="pagination"></div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        /* ── State ── */
        let activeCatId = null;
        let activeBrands = new Set();
        let activeRating = null;
        let maxPrice = 2000000;
        let _dtimer;

        /* ── Debounce ── */
        function debounceFilter() { clearTimeout(_dtimer); _dtimer = setTimeout(() => applyFilters(1), 450); }

        /* ── Collapse sections ── */
        function toggleSection(id) {
            const body = document.getElementById('body-' + id);
            const tog = document.getElementById('tog-' + id);
            const vis = body.style.display !== 'none';
            body.style.display = vis ? 'none' : '';
            tog.textContent = vis ? '+' : '+';
            tog.classList.toggle('open', !vis);
        }

        /* ── Category ── */
        async function loadCategories() {
            try {
                const r = await axios.get(API + '/categories');
                const wrap = document.getElementById('cat-options');
                wrap.innerHTML = r.data.data.map(c => `
          <div class="filter-option" onclick="toggleCat(${c.id},this)" id="cat-opt-${c.id}">
            <div class="filter-checkbox" id="cb-cat-${c.id}"></div>
            <span class="filter-label">${c.name}</span>
            <span class="filter-count">(${c.products_count})</span>
          </div>`).join('');
            } catch { }
        }

        function toggleCat(catId, el) {
            /* uncheck all */
            document.querySelectorAll('[id^="cb-cat-"]').forEach(cb => cb.classList.remove('checked'));
            activeCatId = catId;
            const cbId = catId ? `cb-cat-${catId}` : 'cb-cat-all';
            document.getElementById(cbId)?.classList.add('checked');
            applyFilters(1);
        }

        /* ── Brand ── */
        async function loadBrands() {
            try {
                const r = await axios.get(GW + '/products?per_page=200');
                const products = r.data.data.data || [];
                const brands = [...new Set(products.map(p => p.brand).filter(Boolean))].slice(0, 6);
                const wrap = document.getElementById('brand-options');
                wrap.innerHTML = brands.map(b => `
          <div class="filter-option" onclick="toggleBrand('${b}',this)">
            <div class="filter-checkbox" id="cb-brand-${b.replace(/\s/g, '_')}"></div>
            <span class="filter-label">${b}</span>
          </div>`).join('') || '<p style="font-size:.8rem;color:var(--warm-gray)">Tidak ada brand</p>';
            } catch { document.getElementById('brand-options').innerHTML = ''; }
        }

        function toggleBrand(brand, el) {
            const cbId = 'cb-brand-' + brand.replace(/\s/g, '_');
            if (activeBrands.has(brand)) {
                activeBrands.delete(brand);
                document.getElementById(cbId)?.classList.remove('checked');
            } else {
                activeBrands.add(brand);
                document.getElementById(cbId)?.classList.add('checked');
            }
            applyFilters(1);
        }

        /* ── Price ── */
        function onPriceSlide(val) {
            maxPrice = Number(val);
            const label = val >= 2000000 ? 'Rp 2jt+' : formatRp(val);
            document.getElementById('price-max-label').textContent = label;
            debounceFilter();
        }

        /* ── Rating ── */
        function setRating(val, el) {
            activeRating = activeRating === val ? null : val;
            document.querySelectorAll('.rating-option').forEach(o => o.classList.remove('active'));
            if (activeRating) el.classList.add('active');
            applyFilters(1);
        }

        /* ── Main filter + fetch ── */
        async function applyFilters(page = 1) {
            const grid = document.getElementById('product-grid');
            grid.innerHTML = Array(9).fill(`<div class="skeleton" style="height:360px;"></div>`).join('');
            document.getElementById('pagination').innerHTML = '';

            const params = new URLSearchParams();
            const search = document.getElementById('f-search').value.trim();
            const sort = document.getElementById('f-sort').value;

            if (search) params.set('search', search);
            if (activeCatId) params.set('category_id', activeCatId);
            if (activeBrands.size) params.set('brand', [...activeBrands].join(','));
            if (maxPrice < 2000000) params.set('max_price', maxPrice);
            if (activeRating) params.set('min_rating', activeRating);
            if (sort === 'price_asc') { params.set('sort', 'price'); params.set('order', 'asc'); }
            else if (sort === 'price_desc') { params.set('sort', 'price'); params.set('order', 'desc'); }
            else if (sort === 'rating') { params.set('sort', 'reviews_avg_rating'); params.set('order', 'desc'); }
            else params.set('sort', 'created_at');
            params.set('page', page);
            params.set('per_page', 9);

            try {
                const r = await axios.get(GW + '/products?' + params.toString());
                const { data: products, total, last_page, current_page, from, to } = r.data.data;

                document.getElementById('showing-txt').textContent =
                    total ? `Showing ${from}–${to} of ${total} products` : '0 products found';

                if (!products.length) {
                    grid.innerHTML = `<p style="grid-column:1/-1;text-align:center;padding:4rem 0;color:var(--warm-gray);font-size:.9rem;">No products found. Try adjusting your filters.</p>`;
                    return;
                }

                const badgeMap = ['badge-trending', 'badge-new', 'badge-limited', '', 'badge-new', ''];
                const badgeLbl = ['Trending', 'New', 'Limited', '', 'New', ''];

                grid.innerHTML = products.map((p, i) => {
                    const stars = Math.round(p.reviews_avg_rating || 0);
                    const rating = p.reviews_avg_rating ? Number(p.reviews_avg_rating).toFixed(1) : '—';
                    const reviews = p.reviews_count || 0;
                    const img = p.image || `https://via.placeholder.com/400x260?text=${encodeURIComponent(p.name)}`;
                    const brand = p.brand || p.category?.name || '';
                    const bClass = badgeMap[i % 6];
                    const bLabel = badgeLbl[i % 6];

                    return `
            <div class="product-card" onclick="window.location='/product/${p.id}'">
              <div class="product-card-img">
                <img src="${img}" alt="${p.name}" loading="lazy"
                     onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                ${bLabel ? `<span class="card-badge ${bClass}">${bLabel}</span>` : ''}
                <button class="card-wishlist"
                        onclick="event.stopPropagation();addWishlist(${p.id})"
                        title="Save to wishlist">
                  <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                  </svg>
                </button>
              </div>
              <div class="product-card-body">
                ${brand ? `<div class="card-brand">${brand}</div>` : ''}
                <div class="card-name">${p.name}</div>
                <div class="card-stars">
                  <span class="stars">${'★'.repeat(stars)}${'☆'.repeat(5 - stars)}</span>
                  <span class="review-count">(${reviews})</span>
                </div>
                <div class="card-price">${formatRp(p.price)}</div>
              </div>
            </div>`;
                }).join('');

                renderPagination(current_page, last_page);
            } catch (e) {
                grid.innerHTML = `<p style="grid-column:1/-1;text-align:center;padding:4rem 0;color:var(--warm-gray);">Gagal memuat produk.</p>`;
            }
        }

        /* ── Pagination ── */
        function renderPagination(cur, last) {
            if (last <= 1) { document.getElementById('pagination').innerHTML = ''; return; }

            let pages = [];
            pages.push(`<button class="page-btn arrow" onclick="applyFilters(${Math.max(1, cur - 1)})" ${cur === 1 ? 'disabled style="opacity:.35;pointer-events:none"' : ''}>‹</button>`);

            const range = [];
            range.push(1);
            if (cur > 3) range.push('…');
            for (let i = Math.max(2, cur - 1); i <= Math.min(last - 1, cur + 1); i++) range.push(i);
            if (cur < last - 2) range.push('…');
            if (last > 1) range.push(last);

            range.forEach(p => {
                if (p === '…') pages.push(`<button class="page-btn ellipsis">…</button>`);
                else pages.push(`<button class="page-btn ${p === cur ? 'active' : ''}" onclick="applyFilters(${p})">${p}</button>`);
            });

            pages.push(`<button class="page-btn arrow" onclick="applyFilters(${Math.min(last, cur + 1)})" ${cur === last ? 'disabled style="opacity:.35;pointer-events:none"' : ''}>›</button>`);

            document.getElementById('pagination').innerHTML = pages.join('');
        }

        /* ── Wishlist ── */
        function addWishlist(id) {
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

        /* ── Init ── */
        loadCategories();
        loadBrands();
        applyFilters();
    </script>
@endsection
