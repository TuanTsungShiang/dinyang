@extends('layouts.app')

@section('title', '搜尋「' . $q . '」｜定陽企業有限公司')

@section('content')

  <section class="page-banner">
    <div class="container">
      <h1>搜尋結果</h1>
      <p>「{{ $q }}」共找到 {{ $products->count() + $news->count() }} 筆結果</p>
      <form action="{{ route('search') }}" method="get" class="search-bar-inline" style="margin-top:18px;">
        <input type="text" name="q" value="{{ $q }}" placeholder="再次搜尋…" autocomplete="off" />
        <button type="submit">搜尋</button>
      </form>
    </div>
  </section>

  <section>
    <div class="container">

      {{-- 產品結果 --}}
      <div class="search-section-title">
        <h2>產品服務 <span class="search-count">{{ $products->count() }} 筆</span></h2>
      </div>
      @if($products->isNotEmpty())
        <div class="product-list-grid" style="margin-bottom:3rem;">
          @foreach($products as $product)
            <article class="product-list-card">
              <div class="product-thumb"
                   style="{{ $product->thumbnail ? '' : 'background-color:' . ($product->category?->color_band ?? '#0b4ea2') }}">
                @if($product->thumbnail)
                  <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" />
                @else
                  <span class="product-thumb-icon">{{ $product->icon }}</span>
                @endif
                <span class="product-cat-badge">{{ $product->category?->name }}</span>
              </div>
              <div class="product-card-body">
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->short_description }}</p>
                <a class="product-card-link" href="{{ route('products.show', $product->slug) }}">了解更多 →</a>
              </div>
            </article>
          @endforeach
        </div>
      @else
        <p class="search-empty">沒有符合的產品。</p>
      @endif

      {{-- 消息結果 --}}
      <div class="search-section-title">
        <h2>最新消息 <span class="search-count">{{ $news->count() }} 筆</span></h2>
      </div>
      @if($news->isNotEmpty())
        <div class="news-grid" style="margin-bottom:2rem;">
          @foreach($news as $item)
            <article class="card news-card">
              <div class="news-image">
                @if($item->cover_image)
                  <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}"
                       style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
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
          @endforeach
        </div>
      @else
        <p class="search-empty">沒有符合的消息。</p>
      @endif

    </div>
  </section>

@endsection
