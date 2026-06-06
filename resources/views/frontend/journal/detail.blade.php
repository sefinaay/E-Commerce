@extends('frontend.layout')
@section('title', 'Article — GlowMart Journal')

@section('head')
<style>
/* ── Breadcrumb ── */
.article-breadcrumb {
  max-width: 1320px;
  margin: 0 auto;
  padding: 1.25rem 3rem .5rem;
  display: flex;
  align-items: center;
  gap: .4rem;
  font-size: .72rem;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--warm-gray);
}
.article-breadcrumb a { color: var(--warm-gray); text-decoration: none; transition: color .15s; }
.article-breadcrumb a:hover { color: var(--charcoal); }
.article-breadcrumb span { color: var(--charcoal); }

/* ── Article wrap ── */
.article-wrap { max-width: 780px; margin: 0 auto; padding: 2.5rem 2rem 5rem; }

.article-cat {
  font-size: .65rem;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--rose);
  background: var(--rose-pale);
  display: inline-block;
  padding: .25rem .75rem;
  border-radius: 2px;
  margin-bottom: 1.1rem;
}
.article-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(2rem, 5vw, 2.8rem);
  font-weight: 400;
  color: var(--charcoal);
  line-height: 1.15;
  margin-bottom: 1.25rem;
}
.article-meta {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  margin-bottom: 2.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid var(--border-light);
  font-size: .78rem;
  color: var(--warm-gray);
  flex-wrap: wrap;
}
.article-author { display: flex; align-items: center; gap: .65rem; }
.author-avatar {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: var(--rose-pale);
  color: var(--rose);
  font-size: .8rem;
  font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.author-name { font-weight: 600; color: var(--charcoal); font-size: .82rem; }
.article-cover {
  width: 100%;
  border-radius: 6px;
  object-fit: cover;
  max-height: 480px;
  margin-bottom: 2.5rem;
  background: var(--soft-bg);
  display: block;
}

/* ── Article content ── */
.article-content {
  font-family: 'Jost', sans-serif;
  font-size: .95rem;
  color: var(--charcoal-mid);
  line-height: 1.9;
}
.article-content h2 {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  font-weight: 400;
  color: var(--charcoal);
  margin: 2.5rem 0 .85rem;
  line-height: 1.25;
}
.article-content h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.25rem;
  color: var(--charcoal);
  margin: 2rem 0 .65rem;
}
.article-content p { margin-bottom: 1.25rem; }
.article-content ul, .article-content ol { padding-left: 1.5rem; margin-bottom: 1.25rem; }
.article-content li { margin-bottom: .5rem; }
.article-content blockquote {
  border-left: 3px solid var(--rose-light);
  padding: 1rem 1.25rem;
  background: var(--rose-pale);
  border-radius: 0 4px 4px 0;
  font-family: 'Playfair Display', serif;
  font-style: italic;
  font-size: 1.05rem;
  color: var(--charcoal);
  margin: 1.75rem 0;
}
.article-content img {
  max-width: 100%;
  border-radius: 4px;
  margin: 1.25rem 0;
}
.article-content strong { color: var(--charcoal); }
.article-content a { color: var(--rose); }

/* ── Share row ── */
.article-share {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: 1.5rem 0;
  border-top: 1px solid var(--border-light);
  margin-top: 2.5rem;
  font-size: .75rem;
  color: var(--warm-gray);
  letter-spacing: .06em;
  text-transform: uppercase;
  font-weight: 600;
}
.share-btn {
  width: 34px; height: 34px;
  border-radius: 50%;
  border: 1px solid var(--border);
  background: white;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer;
  color: var(--charcoal-mid);
  font-size: .8rem;
  transition: all .18s;
  text-decoration: none;
}
.share-btn:hover { border-color: var(--rose); color: var(--rose); }

/* ── Related ── */
.related-section {
  background: var(--white);
  border-top: 1px solid var(--border-light);
  padding: 4rem 3rem;
}
.related-inner { max-width: 1320px; margin: 0 auto; }
.related-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.75rem;
  font-weight: 400;
  color: var(--charcoal);
  margin-bottom: 2rem;
}
.related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }

.related-card {
  cursor: pointer;
  border: 1px solid var(--border-light);
  border-radius: 5px;
  overflow: hidden;
  background: white;
  transition: transform .25s, box-shadow .25s;
}
.related-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(200,80,106,.09); }
.related-card-img {
  height: 180px;
  overflow: hidden;
  background: var(--soft-bg);
}
.related-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; display: block; }
.related-card:hover .related-card-img img { transform: scale(1.05); }
.related-card-body { padding: 1.1rem; }
.related-cat { font-size: .62rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--rose); margin-bottom: .3rem; }
.related-name { font-family: 'Playfair Display', serif; font-size: .95rem; color: var(--charcoal); line-height: 1.35; margin-bottom: .4rem; }
.related-time { font-size: .72rem; color: var(--warm-gray); }

/* skeleton */
.skeleton { background: var(--border-light); border-radius: 4px; animation: skpulse 1.4s ease-in-out infinite; }
@keyframes skpulse { 0%,100%{opacity:1}50%{opacity:.4} }

@media (max-width: 768px) {
  .article-breadcrumb { padding: 1rem 1.25rem; }
  .article-wrap { padding: 2rem 1.25rem 4rem; }
  .related-section { padding: 3rem 1.25rem; }
  .related-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')

<nav class="article-breadcrumb">
  <a href="/">Home</a>
  <span>/</span>
  <a href="/journal">Journal</a>
  <span>/</span>
  <span id="bc-title">Article</span>
</nav>

<div class="article-wrap">
  <div id="article-content">
    {{-- skeleton --}}
    <div class="skeleton" style="width:25%;height:24px;margin-bottom:1rem;border-radius:2px;"></div>
    <div class="skeleton" style="width:90%;height:44px;margin-bottom:.5rem;"></div>
    <div class="skeleton" style="width:70%;height:44px;margin-bottom:2rem;"></div>
    <div class="skeleton" style="width:100%;height:480px;border-radius:6px;margin-bottom:2rem;"></div>
    <div class="skeleton" style="width:100%;height:16px;margin-bottom:.6rem;"></div>
    <div class="skeleton" style="width:95%;height:16px;margin-bottom:.6rem;"></div>
    <div class="skeleton" style="width:80%;height:16px;"></div>
  </div>
</div>

<section class="related-section" id="related-section" style="display:none;">
  <div class="related-inner">
    <h2 class="related-title">You May Also Like</h2>
    <div class="related-grid" id="related-grid"></div>
  </div>
</section>

@endsection

@section('scripts')
<script>
const articleSlug = '{{ $slug }}';

/*
 * Pool gambar per-kategori — sama dengan index.blade.php
 * supaya gambar fallback konsisten di semua halaman.
 */
const IMG_POOL = {
  'Skincare': [
    'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=900&q=80',
    'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=900&q=80',
    'https://images.unsplash.com/photo-1631390990881-3b6264e55bcd?w=900&q=80',
    'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=900&q=80',
  ],
  'Makeup': [
    'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=900&q=80',
    'https://images.unsplash.com/photo-1487412947147-5cebf100d293?w=900&q=80',
    'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=900&q=80',
    'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=900&q=80',
  ],
  'Fragrance': [
    'https://images.unsplash.com/photo-1541643600914-78b084683702?w=900&q=80',
    'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=900&q=80',
    'https://images.unsplash.com/photo-1588776814546-1ffbb5b8ab9e?w=900&q=80',
  ],
  'Haircare': [
    'https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=900&q=80',
    'https://images.unsplash.com/photo-1560869713-7d0a29430803?w=900&q=80',
  ],
  'Beauty Tips': [
    'https://images.unsplash.com/photo-1487412947147-5cebf100d293?w=900&q=80',
    'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=900&q=80',
    'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=900&q=80',
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=900&q=80',
  ],
  'Lifestyle': [
    'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=900&q=80',
    'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=900&q=80',
    'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=900&q=80',
  ],
  'default': [
    'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=900&q=80',
    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=900&q=80',
    'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=900&q=80',
  ],
};

function getFallbackImg(category, seed) {
  const pool = IMG_POOL[category] || IMG_POOL['default'];
  /* gunakan seed (misal: id artikel) supaya konsisten untuk artikel yang sama */
  return pool[seed % pool.length];
}

async function loadArticle() {
  try {
    const r = await axios.get(`/api/journal/${articleSlug}`);
    const { data: a, related } = r.data;

    document.title = `${a.title} — GlowMart Journal`;
    document.getElementById('bc-title').textContent = a.title.length > 40
      ? a.title.slice(0, 40) + '...'
      : a.title;

    const date = a.published_at
      ? new Date(a.published_at).toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' })
      : '';

    /* Pilih gambar: pakai cover_image dari DB, kalau kosong fallback ke pool */
    const heroImg = a.cover_image || getFallbackImg(a.category, a.id || 0);

    const pageUrl = encodeURIComponent(window.location.href);
    const pageTitle = encodeURIComponent(a.title);

    document.getElementById('article-content').innerHTML = `
      <span class="article-cat">${a.category}</span>
      <h1 class="article-title">${a.title}</h1>
      <div class="article-meta">
        <div class="article-author">
          <div class="author-avatar">${(a.author?.name || 'G').charAt(0).toUpperCase()}</div>
          <div>
            <div class="author-name">${a.author?.name || 'GlowMart'}</div>
            <div>${date}</div>
          </div>
        </div>
        <span>·</span>
        <span>${a.read_time} min read</span>
      </div>
      <img class="article-cover"
           src="${heroImg}"
           alt="${a.title}"
           onerror="this.src='https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=900&q=80'">
      <div class="article-content">${a.content}</div>
      <div class="article-share">
        <span>Share</span>
        <a class="share-btn" href="https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}" target="_blank" title="Twitter/X">𝕏</a>
        <a class="share-btn" href="https://www.facebook.com/sharer/sharer.php?u=${pageUrl}" target="_blank" title="Facebook">f</a>
        <a class="share-btn" href="https://wa.me/?text=${pageTitle}%20${pageUrl}" target="_blank" title="WhatsApp">W</a>
        <button class="share-btn" onclick="copyLink()" title="Copy link">🔗</button>
      </div>`;

    /* ── Related ── */
    if (related?.length) {
      document.getElementById('related-section').style.display = 'block';
      document.getElementById('related-grid').innerHTML = related.map((rel, i) => {
        const img = rel.cover_image || getFallbackImg(rel.category, (rel.id || i) + 1);
        return `
          <div class="related-card" onclick="window.location='/journal/${rel.slug}'">
            <div class="related-card-img">
              <img src="${img}" alt="${rel.title}" loading="lazy"
                   onerror="this.src='https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=600&q=80'">
            </div>
            <div class="related-card-body">
              <div class="related-cat">${rel.category}</div>
              <div class="related-name">${rel.title}</div>
              <div class="related-time">${rel.read_time} min read</div>
            </div>
          </div>`;
      }).join('');
    }

  } catch {
    document.getElementById('article-content').innerHTML =
      '<p style="color:var(--warm-gray);text-align:center;padding:4rem 0;">Article not found.</p>';
  }
}

function copyLink() {
  navigator.clipboard.writeText(window.location.href)
    .then(() => toast('Link copied! ✓', 'success'))
    .catch(() => toast('Copy manually: ' + window.location.href, ''));
}

loadArticle();
</script>
@endsection
