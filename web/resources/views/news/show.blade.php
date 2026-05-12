@extends('layouts.app')

@section('title', ($item->meta_title ?: $item->title . '｜最新消息｜定陽企業有限公司'))
@section('description', ($item->meta_description ?: $item->excerpt))

@section('content')

  {{-- Breadcrumb --}}
  <div class="breadcrumb-bar">
    <div class="container">
      <nav class="breadcrumb" aria-label="麵包屑">
        <a href="/">首頁</a>
        <span class="sep">/</span>
        <a href="{{ route('news.index') }}">最新消息</a>
        <span class="sep">/</span>
        <span class="current">{{ $item->title }}</span>
      </nav>
    </div>
  </div>

  {{-- Article --}}
  <section>
    <div class="container">
      <div class="news-article-wrap">

        {{-- Header --}}
        <header class="news-article-header">
          @if($item->category)
            <span class="news-article-cat">{{ $item->category->name }}</span>
          @endif
          <h1>{{ $item->title }}</h1>
          <div class="news-article-meta">
            @if($item->author)
              <span>✍️ {{ $item->author }}</span>
            @endif
            @if($item->published_at)
              <time>{{ $item->published_at->format('Y 年 m 月 d 日') }}</time>
            @endif
          </div>
          @if($item->cover_image)
            <div class="news-article-cover">
              <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" />
            </div>
          @endif
        </header>

        {{-- Excerpt --}}
        <p class="news-article-excerpt">{{ $item->excerpt }}</p>

        {{-- Content (RichEditor HTML) --}}
        <div class="news-article-content">
          {!! $item->content !!}
        </div>

        {{-- Tags --}}
        @if(!empty($item->tags))
          <div class="news-article-tags">
            @foreach($item->tags as $tag)
              <span class="news-tag">{{ $tag }}</span>
            @endforeach
          </div>
        @endif

        {{-- Back --}}
        <div style="margin-top:2.5rem;">
          <a href="{{ route('news.index') }}" class="news-back-link">← 返回最新消息</a>
        </div>

      </div>
    </div>
  </section>

  {{-- Related News --}}
  @if($related->isNotEmpty())
    <section style="background:linear-gradient(180deg,#ffffff 0%,#f7fbff 100%);">
      <div class="container">
        <div class="section-title">
          <h2>相關消息</h2>
        </div>
        <div class="news-grid">
          @foreach($related as $r)
            <article class="card news-card">
              <div class="news-image">
                @if($r->cover_image)
                  <img src="{{ asset('storage/' . $r->cover_image) }}" alt="{{ $r->title }}"
                       style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;" />
                @endif
                <span class="tag">{{ $r->category?->name }}</span>
              </div>
              <div class="news-body">
                <h3>{{ $r->title }}</h3>
                <time>{{ $r->published_at?->format('Y / m / d') }}</time>
                <p>{{ $r->excerpt }}</p>
                <a href="{{ route('news.show', $r->slug) }}">閱讀更多 →</a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- Inquiry Bar --}}
  <div class="inquiry-bar">
    <div class="container">
      <h2>找不到符合需求的線材規格？</h2>
      <p>提供您的應用環境、線材長度、接頭型號或設備需求，我們將協助評估可行方案。</p>
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
