# 定陽 CMS Schema 規劃 v1

> 本目錄為**設計文件**，非 Laravel 實作。實際 migrations 將在 `web/database/migrations/` 產出。
> 設計變更走 PR review；migrations 一旦上 develop 就不可改、只能新增 migration 修正。

---

## 文件索引

| 檔案 | 內容 | 涵蓋資料表 |
|---|---|---|
| [README.md](README.md) | 本檔：總覽、命名慣例、ER 圖、Filament 設定注意事項、Decisions Log | — |
| [products.md](products.md) | Products + Categories + 應用領域 | `product_categories`、`products`、`product_related`、`application_areas`、`application_product` |
| [news.md](news.md) | News 與分類 | `news_categories`、`news` |
| [inquiries.md](inquiries.md) | 詢價表單記錄 + 附件 | `inquiries`、`inquiry_attachments` |
| [hero_slides.md](hero_slides.md) | 首頁輪播圖 | `hero_slides` |

**v1 總計**：**10 個新表 + 既有 `users` 表新增 `is_admin` boolean**

---

## ER 概觀（文字版）

```
product_categories ──1:N──┐
                          ▼
                       products ──┬──M:M─→ products (product_related 自參照)
                          │       │
                          │       └──M:M─→ application_areas (application_product)
                          │ 1:N (optional)
                          ▼
                      inquiries ──1:N──→ inquiry_attachments
                          │
                          │ N:1 (handled_by)
                          ▼
                        users ◄── 既有，加 is_admin

news_categories ──1:N──→ news

hero_slides (standalone)
```

獨立實體：`hero_slides`、`product_categories`、`news_categories`、`application_areas`、`users`

關聯實體：`products`、`news`、`inquiries`、`inquiry_attachments`、`product_related`、`application_product`

---

## 命名慣例

### 資料表
- 一律 **snake_case 複數**：`products`、`product_categories`、`hero_slides`
- 中介表：
  - 一般 M:M 用兩個實體單數 + `_` 連接，按字母序：`application_product`
  - 自參照例外：`product_related`（避免 `product_product` 的怪名）

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

軟刪除（`deleted_at`）：`products`、`news`、`inquiries` 啟用；`product_categories`、`news_categories`、`application_areas`、`hero_slides` 不啟用（量小、直接硬刪）。

中介表（`product_related`、`application_product`、`inquiry_attachments`）只有 `created_at`，無 `updated_at`、無軟刪。

---

## 型別約定

| 用途 | 推薦型別 | 備註 |
|---|---|---|
| 短字串（標題、姓名、Email） | `varchar(200)` | 含緩衝 |
| URL / 路徑 | `varchar(500)` | UTF-8 多位元組 |
| Slug | `varchar(200)`，UNIQUE | URL-friendly |
| 短描述 / 摘要 | `varchar(500)` | 卡片用 |
| 長內容 / 內文 | `text` | TINYTEXT 不夠 |
| Rich text 內文 | `longtext` | 會嵌圖片 base64 / 大段 HTML |
| JSON 結構（規格、特色） | `json` | MySQL 8 原生支援 |
| 列舉狀態 | `varchar(20)` + check | 不用 ENUM（schema 變更困難） |
| 金額 | `decimal(12, 2)` | 避免 float 精度問題（暫時用不到） |
| 圖檔路徑 | `varchar(500)` | 存 storage/app/public 相對路徑 |
| 檔案大小 | `bigint unsigned` | bytes，可容納超大檔（理論上） |

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
- News 標籤篩選（拆 `news_tags` + `news_tag_pivot`）
- Hero slides 排程上下架（v1 只用 `is_active`）

---

## Decisions Log

記錄 schema 設計過程中的關鍵決策，避免未來忘記為什麼這樣做。

### 2026-05-08（v1 初版）

| 決策 | 選擇 | 為什麼 |
|---|---|---|
| Inquiries 附件 | **多檔架構（拆 `inquiry_attachments` 子表）** | v1 表單仍只允許單檔，但 schema 已就位多檔。未來改前台表單為多檔上傳時不用 migration，只動程式碼 |
| Hero slides 上下架 | **只用 `is_active` 手動切**（不做 `starts_at` / `ends_at` 排程） | 接案 v1 範圍實用即可；要排程預告再加欄位（migration 不會痛） |
| News 分類 | **獨立 `news_categories` 表** | 客戶未來可能自己加類別（例：獲獎紀錄、媒體報導），不想再回頭做 migration |
| Products 應用場景 | **獨立 `application_areas` 表 + M:M 中介** | 未來要做「按應用領域篩選產品」的列表頁，預留結構；4 種應用領域寫死在 enum 等於白做 |
| Admin 角色管理 | **`users` 加 `is_admin` boolean**（不引入 Spatie/Permissions） | v1 用不到細粒度權限；多角色再加 Spatie |
| 圖片管理 | **Laravel Storage + Filament `FileUpload`**（不引入 Spatie Media Library） | v1 單檔欄位夠用，Spatie Media Library 額外複雜度沒效益 |
| 軟刪除範圍 | **products / news / inquiries 啟用，分類表不啟用** | 主資料需要恢復能力；分類量小、誤刪頻率低、軟刪反而增加 query 複雜度 |
| Slug 策略 | **手動指定英文 slug**（不自動由中文 transliterate） | 中文 URL 雖能 work 但 SEO 體驗差；強迫管理員思考 SEO friendly slug |
