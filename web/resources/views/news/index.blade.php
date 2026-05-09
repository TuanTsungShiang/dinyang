@extends('layouts.app')

@section('title', '最新消息｜定陽企業有限公司')
@section('description', '定陽企業最新消息，包含公司動態、展會資訊與技術文章。')

@section('content')

  {{-- Page Banner --}}
  <section class="page-banner">
    <div class="container">
      <nav class="breadcrumb" aria-label="麵包屑">
        <a href="/">首頁</a>
        <span>/</span>
        <span>最新消息</span>
      </nav>
      <h1>最新消息</h1>
      <p>公司動態、展會資訊與技術文章</p>
    </div>
  </section>

  {{-- News Grid --}}
  <section>
    <div class="container">

      {{-- 分類 Filter --}}
      @if($categories->isNotEmpty())
        <div class="filter-wrap" role="group" aria-label="消息分類篩選">
          <button class="filter-btn active" data-filter="all">全部</button>
          @foreach($categories as $category)
            <button class="filter-btn" data-filter="{{ $category->name }}">
              {{ $category->name }}
            </button>
          @endforeach
        </div>
      @endif

      <div class="news-grid" id="news-grid">
        @forelse($news as $item)
          <article class="card news-card" data-category="{{ $item->category?->name }}">
            <div class="news-image">
              @if($item->cover_image)
                <img src="{{ asset('storage/' . $item->cover_image) }}"
                     alt="{{ $item->title }}"
                     style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" />
              @endif
              <span class="tag">{{ $item->category?->name }}</span>
            </div>
            <div class="news-body">
              <h3>{{ $item->title }}</h3>
              <time>{{ $item->published_at?->format('Y / m / d') }}</time>
              <p>{{ $item->excerpt }}</p>
              <a href="{{ route('news.show', $item->slug) }}">閱讀更多 →</a>
            </div>
          </article>
        @empty
          <p style="color:var(--muted); grid-column:1/-1; padding:2rem 0">目前尚無消息，請稍後再來。</p>
        @endforelse
      </div>

      {{-- Pagination --}}
      @if($news->hasPages())
        <div style="margin-top:2rem; display:flex; justify-content:center;">
          {{ $news->links() }}
        </div>
      @endif

    </div>
  </section>

@endsection

@push('scripts')
<script>
  const btns  = document.querySelectorAll('.filter-btn');
  const cards = document.querySelectorAll('.news-card[data-category]');

  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      btns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      cards.forEach(card => {
        if (filter === 'all' || card.dataset.category === filter) {
          card.removeAttribute('hidden');
        } else {
          card.setAttribute('hidden', '');
        }
      });
    });
  });
</script>
@endpush
