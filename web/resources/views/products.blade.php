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
  <section>
    <div class="container">

      <div class="filter-wrap" role="group" aria-label="產品分類篩選">
        <button class="filter-btn active" data-filter="all">全部</button>
        <button class="filter-btn" data-filter="線材加工">線材加工</button>
        <button class="filter-btn" data-filter="連接器組裝">連接器組裝</button>
        <button class="filter-btn" data-filter="客製線組">客製線組</button>
        <button class="filter-btn" data-filter="自動化設備用線">自動化設備用線</button>
        <button class="filter-btn" data-filter="醫療設備配線">醫療設備配線</button>
        <button class="filter-btn" data-filter="OEM / ODM">OEM / ODM</button>
      </div>

      <div class="product-list-grid" id="product-grid">

        {{-- 線材加工 --}}
        <article class="product-list-card" data-category="線材加工">
          <div class="product-thumb cat-wire">
            <span class="product-cat-badge">線材加工</span>
            <span class="product-thumb-icon">🔌</span>
          </div>
          <div class="product-card-body">
            <h3>電源線材加工</h3>
            <p>多規格電源線材裁切、剝線、壓接與成型，支援 UL/CE 認證材料，適用工業、家電與設備電源配線。</p>
            <a class="product-card-link" href="{{ route('products.show', 'power-cable') }}">了解更多 →</a>
          </div>
        </article>

        <article class="product-list-card" data-category="線材加工">
          <div class="product-thumb cat-wire">
            <span class="product-cat-badge">線材加工</span>
            <span class="product-thumb-icon">📡</span>
          </div>
          <div class="product-card-body">
            <h3>通訊訊號線材</h3>
            <p>高屏蔽性訊號線材加工，支援差動訊號、乙太網路與序列通訊應用，兼顧傳輸穩定與 EMI 防護。</p>
            <a class="product-card-link" href="{{ route('products.show', 'signal-cable') }}">了解更多 →</a>
          </div>
        </article>

        {{-- 連接器組裝 --}}
        <article class="product-list-card" data-category="連接器組裝">
          <div class="product-thumb cat-connector">
            <span class="product-cat-badge">連接器組裝</span>
            <span class="product-thumb-icon">▣</span>
          </div>
          <div class="product-card-body">
            <h3>JST 連接器線組</h3>
            <p>JST PH / XH / ZH / GH 等系列連接器壓接組裝，Pin 數 2P～30P，適用消費性電子與小型設備。</p>
            <a class="product-card-link" href="{{ route('products.show', 'jst-connector') }}">了解更多 →</a>
          </div>
        </article>

        <article class="product-list-card" data-category="連接器組裝">
          <div class="product-thumb cat-connector">
            <span class="product-cat-badge">連接器組裝</span>
            <span class="product-thumb-icon">⚡</span>
          </div>
          <div class="product-card-body">
            <h3>M12 工業連接器線組</h3>
            <p>M12 A/B/D/X Code 工業級連接器組裝，IP67/IP68 防護等級，適用工廠自動化感測器與現場設備配線。</p>
            <a class="product-card-link" href="{{ route('products.show', 'm12-connector') }}">了解更多 →</a>
          </div>
        </article>

        {{-- 客製線組 --}}
        <article class="product-list-card" data-category="客製線組">
          <div class="product-thumb cat-custom">
            <span class="product-cat-badge">客製線組</span>
            <span class="product-thumb-icon">🤖</span>
          </div>
          <div class="product-card-body">
            <h3>機器人高柔性線組</h3>
            <p>針對機器人手臂反覆彎折需求設計，可撓曲壽命 ≥ 500 萬次，支援 EtherCAT / Profibus 等工業協議。</p>
            <a class="product-card-link" href="{{ route('products.show', 'robot-flex-harness') }}">了解更多 →</a>
          </div>
        </article>

        <article class="product-list-card" data-category="客製線組">
          <div class="product-thumb cat-custom">
            <span class="product-cat-badge">客製線組</span>
            <span class="product-thumb-icon">〽</span>
          </div>
          <div class="product-card-body">
            <h3>精密儀器客製線組</h3>
            <p>依據客戶 BOM 與接線圖製作，線徑 AWG 28～AWG 10，支援多色識別、熱縮套管與線號標籤。</p>
            <a class="product-card-link" href="{{ route('products.show', 'precision-harness') }}">了解更多 →</a>
          </div>
        </article>

        {{-- 自動化設備用線 --}}
        <article class="product-list-card" data-category="自動化設備用線">
          <div class="product-thumb cat-auto">
            <span class="product-cat-badge">自動化設備用線</span>
            <span class="product-thumb-icon">🏭</span>
          </div>
          <div class="product-card-body">
            <h3>工業自動化線束</h3>
            <p>PVC / PUR 護套，耐油耐磨耐彎折，適用 CNC、輸送帶、機台控制箱等自動化設備控制配線。</p>
            <a class="product-card-link" href="{{ route('products.show', 'automation-harness') }}">了解更多 →</a>
          </div>
        </article>

        <article class="product-list-card" data-category="自動化設備用線">
          <div class="product-thumb cat-auto">
            <span class="product-cat-badge">自動化設備用線</span>
            <span class="product-thumb-icon">⚙</span>
          </div>
          <div class="product-card-body">
            <h3>PLC 控制系統配線</h3>
            <p>PLC I/O 模組、控制盤、伺服驅動器配線，依圖施工並附線號對照表，縮短現場安裝時間。</p>
            <a class="product-card-link" href="{{ route('products.show', 'plc-wiring') }}">了解更多 →</a>
          </div>
        </article>

        {{-- 醫療設備配線 --}}
        <article class="product-list-card" data-category="醫療設備配線">
          <div class="product-thumb cat-medical">
            <span class="product-cat-badge">醫療設備配線</span>
            <span class="product-thumb-icon">✚</span>
          </div>
          <div class="product-card-body">
            <h3>醫療設備傳輸線</h3>
            <p>採用符合 IEC 60601 標準之醫療級絕緣材料，低漏電流設計，適用患者監護設備、超音波機台等。</p>
            <a class="product-card-link" href="{{ route('products.show', 'medical-cable') }}">了解更多 →</a>
          </div>
        </article>

        <article class="product-list-card" data-category="醫療設備配線">
          <div class="product-thumb cat-medical">
            <span class="product-cat-badge">醫療設備配線</span>
            <span class="product-thumb-icon">▤</span>
          </div>
          <div class="product-card-body">
            <h3>手術室設備配線</h3>
            <p>高潔淨度、可重複消毒材質，抗菌外被設計，通過 ISO 13485 品質管理認證要求，嚴格品管出貨。</p>
            <a class="product-card-link" href="{{ route('products.show', 'or-equipment-wiring') }}">了解更多 →</a>
          </div>
        </article>

        {{-- OEM / ODM --}}
        <article class="product-list-card" data-category="OEM / ODM">
          <div class="product-thumb cat-oem">
            <span class="product-cat-badge">OEM / ODM</span>
            <span class="product-thumb-icon">📦</span>
          </div>
          <div class="product-card-body">
            <h3>OEM 批量線材代工</h3>
            <p>接受 OEM 訂單，按客戶規格與品牌要求製造，提供打樣→小批→量產全流程服務，交期彈性。</p>
            <a class="product-card-link" href="{{ route('products.show', 'oem') }}">了解更多 →</a>
          </div>
        </article>

        <article class="product-list-card" data-category="OEM / ODM">
          <div class="product-thumb cat-oem">
            <span class="product-cat-badge">OEM / ODM</span>
            <span class="product-thumb-icon">📐</span>
          </div>
          <div class="product-card-body">
            <h3>ODM 整線設計服務</h3>
            <p>從需求分析、線路設計、材料選配到樣品驗證，提供完整 ODM 開發支援，協助縮短產品上市時程。</p>
            <a class="product-card-link" href="{{ route('products.show', 'odm') }}">了解更多 →</a>
          </div>
        </article>

      </div>{{-- /product-list-grid --}}
    </div>
  </section>

  {{-- CTA Strip --}}
  <div class="cta-strip">
    <div class="container">
      <h2>找不到符合需求的規格？</h2>
      <p>告訴我們您的應用環境與需求，我們提供客製化方案與快速報價。</p>
      <div class="btn-group">
        <a class="btn btn-outline" href="/#contact">填寫詢價表單</a>
        <a
          class="btn btn-line"
          href="https://line.me/R/ti/p/@@503xumnz"
          target="_blank"
          rel="noopener"
        >
          <img src="/img/icon/line_bubble.png" alt="" />
          LINE 即時詢價
        </a>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  const btns = document.querySelectorAll('.filter-btn');
  const cards = document.querySelectorAll('.product-list-card');

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
