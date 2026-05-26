@extends('frontend.layout')
@section('title','GlowMart - Beauty Store')
@section('head')
<style>
.hero{background:linear-gradient(135deg,var(--soft) 0%,#fce4ec 100%);padding:5rem 2rem;text-align:center;}
.hero h1{font-family:'Cormorant Garamond',serif;font-size:4rem;font-weight:300;color:var(--charcoal);line-height:1.1;margin-bottom:1rem;}
.hero h1 em{color:var(--rose);font-style:italic;}
.hero p{color:#666;font-size:1.1rem;margin-bottom:2rem;max-width:500px;margin-left:auto;margin-right:auto;}
.hero-btns{display:flex;gap:1rem;justify-content:center;}
.section{padding:3rem 2rem;max-width:1200px;margin:0 auto;}
.section h2{font-family:'Cormorant Garamond',serif;font-size:2rem;margin-bottom:1.5rem;color:var(--charcoal);}
.product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.5rem;}
.product-card{background:white;border-radius:12px;overflow:hidden;border:1px solid var(--border);transition:.2s;cursor:pointer;}
.product-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(232,99,122,.15);}
.product-card img{width:100%;height:200px;object-fit:cover;}
.product-info{padding:1rem;}
.product-brand{font-size:.75rem;color:var(--gold);font-weight:500;text-transform:uppercase;letter-spacing:.5px;}
.product-name{font-weight:500;margin:.25rem 0;font-size:.95rem;}
.product-price{color:var(--rose);font-weight:600;}
.product-rating{font-size:.8rem;color:#f59e0b;margin-top:.25rem;}
.categories{display:flex;gap:1rem;overflow-x:auto;padding-bottom:.5rem;scrollbar-width:none;}
.cat-chip{padding:.5rem 1.25rem;border-radius:50px;border:1.5px solid var(--border);background:white;cursor:pointer;white-space:nowrap;font-size:.85rem;transition:.2s;}
.cat-chip:hover,.cat-chip.active{background:var(--rose);color:white;border-color:var(--rose);}
.banner{background:linear-gradient(120deg,var(--charcoal),#4a2c35);color:white;padding:3rem 2rem;text-align:center;margin:2rem 0;}
.banner h2{font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:300;margin-bottom:.5rem;}
</style>
@endsection
@section('content')
<div class="hero">
  <h1>Your Beauty,<br><em>Redefined.</em></h1>
  <p>Temukan ratusan produk makeup & skincare premium dengan harga terjangkau.</p>
  <div class="hero-btns">
    <a href="/shop"><button class="btn btn-primary" style="padding:.75rem 2rem;font-size:1rem;">Belanja Sekarang</button></a>
    <a href="/discover"><button class="btn btn-outline" style="padding:.75rem 2rem;font-size:1rem;">Discover Produk</button></a>
  </div>
</div>

<div class="section">
  <h2>Kategori</h2>
  <div class="categories" id="cat-list">
    <div class="cat-chip active" onclick="filterCat(null,this)">Semua</div>
  </div>
</div>

<div class="section" style="padding-top:0">
  <h2>Produk Unggulan</h2>
  <div class="product-grid" id="product-grid">
    <p style="color:#999">Memuat produk...</p>
  </div>
</div>

<div class="banner">
  <h2>Inspired by <em>Real Beauty</em></h2>
  <p style="opacity:.7;margin-bottom:1.5rem">Ribuan pilihan dari brand favorit dunia</p>
  <a href="/discover"><button class="btn btn-outline" style="border-color:white;color:white;">Jelajahi Koleksi</button></a>
</div>
@endsection
@section('scripts')
<script>
let currentCat = null;

async function loadCategories() {
  const r = await axios.get(API+'/categories');
  r.data.data.forEach(cat => {
    document.getElementById('cat-list').innerHTML +=
      `<div class="cat-chip" onclick="filterCat(${cat.id},this)">${cat.name} (${cat.products_count})</div>`;
  });
}

async function filterCat(catId, el) {
  document.querySelectorAll('.cat-chip').forEach(c=>c.classList.remove('active'));
  el.classList.add('active');
  currentCat = catId;
  await loadProducts(catId);
}

async function loadProducts(catId=null) {
  const grid = document.getElementById('product-grid');
  grid.innerHTML = '<p style="color:#999">Memuat...</p>';
  const params = catId ? `?category_id=${catId}` : '';
  const r = await axios.get(GW+'/products'+params);
  const products = r.data.data.data || [];
  if (!products.length) { grid.innerHTML='<p style="color:#999">Produk tidak ditemukan</p>'; return; }
  grid.innerHTML = products.map(p => `
    <div class="product-card" onclick="window.location='/product/${p.id}'">
      <img src="${p.image||'https://via.placeholder.com/300x200?text='+encodeURIComponent(p.name)}" alt="${p.name}" onerror="this.src='https://via.placeholder.com/300x200?text=Makeup'">
      <div class="product-info">
        <div class="product-brand">${p.brand||p.category?.name||''}</div>
        <div class="product-name">${p.name}</div>
        <div class="product-price">${formatRp(p.price)}</div>
        <div class="product-rating">${'★'.repeat(Math.round(p.reviews_avg_rating||0))}${'☆'.repeat(5-Math.round(p.reviews_avg_rating||0))} (${p.reviews_avg_rating?Number(p.reviews_avg_rating).toFixed(1):'—'})</div>
      </div>
    </div>`).join('');
}

loadCategories();
loadProducts();
</script>
@endsection