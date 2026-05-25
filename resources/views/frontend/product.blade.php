@extends('frontend.layout')
@section('title', 'Detail Produk - GlowMart')
@section('head')
    <style>
        .product-wrap {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .product-img {
            width: 100%;
            border-radius: 12px;
            object-fit: cover;
            max-height: 400px;
        }

        .product-brand {
            font-size: .8rem;
            color: var(--gold);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .product-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            margin: .5rem 0;
        }

        .product-price {
            color: var(--rose);
            font-size: 1.8rem;
            font-weight: 700;
            margin: 1rem 0;
        }

        .product-desc {
            color: #666;
            line-height: 1.7;
            font-size: .9rem;
            margin-bottom: 1.5rem;
        }

        .stock-badge {
            display: inline-block;
            padding: .25rem .75rem;
            border-radius: 50px;
            font-size: .75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .qty-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .qty-input {
            width: 60px;
            text-align: center;
            padding: .5rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
        }

        .reviews-section {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
        }

        .review-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-stars {
            color: #f59e0b;
        }
    </style>
@endsection
@section('content')
    <div class="product-wrap">
        <div class="product-detail" id="product-detail">
            <p style="color:#999">Memuat...</p>
        </div>
        <div class="reviews-section">
            <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;margin-bottom:1rem">Ulasan Produk</h3>
            <div id="review-form-wrap"
                style="background:var(--soft);border-radius:12px;padding:1.5rem;margin-bottom:1.5rem;display:none">
                <h4 style="margin-bottom:1rem">Tulis Ulasan</h4>
                <div style="margin-bottom:.75rem">
                    <label
                        style="font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem">Rating</label>
                    <select id="r-rating"
                        style="padding:.5rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit">
                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4">⭐⭐⭐⭐ (4)</option>
                        <option value="3">⭐⭐⭐ (3)</option>
                        <option value="2">⭐⭐ (2)</option>
                        <option value="1">⭐ (1)</option>
                    </select>
                </div>
                <div><textarea id="r-comment"
                        style="width:100%;padding:.7rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;resize:none"
                        rows="3" placeholder="Ceritakan pengalaman Anda..."></textarea></div>
                <button class="btn btn-primary" style="margin-top:.75rem" onclick="submitReview()">Kirim Ulasan</button>
            </div>
            <div id="reviews-list"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const productId = {{ $id }};
        let productData = null;

        async function loadProduct() {
            const r = await axios.get(GW + '/products/' + productId);
            const p = r.data.data;
            productData = p;

            const stockColor = p.stock > 10 ? '#D4EDDA' : p.stock > 0 ? '#FFF3CD' : '#F8D7DA';
            const stockText = p.stock > 0 ? `Stok: ${p.stock}` : 'Habis';

            document.getElementById('product-detail').innerHTML = `
        <img class="product-img" src="${p.image || 'https://via.placeholder.com/400?text=Makeup'}" alt="${p.name}" onerror="this.src='https://via.placeholder.com/400?text=Makeup'">
        <div>
          <div class="product-brand">${p.brand || p.category?.name || ''}</div>
          <h1 class="product-title">${p.name}</h1>
          <div style="color:#f59e0b;margin:.5rem 0">${'★'.repeat(Math.round(p.reviews_avg_rating || 0))}${'☆'.repeat(5 - Math.round(p.reviews_avg_rating || 0))} <span style="color:#999;font-size:.85rem">(${p.reviews_avg_rating ? Number(p.reviews_avg_rating).toFixed(1) : 'Belum ada ulasan'})</span></div>
          <div class="product-price">${formatRp(p.price)}</div>
          <span class="stock-badge" style="background:${stockColor};color:${p.stock > 10 ? '#155724' : p.stock > 0 ? '#856404' : '#721C24'}">${stockText}</span>
          <p class="product-desc">${p.description || 'Produk makeup berkualitas tinggi.'}</p>
          <div class="qty-wrap">
            <button class="btn btn-outline" onclick="document.getElementById('qty').value=Math.max(1,+document.getElementById('qty').value-1)">−</button>
            <input class="qty-input" id="qty" type="number" value="1" min="1" max="${p.stock}">
            <button class="btn btn-outline" onclick="document.getElementById('qty').value=Math.min(${p.stock},+document.getElementById('qty').value+1)">+</button>
          </div>
          <button class="btn btn-primary" style="padding:.8rem 2rem;font-size:1rem" onclick="addToCart()" ${p.stock === 0 ? 'disabled' : ''}>🛒 Tambah ke Keranjang</button>
        </div>`;

            loadReviews();
            if (getUser()) document.getElementById('review-form-wrap').style.display = 'block';
        }

        async function addToCart() {
            const user = getUser();
            if (!user) { toast('Silakan login dulu', 'error'); window.location.href = '/login'; return; }
            const qty = +document.getElementById('qty').value;
            try {
                await axios.post(API + '/cart/add', { product_id: productId, quantity: qty });
                toast('Ditambahkan ke keranjang ✓', 'success');
                updateCartBadge();
            } catch (e) { toast(e.response?.data?.message || 'Gagal', 'error'); }
        }

        async function loadReviews() {
            const r = await axios.get(API + '/products/' + productId + '/reviews');
            const reviews = r.data.data;
            if (!reviews.length) { document.getElementById('reviews-list').innerHTML = '<p style="color:#999;font-size:.85rem">Belum ada ulasan. Jadilah yang pertama!</p>'; return; }
            document.getElementById('reviews-list').innerHTML = reviews.map(rv => `
        <div class="review-item">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <strong>${rv.user?.name}</strong>
            <span class="review-stars">${'★'.repeat(rv.rating)}${'☆'.repeat(5 - rv.rating)}</span>
          </div>
          <p style="color:#666;font-size:.85rem;margin-top:.25rem">${rv.comment || ''}</p>
          <p style="color:#bbb;font-size:.75rem">${new Date(rv.created_at).toLocaleDateString('id-ID')}</p>
        </div>`).join('');
        }

        async function submitReview() {
            try {
                await axios.post(API + '/products/' + productId + '/reviews', {
                    rating: document.getElementById('r-rating').value,
                    comment: document.getElementById('r-comment').value,
                });
                toast('Ulasan berhasil dikirim ✓', 'success');
                document.getElementById('r-comment').value = '';
                loadReviews();
            } catch (e) { toast(e.response?.data?.message || 'Gagal kirim ulasan', 'error'); }
        }

        loadProduct();
    </script>
@endsection