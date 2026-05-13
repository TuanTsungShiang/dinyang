# Hero Slides Schema

首頁 hero 輪播圖。對應前端 `<div class="hero-media">` 內的 `<div class="hero-slide">`。

---

## `hero_slides`

### 欄位

| 欄位 | 型別 | Nullable | 預設 | 說明 |
|---|---|---|---|---|
| `id` | `bigint unsigned` | NO | auto | PK |
| `title` | `varchar(200)` | NO | - | 主標（例：「專業線材加工與連接器整合服務」） |
| `subtitle` | `varchar(500)` | YES | NULL | 副標 / 描述（例：「深耕產業多年，提供客製化線材...」） |
| `eyebrow` | `varchar(200)` | YES | NULL | 標題上方小標 chip（例：「B2B 線材加工｜連接器整合｜OEM / ODM」） |
| `image_path` | `varchar(500)` | NO | - | 背景圖路徑（例：`hero/server-rack.png`） |
| `image_focal_point` | `varchar(20)` | YES | NULL | object-position 座標（例：`center 30%`） |
| `overlay_gradient` | `json` | YES | NULL | 遮罩漸層設定（見下方結構） |
| `cta_primary_label` | `varchar(100)` | YES | NULL | 主 CTA 文字（例：「立即詢價 →」） |
| `cta_primary_url` | `varchar(500)` | YES | NULL | 主 CTA 連結 |
| `cta_secondary_label` | `varchar(100)` | YES | NULL | 副 CTA 文字（例：「加入 LINE」） |
| `cta_secondary_url` | `varchar(500)` | YES | NULL | 副 CTA 連結 |
| `cta_secondary_icon` | `varchar(500)` | YES | NULL | 副 CTA 圖示（例：`/img/icon/line_bubble.png`） |
| `is_active` | `boolean` | NO | true | 上下架旗標（管理員手動切換） |
| `sort_order` | `int` | NO | 0 | 輪播順序（1, 2, 3...） |
| `created_at` | `timestamp` | NO | auto | |
| `updated_at` | `timestamp` | NO | auto | |

### Indexes

- `INDEX (is_active, sort_order)` — 前台 query 預設排序

### JSON 欄位結構

#### `overlay_gradient`
控制圖片上方的遮罩漸層（讓文字可讀）。對應 `.hero-media::after` 的 `background`。

```json
{
  "direction": "90deg",
  "stops": [
    { "color": "rgba(6, 43, 95, 0.92)", "position": "0%" },
    { "color": "rgba(7, 59, 131, 0.7)", "position": "30%" },
    { "color": "rgba(7, 59, 131, 0.2)", "position": "60%" },
    { "color": "transparent", "position": "100%" }
  ]
}
```

→ 前端 render 時組合成 CSS：
```
linear-gradient(90deg, rgba(6, 43, 95, 0.92) 0%, rgba(7, 59, 131, 0.7) 30%, ...)
```

> v1 可暫時用全站統一遮罩（hardcode 在 CSS），不依賴此 JSON。等需要每張圖客製遮罩時再啟用。

---

## 顯示邏輯

前台 query：

```sql
SELECT * FROM hero_slides
WHERE is_active = true
ORDER BY sort_order ASC;
```

> 不做排程上下架。需要預告 / 排程的場景由管理員手動切 `is_active`。

---

## 範例資料（v1 種子）

```
1. title: 專業線材加工與連接器整合服務
   subtitle: 深耕產業多年，提供客製化線材、連接器、OEM / ODM 與技術支援
   eyebrow: B2B 線材加工｜連接器整合｜OEM / ODM
   image: hero/server-rack-blue-cables.png
   cta_primary: 立即詢價 → /#contact
   cta_secondary: 加入 LINE → https://line.me/R/ti/p/@503xumnz
   is_active: true
   sort_order: 1
```

→ v1 上線時只有 1 筆（即現有 hero）。等業主想換不同視覺再加 slide 2、3...

---

## Filament Resource 行為

- 列表頁顯示縮圖 + title + 上架狀態 + sort_order
- 排序欄位 sort_order 拖拉重排（Filament `ReorderRecords`）
- 預覽功能：點某張 slide 顯示在 modal 中以 hero 比例呈現
- 圖片裁切建議：1920×800（前端 object-fit: cover 會自動處理 responsive）

---

## 前端輪播實作（提示，非 schema 範圍）

- 前端用 vanilla JS / Alpine.js / Swiper 任一
- v1 結構已在 `home.blade.php` 預留：`<div class="hero-media">` 內可放多個 `<div class="hero-slide">`
- 切換邏輯：CSS opacity transition + JS setInterval（最簡單）；若需手勢、indicator、autoplay 控制則用 Swiper

→ 詳細實作放 [sechme/frontend/hero-carousel.md](../frontend/hero-carousel.md)（待寫）
