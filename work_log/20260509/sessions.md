# Work Log — 2026-05-09 Sessions

---

## 早晨對錶 + 承接昨日進度

- `git pull` 確認 develop 已是最新（昨日最後 commit `da53dc9`）
- 昨日「明天/下一步」清單：Phase 2、3、4、5

---

## Phase 2 — Filament Resource 客製化（commit `3f7dbc9`）

### 修改內容

| Resource | 變更 |
|---|---|
| **NewsResource** | `content` → RichEditor、`tags` → TagsInput、navigationGroup「內容管理」、加 TrashedFilter |
| **InquiryResource** | `status` → Select + `BadgeColumn`（4 色：info/warning/success/gray）、Section 分組、法遵欄位 disabled+collapsed、加 AttachmentsRelationManager |
| **ProductResource** | `features`/`specifications` → Repeater、`thumbnail`/`gallery` → FileUpload、加 ApplicationAreasRelationManager + RelatedProductsRelationManager |
| **AdminPanelProvider** | brandName「定陽管理後台」、primary 色 Amber → Blue |
| **全部 Resource** | navigationGroup + 語義化 icon（sidebar 分 4 群組：產品管理/內容管理/客戶管理/外觀設定）|

### 新建 RelationManagers（3 個）
- `ProductResource/RelationManagers/ApplicationAreasRelationManager`
- `ProductResource/RelationManagers/RelatedProductsRelationManager`
- `InquiryResource/RelationManagers/AttachmentsRelationManager`

---

## Phase 3 — 前台 Blade 全面動態化（commit `4b0e8d3`）

### 新建 Controllers（3 個）

**HomeController**
- `index()` → hero 從 `hero_slides` 第 1 筆 is_active、news 從 DB 最新 3 筆 is_published

**ProductController**
- `index()` → categories + products（with category）按 sort_order
- `show($slug)` → with category / relatedProducts.category / applicationAreas，firstOrFail

**InquiryController**
- `store(Request)` → validate → Inquiry::create → 附件 store('inquiry-attachments','public') → redirect()->back()->with('inquiry_success')

### routes/web.php 更新
```
GET  /                    HomeController@index
GET  /products            ProductController@index
GET  /products/{slug}     ProductController@show
POST /inquiries           InquiryController@store
```

### Blade 動態化

| 檔案 | 變更 |
|---|---|
| `home.blade.php` | hero 全欄位從 `$hero?->xxx`；news `@forelse($news as $item)` |
| `products.blade.php` | filter 按鈕 `@foreach($categories)`；商品卡 `@forelse($products)`，color_band inline style |
| `products/show.blade.php` | 所有 hardcoded 換 `$product->xxx`；features/specs/applicationAreas/relatedProducts 各自 `@if + @foreach` 條件渲染 |
| `partials/contact.blade.php` | action 改 `route('inquiries.store')`；加 session('inquiry_success') flash + `$errors->any()` 顯示 |

---

## Phase 4 — Dev 主機部署

使用者在 dev 主機手動執行：

```bash
git pull origin develop
docker compose exec -T php php artisan config:cache
docker compose exec -T php php artisan route:cache
docker compose exec -T php php artisan view:cache
docker compose exec -T php php artisan storage:link
docker compose exec -T php chmod -R 775 storage bootstrap/cache
```

**本次不需要** `migrate`（Phase 2/3 無 schema 異動）、不需要 rebuild image（無 Dockerfile/composer 異動）。

---

## 前台缺口補齊（進行中）

### 缺口清單（Phase 3 審計後發現）

| 項目 | 狀態 |
|---|---|
| 首頁「應用領域」區塊從 DB 拉 | 🔲 |
| `/news` 最新消息列表頁 | 🔲 |
| `/news/{slug}` 最新消息內文頁 | 🔲 |
| 首頁「閱讀更多 →」改連 `/news/{slug}` | 🔲 |

*(本 session 持續更新)*
