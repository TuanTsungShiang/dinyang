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

  {{-- 求職平台 --}}
  <section style="background:linear-gradient(180deg,#ffffff 0%,#f7fbff 100%);">
    <div class="container">
      <div class="section-title">
        <h2>目前開放職缺</h2>
        <p>點擊下方平台查看最新職缺並投遞履歷</p>
      </div>
      <div class="job-platform-grid">
        <a href="https://www.104.com.tw/company/arpyjfk#intro"
           target="_blank" rel="noopener" class="job-platform-card">
          <img src="/img/104.png" alt="104 人力銀行" />
          <span>104 人力銀行</span>
        </a>
        <a href="https://www.yes123.com.tw/wk_index/comp_info.asp?p_id=20120319092331_23444012"
           target="_blank" rel="noopener" class="job-platform-card">
          <img src="/img/123.png" alt="yes123 求職網" />
          <span>yes123 求職網</span>
        </a>
      </div>
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
