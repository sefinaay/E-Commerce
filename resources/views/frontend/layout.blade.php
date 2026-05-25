<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GlowMart — Elevate Your Ritual')</title>
    <meta name="description" content="@yield('meta_description', 'Curating premium, clean beauty essentials for your daily ritual.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ============================================
           GLOWMART — DESIGN SYSTEM
           ============================================ */
        :root {
            --pink-primary:    #ff8da1;
            --pink-light:      #ffc2cc;
            --pink-pale:       #fff0f3;
            --pink-soft:       #ffe4ea;
            --pink-deep:       #e8637a;
            --dark:            #333333;
            --dark-muted:      #666666;
            --dark-light:      #999999;
            --white:           #ffffff;
            --off-white:       #fafafa;
            --border:          #f0e4e7;
            --shadow-sm:       0 2px 12px rgba(255,141,161,0.10);
            --shadow-md:       0 8px 32px rgba(255,141,161,0.18);
            --shadow-lg:       0 20px 60px rgba(255,141,161,0.22);
            --radius-sm:       6px;
            --radius-md:       12px;
            --radius-lg:       20px;
            --radius-xl:       32px;
            --radius-full:     999px;
            --font-serif:      'Playfair Display', Georgia, serif;
            --font-sans:       'Poppins', sans-serif;
            --transition:      all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --max-width:       1280px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-sans);
            font-weight: 300;
            color: var(--dark);
            background: var(--white);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ---- ANNOUNCEMENT BAR ---- */
        .announcement-bar {
            background: var(--pink-pale);
            text-align: center;
            padding: 10px 20px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--dark-muted);
            border-bottom: 1px solid var(--border);
        }
        .announcement-bar span { color: var(--pink-deep); font-weight: 600; }

        /* ---- HEADER / NAVBAR ---- */
        .site-header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }
        .header-inner {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 32px;
            height: 68px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 24px;
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 28px;
        }
        .header-nav a {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--dark-muted);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }
        .header-nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--pink-primary);
            transition: var(--transition);
        }
        .header-nav a:hover { color: var(--dark); }
        .header-nav a:hover::after { width: 100%; }
        .header-nav a.active { color: var(--dark); }
        .header-nav a.active::after { width: 100%; }

        .site-logo {
            text-align: center;
            text-decoration: none;
        }
        .site-logo .logo-text {
            font-family: var(--font-serif);
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
            letter-spacing: 0.02em;
        }

        .header-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }
        .header-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--pink-pale);
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            padding: 8px 16px;
            transition: var(--transition);
            min-width: 180px;
        }
        .header-search:focus-within {
            border-color: var(--pink-primary);
            box-shadow: 0 0 0 3px rgba(255,141,161,0.15);
        }
        .header-search input {
            border: none;
            background: transparent;
            font-family: var(--font-sans);
            font-size: 12px;
            color: var(--dark);
            outline: none;
            width: 100%;
        }
        .header-search input::placeholder { color: var(--dark-light); }
        .header-search i { color: var(--dark-light); font-size: 12px; }

        .header-icon-btn {
            width: 38px;
            height: 38px;
            border: none;
            background: transparent;
            border-radius: var(--radius-full);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-muted);
            font-size: 16px;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }
        .header-icon-btn:hover {
            background: var(--pink-pale);
            color: var(--pink-primary);
        }
        .cart-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: var(--pink-primary);
            color: white;
            font-size: 9px;
            font-weight: 600;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---- FOOTER ---- */
        .site-footer {
            background: var(--white);
            border-top: 1px solid var(--border);
            padding: 64px 0 0;
        }
        .footer-inner {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 32px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 48px;
        }
        .footer-brand .logo-text {
            font-family: var(--font-serif);
            font-size: 22px;
            font-weight: 600;
            color: var(--dark);
            display: block;
            margin-bottom: 12px;
        }
        .footer-brand p {
            font-size: 13px;
            color: var(--dark-muted);
            line-height: 1.7;
            max-width: 260px;
            margin-bottom: 24px;
        }
        .footer-newsletter-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--dark);
            margin-bottom: 12px;
        }
        .footer-newsletter {
            display: flex;
            gap: 0;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--border);
        }
        .footer-newsletter input {
            flex: 1;
            padding: 10px 14px;
            border: none;
            font-family: var(--font-sans);
            font-size: 12px;
            outline: none;
            background: var(--pink-pale);
        }
        .footer-newsletter button {
            background: var(--dark);
            color: white;
            border: none;
            padding: 10px 18px;
            font-family: var(--font-sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
        }
        .footer-newsletter button:hover { background: var(--pink-deep); }

        .footer-col h4 {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--dark);
            margin-bottom: 18px;
        }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 10px; }
        .footer-col ul li a {
            font-size: 13px;
            color: var(--dark-muted);
            text-decoration: none;
            transition: var(--transition);
        }
        .footer-col ul li a:hover { color: var(--pink-primary); padding-left: 4px; }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .footer-bottom p { font-size: 12px; color: var(--dark-light); }
        .footer-social {
            display: flex;
            gap: 16px;
        }
        .footer-social a {
            color: var(--dark-muted);
            font-size: 16px;
            text-decoration: none;
            transition: var(--transition);
        }
        .footer-social a:hover { color: var(--pink-primary); }
        .footer-legal {
            display: flex;
            gap: 20px;
        }
        .footer-legal a {
            font-size: 12px;
            color: var(--dark-light);
            text-decoration: none;
        }
        .footer-legal a:hover { color: var(--pink-primary); }

        /* ---- UTILITY / SHARED ---- */
        .container {
            max-width: var(--max-width);
            margin: 0 auto;
            padding: 0 32px;
        }
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
        .btn-ghost:hover { color: var(--pink-primary); gap: 12px; }

        .section-overline {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--pink-primary);
            margin-bottom: 12px;
        }
        .section-title {
            font-family: var(--font-serif);
            font-size: 36px;
            font-weight: 500;
            color: var(--dark);
            line-height: 1.2;
        }

        /* Product Card */
        .product-card {
            background: var(--white);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }
        .product-card-image {
            aspect-ratio: 1;
            background: var(--pink-pale);
            position: relative;
            overflow: hidden;
        }
        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-card-image img { transform: scale(1.05); }
        .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: var(--radius-full);
        }
        .badge-new { background: var(--dark); color: white; }
        .badge-bestseller { background: var(--pink-primary); color: white; }
        .badge-sale { background: #e8637a; color: white; }
        .badge-limited { background: var(--dark-muted); color: white; }
        .product-wishlist-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 32px;
            height: 32px;
            background: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--dark-light);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            text-decoration: none;
        }
        .product-wishlist-btn:hover { color: var(--pink-primary); transform: scale(1.1); }
        .product-card-body {
            padding: 16px;
        }
        .product-brand {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--dark-light);
            margin-bottom: 4px;
        }
        .product-name {
            font-family: var(--font-serif);
            font-size: 16px;
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 6px;
            text-decoration: none;
            display: block;
        }
        .product-name:hover { color: var(--pink-primary); }
        .product-stars { color: var(--pink-primary); font-size: 11px; margin-bottom: 8px; }
        .product-stars span { color: var(--dark-light); font-size: 11px; margin-left: 4px; }
        .product-price {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
        }
        .product-price-old {
            font-size: 13px;
            color: var(--dark-light);
            text-decoration: line-through;
            margin-left: 6px;
            font-weight: 400;
        }

        /* Stars rating */
        .stars { color: var(--pink-primary); }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
        }
        @media (max-width: 768px) {
            .header-inner { grid-template-columns: auto 1fr auto; padding: 0 16px; }
            .header-nav { display: none; }
            .header-search { display: none; }
            .container { padding: 0 16px; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-inner { padding: 0 16px; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--pink-pale); }
        ::-webkit-scrollbar-thumb { background: var(--pink-light); border-radius: 3px; }

        /* Flash messages */
        .alert {
            padding: 14px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-info { background: var(--pink-pale); color: var(--pink-deep); }

        @yield('extra-styles')
    </style>

    @stack('styles')
</head>
<body>
    {{-- Announcement Bar --}}
    <div class="announcement-bar">
        Free shipping on all orders over $50. Use code <span>GLOWUP</span> for 10% off.
    </div>

    {{-- Header --}}
    <header class="site-header">
        <div class="header-inner">
            {{-- Left Nav --}}
            <nav class="header-nav">
                <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
                <a href="{{ route('discover') }}" class="{{ request()->routeIs('discover') ? 'active' : '' }}">Discover</a>
                <a href="#" class="{{ request()->routeIs('brands') ? 'active' : '' }}">Brands</a>
            </nav>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="site-logo">
                <span class="logo-text">GlowMart</span>
            </a>

            {{-- Right Actions --}}
            <div class="header-actions">
                <form action="{{ route('shop') }}" method="GET" class="header-search">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}">
                </form>

                @auth
                    <a href="{{ route('profile') }}" class="header-icon-btn" title="Profile">
                        <i class="far fa-user"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="header-icon-btn" title="Sign In">
                        <i class="far fa-user"></i>
                    </a>
                @endauth

                <a href="#" class="header-icon-btn" title="Wishlist">
                    <i class="far fa-heart"></i>
                </a>

                <a href="{{ route('cart') }}" class="header-icon-btn" title="Cart">
                    <i class="fas fa-shopping-bag"></i>
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="container" style="padding-top:16px;">
            <div class="alert alert-success">
                <i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container" style="padding-top:16px;">
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>{{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <span class="logo-text">GlowMart</span>
                    <p>Curating premium, clean beauty essentials for your daily ritual. Elevate your glow with our thoughtfully selected products.</p>
                    <p class="footer-newsletter-label">Join the Club</p>
                    <form class="footer-newsletter" action="#" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="Email address">
                        <button type="submit">Subscribe</button>
                    </form>
                </div>

                <div class="footer-col">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="#">Skincare</a></li>
                        <li><a href="#">Makeup</a></li>
                        <li><a href="#">Fragrance</a></li>
                        <li><a href="#">Bath & Body</a></li>
                        <li><a href="#">Gifts</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>About</h4>
                    <ul>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Ingredients</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Journal</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Help</h4>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                        <li><a href="{{ route('orders') }}">Track Order</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} GlowMart Beauty. All rights reserved.</p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="footer-legal">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>