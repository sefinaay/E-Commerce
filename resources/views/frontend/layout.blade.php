<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','GlowMart') ✨</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>
:root{
  --rose:#E8637A;--blush:#F4A5B0;--cream:#FDF6F0;--charcoal:#2C2C2C;
  --gold:#C9A96E;--white:#FFFFFF;--soft:#F9F0F3;--border:#EFE0E5;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--charcoal);}
nav{background:var(--white);border-bottom:1px solid var(--border);padding:0 2rem;display:flex;align-items:center;justify-content:space-between;height:64px;position:sticky;top:0;z-index:100;}
.logo{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:600;color:var(--rose);text-decoration:none;letter-spacing:1px;}
.nav-links{display:flex;gap:1.5rem;align-items:center;}
.nav-links a{text-decoration:none;color:var(--charcoal);font-size:.9rem;font-weight:500;transition:.2s;}
.nav-links a:hover{color:var(--rose);}
.btn{padding:.5rem 1.25rem;border-radius:50px;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:500;font-size:.85rem;transition:.2s;}
.btn-primary{background:var(--rose);color:white;}
.btn-primary:hover{background:#d45570;}
.btn-outline{background:transparent;border:1.5px solid var(--rose);color:var(--rose);}
.btn-outline:hover{background:var(--rose);color:white;}
.badge{background:var(--rose);color:white;border-radius:50%;width:18px;height:18px;font-size:.65rem;display:inline-flex;align-items:center;justify-content:center;margin-left:4px;}
main{min-height:calc(100vh - 64px - 60px);}
footer{background:var(--charcoal);color:#ccc;text-align:center;padding:1rem;font-size:.8rem;}
.toast{position:fixed;bottom:1.5rem;right:1.5rem;background:var(--charcoal);color:white;padding:.75rem 1.25rem;border-radius:8px;z-index:9999;font-size:.85rem;opacity:0;transition:.3s;pointer-events:none;}
.toast.show{opacity:1;}
.toast.success{background:#2E7D32;}
.toast.error{background:#C62828;}
#loading-overlay{position:fixed;inset:0;background:rgba(255,255,255,.7);display:none;align-items:center;justify-content:center;z-index:9998;}
.spinner{width:40px;height:40px;border:3px solid var(--border);border-top-color:var(--rose);border-radius:50%;animation:spin 1s linear infinite;}
@keyframes spin{to{transform:rotate(360deg);}}
</style>
@yield('head')
</head>
<body>
<nav>
  <a class="logo" href="/">GlowMart</a>
  <div class="nav-links">
    <a href="/shop">Belanja</a>
    <a href="/discover">Discover</a>
    <a href="/cart">🛒 Keranjang <span class="badge" id="cart-count">0</span></a>
    <span id="nav-auth"></span>
  </div>
</nav>
<main>@yield('content')</main>
<footer>© 2024 GlowMart — Beauty for Everyone ✨</footer>
<div class="toast" id="toast"></div>
<div id="loading-overlay"><div class="spinner"></div></div>

<script>
const API = '/api';
const GW  = '/gateway';

// Axios interceptor — JWT
axios.interceptors.request.use(cfg => {
  const token = localStorage.getItem('token');
  if (token) cfg.headers.Authorization = 'Bearer ' + token;
  return cfg;
});
axios.interceptors.response.use(r => r, err => {
  if (err.response?.status === 401) {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    window.location.href = '/login';
  }
  return Promise.reject(err);
});

function toast(msg, type='') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'toast show '+(type||'');
  setTimeout(()=>t.className='toast', 3000);
}
function loading(v) {
  document.getElementById('loading-overlay').style.display = v ? 'flex' : 'none';
}
function getUser() {
  try { return JSON.parse(localStorage.getItem('user')); } catch { return null; }
}

// Nav auth state
async function renderNav() {
  const user = getUser();
  const el   = document.getElementById('nav-auth');
  if (user) {
    el.innerHTML = `
      ${user.role==='admin'?'<a href="/admin">Admin Panel</a>':''}
      <a href="/orders">Pesanan</a>
      <a href="/profile">${user.name.split(' ')[0]}</a>
      <button class="btn btn-outline" onclick="logout()">Keluar</button>`;
    updateCartBadge();
  } else {
    el.innerHTML = '<a href="/login"><button class="btn btn-primary">Masuk</button></a>';
  }
}

async function updateCartBadge() {
  try {
    const r = await axios.get(API+'/cart');
    const count = r.data.data.items.length;
    document.getElementById('cart-count').textContent = count;
  } catch {}
}

async function logout() {
  try { await axios.post(API+'/auth/logout'); } catch {}
  localStorage.clear();
  toast('Logout berhasil','success');
  setTimeout(()=>window.location.href='/',500);
}

function formatRp(n) {
  return 'Rp ' + Number(n).toLocaleString('id-ID');
}

renderNav();
</script>
@yield('scripts')
</body>
</html>