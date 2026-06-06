@extends('frontend.layout')
@section('title', 'Our Story — GlowMart')

@section('head')
    <style>
        /* Hero */
        .about-hero {
            position: relative;
            height: 520px;
            overflow: hidden;
            background: linear-gradient(135deg, #f9dde3 0%, #fce8ec 100%);
            display: flex;
            align-items: center;
        }

        .about-hero-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .45;
        }

        .about-hero-content {
            position: relative;
            z-index: 2;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 48px;
        }

        .about-hero-tag {
            font-family: var(--font-sans, 'Jost', sans-serif);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 16px;
        }

        .about-hero-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: clamp(40px, 5vw, 64px);
            font-weight: 400;
            line-height: 1.1;
            color: var(--charcoal);
            margin-bottom: 20px;
        }

        .about-hero-title em {
            font-style: italic;
            color: var(--rose);
        }

        .about-hero-sub {
            font-size: 15px;
            color: var(--warm-gray);
            max-width: 480px;
            line-height: 1.8;
        }

        /* Stats */
        .stats-strip {
            background: white;
            border-bottom: 1px solid var(--border-light);
            padding: 40px 48px;
        }

        .stats-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
            text-align: center;
        }

        .stat-num {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 40px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 6px;
        }

        .stat-num span {
            color: var(--rose);
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--warm-gray);
        }

        /* Story section */
        .story-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 80px 48px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .story-img {
            width: 100%;
            height: 480px;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }

        .story-tag {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 14px;
        }

        .story-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 38px;
            font-weight: 400;
            line-height: 1.15;
            color: var(--charcoal);
            margin-bottom: 20px;
        }

        .story-text {
            font-size: 14px;
            color: var(--warm-gray);
            line-height: 1.9;
            margin-bottom: 16px;
        }

        /* Values */
        .values-section {
            background: var(--soft-bg, #FDF2F5);
            padding: 80px 48px;
        }

        .values-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .values-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .values-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 36px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 12px;
        }

        .values-sub {
            font-size: 14px;
            color: var(--warm-gray);
            max-width: 440px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .value-card {
            background: white;
            border-radius: 20px;
            padding: 36px 28px;
            border: 1px solid var(--border-light);
            transition: transform .25s, box-shadow .25s;
        }

        .value-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(200, 80, 106, .1);
        }

        .value-icon {
            font-size: 36px;
            margin-bottom: 20px;
            display: block;
        }

        .value-name {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 20px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 10px;
        }

        .value-desc {
            font-size: 13px;
            color: var(--warm-gray);
            line-height: 1.8;
        }

        /* Team */
        .team-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 80px 48px;
        }

        .team-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .team-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 36px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 12px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .team-card {
            text-align: center;
        }

        .team-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 18px;
            display: block;
            border: 3px solid var(--border-light);
        }

        .team-name {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 18px;
            color: var(--charcoal);
            margin-bottom: 4px;
        }

        .team-role {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 10px;
        }

        .team-bio {
            font-size: 13px;
            color: var(--warm-gray);
            line-height: 1.7;
            max-width: 280px;
            margin: 0 auto;
        }

        /* CTA */
        .about-cta {
            background: linear-gradient(135deg, #f9dde3 0%, #fce8ec 50%, #ffe4ea 100%);
            padding: 80px 48px;
            text-align: center;
        }

        .about-cta-title {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-size: 40px;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 14px;
        }

        .about-cta-text {
            font-size: 15px;
            color: var(--warm-gray);
            max-width: 420px;
            margin: 0 auto 32px;
            line-height: 1.7;
        }

        .btn-cta-dark {
            padding: 15px 40px;
            background: var(--charcoal);
            color: white;
            border: none;
            border-radius: 50px;
            font-family: var(--font-sans, 'Jost', sans-serif);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .25s;
            text-decoration: none;
            display: inline-block;
            margin: 0 8px;
        }

        .btn-cta-dark:hover {
            background: #333;
            transform: translateY(-1px);
        }

        .btn-cta-outline {
            padding: 14px 36px;
            background: transparent;
            color: var(--charcoal);
            border: 1.5px solid var(--charcoal);
            border-radius: 50px;
            font-family: var(--font-sans, 'Jost', sans-serif);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .25s;
            text-decoration: none;
            display: inline-block;
            margin: 0 8px;
        }

        .btn-cta-outline:hover {
            background: var(--charcoal);
            color: white;
        }

        @media (max-width: 1024px) {
            .story-section {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 48px 24px;
            }

            .story-img {
                height: 320px;
            }

            .values-grid {
                grid-template-columns: 1fr 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-inner {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .about-hero-content {
                padding: 0 24px;
            }

            .stats-strip {
                padding: 32px 24px;
            }

            .values-section {
                padding: 48px 24px;
            }

            .team-section {
                padding: 48px 24px;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr;
            }

            .about-cta {
                padding: 48px 24px;
            }

            .about-cta-title {
                font-size: 28px;
            }
        }
    </style>
@endsection

@section('content')

    {{-- Hero --}}
    <section class="about-hero">
        <img class="about-hero-bg" src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1400&q=80"
            alt="GlowMart Story" onerror="this.onerror=null;this.style.opacity='.08'">
        <div class="about-hero-content">
            <p class="about-hero-tag">Our Story</p>
            <h1 class="about-hero-title">Beauty, <em>Reimagined</em><br>From Within</h1>
            <p class="about-hero-sub">GlowMart was born from a simple belief — that everyone deserves clean, effective
                beauty that celebrates their natural radiance.</p>
        </div>
    </section>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stats-inner">
            <div>
                <div class="stat-num">50<span>K+</span></div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div>
                <div class="stat-num">500<span>+</span></div>
                <div class="stat-label">Curated Products</div>
            </div>
            <div>
                <div class="stat-num">100<span>%</span></div>
                <div class="stat-label">Cruelty Free</div>
            </div>
            <div>
                <div class="stat-num">4.9<span>★</span></div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>
    </div>

    {{-- Story --}}
    <div class="story-section">
        <div>
            <img class="story-img" src="https://images.unsplash.com/photo-1607006344380-b6775a0824a7?w=800&q=80"
                alt="Our Story" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
        </div>
        <div>
            <p class="story-tag">How It Started</p>
            <h2 class="story-title">A Passion for Clean Beauty</h2>
            <p class="story-text">GlowMart started in 2019 when our founder, frustrated by the overwhelming number of beauty
                products filled with harmful chemicals, decided to create a curated destination for clean beauty.</p>
            <p class="story-text">We partner only with brands that share our commitment to transparency, sustainability, and
                effectiveness. Every product on GlowMart has been carefully vetted by our team of beauty experts.</p>
            <p class="story-text">Today, we're proud to serve over 50,000 customers across Indonesia, helping them discover
                beauty routines that are as kind to the planet as they are to their skin.</p>
        </div>
    </div>

    {{-- Values --}}
    <div class="values-section">
        <div class="values-inner">
            <div class="values-header">
                <h2 class="values-title">What We Stand For</h2>
                <p class="values-sub">Our values guide every decision we make, from the products we carry to how we treat
                    our customers.</p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <span class="value-icon">🌿</span>
                    <div class="value-name">Clean Ingredients</div>
                    <p class="value-desc">Every product is formulated without parabens, sulfates, synthetic fragrances, or
                        any ingredient that could harm you or the environment.</p>
                </div>
                <div class="value-card">
                    <span class="value-icon">🐰</span>
                    <div class="value-name">Cruelty Free</div>
                    <p class="value-desc">We are 100% committed to cruelty-free beauty. None of our products are tested on
                        animals, and we only partner with certified cruelty-free brands.</p>
                </div>
                <div class="value-card">
                    <span class="value-icon">♻️</span>
                    <div class="value-name">Sustainable</div>
                    <p class="value-desc">From eco-friendly packaging to carbon-neutral shipping, we're constantly working
                        to reduce our environmental footprint.</p>
                </div>
                <div class="value-card">
                    <span class="value-icon">🔬</span>
                    <div class="value-name">Science-Backed</div>
                    <p class="value-desc">We believe in beauty that works. Every product in our collection is backed by
                        dermatological research and real customer results.</p>
                </div>
                <div class="value-card">
                    <span class="value-icon">🤝</span>
                    <div class="value-name">Transparent</div>
                    <p class="value-desc">Full ingredient lists, honest reviews, and clear sourcing information. We believe
                        you deserve to know exactly what you're putting on your skin.</p>
                </div>
                <div class="value-card">
                    <span class="value-icon">💕</span>
                    <div class="value-name">Inclusive</div>
                    <p class="value-desc">Beauty has no single definition. We celebrate all skin tones, types, and textures
                        — our collection is designed for everyone.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Team --}}
    <div class="team-section">
        <div class="team-header">
            <h2 class="team-title">Meet the Team</h2>
            <p style="font-size:14px;color:var(--warm-gray);max-width:400px;margin:0 auto;line-height:1.7">
                The passionate people behind GlowMart, dedicated to bringing you the best in clean beauty.
            </p>
        </div>
        <div class="team-grid">
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=280&q=80"
                    alt="Sefina Ayudia" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="team-name">Sefina Ayudia</div>
                <div class="team-role">Founder & CEO</div>
                <p class="team-bio">Former cosmetic chemist turned entrepreneur. Sarah founded GlowMart after 10 years in
                    the beauty industry.</p>
            </div>
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=280&q=80"
                    alt="Maya Rodriguez" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="team-name">Naila Keisha </div>
                <div class="team-role">Head of Curation</div>
                <p class="team-bio">Beauty editor and skincare expert with 8 years of experience reviewing and testing
                    beauty products.</p>
            </div>
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=280&q=80"
                    alt="Maya Rodriguez" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="team-name">Nikita Salsabila</div>
                <div class="team-role">Sustainability Director</div>
                <p class="team-bio">Beauty editor and skincare expert with 8 years of experience reviewing and testing
                    beauty products.</p>
            </div>
            <div class="team-card">
                <img class="team-img" src="https://images.unsplash.com/photo-1573496799652-408c2ac9fe98?w=280&q=80"
                    alt="Lisa Park" onerror="this.onerror=null;this.src='/img/placeholder.svg'">
                <div class="team-name">Anggita Putri</div>
                <div class="team-role">Sustainability Director</div>
                <p class="team-bio">Environmental scientist dedicated to making GlowMart's operations as sustainable as
                    possible.</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="about-cta">
        <h2 class="about-cta-title">Ready to Start Your Glow Journey?</h2>
        <p class="about-cta-text">Discover our curated collection of clean beauty products and find your perfect ritual.</p>
        <a href="/shop" class="btn-cta-dark">Shop Now</a>
        <a href="/journal" class="btn-cta-outline">Read Our Journal</a>
    </div>

@endsection
