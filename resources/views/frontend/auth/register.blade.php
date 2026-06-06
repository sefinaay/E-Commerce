@extends('frontend.layout')
@section('title', 'Create Account - GlowMart')
@section('head')
<style>
/* ── Override layout bg ── */
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

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 0;
}

.input-wrapper {
    position: relative;
}

.input-wrapper input {
    width: 100%;
    padding: 0.85rem 2.5rem 0.85rem 1rem;
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

.input-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #cfc6ca;
    cursor: pointer;
    display: flex;
    align-items: center;
}

/* Password strength indicator */
.strength-container {
    margin-top: 0.5rem;
}

.strength-bars {
    display: flex;
    gap: 0.3rem;
    margin-bottom: 0.25rem;
}

.strength-bar {
    flex: 1;
    height: 4px;
    border-radius: 2px;
    background: #f0e6ea;
    transition: all 0.3s ease;
}

.strength-bar.weak {
    background: #e74c5c;
}

.strength-bar.medium {
    background: #f39c12;
}

.strength-bar.strong {
    background: #27ae60;
}

.strength-text {
    font-size: 0.7rem;
    color: #b19ba4;
}

/* Terms checkbox */
.terms-group {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin: 1.5rem 0;
}

.terms-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #d4a5b4;
    cursor: pointer;
    flex-shrink: 0;
    margin-top: 2px;
}

.terms-group label {
    font-size: 0.8rem;
    color: #8e7a83;
    line-height: 1.4;
    cursor: pointer;
}

.terms-group a {
    color: #d4a5b4;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.terms-group a:hover {
    color: #c28b9e;
}

/* Submit button */
.btn-create {
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

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(210, 165, 180, 0.3);
}

.btn-create:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
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

.social-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

/* Login link */
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

.general-error {
    text-align: center;
    color: #e74c5c;
    font-size: 0.8rem;
    margin-bottom: 1rem;
    padding: 0.5rem;
    border-radius: 8px;
    background: #fef5f5;
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
    font-size: 1.5rem;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Testimonial card */
.testimonial-card {
    position: absolute;
    bottom: -1.5rem;
    left: 1rem;
    right: 1rem;
    background: white;
    border-radius: 16px;
    padding: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
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
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <!-- LEFT: Form Section -->
        <div class="auth-form-side">
            <div class="auth-brand">GlowMart</div>
            <div class="auth-tagline">ELEVATE YOUR RITUAL</div>

            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join the GlowMart community today</p>

            <!-- Full Name -->
            <div class="form-group">
                <label>FULL NAME</label>
                <div class="input-wrapper">
                    <input type="text" id="name" placeholder="Sarah Jenkins" autocomplete="name">
                    <span class="input-icon">
                        👤
                    </span>
                </div>
                <div class="error-message" id="err-name"></div>
            </div>

            <!-- Email & Phone Row -->
            <div class="form-row">
                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" placeholder="sarah@example.com" autocomplete="email">
                        <span class="input-icon">
                            ✉️
                        </span>
                    </div>
                    <div class="error-message" id="err-email"></div>
                </div>
                <div class="form-group">
                    <label>PHONE (OPTIONAL)</label>
                    <div class="input-wrapper">
                        <input type="tel" id="phone" placeholder="08xxxxxxxxxx" autocomplete="tel">
                        <span class="input-icon">
                            📱
                        </span>
                    </div>
                    <div class="error-message" id="err-phone"></div>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>PASSWORD</label>
                <div class="input-wrapper">
                    <input type="password" id="password" placeholder="Min. 8 characters" autocomplete="new-password" oninput="checkPasswordStrength(this.value)">
                    <span class="input-icon" onclick="togglePassword('password', 'eye-pw')">
                        <span id="eye-pw">👁️</span>
                    </span>
                </div>
                <div class="strength-container">
                    <div class="strength-bars">
                        <div class="strength-bar" id="bar1"></div>
                        <div class="strength-bar" id="bar2"></div>
                        <div class="strength-bar" id="bar3"></div>
                        <div class="strength-bar" id="bar4"></div>
                    </div>
                    <div class="strength-text" id="strength-text"></div>
                </div>
                <div class="error-message" id="err-password"></div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label>CONFIRM PASSWORD</label>
                <div class="input-wrapper">
                    <input type="password" id="password_confirmation" placeholder="Repeat your password" autocomplete="new-password">
                    <span class="input-icon" onclick="togglePassword('password_confirmation', 'eye-confirm')">
                        <span id="eye-confirm">👁️</span>
                    </span>
                </div>
                <div class="error-message" id="err-password_confirmation"></div>
            </div>

            <!-- Terms & Conditions -->
            <div class="terms-group">
                <input type="checkbox" id="terms">
                <label for="terms">
                    I agree to GlowMart's <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>
                </label>
            </div>

            <!-- General Error -->
            <div class="general-error" id="err-general"></div>

            <!-- Create Account Button -->
            <button class="btn-create" id="register-btn" onclick="handleRegister()">CREATE ACCOUNT</button>

            <!-- Divider -->
            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">OR CONTINUE WITH</span>
                <div class="divider-line"></div>
            </div>

            <!-- Social Buttons -->
            <div class="social-buttons">
                <button class="social-btn" onclick="handleSocialSignup('paypal')">
                    <span class="social-icon">💳</span>
                    PAYPAL
                </button>
                <button class="social-btn" onclick="handleSocialSignup('apple')">
                    <span class="social-icon">🍎</span>
                    APPLE ID
                </button>
            </div>

            <!-- Login Link -->
            <div class="auth-footer">
                Already have an account? <a href="/login">Sign in</a>
            </div>
        </div>

        <!-- RIGHT: Image Section -->
        <div class="auth-image-side">
            <div class="image-frame">
                <img class="main-image" src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=500&h=600&fit=crop"
                     alt="GlowMart Products"
                     onerror="this.src='https://via.placeholder.com/400x500?text=GlowMart'">

                <!-- Floating Badge -->
                <div class="floating-badge">
                    ✨
                </div>

                <!-- Testimonial Card -->
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <div class="testimonial-text">
                        "Joining GlowMart was the best beauty decision I've made. Exclusive drops, expert tips, and products that actually work."
                    </div>
                    <div class="testimonial-author">— Maya T., Verified Member</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toggle password visibility
function togglePassword(inputId, eyeId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById(eyeId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = '👁️';
    }
}

// Check password strength
function checkPasswordStrength(password) {
    const bars = ['bar1', 'bar2', 'bar3', 'bar4'];
    const strengthText = document.getElementById('strength-text');

    let strength = 0;

    // Length check
    if (password.length >= 8) strength++;
    // Uppercase check
    if (/[A-Z]/.test(password)) strength++;
    // Number check
    if (/[0-9]/.test(password)) strength++;
    // Special character check
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    // Update bars
    bars.forEach((bar, index) => {
        const barElement = document.getElementById(bar);
        if (index < strength) {
            if (strength <= 2) {
                barElement.className = 'strength-bar weak';
            } else if (strength === 3) {
                barElement.className = 'strength-bar medium';
            } else {
                barElement.className = 'strength-bar strong';
            }
        } else {
            barElement.className = 'strength-bar';
        }
    });

    // Update text
    if (password.length === 0) {
        strengthText.textContent = '';
    } else if (strength <= 2) {
        strengthText.textContent = 'Weak password';
        strengthText.style.color = '#e74c5c';
    } else if (strength === 3) {
        strengthText.textContent = 'Medium password';
        strengthText.style.color = '#f39c12';
    } else {
        strengthText.textContent = 'Strong password';
        strengthText.style.color = '#27ae60';
    }
}

// Handle social signup
function handleSocialSignup(provider) {
    alert(`${provider.toUpperCase()} sign up coming soon!`);
}

// Handle registration
async function handleRegister() {
    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    document.getElementById('err-general').textContent = '';

    // Get form values
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    const terms = document.getElementById('terms').checked;
    const btn = document.getElementById('register-btn');

    // Validation
    let isValid = true;

    if (!name) {
        document.getElementById('err-name').textContent = 'Full name is required';
        isValid = false;
    }

    if (!email) {
        document.getElementById('err-email').textContent = 'Email address is required';
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('err-email').textContent = 'Please enter a valid email address';
        isValid = false;
    }

    if (password.length < 8) {
        document.getElementById('err-password').textContent = 'Password must be at least 8 characters';
        isValid = false;
    }

    if (password !== passwordConfirmation) {
        document.getElementById('err-password_confirmation').textContent = 'Passwords do not match';
        isValid = false;
    }

    if (!terms) {
        document.getElementById('err-general').textContent = 'Please accept the Terms of Service to continue';
        isValid = false;
    }

    if (!isValid) return;

    // Show loading state
    btn.textContent = 'CREATING ACCOUNT...';
    btn.disabled = true;

    try {
        // Make API call
        const response = await axios.post(API + '/auth/register', {
            name: name,
            email: email,
            phone: phone,
            password: password,
            password_confirmation: passwordConfirmation
        });

        const { access_token, user } = response.data.data;

        // Store tokens and user data
        localStorage.setItem('token', access_token);
        localStorage.setItem('user', JSON.stringify(user));

        // Show success message
        alert(`Welcome to GlowMart, ${user.name.split(' ')[0]}! ✨`);

        // Redirect to home page
        setTimeout(() => {
            window.location.href = '/';
        }, 500);

    } catch (error) {
        // Handle validation errors from backend
        const errors = error.response?.data?.errors || {};

        if (errors.name) {
            document.getElementById('err-name').textContent = errors.name[0];
        }
        if (errors.email) {
            document.getElementById('err-email').textContent = errors.email[0];
        }
        if (errors.phone) {
            document.getElementById('err-phone').textContent = errors.phone[0];
        }
        if (errors.password) {
            document.getElementById('err-password').textContent = errors.password[0];
        }
        if (errors.password_confirmation) {
            document.getElementById('err-password_confirmation').textContent = errors.password_confirmation[0];
        }

        const errorMessage = error.response?.data?.message || 'Registration failed. Please try again.';
        document.getElementById('err-general').textContent = errorMessage;

        // Reset button
        btn.textContent = 'CREATE ACCOUNT';
        btn.disabled = false;
    }
}

// Enter key support
document.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        handleRegister();
    }
});
</script>
@endsection
