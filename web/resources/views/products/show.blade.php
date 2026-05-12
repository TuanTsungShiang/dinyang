@extends('layouts.app')

@section('title', ($product->meta_title ?: $product->name . '｜產品服務｜定陽企業有限公司'))

@section('description', ($product->meta_description ?: $product->short_description))

@section('content')

  {{-- Breadcrumb Bar --}}
  <div class="breadcrumb-bar">
    <div class="container">
      <nav class="breadcrumb" aria-label="麵包屑">
        <a href="/">首頁</a>
        <span class="sep">/</span>
        <a href="{{ route('products.index') }}">產品服務</a>
        <span class="sep">/</span>
        <span class="current">{{ $product->name }}</span>
      </nav>
    </div>
  </div>

  {{-- Product Detail --}}
  <section class="product-detail-section">
    <div class="container">
      <div class="product-detail-grid">

        {{-- Left: Gallery --}}
        <div class="product-gallery">
          @if($product->thumbnail)
            <div class="product-main-img">
              <img src="{{ asset('storage/' . $product->thumbnail) }}"
                   alt="{{ $product->name }}" />
            </div>
          @else
            <div class="product-main-img">{{ $product->icon }}</div>
          @endif

          @if(!empty($product->gallery))
            <div class="product-thumb-row">
              @foreach($product->gallery as $img)
                <div class="product-thumb-item">
                  <img src="{{ asset('storage/' . $img) }}" alt="" />
                </div>
              @endforeach
            </div>
          @endif
        </div>

        {{-- Right: Info --}}
        <div class="product-info">
          @if($product->category)
            <span class="product-category-tag">{{ $product->category->name }}</span>
          @endif
          <h1>{{ $product->name }}</h1>
          <p class="lead">{{ $product->long_description ?: $product->short_description }}</p>

          <hr class="product-divider" />

          <div class="product-meta-row">
            @if($product->code)
              <div class="product-meta-item">
                <span class="meta-label">產品編號</span>
                <span class="meta-value">{{ $product->code }}</span>
              </div>
            @endif
            @if($product->min_order_qty)
              <div class="product-meta-item">
                <span class="meta-label">最小訂量</span>
                <span class="meta-value">{{ $product->min_order_qty }}</span>
              </div>
            @endif
            @if($product->lead_time_days)
              <div class="product-meta-item">
                <span class="meta-label">交期</span>
                <span class="meta-value">{{ $product->lead_time_days }}</span>
              </div>
            @endif
            <div class="product-meta-item">
              <span class="meta-label">客製</span>
              <span class="meta-value">接受客製規格</span>
            </div>
          </div>

          <hr class="product-divider" />

          <div class="product-actions">
            <a class="btn btn-blue" href="/#contact">送出需求</a>
            <a class="btn btn-line" href="https://line.me/R/ti/p/@503xumnz"
               target="_blank" rel="noopener">
              <img src="/img/icon/line_bubble.png" alt="" />
              LINE 技術洽詢
            </a>
          </div>
        </div>

      </div>{{-- /product-detail-grid --}}
    </div>
  </section>

  {{-- Product Features --}}
  @if(!empty($product->features))
    <section style="background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);">
      <div class="container">
        <div class="section-title">
          <h2>產品特色</h2>
        </div>
        <div class="features-grid">
          @foreach($product->features as $feature)
            <div class="feature-card">
              <div class="f-icon">{{ $feature['icon'] ?? '' }}</div>
              <h3>{{ $feature['title'] ?? '' }}</h3>
              <p>{{ $feature['description'] ?? '' }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- Specs Table --}}
  @if(!empty($product->specifications))
    <section>
      <div class="container">
        <div class="section-title">
          <h2>產品規格</h2>
          <p>以下為標準規格，如需客製化請於詢價時說明需求。</p>
        </div>
        <table class="specs-table">
          <thead>
            <tr><th>規格項目</th><th>規格值 / 說明</th></tr>
          </thead>
          <tbody>
            @foreach($product->specifications as $spec)
              <tr>
                <td>{{ $spec['label'] ?? '' }}</td>
                <td>{{ $spec['value'] ?? '' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  @endif

  {{-- Application Areas --}}
  @if($product->applicationAreas->isNotEmpty())
    <section style="background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);">
      <div class="container">
        <div class="section-title">
          <h2>應用場景</h2>
        </div>
        <div class="scenario-grid">
          @foreach($product->applicationAreas as $area)
            <div class="scenario-card">
              <div class="scenario-img">{{ $area->icon }}</div>
              <div class="scenario-body">
                <h3>{{ $area->name }}</h3>
                <p>{{ $area->description }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- Related Products --}}
  @if($product->relatedProducts->isNotEmpty())
    <section>
      <div class="container">
        <div class="section-title">
          <h2>相關產品</h2>
          <p>您可能也感興趣的其他線材與連接器方案。</p>
        </div>
        <div class="related-grid">
          @foreach($product->relatedProducts as $related)
            <article class="related-card">
              <div class="related-thumb"
                   style="background-color: {{ $related->category?->color_band ?? '#0b4ea2' }}">
                {{ $related->icon }}
              </div>
              <div class="related-body">
                <div class="related-cat">{{ $related->category?->name }}</div>
                <h3>{{ $related->name }}</h3>
                <p>{{ $related->short_description }}</p>
                <a class="related-link"
                   href="{{ route('products.show', $related->slug) }}">查看詳情 →</a>
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
