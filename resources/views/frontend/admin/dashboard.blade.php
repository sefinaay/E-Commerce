<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel — GlowMart</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="/js/axios.min.js"></script>
<style>
:root {
  --rose:#C8506A; --rose-light:#E8A0AD; --rose-pale:#F7E8EC;
  --cream:#FAF7F4; --charcoal:#1A1A1A; --charcoal-mid:#3D3D3D;
  --warm-gray:#8A8178; --gold:#B8966A; --white:#FFFFFF;
  --border:#EDE3E7; --border-light:#F3EBEE; --soft-bg:#FDF2F5;
  --sidebar-w: 240px;
}
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{font-family:'Jost',sans-serif;background:var(--cream);color:var(--charcoal);font-size:14px;line-height:1.6;}

.admin-layout{display:flex;min-height:100vh;}

/* ── Sidebar ── */
.admin-sidebar{width:var(--sidebar-w);background:var(--charcoal);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:300;overflow-y:auto;}
.sidebar-brand{padding:1.5rem 1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.08);}
.sidebar-logo{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:500;color:white;text-decoration:none;display:block;margin-bottom:.2rem;}
.sidebar-role-tag{font-size:.62rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--rose-light);}
.sidebar-admin-info{padding:1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:.75rem;}
.sidebar-admin-avatar{width:34px;height:34px;border-radius:50%;background:var(--rose-pale);color:var(--rose);display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;flex-shrink:0;}
.sidebar-admin-name{font-size:.8rem;font-weight:500;color:rgba(255,255,255,.85);}
.sidebar-admin-sub{font-size:.68rem;color:rgba(255,255,255,.4);}
.sidebar-section{padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.06);}
.sidebar-section-label{padding:.4rem 1.5rem;font-size:.62rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:.2rem;}
.sidebar-nav-item{display:flex;align-items:center;gap:.7rem;padding:.65rem 1.5rem;font-size:.82rem;font-weight:400;color:rgba(255,255,255,.55);cursor:pointer;transition:all .18s;border:none;background:none;font-family:'Jost',sans-serif;width:100%;text-align:left;text-decoration:none;border-left:2px solid transparent;}
.sidebar-nav-item:hover{color:rgba(255,255,255,.9);background:rgba(255,255,255,.04);}
.sidebar-nav-item.active{color:white;background:rgba(200,80,106,.15);border-left-color:var(--rose);font-weight:500;}
.sidebar-nav-item svg{flex-shrink:0;opacity:.7;}
.sidebar-nav-item.active svg{opacity:1;}
.nav-badge{margin-left:auto;background:var(--rose);color:white;font-size:.58rem;font-weight:700;padding:.15rem .45rem;border-radius:50px;min-width:18px;text-align:center;}
.sidebar-footer{margin-top:auto;padding:1rem 0;border-top:1px solid rgba(255,255,255,.06);}

/* ── Topbar ── */
.admin-topbar{position:fixed;top:0;left:var(--sidebar-w);right:0;height:56px;background:var(--white);border-bottom:1px solid var(--border-light);display:flex;align-items:center;justify-content:space-between;padding:0 2rem;z-index:200;}
.topbar-title{font-size:.9rem;font-weight:600;color:var(--charcoal);letter-spacing:.02em;}
.topbar-right{display:flex;align-items:center;gap:1rem;}
.topbar-icon{width:34px;height:34px;border-radius:50%;background:var(--soft-bg);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--warm-gray);transition:all .18s;}
.topbar-icon:hover{background:var(--rose-pale);color:var(--rose);}
.topbar-user{display:flex;align-items:center;gap:.6rem;cursor:pointer;}
.topbar-user-avatar{width:32px;height:32px;border-radius:50%;background:var(--rose-pale);color:var(--rose);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;}
.topbar-user-name{font-size:.8rem;font-weight:500;color:var(--charcoal);}

/* ── Main ── */
.admin-main{margin-left:var(--sidebar-w);margin-top:56px;padding:2rem 2rem 4rem;flex:1;min-width:0;}
.tab-content{display:none;}
.tab-content.active{display:block;}

/* ── Page header ── */
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.75rem;}
.page-header h2{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:400;color:var(--charcoal);}
.page-header p{font-size:.78rem;color:var(--warm-gray);margin-top:.15rem;}

/* ── Stat cards ── */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem;}
.stat-card{background:white;border:1px solid var(--border-light);border-radius:6px;padding:1.5rem;display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;}
.stat-label{font-size:.68rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--warm-gray);margin-bottom:.5rem;}
.stat-num{font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:400;color:var(--charcoal);line-height:1;margin-bottom:.35rem;}
.stat-sub{font-size:.72rem;color:var(--warm-gray);}
.stat-sub.up{color:#16A34A;}
.stat-icon{width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.1rem;}
.stat-icon-rose{background:var(--rose-pale);}
.stat-icon-gold{background:#F5EDDE;}
.stat-icon-blue{background:#EFF6FF;}
.stat-icon-green{background:#F0FDF4;}

/* ── Cards ── */
.admin-card{background:white;border:1px solid var(--border-light);border-radius:6px;overflow:hidden;margin-bottom:1.5rem;}
.admin-card-head{display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.5rem;border-bottom:1px solid var(--border-light);}
.admin-card-head h3{font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--charcoal);}
.admin-card-body{padding:0;}

/* ── Table ── */
.data-table{width:100%;border-collapse:collapse;}
.data-table th{padding:.75rem 1.5rem;text-align:left;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--warm-gray);background:var(--cream);border-bottom:1px solid var(--border-light);white-space:nowrap;}
.data-table td{padding:.85rem 1.5rem;font-size:.82rem;border-bottom:1px solid var(--border-light);color:var(--charcoal-mid);vertical-align:middle;}
.data-table tr:last-child td{border-bottom:none;}
.data-table tr:hover td{background:var(--cream);}
.data-table td.font-mono{font-family:monospace;font-size:.8rem;color:var(--charcoal);}

/* ── Status badges ── */
.status-badge{display:inline-flex;align-items:center;gap:.3rem;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.25rem .75rem;border-radius:50px;white-space:nowrap;}
.s-pending{background:#FFF8E1;color:#F59E0B;}
.s-processing{background:#EFF6FF;color:#3B82F6;}
.s-shipped{background:#ECFDF5;color:#10B981;}
.s-delivered{background:#F0FDF4;color:#16A34A;}
.s-cancelled{background:#FEF2F2;color:#EF4444;}
.s-active,.s-published{background:#F0FDF4;color:#16A34A;}
.s-inactive,.s-draft{background:#F9FAFB;color:#6B7280;}
.s-admin{background:var(--rose-pale);color:var(--rose);}
.s-customer{background:#EFF6FF;color:#3B82F6;}

/* ── Toolbar ── */
.table-toolbar{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border-light);flex-wrap:wrap;}
.search-wrap{position:relative;}
.search-wrap input{padding:.5rem 1rem .5rem 2.25rem;border:1px solid var(--border);border-radius:4px;font-family:'Jost',sans-serif;font-size:.8rem;color:var(--charcoal);outline:none;width:200px;transition:border-color .18s;}
.search-wrap input:focus{border-color:var(--charcoal);}
.search-wrap input::placeholder{color:var(--warm-gray);}
.search-wrap svg{position:absolute;left:.7rem;top:50%;transform:translateY(-50%);color:var(--warm-gray);pointer-events:none;}
.filter-select{padding:.5rem .85rem;border:1px solid var(--border);border-radius:4px;font-family:'Jost',sans-serif;font-size:.75rem;color:var(--charcoal);background:white;outline:none;appearance:none;cursor:pointer;padding-right:1.8rem;background-image:url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%238A8178' stroke-width='1.5'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .65rem center;}

/* ── Form overlay ── */
.form-overlay{background:white;border:1px solid var(--border-light);border-radius:6px;padding:1.5rem;margin-bottom:1.5rem;display:none;}
.form-overlay.open{display:block;}
.form-overlay h4{font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--charcoal);margin-bottom:1.25rem;padding-bottom:.85rem;border-bottom:1px solid var(--border-light);}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.form-field{margin-bottom:0;}
.form-field.full{grid-column:1/-1;}
.form-field label{display:block;font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--warm-gray);margin-bottom:.4rem;}
.form-input{width:100%;padding:.65rem .9rem;border:1px solid var(--border);border-radius:4px;font-family:'Jost',sans-serif;font-size:.84rem;color:var(--charcoal);background:white;outline:none;transition:border-color .18s,box-shadow .18s;}
.form-input:focus{border-color:var(--charcoal);box-shadow:0 0 0 3px rgba(26,26,26,.05);}
.form-input::placeholder{color:#CFC6CA;}
.form-textarea{width:100%;padding:.65rem .9rem;border:1px solid var(--border);border-radius:4px;font-family:'Jost',sans-serif;font-size:.84rem;color:var(--charcoal);outline:none;resize:vertical;transition:border-color .18s;}
.form-textarea:focus{border-color:var(--charcoal);}
.form-actions{display:flex;gap:.65rem;margin-top:1.25rem;}

/* ── Buttons ── */
.btn{padding:.55rem 1.2rem;border-radius:3px;border:none;cursor:pointer;font-family:'Jost',sans-serif;font-weight:500;font-size:.75rem;letter-spacing:.08em;text-transform:uppercase;transition:all .2s;display:inline-flex;align-items:center;gap:.4rem;}
.btn-primary{background:var(--charcoal);color:white;}
.btn-primary:hover{background:var(--rose);}
.btn-outline{background:white;border:1.5px solid var(--border);color:var(--charcoal-mid);}
.btn-outline:hover{border-color:var(--charcoal);color:var(--charcoal);}
.btn-danger{background:white;border:1.5px solid #EF4444;color:#EF4444;}
.btn-danger:hover{background:#EF4444;color:white;}
.btn-rose-soft{background:var(--rose-pale);color:var(--rose);border:none;}
.btn-rose-soft:hover{background:var(--rose);color:white;}
.btn-sm{padding:.35rem .75rem;font-size:.68rem;}

/* ── Misc ── */
.prod-thumb{width:40px;height:40px;border-radius:4px;object-fit:cover;background:var(--soft-bg);display:block;}
.status-select{padding:.3rem .65rem;border:1px solid var(--border);border-radius:3px;font-family:'Jost',sans-serif;font-size:.72rem;background:white;color:var(--charcoal);outline:none;cursor:pointer;}
.import-card{background:white;border:1px solid var(--border-light);border-radius:6px;padding:2rem;max-width:520px;}
.import-card h3{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:400;color:var(--charcoal);margin-bottom:.4rem;}
.import-card p{font-size:.8rem;color:var(--warm-gray);margin-bottom:1.5rem;line-height:1.7;}
.import-result{background:var(--soft-bg);border:1px solid var(--border-light);border-radius:4px;padding:.85rem 1rem;font-size:.8rem;color:#16A34A;margin-top:1rem;display:none;}
.journal-excerpt{max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.72rem;color:var(--warm-gray);margin-top:.15rem;}

/* ── Toast & Loader ── */
.toast{position:fixed;bottom:1.5rem;right:1.5rem;background:var(--charcoal);color:white;padding:.75rem 1.3rem;border-radius:3px;z-index:9999;font-size:.8rem;opacity:0;transition:opacity .3s;pointer-events:none;border-left:3px solid var(--rose);}
.toast.show{opacity:1;}
.toast.success{border-left-color:#2E7D32;}
.toast.error{border-left-color:#C62828;}
#loading-overlay{position:fixed;inset:0;background:rgba(250,247,244,.75);display:none;align-items:center;justify-content:center;z-index:9998;}
.spinner{width:34px;height:34px;border:2.5px solid var(--border);border-top-color:var(--rose);border-radius:50%;animation:spin 1s linear infinite;}
@keyframes spin{to{transform:rotate(360deg);}}
.skeleton{background:var(--border-light);border-radius:4px;animation:skpulse 1.4s ease-in-out infinite;}
@keyframes skpulse{0%,100%{opacity:1}50%{opacity:.4}}

@media(max-width:1024px){.stat-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:768px){
  .admin-sidebar{transform:translateX(-100%);}
  .admin-main{margin-left:0;}
  .admin-topbar{left:0;}
}
</style>
</head>
<body>
<div class="admin-layout">

  <!-- ══ SIDEBAR ══ -->
  <aside class="admin-sidebar">
    <div class="sidebar-brand">
      <a class="sidebar-logo" href="/">GlowMart</a>
      <div class="sidebar-role-tag">Admin Panel</div>
    </div>

    <div class="sidebar-admin-info">
      <div class="sidebar-admin-avatar" id="sb-avatar">A</div>
      <div>
        <div class="sidebar-admin-name" id="sb-name">Admin</div>
        <div class="sidebar-admin-sub">Administrator</div>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-section-label">Overview</div>
      <button class="sidebar-nav-item active" onclick="showTab('dashboard',this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </button>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-section-label">Manage</div>
      <button class="sidebar-nav-item" onclick="showTab('orders',this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        Orders
        <span class="nav-badge" id="pending-count">0</span>
      </button>
      <button class="sidebar-nav-item" onclick="showTab('products',this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        Products
      </button>
      <button class="sidebar-nav-item" onclick="showTab('users',this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Customers
      </button>
      <button class="sidebar-nav-item" onclick="showTab('journals',this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        Journal
      </button>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-section-label">Tools</div>
      <button class="sidebar-nav-item" onclick="showTab('import',this)">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"/></svg>
        Import API
      </button>
    </div>

    <div class="sidebar-footer">
      <a href="/" class="sidebar-nav-item">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        View Store
      </a>
      <button class="sidebar-nav-item" style="color:#EF4444;" onclick="logout()">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Sign Out
      </button>
    </div>
  </aside>

  <!-- ══ MAIN ══ -->
  <div style="flex:1;display:flex;flex-direction:column;">

    <!-- Topbar -->
    <header class="admin-topbar">
      <div class="topbar-title" id="topbar-title">Dashboard</div>
      <div class="topbar-right">
        <button class="topbar-icon" onclick="window.location.reload()" title="Refresh">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
        </button>
        <div class="topbar-user">
          <div class="topbar-user-avatar" id="tb-avatar">A</div>
          <span class="topbar-user-name" id="tb-name">Admin</span>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="admin-main">

      <!-- ── DASHBOARD ── -->
      <div class="tab-content active" id="tab-dashboard">
        <div class="page-header">
          <div><h2>Overview</h2><p>Welcome back! Here's what's happening today.</p></div>
          <button class="btn btn-outline btn-sm" onclick="loadDashboard()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            Refresh
          </button>
        </div>
        <div class="stat-grid" id="stats">
          <div class="stat-card"><div class="skeleton" style="height:60px;width:100%;"></div></div>
          <div class="stat-card"><div class="skeleton" style="height:60px;width:100%;"></div></div>
          <div class="stat-card"><div class="skeleton" style="height:60px;width:100%;"></div></div>
          <div class="stat-card"><div class="skeleton" style="height:60px;width:100%;"></div></div>
        </div>
        <div class="admin-card">
          <div class="admin-card-head">
            <h3>Recent Orders</h3>
            <button class="btn btn-outline btn-sm" onclick="showTab('orders',document.querySelector('[onclick*=\"orders\"]'))">View All</button>
          </div>
          <div class="admin-card-body">
            <table class="data-table">
              <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
              <tbody id="recent-orders">
                <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--warm-gray);">Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── ORDERS ── -->
      <div class="tab-content" id="tab-orders">
        <div class="page-header">
          <div><h2>Orders</h2><p>Manage and update customer orders.</p></div>
          <button class="btn btn-outline btn-sm" onclick="loadAllOrders()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            Refresh
          </button>
        </div>
        <div class="admin-card">
          <div class="table-toolbar">
            <div class="search-wrap">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input type="text" id="order-search" placeholder="Search orders..." oninput="filterOrdersTable()">
            </div>
            <select class="filter-select" id="order-status-filter" onchange="filterOrdersTable()">
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="shipped">Shipped</option>
              <option value="delivered">Delivered</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div class="admin-card-body">
            <table class="data-table">
              <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Update</th></tr></thead>
              <tbody id="all-orders">
                <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--warm-gray);">Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── PRODUCTS ── -->
      <div class="tab-content" id="tab-products">
        <div class="page-header">
          <div><h2>Products</h2><p>Manage your product catalogue.</p></div>
          <button class="btn btn-primary" onclick="toggleProductForm()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Product
          </button>
        </div>
        <div class="form-overlay" id="product-form">
          <h4>Add New Product</h4>
          <div class="form-grid-2">
            <div class="form-field"><label>Product Name</label><input class="form-input" id="pf-name" placeholder="Product name"></div>
            <div class="form-field"><label>Brand</label><input class="form-input" id="pf-brand" placeholder="Brand name"></div>
            <div class="form-field"><label>Price (Rp)</label><input class="form-input" id="pf-price" type="number" placeholder="0"></div>
            <div class="form-field"><label>Stock</label><input class="form-input" id="pf-stock" type="number" placeholder="0"></div>
            <div class="form-field"><label>Category</label><select class="form-input" id="pf-cat"></select></div>
            <div class="form-field"><label>Image URL</label><input class="form-input" id="pf-image" placeholder="https://..."></div>
            <div class="form-field full"><label>Description</label><textarea class="form-textarea" id="pf-desc" rows="3" placeholder="Product description..."></textarea></div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" onclick="saveProduct()">Save Product</button>
            <button class="btn btn-outline" onclick="toggleProductForm()">Cancel</button>
          </div>
        </div>
        <div class="admin-card">
          <div class="table-toolbar">
            <div class="search-wrap">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input type="text" id="prod-search" placeholder="Search products..." oninput="filterProductsTable()">
            </div>
            <button class="btn btn-outline btn-sm" onclick="loadAdminProducts()">Refresh</button>
          </div>
          <div class="admin-card-body">
            <table class="data-table">
              <thead><tr><th>Image</th><th>Name</th><th>Brand</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr></thead>
              <tbody id="admin-products">
                <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--warm-gray);">Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── CUSTOMERS ── -->
      <div class="tab-content" id="tab-users">
        <div class="page-header">
          <div><h2>Customers</h2><p>Manage registered users and their roles.</p></div>
        </div>
        <div class="admin-card">
          <div class="table-toolbar">
            <div class="search-wrap">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input type="text" id="user-search" placeholder="Search users..." oninput="filterUsersTable()">
            </div>
            <select class="filter-select" id="user-role-filter" onchange="filterUsersTable()">
              <option value="">All Roles</option>
              <option value="admin">Admin</option>
              <option value="customer">Customer</option>
            </select>
          </div>
          <div class="admin-card-body">
            <table class="data-table">
              <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Phone</th><th>Joined</th></tr></thead>
              <tbody id="admin-users">
                <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--warm-gray);">Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── JOURNALS ── -->
      <div class="tab-content" id="tab-journals">
        <div class="page-header">
          <div><h2>Beauty Journal</h2><p>Manage articles and blog posts.</p></div>
          <button class="btn btn-primary" onclick="toggleJournalForm()">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Article
          </button>
        </div>

        <div class="form-overlay" id="journal-form">
          <h4 id="jf-form-heading">Add New Article</h4>
          <div class="form-grid-2">
            <div class="form-field">
              <label>Title</label>
              <input class="form-input" id="jf-title" placeholder="Article title">
            </div>
            <div class="form-field">
              <label>Category</label>
              <select class="form-input" id="jf-category">
                <option value="Beauty Tips">Beauty Tips</option>
                <option value="Skincare">Skincare</option>
                <option value="Makeup">Makeup</option>
                <option value="Fragrance">Fragrance</option>
                <option value="Lifestyle">Lifestyle</option>
              </select>
            </div>
            <div class="form-field">
              <label>Cover Image URL</label>
              <input class="form-input" id="jf-image" placeholder="https://...">
            </div>
            <div class="form-field">
              <label>Read Time (minutes)</label>
              <input class="form-input" id="jf-readtime" type="number" placeholder="5" value="5" min="1">
            </div>
            <div class="form-field full">
              <label>Excerpt (short description)</label>
              <input class="form-input" id="jf-excerpt" placeholder="Brief description shown in card...">
            </div>
            <div class="form-field full">
              <label>Content (HTML supported)</label>
              <textarea class="form-textarea" id="jf-content" rows="8" placeholder="<p>Article content here...</p>&#10;<h2>Section Title</h2>&#10;<p>More content...</p>"></textarea>
            </div>
            <div class="form-field">
              <label>Status</label>
              <select class="form-input" id="jf-status">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
              </select>
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" onclick="saveJournal()">Save Article</button>
            <button class="btn btn-outline" onclick="toggleJournalForm()">Cancel</button>
          </div>
        </div>

        <div class="admin-card">
          <div class="table-toolbar">
            <div class="search-wrap">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
              <input type="text" id="journal-search" placeholder="Search articles..." oninput="filterJournalsTable()">
            </div>
            <div style="display:flex;gap:.5rem;align-items:center;">
              <select class="filter-select" id="journal-status-filter" onchange="filterJournalsTable()">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
              </select>
              <button class="btn btn-outline btn-sm" onclick="loadJournals()">Refresh</button>
            </div>
          </div>
          <div class="admin-card-body">
            <table class="data-table">
              <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Read Time</th><th>Published</th><th>Actions</th></tr></thead>
              <tbody id="journals-table">
                <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--warm-gray);">Loading...</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ── IMPORT ── -->
      <div class="tab-content" id="tab-import">
        <div class="page-header">
          <div><h2>Import from Makeup API</h2><p>Sync products directly from the external Makeup API.</p></div>
        </div>
        <div class="import-card">
          <h3>Import Products</h3>
          <p>Fetch and import up to 10 products from makeup-api.herokuapp.com directly into your local database.</p>
          <div class="form-field" style="margin-bottom:1rem;">
            <label>Brand</label>
            <input class="form-input" id="imp-brand" placeholder="e.g. Maybelline, NYX, Revlon...">
          </div>
          <div class="form-field" style="margin-bottom:1.25rem;">
            <label>Target Category</label>
            <select class="form-input" id="imp-cat"></select>
          </div>
          <button class="btn btn-primary" style="width:100%;" onclick="importFromApi()">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"/></svg>
            Import Now (max 10 products)
          </button>
          <div class="import-result" id="import-result"></div>
        </div>
      </div>

    </main>
  </div>
</div>

<div class="toast" id="toast"></div>
<div id="loading-overlay"><div class="spinner"></div></div>

<script>
const API = '/api';
const GW  = '/gateway';

/* ── Axios ── */
axios.interceptors.request.use(cfg => {
  const token = localStorage.getItem('gm_token') || localStorage.getItem('token');
  if (token) cfg.headers.Authorization = 'Bearer ' + token;
  return cfg;
});
axios.interceptors.response.use(r => r, err => {
  if (err.response?.status === 401) {
    localStorage.clear();
    window.location.href = '/login';
  }
  return Promise.reject(err);
});

function toast(msg, type='') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'toast show ' + (type || '');
  setTimeout(() => t.className = 'toast', 3200);
}
function loading(v) { document.getElementById('loading-overlay').style.display = v ? 'flex' : 'none'; }
function getUser() {
  try { return JSON.parse(localStorage.getItem('gm_user')) || JSON.parse(localStorage.getItem('user')); }
  catch { return null; }
}
function formatRp(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

/* ── Tab switching ── */
const tabTitles = {
  dashboard: 'Dashboard',
  orders:    'Orders',
  products:  'Products',
  users:     'Customers',
  journals:  'Beauty Journal',
  import:    'Import API',
};
function showTab(name, btn) {
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.sidebar-nav-item').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  if (btn) btn.classList.add('active');
  document.getElementById('topbar-title').textContent = tabTitles[name] || name;
  if (name === 'orders')   loadAllOrders();
  if (name === 'products') loadAdminProducts();
  if (name === 'users')    loadUsers();
  if (name === 'journals') loadJournals();
}

/* ── Check admin ── */
async function checkAdmin() {
  const user = getUser();
  if (!user || user.role !== 'admin') {
    document.querySelector('.admin-layout').innerHTML = `
      <div style="display:flex;align-items:center;justify-content:center;min-height:100vh;flex-direction:column;gap:1rem;text-align:center;padding:2rem;">
        <div style="font-size:2rem;opacity:.4;">🚫</div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:400;">Access Denied</h2>
        <p style="color:var(--warm-gray);font-size:.85rem;">This page is restricted to administrators only.</p>
        <a href="/" style="background:var(--charcoal);color:white;padding:.65rem 1.5rem;border-radius:3px;text-decoration:none;font-size:.8rem;font-family:'Jost',sans-serif;letter-spacing:.08em;text-transform:uppercase;">Back to Store</a>
      </div>`;
    return;
  }
  const initials = user.name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
  ['sb-avatar', 'tb-avatar'].forEach(id => document.getElementById(id).textContent = initials);
  ['sb-name',   'tb-name'  ].forEach(id => document.getElementById(id).textContent = user.name);
  loadDashboard();
  loadCategoriesForForm();
}

/* ── Dashboard ── */
async function loadDashboard() {
  try {
    const r = await axios.get(API + '/admin/dashboard');
    const d = r.data.data;
    const pending = (d.recent_orders || []).filter(o => o.status === 'pending').length;
    document.getElementById('pending-count').textContent = pending || 0;

    document.getElementById('stats').innerHTML = `
      <div class="stat-card">
        <div>
          <div class="stat-label">Total Revenue</div>
          <div class="stat-num">${formatRp(d.total_revenue)}</div>
          <div class="stat-sub up">↑ All time</div>
        </div>
        <div class="stat-icon stat-icon-rose">💰</div>
      </div>
      <div class="stat-card">
        <div>
          <div class="stat-label">Total Orders</div>
          <div class="stat-num">${d.total_orders}</div>
          <div class="stat-sub">All orders</div>
        </div>
        <div class="stat-icon stat-icon-blue">📦</div>
      </div>
      <div class="stat-card">
        <div>
          <div class="stat-label">Products</div>
          <div class="stat-num">${d.total_products}</div>
          <div class="stat-sub">In catalogue</div>
        </div>
        <div class="stat-icon stat-icon-gold">✨</div>
      </div>
      <div class="stat-card">
        <div>
          <div class="stat-label">Customers</div>
          <div class="stat-num">${d.total_users}</div>
          <div class="stat-sub">Registered</div>
        </div>
        <div class="stat-icon stat-icon-green">👤</div>
      </div>`;

    document.getElementById('recent-orders').innerHTML =
      (d.recent_orders || []).map(o => `
        <tr>
          <td class="font-mono">${o.order_number}</td>
          <td>${o.user?.name || '—'}</td>
          <td style="font-weight:600;">${formatRp(o.total)}</td>
          <td><span class="status-badge s-${o.status}">${o.status}</span></td>
          <td style="color:var(--warm-gray);">${new Date(o.created_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})}</td>
        </tr>`).join('') ||
      '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--warm-gray);">No recent orders.</td></tr>';
  } catch {
    document.getElementById('stats').innerHTML = '<p style="color:var(--warm-gray);padding:1rem;">Failed to load stats.</p>';
  }
}

/* ── Orders ── */
let allOrdersData = [];
async function loadAllOrders() {
  try {
    const r = await axios.get(API + '/admin/orders');
    allOrdersData = r.data.data.data || [];
    renderOrdersTable(allOrdersData);
  } catch {
    document.getElementById('all-orders').innerHTML =
      '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--warm-gray);">Failed to load orders.</td></tr>';
  }
}
function renderOrdersTable(orders) {
  document.getElementById('all-orders').innerHTML = orders.map(o => `
    <tr>
      <td class="font-mono">${o.order_number}</td>
      <td>${o.user?.name || '—'}</td>
      <td style="font-weight:600;">${formatRp(o.total)}</td>
      <td style="text-transform:capitalize;">${(o.payment_method || '').replace('_', ' ')}</td>
      <td><span class="status-badge s-${o.status}">${o.status}</span></td>
      <td style="color:var(--warm-gray);">${new Date(o.created_at).toLocaleDateString('en-US',{month:'short',day:'numeric'})}</td>
      <td>
        <select class="status-select" onchange="updateStatus(${o.id},this.value)">
          ${['pending','processing','shipped','delivered','cancelled'].map(s =>
            `<option value="${s}" ${s === o.status ? 'selected' : ''}>${s}</option>`).join('')}
        </select>
      </td>
    </tr>`).join('') ||
    '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--warm-gray);">No orders found.</td></tr>';
}
function filterOrdersTable() {
  const q = document.getElementById('order-search').value.toLowerCase();
  const s = document.getElementById('order-status-filter').value;
  renderOrdersTable(allOrdersData.filter(o =>
    (!q || o.order_number?.toLowerCase().includes(q) || o.user?.name?.toLowerCase().includes(q)) &&
    (!s || o.status === s)
  ));
}
async function updateStatus(id, status) {
  try {
    await axios.put(API + '/admin/orders/' + id + '/status', { status });
    toast('Status updated ✓', 'success');
  } catch { toast('Failed to update status', 'error'); }
}

/* ── Products ── */
let allProductsData = [];
async function loadAdminProducts() {
  try {
    const r = await axios.get(API + '/products?per_page=100');
    allProductsData = r.data.data.data || [];
    renderProductsTable(allProductsData);
  } catch {
    document.getElementById('admin-products').innerHTML =
      '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--warm-gray);">Failed to load products.</td></tr>';
  }
}
function renderProductsTable(products) {
  document.getElementById('admin-products').innerHTML = products.map(p => `
    <tr>
      <td><img class="prod-thumb" src="${p.image || 'https://via.placeholder.com/40?text=P'}" alt="${p.name}"
          onerror="this.src='https://via.placeholder.com/40?text=P'"></td>
      <td style="font-weight:500;color:var(--charcoal);">${p.name}</td>
      <td>${p.brand || '—'}</td>
      <td style="font-weight:600;">${formatRp(p.price)}</td>
      <td>${p.stock}</td>
      <td><span class="status-badge ${p.status === 'active' ? 's-active' : 's-inactive'}">${p.status || 'active'}</span></td>
      <td><button class="btn btn-danger btn-sm" onclick="deleteProduct(${p.id})">Delete</button></td>
    </tr>`).join('') ||
    '<tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--warm-gray);">No products found.</td></tr>';
}
function filterProductsTable() {
  const q = document.getElementById('prod-search').value.toLowerCase();
  renderProductsTable(allProductsData.filter(p =>
    !q || p.name?.toLowerCase().includes(q) || (p.brand || '').toLowerCase().includes(q)
  ));
}
function toggleProductForm() {
  const f = document.getElementById('product-form');
  f.classList.toggle('open');
  if (!f.classList.contains('open')) {
    ['pf-name','pf-brand','pf-price','pf-stock','pf-image','pf-desc'].forEach(id => document.getElementById(id).value = '');
  }
}
async function saveProduct() {
  const data = {
    name:        document.getElementById('pf-name').value.trim(),
    brand:       document.getElementById('pf-brand').value.trim(),
    price:       document.getElementById('pf-price').value,
    stock:       document.getElementById('pf-stock').value,
    category_id: document.getElementById('pf-cat').value,
    image:       document.getElementById('pf-image').value.trim(),
    description: document.getElementById('pf-desc').value.trim(),
  };
  if (!data.name || !data.price) { toast('Name and price are required', 'error'); return; }
  loading(true);
  try {
    await axios.post(API + '/admin/products', data);
    toast('Product saved ✓', 'success');
    toggleProductForm();
    loadAdminProducts();
  } catch(e) {
    const err = e.response?.data?.errors;
    toast(err ? Object.values(err).flat().join(', ') : e.response?.data?.message || 'Failed to save', 'error');
  } finally { loading(false); }
}
async function deleteProduct(id) {
  if (!confirm('Delete this product permanently?')) return;
  loading(true);
  try {
    await axios.delete(API + '/admin/products/' + id);
    toast('Product deleted', 'success');
    loadAdminProducts();
  } catch { toast('Failed to delete', 'error'); }
  finally { loading(false); }
}

/* ── Users ── */
let allUsersData = [];
async function loadUsers() {
  try {
    const r = await axios.get(API + '/admin/users');
    allUsersData = r.data.data.data || [];
    renderUsersTable(allUsersData);
  } catch {
    document.getElementById('admin-users').innerHTML =
      '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--warm-gray);">Failed to load users.</td></tr>';
  }
}
function renderUsersTable(users) {
  document.getElementById('admin-users').innerHTML = users.map(u => `
    <tr>
      <td style="font-weight:500;color:var(--charcoal);">${u.name}</td>
      <td>${u.email}</td>
      <td><span class="status-badge ${u.role === 'admin' ? 's-admin' : 's-customer'}">${u.role}</span></td>
      <td>${u.phone || '—'}</td>
      <td style="color:var(--warm-gray);">${new Date(u.created_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})}</td>
    </tr>`).join('') ||
    '<tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--warm-gray);">No users found.</td></tr>';
}
function filterUsersTable() {
  const q = document.getElementById('user-search').value.toLowerCase();
  const r = document.getElementById('user-role-filter').value;
  renderUsersTable(allUsersData.filter(u =>
    (!q || u.name?.toLowerCase().includes(q) || u.email?.toLowerCase().includes(q)) &&
    (!r || u.role === r)
  ));
}

/* ── Categories ── */
async function loadCategoriesForForm() {
  try {
    const r = await axios.get(API + '/categories');
    const cats = r.data.data || [];
    ['pf-cat', 'imp-cat'].forEach(id => {
      document.getElementById(id).innerHTML = cats.map(c =>
        `<option value="${c.id}">${c.name}</option>`).join('');
    });
  } catch {}
}

/* ── Journals ── */
let allJournalsData = [];
let editJournalId   = null;

async function loadJournals() {
  document.getElementById('journals-table').innerHTML =
    '<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--warm-gray);">Loading...</td></tr>';
  try {
    /* try admin endpoint first, fallback to public */
    let articles = [];
    try {
      const r = await axios.get(API + '/admin/journals?per_page=100');
      articles = r.data.data.data || r.data.data || [];
    } catch {
      const r = await axios.get(API + '/journal?per_page=100');
      articles = r.data.data.data || r.data.data || [];
    }
    allJournalsData = articles;
    renderJournalsTable(allJournalsData);
  } catch {
    document.getElementById('journals-table').innerHTML =
      '<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--warm-gray);">Failed to load articles. Check that the journal API endpoint exists.</td></tr>';
  }
}

function renderJournalsTable(journals) {
  if (!journals.length) {
    document.getElementById('journals-table').innerHTML =
      '<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--warm-gray);">No articles yet. Create your first one!</td></tr>';
    return;
  }
  document.getElementById('journals-table').innerHTML = journals.map(j => `
    <tr>
      <td>
        <div style="font-weight:500;color:var(--charcoal);max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${j.title}</div>
        <div class="journal-excerpt">${j.excerpt ? j.excerpt.substring(0, 70) + '...' : ''}</div>
      </td>
      <td>
        <span style="background:var(--rose-pale);color:var(--rose);font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.2rem .65rem;border-radius:50px;">
          ${j.category}
        </span>
      </td>
      <td><span class="status-badge s-${j.status}">${j.status}</span></td>
      <td>${j.read_time} min</td>
      <td style="color:var(--warm-gray);">
        ${j.published_at ? new Date(j.published_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}) : (j.created_at ? new Date(j.created_at).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}) : '—')}
      </td>
      <td>
        <div style="display:flex;gap:.4rem;flex-wrap:nowrap;">
          <button class="btn btn-outline btn-sm" onclick="editJournal(${j.id})">Edit</button>
          <button class="btn btn-rose-soft btn-sm" onclick="toggleJournalStatus(${j.id})">
            ${j.status === 'published' ? 'Unpublish' : 'Publish'}
          </button>
          <button class="btn btn-danger btn-sm" onclick="deleteJournal(${j.id})">Delete</button>
        </div>
      </td>
    </tr>`).join('');
}

function filterJournalsTable() {
  const q = document.getElementById('journal-search').value.toLowerCase();
  const s = document.getElementById('journal-status-filter').value;
  renderJournalsTable(allJournalsData.filter(j =>
    (!q || j.title?.toLowerCase().includes(q) || j.category?.toLowerCase().includes(q)) &&
    (!s || j.status === s)
  ));
}

function toggleJournalForm(reset = true) {
  const f = document.getElementById('journal-form');
  f.classList.toggle('open');
  if (reset && !f.classList.contains('open')) {
    editJournalId = null;
    document.getElementById('jf-form-heading').textContent = 'Add New Article';
    ['jf-title','jf-image','jf-excerpt','jf-content'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('jf-readtime').value  = '5';
    document.getElementById('jf-status').value   = 'published';
    document.getElementById('jf-category').value = 'Beauty Tips';
  }
  if (f.classList.contains('open')) f.scrollIntoView({ behavior: 'smooth' });
}

function editJournal(id) {
  const j = allJournalsData.find(a => a.id === id);
  if (!j) return;
  editJournalId = id;
  document.getElementById('jf-form-heading').textContent  = 'Edit Article';
  document.getElementById('jf-title').value    = j.title       || '';
  document.getElementById('jf-category').value = j.category    || 'Beauty Tips';
  document.getElementById('jf-image').value    = j.cover_image || '';
  document.getElementById('jf-readtime').value = j.read_time   || 5;
  document.getElementById('jf-excerpt').value  = j.excerpt     || '';
  document.getElementById('jf-content').value  = j.content     || '';
  document.getElementById('jf-status').value   = j.status      || 'published';
  const f = document.getElementById('journal-form');
  if (!f.classList.contains('open')) f.classList.add('open');
  f.scrollIntoView({ behavior: 'smooth' });
}

async function saveJournal() {
  const title   = document.getElementById('jf-title').value.trim();
  const content = document.getElementById('jf-content').value.trim();
  if (!title)   { toast('Title is required', 'error');   return; }
  if (!content) { toast('Content is required', 'error'); return; }

  const data = {
    title,
    content,
    excerpt:     document.getElementById('jf-excerpt').value.trim(),
    cover_image: document.getElementById('jf-image').value.trim() || null,
    category:    document.getElementById('jf-category').value,
    read_time:   parseInt(document.getElementById('jf-readtime').value) || 5,
    status:      document.getElementById('jf-status').value,
  };

  loading(true);
  try {
    if (editJournalId) {
      await axios.put(API + '/admin/journals/' + editJournalId, data);
      toast('Article updated ✓', 'success');
    } else {
      await axios.post(API + '/admin/journals', data);
      toast('Article published ✓', 'success');
    }
    toggleJournalForm(true);
    loadJournals();
  } catch(e) {
    const err = e.response?.data?.errors;
    toast(err ? Object.values(err).flat().join(', ') : e.response?.data?.message || 'Failed to save', 'error');
  } finally { loading(false); }
}

async function toggleJournalStatus(id) {
  try {
    /* try PATCH toggle, fallback to reading current status then PUT */
    const j = allJournalsData.find(a => a.id === id);
    try {
      await axios.patch(API + '/admin/journals/' + id + '/toggle');
    } catch {
      const newStatus = j?.status === 'published' ? 'draft' : 'published';
      await axios.put(API + '/admin/journals/' + id, { ...j, status: newStatus });
    }
    toast('Status updated ✓', 'success');
    loadJournals();
  } catch { toast('Failed to update status', 'error'); }
}

async function deleteJournal(id) {
  if (!confirm('Delete this article permanently?')) return;
  loading(true);
  try {
    await axios.delete(API + '/admin/journals/' + id);
    toast('Article deleted', 'success');
    loadJournals();
  } catch { toast('Failed to delete', 'error'); }
  finally { loading(false); }
}

/* ── Import ── */
async function importFromApi() {
  const brand = document.getElementById('imp-brand').value.trim();
  const cat   = document.getElementById('imp-cat').value;
  if (!brand || !cat) { toast('Enter brand and select category', 'error'); return; }
  loading(true);
  try {
    const r = await axios.post(API + '/admin/external/makeup/import', { brand, category_id: cat });
    const el = document.getElementById('import-result');
    el.textContent   = r.data.message;
    el.style.display = 'block';
    toast(r.data.message, 'success');
    loadAdminProducts();
  } catch(e) {
    toast(e.response?.data?.message || 'Import failed', 'error');
  } finally { loading(false); }
}

/* ── Sign out ── */
async function logout() {
  try { await axios.post(API + '/auth/logout'); } catch {}
  localStorage.clear();
  window.location.href = '/login';
}

/* ── Init ── */
checkAdmin();
</script>
</body>
</html>
ENDOFFILE
Output
