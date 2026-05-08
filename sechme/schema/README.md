# 定陽 CMS Schema 規劃 v1

> 本目錄為**設計文件**，非 Laravel 實作。實際 migrations 將在 `web/database/migrations/` 產出。
> 設計變更走 PR review；migrations 一旦上 develop 就不可改、只能新增 migration 修正。

---

## 文件索引

| 檔案 | 內容 |
|---|---|
| [README.md](README.md) | 本檔：總覽、命名慣例、ER 圖、Filament 設定注意事項 |
| [products.md](products.md) | `products` + `product_categories` + `product_related`（自參照 M:M） |
| [news.md](news.md) | `news`（最新消息：公司消息 / 展會資訊 / 技術文章） |
| [inquiries.md](inquiries.md) | `inquiries`（詢價表單提交，含處理狀態） |
| [hero_slides.md](hero_slides.md) | `hero_slides`（首頁 hero 輪播圖） |

---

## ER 概觀（文字版）

```
┌─────────────────────┐
│ product_categories  │ 6 種分類（線材加工 / 連接器組裝 / ...）
└──────────┬──────────┘
           │ 1:N
           ▼
┌─────────────────────┐         ┌──────────────────┐
│      products       │ ◄─M:M─► │ product_related  │（自參照中介表）
└──────────┬──────────┘         └──────────────────┘
           │ 1:N (optional)
           ▼
┌─────────────────────┐
│     inquiries       │ ─── (FK handled_by) ──► users
└─────────────────────┘                            ▲
                                                   │
┌─────────────────────┐                            │
│        news         │                            │（admin auth）
└─────────────────────┘                            │
                                                   │
┌─────────────────────┐                            │
│     hero_slides     │                            │
└─────────────────────┘                            │
                                                   │
┌─────────────────────┐                            │
│       users         │ ◄──── 既有，加 is_admin ────┘
└─────────────────────┘
```

`news`、`hero_slides`、`product_categories` 為獨立實體（無外部 FK）。

---

## 命名慣例

### 資料表
- 一律 **snake_case 複數**：`products`、`product_categories`、`hero_slides`
- 中介表用兩個實體單數 + `_` 連接，按字母序：`product_related`（自參照例外，見 products.md）

### 欄位
- snake_case：`category_id`、`published_at`、`is_active`
- 布林值用 `is_xxx` / `has_xxx`：`is_published`、`is_active`、`is_admin`
- 日期欄位用 `_at`：`created_at`、`updated_at`、`published_at`、`handled_at`
- 排序欄位統一 `sort_order`（int）

### 主鍵 / 外鍵
- PK 一律 `id`：`bigint unsigned auto_increment`
- FK 命名：`{單數實體}_id`（例：`category_id`、`product_id`、`handled_by`）

---

## 共用欄位（所有資料表都有）

| 欄位 | 型別 | 說明 |
|---|---|---|
| `id` | `bigint unsigned` | 主鍵、auto-increment |
| `created_at` | `timestamp` | Laravel 預設 |
| `updated_at` | `timestamp` | Laravel 預設 |

軟刪除（`deleted_at`）：products、news、inquiries 啟用；categories、hero_slides 不啟用（量小、直接硬刪）。

---

## 型別約定

| 用途 | 推薦型別 | 備註 |
|---|---|---|
| 短字串（標題、姓名、Email） | `varchar(200)` | 含緩衝 |
| URL / 路徑 | `varchar(500)` | UTF-8 多位元組 |
| Slug | `varchar(200)`，UNIQUE | URL-friendly |
| 短描述 / 摘要 | `varchar(500)` | 卡片用 |
| 長內容 / 內文 | `text` | TINYTEXT 不夠 |
| JSON 結構（規格、特色、應用場景） | `json` | MySQL 8 原生支援 |
| 列舉狀態 | `varchar(20)` + check | 不用 ENUM（schema 變更困難） |
| 金額 | `decimal(12, 2)` | 避免 float 精度問題（暫時用不到） |
| 圖檔路徑 | `varchar(500)` | 存 storage/app/public 相對路徑 |

---

## Index 慣例

- 所有 FK 欄位自動加 index
- 常查詢過濾欄位：`is_published`、`is_active`、`published_at`、`category_id`
- Slug 一律 UNIQUE
- 列表排序組合：`(is_published, sort_order)` 或 `(published_at desc)`

---

## Filament v3 整合注意事項

### Admin 認證
- **沿用 `users` 表，新增 `is_admin` boolean**（預設 false）
- Filament 在 `App\Providers\Filament\AdminPanelProvider` 設定 `auth->guard('web')`
- User model 實作 `FilamentUser` interface，`canAccessPanel()` 回傳 `$this->is_admin`
- 不引入 Spatie/Permissions（首版用不到角色，未來如果要分編輯/管理員再加）

### 檔案上傳
- 統一儲存到 `storage/app/public/{model}/{id}/{filename}`
  - 例：`storage/app/public/products/12/hero.jpg`、`storage/app/public/inquiries/45/spec.pdf`
- 對外路徑透過 `php artisan storage:link` 暴露為 `/storage/...`
- 暫不引入 Spatie Media Library（單檔欄位用 Filament 內建 `FileUpload` 即可）

### Soft Delete + Filament
- products / news / inquiries 啟用 soft delete
- Filament Resource 加 `->modifyQueryUsing(fn ($q) => $q->withoutTrashed())` 預設不顯示已刪除
- 提供 trashed filter 切換顯示

### Slug 自動產生
- 用 [`spatie/laravel-sluggable`](https://github.com/spatie/laravel-sluggable) 或 Laravel 內建 `Str::slug()`
- 中文 slug → 英文/拼音轉換（中文字元 URL 解碼後仍可讀，但建議手動指定 slug 以利 SEO）

---

## 預留 / 暫不處理（v2 再議）

- 多語系（網站目前只中文）
- 產品的多張圖片 gallery 改用獨立 `product_images` 表（v1 用 JSON 欄位即可）
- 角色權限細分（編輯 / 管理員）— 用 Spatie Permissions
- 商品評價 / 客戶見證
- 編輯型靜態頁（about、application 等改 DB 驅動）
- Inquiry 自動發送通知（Email / LINE Notify）
- 全文檢索（Scout + Meilisearch）

---

## Open Questions（待確認）

1. **Inquiries 的 attachment 多檔還是單檔？** 目前表單欄位只允許單檔，schema 也是單檔（`attachment_path`）。若改多檔需拆 `inquiry_attachments` 表。
2. **Hero slides 上下架排程** 用 `starts_at` / `ends_at` 還是手動切 `is_active`？v1 兩個都做，可選。
3. **News 分類**：用 enum 字串（`company` / `event` / `tech`）還是獨立 `news_categories` 表？v1 用 enum 字串（量少且穩定）。
4. **Products 的「應用場景」連結到哪裡？** 目前只是 JSON 描述。若應用領域要做成可篩選頁面，需要 `application_areas` 表 + M:M。**v1 不做**，先存 JSON。
