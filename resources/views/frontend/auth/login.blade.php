@extends('frontend.layout')
@section('title','Login - GlowMart')
@section('head')
<style>
.auth-wrap{min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem;}
.auth-card{background:white;border-radius:16px;padding:2.5rem;width:100%;max-width:400px;border:1px solid var(--border);box-shadow:0 4px 24px rgba(0,0,0,.06);}
.auth-card h1{font-family:'Cormorant Garamond',serif;font-size:2rem;text-align:center;margin-bottom:.25rem;}
.auth-card p{text-align:center;color:#999;font-size:.85rem;margin-bottom:2rem;}
.form-group{margin-bottom:1rem;}
.form-group label{font-size:.8rem;font-weight:600;color:#666;display:block;margin-bottom:.4rem;}
.form-group input{width:100%;padding:.7rem 1rem;border:1.5px solid var(--border);border-radius:8px;font-family:inherit;font-size:.9rem;transition:.2s;}
.form-group input:focus{outline:none;border-color:var(--rose);}
.error-msg{color:#e53e3e;font-size:.8rem;margin-top:.25rem;}
.submit-btn{width:100%;padding:.8rem;background:var(--rose);color:white;border:none;border-radius:8px;font-size:1rem;cursor:pointer;font-family:inherit;margin-top:.5rem;transition:.2s;}
.submit-btn:hover{background:#d45570;}
.auth-link{text-align:center;margin-top:1.5rem;font-size:.85rem;color:#666;}
.auth-link a{color:var(--rose);text-decoration:none;font-weight:500;}
</style>
@endsection
@section('content')
<div class="auth-wrap">
  <div class="auth-card">
    <h1>✨ Selamat Datang</h1>
    <p>Masuk ke akun GlowMart Anda</p>
    <div class="form-group">
      <label>Email</label>
      <input type="email" id="email" placeholder="email@example.com">
      <div class="error-msg" id="err-email"></div>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" id="password" placeholder="••••••••">
      <div class="error-msg" id="err-password"></div>
    </div>
    <button class="submit-btn" onclick="doLogin()">Masuk</button>
    <p style="text-align:center;color:#e53e3e;font-size:.85rem;margin-top:.5rem" id="err-general"></p>
    <div class="auth-link">Belum punya akun? <a href="/register">Daftar sekarang</a></div>
    <div style="margin-top:1rem;padding:1rem;background:var(--soft);border-radius:8px;font-size:.78rem;color:#666;">
      <strong>Demo:</strong><br>
      Admin: admin@glowmart.com / password<br>
      Customer: customer@glowmart.com / password
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
async function doLogin() {
  ['err-email','err-password','err-general'].forEach(id=>document.getElementById(id).textContent='');
  const email    = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  if (!email) { document.getElementById('err-email').textContent='Email wajib diisi'; return; }
  if (!password) { document.getElementById('err-password').textContent='Password wajib diisi'; return; }

  loading(true);
  try {
    const r = await axios.post(API+'/auth/login', {email, password});
    const {access_token, user} = r.data.data;
    localStorage.setItem('token', access_token);
    localStorage.setItem('user', JSON.stringify(user));
    toast('Login berhasil! Selamat datang, '+user.name,'success');
    setTimeout(()=>window.location.href = user.role==='admin' ? '/admin' : '/', 800);
  } catch(e) {
    const errors = e.response?.data?.errors;
    if (errors?.email) document.getElementById('err-email').textContent = errors.email[0];
    if (errors?.password) document.getElementById('err-password').textContent = errors.password[0];
    document.getElementById('err-general').textContent = e.response?.data?.message || 'Login gagal';
  } finally {
    loading(false);
  }
}
document.addEventListener('keydown', e => { if(e.key==='Enter') doLogin(); });
</script>
@endsection