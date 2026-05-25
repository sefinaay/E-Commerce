@extends('frontend.layout')
@section('title', 'Discover - GlowMart')
@section('head')
    <style>
        .discover-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .discover-hero {
            text-align: center;
            padding: 3rem 1rem;
            background: linear-gradient(135deg, var(--soft), #fce4ec);
            border-radius: 16px;
            margin-bottom: 2rem;
        }

        .discover-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: .5rem;
        }

        .discover-hero p {
            color: #666;
        }

        .api-badge {
            display: inline-block;
            background: var(--gold);
            color: white;
            padding: .25rem .75rem;
            border-radius: 50px;
            font-size: .75rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-row select,
        .filter-row input {
            padding: .6rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: .85rem;
            background: white;
        }

        .ext-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .ext-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: .2s;
        }

        .ext-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .1);
        }

        .ext-card img {
            width: 100%;
            height: 180px;
            object-fit: contain;
            padding: 1rem;
            background: #f9f9f9;
        }

        .ext-info {
            padding: 1rem;
        }

        .ext-brand {
            font-size: .7rem;
            color: var(--gold);
            font-weight: 600;
            text-transform: uppercase;
        }

        .ext-name {
            font-size: .9rem;
            font-weight: 500;
            margin: .2rem 0;
        }

        .ext-price {
            color: var(--rose);
            font-weight: 600;
        }

        .ext-rating {
            font-size: .8rem;
            color: #f59e0b;
        }
    </style>
@endsection
@section('content')
    <div class="discover-wrap">
        <div class="discover-hero">
            <div class="api-badge">🌐 Powered by Makeup API</div>
            <h1>Discover Produk Global</h1>
            <p>Jelajahi ribuan produk makeup dari seluruh dunia via Makeup API (makeup-api.herokuapp.com)</p>
        </div>

        <div class="filter-row">
            <select id="d-brand" onchange="discoverSearch()">
                <option value="">Semua Brand</option>
            </select>
            <select id="d-type" onchange="discoverSearch()">
                <option value="">Semua Tipe</option>
                <option value="lipstick">Lipstick</option>
                <option value="foundation">Foundation</option>
                <option value="eyeshadow">Eyeshadow</option>
                <option value="blush">Blush</option>
                <option value="mascara">Mascara</option>
                <option value="bronzer">Bronzer</option>
                <option value="eyeliner">Eyeliner</option>
                <option value="lip_liner">Lip Liner</option>
            </select>
            <button class="btn btn-primary" onclick="discoverSearch()">Cari</button>
        </div>

        <div class="ext-grid" id="ext-grid">
            <p style="color:#999">Memuat dari Makeup API...</p>
        </div>

        <div style="background:var(--soft);border-radius:12px;padding:1.5rem;margin-top:2rem;font-size:.85rem;color:#666;">
            <strong>ℹ️ Tentang Integrasi API</strong><br>
            Data di atas berasal langsung dari <strong>Makeup API (makeup-api.herokuapp.com)</strong> — sebuah REST API
            publik gratis untuk data produk makeup global. Data diambil real-time dan di-cache selama 5 menit.
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        async function loadBrands() {
            try {
                const r = await axios.get(API + '/external/makeup/brands');
                const sel = document.getElementById('d-brand');
                r.data.data.slice(0, 30).forEach(b => sel.innerHTML += `<option value="${b}">${b}</option>`);
            } catch { }
        }

        async function discoverSearch() {
            const brand = document.getElementById('d-brand').value;
            const type = document.getElementById('d-type').value;
            const grid = document.getElementById('ext-grid');
            grid.innerHTML = '<p style="color:#999">Memuat dari API eksternal...</p>';

            try {
                const params = new URLSearchParams();
                if (brand) params.set('brand', brand);
                if (type) params.set('product_type', type);

                const r = await axios.get(API + '/external/makeup/search?' + params.toString());
                const products = r.data.data;

                if (!products.length) { grid.innerHTML = '<p style="color:#999;grid-column:1/-1">Tidak ada produk ditemukan</p>'; return; }

                grid.innerHTML = products.map(p => `
          <div class="ext-card">
            <img src="${p.image_link || 'https://via.placeholder.com/200x180?text=Makeup'}" alt="${p.name}" onerror="this.src='https://via.placeholder.com/200x180?text=Makeup'">
            <div class="ext-info">
              <div class="ext-brand">${p.brand || ''}</div>
              <div class="ext-name">${p.name}</div>
              <div class="ext-price">${p.price ? '$' + p.price : 'N/A'}</div>
              <div class="ext-rating">${p.rating ? '★ ' + p.rating : '—'}</div>
              <a href="${p.source_url || '#'}" target="_blank"><button class="btn btn-outline" style="width:100%;margin-top:.5rem;font-size:.75rem">Lihat Asli ↗</button></a>
            </div>
          </div>`).join('');
            } catch (e) {
                grid.innerHTML = '<p style="color:#e53e3e;grid-column:1/-1">Gagal memuat dari API eksternal. Coba lagi nanti.</p>';
            }
        }

        loadBrands();
        discoverSearch();
    </script>
@endsection