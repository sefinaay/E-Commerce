@extends('frontend.layout')
@section('title', 'Your Shopping Bag - GlowMart')
@section('head')
    <style>
        /* ── Page ── */
        .cart-page {
            max-width: 1320px;
            margin: 0 auto;
            padding: 2.5rem 3rem 5rem;
        }

        .cart-page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 2rem;
        }

        /* Two-column layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2rem;
            align-items: start;
        }

        /* ── Step card shared ── */
        .step-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            margin-bottom: 1.25rem;
            overflow: hidden;
        }

        .step-head {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-light);
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--rose-pale);
            color: var(--rose);
            font-size: .72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-head h2 {
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .04em;
            color: var(--charcoal);
        }

        .step-body {
            padding: 1.5rem;
        }

        /* ── Cart items ── */
        .cart-item {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1.1rem 0;
            border-bottom: 1px solid var(--border-light);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-img {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            overflow: hidden;
            background: var(--soft-bg);
            flex-shrink: 0;
        }

        .cart-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-size: .9rem;
            font-weight: 600;
            color: var(--charcoal);
            margin-bottom: .15rem;
        }

        .cart-item-variant {
            font-size: .72rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--warm-gray);
            margin-bottom: .65rem;
        }

        .cart-qty-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .qty-ctrl-sm {
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 2px;
        }

        .qty-btn-sm {
            width: 28px;
            height: 28px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: var(--charcoal);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
            font-family: 'Jost', sans-serif;
        }

        .qty-btn-sm:hover {
            background: var(--soft-bg);
        }

        .qty-val-sm {
            width: 36px;
            text-align: center;
            font-size: .82rem;
            font-family: 'Jost', sans-serif;
            color: var(--charcoal);
            font-weight: 500;
        }

        .remove-link {
            font-size: .72rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
            cursor: pointer;
            background: none;
            border: none;
            font-family: 'Jost', sans-serif;
            transition: color .15s;
            padding: 0;
        }

        .remove-link:hover {
            color: var(--rose);
        }

        .cart-item-price {
            font-size: .92rem;
            font-weight: 600;
            color: var(--charcoal);
            white-space: nowrap;
            text-align: right;
            min-width: 70px;
        }

        /* ── Shipping form ── */
        .form-grid {
            display: grid;
            gap: 1rem;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-field label {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--warm-gray);
            margin-bottom: .4rem;
        }

        .form-input {
            width: 100%;
            padding: .65rem .85rem;
            border: 1px solid var(--border);
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .85rem;
            color: var(--charcoal);
            background: white;
            outline: none;
            transition: border-color .18s;
        }

        .form-input:focus {
            border-color: var(--charcoal);
        }

        .form-input::placeholder {
            color: var(--border);
        }

        /* ── Payment method ── */
        .pay-methods {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .pay-method-btn {
            flex: 1;
            padding: .9rem .75rem;
            border: 1.5px solid var(--border);
            border-radius: 6px;
            background: white;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            transition: all .18s;
            position: relative;
        }

        .pay-method-btn.active {
            border-color: var(--charcoal);
            background: var(--cream);
        }

        .pay-method-btn .check-dot {
            position: absolute;
            top: .45rem;
            right: .45rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--charcoal);
            display: none;
            align-items: center;
            justify-content: center;
            font-size: .5rem;
            color: white;
        }

        .pay-method-btn.active .check-dot {
            display: flex;
        }

        .pay-icon {
            font-size: 1.3rem;
            line-height: 1;
        }

        .pay-label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--charcoal);
        }

        .card-fields {
            display: grid;
            gap: 1rem;
        }

        .card-num-wrap {
            position: relative;
        }

        .card-chip-icon {
            position: absolute;
            right: .85rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: .8rem;
            color: var(--warm-gray);
            font-weight: 700;
            letter-spacing: .05em;
        }

        /* ── Order Summary (sticky right) ── */
        .order-summary {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            padding: 1.5rem;
            position: sticky;
            top: 80px;
        }

        .order-summary h3 {
            font-size: .9rem;
            font-weight: 600;
            color: var(--charcoal);
            margin-bottom: 1.25rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .8rem;
            font-size: .83rem;
            color: var(--charcoal-mid);
        }

        .summary-row .lbl {
            color: var(--warm-gray);
        }

        .promo-applied {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            background: var(--rose-pale);
            color: var(--rose);
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: .2rem .5rem;
            border-radius: 2px;
        }

        .promo-discount {
            color: var(--rose);
            font-weight: 600;
        }

        .summary-divider {
            border: none;
            border-top: 1px solid var(--border-light);
            margin: 1rem 0;
        }

        .summary-total-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 1.25rem;
        }

        .summary-total-row .total-lbl {
            font-size: .85rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        .summary-total-row .total-amt {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 500;
            color: var(--charcoal);
        }

        /* Promo input */
        .promo-input-row {
            display: flex;
            gap: .5rem;
            margin-bottom: 1.25rem;
        }

        .promo-input {
            flex: 1;
            padding: .6rem .85rem;
            border: 1px solid var(--border);
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .8rem;
            color: var(--charcoal);
            outline: none;
            transition: border-color .18s;
        }

        .promo-input:focus {
            border-color: var(--charcoal);
        }

        .promo-input::placeholder {
            color: var(--border);
            font-size: .8rem;
        }

        .btn-apply {
            padding: .6rem 1rem;
            background: var(--charcoal);
            color: white;
            border: none;
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background .18s;
            white-space: nowrap;
        }

        .btn-apply:hover {
            background: var(--rose);
        }

        .btn-place-order {
            width: 100%;
            padding: .9rem;
            background: var(--rose-pale);
            color: var(--rose);
            border: none;
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .22s;
            margin-bottom: .75rem;
        }

        .btn-place-order:hover {
            background: var(--rose);
            color: white;
        }

        .btn-place-order:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .order-legal {
            font-size: .7rem;
            color: var(--warm-gray);
            text-align: center;
            line-height: 1.6;
        }

        .order-legal a {
            color: var(--charcoal);
            text-decoration: underline;
        }

        /* Free shipping badge */
        .free-ship-badge {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .85rem 1.25rem;
            background: var(--soft-bg);
            border: 1px solid var(--border-light);
            border-radius: 5px;
            margin-top: 1rem;
        }

        .free-ship-badge svg {
            flex-shrink: 0;
            color: var(--rose);
        }

        .free-ship-badge .fs-txt {
            font-size: .75rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        .free-ship-badge .fs-sub {
            font-size: .68rem;
            color: var(--warm-gray);
        }

        .pay-icons-row {
            display: flex;
            gap: .4rem;
            margin-top: .75rem;
            justify-content: center;
        }

        .pay-icon-badge {
            padding: .25rem .55rem;
            border: 1px solid var(--border);
            border-radius: 3px;
            font-size: .62rem;
            font-weight: 700;
            color: var(--warm-gray);
            letter-spacing: .05em;
            background: white;
        }

        /* ── Empty state ── */
        .empty-bag {
            text-align: center;
            padding: 5rem 2rem;
        }

        .empty-bag .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: .4;
        }

        .empty-bag h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: .5rem;
        }

        .empty-bag p {
            color: var(--warm-gray);
            font-size: .85rem;
            margin-bottom: 1.75rem;
        }

        /* ── People also loved ── */
        .also-loved {
            max-width: 1320px;
            margin: 0 auto;
            padding: 4rem 3rem;
        }

        .also-loved h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--charcoal);
            text-align: center;
            margin-bottom: 2rem;
        }

        .also-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .also-card {
            cursor: pointer;
            transition: transform .22s;
        }

        .also-card:hover {
            transform: translateY(-4px);
        }

        .also-card-img {
            height: 240px;
            border-radius: 4px;
            overflow: hidden;
            background: var(--soft-bg);
            margin-bottom: .85rem;
        }

        .also-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s;
        }

        .also-card:hover .also-card-img img {
            transform: scale(1.05);
        }

        .also-brand {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .2rem;
        }

        .also-name {
            font-size: .88rem;
            color: var(--charcoal);
            margin-bottom: .4rem;
        }

        .also-add {
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--warm-gray);
            font-weight: 500;
        }

        /* skeleton */
        .skeleton {
            background: var(--border-light);
            border-radius: 4px;
            animation: skpulse 1.4s ease-in-out infinite;
        }

        @keyframes skpulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .4
            }
        }

        @media(max-width:1024px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }

            .also-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:640px) {
            .cart-page {
                padding: 1.5rem 1.25rem 4rem;
            }

            .cart-page-title {
                font-size: 1.8rem;
            }

            .pay-methods {
                flex-direction: column;
            }

            .form-row-2 {
                grid-template-columns: 1fr;
            }

            .also-loved {
                padding: 3rem 1.25rem;
            }
        }
    </style>
@endsection

@section('content')

    <div class="cart-page">
        <h1 class="cart-page-title">Your Shopping Bag</h1>

        {{-- Not logged in --}}
        <div id="not-logged" style="display:none;">
            <div class="empty-bag">
                <div class="empty-icon">🛍</div>
                <h2>Sign in to view your bag</h2>
                <p>Log in to see your saved items and continue shopping.</p>
                <a href="/login" class="btn btn-primary" style="padding:.75rem 2rem;">Sign In</a>
            </div>
        </div>

        {{-- Empty state --}}
        <div id="empty-state" style="display:none;">
            <div class="empty-bag">
                <div class="empty-icon">🛍</div>
                <h2>Your bag is empty</h2>
                <p>Looks like you haven't added anything yet.</p>
                <a href="/shop" class="btn btn-primary" style="padding:.75rem 2rem;">Start Shopping</a>
            </div>
        </div>

        {{-- Cart content --}}
        <div id="cart-main" style="display:none;">
            <div class="cart-layout">

                {{-- LEFT COLUMN --}}
                <div>

                    {{-- Step 1 — Review Items --}}
                    <div class="step-card">
                        <div class="step-head">
                            <div class="step-num">1</div>
                            <h2>Review Items</h2>
                        </div>
                        <div class="step-body" id="cart-items-list">
                            {{-- filled by JS --}}
                        </div>
                    </div>

                    {{-- Step 2 — Shipping --}}
                    <div class="step-card">
                        <div class="step-head">
                            <div class="step-num">2</div>
                            <h2>Shipping Information</h2>
                        </div>
                        <div class="step-body">
                            <div class="form-grid">
                                <div class="form-field">
                                    <label>Full Name</label>
                                    <input class="form-input" id="sh-name" type="text" placeholder="Sarah Jenkins">
                                </div>
                                <div class="form-field">
                                    <label>Address Line</label>
                                    <input class="form-input" id="sh-address" type="text" placeholder="123 Glow Avenue">
                                </div>
                                <div class="form-row-2">
                                    <div class="form-field">
                                        <label>City</label>
                                        <input class="form-input" id="sh-city" type="text" placeholder="Los Angeles">
                                    </div>
                                    <div class="form-field">
                                        <label>Zip Code</label>
                                        <input class="form-input" id="sh-zip" type="text" placeholder="90001">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3 — Payment --}}
                    <div class="step-card">
                        <div class="step-head">
                            <div class="step-num">3</div>
                            <h2>Payment Method</h2>
                        </div>
                        <div class="step-body">
                            <div class="pay-methods">
                                {{-- GANTI 3 button pay-method-btn --}}
                                <button class="pay-method-btn active" onclick="selectPay(this,'transfer')">
                                    <div class="check-dot">✓</div>
                                    <div class="pay-icon">🏦</div>
                                    <div class="pay-label">Bank Transfer</div>
                                </button>
                                <button class="pay-method-btn" onclick="selectPay(this,'ewallet')">
                                    <div class="check-dot">✓</div>
                                    <div class="pay-icon">📱</div>
                                    <div class="pay-label">E-Wallet</div>
                                </button>
                                <button class="pay-method-btn" onclick="selectPay(this,'cod')">
                                    <div class="check-dot">✓</div>
                                    <div class="pay-icon">💵</div>
                                    <div class="pay-label">COD</div>
                                </button>
                            </div>

                            <div class="card-fields" id="card-fields">
                                <div class="form-field">
                                    <label>Card Number</label>
                                    <div class="card-num-wrap">
                                        <input class="form-input" id="card-num" type="text"
                                            placeholder="•••• •••• •••• 1234" maxlength="19" oninput="formatCard(this)">
                                        <span class="card-chip-icon" id="card-brand-icon">VISA</span>
                                    </div>
                                </div>
                                <div class="form-row-2">
                                    <div class="form-field">
                                        <label>Expiry Date</label>
                                        <input class="form-input" id="card-exp" type="text" placeholder="MM / YY"
                                            maxlength="7" oninput="formatExp(this)">
                                    </div>
                                    <div class="form-field">
                                        <label>CVC</label>
                                        <input class="form-input" id="card-cvc" type="text" placeholder="•••" maxlength="4">
                                    </div>
                                </div>
                            </div>

                            <div id="paypal-fields"
                                style="display:none;padding:1.5rem;text-align:center;color:var(--warm-gray);font-size:.85rem;border:1px dashed var(--border);border-radius:4px;margin-top:.5rem;">
                                You will be redirected to PayPal to complete your payment.
                            </div>
                            <div id="apple-fields"
                                style="display:none;padding:1.5rem;text-align:center;color:var(--warm-gray);font-size:.85rem;border:1px dashed var(--border);border-radius:4px;margin-top:.5rem;">
                                Use Touch ID or Face ID to pay with Apple Pay.
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN — Order Summary --}}
                <div>
                    <div class="order-summary">
                        <h3>Order Summary</h3>

                        <div class="summary-row">
                            <span class="lbl">Subtotal</span>
                            <span id="sum-subtotal">—</span>
                        </div>
                        <div class="summary-row">
                            <span class="lbl">Shipping</span>
                            <span id="sum-shipping" style="color:#2E7D32;font-weight:500;">$0.00</span>
                        </div>
                        <div class="summary-row" id="promo-row" style="display:none;">
                            <span class="lbl">Promo Code <span class="promo-applied" id="promo-tag">ACTIVE</span></span>
                            <span class="promo-discount" id="sum-discount">—</span>
                        </div>

                        <hr class="summary-divider">

                        <div class="summary-total-row">
                            <span class="total-lbl">Total</span>
                            <span class="total-amt" id="sum-total">—</span>
                        </div>

                        <div class="promo-input-row">
                            <input class="promo-input" id="promo-input" type="text" placeholder="Promo Code">
                            <button class="btn-apply" onclick="applyPromo()">Apply</button>
                        </div>

                        <button class="btn-place-order" id="place-btn" onclick="placeOrder()">
                            Place Your Order
                        </button>
                        <p class="order-legal">
                            By placing your order, you agree to GlowMart's
                            <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>.
                        </p>

                        <div class="free-ship-badge">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <rect x="1" y="3" width="15" height="13" rx="1" />
                                <path d="M16 8h4l3 5v3h-7V8z" />
                                <circle cx="5.5" cy="18.5" r="2.5" />
                                <circle cx="18.5" cy="18.5" r="2.5" />
                            </svg>
                            <div>
                                <div class="fs-txt">Free Shipping</div>
                                <div class="fs-sub">On orders over $75</div>
                            </div>
                        </div>

                        <div class="pay-icons-row">
                            <span class="pay-icon-badge">VISA</span>
                            <span class="pay-icon-badge">MC</span>
                            <span class="pay-icon-badge">AMEX</span>
                            <span class="pay-icon-badge">GPay</span>
                            <span class="pay-icon-badge">OVO</span>
                        </div>
                    </div>
                </div>

            </div>{{-- .cart-layout --}}
        </div>{{-- #cart-main --}}
    </div>

    {{-- People also loved --}}
    <div class="also-loved">
        <h2>People also loved</h2>
        <div class="also-grid" id="also-grid">
            <div class="skeleton" style="height:300px;"></div>
            <div class="skeleton" style="height:300px;"></div>
            <div class="skeleton" style="height:300px;"></div>
            <div class="skeleton" style="height:300px;"></div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let cartItems = [];
        let cartTotal = 0;
        let promoDiscount = 0;
        let selectedPayMethod = 'transfer';

        /* ══ Load cart ══ */
        async function loadCart() {
            const user = getUser();
            if (!user) {
                document.getElementById('not-logged').style.display = 'block';
                loadAlsoLoved();
                return;
            }
            try {
                const r = await axios.get(API + '/cart');
                cartItems = r.data.data.items || [];
                cartTotal = r.data.data.total || 0;

                if (!cartItems.length) {
                    document.getElementById('empty-state').style.display = 'block';
                    loadAlsoLoved();
                    return;
                }

                document.getElementById('cart-main').style.display = 'block';
                renderItems();
                renderSummary();
                loadAlsoLoved();
            } catch {
                document.getElementById('cart-main').style.display = 'block';
                document.getElementById('cart-items-list').innerHTML =
                    '<p style="color:var(--warm-gray)">Gagal memuat keranjang.</p>';
            }
        }

        /* ══ Render items ══ */
        function renderItems() {
            const list = document.getElementById('cart-items-list');
            list.innerHTML = cartItems.map(item => {
                const p = item.product || {};
                const img = p.image || 'https://via.placeholder.com/80x80?text=Beauty';
                const name = p.name || 'Product';
                const brand = (p.brand || p.category?.name || '').toUpperCase();
                const variant = brand ? `${item.variant || '30ML'} • ${brand}` : (item.variant || '');
                const price = p.price * item.quantity;

                return `
          <div class="cart-item" id="ci-${item.id}">
            <div class="cart-item-img">
              <img src="${img}" alt="${name}" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
            </div>
            <div class="cart-item-info">
              <div class="cart-item-name">${name}</div>
              ${variant ? `<div class="cart-item-variant">${variant}</div>` : ''}
              <div class="cart-qty-row">
                <div class="qty-ctrl-sm">
                  <button class="qty-btn-sm" onclick="updateQty(${item.id},${item.quantity - 1})">−</button>
                  <span class="qty-val-sm">${item.quantity}</span>
                  <button class="qty-btn-sm" onclick="updateQty(${item.id},${item.quantity + 1})">+</button>
                </div>
                <button class="remove-link" onclick="removeItem(${item.id})">Remove</button>
              </div>
            </div>
            <div class="cart-item-price">${formatRp(p.price)}</div>
          </div>`;
            }).join('');
        }

        /* ══ Render summary ══ */
        function renderSummary() {
            const net = cartTotal - promoDiscount;
            document.getElementById('sum-subtotal').textContent = formatRp(cartTotal);
            document.getElementById('sum-total').textContent = formatRp(Math.max(0, net));
            document.getElementById('cart-count').textContent = cartItems.length;
        }

        /* ══ Qty & remove ══ */
        async function updateQty(id, qty) {
            if (qty < 1) { removeItem(id); return; }
            try {
                await axios.put(API + '/cart/' + id, { quantity: qty });
                loadCart();
            } catch (e) { toast(e.response?.data?.message || 'Gagal', 'error'); }
        }
        async function removeItem(id) {
            try {
                await axios.delete(API + '/cart/' + id);
                toast('Item removed', 'success');
                loadCart();
            } catch { toast('Gagal menghapus', 'error'); }
        }

        /* ══ Promo ══ */
        async function applyPromo() {
            const code = document.getElementById('promo-input').value.trim().toUpperCase();
            if (!code) return;
            /* Demo: hardcode discount for any code */
            try {
                promoDiscount = Math.round(cartTotal * 0.15); /* 15% off demo */
                document.getElementById('promo-row').style.display = 'flex';
                document.getElementById('promo-tag').textContent = code;
                document.getElementById('sum-discount').textContent = '−' + formatRp(promoDiscount);
                renderSummary();
                toast('Promo code applied ✓', 'success');
            } catch { toast('Invalid promo code', 'error'); }
        }

        /* ══ Payment method toggle ══ */
        function selectPay(btn, method) {
            selectedPayMethod = method;
            document.querySelectorAll('.pay-method-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('card-fields').style.display = method === 'transfer' ? 'grid' : 'none';
            document.getElementById('paypal-fields').style.display = method === 'ewallet' ? 'block' : 'none';
            document.getElementById('apple-fields').style.display = method === 'cod' ? 'block' : 'none';
        }

        /* ══ Card formatting ══ */
        function formatCard(el) {
            let v = el.value.replace(/\D/g, '').slice(0, 16);
            el.value = v.replace(/(.{4})/g, '$1 ').trim();
            /* brand detection */
            const brand = v.startsWith('4') ? 'VISA'
                : /^5[1-5]/.test(v) ? 'MC'
                    : /^3[47]/.test(v) ? 'AMEX'
                        : 'CARD';
            document.getElementById('card-brand-icon').textContent = brand;
        }
        function formatExp(el) {
            let v = el.value.replace(/\D/g, '');
            if (v.length >= 2) v = v.slice(0, 2) + ' / ' + v.slice(2, 4);
            el.value = v;
        }

        /* ══ Place order ══ */
        async function placeOrder() {
            const user = getUser();
            if (!user) { window.location.href = '/login'; return; }

            const name = document.getElementById('sh-name').value.trim();
            const address = document.getElementById('sh-address').value.trim();
            const city = document.getElementById('sh-city').value.trim();

            if (!name) { toast('Masukkan nama lengkap', 'error'); return; }
            if (!address) { toast('Masukkan alamat pengiriman', 'error'); return; }
            if (!city) { toast('Masukkan kota tujuan', 'error'); return; }

            const btn = document.getElementById('place-btn');
            btn.disabled = true;
            btn.textContent = 'Processing...';
            loading(true);

            try {
                await axios.post(API + '/orders', {
                    shipping_address: address,
                    shipping_city: city,        // ← wajib ada
                    payment_method: selectedPayMethod,  // transfer / ewallet / cod
                    shipping_cost: 0,
                    notes: '',
                });
                toast('Order placed! Thank you ✓', 'success');
                setTimeout(() => window.location.href = '/orders', 1200);
            } catch (e) {
                console.log('Error:', e.response?.data);
                toast(e.response?.data?.message || 'Gagal checkout', 'error');
                btn.disabled = false;
                btn.textContent = 'Place Your Order';
            } finally { loading(false); }
        }

        /* ══ People also loved ══ */
        async function loadAlsoLoved() {
            try {
                const r = await axios.get(GW + '/products?per_page=4&sort=created_at');
                const products = r.data.data.data || [];
                const grid = document.getElementById('also-grid');
                if (!products.length) { grid.innerHTML = ''; return; }
                grid.innerHTML = products.map(p => `
          <div class="also-card" onclick="window.location='/product/${p.id}'">
            <div class="also-card-img">
              <img src="${p.image || 'https://via.placeholder.com/300x240?text=Beauty'}" alt="${p.name}"
                   onerror="this.onerror=null;this.src='/img/placeholder.svg'" loading="lazy">
            </div>
            <div class="also-brand">${p.brand || p.category?.name || ''}</div>
            <div class="also-name">${p.name}</div>
            <div class="also-add">Add — ${formatRp(p.price)}</div>
          </div>`).join('');
            } catch {
                document.getElementById('also-grid').innerHTML = '';
            }
        }

        /* ══ Init ══ */
        loadCart();
    </script>
@endsection
