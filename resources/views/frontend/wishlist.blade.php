@extends('frontend.layout')
@section('title', 'Wishlist — GlowMart')

@section('head')
    <style>
        .wishlist-page {
            max-width: 1280px;
            margin: 0 auto;
            padding: 48px 48px 80px;
        }

        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 40px;
        }

        .wishlist-title {
            font-family: var(--font-serif);
            font-size: 40px;
            font-weight: 400;
            color: var(--dark);
        }

        .wishlist-count {
            font-family: var(--font-sans);
            font-size: 13px;
            color: var(--muted);
        }

        .btn-clear-wish {
            font-family: var(--font-sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            background: none;
            border: none;
            cursor: pointer;
            transition: color .2s;
        }

        .btn-clear-wish:hover {
            color: #e53e3e;
        }

        /* Grid */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        @media (max-width: 1024px) {
            .wishlist-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .wishlist-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .wishlist-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card */
        .wish-card {
            background: white;
            border: 1px solid var(--border-pink);
            border-radius: 16px;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            position: relative;
        }

        .wish-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(255, 176, 193, .2);
        }

        .wish-card-img-wrap {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: var(--pink-light);
            cursor: pointer;
        }

        .wish-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }

        .wish-card:hover .wish-card-img {
            transform: scale(1.05);
        }

        .btn-remove-wish {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            color: var(--pink);
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            transition: all .2s;
            z-index: 2;
        }

        .btn-remove-wish:hover {
            background: #fff5f5;
            color: #e53e3e;
            transform: scale(1.1);
        }

        .wish-card-body {
            padding: 16px;
        }

        .wish-brand {
            font-family: var(--font-sans);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 5px;
        }

        .wish-name {
            font-family: var(--font-serif);
            font-size: 17px;
            font-weight: 400;
            color: var(--dark);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .wish-price {
            font-family: var(--font-sans);
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 14px;
        }

        .btn-wish-add {
            width: 100%;
            padding: 11px;
            background: var(--pink);
            color: white;
            border: none;
            border-radius: 50px;
            font-family: var(--font-sans);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-wish-add:hover {
            background: #ff8fa8;
            box-shadow: 0 6px 16px rgba(255, 176, 193, .4);
        }

        /* Empty state */
        .wishlist-empty {
            text-align: center;
            padding: 80px 24px;
            grid-column: 1 / -1;
        }

        .wishlist-empty-icon {
            font-size: 56px;
            margin-bottom: 20px;
        }

        .wishlist-empty-title {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 400;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .wishlist-empty-text {
            font-family: var(--font-sans);
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 32px;
            line-height: 1.7;
        }

        .btn-shop-now {
            padding: 14px 40px;
            background: var(--dark);
            color: white;
            border: none;
            border-radius: 50px;
            font-family: var(--font-sans);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-shop-now:hover {
            background: #333;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .wishlist-page {
                padding: 32px 20px 60px;
            }

            .wishlist-title {
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wishlist-page">
        <div class="wishlist-header">
            <div>
                <h1 class="wishlist-title">My Wishlist</h1>
                <p class="wishlist-count" id="wish-count"></p>
            </div>
            <button class="btn-clear-wish" onclick="clearWishlist()">Clear All</button>
        </div>

        <div class="wishlist-grid" id="wishlist-grid">
            <p style="font-family:var(--font-sans);color:var(--muted)">Loading...</p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // ── Wishlist pakai localStorage ──────────────────────────
        function getWishlist() {
            try {
                const raw = localStorage.getItem('gm_wishlist') || '[]';
                return JSON.parse(raw).map(id => Number(id));
            } catch { return []; }
        }
        function saveWishlist(items) {
            localStorage.setItem('gm_wishlist', JSON.stringify(items));
        }

        // ── Render ───────────────────────────────────────────────
        async function renderWishlist() {
            const ids = getWishlist();
            const grid = document.getElementById('wishlist-grid');
            const count = document.getElementById('wish-count');

            if (!ids.length) {
                count.textContent = '0 items';
                grid.innerHTML = `
                <div class="wishlist-empty">
                    <div class="wishlist-empty-icon">🤍</div>
                    <h2 class="wishlist-empty-title">Your wishlist is empty</h2>
                    <p class="wishlist-empty-text">
                        Save your favourite products here and come back when you're ready to treat yourself.
                    </p>
                    <a href="/shop" class="btn-shop-now">Start Shopping</a>
                </div>`;
                return;
            }

            count.textContent = `${ids.length} item${ids.length > 1 ? 's' : ''}`;
            grid.innerHTML = ids.map(() =>
                `<div class="skeleton" style="height:320px;border-radius:16px"></div>`
            ).join('');

            // Fetch detail produk satu per satu
            const products = await Promise.all(
                ids.map(id =>
                    axios.get(`/api/products/${id}`)
                        .then(r => r.data.data)
                        .catch(() => null)
                )
            );

            const valid = products.filter(Boolean);

            if (!valid.length) {
                saveWishlist([]); // bersihkan ID yang tidak valid
                renderWishlist();
                return;
            }

            grid.innerHTML = valid.map(p => `
            <div class="wish-card" id="wc-${p.id}">
                <div class="wish-card-img-wrap" onclick="window.location='/product/${p.id}'">
                    <img class="wish-card-img"
                         src="${p.image || '/img/placeholder.svg'}"
                         alt="${p.name}"
                         onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                    <button class="btn-remove-wish"
                            onclick="event.stopPropagation();removeFromWishlist(${p.id})"
                            title="Remove from wishlist">♥</button>
                </div>
                <div class="wish-card-body">
                    <div class="wish-brand">${p.brand || p.category?.name || 'GlowMart'}</div>
                    <div class="wish-name">${p.name}</div>
                    <div class="wish-price">${formatRp(p.price)}</div>
                    <button class="btn-wish-add" onclick="addToCartFromWish(${p.id})">
                        Add to Bag
                    </button>
                </div>
            </div>`).join('');
        }

        // ── Actions ──────────────────────────────────────────────
        function removeFromWishlist(id) {
            const items = getWishlist().filter(i => i !== id);
            saveWishlist(items);

            // Animasi hapus
            const card = document.getElementById(`wc-${id}`);
            if (card) {
                card.style.transition = 'all .3s';
                card.style.opacity = '0';
                card.style.transform = 'scale(.95)';
                setTimeout(() => renderWishlist(), 300);
            }
            toast('Removed from wishlist', '');
            updateWishBadge();
        }

        function clearWishlist() {
            if (!confirm('Clear your entire wishlist?')) return;
            saveWishlist([]);
            renderWishlist();
            updateWishBadge();
            toast('Wishlist cleared', '');
        }

        async function addToCartFromWish(productId) {
            if (!getUser()) {
                toast('Please sign in to add items to your bag', 'error');
                window.location.href = '/login';
                return;
            }
            try {
                await axios.post('/api/cart/add', { product_id: productId, quantity: 1 });
                toast('Added to your bag ✓', 'success');
                updateCartBadge();
            } catch (e) {
                toast(e.response?.data?.message || 'Failed to add', 'error');
            }
        }

        function updateWishBadge() {
            const count = getWishlist().length;
            // Update badge di navbar kalau ada
            const badge = document.getElementById('wish-badge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count ? 'flex' : 'none';
            }
        }

        // ── Init ─────────────────────────────────────────────────
        renderWishlist();
    </script>
@endsection
