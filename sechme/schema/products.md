# Products + Categories Schema

涵蓋 `product_categories`、`products`、以及自參照中介表 `product_related`。

---

## 1. `product_categories`

產品分類。目前 6 種固定分類，未來客戶可能新增。

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `name` | `varchar(100)` | NO | - | 顯示名稱（例：「線材加工」） |
| `slug` | `varchar(100)` | NO | - | URL-friendly，UNIQUE（例：`cable-processing`） |
| `description` | `text` | YES | NULL | 分類說明（列表頁分類介紹用） |
| `color_band` | `varchar(20)` | YES | NULL | 卡片頂部色帶 hex（例：`#0b4ea2`） |
| `sort_order` | `int` | NO | 0 | 顯示順序（小到大） |
| `is_active` | `boolean` | NO | true | 上下架；下架後不顯示在前台 filter |
| `created_at` | `timestamp` | NO | auto | |
| `updated_at` | `timestamp` | NO | auto | |

### Indexes

- `UNIQUE (slug)`
- `INDEX (is_active, sort_order)`

### 關聯

- `1:N → products`（一個分類有多個產品）

### 種子資料（migration seeder）

```
1. 線材加工        cable-processing      #0b4ea2  ord=10
2. 連接器組裝      connector-assembly    #0d80c0  ord=20
3. 客製線組        custom-harness        #5b3eaf  ord=30
4. 自動化設備用線  automation-cable      #b5651d  ord=40
5. 醫療設備配線    medical-wiring        #0a8a4e  ord=50
6. OEM/ODM         oem-odm               #1a2c4a  ord=60
```

---

## 2. `products`

主產品表。每個產品有完整詳細頁。

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `category_id` | `bigint unsigned` | NO | - | FK → `product_categories.id`（主分類） |
| `name` | `varchar(200)` | NO | - | 中文品名（例：「機器人高柔性線組」） |
| `slug` | `varchar(200)` | NO | - | URL slug，UNIQUE（例：`robot-flex-cable`） |
| `code` | `varchar(50)` | YES | NULL | 產品編號（例：`DY-RF-2400`） |
| `short_description` | `varchar(500)` | NO | - | 列表卡片上的一行描述 |
| `long_description` | `text` | YES | NULL | 內頁主要介紹段落 |
| `features` | `json` | YES | NULL | 產品特色陣列（見下方結構） |
| `specifications` | `json` | YES | NULL | 規格表（key-value 陣列） |
| `applications` | `json` | YES | NULL | 應用場景陣列 |
| `min_order_qty` | `varchar(50)` | YES | NULL | 最小訂購量（保留字串以容納「樣品 1 pcs；量產 50 pcs 起」這種多值） |
| `lead_time_days` | `varchar(50)` | YES | NULL | 樣品 / 交期描述 |
| `icon` | `varchar(100)` | YES | NULL | 列表卡片 icon（emoji 或 path） |
| `thumbnail` | `varchar(500)` | YES | NULL | 列表頁卡片縮圖路徑 |
| `gallery` | `json` | YES | NULL | 內頁圖片路徑陣列 |
| `meta_title` | `varchar(200)` | YES | NULL | SEO title override（不填則用 name） |
| `meta_description` | `varchar(500)` | YES | NULL | SEO description override |
| `is_published` | `boolean` | NO | false | 上下架旗標 |
| `sort_order` | `int` | NO | 0 | 同分類內排序 |
| `published_at` | `timestamp` | YES | NULL | 上架時間（用於排程） |
| `created_at` | `timestamp` | NO | auto | |
| `updated_at` | `timestamp` | NO | auto | |
| `deleted_at` | `timestamp` | YES | NULL | 軟刪除 |

### Indexes

- `UNIQUE (slug)`
- `INDEX (category_id)` (FK 自動)
- `INDEX (is_published, sort_order)`
- `INDEX (published_at)`

### JSON 欄位結構

#### `features`（產品特色）
```json
[
  {
    "icon": "💪",
    "title": "超高撓曲壽命",
    "description": "採用螺旋繞線結構，在彎曲半徑 5D 條件下不可撓曲超過 500 萬次..."
  },
  ...
]
```

#### `specifications`（產品規格）
```json
[
  { "label": "導體材質", "value": "鍍錫銅絞線（符合 IEC 60228 Class 6）" },
  { "label": "導體截面積", "value": "0.14 mm² · 0.25 mm² · 0.5 mm²..." },
  ...
]
```

#### `applications`（應用場景）
```json
[
  {
    "icon": "🦾",
    "title": "工業機器手臂",
    "description": "六軸機器人本體配線與外掛工具線束整合"
  },
  ...
]
```

#### `gallery`
```json
[
  "products/12/main.jpg",
  "products/12/spec.pdf",
  "products/12/usage.png"
]
```

### 關聯

- `N:1 → product_categories`
- `1:N ← inquiries`（產品內頁送出的詢價會記 `inquiries.product_id`）
- `M:M ↔ products`（透過 `product_related` 自參照）

---

## 3. `product_related`（自參照 M:M 中介表）

「相關產品」推薦關聯。雙向：`product_id` 認為 `related_product_id` 是相關產品。

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `product_id` | `bigint unsigned` | NO | - | FK → `products.id`（主體） |
| `related_product_id` | `bigint unsigned` | NO | - | FK → `products.id`（相關產品） |
| `sort_order` | `int` | NO | 0 | 推薦順序 |
| `created_at` | `timestamp` | NO | auto | |

### Indexes

- `PRIMARY KEY (product_id, related_product_id)`
- `INDEX (related_product_id)`（反向查詢）

### Constraint

- 應用層阻擋 `product_id = related_product_id`（自己關聯自己）
- 雙向關聯需要兩筆紀錄（A→B、B→A），由 admin 維護或 model 事件自動同步

### Filament 注意

- Resource 用 `BelongsToMany` 關聯，UI 上做雙向同步（Filament 內建 `Repeater` 或 `Select::multiple()` 都可，建議用 `Select::multiple()->relationship('relatedProducts')`）

---

## 種子資料規模參考

從現有靜態 HTML（`product-detail.html`、`products.html`）抓取：

- **6 個分類**（已列在 `product_categories` 種子）
- **12 個產品**（對應現有 12 張卡片）
- **每個產品 ~3 個相關產品**（共 36 筆 `product_related`）

種子資料於 [seeders.md](./seeders.md)（待寫）整理，避免本檔過長。
