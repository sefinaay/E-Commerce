@extends('frontend.layout')
@section('title','My Orders - GlowMart')
@section('head')
<style>

/* ── Page layout ── */
.orders-page {
  max-width: 1320px;
  margin: 0 auto;
  padding: 3rem 3rem 5rem;
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 2.5rem;
  align-items: start;
}

/* ══ SIDEBAR (same as profile) ══ */
.profile-sidebar {
  position: sticky;
  top: 84px;
  display: flex;
  flex-direction: column;
  gap: .35rem;
}
.sidebar-avatar-wrap {
  background: white;
  border: 1px solid var(--border-light);
  border-radius: 6px;
  padding: 2rem 1.5rem;
  text-align: center;
  margin-bottom: .5rem;
}
.sidebar-avatar {
  width: 68px; height: 68px;
  border-radius: 50%;
  background: var(--rose-pale);
  color: var(--rose);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem; font-weight: 500;
  margin: 0 auto 1rem;
  border: 2px solid var(--border-light);
}
.sidebar-name  { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 500; color: var(--charcoal); margin-bottom: .2rem; }
.sidebar-email { font-size: .75rem; color: var(--warm-gray); margin-bottom: .75rem; }
.sidebar-role-badge {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
  padding: .3rem .8rem; border-radius: 50px;
  background: var(--rose-pale); color: var(--rose);
}
.sidebar-nav-item {
  display: flex; align-items: center; gap: .75rem;
  padding: .75rem 1rem; border-radius: 4px;
  cursor: pointer; font-size: .82rem;
  color: var(--charcoal-mid); font-weight: 500;
  transition: all .18s; border: none;
  background: none; font-family: 'Jost', sans-serif;
  width: 100%; text-align: left; text-decoration: none;
}
.sidebar-nav-item:hover { background: var(--soft-bg); color: var(--charcoal); }
.sidebar-nav-item.active { background: var(--charcoal); color: white; }
.sidebar-nav-item svg { flex-shrink: 0; }

/* ══ MAIN ══ */
.orders-main {}
.orders-page-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem; font-weight: 400;
  color: var(--charcoal); margin-bottom: .35rem;
}
.orders-page-sub {
  font-size: .8rem; color: var(--warm-gray);
  margin-bottom: 2rem;
}

/* ── Filter tab bar ── */
.orders-tab-bar {
  display: flex;
  gap: 0;
  border-bottom: 1px solid var(--border-light);
  margin-bottom: 1.5rem;
  overflow-x: auto;
  scrollbar-width: none;
}
.orders-tab {
  padding: .65rem 1.1rem;
  font-size: .75rem; font-weight: 600;
  letter-spacing: .06em; text-transform: uppercase;
  color: var(--warm-gray);
  background: none; border: none;
  border-bottom: 2px solid transparent;
  cursor: pointer; font-family: 'Jost', sans-serif;
  transition: all .18s; white-space: nowrap;
  margin-bottom: -1px;
}
.orders-tab:hover { color: var(--charcoal); }
.orders-tab.active { color: var(--charcoal); border-bottom-color: var(--charcoal); }

/* ── Order card ── */
.order-card {
  background: white;
  border: 1px solid var(--border-light);
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 1rem;
  transition: box-shadow .2s;
}
.order-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.05); }

.order-card-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.1rem 1.5rem;
  border-bottom: 1px solid var(--border-light);
  gap: 1rem;
  flex-wrap: wrap;
}
.order-num {
  font-size: .8rem; font-weight: 700;
  color: var(--charcoal); font-family: monospace;
  letter-spacing: .04em;
}
.order-date {
  font-size: .72rem; color: var(--warm-gray);
  margin-top: .15rem;
}
.status-badge {
  display: inline-flex; align-items: center; gap: .3rem;
  font-size: .65rem; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  padding: .3rem .85rem; border-radius: 50px;
  white-space: nowrap;
}
.status-pending    { background: #FFF8E1; color: #F59E0B; }
.status-processing { background: #EFF6FF; color: #3B82F6; }
.status-shipped    { background: #ECFDF5; color: #10B981; }
.status-delivered  { background: #F0FDF4; color: #16A34A; }
.status-cancelled  { background: #FEF2F2; color: #EF4444; }

/* status dot */
.status-dot {
  width: 6px; height: 6px; border-radius: 50%;
  display: inline-block; flex-shrink: 0;
}
.status-pending    .status-dot { background: #F59E0B; }
.status-processing .status-dot { background: #3B82F6; }
.status-shipped    .status-dot { background: #10B981; }
.status-delivered  .status-dot { background: #16A34A; }
.status-cancelled  .status-dot { background: #EF4444; }

/* order body */
.order-card-body {
  padding: 1.25rem 1.5rem;
  display: flex;
  gap: 1rem;
  align-items: flex-start;
}
.order-thumbs {
  display: flex;
  gap: .4rem;
  flex-shrink: 0;
}
.order-thumb {
  width: 52px; height: 52px;
  border-radius: 4px;
  overflow: hidden;
  background: var(--soft-bg);
  border: 1px solid var(--border-light);
}
.order-thumb img { width: 100%; height: 100%; object-fit: cover; }
.order-thumb-more {
  width: 52px; height: 52px;
  border-radius: 4px;
  background: var(--cream);
  border: 1px solid var(--border-light);
  display: flex; align-items: center; justify-content: center;
  font-size: .72rem; font-weight: 600; color: var(--warm-gray);
}

.order-info { flex: 1; min-width: 0; }
.order-items-txt {
  font-size: .82rem; color: var(--charcoal-mid);
  line-height: 1.6; margin-bottom: .4rem;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.order-meta {
  font-size: .72rem; color: var(--warm-gray);
  display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
}
.order-meta-sep { opacity: .4; }

.order-card-foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: .9rem 1.5rem;
  border-top: 1px solid var(--border-light);
  background: var(--cream);
  gap: 1rem;
  flex-wrap: wrap;
}
.order-total {
  font-family: 'Playfair Display', serif;
  font-size: 1.1rem; font-weight: 500;
  color: var(--charcoal);
}
.order-total-label {
  font-size: .68rem; letter-spacing: .1em;
  text-transform: uppercase; color: var(--warm-gray);
  margin-bottom: .1rem;
}
.order-actions { display: flex; gap: .6rem; }
.btn-sm {
  padding: .45rem 1rem;
  border-radius: 3px;
  font-family: 'Jost', sans-serif;
  font-size: .72rem; font-weight: 600;
  letter-spacing: .08em; text-transform: uppercase;
  cursor: pointer; transition: all .18s; border: none;
}
.btn-sm-outline {
  background: white;
  border: 1.5px solid var(--border);
  color: var(--charcoal-mid);
}
.btn-sm-outline:hover { border-color: var(--charcoal); color: var(--charcoal); }
.btn-sm-danger {
  background: white;
  border: 1.5px solid #EF4444;
  color: #EF4444;
}
.btn-sm-danger:hover { background: #EF4444; color: white; }
.btn-sm-primary {
  background: var(--charcoal);
  color: white;
  border: 1.5px solid var(--charcoal);
}
.btn-sm-primary:hover { background: var(--rose); border-color: var(--rose); }

/* ── Empty state ── */
.empty-orders {
  text-align: center;
  padding: 5rem 2rem;
  background: white;
  border: 1px solid var(--border-light);
  border-radius: 6px;
}
.empty-orders .empty-icon { font-size: 2.5rem; margin-bottom: 1rem; opacity: .4; }
.empty-orders h2 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem; font-weight: 400;
  color: var(--charcoal); margin-bottom: .5rem;
}
.empty-orders p { font-size: .83rem; color: var(--warm-gray); margin-bottom: 1.75rem; }

/* skeleton */
.skeleton { background: var(--border-light); border-radius: 4px; animation: skpulse 1.4s ease-in-out infinite; }
@keyframes skpulse { 0%,100%{opacity:1}50%{opacity:.4} }

@media (max-width: 900px) {
  .orders-page { grid-template-columns: 1fr; padding: 2rem 1.25rem 4rem; }
  .profile-sidebar { position: static; }
}
@media (max-width: 640px) {
  .order-card-body { flex-direction: column; }
}
</style>
@endsection

@section('content')
<div class="orders-page">

  {{-- ══ SIDEBAR ══ --}}
  <aside class="profile-sidebar">
    <div class="sidebar-avatar-wrap">
      <div class="sidebar-avatar" id="sidebar-avatar">?</div>
      <div class="sidebar-name"  id="sidebar-name">—</div>
      <div class="sidebar-email" id="sidebar-email">—</div>
      <span class="sidebar-role-badge">Customer</span>
    </div>
    <a href="/profile" class="sidebar-nav-item">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Personal Info
    </a>
    <a href="/orders" class="sidebar-nav-item active">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      My Orders
    </a>
    <a href="/wishlist" class="sidebar-nav-item">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
      Wishlist
    </a>
    <a href="/shop" class="sidebar-nav-item">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Shop
    </a>
    <button class="sidebar-nav-item" style="color:#e53e3e;" onclick="logout()">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Sign Out
    </button>
  </aside>

  {{-- ══ MAIN ══ --}}
  <div class="orders-main">
    <h1 class="orders-page-title">My Orders</h1>
    <p class="orders-page-sub">Track and manage your GlowMart purchases.</p>

    {{-- Status filter tabs --}}
    <div class="orders-tab-bar">
      <button class="orders-tab active" onclick="filterOrders('all',this)">All Orders</button>
      <button class="orders-tab" onclick="filterOrders('pending',this)">Pending</button>
      <button class="orders-tab" onclick="filterOrders('processing',this)">Processing</button>
      <button class="orders-tab" onclick="filterOrders('shipped',this)">Shipped</button>
      <button class="orders-tab" onclick="filterOrders('delivered',this)">Delivered</button>
      <button class="orders-tab" onclick="filterOrders('cancelled',this)">Cancelled</button>
    </div>

    {{-- Orders list --}}
    <div id="orders-list">
      <div class="skeleton" style="height:160px;margin-bottom:1rem;border-radius:6px;"></div>
      <div class="skeleton" style="height:160px;margin-bottom:1rem;border-radius:6px;"></div>
      <div class="skeleton" style="height:160px;border-radius:6px;"></div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
let allOrders   = [];
let activeFilter= 'all';

/* ── Sidebar user ── */
function populateSidebar() {
  const u = getUser();
  if (!u) return;
  const initials = u.name.split(' ').map(w=>w[0]).join('').slice(0,2).toUpperCase();
  document.getElementById('sidebar-avatar').textContent = initials;
  document.getElementById('sidebar-name').textContent   = u.name;
  document.getElementById('sidebar-email').textContent  = u.email;
}

/* ── Load orders ── */
async function loadOrders() {
  const user = getUser();
  if (!user) { window.location.href = '/login'; return; }
  populateSidebar();

  try {
    const r = await axios.get(API+'/orders');
    allOrders = r.data.data.data || r.data.data || [];
    renderOrders();
  } catch(e) {
    if (e.response?.status === 401) window.location.href = '/login';
    document.getElementById('orders-list').innerHTML =
      '<p style="color:var(--warm-gray);text-align:center;padding:3rem 0;">Failed to load orders.</p>';
  }
}

/* ── Filter ── */
function filterOrders(status, btn) {
  activeFilter = status;
  document.querySelectorAll('.orders-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  renderOrders();
}

/* ── Render ── */
function renderOrders() {
  const list = document.getElementById('orders-list');
  const filtered = activeFilter === 'all'
    ? allOrders
    : allOrders.filter(o => o.status === activeFilter);

  if (!filtered.length) {
    list.innerHTML = `
      <div class="empty-orders">
        <div class="empty-icon">📦</div>
        <h2>${activeFilter === 'all' ? 'No orders yet' : 'No ' + activeFilter + ' orders'}</h2>
        <p>${activeFilter === 'all' ? "You haven't placed any orders. Start shopping!" : 'No orders with this status.'}</p>
        <a href="/shop" class="btn btn-primary" style="padding:.7rem 2rem;">Start Shopping</a>
      </div>`;
    return;
  }

  const statusLabel = {
    pending:    'Pending',
    processing: 'Processing',
    shipped:    'Shipped',
    delivered:  'Delivered',
    cancelled:  'Cancelled',
  };

  list.innerHTML = filtered.map(o => {
    const items    = o.items || [];
    const status   = o.status || 'pending';
    const dateStr  = new Date(o.created_at).toLocaleDateString('en-US', {
      year:'numeric', month:'long', day:'numeric'
    });
    const itemNames = items.map(i => `${i.product?.name || '—'} ×${i.quantity}`).join(' · ');

    /* thumbnails — show up to 3 + overflow count */
    const thumbsHtml = (() => {
      const show = items.slice(0, 3);
      const rest = items.length - 3;
      return show.map(i => {
        const img = i.product?.image || 'https://via.placeholder.com/52?text=P';
        return `<div class="order-thumb"><img src="${img}" alt="${i.product?.name||''}" onerror="this.src='https://via.placeholder.com/52?text=P'"></div>`;
      }).join('') + (rest > 0 ? `<div class="order-thumb-more">+${rest}</div>` : '');
    })();

    const payLabel = (o.payment_method || '').replace('_',' ').toUpperCase();
    const payStatus= (o.payment_status || '').replace('_',' ');

    return `
      <div class="order-card">
        {{-- Head --}}
        <div class="order-card-head">
          <div>
            <div class="order-num">${o.order_number || '#' + o.id}</div>
            <div class="order-date">${dateStr}</div>
          </div>
          <span class="status-badge status-${status}">
            <span class="status-dot"></span>
            ${statusLabel[status] || status}
          </span>
        </div>

        {{-- Body --}}
        <div class="order-card-body">
          <div class="order-thumbs">${thumbsHtml}</div>
          <div class="order-info">
            <div class="order-items-txt">${itemNames || '—'}</div>
            <div class="order-meta">
              <span>${items.length} item${items.length !== 1 ? 's' : ''}</span>
              <span class="order-meta-sep">·</span>
              <span>${payLabel}</span>
              <span class="order-meta-sep">·</span>
              <span>${payStatus}</span>
              ${o.shipping_city ? `<span class="order-meta-sep">·</span><span>${o.shipping_city}</span>` : ''}
            </div>
          </div>
        </div>

        {{-- Foot --}}
        <div class="order-card-foot">
          <div>
            <div class="order-total-label">Order Total</div>
            <div class="order-total">${formatRp(o.total)}</div>
          </div>
          <div class="order-actions">
            ${status === 'pending'
              ? `<button class="btn-sm btn-sm-danger" onclick="cancelOrder(${o.id})">Cancel</button>`
              : ''}
            ${status === 'delivered'
              ? `<button class="btn-sm btn-sm-outline" onclick="reorder(${o.id})">Reorder</button>`
              : ''}
            <button class="btn-sm btn-sm-primary" onclick="viewOrder(${o.id})">View Details</button>
          </div>
        </div>
      </div>`;
  }).join('');
}

/* ── Actions ── */
async function cancelOrder(id) {
  if (!confirm('Cancel this order? This action cannot be undone.')) return;
  try {
    loading(true);
    await axios.post(API+'/orders/'+id+'/cancel');
    toast('Order cancelled', 'success');
    loadOrders();
  } catch(e) {
    toast(e.response?.data?.message || 'Failed to cancel order', 'error');
  } finally { loading(false); }
}

function viewOrder(id) {
  window.location.href = '/orders/' + id;
}

async function reorder(id) {
  try {
    loading(true);
    const r = await axios.get(API+'/orders/'+id);
    const items = r.data.data?.items || [];
    for (const item of items) {
      await axios.post(API+'/cart/add', {
        product_id: item.product_id,
        quantity:   item.quantity,
      });
    }
    toast('Items added to cart ✓', 'success');
    updateCartBadge();
    setTimeout(() => window.location.href = '/cart', 900);
  } catch {
    toast('Failed to reorder', 'error');
  } finally { loading(false); }
}

/* ── Init ── */
loadOrders();
</script>
@endsection
