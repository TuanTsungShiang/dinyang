@extends('layouts.app')

@section('title', '人才招募｜定陽企業有限公司')
@section('description', '加入定陽企業，與我們一同深耕線材加工與連接器整合領域，共創產業價值。')

@section('content')

  {{-- Page Banner --}}
  <section class="page-banner">
    <div class="container">
      <nav class="breadcrumb" aria-label="麵包屑">
        <a href="/">首頁</a>
        <span>/</span>
        <span>人才招募</span>
      </nav>
      <h1>人才招募</h1>
      <p>加入定陽，與專業團隊共同成長，打造高品質線材與連接器解決方案</p>
    </div>
  </section>

  {{-- 為什麼加入我們 --}}
  <section>
    <div class="container">
      <div class="section-title">
        <h2>為什麼選擇定陽？</h2>
        <p>我們重視每位夥伴的成長，提供穩定、專業、有溫度的工作環境。</p>
      </div>
      <div class="feature-grid">
        <article class="card">
          <div class="icon">🏭</div>
          <h3>產業深度</h3>
          <p>深耕線材加工領域多年，讓你累積真正有價值的專業技術。</p>
        </article>
        <article class="card">
          <div class="icon">📈</div>
          <h3>穩定成長</h3>
          <p>持續開拓國內外客戶，業務成長穩健，職涯發展空間廣闊。</p>
        </article>
        <article class="card">
          <div class="icon">🤝</div>
          <h3>團隊文化</h3>
          <p>扁平化管理，重視溝通協作，讓每位夥伴的意見都被聽見。</p>
        </article>
      </div>
    </div>
  </section>

  {{-- 職缺列表 --}}
  <section style="background:linear-gradient(180deg,#ffffff 0%,#f7fbff 100%);">
    <div class="container">
      <div class="section-title">
        <h2>開放職缺</h2>
        <p>歡迎有志之士加入我們的團隊</p>
      </div>

      @forelse($jobs as $job)
        <article class="job-card">
          <div class="job-header">
            <div>
              <h3 class="job-title">{{ $job->title }}</h3>
              <div class="job-meta">
                @if($job->department)
                  <span>📂 {{ $job->department }}</span>
                @endif
                <span>📍 {{ $job->location }}</span>
                <span class="job-type-badge job-type-{{ $job->type }}">
                  {{ $job->getTypeLabel() }}
                </span>
              </div>
            </div>
            <a href="/#contact" class="btn btn-blue job-apply-btn">立即應徵</a>
          </div>

          @if($job->description)
            <div class="job-section">
              <h4>工作內容</h4>
              <div class="job-text">{!! nl2br(e($job->description)) !!}</div>
            </div>
          @endif

          @if($job->requirements)
            <div class="job-section">
              <h4>應徵條件</h4>
              <div class="job-text">{!! nl2br(e($job->requirements)) !!}</div>
            </div>
          @endif
        </article>
      @empty
        <div class="careers-empty">
          <p>目前暫無開放職缺，歡迎將履歷寄至 <a href="mailto:service@dinyang.com.tw">service@dinyang.com.tw</a>，我們會在有職缺時主動聯繫。</p>
        </div>
      @endforelse
    </div>
  </section>

  {{-- CTA --}}
  <div class="inquiry-bar">
    <div class="container">
      <h2>沒有符合的職缺？</h2>
      <p>歡迎主動投遞履歷，我們保留儲備人才資料，有機會將優先聯繫。</p>
      <div class="btn-group">
        <a class="btn btn-outline" href="/#contact">聯絡我們</a>
        <a class="btn btn-line" href="https://line.me/R/ti/p/@503xumnz"
           target="_blank" rel="noopener">
          <img src="/img/icon/line_bubble.png" alt="" />
          LINE 即時詢問
        </a>
      </div>
    </div>
  </div>

@endsection
