@extends('frontend.layout')
@section('title','My Profile - GlowMart')
@section('head')
<style>

/* ── Page layout ── */
.profile-page {
  max-width: 1320px;
  margin: 0 auto;
  padding: 3rem 3rem 5rem;
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 2.5rem;
  align-items: start;
}

/* ══ SIDEBAR ══ */
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
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: var(--rose-pale);
  color: var(--rose);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Playfair Display', serif;
  font-size: 1.75rem;
  font-weight: 500;
  margin: 0 auto 1rem;
  border: 2px solid var(--border-light);
}
.sidebar-name {
  font-family: 'Playfair Display', serif;
  font-size: 1rem;
  font-weight: 500;
  color: var(--charcoal);
  margin-bottom: .2rem;
}
.sidebar-email {
  font-size: .75rem;
  color: var(--warm-gray);
  margin-bottom: .75rem;
}
.sidebar-role-badge {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  padding: .3rem .8rem;
  border-radius: 50px;
  background: var(--rose-pale);
  color: var(--rose);
}

/* Nav links */
.sidebar-nav-item {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: .75rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-size: .82rem;
  color: var(--charcoal-mid);
  font-weight: 500;
  transition: all .18s;
  border: none;
  background: none;
  font-family: 'Jost', sans-serif;
  width: 100%;
  text-align: left;
  text-decoration: none;
}
.sidebar-nav-item:hover { background: var(--soft-bg); color: var(--charcoal); }
.sidebar-nav-item.active { background: var(--charcoal); color: white; }
.sidebar-nav-item svg { flex-shrink: 0; }

/* ══ MAIN CONTENT ══ */
.profile-main {}

/* Page title */
.profile-page-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.8rem;
  font-weight: 400;
  color: var(--charcoal);
  margin-bottom: .35rem;
}
.profile-page-sub {
  font-size: .8rem;
  color: var(--warm-gray);
  margin-bottom: 2rem;
}

/* Cards */
.profile-card {
  background: white;
  border: 1px solid var(--border-light);
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 1.25rem;
}
.profile-card-head {
  padding: 1.25rem 1.75rem;
  border-bottom: 1px solid var(--border-light);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.profile-card-head h3 {
  font-size: .78rem;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--charcoal);
}
.profile-card-body { padding: 1.75rem; }

/* Form fields */
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.form-field { margin-bottom: 0; }
.form-field.full { grid-column: 1 / -1; }
.form-field label {
  display: block;
  font-size: .68rem;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--warm-gray);
  margin-bottom: .45rem;
}
.form-input {
  width: 100%;
  padding: .7rem 1rem;
  border: 1px solid var(--border);
  border-radius: 4px;
  font-family: 'Jost', sans-serif;
  font-size: .88rem;
  color: var(--charcoal);
  background: white;
  outline: none;
  transition: border-color .18s, box-shadow .18s;
}
.form-input:focus {
  border-color: var(--charcoal);
  box-shadow: 0 0 0 3px rgba(26,26,26,.05);
}
.form-input::placeholder { color: #CFC6CA; }
.form-input[readonly] {
  background: var(--cream);
  color: var(--warm-gray);
  cursor: default;
}
.form-input[readonly]:focus { border-color: var(--border); box-shadow: none; }

/* Card actions */
.card-actions {
  display: flex;
  justify-content: flex-end;
  gap: .75rem;
  padding: 1.25rem 1.75rem;
  border-top: 1px solid var(--border-light);
  background: var(--cream);
}

/* Password strength */
.strength-bar-wrap { display: flex; gap: .3rem; margin-top: .4rem; }
.strength-seg {
  flex: 1; height: 3px; border-radius: 2px;
  background: var(--border-light); transition: background .25s;
}
.strength-seg.weak   { background: #e53e3e; }
.strength-seg.medium { background: #E8A800; }
.strength-seg.strong { background: #2E7D32; }

/* Stats row */
.stats-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1px;
  background: var(--border-light);
  border: 1px solid var(--border-light);
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 1.25rem;
}
.stat-box {
  background: white;
  padding: 1.5rem;
  text-align: center;
}
.stat-num {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 400;
  color: var(--charcoal);
  display: block;
  margin-bottom: .25rem;
}
.stat-lbl {
  font-size: .68rem;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--warm-gray);
  font-weight: 600;
}

/* Danger zone */
.danger-btn {
  background: none;
  border: 1.5px solid #e53e3e;
  color: #e53e3e;
  padding: .55rem 1.25rem;
  border-radius: 4px;
  font-family: 'Jost', sans-serif;
  font-size: .75rem;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  cursor: pointer;
  transition: all .18s;
}
.danger-btn:hover { background: #e53e3e; color: white; }

@media (max-width: 900px) {
  .profile-page { grid-template-columns: 1fr; padding: 2rem 1.25rem 4rem; }
  .profile-sidebar { position: static; flex-direction: row; flex-wrap: wrap; }
  .sidebar-avatar-wrap { width: 100%; }
  .form-grid-2 { grid-template-columns: 1fr; }
  .stats-row { grid-template-columns: repeat(3, 1fr); }
}
</style>
@endsection

@section('content')
<div class="profile-page">

  {{-- ══ SIDEBAR ══ --}}
  <aside class="profile-sidebar">

    <div class="sidebar-avatar-wrap">
      <div class="sidebar-avatar" id="sidebar-avatar">?</div>
      <div class="sidebar-name"  id="sidebar-name">Loading...</div>
      <div class="sidebar-email" id="sidebar-email">—</div>
      <span class="sidebar-role-badge" id="sidebar-role">Customer</span>
    </div>

    <a href="/profile"  class="sidebar-nav-item active">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Personal Info
    </a>
    <a href="/orders" class="sidebar-nav-item">
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
  <div class="profile-main">

    <h1 class="profile-page-title">Personal Information</h1>
    <p class="profile-page-sub">Manage your GlowMart account details and preferences.</p>

    {{-- Stats --}}
    <div class="stats-row">
      <div class="stat-box">
        <span class="stat-num" id="stat-orders">—</span>
        <span class="stat-lbl">Orders</span>
      </div>
      <div class="stat-box">
        <span class="stat-num" id="stat-wishlist">—</span>
        <span class="stat-lbl">Wishlist</span>
      </div>
      <div class="stat-box">
        <span class="stat-num" id="stat-reviews">—</span>
        <span class="stat-lbl">Reviews</span>
      </div>
    </div>

    {{-- Personal details card --}}
    <div class="profile-card">
      <div class="profile-card-head">
        <h3>Account Details</h3>
      </div>
      <div class="profile-card-body">
        <div class="form-grid-2">
          <div class="form-field">
            <label>Full Name</label>
            <input class="form-input" id="p-name" type="text" placeholder="Your name">
          </div>
          <div class="form-field">
            <label>Email Address</label>
            <input class="form-input" id="p-email" type="email" readonly>
          </div>
          <div class="form-field">
            <label>Phone Number</label>
            <input class="form-input" id="p-phone" type="tel" placeholder="08xxxxxxxxxx">
          </div>
          <div class="form-field">
            <label>Role</label>
            <input class="form-input" id="p-role" readonly>
          </div>
          <div class="form-field full">
            <label>Shipping Address</label>
            <input class="form-input" id="p-address" type="text" placeholder="123 Beauty Lane, Jakarta">
          </div>
        </div>
      </div>
      <div class="card-actions">
        <button class="btn btn-outline" style="padding:.55rem 1.4rem;font-size:.75rem;" onclick="loadProfile()">Cancel</button>
        <button class="btn btn-primary" style="padding:.55rem 1.4rem;font-size:.75rem;" onclick="updateProfile()">Save Changes</button>
      </div>
    </div>

    {{-- Change password card --}}
    <div class="profile-card">
      <div class="profile-card-head">
        <h3>Change Password</h3>
      </div>
      <div class="profile-card-body">
        <div class="form-grid-2">
          <div class="form-field full">
            <label>Current Password</label>
            <input class="form-input" id="p-pw-current" type="password" placeholder="••••••••">
          </div>
          <div class="form-field">
            <label>New Password</label>
            <input class="form-input" id="p-pw-new" type="password" placeholder="Min. 8 characters"
                   oninput="checkStrength(this.value)">
            <div class="strength-bar-wrap">
              <div class="strength-seg" id="sb1"></div>
              <div class="strength-seg" id="sb2"></div>
              <div class="strength-seg" id="sb3"></div>
              <div class="strength-seg" id="sb4"></div>
            </div>
          </div>
          <div class="form-field">
            <label>Confirm New Password</label>
            <input class="form-input" id="p-pw-confirm" type="password" placeholder="Repeat password">
          </div>
        </div>
      </div>
      <div class="card-actions">
        <button class="btn btn-primary" style="padding:.55rem 1.4rem;font-size:.75rem;" onclick="changePassword()">Update Password</button>
      </div>
    </div>

    {{-- Danger zone --}}
    <div class="profile-card">
      <div class="profile-card-head">
        <h3>Danger Zone</h3>
      </div>
      <div class="profile-card-body" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
        <div>
          <div style="font-size:.85rem;font-weight:500;color:var(--charcoal);margin-bottom:.2rem;">Delete Account</div>
          <div style="font-size:.78rem;color:var(--warm-gray);">Permanently remove your account and all associated data.</div>
        </div>
        <button class="danger-btn" onclick="confirmDelete()">Delete Account</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
/* ── Load profile ── */
async function loadProfile() {
  const user = getUser();
  if (!user) { window.location.href = '/login'; return; }

  try {
    const r = await axios.get(API+'/auth/profile');
    const u = r.data.data;
    localStorage.setItem('user', JSON.stringify(u));

    const initials = u.name.split(' ').map(w=>w[0]).join('').slice(0,2).toUpperCase();

    /* sidebar */
    document.getElementById('sidebar-avatar').textContent = initials;
    document.getElementById('sidebar-name').textContent   = u.name;
    document.getElementById('sidebar-email').textContent  = u.email;
    document.getElementById('sidebar-role').textContent   = u.role === 'admin' ? '👑 Admin' : 'Customer';

    /* form */
    document.getElementById('p-name').value    = u.name    || '';
    document.getElementById('p-email').value   = u.email   || '';
    document.getElementById('p-phone').value   = u.phone   || '';
    document.getElementById('p-address').value = u.address || '';
    document.getElementById('p-role').value    = u.role === 'admin' ? 'Administrator' : 'Customer';

    /* load stats */
    loadStats();
  } catch(e) {
    if (e.response?.status === 401) window.location.href = '/login';
  }
}

/* ── Stats ── */
async function loadStats() {
  try {
    const r = await axios.get(API+'/orders');
    document.getElementById('stat-orders').textContent = (r.data.data || []).length;
  } catch { document.getElementById('stat-orders').textContent = '0'; }
  document.getElementById('stat-wishlist').textContent = '—';
  document.getElementById('stat-reviews').textContent  = '—';
}

/* ── Update profile ── */
async function updateProfile() {
  loading(true);
  try {
    await axios.put(API+'/auth/profile', {
      name:    document.getElementById('p-name').value.trim(),
      phone:   document.getElementById('p-phone').value.trim(),
      address: document.getElementById('p-address').value.trim(),
    });
    toast('Profile updated ✓', 'success');
    const r = await axios.get(API+'/auth/profile');
    localStorage.setItem('user', JSON.stringify(r.data.data));
    renderNav();
    loadProfile();
  } catch(e) {
    toast(e.response?.data?.message || 'Failed to update profile', 'error');
  } finally { loading(false); }
}

/* ── Change password ── */
async function changePassword() {
  const current = document.getElementById('p-pw-current').value;
  const pw      = document.getElementById('p-pw-new').value;
  const confirm = document.getElementById('p-pw-confirm').value;

  if (!current) { toast('Enter your current password', 'error'); return; }
  if (pw.length < 8) { toast('New password must be at least 8 characters', 'error'); return; }
  if (pw !== confirm) { toast('Passwords do not match', 'error'); return; }

  loading(true);
  try {
    await axios.put(API+'/auth/password', {
      current_password: current,
      password: pw,
      password_confirmation: confirm,
    });
    toast('Password updated ✓', 'success');
    ['p-pw-current','p-pw-new','p-pw-confirm'].forEach(id => document.getElementById(id).value = '');
    [1,2,3,4].forEach(i => document.getElementById('sb'+i).className = 'strength-seg');
  } catch(e) {
    toast(e.response?.data?.message || 'Failed to update password', 'error');
  } finally { loading(false); }
}

/* ── Password strength ── */
function checkStrength(val) {
  let score = 0;
  if (val.length >= 8)           score++;
  if (/[A-Z]/.test(val))         score++;
  if (/[0-9]/.test(val))         score++;
  if (/[^A-Za-z0-9]/.test(val))  score++;
  const cls = score <= 2 ? 'weak' : score === 3 ? 'medium' : 'strong';
  [1,2,3,4].forEach(i => {
    document.getElementById('sb'+i).className = 'strength-seg ' + (i <= score ? cls : '');
  });
}

/* ── Delete account ── */
function confirmDelete() {
  if (!confirm('Are you sure you want to permanently delete your account? This action cannot be undone.')) return;
  toast('Contact support to delete your account.', '');
}

/* ── Init ── */
loadProfile();
</script>
@endsection
