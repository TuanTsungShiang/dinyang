# News Schema

最新消息：公司消息 / 展會資訊 / 技術文章。分類拆獨立表，方便客戶未來自行新增類別（例：獲獎紀錄、媒體報導）。

涵蓋 `news_categories` 與 `news` 兩個表。

---

## 1. `news_categories`

文章分類。

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `name` | `varchar(100)` | NO | - | 顯示名稱（例：「公司消息」） |
| `slug` | `varchar(100)` | NO | - | URL slug，UNIQUE（例：`company`） |
| `description` | `text` | YES | NULL | 分類說明（分類頁介紹用） |
| `color` | `varchar(20)` | YES | NULL | 卡片標籤色 hex（例：`#0b4ea2`） |
| `sort_order` | `int` | NO | 0 | 顯示順序 |
| `is_active` | `boolean` | NO | true | 上下架；下架後不顯示在前台篩選 |
| `created_at` | `timestamp` | NO | auto | |
| `updated_at` | `timestamp` | NO | auto | |

### Indexes

- `UNIQUE (slug)`
- `INDEX (is_active, sort_order)`

### 種子資料（migration seeder）

```
1. 公司消息   company  #0b4ea2  ord=10
2. 展會資訊   event    #d4742a  ord=20
3. 技術文章   tech     #0a8a4e  ord=30
```

---

## 2. `news`

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `category_id` | `bigint unsigned` | NO | - | FK → `news_categories.id` |
| `title` | `varchar(200)` | NO | - | 文章標題 |
| `slug` | `varchar(200)` | NO | - | URL slug，UNIQUE |
| `excerpt` | `varchar(500)` | NO | - | 摘要（列表卡片用） |
| `content` | `longtext` | YES | NULL | 內文（rich text，支援圖片內嵌） |
| `cover_image` | `varchar(500)` | YES | NULL | 封面圖路徑（列表卡片背景） |
| `author` | `varchar(100)` | YES | NULL | 作者 / 發布單位（自由字串，例：「定陽編輯部」） |
| `tags` | `json` | YES | NULL | 標籤陣列（搜尋輔助；v1 不做篩選功能但保留欄位） |
| `is_published` | `boolean` | NO | false | 上下架 |
| `published_at` | `timestamp` | YES | NULL | 發布時間；null = 草稿 |
| `meta_title` | `varchar(200)` | YES | NULL | SEO override |
| `meta_description` | `varchar(500)` | YES | NULL | SEO override |
| `created_at` | `timestamp` | NO | auto | |
| `updated_at` | `timestamp` | NO | auto | |
| `deleted_at` | `timestamp` | YES | NULL | 軟刪除 |

### Indexes

- `UNIQUE (slug)`
- `INDEX (category_id)` (FK 自動)
- `INDEX (is_published, published_at desc)` — 列表頁用「已發布」+「最新優先」
- `INDEX (category_id, published_at desc)` — 分類過濾用

---

## 範例資料（從現有 home.blade.php 提取）

```
1. category=1 (公司消息)  定陽企業新廠落成啟用            2024-05-15
2. category=2 (展會資訊)  2024 台北國際自動化工業大展     2024-05-01
3. category=3 (技術文章)  連接器選型指南與應用要點        2024-04-20
```

---

## 關聯

- `N:1 → news_categories`

未來擴充：
- 若加 `author_id` 連到 `users`（作者管理）
- 若加 tag 篩選頁，拆 `news_tags` + `news_tag_pivot` 表

---

## Filament Resource 行為

### NewsCategoryResource
- 簡單 CRUD：name / slug / description / color / sort_order / is_active
- 預設按 sort_order 排序
- 刪除前檢查：若有 news 引用則不允許硬刪（cascade restrict）

### NewsResource
- 列表頁預設按 `published_at desc`
- 顯示分類名稱（join `news_categories.name`），不顯示原始 category_id
- 新增草稿時 `is_published=false`、`published_at=null`
- 「發布」動作：`is_published=true`、`published_at=now()`（除非已預設）
- 提供「排程發布」：`is_published=true` + `published_at=未來時間`，前台 query 條件加 `published_at <= now()`
