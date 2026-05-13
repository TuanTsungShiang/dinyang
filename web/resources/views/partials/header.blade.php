<!-- Laravel CMS: Header / Navigation / LINE CTA -->
<header class="header" data-nav-open="false">
  <div class="header-inner">
    <a href="/" class="brand" aria-label="定陽企業有限公司首頁">
      <img class="logo-full" src="/img/logo_long_rb.png" alt="定陽企業有限公司" />
      <img class="logo-sm" src="/img/logo_sm.png" alt="定陽企業有限公司" />
    </a>

    {{-- 手機專用搜尋框（桌機隱藏） --}}
    <form action="{{ route('search') }}" method="get" class="search-form-mobile" id="search-form-mobile">
      <input type="text" name="q" placeholder="搜尋…"
        value="{{ request('q') }}" autocomplete="off" aria-label="搜尋" />
      <button type="submit" aria-label="送出搜尋">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
          viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
          <circle cx="11" cy="11" r="7" />
          <path d="M21 21l-4.35-4.35" />
        </svg>
      </button>
    </form>

    <button
      type="button"
      class="nav-toggle"
      aria-label="開啟主選單"
      aria-expanded="false"
      aria-controls="primary-nav">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav id="primary-nav" class="nav" aria-label="主選單">
      <a href="/#about">關於我們</a>
      <a href="/products" class="{{ request()->is('products*') ? 'nav-active' : '' }}">產品服務</a>
      <a href="/#applications">應用領域</a>
      <a href="/news" class="{{ request()->is('news*') ? 'nav-active' : '' }}">最新消息</a>
      <a href="/#contact">聯絡我們</a>
      <a href="/careers" class="{{ request()->is('careers*') ? 'nav-active' : '' }}">人才招募</a>

      {{-- 桌機搜尋 icon（手機隱藏） --}}
      <div class="header-search" id="header-search">
        <button class="search-icon-btn" id="search-toggle" aria-label="開啟搜尋">
          <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <circle cx="11" cy="11" r="7" />
            <path d="M21 21l-4.35-4.35" />
          </svg>
        </button>
        <form action="{{ route('search') }}" method="get" class="search-form" id="search-form">
          <input type="text" name="q" class="search-input" placeholder="搜尋產品 / 消息…"
            value="{{ request('q') }}" autocomplete="off" aria-label="搜尋" id="search-input" />
          <button type="submit" class="search-btn" aria-label="送出搜尋">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
              viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
              <circle cx="11" cy="11" r="7" />
              <path d="M21 21l-4.35-4.35" />
            </svg>
          </button>
        </form>
      </div>

      <a
        class="btn btn-line"
        href="https://line.me/R/ti/p/@@503xumnz"
        target="_blank"
        rel="noopener">
        <img src="/img/icon/line_bubble.png" alt="" />
        LINE 技術洽詢
      </a>
    </nav>
  </div>
</header>