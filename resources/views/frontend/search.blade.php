@extends('frontend.layout')
@section('title', 'Search — GlowMart')

@section('head')
    <style>
        .search-page {
            max-width: 1280px;
            margin: 0 auto;
            padding: 48px 48px 80px;
        }

        .search-hero {
            text-align: center;
            padding: 48px 0 40px;
        }

        .search-hero-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 40px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 24px;
        }

        /* Search bar besar */
        .search-bar-wrap {
            max-width: 600px;
            margin: 0 auto 48px;
            position: relative;
        }

        .search-bar-input {
            width: 100%;
            padding: 18px 56px 18px 24px;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-family: var(--font-sans, 'Jost', sans-serif);
            font-size: 15px;
            color: var(--charcoal);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: white;
        }

        .search-bar-input:focus {
            border-color: var(--rose);
            box-shadow: 0 0 0 4px rgba(200, 80, 106, .08);
        }

        .search-bar-input::placeholder {
            color: #bbb;
        }

        .search-bar-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--charcoal);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s;
            color: white;
        }

        .search-bar-btn:hover {
            background: var(--rose);
        }

        /* Suggestions */
        .search-suggestions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 40px;
        }

        .suggestion-chip {
            padding: 6px 16px;
            border-radius: 50px;
            border: 1.5px solid var(--border);
            background: white;
            font-family: var(--font-sans, 'Jost', sans-serif);
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            color: var(--charcoal-mid);
            transition: all .2s;
        }

        .suggestion-chip:hover {
            background: var(--charcoal);
            color: white;
            border-color: var(--charcoal);
        }

        /* Results header */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-light);
        }

        .results-count {
            font-family: var(--font-sans, 'Jost', sans-serif);
            font-size: 13px;
            color: var(--warm-gray);
        }

        .results-count strong {
            color: var(--charcoal);
        }

        /* Grid */
        .search-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        @media (max-width: 1024px) {
            .search-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .search-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Product card */
        .search-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
        }

        .search-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(200, 80, 106, .12);
        }

        .search-card-img {
            height: 200px;
            overflow: hidden;
            background: var(--soft-bg);
        }

        .search-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }

        .search-card:hover .search-card-img img {
            transform: scale(1.05);
        }

        .search-card-body {
            padding: 14px 16px;
        }

        .search-card-brand {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 4px;
        }

        .search-card-name {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 15px;
            color: var(--charcoal);
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .search-card-price {
            font-size: 14px;
            font-weight: 600;
            color: var(--charcoal);
        }

        /* Empty & initial state */
        .search-empty {
            text-align: center;
            padding: 60px 24px;
            grid-column: 1/-1;
        }

        .search-empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .search-empty-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 24px;
            color: var(--charcoal);
            margin-bottom: 8px;
        }

        .search-empty-text {
            font-size: 13px;
            color: var(--warm-gray);
        }

        /* Skeleton */
        .sk {
            background: linear-gradient(90deg, #f5e6eb 25%, #fce9ef 50%, #f5e6eb 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0
            }

            100% {
                background-position: -200% 0
            }
        }

        @media (max-width: 768px) {
            .search-page {
                padding: 24px 20px 60px;
            }

            .search-hero-title {
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="search-page">
        <div class="search-hero">
            <h1 class="search-hero-title">Find Your Glow</h1>
        </div>

        {{-- Search Bar --}}
        <div class="search-bar-wrap">
            <input class="search-bar-input" type="text" id="search-input" placeholder="Search products, brands..."
                autofocus>
            <button class="search-bar-btn" onclick="doSearch()">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
            </button>
        </div>

        {{-- Suggestions --}}
        <div class="search-suggestions">
            <span class="suggestion-chip" onclick="searchFor('Serum')">Serum</span>
            <span class="suggestion-chip" onclick="searchFor('Lipstick')">Lipstick</span>
            <span class="suggestion-chip" onclick="searchFor('Foundation')">Foundation</span>
            <span class="suggestion-chip" onclick="searchFor('Maybelline')">Maybelline</span>
            <span class="suggestion-chip" onclick="searchFor('NYX')">NYX</span>
            <span class="suggestion-chip" onclick="searchFor('Mascara')">Mascara</span>
            <span class="suggestion-chip" onclick="searchFor('Eyeshadow')">Eyeshadow</span>
            <span class="suggestion-chip" onclick="searchFor('Blush')">Blush</span>
        </div>

        {{-- Results --}}
        <div id="results-header" class="results-header" style="display:none">
            <span class="results-count" id="results-count"></span>
        </div>

        <div class="search-grid" id="search-grid">
            <div class="search-empty">
                <h2 class="search-empty-title">Search for beauty products</h2>
                <p class="search-empty-text">Try searching for a product name, brand, or category</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Ambil query dari URL kalau ada (?search=xxx)
        const urlParams = new URLSearchParams(window.location.search);
        const initialQuery = urlParams.get('search') || '';
        if (initialQuery) {
            document.getElementById('search-input').value = initialQuery;
            doSearch();
        }

        // Enter key
        document.getElementById('search-input').addEventListener('keydown', e => {
            if (e.key === 'Enter') doSearch();
        });

        // Input debounce
        let _timer;
        document.getElementById('search-input').addEventListener('input', () => {
            clearTimeout(_timer);
            _timer = setTimeout(() => {
                const val = document.getElementById('search-input').value.trim();
                if (val.length >= 2) doSearch();
                if (val.length === 0) resetSearch();
            }, 400);
        });

        function searchFor(term) {
            document.getElementById('search-input').value = term;
            doSearch();
        }

        async function doSearch() {
            const query = document.getElementById('search-input').value.trim();
            if (!query) { resetSearch(); return; }

            // Update URL tanpa reload
            history.replaceState(null, '', `/search?search=${encodeURIComponent(query)}`);

            const grid = document.getElementById('search-grid');
            grid.innerHTML = Array(8).fill(
                `<div>
                <div class="sk" style="height:200px;border-radius:16px 16px 0 0"></div>
                <div style="padding:14px 16px;border:1px solid #f5e6eb;border-top:none;border-radius:0 0 16px 16px">
                    <div class="sk" style="height:10px;width:40%;margin-bottom:8px"></div>
                    <div class="sk" style="height:16px;width:80%;margin-bottom:8px"></div>
                    <div class="sk" style="height:14px;width:30%"></div>
                </div>
            </div>`
            ).join('');

            document.getElementById('results-header').style.display = 'flex';
            document.getElementById('results-count').innerHTML = `Searching for <strong>"${query}"</strong>...`;

            try {
                const r = await axios.get(`/gateway/products?search=${encodeURIComponent(query)}&per_page=12`);
                const products = r.data.data?.data || [];
                const total = r.data.data?.total || 0;

                document.getElementById('results-count').innerHTML =
                    `<strong>${total}</strong> result${total !== 1 ? 's' : ''} for "<strong>${query}</strong>"`;

                if (!products.length) {
                    grid.innerHTML = `
                    <div class="search-empty">
                        <h2 class="search-empty-title">No results found</h2>
                        <p class="search-empty-text">Try a different keyword or browse our <a href="/shop" style="color:var(--rose)">full collection</a></p>
                    </div>`;
                    return;
                }

                grid.innerHTML = products.map(p => `
                <div class="search-card" onclick="window.location='/product/${p.id}'">
                    <div class="search-card-img">
                        <img src="${p.image || '/img/placeholder.svg'}"
                             alt="${p.name}"
                             onerror="this.onerror=null;this.src='/img/placeholder.svg'"
                             loading="lazy">
                    </div>
                    <div class="search-card-body">
                        <div class="search-card-brand">${p.brand || p.category?.name || ''}</div>
                        <div class="search-card-name">${p.name}</div>
                        <div class="search-card-price">${formatRp(p.price)}</div>
                    </div>
                </div>`).join('');

            } catch (e) {
                grid.innerHTML = `
                <div class="search-empty">
                    <div class="search-empty-icon">⚠️</div>
                    <h2 class="search-empty-title">Something went wrong</h2>
                    <p class="search-empty-text">Failed to load results. Please try again.</p>
                </div>`;
            }
        }

        function resetSearch() {
            history.replaceState(null, '', '/search');
            document.getElementById('results-header').style.display = 'none';
            document.getElementById('search-grid').innerHTML = `
            <div class="search-empty">
                <h2 class="search-empty-title">Search for beauty products</h2>
                <p class="search-empty-text">Try searching for a product name, brand, or category</p>
            </div>`;
        }
    </script>
@endsection
