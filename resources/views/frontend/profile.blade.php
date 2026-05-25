@extends('frontend.layout')
@section('title','Profil - GlowMart')
@section('head')
<style>
.profile-wrap{max-width:600px;margin:2rem auto;padding:0 1rem;}
.profile-card{background:white;border:1px solid var(--border);border-radius:16px;padding:2rem;}
.profile-avatar{width:80px;height:80px;border-radius:50%;background:var(--rose);color:white;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.5rem;}
.form-group{margin-bottom:1rem;}
.form-group label{font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem;}
.form-group input{width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:.9rem;}
.form-group input:focus{outline:none;border-color:var(--rose);}
</style>
@endsection
@section('content')
<div class="profile-wrap">
  <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;margin-bottom:1.5rem;text-align:center">Profil Saya</h1>
  <div class="profile-card">
    <div class="profile-avatar" id="avatar-initial">?</div>
    <div class="form-group"><label>Nama Lengkap</label><input id="p-name" placeholder="Nama Anda"></div>
    <div class="form-group"><label>Email</label><input id="p-email" readonly style="background:#f9f9f9;color:#999"></div>
    <div class="form-group"><label>Role</label><input id="p-role" readonly style="background:#f9f9f9;color:#999"></div>
    <div class="form-group"><label>No. HP</label><input id="p-phone" placeholder="08xxxxxxxxxx"></div>
    <div class="form-group"><label>Alamat</label><input id="p-address" placeholder="Alamat Anda"></div>
    <button class="btn btn-primary" style="width:100%;padding:.8rem;font-size:1rem;margin-top:.5rem" onclick="updateProfile()">Simpan Perubahan</button>
  </div>
</div>
@endsection
@section('scripts')
<script>
async function loadProfile() {
  const user = getUser();
  if (!user) { window.location.href='/login'; return; }
  try {
    const r = await axios.get(API+'/auth/profile');
    const u = r.data.data;
    localStorage.setItem('user',JSON.stringify(u));
    document.getElementById('avatar-initial').textContent = u.name.charAt(0).toUpperCase();
    document.getElementById('p-name').value  = u.name;
    document.getElementById('p-email').value = u.email;
    document.getElementById('p-role').value  = u.role === 'admin' ? '👑 Admin' : '🛍️ Customer';
    document.getElementById('p-phone').value = u.phone||'';
    document.getElementById('p-address').value = u.address||'';
  } catch {}
}

async function updateProfile() {
  loading(true);
  try {
    await axios.put(API+'/auth/profile', {
      name: document.getElementById('p-name').value,
      phone: document.getElementById('p-phone').value,
      address: document.getElementById('p-address').value,
    });
    toast('Profil berhasil diperbarui ✓','success');
    const r = await axios.get(API+'/auth/profile');
    localStorage.setItem('user',JSON.stringify(r.data.data));
    renderNav();
  } catch(e) {
    toast(e.response?.data?.message||'Gagal update profil','error');
  } finally { loading(false); }
}

loadProfile();
</script>
@endsection