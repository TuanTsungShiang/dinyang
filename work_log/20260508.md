# Work Log — 2026-05-08

> 工程進度日誌。今天主軸：完成前台修正 → 開始後台 schema 規劃。

---

## 早晨對錶 + 同步昨晚進度

- `git pull` 拉到 `60d172e`（昨晚使用者完成的 Strangler Fig 階段 C：商品列表 + 內頁進 Blade）
- 部署 `dfcf133..60d172e` 到 dev 主機
  - 包含商品頁 + LINE QR 換獨立檔名 + LINE ID 統一為 `@503xumnz`
  - 部署過程踩到 `web/public/build` 沒被重 build 的雷，靠 `docker exec ... rm -rf public/build && npm ci && npm run build` 強制 rebuild 解決

---

## 前台修正

### 1. 產品頁版型對齊原稿（commit `575ccbe`）

**問題**：產品列表 / 內頁底部會多一個完整聯絡表單，跟頁面自身的 `cta-strip` / `inquiry-bar` 功能重疊。

**根因**：`partials.contact` 寫死在 `layouts/app.blade.php`，每頁都 include。原稿（`products.html` / `product-detail.html`）的設計是「產品頁 CTA 後直接接 footer，聯絡表單只在首頁」。

**修正**：
- `layouts/app.blade.php` 拿掉 `@include('partials.contact')`
- `home.blade.php` 在 news section 後顯式加 `@include('partials.contact')`
- 結果：首頁保留聯絡表單；產品頁的 CTA 後直接接 footer，符合原稿

### 2. cta-strip / inquiry-bar 視覺調整（同 commit `575ccbe`）

**問題**：`cta-strip` 跟 `footer` 都用 `linear-gradient(135deg, var(--blue-950), var(--blue-800))`，視覺融成一塊。

**修正**：
- 背景由深藍漸層 → 灰藍 / 淺藍 180° 漸變（`#d4dee9 → #e6eef8 → #f5f9ff`）
- 加 `1px solid #c8d4e6` top border，視覺像翻頁摺線
- `btn-outline` 在 `.cta-strip` / `.inquiry-bar` 內覆寫成「白底藍邊藍字」適應淺色底
- text colors 跟著翻黑（`color`、`h2 color`、`p color`）

### 3. 商品內頁區塊順序對調（同 commit `575ccbe`）

把 `inquiry-bar` 跟「相關產品」對調，新順序：

```
詳細介紹 → 產品特色 → 產品規格 → 應用場景 → 相關產品 → inquiry-bar → footer
```

CTA 收尾在頁面最底，動線更合理（看完介紹 → 看相關 → 沒中意？馬上詢價）。

---

## 後台規劃（Schema v1）

### 決定走 Filament v3

**評估**：B2B 形象站後台是內部工具，視覺 < 好用 < 穩定；Filament 預設 UI 已夠用，CP 值最高。

**Trade-off**：Filament 視覺彈性受限於設計系統（品牌色 / logo / 字型可調，但無法完全脫離設計語言）。客戶（周志宏）若未來要求後台視覺一致於前台，需投入額外 Blade 覆寫成本，但 schema / model 不用動。

**後台路徑**：`/admin`（Filament 預設）
- Dev: https://dev-dinyang.ezweb356.online/admin
- 本機: http://localhost:8000/admin

### Schema 規劃文件 (commit `49a5903`)

新增 `sechme/schema/`：

| 檔案 | 涵蓋資料表 |
|---|---|
| `README.md` | 總覽、ER 圖、命名慣例、Filament 設定、Decisions Log |
| `products.md` | `product_categories`、`products`、`product_related` |
| `news.md` | `news` |
| `inquiries.md` | `inquiries` |
| `hero_slides.md` | `hero_slides` |

**初版規模**：6 個新表 + 既有 `users` 加 `is_admin`

### 4 個 Open Questions 決策 + Schema 更新 (commit `b54a722`)

| 議題 | 決定 | 為什麼 |
|---|---|---|
| Inquiries 附件 | 拆 `inquiry_attachments` 子表（v1 仍單檔，schema 預留多檔） | 未來改多檔免 migration |
| Hero slides 排程 | 只用 `is_active` 手動切，去掉 `starts_at` / `ends_at` | 接案 v1 簡化；要排程再加欄位 |
| News 分類 | 拆 `news_categories` 表 | 客戶可能自行新增分類（獲獎、媒體報導等） |
| Products 應用場景 | 拆 `application_areas` + `application_product` M:M 中介 | 預留「按應用領域篩選產品」功能 |

**更新後規模**：**10 個新表** + 既有 `users` 加 `is_admin`

完整表清單：
```
product_categories
products
product_related        (M:M 自參照)
application_areas
application_product    (M:M)
news_categories
news
inquiries
inquiry_attachments
hero_slides
```

README 末尾新增 **Decisions Log**，記錄這 4 個決策的選擇與理由（含其他 v1 決策：軟刪除範圍、Slug 策略、權限模型、圖片管理）。

---

## 其他

- 清掉根目錄誤觸產生的空 `package-lock.json`（86 bytes、空殼，無對應 root `package.json`）
- 啟動本機 dev server（`artisan serve` :8000 + Vite :5173）做視覺微調
- VM 部署的踩雷確認：`web/public/build` 存在時 entrypoint 會跳過 `npm ci && npm run build`，CSS 改動需要 `docker exec` 進容器強制 rebuild。可考慮未來把 build 步驟拆出 entrypoint 條件判斷，做成 deploy 必跑

---

## Today's Commits

| Hash | 訊息 |
|---|---|
| `575ccbe` | fix: 產品頁版型對齊原稿 + cta-strip 視覺調整 |
| `49a5903` | docs: 新增 CMS schema 規劃 (sechme/schema/) |
| `b54a722` | docs: schema 規劃依 v1 決策更新為更完整建模 |

---

## 下午 — Filament 安裝 + v1 schema 全表實作

當天直接接著做 (C) 階段，不等明天。Schema 規劃完直接開實作，5 個 phase 跑完整套後台 CRUD。

### Phase 1A：Filament 安裝 + product_categories (commit `b40996a`)

- `composer require filament/filament:^3.2 -W`（裝 Filament v3.3.50）
- `php artisan filament:install --panels`（產生 `AdminPanelProvider`）
- 加 `users.is_admin` boolean migration
- User model 實作 `FilamentUser` interface，`canAccessPanel()` 回傳 `is_admin`
- 用 tinker 建 dev admin user：`dev@dinyang.local` / `dinyang2026!`（測試用，正式環境前必須砍）
- product_categories：migration + Model + Seeder（6 筆分類）+ Filament Resource (`--generate`)
- 跑通第一個整條鏈 → /admin/product-categories CRUD UI 正常顯示

**踩雷**：`make:migration` / `make:model` 預設 scaffold 是空殼，第一次 Write 之前要先 Read，不然 migration 跑空的、表只有 id+timestamps，要 `migrate:rollback` 重來。

### Phase 1B：3 個獨立 entity (commit `d0f9ec6`)

`application_areas` (4 筆) + `news_categories` (3 筆) + `hero_slides` (1 筆) — 都是無 FK 依賴的獨立表，模式跟 product_categories 一致，批次處理。

`hero_slides` 種子帶入現有 hero 資料（Server_rack_blue_cables.png + LINE @503xumnz），未來輪播功能就接這張表。

### Phase 1C：products + 2 pivot 表 (commit `80200dc`)

最複雜的一個 entity：
- `products` 主表：FK category_id + 軟刪除 + JSON (features/specifications/gallery) + index
- `product_related`：M:M 自參照，雙向關聯 (product_id, related_product_id) 複合 PK
- `application_product`：products ↔ application_areas M:M，pivot 含 note 欄位
- `Product` model 含 `category` / `applicationAreas` / `relatedProducts` / `inquiries` 4 種關聯
- `ProductCategory` / `ApplicationArea` model 補上反向 hasMany / belongsToMany
- 3 個範例產品 seeded，第 1 個（機器人高柔性線組）帶完整 features + specifications JSON

### Phase 1D & 1E：news + inquiries + inquiry_attachments (commit `3aa5152`)

- `news`：FK category_id + longtext content + json tags + 軟刪除
- `inquiries`：客戶必填欄位 + status (`new`/`in_progress`/`completed`/`archived`) + handled_by FK 到 users + 法遵欄位（ip / user_agent / privacy_agreed_at）+ 軟刪除
- `inquiry_attachments`：FK inquiry_id (cascade)，path / original_name / mime_type / size_bytes
- News / Inquiry / InquiryAttachment models 含完整關聯
- NewsSeeder：3 筆消息對應 home.blade.php 既有資料
- InquiriesSeeder 不做（真實客戶資料不假造）
- NewsResource / InquiryResource 用 `--generate` 自動產生

### 至此 v1 schema 10 表全部跑通

**/admin 現況**：左側 sidebar 7 個 Resource，全部可 CRUD（auto-generated 版本）

| Resource | 種子數 |
|---|---|
| Product Categories | 6 |
| Application Areas | 4 |
| News Categories | 3 |
| Hero Slides | 1 |
| Products | 3（範例，等客戶補完整 12 筆） |
| News | 3 |
| Inquiries | 0（不假造） |

11 張表（含 2 pivot + 1 子表）migrations 全部 applied。

---

## Today's Commits (afternoon updates)

| Hash | 訊息 |
|---|---|
| `b40996a` | feat: 安裝 Filament v3 後台 + product_categories 整條鏈跑通 |
| `d0f9ec6` | feat: 新增 3 個獨立 entity 後台 Resource (Phase 1B) |
| `80200dc` | feat: products + 2 pivot 表 + 關聯模型 (Phase 1C) |
| `3aa5152` | feat: news + inquiries + inquiry_attachments (Phase 1D & 1E) |

---

## 明天 / 下一步

Schema 結構完成，後續是 admin 功能與資料雙向綁定：

1. **Phase 2 — Filament Resource 客製化**（2-4 hr）
   - News 用 rich text editor（Filament 內建 `RichEditor`）取代 textarea
   - Inquiries status 改 `Tables\Columns\BadgeColumn`，依狀態著色
   - Products JSON 欄位用 `Repeater` 編輯 features / specifications
   - Products / News / Inquiries 加 RelationManager（related products、attachments）
   - 視覺：Filament 品牌色 / logo / 字型客製到對齊定陽

2. **Phase 3 — 前台 Blade 動態化**（3-5 hr）
   - `/products` 列表頁從 hardcoded 12 卡 → DB query
   - `/products/{slug}` 內頁從 hardcoded → DB query
   - `home.blade.php` news 區塊 → DB query 最近 3 筆
   - hero 區塊改用 `hero_slides` 第 1 筆
   - 聯絡表單 POST 動作 → InquiryController 寫進 inquiries 表

3. **Phase 4 — 部署 dev 主機**（30 min）
   - VM 端 git pull、npm ci && npm run build、`php artisan migrate --force`、跑所有 seeders
   - 在 dev 主機建 admin user

4. **Phase 5 — 後台通知**（1 hr）
   - Inquiry 新進時寄 email 給 admin（先簡單版）
   - 後續可加 LINE Notify

預估完成完整 CMS 動態化：~6-10 hr 工程時數，可分 2-3 天完成。
