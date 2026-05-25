@extends('frontend.layout')
@section('title','Checkout - GlowMart')
@section('head')
<style>
.checkout-wrap{max-width:900px;margin:2rem auto;padding:0 1rem;display:grid;grid-template-columns:1fr 380px;gap:2rem;}
.checkout-wrap h1{font-family:'Cormorant Garamond',serif;font-size:2rem;margin-bottom:1.5rem;grid-column:1/-1;}
.checkout-form{background:white;border:1px solid var(--border);border-radius:12px;padding:1.5rem;}
.form-group{margin-bottom:1rem;}
.form-group label{font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:.9rem;}
.form-group input:focus,.form-group select:focus{outline:none;border-color:var(--rose);}
.order-summary{background:white;border:1px solid var(--border);border-radius:12px;padding:1.5rem;height:fit-content;position:sticky;top:80px;}
.shipping-options{display:flex;flex-direction:column;gap:.5rem;margin-top:.5rem;}
.shipping-opt{padding:.75rem;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;font-size:.85rem;transition:.2s;}
.shipping-opt.selected{border-color:var(--rose);background:var(--soft);}
</style>
@endsection
@section('content')
<div class="checkout-wrap">
  <h1>💳 Checkout</h1>
  <div>
    <div class="checkout-form">
      <h3 style="margin-bottom:1rem;font-family:'Cormorant Garamond',serif;font-size:1.4rem">Alamat Pengiriman</h3>
      <div class="form-group"><label>Alamat Lengkap</label><textarea id="shipping_address" rows="3" style="width:100%;padding:.7rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;resize:none" placeholder="Jl. Contoh No. 123, RT/RW 01/02"></textarea></div>
      <div class="form-group"><label>Kota</label><input id="shipping_city" placeholder="Malang"></div>
      <div class="form-group">
        <label>Kurir & Estimasi Ongkir</label>
        <select id="courier" onchange="calculateShipping()">
          <option value="jne">JNE</option>
          <option value="tiki">TIKI</option>
          <option value="pos">POS Indonesia</option>
        </select>
      </div>
      <div id="shipping-options" class="shipping-options"></div>
      <div class="form-group" style="margin-top:1rem">
        <label>Metode Pembayaran</label>
        <select id="payment_method">
          <option value="transfer">Transfer Bank</option>
          <option value="ewallet">E-Wallet (GoPay/OVO)</option>
          <option value="cod">COD (Bayar di Tempat)</option>
        </select>
      </div>
      <div class="form-group"><label>Catatan (opsional)</label><input id="notes" placeholder="Instruksi khusus untuk kurir..."></div>
    </div>
  </div>

  <div class="order-summary">
    <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;margin-bottom:1rem">Ringkasan Pesanan</h3>
    <div id="order-items"></div>
    <div style="border-top:1px solid var(--border);margin:1rem 0"></div>
    <div style="display:flex;justify-content:space-between;font-size:.9rem;margin-bottom:.5rem"><span>Subtotal</span><span id="subtotal-val">-</span></div>
    <div style="display:flex;justify-content:space-between;font-size:.9rem;margin-bottom:.5rem"><span>Ongkir</span><span id="shipping-val">Pilih kurir</span></div>
    <div style="display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem;margin-top:.75rem;border-top:2px solid var(--border);padding-top:.75rem"><span>Total</span><span id="total-val">-</span></div>
    <button class="btn btn-primary" style="width:100%;padding:.8rem;font-size:1rem;margin-top:1.5rem" onclick="placeOrder()">Buat Pesanan</button>
  </div>
</div>
@endsection
@section('scripts')
<script>
let cartData = null;
let selectedShipping = 0;
let selectedShippingName = '';

async function loadCheckout() {
  const user = getUser();
  if (!user) { window.location.href='/login'; return; }
  const r = await axios.get(API+'/cart');
  cartData = r.data.data;
  if (!cartData.items.length) { window.location.href='/cart'; return; }

  document.getElementById('subtotal-val').textContent = formatRp(cartData.total);
  document.getElementById('total-val').textContent = formatRp(cartData.total);

  document.getElementById('order-items').innerHTML = cartData.items.map(i=>
    `<div style="display:flex;justify-content:space-between;font-size:.85rem;margin-bottom:.5rem">
      <span>${i.product?.name} x${i.quantity}</span>
      <span>${formatRp(i.product?.price * i.quantity)}</span>
    </div>`).join('');
}

async function calculateShipping() {
  const city = document.getElementById('shipping_city').value || 'malang';
  const courier = document.getElementById('courier').value;
  document.getElementById('shipping-options').innerHTML = '<p style="color:#999;font-size:.85rem">Menghitung...</p>';

  try {
    const r = await axios.post(API+'/shipping/calculate', {
      origin: '455', destination: '455',
      weight: 500, courier
    });
    const services = r.data.data;
    document.getElementById('shipping-options').innerHTML = services.map((s,i) => `
      <div class="shipping-opt ${i===0?'selected':''}" onclick="selectShipping(this,${s.cost},'${s.service}')">
        <strong>${s.service}</strong> — ${formatRp(s.cost)} <span style="color:#999">(${s.etd})</span>
      </div>`).join('');
    if (services[0]) selectShipping(null, services[0].cost, services[0].service, true);
  } catch {
    document.getElementById('shipping-options').innerHTML='<p style="color:#e53e3e;font-size:.85rem">Gagal kalkulasi ongkir</p>';
  }
}

function selectShipping(el, cost, name, silent=false) {
  if (!silent) {
    document.querySelectorAll('.shipping-opt').forEach(e=>e.classList.remove('selected'));
    el?.classList.add('selected');
  }
  selectedShipping = cost;
  selectedShippingName = name;
  const sub = cartData?.total || 0;
  document.getElementById('shipping-val').textContent = formatRp(cost);
  document.getElementById('total-val').textContent = formatRp(sub + cost);
}

async function placeOrder() {
  const addr = document.getElementById('shipping_address').value;
  const city = document.getElementById('shipping_city').value;
  if (!addr || !city) { toast('Isi alamat lengkap','error'); return; }

  loading(true);
  try {
    const r = await axios.post(API+'/orders', {
      shipping_address: addr,
      shipping_city: city,
      payment_method: document.getElementById('payment_method').value,
      shipping_cost: selectedShipping,
      notes: document.getElementById('notes').value,
    });
    toast('Pesanan berhasil dibuat! 🎉','success');
    setTimeout(()=>window.location.href='/orders', 1000);
  } catch(e) {
    toast(e.response?.data?.message||'Gagal membuat pesanan','error');
  } finally { loading(false); }
}

loadCheckout();
calculateShipping();
</script>
@endsection