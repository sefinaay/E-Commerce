@extends('frontend.layout')
@section('title', 'Beauty Journal — GlowMart')
@section('head')
<style>
/* ---- HERO ---- */
.hero {
  position: relative;
  min-height: 580px;
  background: linear-gradient(135deg, #f9dde3 0%, #fce8ec 40%, #ffe4ea 100%);
  overflow: hidden;
  display: flex;
  align-items: center;
}
.hero-bg-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.55;
}
.hero-content {
  position: relative;
  z-index: 2;
  max-width: 560px;
  padding: 80px 0;
}
.hero-overline {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: var(--rose);
  margin-bottom: 20px;
  opacity: 0;
  animation: fadeUp 0.8s 0.2s forwards;
}
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(40px, 6vw, 64px);
  font-weight: 500;
  line-height: 1.1;
  color: var(--charcoal);
  margin-bottom: 20px;
  opacity: 0;
  animation: fadeUp 0.8s 0.4s forwards;
}
.hero-title em { font-style: italic; color: var(--rose); }
.hero-subtitle {
  font-size: 15px;
  font-weight: 300;
  color: var(--charcoal-mid);
  line-height: 1.7;
  margin-bottom: 36px;
  max-width: 380px;
  opacity: 0;
  animation: fadeUp 0.8s 0.6s forwards;
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}
.hero-scroll-hint {
  position: absolute;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .4rem;
  color: var(--warm-gray);
  font-size: .7rem;
  letter-spacing: .12em;
  text-transform: uppercase;
  animation: bobble 2s ease-in-out infinite;
}
@keyframes bobble {
  0%,100% { transform: translateX(-50%) translateY(0); }
  50%      { transform: translateX(-50%) translateY(6px); }
}
.hero-scroll-hint svg { opacity: .5; }

/* ── Filter chips ── */
.journal-filters-wrap {
  background: var(--white);
  border-bottom: 1px solid var(--border-light);
  position: sticky;
  top: 64px;
  z-index: 100;
}
.journal-filters {
  max-width: 1320px;
  margin: 0 auto;
  padding: 0 3rem;
  display: flex;
  align-items: center;
  gap: .5rem;
  height: 52px;
  overflow-x: auto;
  scrollbar-width: none;
}
.filter-chip {
  padding: .35rem 1.1rem;
  border-radius: 50px;
  border: 1px solid var(--border);
  background: white;
  font-family: 'Jost', sans-serif;
  font-size: .75rem;
  font-weight: 500;
  letter-spacing: .04em;
  cursor: pointer;
  transition: all .18s;
  color: var(--warm-gray);
  white-space: nowrap;
  flex-shrink: 0;
}
.filter-chip:hover { border-color: var(--charcoal); color: var(--charcoal); }
.filter-chip.active { background: var(--charcoal); border-color: var(--charcoal); color: white; }

/* ── Main grid ── */
.journal-wrap {
  max-width: 1320px;
  margin: 0 auto;
  padding: 3.5rem 3rem 5rem;
}

/* Featured */
.journal-featured {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0;
  border: 1px solid var(--border-light);
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 2rem;
  cursor: pointer;
  transition: box-shadow .25s;
  background: white;
}
.journal-featured:hover { box-shadow: 0 12px 40px rgba(200,80,106,.1); }
.journal-featured-img { height: 380px; overflow: hidden; }
.journal-featured-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
.journal-featured:hover .journal-featured-img img { transform: scale(1.04); }
.journal-featured-body {
  padding: 3rem 2.5rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.journal-feat-tag {
  display: inline-block;
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--rose);
  background: var(--rose-pale);
  padding: .25rem .7rem;
  border-radius: 2px;
  margin-bottom: 1rem;
}
.journal-feat-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.9rem;
  font-weight: 400;
  color: var(--charcoal);
  line-height: 1.25;
  margin-bottom: .85rem;
}
.journal-feat-excerpt {
  font-size: .85rem;
  color: var(--warm-gray);
  line-height: 1.8;
  margin-bottom: 1.5rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.journal-feat-meta { display: flex; align-items: center; gap: 1rem; font-size: .75rem; color: var(--warm-gray); }
.author-avatar {
  width: 30px; height: 30px;
  border-radius: 50%;
  background: var(--rose-pale);
  color: var(--rose);
  font-size: .72rem;
  font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.journal-feat-read-link {
  font-size: .72rem;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--charcoal);
  font-weight: 600;
  border-bottom: 1px solid var(--charcoal);
  padding-bottom: 1px;
  transition: color .18s;
}
.journal-featured:hover .journal-feat-read-link { color: var(--rose); border-color: var(--rose); }

/* ── Regular grid ── */
.journal-section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
.journal-section-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 400; color: var(--charcoal); }
.journal-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }

.journal-card {
  background: white;
  border: 1px solid var(--border-light);
  border-radius: 5px;
  overflow: hidden;
  cursor: pointer;
  transition: transform .25s, box-shadow .25s;
}
.journal-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(200,80,106,.09); }
.journal-card-img-wrap { overflow: hidden; height: 210px; background: var(--soft-bg); }
.journal-card-img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s; display: block; }
.journal-card:hover .journal-card-img { transform: scale(1.05); }
.journal-card-body { padding: 1.4rem 1.4rem 1.5rem; }
.journal-card-cat { font-size: .63rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--rose); margin-bottom: .55rem; }
.journal-card-title { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 400; color: var(--charcoal); line-height: 1.35; margin-bottom: .65rem; }
.journal-card-excerpt { font-size: .8rem; color: var(--warm-gray); line-height: 1.7; margin-bottom: 1.1rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.journal-card-meta { display: flex; align-items: center; justify-content: space-between; font-size: .72rem; color: var(--warm-gray); border-top: 1px solid var(--border-light); padding-top: .9rem; }
.card-author { display: flex; align-items: center; gap: .5rem; }
.card-author-dot { width: 26px; height: 26px; border-radius: 50%; background: var(--rose-pale); color: var(--rose); font-size: .65rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.card-read-time { display: flex; align-items: center; gap: .3rem; }

/* ── Pagination ── */
.journal-pagination { display: flex; align-items: center; justify-content: center; gap: .4rem; margin-top: 3rem; }
.page-btn { width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--border); background: white; font-family: 'Jost', sans-serif; font-size: .8rem; color: var(--charcoal-mid); cursor: pointer; transition: all .18s; display: flex; align-items: center; justify-content: center; }
.page-btn:hover { border-color: var(--charcoal); color: var(--charcoal); }
.page-btn.active { background: var(--charcoal); border-color: var(--charcoal); color: white; font-weight: 600; }
.page-btn.arrow { font-size: .9rem; }
.page-btn.arrow:hover { background: var(--charcoal); color: white; }
.page-btn:disabled { opacity: .35; pointer-events: none; }

/* ── Empty ── */
.journal-empty { text-align: center; padding: 5rem 2rem; grid-column: 1/-1; }
.journal-empty h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 400; color: var(--charcoal); margin-bottom: .5rem; }
.journal-empty p { font-size: .82rem; color: var(--warm-gray); }

/* ── Newsletter ── */
.journal-newsletter { background: var(--charcoal); padding: 4rem 3rem; text-align: center; }
.journal-newsletter h2 { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; color: white; margin-bottom: .6rem; }
.journal-newsletter p { font-size: .85rem; color: rgba(255,255,255,.55); margin-bottom: 1.75rem; }
.newsletter-form { display: flex; gap: .6rem; max-width: 440px; margin: 0 auto; }
.newsletter-input { flex: 1; padding: .75rem 1.1rem; border: 1px solid rgba(255,255,255,.15); border-radius: 3px; background: rgba(255,255,255,.08); color: white; font-family: 'Jost', sans-serif; font-size: .85rem; outline: none; transition: border-color .18s; }
.newsletter-input::placeholder { color: rgba(255,255,255,.35); }
.newsletter-input:focus { border-color: rgba(255,255,255,.4); }

.skeleton { background: var(--border-light); border-radius: 4px; animation: skpulse 1.4s ease-in-out infinite; }
@keyframes skpulse { 0%,100%{opacity:1}50%{opacity:.4} }

@media (max-width: 1024px) {
  .journal-grid { grid-template-columns: repeat(2, 1fr); }
  .journal-featured { grid-template-columns: 1fr; }
  .journal-featured-img { height: 260px; }
}
@media (max-width: 640px) {
  .journal-filters { padding: 0 1.25rem; }
  .journal-wrap { padding: 2.5rem 1.25rem 4rem; }
  .journal-grid { grid-template-columns: 1fr; }
  .journal-featured-body { padding: 1.5rem; }
  .journal-newsletter { padding: 3rem 1.25rem; }
  .newsletter-form { flex-direction: column; }
}
</style>
@endsection

@section('content')

{{-- ── Hero ── --}}
<section class="hero">
  <img src="https://plus.unsplash.com/premium_photo-1661663609670-61f15ceac37c?q=80&w=1170"
       alt="GlowMart — Clean Beauty" class="hero-bg-img">
  <div class="container">
    <div class="hero-content">
      <p class="hero-overline">The Beauty Edit</p>
      <h1 class="hero-title">Beauty Journal</h1>
      <p class="hero-subtitle">Expert tips, skincare rituals, and beauty stories curated for your daily glow.</p>
    </div>
  </div>
  <div class="hero-scroll-hint">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <polyline points="6 9 12 15 18 9"/>
    </svg>
    Scroll
  </div>
</section>

{{-- ── Filter chips ── --}}
<div class="journal-filters-wrap">
  <div class="journal-filters">
    <button class="filter-chip active" onclick="filterCategory(null,this)">All</button>
    <button class="filter-chip" onclick="filterCategory('Beauty Tips',this)">Beauty Tips</button>
    <button class="filter-chip" onclick="filterCategory('Skincare',this)">Skincare</button>
    <button class="filter-chip" onclick="filterCategory('Makeup',this)">Makeup</button>
    <button class="filter-chip" onclick="filterCategory('Fragrance',this)">Fragrance</button>
    <button class="filter-chip" onclick="filterCategory('Lifestyle',this)">Lifestyle</button>
  </div>
</div>

{{-- ── Content ── --}}
<div class="journal-wrap">
  <div id="journal-featured"></div>
  <div id="journal-rest">
    <div class="journal-section-head" style="display:none;" id="more-head">
      <h2 class="journal-section-title">More Articles</h2>
    </div>
    <div class="journal-grid" id="journal-grid">
      @for($i=0;$i<6;$i++)
      <div>
        <div class="skeleton" style="height:210px;border-radius:5px 5px 0 0;"></div>
        <div style="background:white;border:1px solid var(--border-light);border-top:none;border-radius:0 0 5px 5px;padding:1.4rem;">
          <div class="skeleton" style="width:35%;height:10px;margin-bottom:.7rem;"></div>
          <div class="skeleton" style="width:90%;height:16px;margin-bottom:.5rem;"></div>
          <div class="skeleton" style="width:70%;height:16px;margin-bottom:1rem;"></div>
          <div class="skeleton" style="width:100%;height:11px;margin-bottom:.4rem;"></div>
          <div class="skeleton" style="width:80%;height:11px;"></div>
        </div>
      </div>
      @endfor
    </div>
  </div>
  <div class="journal-pagination" id="journal-pagination"></div>
</div>

{{-- ── Newsletter ── --}}
<section class="journal-newsletter">
  <h2>Stay in the Glow</h2>
  <p>Beauty tips, new arrivals, and exclusive offers delivered to your inbox.</p>
  <div class="newsletter-form">
    <input class="newsletter-input" type="email" id="nl-email" placeholder="your@email.com">
    <button class="btn btn-primary" style="border-radius:3px;padding:.75rem 1.5rem;font-size:.75rem;white-space:nowrap;"
            onclick="subscribeNewsletter()">Subscribe</button>
  </div>
</section>

@endsection

@section('scripts')
<script>
let currentCategory = null;
let currentPage     = 1;

/*
 * Pool gambar per-kategori — dipakai ketika cover_image dari DB kosong.
 * Setiap artikel mengambil gambar yang berbeda berdasarkan index-nya
 * sehingga tidak ada 2 artikel bersebelahan dengan foto yang sama.
 */
const IMG_POOL = {
  'Skincare': [
    'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',
    'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=800&q=80',
    'https://images.unsplash.com/photo-1631390990881-3b6264e55bcd?w=800&q=80',
    'https://images.unsplash.com/photo-1611080541599-8c6dbde6ed28?w=800&q=80',
    'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&q=80',
    'https://images.unsplash.com/photo-1512207736890-6ffed8a84e8d?w=800&q=80',
  ],
  'Makeup': [
    'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=800&q=80',
    'https://images.unsplash.com/photo-1487412947147-5cebf100d293?w=800&q=80',
    'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=800&q=80',
    'https://images.unsplash.com/photo-1503236823255-94609f598e71?w=800&q=80',
    'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=800&q=80',
    'https://images.unsplash.com/photo-1519014816548-bf5fe059798b?w=800&q=80',
  ],
  'Fragrance': [
    'https://images.unsplash.com/photo-1541643600914-78b084683702?w=800&q=80',
    'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=800&q=80',
    'https://images.unsplash.com/photo-1588776814546-1ffbb5b8ab9e?w=800&q=80',
    'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=800&q=80',
    'https://images.unsplash.com/photo-1547887538-047ad8ccd4ee?w=800&q=80',
    'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800&q=80',
  ],
  'Haircare': [
    'https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=800&q=80',
    'https://images.unsplash.com/photo-1560869713-7d0a29430803?w=800&q=80',
    'https://images.unsplash.com/photo-1634449571010-02389ed0f9b0?w=800&q=80',
    'https://images.unsplash.com/photo-1598524374912-6b0a2f75d0c3?w=800&q=80',
  ],
  'Beauty Tips': [
    'https://images.unsplash.com/photo-1487412947147-5cebf100d293?w=800&q=80',
    'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=800&q=80',
    'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=800&q=80',
    'https://images.unsplash.com/photo-1520013573690-82d9c69c3ec0?w=800&q=80',
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&q=80',
    'https://images.unsplash.com/photo-1607748851687-ba9a10438621?w=800&q=80',
  ],
  'Lifestyle': [
    'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&q=80',
    'https://images.unsplash.com/photo-1519415510236-718bdfcd89c8?w=800&q=80',
    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80',
    'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=800&q=80',
    'https://images.unsplash.com/photo-1471286174890-9c112ffca5b4?w=800&q=80',
    'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=800&q=80',
  ],
  /* fallback jika kategori tidak dikenali */
  'default': [
    'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&q=80',
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&q=80',
    'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=800&q=80',
    'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=800&q=80',
    'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=800&q=80',
    'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',
  ],
};

/**
 * Kembalikan URL gambar untuk artikel pada index tertentu.
 * Jika artikel sudah punya cover_image sendiri → pakai itu.
 * Kalau tidak → pilih dari pool berdasarkan kategori + index
 * supaya setiap kartu punya foto berbeda.
 */
function getArticleImg(article, indexInBatch) {
  if (article.cover_image) return article.cover_image;
  const pool = IMG_POOL[article.category] || IMG_POOL['default'];
  return pool[indexInBatch % pool.length];
}

/* ── Load journals ── */
async function loadJournals(page = 1) {
  currentPage = page;
  const params = new URLSearchParams({ per_page: 7, page });
  if (currentCategory) params.set('category', currentCategory);

  /* skeleton */
  document.getElementById('journal-featured').innerHTML = '';
  document.getElementById('journal-grid').innerHTML =
    Array(6).fill(`
      <div>
        <div class="skeleton" style="height:210px;border-radius:5px 5px 0 0;"></div>
        <div style="background:white;border:1px solid var(--border-light);border-top:none;border-radius:0 0 5px 5px;padding:1.4rem;">
          <div class="skeleton" style="width:35%;height:10px;margin-bottom:.7rem;"></div>
          <div class="skeleton" style="width:90%;height:16px;margin-bottom:.5rem;"></div>
          <div class="skeleton" style="width:70%;height:16px;margin-bottom:1rem;"></div>
          <div class="skeleton" style="width:100%;height:11px;margin-bottom:.4rem;"></div>
          <div class="skeleton" style="width:80%;height:11px;"></div>
        </div>
      </div>`).join('');
  document.getElementById('journal-pagination').innerHTML = '';

  try {
    const r = await axios.get(`/api/journal?${params}`);
    const { data: articles, last_page, current_page } = r.data.data;

    if (!articles.length) {
      document.getElementById('journal-featured').innerHTML = '';
      document.getElementById('journal-grid').innerHTML = `
        <div class="journal-empty">
          <div style="font-size:2.5rem;margin-bottom:1rem;opacity:.4;">📖</div>
          <h3>No articles yet</h3>
          <p>Check back soon for beauty tips and stories.</p>
        </div>`;
      document.getElementById('more-head').style.display = 'none';
      return;
    }

    /* ── Featured (artikel pertama) ── */
    const feat    = articles[0];
    const featImg = getArticleImg(feat, 0);
    const featInit = (feat.author?.name || 'G').charAt(0).toUpperCase();

    document.getElementById('journal-featured').innerHTML = `
      <div class="journal-featured" onclick="window.location='/journal/${feat.slug}'">
        <div class="journal-featured-img">
          <img src="${featImg}" alt="${feat.title}"
               onerror="this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=800&q=80'">
        </div>
        <div class="journal-featured-body">
          <span class="journal-feat-tag">${feat.category}</span>
          <h2 class="journal-feat-title">${feat.title}</h2>
          <p class="journal-feat-excerpt">${feat.excerpt || ''}</p>
          <div class="journal-feat-meta">
            <div class="author-avatar">${featInit}</div>
            <span>${feat.author?.name || 'GlowMart'}</span>
            <span>·</span>
            <span>${feat.read_time} min read</span>
          </div>
          <div style="margin-top:1.25rem;">
            <span class="journal-feat-read-link">Read Article →</span>
          </div>
        </div>
      </div>`;

    /* ── Rest (artikel 2–7) ── */
    const rest = articles.slice(1);
    document.getElementById('more-head').style.display = rest.length ? 'flex' : 'none';

    if (!rest.length) {
      document.getElementById('journal-grid').innerHTML = '';
    } else {
      document.getElementById('journal-grid').innerHTML = rest.map((a, i) => {
        /*
         * i dimulai dari 0 untuk artikel ke-2.
         * Kita pakai (i + 1) supaya index-nya berbeda dari featured (0),
         * dan setiap kartu dalam grid mendapat gambar yang berbeda.
         */
        const img  = getArticleImg(a, i + 1);
        const init = (a.author?.name || 'G').charAt(0).toUpperCase();

        return `
          <div class="journal-card" onclick="window.location='/journal/${a.slug}'">
            <div class="journal-card-img-wrap">
              <img class="journal-card-img" src="${img}" alt="${a.title}"
                   loading="lazy"
                   onerror="this.src='https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=600&q=80'">
            </div>
            <div class="journal-card-body">
              <div class="journal-card-cat">${a.category}</div>
              <h3 class="journal-card-title">${a.title}</h3>
              <p class="journal-card-excerpt">${a.excerpt || ''}</p>
              <div class="journal-card-meta">
                <div class="card-author">
                  <div class="card-author-dot">${init}</div>
                  <span>${a.author?.name || 'GlowMart'}</span>
                </div>
                <div class="card-read-time">
                  <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                  </svg>
                  ${a.read_time} min
                </div>
              </div>
            </div>
          </div>`;
      }).join('');
    }

    /* ── Pagination ── */
    if (last_page > 1) {
      let pages = [];
      pages.push(`<button class="page-btn arrow" onclick="loadJournals(${Math.max(1, current_page-1)})" ${current_page===1?'disabled':''}>‹</button>`);
      for (let i = 1; i <= last_page; i++) {
        pages.push(`<button class="page-btn ${i===current_page?'active':''}" onclick="loadJournals(${i})">${i}</button>`);
      }
      pages.push(`<button class="page-btn arrow" onclick="loadJournals(${Math.min(last_page, current_page+1)})" ${current_page===last_page?'disabled':''}>›</button>`);
      document.getElementById('journal-pagination').innerHTML = pages.join('');
    }

  } catch {
    document.getElementById('journal-grid').innerHTML =
      '<p style="color:var(--warm-gray);grid-column:1/-1;text-align:center;padding:3rem 0;">Failed to load articles.</p>';
  }
}

function filterCategory(cat, el) {
  currentCategory = cat;
  document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  loadJournals(1);
}

function subscribeNewsletter() {
  const email = document.getElementById('nl-email').value.trim();
  if (!email || !email.includes('@')) { toast('Enter a valid email address', 'error'); return; }
  toast('Thank you for subscribing! ✓', 'success');
  document.getElementById('nl-email').value = '';
}

loadJournals();
</script>
@endsection
