@extends('frontend.layout')
@section('title', 'Admin - GlowMart')
@section('head')
    <style>
        .admin-wrap {
            max-width: 1200px;
            margin: 1rem auto;
            padding: 0 1rem;
        }

        .admin-tabs {
            display: flex;
            gap: .5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
            padding-bottom: 0;
        }

        .tab-btn {
            padding: .6rem 1.25rem;
            border: none;
            background: transparent;
            cursor: pointer;
            font-family: inherit;
            font-size: .9rem;
            color: #666;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: .2s;
        }

        .tab-btn.active {
            color: var(--rose);
            border-bottom-color: var(--rose);
            font-weight: 500;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            color: var(--rose);
            font-weight: 600;
        }

        .stat-label {
            font-size: .8rem;
            color: #999;
            margin-top: .25rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .data-table th {
            background: var(--soft);
            padding: .75rem 1rem;
            text-align: left;
            font-size: .8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #666;
        }

        .data-table td {
            padding: .75rem 1rem;
            font-size: .85rem;
            border-bottom: 1px solid var(--border);
        }

        .status-badge {
            padding: .2rem .6rem;
            border-radius: 50px;
            font-size: .7rem;
            font-weight: 600;
        }

        .s-pending {
            background: #FFF3CD;
            color: #856404;
        }

        .s-processing {
            background: #CCE5FF;
            color: #004085;
        }

        .s-shipped {
            background: #D1ECF1;
            color: #0C5460;
        }

        .s-delivered {
            background: #D4EDDA;
            color: #155724;
        }

        .s-cancelled {
            background: #F8D7DA;
            color: #721C24;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-input {
            width: 100%;
            padding: .6rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: .85rem;
            margin-top: .25rem;
        }
    </style>
@endsection
@section('content')
    <div class="admin-wrap">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h1 style="font-family:'Cormorant Garamond',serif;font-size:2rem">⚙️ Admin Panel</h1>
            <span id="admin-check" style="font-size:.85rem;color:#999"></span>
        </div>

        <div class="admin-tabs">
            <button class="tab-btn active" onclick="showTab('dashboard')">Dashboard</button>
            <button class="tab-btn" onclick="showTab('orders')">Pesanan</button>
            <button class="tab-btn" onclick="showTab('products')">Produk</button>
            <button class="tab-btn" onclick="showTab('users')">Pengguna</button>
            <button class="tab-btn" onclick="showTab('import')">Import Makeup API</button>
        </div>

        <!-- DASHBOARD -->
        <div class="tab-content active" id="tab-dashboard">
            <div class="stat-grid" id="stats"></div>
            <h3 style="margin-bottom:1rem">Pesanan Terbaru</h3>
            <table class="data-table" id="recent-orders-table">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody id="recent-orders"></tbody>
            </table>
        </div>

        <!-- ORDERS -->
        <div class="tab-content" id="tab-orders">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
                <h3>Semua Pesanan</h3>
                <button class="btn btn-outline" onclick="loadAllOrders()">Refresh</button>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="all-orders"></tbody>
            </table>
        </div>

        <!-- PRODUCTS -->
        <div class="tab-content" id="tab-products">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
                <h3>Manajemen Produk</h3>
                <button class="btn btn-primary" onclick="showProductForm()">+ Produk Baru</button>
            </div>
            <div id="product-form-container"
                style="display:none;background:white;border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-bottom:1.5rem">
                <h4 style="margin-bottom:1rem">Tambah/Edit Produk</h4>
                <div class="form-row">
                    <div><label style="font-size:.8rem;font-weight:600;color:#666">Nama Produk</label><input
                            class="form-input" id="pf-name" placeholder="Nama produk"></div>
                    <div><label style="font-size:.8rem;font-weight:600;color:#666">Brand</label><input class="form-input"
                            id="pf-brand" placeholder="Brand"></div>
                </div>
                <div class="form-row" style="margin-top:.75rem">
                    <div><label style="font-size:.8rem;font-weight:600;color:#666">Harga (Rp)</label><input
                            class="form-input" id="pf-price" type="number" placeholder="0"></div>
                    <div><label style="font-size:.8rem;font-weight:600;color:#666">Stok</label><input class="form-input"
                            id="pf-stock" type="number" placeholder="0"></div>
                </div>
                <div style="margin-top:.75rem">
                    <label style="font-size:.8rem;font-weight:600;color:#666">Kategori</label>
                    <select class="form-input" id="pf-cat"></select>
                </div>
                <div style="margin-top:.75rem">
                    <label style="font-size:.8rem;font-weight:600;color:#666">URL Gambar</label>
                    <input class="form-input" id="pf-image" placeholder="https://...">
                </div>
                <div style="margin-top:.75rem">
                    <label style="font-size:.8rem;font-weight:600;color:#666">Deskripsi</label>
                    <textarea class="form-input" id="pf-desc" rows="3" style="resize:none"
                        placeholder="Deskripsi produk..."></textarea>
                </div>
                <div style="display:flex;gap:.5rem;margin-top:1rem">
                    <button class="btn btn-primary" onclick="saveProduct()">Simpan</button>
                    <button class="btn btn-outline"
                        onclick="document.getElementById('product-form-container').style.display='none'">Batal</button>
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="admin-products"></tbody>
            </table>
        </div>

        <!-- USERS -->
        <div class="tab-content" id="tab-users">
            <h3 style="margin-bottom:1rem">Semua Pengguna</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>HP</th>
                        <th>Bergabung</th>
                    </tr>
                </thead>
                <tbody id="admin-users"></tbody>
            </table>
        </div>

        <!-- IMPORT -->
        <div class="tab-content" id="tab-import">
            <div style="background:white;border:1px solid var(--border);border-radius:12px;padding:2rem;max-width:500px">
                <h3 style="margin-bottom:1rem">Import dari Makeup API</h3>
                <p style="font-size:.85rem;color:#666;margin-bottom:1.5rem">Import produk langsung dari
                    makeup-api.herokuapp.com ke database lokal.</p>
                <div style="margin-bottom:1rem">
                    <label
                        style="font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem">Brand</label>
                    <input class="form-input" id="imp-brand" placeholder="Maybelline, NYX, Revlon, Covergirl...">
                </div>
                <div style="margin-bottom:1rem">
                    <label style="font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem">Kategori
                        Tujuan</label>
                    <select class="form-input" id="imp-cat"></select>
                </div>
                <button class="btn btn-primary" onclick="importFromApi()" style="width:100%">Import Sekarang (maks 10
                    produk)</button>
                <div id="import-result" style="margin-top:1rem;font-size:.85rem;color:#2E7D32"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showTab(name) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + name).classList.add('active');
            event.target.classList.add('active');
            if (name === 'orders') loadAllOrders();
            if (name === 'products') loadAdminProducts();
            if (name === 'users') loadUsers();
        }

        async function checkAdmin() {
            const user = getUser();
            if (!user || user.role !== 'admin') {
                document.querySelector('.admin-wrap').innerHTML = '<div style="text-align:center;padding:3rem"><h2 style="color:#e53e3e">🚫 Akses Ditolak</h2><p style="margin:.5rem 0;color:#666">Halaman ini hanya untuk admin.</p><a href="/"><button class="btn btn-primary">Kembali ke Beranda</button></a></div>';
                return;
            }
            document.getElementById('admin-check').textContent = 'Login sebagai: ' + user.name;
            loadDashboard();
            loadCategoriesForForm();
        }

        async function loadDashboard() {
            const r = await axios.get(API + '/admin/dashboard');
            const d = r.data.data;
            document.getElementById('stats').innerHTML = `
        <div class="stat-card"><div class="stat-num">${d.total_users}</div><div class="stat-label">Total Customer</div></div>
        <div class="stat-card"><div class="stat-num">${d.total_products}</div><div class="stat-label">Total Produk</div></div>
        <div class="stat-card"><div class="stat-num">${d.total_orders}</div><div class="stat-label">Total Pesanan</div></div>
        <div class="stat-card"><div class="stat-num">${formatRp(d.total_revenue)}</div><div class="stat-label">Total Revenue</div></div>`;
            document.getElementById('recent-orders').innerHTML = d.recent_orders.map(o => `
        <tr>
          <td style="font-family:monospace">${o.order_number}</td>
          <td>${o.user?.name}</td>
          <td style="color:var(--rose);font-weight:600">${formatRp(o.total)}</td>
          <td><span class="status-badge s-${o.status}">${o.status}</span></td>
          <td style="color:#999">${new Date(o.created_at).toLocaleDateString('id-ID')}</td>
        </tr>`).join('');
        }

        async function loadAllOrders() {
            const r = await axios.get(API + '/admin/orders');
            const orders = r.data.data.data || [];
            document.getElementById('all-orders').innerHTML = orders.map(o => `
        <tr>
          <td style="font-family:monospace">${o.order_number}</td>
          <td>${o.user?.name}</td>
          <td style="color:var(--rose);font-weight:600">${formatRp(o.total)}</td>
          <td><span class="status-badge s-${o.status}">${o.status}</span></td>
          <td>${o.payment_status}</td>
          <td>
            <select onchange="updateStatus(${o.id},this.value)" style="padding:.25rem;border:1px solid var(--border);border-radius:4px;font-size:.78rem">
              ${['pending', 'processing', 'shipped', 'delivered', 'cancelled'].map(s => `<option value="${s}" ${s === o.status ? 'selected' : ''}>${s}</option>`).join('')}
            </select>
          </td>
        </tr>`).join('');
        }

        async function updateStatus(id, status) {
            await axios.put(API + '/admin/orders/' + id + '/status', { status });
            toast('Status diperbarui', 'success');
        }

        async function loadAdminProducts() {
            const r = await axios.get(API + '/products?per_page=50');
            const products = r.data.data.data || [];
            document.getElementById('admin-products').innerHTML = products.map(p => `
        <tr>
          <td><img src="${p.image || 'https://via.placeholder.com/40'}" style="width:40px;height:40px;object-fit:cover;border-radius:6px" onerror="this.src='https://via.placeholder.com/40?text=P'"></td>
          <td>${p.name}</td>
          <td>${p.brand || '-'}</td>
          <td style="color:var(--rose);font-weight:600">${formatRp(p.price)}</td>
          <td>${p.stock}</td>
          <td><span class="status-badge" style="background:${p.status === 'active' ? '#D4EDDA' : '#F8D7DA'};color:${p.status === 'active' ? '#155724' : '#721C24'}">${p.status}</span></td>
          <td><button class="btn btn-outline" style="font-size:.75rem;padding:.25rem .6rem" onclick="deleteProduct(${p.id})">Hapus</button></td>
        </tr>`).join('');
        }

        async function loadUsers() {
            const r = await axios.get(API + '/admin/users');
            const users = r.data.data.data || [];
            document.getElementById('admin-users').innerHTML = users.map(u => `
        <tr>
          <td>${u.name}</td>
          <td>${u.email}</td>
          <td><span class="status-badge" style="background:${u.role === 'admin' ? '#E8637A20' : '#CCE5FF'};color:${u.role === 'admin' ? 'var(--rose)' : '#004085'}">${u.role}</span></td>
          <td>${u.phone || '-'}</td>
          <td style="color:#999">${new Date(u.created_at).toLocaleDateString('id-ID')}</td>
        </tr>`).join('');
        }

        let editProductId = null;
        async function loadCategoriesForForm() {
            const r = await axios.get(API + '/categories');
            const sel1 = document.getElementById('pf-cat');
            const sel2 = document.getElementById('imp-cat');
            r.data.data.forEach(c => {
                sel1.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                sel2.innerHTML += `<option value="${c.id}">${c.name}</option>`;
            });
        }

        function showProductForm() {
            editProductId = null;
            ['pf-name', 'pf-brand', 'pf-price', 'pf-stock', 'pf-image', 'pf-desc'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('product-form-container').style.display = 'block';
        }

        async function saveProduct() {
            const data = {
                name: document.getElementById('pf-name').value,
                brand: document.getElementById('pf-brand').value,
                price: document.getElementById('pf-price').value,
                stock: document.getElementById('pf-stock').value,
                category_id: document.getElementById('pf-cat').value,
                image: document.getElementById('pf-image').value,
                description: document.getElementById('pf-desc').value,
            };
            loading(true);
            try {
                await axios.post(API + '/admin/products', data);
                toast('Produk berhasil disimpan', 'success');
                document.getElementById('product-form-container').style.display = 'none';
                loadAdminProducts();
            } catch (e) {
                const errors = e.response?.data?.errors;
                if (errors) { toast(Object.values(errors).flat().join(', '), 'error'); }
                else toast(e.response?.data?.message || 'Gagal', 'error');
            } finally { loading(false); }
        }

        async function deleteProduct(id) {
            if (!confirm('Hapus produk ini?')) return;
            await axios.delete(API + '/admin/products/' + id);
            toast('Produk dihapus', 'success');
            loadAdminProducts();
        }

        async function importFromApi() {
            const brand = document.getElementById('imp-brand').value;
            const cat = document.getElementById('imp-cat').value;
            if (!brand || !cat) { toast('Isi brand dan kategori', 'error'); return; }
            loading(true);
            try {
                const r = await axios.post(API + '/admin/external/makeup/import', { brand, category_id: cat });
                document.getElementById('import-result').textContent = r.data.message;
                toast(r.data.message, 'success');
                loadAdminProducts();
            } catch (e) {
                toast(e.response?.data?.message || 'Gagal import', 'error');
            } finally { loading(false); }
        }

        checkAdmin();
    </script>
@endsection