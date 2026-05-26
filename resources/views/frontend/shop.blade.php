@extends('frontend.layout')
@section('title','Belanja - GlowMart')
@section('head')
<style>
.shop-layout{display:grid;grid-template-columns:240px 1fr;gap:2rem;max-width:1200px;margin:0 auto;padding:2rem;}
.filters{background:white;border-radius:12px;padding:1.5rem;border:1px solid var(--border);height:fit-content;position:sticky;top:80px;}
.filters h3{font-family:'Cormorant Garamond',serif;font-size:1.3rem;margin-bottom:1rem;}
.filter-group{margin-bottom:1.5rem;}
.filter-group label{font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:#999;display:block;margin-bottom:.5rem;}
.filter-input{width:100%;padding:.5rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:.85rem;}
.filter-input:focus{outline:none;border-color:var(--rose);}
.products-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;}
.product-card{background:white;border-radius:12px;overflow:hidden;border:1px solid var(--border);transition:.2s;cursor:pointer;}
.product-card:hover{transform:translateY(-3px);box-shadow:0 6px 20px rgba(232,99,122,.12);}
.product-card img{width:100%;height:180px;object-fit:cover;}
.product-info{padding:.75rem;}
.product-brand{font-size:.7rem;color:var(--gold);font-weight:500;text-transform:uppercase;}
.product-name{font-size:.9rem;font-weight:500;margin:.2rem 0;}
.product-price{color:var(--rose);font-weight:600;font-size:.95rem;}
.pagination{display:flex;gap:.5rem;margin-top:1.5rem;justify-content:center;}
.page-btn{padding:.5rem .75rem;border-radius:8px;border:1.5px solid var(--border);background:white;cursor:pointer;font-size:.85rem;}
.page-btn.active{background:var(--rose);color:white;border-color:var(--rose);}
</style>
@endsection
@section('content')
<div class="shop-layout">
  <aside class="filters">
    <h3>Filter</h3>
    <div class="filter-group">
      <label>Cari</label>
      <input class="filter-input" id="f-search" placeholder="Nama produk..." oninput="debounce(applyFilters,500)()">
    </div>
    <div class="filter-group">
      <label>Kategori</label>
      <select class="filter-input" id="f-cat" onchange="applyFilters()">
        <option value="">Semua Kategori</option>
      </select>
    </div>
    <div class="filter-group">
      <label>Brand</label>
      <input class="filter-input" id="f-brand" placeholder="Misal: Maybelline" oninput="debounce(applyFilters,500)()">
    </div>
    <div class="filter-group">
      <label>Harga Min</label>
      <input class="filter-input" id="f-min" type="number" placeholder="0" oninput="debounce(applyFilters,500)()">
    </div>
    <div class="filter-group">
      <label>Harga Max</label>
      <input class="filter-input" id="f-max" type="number" placeholder="1000000" oninput="debounce(applyFilters,500)()">
    </div>
    <div class="filter-group">
      <label>Urutkan</label>
      <select class="filter-input" id="f-sort" onchange="applyFilters()">
        <option value="created_at">Terbaru</option>
        <option value="price">Harga ↑</option>
        <option value="price&order=desc">Harga ↓</option>
      </select>
    </div>
    <button class="btn btn-primary" style="width:100%" onclick="resetFilters()">Reset Filter</button>
  </aside>

  <div>
    <div class="products-header">
      <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.8rem">Semua Produk</h2>
      <span id="product-count" style="color:#999;font-size:.85rem"></span>
    </div>
    <div class="product-grid" id="product-grid"></div>
    <div class="pagination" id="pagination"></div>
  </div>
</div>
@endsection
@section('scripts')
<script>
let _timer;
function debounce(fn, delay) { return () => { clearTimeout(_timer); _timer = setTimeout(fn, delay); }; }

async function loadCategories() {
  const r = await axios.get(API+'/categories');
  const sel = document.getElementById('f-cat');
  r.data.data.forEach(c => sel.innerHTML += `<option value="${c.id}">${c.name}</option>`);
}

async function applyFilters(page=1) {
  const params = new URLSearchParams();
  const s = document.getElementById('f-search').value;
  const c = document.getElementById('f-cat').value;
  const b = document.getElementById('f-brand').value;
  const mn= document.getElementById('f-min').value;
  const mx= document.getElementById('f-max').value;
  const so= document.getElementById('f-sort').value;

  if(s) params.set('search',s);
  if(c) params.set('category_id',c);
  if(b) params.set('brand',b);
  if(mn) params.set('min_price',mn);
  if(mx) params.set('max_price',mx);
  params.set('sort', so.split('&')[0]);
  if(so.includes('desc')) params.set('order','desc');
  params.set('page',page);

  const r = await axios.get(GW+'/products?'+params.toString());
  const {data:products, total, last_page, current_page} = r.data.data;
  document.getElementById('product-count').textContent = total+' produk ditemukan';

  const grid = document.getElementById('product-grid');
  if (!products.length) { grid.innerHTML='<p style="color:#999;grid-column:1/-1">Tidak ada produk ditemukan</p>'; return; }

  grid.innerHTML = products.map(p => `
    <div class="product-card" onclick="window.location='/product/${p.id}'">
      <img src="${p.image||'https://via.placeholder.com/300x180?text=Makeup'}" alt="${p.name}" onerror="this.src='https://via.placeholder.com/300x180?text=Makeup'">
      <div class="product-info">
        <div class="product-brand">${p.brand||''}</div>
        <div class="product-name">${p.name}</div>
        <div class="product-price">${formatRp(p.price)}</div>
        <button class="btn btn-primary" style="width:100%;margin-top:.5rem;font-size:.8rem" onclick="event.stopPropagation();addToCart(${p.id})">+ Keranjang</button>
      </div>
    </div>`).join('');

  // Pagination
  let pages = '';
  for(let i=1;i<=last_page;i++) pages += `<button class="page-btn ${i===current_page?'active':''}" onclick="applyFilters(${i})">${i}</button>`;
  document.getElementById('pagination').innerHTML = pages;
}

async function addToCart(productId) {
  const user = getUser();
  if (!user) { toast('Silakan login dulu','error'); window.location.href='/login'; return; }
  try {
    await axios.post(API+'/cart/add',{product_id:productId,quantity:1});
    toast('Ditambahkan ke keranjang ✓','success');
    updateCartBadge();
  } catch(e) {
    toast(e.response?.data?.message||'Gagal','error');
  }
}

function resetFilters() {
  ['f-search','f-brand','f-min','f-max'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('f-cat').value='';
  document.getElementById('f-sort').value='created_at';
  applyFilters();
}

loadCategories();
applyFilters();
</script>
@endsection