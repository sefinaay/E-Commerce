@extends('frontend.layout')
@section('title','Keranjang - GlowMart')
@section('head')
<style>
.cart-wrap{max-width:900px;margin:2rem auto;padding:0 1rem;}
.cart-wrap h1{font-family:'Cormorant Garamond',serif;font-size:2.5rem;margin-bottom:1.5rem;}
.cart-item{background:white;border:1px solid var(--border);border-radius:12px;display:flex;gap:1rem;padding:1rem;margin-bottom:1rem;align-items:center;}
.cart-item img{width:80px;height:80px;object-fit:cover;border-radius:8px;}
.cart-item-info{flex:1;}
.cart-item-name{font-weight:500;margin-bottom:.25rem;}
.cart-item-price{color:var(--rose);font-weight:600;}
.qty-controls{display:flex;align-items:center;gap:.5rem;margin-top:.5rem;}
.qty-btn{width:28px;height:28px;border-radius:50%;border:1.5px solid var(--border);background:white;cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;}
.cart-summary{background:white;border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-top:1rem;}
.summary-row{display:flex;justify-content:space-between;margin-bottom:.75rem;font-size:.9rem;}
.summary-total{display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem;border-top:2px solid var(--border);padding-top:.75rem;margin-top:.75rem;}
</style>
@endsection
@section('content')
<div class="cart-wrap">
  <h1>🛒 Keranjang Belanja</h1>
  <div id="cart-content"><p style="color:#999">Memuat...</p></div>
</div>
@endsection
@section('scripts')
<script>
async function loadCart() {
  const user = getUser();
  if (!user) { document.getElementById('cart-content').innerHTML='<p>Silakan <a href="/login" style="color:var(--rose)">login</a> untuk melihat keranjang.</p>'; return; }

  try {
    const r = await axios.get(API+'/cart');
    const {items, total} = r.data.data;

    if (!items.length) {
      document.getElementById('cart-content').innerHTML=`<div style="text-align:center;padding:3rem;"><div style="font-size:4rem">🛍️</div><p style="color:#999;margin:.5rem 0">Keranjang kosong</p><a href="/shop"><button class="btn btn-primary">Mulai Belanja</button></a></div>`;
      return;
    }

    let html = items.map(item => `
      <div class="cart-item">
        <img src="${item.product?.image||'https://via.placeholder.com/80'}" alt="${item.product?.name}" onerror="this.src='https://via.placeholder.com/80?text=P'">
        <div class="cart-item-info">
          <div class="cart-item-name">${item.product?.name}</div>
          <div style="font-size:.8rem;color:#999">${item.product?.brand||''}</div>
          <div class="cart-item-price">${formatRp(item.product?.price)}</div>
          <div class="qty-controls">
            <button class="qty-btn" onclick="updateQty(${item.id},${item.quantity-1})">−</button>
            <span>${item.quantity}</span>
            <button class="qty-btn" onclick="updateQty(${item.id},${item.quantity+1})">+</button>
            <button style="background:none;border:none;color:#e53e3e;cursor:pointer;margin-left:.5rem" onclick="removeItem(${item.id})">🗑</button>
          </div>
        </div>
        <div style="font-weight:700;color:var(--rose)">${formatRp(item.product?.price * item.quantity)}</div>
      </div>`).join('');

    html += `<div class="cart-summary">
      <div class="summary-row"><span>Subtotal (${items.length} produk)</span><span>${formatRp(total)}</span></div>
      <div class="summary-row"><span>Ongkos Kirim</span><span>Dihitung saat checkout</span></div>
      <div class="summary-total"><span>Total</span><span>${formatRp(total)}</span></div>
      <button class="btn btn-primary" style="width:100%;padding:.8rem;font-size:1rem;margin-top:1rem" onclick="window.location.href='/checkout'">Lanjut ke Checkout</button>
      <button class="btn btn-outline" style="width:100%;padding:.8rem;margin-top:.5rem" onclick="clearCart()">Kosongkan Keranjang</button>
    </div>`;

    document.getElementById('cart-content').innerHTML = html;
    document.getElementById('cart-count').textContent = items.length;
  } catch(e) {
    document.getElementById('cart-content').innerHTML='<p style="color:#e53e3e">Gagal memuat keranjang</p>';
  }
}

async function updateQty(id, qty) {
  if (qty < 1) { removeItem(id); return; }
  await axios.put(API+'/cart/'+id, {quantity:qty});
  loadCart();
}
async function removeItem(id) {
  await axios.delete(API+'/cart/'+id);
  toast('Item dihapus','success');
  loadCart();
}
async function clearCart() {
  if (!confirm('Kosongkan semua keranjang?')) return;
  await axios.delete(API+'/cart');
  loadCart();
}

loadCart();
</script>
@endsection