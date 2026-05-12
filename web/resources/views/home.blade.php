@extends('layouts.app')

@section('content')
  <!-- Hero 輪播 -->
  @php $slides = $heroSlides->isNotEmpty() ? $heroSlides : collect([null]); @endphp
  <div class="hero-slider" id="hero-slider">
    <div class="hero-slider-track" id="hero-track">
    @foreach($slides as $i => $slide)
      <section class="hero hero-slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
        <div class="hero-content">
          <div class="eyebrow">{{ $slide?->eyebrow ?? 'B2B 線材加工｜連接器整合｜OEM / ODM' }}</div>
          <h1>{!! nl2br(e($slide?->title ?? '專業線材加工與連接器整合服務')) !!}</h1>
          <p>{{ $slide?->subtitle ?? '深耕產業多年，提供客製化線材、連接器、OEM / ODM 與技術支援' }}</p>
          <div class="hero-actions">
            <a class="btn btn-outline" href="{{ $slide?->cta_primary_url ?? '/#contact' }}">
              {{ $slide?->cta_primary_label ?? '了解更多 →' }}
            </a>
            <a class="btn btn-line"
               href="{{ $slide?->cta_secondary_url ?? 'https://line.me/R/ti/p/@503xumnz' }}"
               target="_blank" rel="noopener">
              <img src="{{ $slide?->cta_secondary_icon ?? '/img/icon/line_bubble.png' }}" alt="" />
              {{ $slide?->cta_secondary_label ?? '加入 LINE' }}
            </a>
          </div>
        </div>
        <div class="hero-media">
          <img src="{{ $slide?->image_path ? asset('storage/' . $slide->image_path) : '/img/Server_rack_blue_cables.png' }}"
               alt="{{ $slide?->title ?? '定陽企業' }}" />
        </div>
      </section>
    @endforeach

    </div>{{-- /hero-slider-track --}}

    @if($slides->count() > 1)
      {{-- Prev / Next --}}
      <button class="hero-arrow hero-prev" id="hero-prev" aria-label="上一張">&#8249;</button>
      <button class="hero-arrow hero-next" id="hero-next" aria-label="下一張">&#8250;</button>

      {{-- Dots --}}
      <div class="hero-dots" id="hero-dots">
        @foreach($slides as $i => $slide)
          <button class="hero-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}" aria-label="第 {{ $i+1 }} 張"></button>
        @endforeach
      </div>
    @endif
  </div>

  <!-- 公司介紹 -->
  <section id="about">
    <div class="container intro-grid">
      <div class="intro-copy">
        <h2>關於定陽</h2>
        <p>
          定陽企業有限公司深耕線材加工與連接器整合領域，累積豐富的製造經驗與技術能量。我們以品質為核心，結合客製化服務與快速交期能力，協助客戶提升產品競爭力，成為您值得信賴的長期合作夥伴。
        </p>
      </div>
      <div class="feature-grid">
        <article class="card">
          <div class="icon"><img src="/img/icon/icon_experience.svg" alt="" /></div>
          <h3>多年產業經驗</h3>
          <p>深耕線材與連接器產業多年，熟悉各產業需求。</p>
        </article>
        <article class="card">
          <div class="icon"><img src="/img/icon/icon_custom_processing.svg" alt="" /></div>
          <h3>客製化加工</h3>
          <p>依客戶需求提供客製化線材與連接器解決方案。</p>
        </article>
        <article class="card">
          <div class="icon"><img src="/img/icon/icon_fast_delivery.svg" alt="" /></div>
          <h3>快速交期支援</h3>
          <p>完善生產流程與庫存管理，快速回應客戶交期需求。</p>
        </article>
      </div>
    </div>
  </section>

  <!-- 產品分類（DB） -->
  <section id="products">
    <div class="container">
      <div class="section-title">
        <h2>產品服務</h2>
        <p>提供從線材加工、連接器組裝到客製線組量產的一站式支援。</p>
      </div>
      <div class="cat-grid">
        @foreach($productCategories as $cat)
          <a class="cat-card" href="{{ route('products.index') }}">
            <div class="cat-img" style="border-color: {{ $cat->color_band }}44">
              @if($cat->image)
                <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" />
              @else
                <div class="cat-img-placeholder" style="background:{{ $cat->color_band }}22; color:{{ $cat->color_band }}">
                  {{ mb_substr($cat->name, 0, 1) }}
                </div>
              @endif
            </div>
            <div class="cat-body">
              <h3>{{ $cat->name }}</h3>
              <p>{{ $cat->description }}</p>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- 服務流程 -->
  <section>
    <div class="container">
      <div class="section-title">
        <h2>服務流程</h2>
        <p>從需求確認到量產交付，建立清楚、可追蹤的合作流程。</p>
      </div>
      <div class="process">
        <article class="step">
          <div class="step-icon">💬</div>
          <small>01</small><strong>需求確認</strong>
          <p>與客戶充分溝通，了解產品需求與應用環境。</p>
        </article>
        <article class="step">
          <div class="step-icon">📋</div>
          <small>02</small><strong>規格評估</strong>
          <p>提供專業建議與規格評估，確認最佳解決方案。</p>
        </article>
        <article class="step">
          <div class="step-icon">⏳</div>
          <small>03</small><strong>樣品打樣</strong>
          <p>製作樣品並進行測試，確認品質與規格。</p>
        </article>
        <article class="step">
          <div class="step-icon">📦</div>
          <small>04</small><strong>量產交付</strong>
          <p>批量生產與品質管控，準時交付客戶。</p>
        </article>
      </div>
    </div>
  </section>

  <!-- 應用領域（DB） -->
  <section id="applications">
    <div class="container">
      <div class="section-title">
        <h2>應用領域</h2>
        <p>支援多種產業設備線材與連接器需求。</p>
      </div>
      <div class="application-grid">
        @foreach($applicationAreas as $area)
          <article class="card app-card">
            <div class="app-image {{ $area->cover_image ? 'has-image' : '' }}">
              @if($area->cover_image)
                <img src="{{ asset('storage/' . $area->cover_image) }}"
                     alt="{{ $area->name }}"
                     style="width:100%;height:100%;object-fit:cover;display:block;" />
              @endif
            </div>
            <div class="app-body">
              <div class="icon">{{ $area->icon }}</div>
              <h3>{{ $area->name }}</h3>
              <p>{{ $area->description }}</p>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- 最新消息（DB） -->
  <section id="news">
    <div class="container">
      <div class="section-title">
        <h2>最新消息</h2>
        <p>發布公司動態、展會資訊與技術文章，提升網站活躍度與搜尋能見度。</p>
      </div>
      <div class="news-grid">
        @forelse($news as $item)
          <article class="card news-card">
            <div class="news-image">
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
          <p style="color:#666">目前尚無消息，請稍後再來。</p>
        @endforelse
      </div>
    </div>
  </section>

  @include('partials.contact')
@endsection
