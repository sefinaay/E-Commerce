@extends('frontend.layout')
@section('title', 'Detail Produk - GlowMart')
@section('head')
    <style>
        /* ── Breadcrumb ── */
        .breadcrumb {
            max-width: 1320px;
            margin: 0 auto;
            padding: 1rem 3rem .25rem;
            display: flex;
            align-items: center;
            gap: .4rem;
            font-size: .72rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--warm-gray);
        }

        .breadcrumb a {
            color: var(--warm-gray);
            text-decoration: none;
            transition: color .15s;
        }

        .breadcrumb a:hover {
            color: var(--charcoal);
        }

        .breadcrumb span {
            color: var(--charcoal);
            font-weight: 500;
        }

        .breadcrumb-sep {
            color: var(--border);
        }

        /* ── Product Detail Layout ── */
        .product-section {
            max-width: 1320px;
            margin: 0 auto;
            padding: 1.5rem 3rem 4rem;
            display: grid;
            grid-template-columns: 88px 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        /* Thumbnail strip */
        .thumb-strip {
            display: flex;
            flex-direction: column;
            gap: .65rem;
            position: sticky;
            top: 88px;
        }

        .thumb {
            width: 76px;
            height: 76px;
            border-radius: 6px;
            overflow: hidden;
            border: 1.5px solid var(--border-light);
            cursor: pointer;
            transition: border-color .18s;
            flex-shrink: 0;
        }

        .thumb.active {
            border-color: var(--charcoal);
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .25s;
        }

        .thumb:hover img {
            transform: scale(1.06);
        }

        /* Main image */
        .main-image-wrap {
            position: sticky;
            top: 80px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--soft-bg);
            aspect-ratio: 4/5;
        }

        .main-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity .25s;
        }

        /* Product info panel */
        .product-info-panel {
            padding-left: 1rem;
        }

        .product-badge-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .9rem;
        }

        .badge-bestseller {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--rose);
            background: var(--rose-pale);
            padding: .25rem .7rem;
            border-radius: 2px;
        }

        .inline-stars {
            color: #E8A800;
            font-size: .82rem;
            letter-spacing: 1px;
        }

        .inline-rating {
            font-size: .78rem;
            color: var(--charcoal-mid);
            font-weight: 500;
        }

        .inline-reviews {
            font-size: .75rem;
            color: var(--warm-gray);
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--charcoal);
            line-height: 1.1;
            margin-bottom: .35rem;
        }

        .product-subtitle {
            font-size: .72rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--warm-gray);
            margin-bottom: 1.25rem;
        }

        .price-row {
            display: flex;
            align-items: baseline;
            gap: .75rem;
            margin-bottom: 1.1rem;
        }

        .price-main {
            font-size: 1.85rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        .price-original {
            font-size: 1rem;
            color: var(--warm-gray);
            text-decoration: line-through;
        }

        .product-desc {
            font-size: .85rem;
            color: var(--charcoal-mid);
            line-height: 1.8;
            margin-bottom: 1.5rem;
            max-width: 420px;
        }

        /* Size selector */
        .size-label {
            font-size: .7rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--charcoal);
            margin-bottom: .65rem;
        }

        .size-options {
            display: flex;
            gap: .6rem;
            margin-bottom: 1.5rem;
        }

        .size-btn {
            padding: .45rem 1.1rem;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            background: white;
            font-family: 'Jost', sans-serif;
            font-size: .8rem;
            color: var(--charcoal-mid);
            cursor: pointer;
            transition: all .18s;
        }

        .size-btn:hover {
            border-color: var(--charcoal);
            color: var(--charcoal);
        }

        .size-btn.active {
            background: var(--charcoal);
            color: white;
            border-color: var(--charcoal);
        }

        /* Qty + CTA */
        .qty-cta-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.5rem;
        }

        .qty-ctrl {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--border);
            border-radius: 2px;
            overflow: hidden;
        }

        .qty-btn {
            width: 36px;
            height: 44px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: var(--charcoal);
            transition: background .15s;
            font-family: 'Jost', sans-serif;
        }

        .qty-btn:hover {
            background: var(--soft-bg);
        }

        .qty-val {
            width: 44px;
            text-align: center;
            font-size: .9rem;
            font-family: 'Jost', sans-serif;
            font-weight: 500;
            border: none;
            outline: none;
            color: var(--charcoal);
        }

        .btn-add-cart {
            flex: 1;
            padding: .8rem 1.5rem;
            background: var(--rose-pale);
            color: var(--rose);
            border: none;
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .22s;
        }

        .btn-add-cart:hover {
            background: var(--rose);
            color: white;
        }

        .btn-add-cart:disabled {
            opacity: .45;
            cursor: not-allowed;
        }

        .btn-wishlist-round {
            width: 44px;
            height: 44px;
            border: 1.5px solid var(--border);
            border-radius: 2px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .18s;
            flex-shrink: 0;
        }

        .btn-wishlist-round:hover {
            border-color: var(--rose);
        }

        .btn-wishlist-round:hover svg {
            stroke: var(--rose);
        }

        /* Accordion */
        .accordion {
            border-top: 1px solid var(--border-light);
            margin-top: .5rem;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border-light);
        }

        .accordion-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            cursor: pointer;
            user-select: none;
        }

        .accordion-head h4 {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--charcoal);
        }

        .accordion-icon {
            font-size: .9rem;
            color: var(--warm-gray);
            transition: transform .2s;
            line-height: 1;
        }

        .accordion-icon.open {
            transform: rotate(180deg);
        }

        .accordion-body {
            font-size: .83rem;
            color: var(--charcoal-mid);
            line-height: 1.75;
            padding-bottom: 1.1rem;
            display: none;
        }

        .accordion-body.open {
            display: block;
        }

        /* ═══════════════════════════
       GLOW TALK (Reviews)
    ═══════════════════════════ */
        .reviews-section {
            background: var(--white);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
            padding: 4rem 3rem;
        }

        .reviews-inner {
            max-width: 1320px;
            margin: 0 auto;
        }

        .reviews-section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 400;
            text-align: center;
            color: var(--charcoal);
            margin-bottom: 2.5rem;
        }

        .rating-summary {
            display: flex;
            align-items: center;
            gap: 3rem;
            margin-bottom: 2.5rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-light);
        }

        .rating-big {
            text-align: center;
            flex-shrink: 0;
        }

        .rating-num {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 400;
            color: var(--charcoal);
            line-height: 1;
        }

        .rating-stars-big {
            color: #E8A800;
            font-size: 1rem;
            letter-spacing: 2px;
            margin: .35rem 0 .2rem;
        }

        .rating-label {
            font-size: .65rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--warm-gray);
        }

        .rating-bars {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: .4rem;
        }

        .bar-row {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .bar-lbl {
            font-size: .72rem;
            color: var(--warm-gray);
            width: 48px;
            white-space: nowrap;
        }

        .bar-track {
            flex: 1;
            height: 5px;
            background: var(--border-light);
            border-radius: 3px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            background: var(--rose-light);
            border-radius: 3px;
            transition: width .6s;
        }

        .bar-pct {
            font-size: .72rem;
            color: var(--warm-gray);
            width: 30px;
            text-align: right;
        }

        /* Review cards */
        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .review-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 4px;
            padding: 1.5rem;
        }

        .review-author-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .75rem;
        }

        .review-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--rose-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            font-weight: 700;
            color: var(--rose);
            flex-shrink: 0;
        }

        .review-author-name {
            font-size: .85rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        .review-author-date {
            font-size: .72rem;
            color: var(--warm-gray);
        }

        .review-stars-row {
            color: #E8A800;
            font-size: .82rem;
            margin-bottom: .6rem;
        }

        .review-text {
            font-size: .82rem;
            color: var(--charcoal-mid);
            line-height: 1.7;
            font-style: italic;
        }

        .review-text::before {
            content: '"';
        }

        .review-text::after {
            content: '"';
        }

        .write-review-wrap {
            text-align: center;
            padding-top: 1rem;
        }

        /* Review form modal-ish */
        .review-form-section {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 3rem;
            display: none;
        }

        .review-form-section.open {
            display: block;
        }

        .review-form-inner {
            background: var(--soft-bg);
            border: 1px solid var(--border-light);
            border-radius: 4px;
            padding: 2rem;
            max-width: 600px;
            margin: 1.5rem auto 3rem;
        }

        .review-form-inner h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 400;
            margin-bottom: 1.25rem;
            color: var(--charcoal);
        }

        .form-field {
            margin-bottom: 1rem;
        }

        .form-field label {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--warm-gray);
            margin-bottom: .4rem;
        }

        .star-picker {
            display: flex;
            gap: .35rem;
        }

        .star-pick {
            font-size: 1.5rem;
            color: var(--border);
            cursor: pointer;
            transition: color .15s;
            line-height: 1;
        }

        .star-pick.lit {
            color: #E8A800;
        }

        .form-textarea {
            width: 100%;
            padding: .75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 2px;
            font-family: 'Jost', sans-serif;
            font-size: .85rem;
            resize: none;
            outline: none;
            transition: border-color .18s;
            color: var(--charcoal);
        }

        .form-textarea:focus {
            border-color: var(--charcoal);
        }

        .form-actions {
            display: flex;
            gap: .75rem;
            margin-top: .25rem;
        }

        /* ═══════════════════════════
       RELATED PRODUCTS
    ═══════════════════════════ */
        .related-section {
            max-width: 1320px;
            margin: 0 auto;
            padding: 4rem 3rem;
        }

        .related-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .related-eyebrow {
            font-size: .68rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--warm-gray);
            margin-bottom: .35rem;
        }

        .related-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--charcoal);
        }

        .related-nav {
            display: flex;
            gap: .5rem;
        }

        .related-nav-btn {
            width: 34px;
            height: 34px;
            border: 1px solid var(--border);
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .18s;
            font-size: .9rem;
            color: var(--charcoal);
        }

        .related-nav-btn:hover {
            background: var(--charcoal);
            color: white;
            border-color: var(--charcoal);
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        .related-card {
            cursor: pointer;
            transition: transform .22s;
        }

        .related-card:hover {
            transform: translateY(-4px);
        }

        .related-card-img {
            height: 220px;
            border-radius: 4px;
            overflow: hidden;
            background: var(--soft-bg);
            margin-bottom: .9rem;
        }

        .related-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .35s;
        }

        .related-card:hover .related-card-img img {
            transform: scale(1.05);
        }

        .related-brand {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: .25rem;
        }

        .related-name {
            font-size: .88rem;
            color: var(--charcoal);
            margin-bottom: .35rem;
        }

        .related-price {
            font-size: .88rem;
            font-weight: 600;
            color: var(--charcoal);
        }

        /* ═══════════════════════════
       RITUAL / BUNDLE CTA
    ═══════════════════════════ */
        .ritual-cta-section {
            background: var(--cream);
            border-top: 1px solid var(--border-light);
        }

        .ritual-cta-inner {
            max-width: 1320px;
            margin: 0 auto;
            padding: 5rem 3rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .ritual-img-wrap {
            position: relative;
        }

        .ritual-img-wrap img {
            width: 100%;
            border-radius: 4px;
            display: block;
        }

        .ritual-bundle-pill {
            position: absolute;
            bottom: -1rem;
            right: -1rem;
            background: white;
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: .85rem 1.3rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .07);
        }

        .ritual-bundle-pill .pill-tag {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--warm-gray);
        }

        .ritual-bundle-pill .pill-name {
            font-family: 'Playfair Display', serif;
            font-size: .95rem;
            color: var(--charcoal);
            margin: .2rem 0 .75rem;
        }

        .ritual-eyebrow {
            font-size: .68rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--warm-gray);
            margin-bottom: 1rem;
        }

        .ritual-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 400;
            color: var(--charcoal);
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .ritual-desc {
            font-size: .85rem;
            color: var(--warm-gray);
            line-height: 1.8;
            margin-bottom: 1.75rem;
        }

        .ritual-steps {
            margin-bottom: 2rem;
        }

        .ritual-step {
            display: flex;
            align-items: center;
            gap: .65rem;
            font-size: .85rem;
            color: var(--charcoal-mid);
            margin-bottom: .55rem;
        }

        .ritual-step-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--rose);
            flex-shrink: 0;
        }

        .ritual-cta-btns {
            display: flex;
            gap: 1rem;
            align-items: center;
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
            .product-section {
                grid-template-columns: 1fr 1fr;
            }

            .thumb-strip {
                display: none;
            }

            .reviews-grid {
                grid-template-columns: 1fr 1fr;
            }

            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .ritual-cta-inner {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
        }

        @media (max-width: 640px) {
            .breadcrumb {
                padding: .75rem 1.25rem;
            }

            .product-section {
                grid-template-columns: 1fr;
                padding: 1rem 1.25rem 3rem;
            }

            .reviews-section {
                padding: 3rem 1.25rem;
            }

            .related-section {
                padding: 3rem 1.25rem;
            }

            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .reviews-grid {
                grid-template-columns: 1fr;
            }

            .ritual-cta-inner {
                padding: 3rem 1.25rem;
            }

            .rating-summary {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')

    {{-- Breadcrumb --}}
    <nav class="breadcrumb" id="breadcrumb-nav">
        <a href="/">Home</a>
        <span class="breadcrumb-sep">/</span>
        <a href="/shop" id="bc-cat">Skincare</a>
        <span class="breadcrumb-sep">/</span>
        <span id="bc-name">Loading...</span>
    </nav>

    {{-- ── Product Detail ── --}}
    <div class="product-section" id="product-section">
        {{-- Thumbnail strip --}}
        <div class="thumb-strip" id="thumb-strip">
            <div class="skeleton thumb"></div>
            <div class="skeleton thumb"></div>
            <div class="skeleton thumb"></div>
        </div>

        {{-- Main image --}}
        <div class="main-image-wrap">
            <img id="main-img" src="" alt="Product" style="opacity:0">
        </div>

        {{-- Info panel --}}
        <div class="product-info-panel" id="info-panel">
            <div style="height:400px;" class="skeleton"></div>
        </div>
    </div>

    {{-- ── Glow Talk (Reviews) ── --}}
    <section class="reviews-section">
        <div class="reviews-inner">
            <h2 class="reviews-section-title">Glow Talk</h2>

            {{-- Rating summary --}}
            <div class="rating-summary">
                <div class="rating-big">
                    <div class="rating-num" id="avg-rating">—</div>
                    <div class="rating-stars-big" id="avg-stars">☆☆☆☆☆</div>
                    <div class="rating-label">Global Rating</div>
                </div>
                <div class="rating-bars" id="rating-bars">
                    <div class="bar-row"><span class="bar-lbl">5 Stars</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width:0%"></div>
                        </div><span class="bar-pct">0%</span>
                    </div>
                    <div class="bar-row"><span class="bar-lbl">4 Stars</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width:0%"></div>
                        </div><span class="bar-pct">0%</span>
                    </div>
                    <div class="bar-row"><span class="bar-lbl">3 Stars</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width:0%"></div>
                        </div><span class="bar-pct">0%</span>
                    </div>
                </div>
            </div>

            {{-- Review cards --}}
            <div class="reviews-grid" id="reviews-grid">
                <div class="skeleton" style="height:180px;"></div>
                <div class="skeleton" style="height:180px;"></div>
                <div class="skeleton" style="height:180px;"></div>
            </div>

            <div class="write-review-wrap">
                <button class="btn btn-primary" style="border-radius:50px;padding:.7rem 2rem;font-size:.78rem;"
                    onclick="toggleReviewForm()">Write a Review</button>
            </div>
        </div>
    </section>

    {{-- Review form --}}
    <div class="review-form-section" id="review-form-section">
        <div class="review-form-inner">
            <h3>Write Your Review</h3>
            <div class="form-field">
                <label>Your Rating</label>
                <div class="star-picker" id="star-picker">
                    <span class="star-pick" data-v="1" onclick="setStarRating(1)">★</span>
                    <span class="star-pick" data-v="2" onclick="setStarRating(2)">★</span>
                    <span class="star-pick" data-v="3" onclick="setStarRating(3)">★</span>
                    <span class="star-pick" data-v="4" onclick="setStarRating(4)">★</span>
                    <span class="star-pick" data-v="5" onclick="setStarRating(5)">★</span>
                </div>
            </div>
            <div class="form-field">
                <label>Your Review</label>
                <textarea class="form-textarea" id="r-comment" rows="4"
                    placeholder="Share your experience with this product..."></textarea>
            </div>
            <div class="form-actions">
                <button class="btn-primary" onclick="submitReview()">Submit Review</button>
                <button class="btn-secondary" onclick="toggleReviewForm()">Cancel</button>
            </div>
        </div>
    </div>

    {{-- ── Related Products ── --}}
    <section class="related-section">
        <div class="related-header">
            <div>
                <p class="related-eyebrow">Complete the Look</p>
                <h2 class="related-title">Related Rituals</h2>
            </div>
            <div class="related-nav">
                <button class="related-nav-btn" onclick="scrollRelated(-1)">‹</button>
                <button class="related-nav-btn" onclick="scrollRelated(1)">›</button>
            </div>
        </div>
        <div class="related-grid" id="related-grid">
            <div class="skeleton" style="height:300px;"></div>
            <div class="skeleton" style="height:300px;"></div>
            <div class="skeleton" style="height:300px;"></div>
            <div class="skeleton" style="height:300px;"></div>
        </div>
    </section>

    {{-- ── Build Your Ritual CTA ── --}}
    <section class="ritual-cta-section">
        <div class="ritual-cta-inner">
            <div class="ritual-img-wrap">
                <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=700&q=80" alt="The Gold Kit"
                    onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="ritual-bundle-pill">
                    <div class="pill-tag">Bundle &amp; Save</div>
                    <div class="pill-name">The Gold Kit</div>
                    <a href="/shop/bundles" class="btn btn-primary" style="font-size:.7rem;padding:.45rem 1rem;">Add Ritual
                        — Rp 145rb</a>
                </div>
            </div>
            <div>
                <p class="ritual-eyebrow">The Ultimate Glow</p>
                <h2 class="ritual-title">Build Your Dream<br>Daily Skincare<br>Ritual</h2>
                <p class="ritual-desc">Pairs perfectly with your Radiant Glow Serum. This collection is designed to
                    synchronize your morning and evening skincare for maximum radiance.</p>
                <div class="ritual-steps">
                    <div class="ritual-step"><span class="ritual-step-dot"></span>Step 1: Silk Cleanser</div>
                    <div class="ritual-step"><span class="ritual-step-dot"></span>Step 2: Radiant Serum</div>
                    <div class="ritual-step"><span class="ritual-step-dot"></span>Step 3: Quartz Moisturizer</div>
                </div>
                <div class="ritual-cta-btns">
                    <a href="/shop/bundles" class="btn btn-primary" style="padding:.75rem 2rem;">View the Routine</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        const productId = {{ $id }};
        let productData = null;
        let selectedRating = 5;
        let relatedPage = 0;
        let relatedAll = [];

        /* ══ Load product ══ */
        async function loadProduct() {
            try {
                const r = await axios.get(GW + '/products/' + productId);
                const p = r.data.data;
                productData = p;

                /* breadcrumb */
                const catName = p.category?.name || 'Shop';
                document.getElementById('bc-cat').textContent = catName;
                document.getElementById('bc-cat').href = `/shop?cat=${p.category_id || ''}`;
                document.getElementById('bc-name').textContent = p.name;
                document.title = p.name + ' — GlowMart';

                /* thumbnails — use same image for all if no gallery */
                const imgs = p.images?.length ? p.images : [p.image, p.image, p.image, p.image].filter(Boolean);
                const thumbStrip = document.getElementById('thumb-strip');
                thumbStrip.innerHTML = imgs.map((src, i) => `
          <div class="thumb ${i === 0 ? 'active' : ''}" onclick="setMainImg('${src}',this)">
            <img src="${src}" alt="thumb" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
          </div>`).join('');

                /* main image */
                const mainImg = document.getElementById('main-img');
                mainImg.src = p.image || 'https://via.placeholder.com/600x750?text=Beauty';
                mainImg.alt = p.name;
                mainImg.style.opacity = '1';
                mainImg.onerror = () => { mainImg.src = 'https://via.placeholder.com/600x750?text=Beauty'; };

                /* stock */
                const inStock = p.stock > 0;
                const stockTxt = p.stock > 10 ? 'In Stock'
                    : p.stock > 0 ? `Only ${p.stock} left`
                        : 'Out of Stock';

                /* rating */
                const stars = Math.round(p.reviews_avg_rating || 0);
                const rating = p.reviews_avg_rating ? Number(p.reviews_avg_rating).toFixed(1) : '—';
                const rcnt = p.reviews_count || 0;

                /* info panel */
                document.getElementById('info-panel').innerHTML = `
          <div class="product-badge-row">
            <span class="badge-bestseller">Bestseller</span>
            <span class="inline-stars">${'★'.repeat(stars)}${'☆'.repeat(5 - stars)}</span>
            <span class="inline-rating">${rating}</span>
            <span class="inline-reviews">(${rcnt.toLocaleString()} Reviews)</span>
          </div>

          <h1 class="product-title">${p.name}</h1>
          <p class="product-subtitle">${p.brand || p.category?.name || 'Nourishing Complex'}</p>

          <div class="price-row">
            <span class="price-main">${formatRp(p.price)}</span>
            ${p.original_price ? `<span class="price-original">${formatRp(p.original_price)}</span>` : ''}
          </div>

          <p class="product-desc">${p.description || 'Experience the transformative power of our award-winning formula. Deeply hydrates while illuminating your complexion from within. Perfect for all skin types seeking a natural, dewy finish.'}</p>

          <div class="size-label">Size: <span style="color:var(--charcoal-mid);font-weight:400;letter-spacing:0;text-transform:none;">30ml</span></div>
          <div class="size-options">
            <button class="size-btn active" onclick="selectSize(this)">30ml</button>
            <button class="size-btn" onclick="selectSize(this)">50ml</button>
            <button class="size-btn" onclick="selectSize(this)">100ml</button>
          </div>

          <div class="qty-cta-row">
            <div class="qty-ctrl">
              <button class="qty-btn" onclick="changeQty(-1)">−</button>
              <input class="qty-val" id="qty" type="number" value="1" min="1" max="${p.stock}" readonly>
              <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>
            <button class="btn-add-cart" id="add-cart-btn" onclick="addToCart()" ${!inStock ? 'disabled' : ''}>
              ${inStock ? 'Add to Cart' : 'Out of Stock'}
            </button>
            <button class="btn-wishlist-round" onclick="addWishlist()" title="Save to wishlist">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
              </svg>
            </button>
          </div>

          <div class="accordion">
            <div class="accordion-item">
              <div class="accordion-head" onclick="toggleAcc(this)">
                <h4>How to Use</h4>
                <span class="accordion-icon">∨</span>
              </div>
              <div class="accordion-body">
                Apply 2–3 drops to cleansed skin morning and evening. Gently press into face and neck. Follow with moisturizer. For best results, use consistently for 4 weeks.
              </div>
            </div>
            <div class="accordion-item">
              <div class="accordion-head" onclick="toggleAcc(this)">
                <h4>Key Ingredients</h4>
                <span class="accordion-icon">∨</span>
              </div>
              <div class="accordion-body">
                Vitamin C Complex, Hyaluronic Acid, Niacinamide, Rose Hip Seed Oil, Peptide Blend. Free from parabens, sulfates, and synthetic fragrances.
              </div>
            </div>
            <div class="accordion-item">
              <div class="accordion-head" onclick="toggleAcc(this)">
                <h4>Shipping &amp; Returns</h4>
                <span class="accordion-icon">∨</span>
              </div>
              <div class="accordion-body">
                Free shipping on orders over Rp 250.000. Standard delivery 2–4 business days. Returns accepted within 30 days of purchase for unused, unopened items.
              </div>
            </div>
          </div>`;

                loadReviews();
                loadRelated(p.category_id);
            } catch (e) {
                document.getElementById('info-panel').innerHTML = '<p style="color:var(--warm-gray)">Gagal memuat produk.</p>';
            }
        }

        /* ══ Thumbnail switcher ══ */
        function setMainImg(src, thumbEl) {
            const img = document.getElementById('main-img');
            img.style.opacity = '0';
            setTimeout(() => { img.src = src; img.style.opacity = '1'; }, 180);
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            thumbEl.classList.add('active');
        }

        /* ══ Size select ══ */
        function selectSize(btn) {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelector('.size-label').innerHTML =
                `Size: <span style="color:var(--charcoal-mid);font-weight:400;letter-spacing:0;text-transform:none;">${btn.textContent}</span>`;
        }

        /* ══ Qty ══ */
        function changeQty(d) {
            const el = document.getElementById('qty');
            if (!el) return;
            const max = parseInt(el.max) || 99;
            el.value = Math.max(1, Math.min(max, parseInt(el.value) + d));
        }

        /* ══ Add to cart ══ */
        async function addToCart() {
            if (!getUser()) { toast('Silakan login dulu', 'error'); window.location.href = '/login'; return; }
            const qty = parseInt(document.getElementById('qty').value) || 1;
            try {
                loading(true);
                await axios.post(API + '/cart/add', { product_id: productId, quantity: qty });
                toast('Added to cart ✓', 'success');
                updateCartBadge();
            } catch (e) { toast(e.response?.data?.message || 'Gagal menambahkan', 'error'); }
            finally { loading(false); }
        }

        /* ══ Wishlist ══ */
        function addWishlist(id) {
            const user = getUser();
            if (!user) { window.location.href = '/login'; return; }

            const pid = Number(id);
            let items = JSON.parse(localStorage.getItem('gm_wishlist') || '[]').map(Number);

            if (items.includes(pid)) {
                items = items.filter(i => i !== pid);
                localStorage.setItem('gm_wishlist', JSON.stringify(items));
                toast('Dihapus dari wishlist', '');
            } else {
                items.push(pid);
                localStorage.setItem('gm_wishlist', JSON.stringify(items));
                toast('Ditambahkan ke wishlist ❤️', 'success');
            }
        }

        /* ══ Accordion ══ */
        function toggleAcc(head) {
            const body = head.nextElementSibling;
            const icon = head.querySelector('.accordion-icon');
            const open = body.classList.contains('open');
            body.classList.toggle('open', !open);
            icon.classList.toggle('open', !open);
        }

        /* ══ Reviews ══ */
        async function loadReviews() {
            try {
                const r = await axios.get(API + '/products/' + productId + '/reviews');
                const reviews = r.data.data || [];

                /* avg + bars */
                if (reviews.length) {
                    const avg = reviews.reduce((s, rv) => s + rv.rating, 0) / reviews.length;
                    document.getElementById('avg-rating').textContent = avg.toFixed(1);
                    const s = Math.round(avg);
                    document.getElementById('avg-stars').textContent = '★'.repeat(s) + '☆'.repeat(5 - s);

                    const counts = { 5: 0, 4: 0, 3: 0 };
                    reviews.forEach(rv => { if (counts[rv.rating] !== undefined) counts[rv.rating]++; });
                    const bars = document.getElementById('rating-bars');
                    bars.innerHTML = [5, 4, 3].map(n => {
                        const pct = reviews.length ? Math.round(counts[n] / reviews.length * 100) : 0;
                        return `<div class="bar-row">
              <span class="bar-lbl">${n} Stars</span>
              <div class="bar-track"><div class="bar-fill" style="width:${pct}%"></div></div>
              <span class="bar-pct">${pct}%</span>
            </div>`;
                    }).join('');
                }

                /* review cards */
                const grid = document.getElementById('reviews-grid');
                if (!reviews.length) {
                    grid.innerHTML = '<p style="grid-column:1/-1;color:var(--warm-gray);font-size:.85rem;text-align:center;padding:2rem 0;">Be the first to review this product.</p>';
                    return;
                }
                grid.innerHTML = reviews.slice(0, 3).map(rv => {
                    const initials = (rv.user?.name || 'U').split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
                    const stars = Math.round(rv.rating || 0);
                    const date = new Date(rv.created_at).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                    return `
            <div class="review-card">
              <div class="review-author-row">
                <div class="review-avatar">${initials}</div>
                <div>
                  <div class="review-author-name">${rv.user?.name || 'Customer'}</div>
                  <div class="review-author-date">${date}</div>
                </div>
              </div>
              <div class="review-stars-row">${'★'.repeat(stars)}${'☆'.repeat(5 - stars)}</div>
              <p class="review-text">${rv.comment || ''}</p>
            </div>`;
                }).join('');
            } catch {
                document.getElementById('reviews-grid').innerHTML =
                    '<p style="grid-column:1/-1;color:var(--warm-gray);text-align:center;padding:2rem 0;">Gagal memuat ulasan.</p>';
            }
        }

        /* ══ Review form ══ */
        function toggleReviewForm() {
            if (!getUser()) { toast('Login untuk menulis ulasan', 'error'); window.location.href = '/login'; return; }
            const sec = document.getElementById('review-form-section');
            const open = sec.classList.toggle('open');
            if (open) sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function setStarRating(val) {
            selectedRating = val;
            document.querySelectorAll('.star-pick').forEach(s => {
                s.classList.toggle('lit', parseInt(s.dataset.v) <= val);
            });
        }
        /* init stars */
        setStarRating(5);

        async function submitReview() {
            const comment = document.getElementById('r-comment').value.trim();
            if (!comment) { toast('Tulis komentar dulu ya', 'error'); return; }
            try {
                loading(true);
                await axios.post(API + '/products/' + productId + '/reviews', { rating: selectedRating, comment });
                toast('Review submitted ✓', 'success');
                document.getElementById('r-comment').value = '';
                document.getElementById('review-form-section').classList.remove('open');
                loadReviews();
            } catch (e) { toast(e.response?.data?.message || 'Gagal kirim ulasan', 'error'); }
            finally { loading(false); }
        }

        /* ══ Related products ══ */
        async function loadRelated(catId) {
            try {
                const params = catId ? `?category_id=${catId}&per_page=8` : '?per_page=8';
                const r = await axios.get(GW + '/products' + params);
                relatedAll = (r.data.data.data || []).filter(p => p.id != productId).slice(0, 8);
                renderRelated();
            } catch {
                document.getElementById('related-grid').innerHTML = '';
            }
        }

        function renderRelated() {
            const show = relatedAll.slice(relatedPage * 4, relatedPage * 4 + 4);
            if (!show.length) return;
            document.getElementById('related-grid').innerHTML = show.map(p => `
        <div class="related-card" onclick="window.location='/product/${p.id}'">
          <div class="related-card-img">
            <img src="${p.image || 'https://via.placeholder.com/300x220?text=Beauty'}" alt="${p.name}"
                 onerror="this.onerror=null;this.src='/img/placeholder.svg'" loading="lazy">
          </div>
          <div class="related-brand">${p.brand || p.category?.name || ''}</div>
          <div class="related-name">${p.name}</div>
          <div class="related-price">${formatRp(p.price)}</div>
        </div>`).join('');
        }

        function scrollRelated(dir) {
            const maxPage = Math.ceil(relatedAll.length / 4) - 1;
            relatedPage = Math.max(0, Math.min(maxPage, relatedPage + dir));
            renderRelated();
        }

        /* ══ Init ══ */
        loadProduct();
    </script>
@endsection
