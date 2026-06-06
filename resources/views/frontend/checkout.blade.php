@extends('frontend.layout')
@section('title', 'Checkout - GlowMart')
@section('head')
    <style>
        /* ── Page ── */
        .checkout-page {
            max-width: 1320px;
            margin: 0 auto;
            padding: 2.5rem 3rem 5rem;
        }

        .checkout-page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.6rem;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 2rem;
        }

        /* Two-column */
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
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
            padding: 1.25rem 1.75rem;
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
            padding: 1.75rem;
        }

        /* ── Order items ── */
        .checkout-item {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: .85rem 0;
            border-bottom: 1px solid var(--border-light);
        }

        .checkout-item:last-child {
            border-bottom: none;
        }

        .checkout-item-img {
            width: 64px;
            height: 64px;
            border-radius: 4px;
            overflow: hidden;
            background: var(--soft-bg);
            flex-shrink: 0;
        }

        .checkout-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .checkout-item-name {
            font-size: .88rem;
            font-weight: 500;
            color: var(--charcoal);
        }

        .checkout-item-meta {
            font-size: .72rem;
            color: var(--warm-gray);
            margin-top: .15rem;
        }

        .checkout-item-price {
            margin-left: auto;
            font-size: .88rem;
            font-weight: 600;
            color: var(--charcoal);
            white-space: nowrap;
        }

        /* ── Form fields ── */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.1rem;
        }

        .form-field {
            margin-bottom: 0;
        }

        .form-field.full {
            grid-column: 1 / -1;
        }

        .form-field label {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--charcoal);
            margin-bottom: .42rem;
        }

        .form-input {
            width: 100%;
            padding: .7rem 1rem;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-family: 'Jost', sans-serif;
            font-size: .86rem;
            color: var(--charcoal);
            background: white;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .form-input:focus {
            border-color: var(--charcoal);
            box-shadow: 0 0 0 3px rgba(26, 26, 26, .05);
        }

        .form-input::placeholder {
            color: #CFC6CA;
        }

        .form-textarea {
            width: 100%;
            padding: .7rem 1rem;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-family: 'Jost', sans-serif;
            font-size: .86rem;
            color: var(--charcoal);
            outline: none;
            resize: none;
            transition: border-color .18s;
        }

        .form-textarea:focus {
            border-color: var(--charcoal);
        }

        .form-textarea::placeholder {
            color: #CFC6CA;
        }

        /* ── Courier / Shipping options ── */
        .courier-options {
            display: flex;
            gap: .65rem;
            margin-bottom: 1.25rem;
        }

        .courier-btn {
            flex: 1;
            padding: .65rem .75rem;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            background: white;
            font-family: 'Jost', sans-serif;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--charcoal-mid);
            cursor: pointer;
            transition: all .18s;
            text-align: center;
        }

        .courier-btn:hover {
            border-color: var(--charcoal);
            color: var(--charcoal);
        }

        .courier-btn.active {
            border-color: var(--charcoal);
            background: var(--charcoal);
            color: white;
        }

        .shipping-options {
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .shipping-opt {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .85rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
            transition: all .18s;
            gap: .75rem;
        }

        .shipping-opt:hover {
            border-color: var(--charcoal-mid);
        }

        .shipping-opt.selected {
            border-color: var(--charcoal);
            background: var(--cream);
        }

        .shipping-opt-radio {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }

        .shipping-opt.selected .shipping-opt-radio {
            border-color: var(--charcoal);
            background: var(--charcoal);
        }

        .shipping-opt.selected .shipping-opt-radio::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: white;
            display: block;
        }

        .shipping-opt-info {
            flex: 1;
        }

        .shipping-opt-name {
            font-size: .82rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        .shipping-opt-etd {
            font-size: .72rem;
            color: var(--warm-gray);
            margin-top: .1rem;
        }

        .shipping-opt-cost {
            font-size: .85rem;
            font-weight: 600;
            color: var(--charcoal);
            white-space: nowrap;
        }

        /* Calculating state */
        .shipping-loading {
            font-size: .8rem;
            color: var(--warm-gray);
            padding: 1rem 0;
            text-align: center;
        }

        /* ── Payment methods ── */
        .pay-methods {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .pay-method-btn {
            flex: 1;
            padding: .85rem .75rem;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            background: white;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .35rem;
            transition: all .18s;
            position: relative;
        }

        .pay-method-btn.active {
            border-color: var(--charcoal);
            background: var(--cream);
        }

        .pay-method-btn .pm-check {
            position: absolute;
            top: .4rem;
            right: .4rem;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: var(--charcoal);
            color: white;
            font-size: .5rem;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .pay-method-btn.active .pm-check {
            display: flex;
        }

        .pm-icon {
            font-size: 1.2rem;
        }

        .pm-label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--charcoal);
        }

        /* ── Order Summary (right) ── */
        .order-summary {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            overflow: hidden;
            position: sticky;
            top: 80px;
        }

        .order-summary-head {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-light);
        }

        .order-summary-head h3 {
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--charcoal);
        }

        .order-summary-body {
            padding: 1.25rem 1.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: .75rem;
            font-size: .82rem;
        }

        .summary-item .lbl {
            color: var(--warm-gray);
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .summary-item .val {
            font-weight: 500;
            color: var(--charcoal);
        }

        .summary-item .val.free {
            color: #2E7D32;
        }

        .summary-item .val.discount {
            color: var(--rose);
        }

        .summary-divider {
            border: none;
            border-top: 1px solid var(--border-light);
            margin: 1rem 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 1.25rem;
        }

        .summary-total .total-lbl {
            font-size: .85rem;
            font-weight: 700;
            color: var(--charcoal);
        }

        .summary-total .total-val {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--charcoal);
        }

        .btn-place {
            width: 100%;
            padding: .85rem;
            background: var(--rose-pale);
            color: var(--rose);
            border: none;
            border-radius: 4px;
            font-family: 'Jost', sans-serif;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .22s;
            margin-bottom: .75rem;
        }

        .btn-place:hover {
            background: var(--rose);
            color: white;
        }

        .btn-place:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .order-legal {
            font-size: .68rem;
            color: var(--warm-gray);
            text-align: center;
            line-height: 1.6;
        }

        .order-legal a {
            color: var(--charcoal);
            text-decoration: underline;
        }

        .trust-row {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 1rem 1.5rem;
            background: var(--soft-bg);
            border-top: 1px solid var(--border-light);
        }

        .trust-row svg {
            color: var(--rose);
            flex-shrink: 0;
        }

        .trust-txt {
            font-size: .72rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        .trust-sub {
            font-size: .65rem;
            color: var(--warm-gray);
        }

        .pay-badges {
            display: flex;
            gap: .35rem;
            padding: .75rem 1.5rem 1rem;
            justify-content: center;
            border-top: 1px solid var(--border-light);
        }

        .pay-badge {
            padding: .25rem .5rem;
            border: 1px solid var(--border);
            border-radius: 3px;
            font-size: .6rem;
            font-weight: 700;
            color: var(--warm-gray);
            letter-spacing: .04em;
            background: white;
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

        @media (max-width: 1024px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }
        }

        @media (max-width: 640px) {
            .checkout-page {
                padding: 1.5rem 1.25rem 4rem;
            }

            .checkout-page-title {
                font-size: 1.8rem;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
            }

            .pay-methods {
                flex-direction: column;
            }

            .courier-options {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
    <div class="checkout-page">
        <h1 class="checkout-page-title">Checkout</h1>

        <div class="checkout-layout">

            {{-- ══ LEFT ══ --}}
            <div>

                {{-- Step 1: Order Review --}}
                <div class="step-card">
                    <div class="step-head">
                        <div class="step-num">1</div>
                        <h2>Review Your Order</h2>
                    </div>
                    <div class="step-body" id="checkout-items">
                        <div class="skeleton" style="height:80px;margin-bottom:.75rem;"></div>
                        <div class="skeleton" style="height:80px;"></div>
                    </div>
                </div>

                {{-- Step 2: Shipping Address --}}
                <div class="step-card">
                    <div class="step-head">
                        <div class="step-num">2</div>
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="step-body">
                        <div class="form-grid-2">
                            <div class="form-field">
                                <label>Full Name</label>
                                <input class="form-input" id="sh-name" type="text" placeholder="Sarah Jenkins">
                            </div>
                            <div class="form-field">
                                <label>Phone</label>
                                <input class="form-input" id="sh-phone" type="tel" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="form-field full">
                                <label>Street Address</label>
                                <input class="form-input" id="sh-address" type="text"
                                    placeholder="Jl. Contoh No. 123, RT/RW 01/02" oninput="debouncedShipping()">
                            </div>
                            <div class="form-field">
                                <label>City</label>
                                <input class="form-input" id="sh-city" type="text" placeholder="Malang"
                                    oninput="debouncedShipping()">
                            </div>
                            <div class="form-field">
                                <label>Zip Code</label>
                                <input class="form-input" id="sh-zip" type="text" placeholder="65141">
                            </div>
                            <div class="form-field full">
                                <label>Order Notes (optional)</label>
                                <textarea class="form-textarea" id="sh-notes" rows="2"
                                    placeholder="Special instructions for the courier..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 3: Shipping Method --}}
                <div class="step-card">
                    <div class="step-head">
                        <div class="step-num">3</div>
                        <h2>Shipping Method</h2>
                    </div>
                    <div class="step-body">
                        <div style="margin-bottom:1rem;">
                            <div
                                style="font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--warm-gray);margin-bottom:.6rem;">
                                Choose Courier</div>
                            <div class="courier-options">
                                <button class="courier-btn active" onclick="selectCourier(this,'jne')">JNE</button>
                                <button class="courier-btn" onclick="selectCourier(this,'tiki')">TIKI</button>
                                <button class="courier-btn" onclick="selectCourier(this,'pos')">POS Indonesia</button>
                            </div>
                        </div>
                        <div id="shipping-options">
                            <p class="shipping-loading">Enter your city to see shipping options.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 4: Payment --}}
                <div class="step-card">
                    <div class="step-head">
                        <div class="step-num">4</div>
                        <h2>Payment Method</h2>
                    </div>
                    <div class="step-body">
                        <div class="pay-methods">
                            <button class="pay-method-btn active" onclick="selectPay(this,'transfer')">
                                <div class="pm-check">✓</div>
                                <div class="pm-icon">🏦</div>
                                <div class="pm-label">Bank Transfer</div>
                            </button>
                            <button class="pay-method-btn" onclick="selectPay(this,'ewallet')">
                                <div class="pm-check">✓</div>
                                <div class="pm-icon">📱</div>
                                <div class="pm-label">E-Wallet</div>
                            </button>
                            <button class="pay-method-btn" onclick="selectPay(this,'cod')">
                                <div class="pm-check">✓</div>
                                <div class="pm-icon">💵</div>
                                <div class="pm-label">COD</div>
                            </button>
                        </div>
                        {{-- Bank transfer details --}}
                        <div id="pay-transfer-detail"
                            style="background:var(--soft-bg);border:1px solid var(--border-light);border-radius:4px;padding:1rem;">
                            <div
                                style="font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--warm-gray);margin-bottom:.6rem;">
                                Bank Account Details</div>
                            <div style="font-size:.85rem;color:var(--charcoal-mid);line-height:1.9;">
                                Bank BCA &nbsp;·&nbsp; <strong>1234 5678 90</strong><br>
                                Bank Mandiri &nbsp;·&nbsp; <strong>0987 6543 21</strong><br>
                                <span style="font-size:.75rem;color:var(--warm-gray);">a/n PT GlowMart Beauty
                                    Indonesia</span>
                            </div>
                        </div>
                        <div id="pay-ewallet-detail"
                            style="display:none;background:var(--soft-bg);border:1px solid var(--border-light);border-radius:4px;padding:1rem;">
                            <div style="font-size:.82rem;color:var(--charcoal-mid);">GoPay / OVO / DANA will be billed to
                                your registered number upon order confirmation.</div>
                        </div>
                        <div id="pay-cod-detail"
                            style="display:none;background:var(--soft-bg);border:1px solid var(--border-light);border-radius:4px;padding:1rem;">
                            <div style="font-size:.82rem;color:var(--charcoal-mid);">Pay in cash when your order arrives.
                                COD available for selected areas only.</div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══ RIGHT: Order Summary ══ --}}
            <div>
                <div class="order-summary">
                    <div class="order-summary-head">
                        <h3>Order Summary</h3>
                    </div>
                    <div class="order-summary-body">
                        <div class="summary-item">
                            <span class="lbl">Subtotal</span>
                            <span class="val" id="sum-subtotal">—</span>
                        </div>
                        <div class="summary-item">
                            <span class="lbl">Shipping</span>
                            <span class="val" id="sum-shipping" style="color:var(--warm-gray);">Select method</span>
                        </div>
                        <hr class="summary-divider">
                        <div class="summary-total">
                            <span class="total-lbl">Total</span>
                            <span class="total-val" id="sum-total">—</span>
                        </div>
                        <button class="btn-place" id="place-btn" onclick="placeOrder()">
                            Place Order
                        </button>
                        <p class="order-legal">
                            By placing your order, you agree to GlowMart's
                            <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>.
                        </p>
                    </div>
                    <div class="trust-row">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <rect x="1" y="3" width="15" height="13" rx="1" />
                            <path d="M16 8h4l3 5v3h-7V8z" />
                            <circle cx="5.5" cy="18.5" r="2.5" />
                            <circle cx="18.5" cy="18.5" r="2.5" />
                        </svg>
                        <div>
                            <div class="trust-txt">Free Shipping</div>
                            <div class="trust-sub">On orders over Rp 250.000</div>
                        </div>
                    </div>
                    <div class="pay-badges">
                        <span class="pay-badge">VISA</span>
                        <span class="pay-badge">MC</span>
                        <span class="pay-badge">BCA</span>
                        <span class="pay-badge">GoPay</span>
                        <span class="pay-badge">OVO</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let cartData = null;
        let selectedShip = 0;
        let selectedShipName = '';
        let selectedCourier = 'jne';
        let selectedPayment = 'transfer';
        let _shipTimer;

        function formatRp(n) { return fmtRp(n); }

        /* ── Load checkout ── */
        async function loadCheckout() {
            const user = getUser();
            if (!user) { window.location.href = '/login'; return; }
            try {
                const r = await axios.get(API + '/cart');
                cartData = r.data.data;
                if (!cartData.items.length) { window.location.href = '/cart'; return; }

                /* pre-fill name/phone from user */
                const u = getUser();
                if (u) {
                    document.getElementById('sh-name').value = u.name || '';
                    document.getElementById('sh-phone').value = u.phone || '';
                }

                /* items list */
                document.getElementById('checkout-items').innerHTML =
                    cartData.items.map(item => {
                        const p = item.product || {};
                        const img = p.image || '/img/placeholder.svg';
                        return `
          <div class="checkout-item">
            <div class="checkout-item-img">
              <img src="${img}" alt="${p.name}" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                    </div>
                    <div>
                      <div class="checkout-item-name">${p.name || '—'}</div>
                      <div class="checkout-item-meta">Qty ${item.quantity} · ${p.brand || ''}</div>
                    </div>
                    <div class="checkout-item-price">${formatRp(p.price * item.quantity)}</div>
                  </div>`;
                    }).join('');

                document.getElementById('sum-subtotal').textContent = formatRp(cartData.total);
                document.getElementById('sum-total').textContent = formatRp(cartData.total);
            } catch (e) {
                if (e.response?.status === 401) window.location.href = '/login';
            }
        }

        /* ── Courier select ── */
        function selectCourier(btn, courier) {
            document.querySelectorAll('.courier-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedCourier = courier;
            calculateShipping();
        }

        /* ── Debounced shipping calc ── */
        function debouncedShipping() {
            clearTimeout(_shipTimer);
            _shipTimer = setTimeout(calculateShipping, 800);
        }

        /* ── Calculate shipping ── */
        async function calculateShipping() {
            const city = document.getElementById('sh-city').value.trim();
            if (!city) {
                document.getElementById('shipping-options').innerHTML =
                    '<p class="shipping-loading">Enter your city to see shipping options.</p>';
                return;
            }

            document.getElementById('shipping-options').innerHTML =
                '<p class="shipping-loading">Calculating shipping rates...</p>';

            try {
                const r = await axios.post(API + '/shipping/calculate', {
                    origin: '455',
                    destination: '455',
                    weight: 500,
                    courier: selectedCourier,
                });
                const services = r.data.data || [];
                if (!services.length) {
                    document.getElementById('shipping-options').innerHTML =
                        '<p class="shipping-loading" style="color:var(--warm-gray)">No shipping options available.</p>';
                    return;
                }

                document.getElementById('shipping-options').innerHTML =
                    `<div class="shipping-options">` +
                    services.map((s, i) => `
                <div class="shipping-opt ${i === 0 ? 'selected' : ''}"
                     onclick="selectShipping(this,${s.cost},'${s.service}')">
                  <div class="shipping-opt-radio"></div>
                  <div class="shipping-opt-info">
                    <div class="shipping-opt-name">${selectedCourier.toUpperCase()} ${s.service}</div>
                    <div class="shipping-opt-etd">Estimasi ${s.etd}</div>
                  </div>
                  <div class="shipping-opt-cost">${formatRp(s.cost)}</div>
                </div>`).join('') +
                    `</div>`;

                if (services[0]) selectShipping(null, services[0].cost, services[0].service, true);
            } catch {
                document.getElementById('shipping-options').innerHTML =
                    '<p class="shipping-loading" style="color:#C62828;">Failed to calculate shipping. Try again.</p>';
            }
        }

        function selectShipping(el, cost, name, silent = false) {
            if (!silent && el) {
                document.querySelectorAll('.shipping-opt').forEach(o => o.classList.remove('selected'));
                el.classList.add('selected');
            }
            selectedShip = cost;
            selectedShipName = name;

            const sub = cartData?.total || 0;
            const total = sub + cost;

            const shipEl = document.getElementById('sum-shipping');
            shipEl.textContent = cost === 0 ? 'Free' : formatRp(cost);
            shipEl.style.color = cost === 0 ? '#2E7D32' : 'var(--charcoal)';
            shipEl.style.fontWeight = '500';

            document.getElementById('sum-total').textContent = formatRp(total);
        }

        /* ── Payment method ── */
        function selectPay(btn, method) {
            document.querySelectorAll('.pay-method-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedPayment = method;
            ['transfer', 'ewallet', 'cod'].forEach(m => {
                document.getElementById('pay-' + m + '-detail').style.display = m === method ? 'block' : 'none';
            });
        }

        /* ── Place order ── */
        /* ── Place order ── */
        async function placeOrder() {
            const addr = document.getElementById('sh-address')?.value?.trim() || '';
            const city = document.getElementById('sh-city')?.value?.trim() || '';
            const name = document.getElementById('sh-name')?.value?.trim() || '';

            if (!name) { toast('Enter your full name', 'error'); return; }
            if (!addr) { toast('Enter your street address', 'error'); return; }
            if (!city) { toast('Enter your city', 'error'); return; }

            const btn = document.getElementById('place-btn'); // ← ID yang benar
            if (btn) { btn.disabled = true; btn.textContent = 'Processing...'; }
            loading(true);

            try {
                await axios.post(API + '/orders', {
                    shipping_address: addr,
                    shipping_city: city,
                    payment_method: selectedPayment || 'transfer',
                    shipping_cost: selectedShip || 0,  // ← pakai selectedShip
                    notes: document.getElementById('sh-notes')?.value || '',
                });
                toast('Order placed successfully! ✓', 'success');
                setTimeout(() => window.location.href = '/orders', 1000);
            } catch (e) {
                console.log('Order error:', e.response?.data);
                toast(e.response?.data?.message || 'Failed to place order', 'error');
                if (btn) { btn.disabled = false; btn.textContent = 'Place Order'; }
            } finally {
                loading(false);
            }
        }

        /* ── Init ── */
        loadCheckout();
    </script>
@endsection
