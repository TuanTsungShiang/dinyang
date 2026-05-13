@extends('layouts.app')

@section('title', '產品服務｜定陽企業有限公司')

@section('description', '定陽企業有限公司提供線材加工、連接器組裝、客製線組、自動化設備用線、醫療設備配線與 OEM/ODM 服務，歡迎洽詢。')

@section('content')

  {{-- Page Banner --}}
  <section class="page-banner">
    <div class="container">
      <nav class="breadcrumb" aria-label="麵包屑">
        <a href="/">首頁</a>
        <span>/</span>
        <span>產品服務</span>
      </nav>
      <h1>產品服務</h1>
      <p>線材加工、連接器組裝、客製線組到 OEM/ODM，提供完整一站式解決方案</p>
    </div>
  </section>

  {{-- Filter + Product Grid --}}
  @php $activeCatSlug = request('cat'); @endphp
  <section>
    <div class="container">

      <div class="filter-wrap" role="group" aria-label="產品分類篩選">
        <button class="filter-btn {{ !$activeCatSlug ? 'active' : '' }}" data-filter="all">全部</button>
        @foreach($categories as $category)
          <button class="filter-btn {{ $activeCatSlug === $category->slug ? 'active' : '' }}"
                  data-filter="{{ $category->name }}" data-slug="{{ $category->slug }}">
            {{ $category->name }}
          </button>
        @endforeach
      </div>

      <div class="product-list-grid" id="product-grid">
        @forelse($products as $product)
          <article class="product-list-card" data-category="{{ $product->category?->name }}"
                   @if($activeCatSlug && $product->category?->slug !== $activeCatSlug) hidden @endif>
            <div class="product-thumb"
                 style="{{ $product->thumbnail ? '' : 'background-color:' . ($product->category?->color_band ?? '#0b4ea2') }}">
              @if($product->thumbnail)
                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                     alt="{{ $product->name }}" />
              @else
                <span class="product-thumb-icon">{{ $product->icon }}</span>
              @endif
              <span class="product-cat-badge">{{ $product->category?->name }}</span>
            </div>
            <div class="product-card-body">
              <h3>{{ $product->name }}</h3>
              <p>{{ $product->short_description }}</p>
              <a class="product-card-link"
                 href="{{ route('products.show', $product->slug) }}">了解更多 →</a>
            </div>
          </article>
        @empty
          <p style="color:#666; padding: 2rem 0">產品資料建置中，請稍後再來。</p>
        @endforelse
      </div>

    </div>
  </section>

  {{-- CTA Strip --}}
  <div class="cta-strip">
    <div class="container">
      <h2>找不到符合需求的線材規格？</h2>
      <p>提供您的應用環境、線材長度、接頭型號或設備需求，<br>我們將協助評估可行方案。</p>
      <div class="btn-group">
        <a class="btn btn-outline" href="/#contact">送出需求</a>
        <a class="btn btn-line" href="https://line.me/R/ti/p/@503xumnz"
           target="_blank" rel="noopener">
          <img src="/img/icon/line_bubble.png" alt="" />
          LINE 技術洽詢
        </a>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const btns  = document.querySelectorAll('.filter-btn');
  const cards = document.querySelectorAll('.product-list-card');

  function applyFilter(filter) {
    btns.forEach(b => b.classList.remove('active'));
    const active = [...btns].find(b => b.dataset.filter === filter);
    (active ?? btns[0]).classList.add('active');
    cards.forEach(card => {
      if (filter === 'all' || card.dataset.category === filter) {
        card.removeAttribute('hidden');
      } else {
        card.setAttribute('hidden', '');
      }
    });

    // 同步更新 URL（不重新載入頁面）
    const btn = [...btns].find(b => b.dataset.filter === filter);
    const slug = btn?.dataset.slug;
    const url = slug ? `?cat=${slug}` : location.pathname;
    history.replaceState(null, '', url);
  }

  btns.forEach(btn => {
    btn.addEventListener('click', () => applyFilter(btn.dataset.filter));
  });

  // 從首頁帶過來的 ?cat=slug 自動套用
  const catSlug = new URLSearchParams(location.search).get('cat');
  if (catSlug) {
    const matched = [...btns].find(b => b.dataset.slug === catSlug);
    if (matched) applyFilter(matched.dataset.filter);
  }
});
</script>
@endpush
