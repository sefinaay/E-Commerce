@extends('frontend.layout')
@section('title','Daftar - GlowMart')
@section('head')
<style>
.auth-wrap{min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem;}
.auth-card{background:white;border-radius:16px;padding:2.5rem;width:100%;max-width:420px;border:1px solid var(--border);}
.auth-card h1{font-family:'Cormorant Garamond',serif;font-size:2rem;text-align:center;margin-bottom:.25rem;}
.form-group{margin-bottom:1rem;}
.form-group label{font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem;}
.form-group input{width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:.9rem;}
.form-group input:focus{outline:none;border-color:var(--rose);}
.error-msg{color:#e53e3e;font-size:.8rem;margin-top:.25rem;}
.submit-btn{width:100%;padding:.8rem;background:var(--rose);color:white;border:none;border-radius:8px;font-size:1rem;cursor:pointer;font-family:inherit;margin-top:.5rem;}
.auth-link{text-align:center;margin-top:1.5rem;font-size:.85rem;color:#666;}
.auth-link a{color:var(--rose);text-decoration:none;font-weight:500;}
</style>
@endsection
@section('content')
<div class="auth-wrap">
  <div class="auth-card">
    <h1>💄 Buat Akun</h1>
    <p style="text-align:center;color:#999;font-size:.85rem;margin-bottom:1.5rem">Bergabung dengan GlowMart hari ini</p>
    <div class="form-group"><label>Nama Lengkap</label><input id="name" placeholder="Nama Anda"><div class="error-msg" id="err-name"></div></div>
    <div class="form-group"><label>Email</label><input type="email" id="email" placeholder="email@example.com"><div class="error-msg" id="err-email"></div></div>
    <div class="form-group"><label>No. HP</label><input id="phone" placeholder="08xxxxxxxxxx"></div>
    <div class="form-group"><label>Password</label><input type="password" id="password" placeholder="Min. 6 karakter"><div class="error-msg" id="err-password"></div></div>
    <div class="form-group"><label>Konfirmasi Password</label><input type="password" id="password_confirmation" placeholder="Ulangi password"></div>
    <button class="submit-btn" onclick="doRegister()">Buat Akun</button>
    <p style="text-align:center;color:#e53e3e;font-size:.85rem;margin-top:.5rem" id="err-general"></p>
    <div class="auth-link">Sudah punya akun? <a href="/login">Masuk</a></div>
  </div>
</div>
@endsection
@section('scripts')
<script>
async function doRegister() {
  document.querySelectorAll('.error-msg').forEach(e=>e.textContent='');
  loading(true);
  try {
    const r = await axios.post(API+'/auth/register', {
      name: document.getElementById('name').value,
      email: document.getElementById('email').value,
      phone: document.getElementById('phone').value,
      password: document.getElementById('password').value,
      password_confirmation: document.getElementById('password_confirmation').value,
    });
    const {access_token,user} = r.data.data;
    localStorage.setItem('token',access_token);
    localStorage.setItem('user',JSON.stringify(user));
    toast('Registrasi berhasil! Selamat datang 🎉','success');
    setTimeout(()=>window.location.href='/',800);
  } catch(e) {
    const errors = e.response?.data?.errors||{};
    ['name','email','password'].forEach(f=>{
      if(errors[f]) document.getElementById('err-'+f).textContent=errors[f][0];
    });
    document.getElementById('err-general').textContent = e.response?.data?.message||'';
  } finally { loading(false); }
}
</script>
@endsection