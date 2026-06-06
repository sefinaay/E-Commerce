<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GlowMart') ✨</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="/js/axios.min.js"></script>
    <style>
        :root {
            --rose: #C8506A;
            --rose-light: #E8A0AD;
            --rose-pale: #F7E8EC;
            --cream: #FAF7F4;
            --charcoal: #1A1A1A;
            --charcoal-mid: #3D3D3D;
            --warm-gray: #8A8178;
            --gold: #B8966A;
            --white: #FFFFFF;
            --border: #EDE3E7;
            --border-light: #F3EBEE;
            --soft-bg: #FDF2F5;
            --pink-primary: #ff8da1;
            --pink-light: #ffc2cc;
            --pink-pale: #fff0f3;
            --pink-soft: #ffe4ea;
            --pink-deep: #e8637a;
            --dark: #333333;
            --dark-muted: #666666;
            --dark-light: #999999;
            --white: #ffffff;
            --off-white: #fafafa;
            --border: #f0e4e7;
            --shadow-sm: 0 2px 12px rgba(255, 141, 161, 0.10);
            --shadow-md: 0 8px 32px rgba(255, 141, 161, 0.18);
            --shadow-lg: 0 20px 60px rgba(255, 141, 161, 0.22);
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 32px;
            --radius-full: 999px;
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Poppins', sans-serif;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --max-width: 1280px;

        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            font-size: 15px;
            line-height: 1.6;
        }

        /* ── Announcement Bar ── */
        .announcement-bar {
            background: var(--charcoal);
            color: rgba(255, 255, 255, .8);
            text-align: center;
            padding: .4rem 1rem;
            font-size: .75rem;
            letter-spacing: .06em;
        }

        .announcement-bar span {
            color: var(--rose-light);
        }

        /* Hero Section */
        .container {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 32px;
        }

        /* ── Navigation — logo di tengah dengan absolute ── */
        .nav-wrapper {
            background: var(--white);
            border-bottom: 1px solid var(--border-light);
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 200;
        }

        .nav-inner {
            position: relative;
            /* penting agar .logo absolute bekerja */
            max-width: 100%;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
        }

        .nav-left {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-left a {
            text-decoration: none;
            color: var(--charcoal-mid);
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            transition: color .2s;
        }

        .nav-left a:hover {
            color: var(--rose);
        }

        /* Logo tepat tengah */
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--charcoal);
            text-decoration: none;
            letter-spacing: .5px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            pointer-events: auto;
        }

        .nav-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-right a {
            text-decoration: none;
            color: var(--charcoal-mid);
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .05em;
            transition: color .2s;
        }

        .nav-right a:hover {
            color: var(--rose);
        }

        .nav-icon {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--charcoal);
            display: flex;
            align-items: center;
            gap: .25rem;
            transition: color .2s;
            font-family: 'Jost', sans-serif;
            font-size: .78rem;
        }

        .nav-icon:hover {
            color: var(--rose);
        }

        .cart-badge {
            background: var(--rose);
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: .58rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-left: 1px;
        }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--pink-primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: var(--radius-full);
            font-family: var(--font-sans);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.04em;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--pink-deep);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: transparent;
            color: var(--dark);
            border: 1.5px solid var(--dark);
            padding: 13px 30px;
            border-radius: var(--radius-full);
            font-family: var(--font-sans);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.04em;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--dark);
            color: white;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--dark);
            border: none;
            padding: 10px 0;
            font-family: var(--font-sans);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-ghost:hover {
            color: var(--pink-primary);
            gap: 12px;
        }

        /* .btn{padding:.6rem 1.6rem;border-radius:2px;border:none;cursor:pointer;font-family:'Jost',sans-serif;font-weight:500;font-size:.78rem;letter-spacing:.1em;text-transform:uppercase;transition:all .22s;text-decoration:none;display:inline-block;}
.btn-primary{background:var(--charcoal);color:white;}
.btn-primary:hover{background:var(--rose);} */

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--charcoal);
            color: var(--charcoal);
            border-radius: 40px;
        }

        .btn-outline:hover {
            background: var(--charcoal);
            color: white;
        }

        .btn-outline-white {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, .8);
            color: white;
            border-radius: 40px;
        }

        .btn-outline-white:hover {
            background: white;
            color: var(--charcoal);
        }

        /* ── Layout helpers ── */
        main {
            min-height: calc(100vh - 64px - 36px);
        }

        .section {
            padding: 4rem 3rem;
            max-width: 1320px;
            margin: 0 auto;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: .35rem;
        }

        .section-subtitle {
            color: var(--warm-gray);
            font-size: .82rem;
            letter-spacing: .04em;
            margin-bottom: 0;
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .explore-link {
            font-size: .72rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            padding-bottom: 2px;
            transition: color .2s, border-color .2s;
        }

        .explore-link:hover {
            color: var(--rose);
            border-color: var(--rose);
        }

        /* ── Footer ── */
        footer {
            background: var(--charcoal);
            color: rgba(255, 255, 255, .5);
        }

        .footer-inner {
            max-width: 1320px;
            margin: 0 auto;
            padding: 4rem 3rem 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
        }

        .footer-brand .logo-foot {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: white;
            display: block;
            margin-bottom: 1rem;
        }

        .footer-brand p {
            font-size: .8rem;
            line-height: 1.8;
            max-width: 230px;
            color: rgba(255, 255, 255, .4);
        }

        .footer-social {
            display: flex;
            gap: .65rem;
            margin-top: 1.5rem;
        }

        .footer-social a {
            width: 32px;
            height: 32px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, .5);
            text-decoration: none;
            font-size: .82rem;
            transition: all .2s;
        }

        .footer-social a:hover {
            border-color: var(--rose-light);
            color: var(--rose-light);
        }

        .footer-col h4 {
            font-size: .7rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 600;
            color: rgba(255, 255, 255, .7);
            margin-bottom: 1.2rem;
        }

        .footer-col a {
            display: block;
            color: rgba(255, 255, 255, .4);
            text-decoration: none;
            font-size: .8rem;
            margin-bottom: .6rem;
            transition: color .2s;
        }

        .footer-col a:hover {
            color: rgba(255, 255, 255, .85);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .08);
            max-width: 1320px;
            margin: 0 auto;
            padding: 1.25rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .72rem;
            color: rgba(255, 255, 255, .3);
        }

        /* ── Toast & Loader ── */
        .toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background: var(--charcoal);
            color: white;
            padding: .75rem 1.3rem;
            border-radius: 3px;
            z-index: 9999;
            font-size: .8rem;
            opacity: 0;
            transition: opacity .3s;
            pointer-events: none;
            border-left: 3px solid var(--rose);
        }

        .toast.show {
            opacity: 1;
        }

        .toast.success {
            border-left-color: #2E7D32;
        }

        .toast.error {
            border-left-color: #C62828;
        }

        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(250, 247, 244, .75);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9998;
        }

        .spinner {
            width: 34px;
            height: 34px;
            border: 2.5px solid var(--border);
            border-top-color: var(--rose);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media(max-width:768px) {
            .nav-inner {
                padding: 0 1.25rem;
            }

            .nav-left {
                display: none;
            }

            .logo {
                position: static;
                transform: none;
            }

            .section {
                padding: 3rem 1.25rem;
            }

            .footer-inner {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                gap: .4rem;
                text-align: center;
            }
        }
    </style>
    @yield('head')
</head>

<body>

    <div class="announcement-bar">
        Complimentary Signature Gift with every order over <span>Rp 750.000</span> &nbsp;—&nbsp; Free Ongkir
        se-Indonesia
    </div>

    <div class="nav-wrapper">
        <div class="nav-inner">
            <div class="nav-left">
                <a href="/shop">Shop</a>
                <a href="/discover">Collections</a>
                <a href="/journal">Journal</a>
            </div>

            <a class="logo" href="/">GlowMart</a>

            <div class="nav-right" id="nav-auth">
                {{-- filled by JS --}}
            </div>
        </div>
    </div>

    <main>@yield('content')</main>

    <footer>
        <div class="footer-inner">
            <div class="footer-brand">
                <span class="logo-foot">GlowMart</span>
                <p>Curating premium, clean beauty essentials for your daily rituals. Sustainability and transparency in
                    every step.</p>
                <div class="footer-social">
                    <a href="#" aria-label="TikTok">𝕋</a>
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="Pinterest">⊕</a>
                    <a href="#" aria-label="YouTube">▷</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Shop</h4>
                <a href="/shop?cat=skincare">Skincare</a>
                <a href="/shop?cat=makeup">Makeup</a>
                <a href="/shop?cat=fragrance">Fragrance</a>
                <a href="/shop?cat=haircare">Haircare</a>
            </div>
            <div class="footer-col">
                <h4>Information</h4>
                <a href="/about">Our Story</a>
                <a href="/sustainability">Sustainability</a>
                <a href="/ingredients">Ingredients Glossary</a>
                <a href="/journal">Beauty Journal</a>
            </div>
            <div class="footer-col">
                <h4>Support</h4>
                <a href="/help">Customer Care</a>
                <a href="/shipping">Shipping &amp; Returns</a>
                <a href="/orders">Your Orders</a>
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 GlowMart Beauty. All rights reserved.</span>
        </div>
    </footer>

    <div class="toast" id="toast"></div>
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <script>
        const API = '/api';
        const GW = '/gateway';

        axios.interceptors.request.use(cfg => {
            const token = localStorage.getItem('gm_token')
                || localStorage.getItem('token');
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

        function toast(msg, type = '') {
            const t = document.getElementById('toast');
            t.textContent = msg; t.className = 'toast show ' + (type || '');
            setTimeout(() => t.className = 'toast', 3000);
        }
        function loading(v) { document.getElementById('loading-overlay').style.display = v ? 'flex' : 'none'; }
        function getUser() {
            try {
                return JSON.parse(localStorage.getItem('gm_user'))
                    || JSON.parse(localStorage.getItem('user'));
            } catch { return null; }
        }
        function formatRp(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

        const iconSearch = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>`;
        const iconHeart = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>`;
        const iconCart = `<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>`;

        async function renderNav() {
            const user = getUser();
            const el = document.getElementById('nav-auth');
            const cartLink = `<a href="/cart" style="display:flex;align-items:center;gap:3px;text-decoration:none;color:var(--charcoal);">${iconCart}<span class="cart-badge" id="cart-count">0</span></a>`;
            const iconsBase = `
    <button class="nav-icon" onclick="window.location='/search'">${iconSearch}</button>
    <button class="nav-icon" onclick="window.location='/wishlist'">${iconHeart}</button>
    ${cartLink}`;

            if (user) {
                el.innerHTML = `
      ${user.role === 'admin' ? '<a href="/admin">Admin</a>' : ''}
      <a href="/orders">Pesanan</a>
      <a href="/profile">${user.name.split(' ')[0]}</a>
      <button class="btn btn-secondary" style="padding:.35rem 1rem;font-size:.72rem;" onclick="logout()">Keluar</button>
      ${iconsBase}`;
                updateCartBadge();
            } else {
                el.innerHTML = `
      <a href="/login"><button class="btn btn-primary" style="padding:.4rem 1.2rem;font-size:.75rem;">Masuk</button></a>
      ${iconsBase}`;
            }
        }

        async function updateCartBadge() {
            try {
                const r = await axios.get(API + '/cart');
                const c = r.data.data.items.length;
                const el = document.getElementById('cart-count');
                if (el) el.textContent = c;
            } catch { }
        }

        function handleWishlist() {
            if (!getUser()) {
                toast('Please sign in to use your wishlist', 'error');
                return;
            }
            window.location.href = '/wishlist';
        }

        // Tambah di layout.blade.php
        function addToWishlist(productId) {
            if (!getUser()) {
                toast('Please sign in to save items', 'error');
                return;
            }
            const id = Number(productId);
            let items = JSON.parse(localStorage.getItem('gm_wishlist') || '[]').map(Number);

            if (items.includes(id)) {
                items = items.filter(i => i !== id);
                localStorage.setItem('gm_wishlist', JSON.stringify(items));
                toast('Removed from wishlist', '');
            } else {
                items.push(id);
                localStorage.setItem('gm_wishlist', JSON.stringify(items));
                toast('Saved to wishlist ♥', 'success');
            }
        }
        async function logout() {
            try { await axios.post(API + '/auth/logout'); } catch { }
            localStorage.removeItem('gm_token');
            localStorage.removeItem('gm_user');
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            toast('You have been signed out', '');
            setTimeout(() => window.location.href = '/', 500);
        }
        renderNav();
    </script>
    @yield('scripts')
</body>

</html>
