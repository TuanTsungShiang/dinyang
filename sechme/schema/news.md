# News Schema

最新消息：公司消息 / 展會資訊 / 技術文章。

---

## `news`

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `title` | `varchar(200)` | NO | - | 文章標題 |
| `slug` | `varchar(200)` | NO | - | URL slug，UNIQUE |
| `category` | `varchar(20)` | NO | - | 分類字串：`company` / `event` / `tech` |
| `excerpt` | `varchar(500)` | NO | - | 摘要（列表卡片用） |
| `content` | `longtext` | YES | NULL | 內文（rich text，支援圖片內嵌；用 `text` 可能不夠） |
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
- `INDEX (is_published, published_at desc)` — 列表頁用「已發布」+「最新優先」
- `INDEX (category, published_at desc)` — 分類過濾用

### Category 列舉值

| 值 | 顯示 | 卡片標籤色 |
|---|---|---|
| `company` | 公司消息 | `--blue-800` 深藍 |
| `event` | 展會資訊 | `#d4742a` 橘 |
| `tech` | 技術文章 | `#0a8a4e` 綠 |

→ 應用層用 enum 或 const class 管理（不用 DB ENUM，便於擴充）。

---

## 範例資料（從現有 home.blade.php 提取）

```
1. 定陽企業新廠落成啟用            company  2024-05-15
2. 2024 台北國際自動化工業大展     event    2024-05-01
3. 連接器選型指南與應用要點        tech     2024-04-20
```

---

## 關聯

無外部關聯，獨立實體。

未來擴充：
- 若加 `author_id` 連到 `users`（作者管理）
- 若加 tag 篩選頁，拆 `news_tags` + `news_tag_pivot` 表

---

## Filament Resource 行為

- 列表頁預設按 `published_at desc`
- 新增草稿時 `is_published=false`、`published_at=null`
- 「發布」動作：`is_published=true`、`published_at=now()`（除非已預設）
- 提供「排程發布」：`is_published=true` + `published_at=未來時間`，前台 query 條件加 `published_at <= now()`
