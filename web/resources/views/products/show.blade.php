@extends('layouts.app')

@section('title', '機器人高柔性線組｜產品服務｜定陽企業有限公司')

@section('description', '定陽企業機器人高柔性線組，可撓曲壽命 ≥ 500 萬次，支援機器人手臂、協作機器人、Delta 機器人等應用，歡迎洽詢客製規格。')

@section('content')

  {{-- Breadcrumb Bar --}}
  <div class="breadcrumb-bar">
    <div class="container">
      <nav class="breadcrumb" aria-label="麵包屑">
        <a href="/">首頁</a>
        <span class="sep">/</span>
        <a href="{{ route('products.index') }}">產品服務</a>
        <span class="sep">/</span>
        <span class="current">機器人高柔性線組</span>
      </nav>
    </div>
  </div>

  {{-- Product Detail --}}
  <section class="product-detail-section">
    <div class="container">
      <div class="product-detail-grid">

        {{-- Left: Gallery --}}
        <div class="product-gallery">
          <div class="product-main-img">🤖</div>
          <div class="product-thumb-row">
            <div class="product-thumb-item">🤖</div>
            <div class="product-thumb-item">🔌</div>
            <div class="product-thumb-item">📐</div>
            <div class="product-thumb-item">📋</div>
          </div>
        </div>

        {{-- Right: Info --}}
        <div class="product-info">
          <span class="product-category-tag">客製線組</span>
          <h1>機器人高柔性線組</h1>
          <p class="lead">
            針對機器人手臂、Delta 機器人與協作機器人的高頻反覆彎折需求設計，採用高柔性銅絞線與 PUR 護套，可撓曲壽命 ≥ 500 萬次，同時支援電力、訊號與工業乙太網路整合佈線。
          </p>

          <div class="product-badges">
            <div class="product-badge">
              <span class="badge-label">撓曲壽命</span>
              ≥ 500 萬次
            </div>
            <div class="product-badge">
              <span class="badge-label">導體</span>
              鍍錫細銅絞線
            </div>
            <div class="product-badge">
              <span class="badge-label">護套</span>
              PUR / TPE
            </div>
            <div class="product-badge">
              <span class="badge-label">認證</span>
              CE・UL
            </div>
          </div>

          <hr class="product-divider" />

          <div class="product-meta-row">
            <div class="product-meta-item">
              <span class="meta-label">產品編號</span>
              <span class="meta-value">DY-RF-2400</span>
            </div>
            <div class="product-meta-item">
              <span class="meta-label">最小訂量</span>
              <span class="meta-value">50 pcs</span>
            </div>
            <div class="product-meta-item">
              <span class="meta-label">交期</span>
              <span class="meta-value">樣品 5～7 工作天</span>
            </div>
            <div class="product-meta-item">
              <span class="meta-label">客製</span>
              <span class="meta-value">接受客製規格</span>
            </div>
          </div>

          <hr class="product-divider" />

          <div class="product-actions">
            <a class="btn btn-blue" href="/#contact">填寫詢價單</a>
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

      </div>{{-- /product-detail-grid --}}
    </div>
  </section>

  {{-- Product Features --}}
  <section style="background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);">
    <div class="container">
      <div class="section-title">
        <h2>產品特色</h2>
        <p>針對工業機器人應用場景工程化設計，滿足嚴苛的動態配線需求。</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="f-icon">💪</div>
          <h3>超高撓曲壽命</h3>
          <p>採用鍍錫細銅絞線，在彎曲半徑 5D 條件下可撓曲 500 萬次以上，大幅降低斷線風險。</p>
        </div>
        <div class="feature-card">
          <div class="f-icon">🛡️</div>
          <h3>耐油耐磨護套</h3>
          <p>PUR / TPE 護套具優異耐油、耐磨與耐低溫性能，適合暴露於切削油與工業清潔劑的環境。</p>
        </div>
        <div class="feature-card">
          <div class="f-icon">📡</div>
          <h3>整合多訊號</h3>
          <p>可整合電力、EtherCAT、Profibus、類比訊號與編碼器回授於單一線束，減少佈線複雜度。</p>
        </div>
        <div class="feature-card">
          <div class="f-icon">🎨</div>
          <h3>色碼識別管理</h3>
          <p>依客戶需求提供多色導線識別、線號標籤與端子標記，方便現場安裝與後續維護。</p>
        </div>
        <div class="feature-card">
          <div class="f-icon">✅</div>
          <h3>嚴格品質管控</h3>
          <p>每批出貨附導通測試報告、絕緣耐壓測試記錄，確保品質一致性。</p>
        </div>
        <div class="feature-card">
          <div class="f-icon">⚡</div>
          <h3>快速打樣交期</h3>
          <p>標準規格樣品 5～7 工作天交付，量產訂單依數量彈性安排，支援緊急備料需求。</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Specs Table --}}
  <section>
    <div class="container">
      <div class="section-title">
        <h2>產品規格</h2>
        <p>以下為標準規格，如需客製化請於詢價時說明需求。</p>
      </div>
      <table class="specs-table">
        <thead>
          <tr>
            <th>規格項目</th>
            <th>規格值 / 說明</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>導體材質</td>
            <td>鍍錫細銅絞線（符合 IEC 60228 Class 6）</td>
          </tr>
          <tr>
            <td>導體截面積</td>
            <td>0.14 mm²、0.25 mm²、0.5 mm²、0.75 mm²、1.0 mm²（可依需求調整）</td>
          </tr>
          <tr>
            <td>絕緣材質</td>
            <td>XLPE / PVC（內絕緣），顏色可客製</td>
          </tr>
          <tr>
            <td>護套材質</td>
            <td>PUR（標準）/ TPE（選配）</td>
          </tr>
          <tr>
            <td>護套顏色</td>
            <td>黑色（標準），可依需求選配其他顏色</td>
          </tr>
          <tr>
            <td>芯數 / 結構</td>
            <td>2C ～ 30C，可整合遮蔽層（鋁箔 + 編織）</td>
          </tr>
          <tr>
            <td>最小彎曲半徑</td>
            <td>動態佈線：5× 外徑；靜態佈線：3× 外徑</td>
          </tr>
          <tr>
            <td>可撓曲壽命</td>
            <td>≥ 500 萬次（彎曲半徑 5D，速度 1 m/s）</td>
          </tr>
          <tr>
            <td>耐溫範圍</td>
            <td>-40°C ～ +105°C</td>
          </tr>
          <tr>
            <td>額定電壓</td>
            <td>300V / 500V（依規格）</td>
          </tr>
          <tr>
            <td>認證</td>
            <td>CE、UL Listed（材料），依需求提供 RoHS 符合聲明</td>
          </tr>
          <tr>
            <td>連接器選配</td>
            <td>M8、M12、D-Sub、JST、客戶指定連接器</td>
          </tr>
          <tr>
            <td>最小訂量</td>
            <td>樣品 1 pcs；量產 50 pcs 起</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  {{-- Application Scenarios --}}
  <section style="background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);">
    <div class="container">
      <div class="section-title">
        <h2>應用場景</h2>
        <p>廣泛應用於各類工業機器人與自動化設備動態配線需求。</p>
      </div>
      <div class="scenario-grid">
        <div class="scenario-card">
          <div class="scenario-img">🦾</div>
          <div class="scenario-body">
            <h3>工業機器手臂</h3>
            <p>六軸機器人本體配線與外掛工具線束整合。</p>
          </div>
        </div>
        <div class="scenario-card">
          <div class="scenario-img">⬡</div>
          <div class="scenario-body">
            <h3>Delta 並聯機器人</h3>
            <p>高速並聯機器人動態線束，兼顧輕量與耐久。</p>
          </div>
        </div>
        <div class="scenario-card">
          <div class="scenario-img">🤝</div>
          <div class="scenario-body">
            <h3>協作機器人 (Cobot)</h3>
            <p>輕量化設計，適用與人協作的低速高頻場景。</p>
          </div>
        </div>
        <div class="scenario-card">
          <div class="scenario-img">🔄</div>
          <div class="scenario-body">
            <h3>拖鏈式自動化設備</h3>
            <p>配合拖鏈（Cable Chain）動態配線應用設計。</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Inquiry Bar --}}
  <div class="inquiry-bar">
    <div class="container">
      <h2>需要客製化規格或批量報價？</h2>
      <p>提供應用環境、線長、芯數與連接器需求，我們將在 1 個工作日內回覆。</p>
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

  {{-- Related Products --}}
  <section>
    <div class="container">
      <div class="section-title">
        <h2>相關產品</h2>
        <p>您可能也感興趣的其他線材與連接器方案。</p>
      </div>
      <div class="related-grid">
        <article class="related-card">
          <div class="related-thumb t-wire">🔌</div>
          <div class="related-body">
            <div class="related-cat">線材加工</div>
            <h3>工業自動化線束</h3>
            <p>PVC / PUR 護套，耐油耐磨，適用 CNC 與輸送設備控制配線。</p>
            <a class="related-link" href="{{ route('products.show', 'automation-harness') }}">查看詳情 →</a>
          </div>
        </article>
        <article class="related-card">
          <div class="related-thumb t-connector">▣</div>
          <div class="related-body">
            <div class="related-cat">連接器組裝</div>
            <h3>M12 工業連接器線組</h3>
            <p>IP67/IP68，A/B/D/X Code，適用工廠自動化感測器配線。</p>
            <a class="related-link" href="{{ route('products.show', 'm12-connector') }}">查看詳情 →</a>
          </div>
        </article>
        <article class="related-card">
          <div class="related-thumb t-auto">⚙</div>
          <div class="related-body">
            <div class="related-cat">自動化設備用線</div>
            <h3>PLC 控制系統配線</h3>
            <p>依圖施工，附線號對照表，縮短現場安裝時間。</p>
            <a class="related-link" href="{{ route('products.show', 'plc-wiring') }}">查看詳情 →</a>
          </div>
        </article>
      </div>
    </div>
  </section>

@endsection
