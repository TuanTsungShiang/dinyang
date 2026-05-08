@extends('layouts.app')

@section('content')
  <!-- Laravel CMS: Banner 模組（hero-media 之後可改為輪播容器） -->
  <section class="hero" id="top">
    <div class="hero-content">
      <div class="eyebrow">B2B 線材加工｜連接器整合｜OEM / ODM</div>
      <h1>專業線材加工與<br />連接器整合服務</h1>
      <p>深耕產業多年，提供客製化線材、連接器、</br>OEM / ODM 與技術支援</p>
      <div class="hero-actions">
        <a class="btn btn-outline" href="#contact">立即詢價 →</a>
        <a
          class="btn btn-line"
          href="https://line.me/R/ti/p/@@503xumnz"
          target="_blank"
          rel="noopener"
        >
          <img src="/img/icon/line_bubble.png" alt="" />
          加入 LINE
        </a>
      </div>
    </div>
    <div class="hero-media">
      <img src="/img/Server_rack_blue_cables.png" alt="網路機櫃藍色乙太線" />
    </div>
  </section>

  <!-- Laravel CMS: 公司介紹模組 -->
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
          <div class="icon">
            <img src="/img/icon/icon_experience.svg" alt="" />
          </div>
          <h3>多年產業經驗</h3>
          <p>深耕線材與連接器產業多年，熟悉各產業需求。</p>
        </article>
        <article class="card">
          <div class="icon">
            <img src="/img/icon/icon_custom_processing.svg" alt="" />
          </div>
          <h3>客製化加工</h3>
          <p>依客戶需求提供客製化線材與連接器解決方案。</p>
        </article>
        <article class="card">
          <div class="icon">
            <img src="/img/icon/icon_fast_delivery.svg" alt="" />
          </div>
          <h3>快速交期支援</h3>
          <p>完善生產流程與庫存管理，快速回應客戶交期需求。</p>
        </article>
      </div>
    </div>
  </section>

  <!-- Laravel CMS: 產品分類模組 -->
  <section id="products">
    <div class="container">
      <div class="section-title">
        <h2>產品服務</h2>
        <p>提供從線材加工、連接器組裝到客製線組量產的一站式支援。</p>
      </div>
      <div class="product-grid">
        <article class="card product-card">
          <div class="icon">🔌</div>
          <div>
            <h3>線材加工</h3>
            <p>多樣線材裁切、剝線、壓接與成型加工服務。</p>
          </div>
        </article>
        <article class="card product-card">
          <div class="icon">▣</div>
          <div>
            <h3>連接器組裝</h3>
            <p>各式連接器組裝、壓接與測試的一站式服務。</p>
          </div>
        </article>
        <article class="card product-card">
          <div class="icon">〽</div>
          <div>
            <h3>客製線組</h3>
            <p>客製化線組設計與製造，滿足各式應用需求。</p>
          </div>
        </article>
        <article class="card product-card">
          <div class="icon">🤖</div>
          <div>
            <h3>自動化設備用線</h3>
            <p>高耐用、高柔性線材，適用自動化設備應用。</p>
          </div>
        </article>
        <article class="card product-card">
          <div class="icon">▤</div>
          <div>
            <h3>醫療設備配線</h3>
            <p>符合醫療等級標準，提供可靠的配線解決方案。</p>
          </div>
        </article>
        <article class="card product-card">
          <div class="icon">⚙</div>
          <div>
            <h3>OEM / ODM 服務</h3>
            <p>從設計開發到量產製造，提供完整 OEM / ODM 服務。</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Laravel CMS: 服務流程模組 -->
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

  <!-- Laravel CMS: 應用領域模組 -->
  <section id="applications">
    <div class="container">
      <div class="section-title">
        <h2>應用領域</h2>
        <p>支援多種產業設備線材與連接器需求。</p>
      </div>
      <div class="application-grid">
        <article class="card app-card">
          <div class="app-image"></div>
          <div class="app-body">
            <div class="icon">🏭</div>
            <h3>自動化設備</h3>
            <p>工業自動化控制系統與設備配線應用。</p>
          </div>
        </article>
        <article class="card app-card">
          <div class="app-image"></div>
          <div class="app-body">
            <div class="icon">◈</div>
            <h3>半導體設備</h3>
            <p>高精度、高可靠度配線，適用半導體製程設備。</p>
          </div>
        </article>
        <article class="card app-card">
          <div class="app-image"></div>
          <div class="app-body">
            <div class="icon">✚</div>
            <h3>醫療機械</h3>
            <p>符合醫療標準的配線，確保設備穩定與安全。</p>
          </div>
        </article>
        <article class="card app-card">
          <div class="app-image"></div>
          <div class="app-body">
            <div class="icon">⚙</div>
            <h3>機器人製造</h3>
            <p>機器人本體與周邊設備線材整合應用。</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- Laravel CMS: 最新消息模組 -->
  <section id="news">
    <div class="container">
      <div class="section-title">
        <h2>最新消息</h2>
        <p>
          發布公司動態、展會資訊與技術文章，提升網站活躍度與搜尋能見度。
        </p>
      </div>
      <div class="news-grid">
        <article class="card news-card">
          <div class="news-image"><span class="tag">公司消息</span></div>
          <div class="news-body">
            <h3>定陽企業新廠落成啟用</h3>
            <time>2024 / 05 / 15</time>
            <p>
              為提升產能與服務品質，我們的新廠正式落成，提供更完善的生產與檢驗設備。
            </p>
            <a href="#">閱讀更多 →</a>
          </div>
        </article>
        <article class="card news-card">
          <div class="news-image"><span class="tag">展會資訊</span></div>
          <div class="news-body">
            <h3>2024 台北國際自動化工業大展</h3>
            <time>2024 / 05 / 01</time>
            <p>定陽企業將參加台北國際自動化工業展，歡迎蒞臨參觀指教。</p>
            <a href="#">閱讀更多 →</a>
          </div>
        </article>
        <article class="card news-card">
          <div class="news-image"><span class="tag">技術文章</span></div>
          <div class="news-body">
            <h3>連接器選型指南與應用要點</h3>
            <time>2024 / 04 / 20</time>
            <p>深入了解連接器選型的關鍵因素，協助提升產品可靠度與效能。</p>
            <a href="#">閱讀更多 →</a>
          </div>
        </article>
      </div>
    </div>
  </section>

  @include('partials.contact')
@endsection
