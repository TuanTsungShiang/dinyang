# Inquiries Schema

詢價表單提交記錄 + 處理狀態追蹤 + 附件子表（v1 表單只允許單檔，但 schema 已就位多檔擴充）。

涵蓋 `inquiries` 與 `inquiry_attachments` 兩個表。

---

## 1. `inquiries`

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `company_name` | `varchar(200)` | NO | - | 公司名稱（必填） |
| `contact_name` | `varchar(100)` | NO | - | 聯絡人（必填） |
| `phone` | `varchar(50)` | NO | - | 電話（必填，包含分機字串） |
| `email` | `varchar(200)` | NO | - | Email（必填） |
| `message` | `text` | NO | - | 需求說明（必填） |
| `source` | `varchar(50)` | NO | - | 來源頁面：`home` / `product_detail` / `cta_strip` / `inquiry_bar` |
| `product_id` | `bigint unsigned` | YES | NULL | FK → `products.id`（從產品內頁送來才有） |
| `status` | `varchar(20)` | NO | `'new'` | 處理狀態：`new` / `in_progress` / `completed` / `archived` |
| `handled_by` | `bigint unsigned` | YES | NULL | FK → `users.id`（處理者） |
| `handled_at` | `timestamp` | YES | NULL | 處理時間 |
| `notes` | `text` | YES | NULL | 內部備註（admin 用） |
| `ip_address` | `varchar(45)` | YES | NULL | 提交者 IP（IPv6 也容得下） |
| `user_agent` | `varchar(500)` | YES | NULL | 提交者 User-Agent |
| `privacy_agreed_at` | `timestamp` | YES | NULL | 同意隱私政策時間（合規用） |
| `created_at` | `timestamp` | NO | auto | |
| `updated_at` | `timestamp` | NO | auto | |
| `deleted_at` | `timestamp` | YES | NULL | 軟刪除 |

> 附件改放在 `inquiry_attachments` 子表，主表不再有 `attachment_path`。

### Indexes

- `INDEX (status, created_at desc)` — admin 列表預設排序
- `INDEX (product_id)` (FK 自動)
- `INDEX (handled_by)` (FK 自動)
- `INDEX (email)` — 查詢同一客戶歷史紀錄

### Status 列舉值

| 值 | 顯示 | 說明 |
|---|---|---|
| `new` | 新進詢價 | 預設值，未指派 |
| `in_progress` | 處理中 | 有人接手回覆 |
| `completed` | 已完成 | 報價已回覆 / 結案 |
| `archived` | 已封存 | 廢棄 / 重複（如非必要不刪除，保留 trace） |

### Source 列舉值

| 值 | 對應前台位置 |
|---|---|
| `home` | 首頁 `partials.contact` 表單 |
| `cta_strip` | products 列表頁底部「找不到符合需求的規格？」CTA |
| `inquiry_bar` | products 內頁底部「需要客製化規格或批量報價？」CTA（注：CTA 本身只跳轉 `/#contact`，需要在跳轉時帶 query string `?source=inquiry_bar` 才能標記） |
| `product_detail` | （預留）產品內頁未來若有獨立詢價表單時用 |

> v1 簡化做法：所有 CTA 都只跳轉到 `/#contact`，表單統一以 `home` 為 source。`source` 欄位保留以便未來細分。

---

## 2. `inquiry_attachments`

附件子表。v1 表單規格仍是單檔上傳，但 schema 已就位多檔擴充（未來只要改前台表單為 multiple file input、加上 server-side 多檔儲存即可，**不用 migration**）。

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `inquiry_id` | `bigint unsigned` | NO | - | FK → `inquiries.id`（cascade delete） |
| `path` | `varchar(500)` | NO | - | 儲存路徑（相對 `storage/app/public/`） |
| `original_name` | `varchar(200)` | NO | - | 原始檔名（顯示用） |
| `mime_type` | `varchar(100)` | YES | NULL | MIME type（驗證 / 顯示 icon 用） |
| `size_bytes` | `bigint unsigned` | YES | NULL | 檔案大小（檔案管理 / 額度用） |
| `sort_order` | `int` | NO | 0 | 顯示順序（多檔時客戶可指定首選） |
| `created_at` | `timestamp` | NO | auto | |

### Indexes

- `INDEX (inquiry_id)` (FK 自動)

### Cascade

- `inquiry_id` 設 `ON DELETE CASCADE` → 軟刪除 inquiry 時不影響（軟刪只是設 deleted_at）；硬刪 inquiry 時自動清掉附件記錄。**注意**：實體檔案需在 model `deleting` event 額外處理 `Storage::delete()`。

---

## 檔案上傳處理

### 路徑慣例
- 儲存到：`storage/app/public/inquiries/{inquiry_id}/{filename}`
- DB 存：`inquiries/{inquiry_id}/{filename}`（相對 `storage/app/public/`）
- 顯示時組合：`/storage/inquiries/{inquiry_id}/{filename}`

### 安全性
- 限定副檔名：`pdf, jpg, jpeg, png, doc, docx, xls, xlsx`
- 限定檔案大小：10 MB
- 上傳前重新命名為時間戳 + 隨機 hash，避免衝突與路徑遍歷
- 使用 Laravel `Storage::disk('public')->putFileAs()`

---

## 關聯

- `inquiries` `N:1 → products`（optional，若從產品內頁來）
- `inquiries` `N:1 → users`（`handled_by` 對應到 admin user）
- `inquiries` `1:N → inquiry_attachments`

---

## Filament Resource 行為

### 列表頁
- 預設過濾：`status = 'new'` + `status = 'in_progress'`（聚焦待處理）
- Tab 切換：全部 / 新進 / 處理中 / 已完成 / 已封存
- 每列顯示：公司、聯絡人、Email、來源（badge）、狀態（badge）、附件數、提交時間（相對時間）

### 內頁
- 唯讀：所有 form 欄位（避免 admin 改客戶資料）
- 可編輯：`status`、`handled_by`、`handled_at`、`notes`
- 顯示附件清單：原始檔名、大小、下載連結
- 動作按鈕：「指派給我」、「標記處理中」、「標記完成」、「封存」
- 顯示原始 user-agent / ip（風險識別用）

### 通知（v1 不做，v2 實作）
- 新進詢價時 → 寄信給 admin email
- 或 → LINE Notify 推送
- 客戶確認信（提交時自動寄送「我們已收到」）

---

## 隱私 / 法遵

- 隱私政策同意時間記錄於 `privacy_agreed_at`（前台 checkbox 勾選時記）
- 軟刪除保留 30 天再永久清除（合規與爭議追溯）
- 出口資料（PII）需經權限管控，非 admin 不可下載 attachment
