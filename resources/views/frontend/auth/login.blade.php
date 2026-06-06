@extends('frontend.layout')
@section('title', 'Sign In - GlowMart')
@section('head')
    <style>
        /* ── Override layout bg for auth page ── */
        body {
            background: linear-gradient(135deg, #fce8ef 0%, #fdf0f5 100%);
        }

        /* ── Full page split layout ── */
        .auth-page {
            min-height: calc(100vh - 64px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* ─── Main Container Frame ─── */
        .auth-container {
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* ══ LEFT — Form Side ══ */
        .auth-form-side {
            padding: 3rem 2.5rem;
            background: white;
        }

        /* Brand */
        .auth-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #2d2d2d 0%, #5c3d4e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
        }

        .auth-tagline {
            font-size: 0.65rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #b19ba4;
            margin-bottom: 2rem;
        }

        /* Heading */
        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 500;
            color: #2d2d2d;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            font-size: 0.85rem;
            color: #8e7a83;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Form fields */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #5c3d4e;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1.5px solid #f0e6ea;
            border-radius: 12px;
            font-family: 'Jost', sans-serif;
            font-size: 0.9rem;
            color: #2d2d2d;
            background: #fefcfd;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-wrapper input:focus {
            border-color: #d4a5b4;
            box-shadow: 0 0 0 3px rgba(212, 165, 180, 0.1);
            background: white;
        }

        .input-wrapper input::placeholder {
            color: #cfc6ca;
        }

        /* Remember + Forgot row */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #6b5a63;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #d4a5b4;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: #d4a5b4;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        .forgot-link:hover {
            opacity: 0.7;
        }

        /* Sign in button */
        .btn-signin {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #d4a5b4 0%, #c28b9e 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-family: 'Jost', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }

        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(210, 165, 180, 0.3);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #f0e6ea;
        }

        .divider-text {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #b19ba4;
        }

        /* Social buttons */
        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.7rem;
            border: 1.5px solid #f0e6ea;
            border-radius: 12px;
            background: white;
            font-family: 'Jost', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: #2d2d2d;
            cursor: pointer;
            transition: all 0.2s;
        }

        .social-btn:hover {
            border-color: #d4a5b4;
            background: #fefcfd;
            transform: translateY(-1px);
        }

        .paypal-btn {
            background: #fef7f9;
        }

        .apple-btn {
            background: #fef7f9;
        }

        /* Register link */
        .auth-footer {
            text-align: center;
            font-size: 0.85rem;
            color: #8e7a83;
        }

        .auth-footer a {
            color: #d4a5b4;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .auth-footer a:hover {
            color: #c28b9e;
        }

        /* Error messages */
        .error-message {
            color: #e74c5c;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        /* ══ RIGHT — Image Side ══ */
        .auth-image-side {
            background: linear-gradient(135deg, #fdf0f5 0%, #fce8ef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .image-frame {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .main-image {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: block;
            transition: transform 0.3s ease;
        }

        .main-image:hover {
            transform: scale(1.02);
        }

        /* Floating testimonial card */
        .testimonial-card {
            position: absolute;
            bottom: -1.5rem;
            left: 1rem;
            right: 1rem;
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .stars {
            color: #ffd700;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
        }

        .testimonial-text {
            font-family: 'Playfair Display', serif;
            font-size: 0.85rem;
            font-style: italic;
            color: #2d2d2d;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .testimonial-author {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #d4a5b4;
        }

        /* Floating badge */
        .floating-badge {
            position: absolute;
            top: -1rem;
            right: -1rem;
            background: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: float 2s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive */
        @media (max-width: 900px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .auth-image-side {
                display: none;
            }

            .auth-form-side {
                padding: 2rem;
            }
        }

        @media (max-width: 480px) {
            .social-buttons {
                grid-template-columns: 1fr;
            }

            .auth-form-side {
                padding: 1.5rem;
            }
        }

        /* Loading state */
        .btn-signin.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <!-- LEFT: Form Section -->
        <div class="auth-form-side">
            <div class="auth-brand">GlowMart</div>
            <div class="auth-tagline">ELEVATE YOUR RITUAL</div>

            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Please enter your details to sign in</p>

            <!-- Email Field -->
            <div class="form-group">
                <label>EMAIL ADDRESS</label>
                <div class="input-wrapper">
                    <input type="email" id="email" placeholder="sarah@example.com" autocomplete="email">
                </div>
                <div class="error-message" id="err-email"></div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label>PASSWORD</label>
                <div class="input-wrapper" style="position: relative;">
                    <input type="password" id="password" placeholder="********" autocomplete="current-password">
                    <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #cfc6ca;" onclick="togglePassword()">
                        👁️
                    </span>
                </div>
                <div class="error-message" id="err-password"></div>
            </div>

            <!-- Remember & Forgot -->
            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" id="remember">
                    Remember me
                </label>
                <a href="/forgot-password" class="forgot-link">Forgot password?</a>
            </div>

            <!-- General Error -->
            <div class="error-message" id="err-general" style="text-align: center; margin-bottom: 1rem;"></div>

            <!-- Sign In Button -->
            <button class="btn-signin" id="signin-btn" onclick="handleLogin()">SIGN IN</button>

            <!-- Divider -->
            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">OR CONTINUE WITH</span>
                <div class="divider-line"></div>
            </div>

            <!-- Social Buttons -->
            <div class="social-buttons">
                <button class="social-btn paypal-btn" onclick="handleSocialLogin('paypal')">
                    💳 PAYPAL
                </button>
                <button class="social-btn apple-btn" onclick="handleSocialLogin('apple')">
                    🍎 APPLE ID
                </button>
            </div>

            <!-- Register Link -->
            <div class="auth-footer">
                Don't have an account? <a href="/register">Create one</a>
            </div>
        </div>

        <!-- RIGHT: Image Section with Frame -->
        <div class="auth-image-side">
            <div class="image-frame">
                <img class="main-image" src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500&h=600&fit=crop"
                     alt="Skincare products"
                     onerror="this.src='https://via.placeholder.com/400x500?text=GlowMart'">

                <!-- Floating Badge -->
                <div class="floating-badge">
                    ✨
                </div>

                <!-- Testimonial Card -->
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <div class="testimonial-text">
                        "The products from GlowMart have completely transformed my skincare routine. My skin has never looked more radiant."
                    </div>
                    <div class="testimonial-author">— Sarah J., Verified Customer</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    }

    // Handle social login
    function handleSocialLogin(provider) {
        showToast(`${provider} login coming soon!`, 'info');
    }

    // Show toast notification
    function showToast(message, type = 'info') {
        // You can implement your own toast notification here
        alert(message);
    }

    // Handle login
    async function handleLogin() {
        // Clear previous errors
        document.getElementById('err-email').textContent = '';
        document.getElementById('err-password').textContent = '';
        document.getElementById('err-general').textContent = '';

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const btn = document.getElementById('signin-btn');
        const originalText = btn.textContent;

        // Validation
        if (!email) {
            document.getElementById('err-email').textContent = 'Email is required';
            return;
        }
        if (!password) {
            document.getElementById('err-password').textContent = 'Password is required';
            return;
        }

        // Show loading state
        btn.textContent = 'SIGNING IN...';
        btn.classList.add('loading');

        try {
            // Make API call
            const response = await axios.post(API + '/auth/login', {
                email,
                password
            });

            const { access_token, user } = response.data.data;

            // Store tokens and user data
            localStorage.setItem('token', access_token);
            localStorage.setItem('user', JSON.stringify(user));

            // Show success message
            showToast(`Welcome back, ${user.name.split(' ')[0]}! ✨`, 'success');

            // Redirect based on role
            setTimeout(() => {
                window.location.href = user.role === 'admin' ? '/admin' : '/';
            }, 900);

        } catch (error) {
            // Handle errors
            const errors = error.response?.data?.errors || {};

            if (errors.email) {
                document.getElementById('err-email').textContent = errors.email[0];
            }
            if (errors.password) {
                document.getElementById('err-password').textContent = errors.password[0];
            }

            const errorMessage = error.response?.data?.message || 'Invalid email or password. Please try again.';
            document.getElementById('err-general').textContent = errorMessage;

            // Reset button
            btn.textContent = originalText;
            btn.classList.remove('loading');
        }
    }

    // Enter key support
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            handleLogin();
        }
    });

    // Auto-fill demo (optional - remove in production)
    // This is just for demonstration to match the image
    if (document.getElementById('email').value === '') {
        // Uncomment below for demo purposes
        // document.getElementById('email').value = 'sarah@example.com';
        // document.getElementById('password').value = '********';
    }
</script>
@endsection
