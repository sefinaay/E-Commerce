<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GlowMart')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        :root {
            --rose: #E8637A;
            --blush: #F4A5B0;
            --cream: #FDF6F0;
            --charcoal: #2C2C2C;
            --gold: #C9A96E;
            --white: #FFFFFF;
            --soft: #F9F0F3;
            --border: #EFE0E5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
        }

        .toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background: var(--charcoal);
            color: white;
            padding: .75rem 1.25rem;
            border-radius: 8px;
            z-index: 9999;
            font-size: .85rem;
            opacity: 0;
            transition: .3s;
            pointer-events: none;
        }

        .toast.show { opacity: 1; }
        .toast.success { background: #2E7D32; }
        .toast.error { background: #C62828; }

        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9998;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border);
            border-top-color: var(--rose);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    @yield('head')
</head>
<body>
    <main>
        @yield('content')
    </main>

    <div class="toast" id="toast"></div>
    <div id="loading-overlay"><div class="spinner"></div></div>

    <script>
        const API = '/api';
        const GW = '/gateway';

        axios.interceptors.request.use(cfg => {
            const token = localStorage.getItem('token');
            if (token) cfg.headers.Authorization = 'Bearer ' + token;
            return cfg;
        });

        axios.interceptors.response.use(r => r, err => {
            if (err.response?.status === 401) {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                if (!window.location.pathname.includes('/login')) {
                    window.location.href = '/login';
                }
            }
            return Promise.reject(err);
        });

        function toast(msg, type='') {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.className = 'toast show ' + type;
            setTimeout(() => t.className = 'toast', 3000);
        }

        function loading(v) {
            document.getElementById('loading-overlay').style.display = v ? 'flex' : 'none';
        }

        function getUser() {
            try { return JSON.parse(localStorage.getItem('user')); }
            catch { return null; }
        }

        function formatRp(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }
    </script>

    @yield('scripts')
</body>
</html>
