@extends('frontend.layout')
@section('title','Pesanan Saya - GlowMart')
@section('head')
<style>
.orders-wrap{max-width:800px;margin:2rem auto;padding:0 1rem;}
.orders-wrap h1{font-family:'Cormorant Garamond',serif;font-size:2.5rem;margin-bottom:1.5rem;}
.order-card{background:white;border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-bottom:1rem;}
.order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.order-number{font-weight:700;font-family:monospace;font-size:.95rem;}
.status-badge{padding:.25rem .75rem;border-radius:50px;font-size:.75rem;font-weight:600;}
.status-pending{background:#FFF3CD;color:#856404;}
.status-processing{background:#CCE5FF;color:#004085;}
.status-shipped{background:#D1ECF1;color:#0C5460;}
.status-delivered{background:#D4EDDA;color:#155724;}
.status-cancelled{background:#F8D7DA;color:#721C24;}
.order-items{font-size:.85rem;color:#666;margin-bottom:.75rem;}
.order-total{font-weight:700;color:var(--rose);}
</style>
@endsection
@section('content')
<div class="orders-wrap">
  <h1>📦 Pesanan Saya</h1>
  <div id="orders-list"><p style="color:#999">Memuat...</p></div>
</div>
@endsection
@section('scripts')
<script>
async function loadOrders() {
  const user = getUser();
  if (!user) { window.location.href='/login'; return; }
  const r = await axios.get(API+'/orders');
  const orders = r.data.data.data || [];
  if (!orders.length) {
    document.getElementById('orders-list').innerHTML=`<div style="text-align:center;padding:3rem"><div style="font-size:4rem">📦</div><p style="color:#999;margin:.5rem 0">Belum ada pesanan</p><a href="/shop"><button class="btn btn-primary">Mulai Belanja</button></a></div>`;
    return;
  }
  document.getElementById('orders-list').innerHTML = orders.map(o=>`
    <div class="order-card">
      <div class="order-header">
        <div>
          <div class="order-number">${o.order_number}</div>
          <div style="font-size:.8rem;color:#999">${new Date(o.created_at).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})}</div>
        </div>
        <span class="status-badge status-${o.status}">${o.status.toUpperCase()}</span>
      </div>
      <div class="order-items">${o.items?.map(i=>`${i.product?.name} x${i.quantity}`).join(' · ')}</div>
      <div style="display:flex;justify-content:space-between;align-items:center">
        <span class="order-total">${formatRp(o.total)}</span>
        <div style="display:flex;gap:.5rem">
          ${o.status==='pending'?`<button class="btn btn-outline" style="font-size:.8rem;padding:.35rem .75rem" onclick="cancelOrder(${o.id})">Batalkan</button>`:''}
          <span style="font-size:.8rem;color:#999">${o.payment_method.toUpperCase()} · ${o.payment_status}</span>
        </div>
      </div>
    </div>`).join('');
}

async function cancelOrder(id) {
  if (!confirm('Batalkan pesanan ini?')) return;
  await axios.post(API+'/orders/'+id+'/cancel');
  toast('Pesanan dibatalkan','success');
  loadOrders();
}

loadOrders();
</script>
@endsection