# 2026-05-09 工作日誌

> 主軸：承接昨日 Phase 1 成果 → 完成 Phase 2–4 → 補齊前台缺口 → Phase 5 通知

---

## 重大里程碑

- ✅ Phase 2 — Filament Resource 客製化（RichEditor、BadgeColumn、Repeater、RelationManagers、品牌色）
- ✅ Phase 3 — 前台 Blade 全面動態化（3 Controllers、products/home/contact 串 DB）
- ✅ Phase 4 — Dev 主機部署（git pull develop + cache + storage:link）
- 🔲 前台缺口補齊（應用領域 DB 化、最新消息列表 + 內頁、閱讀更多連結）
- 🔲 Phase 5 — 新詢價單 email 通知

---

## 文件索引

| 檔案 | 內容 |
|---|---|
| [README.md](README.md) | 本檔：總覽、commit list、今日計畫 |
| [sessions.md](sessions.md) | 各 session 詳細工程紀錄 |

---

## 今日 Commits

| Hash | 訊息 |
|---|---|
| `3f7dbc9` | feat: Phase 2 — Filament Resource 客製化 |
| `4b0e8d3` | feat: Phase 3 — 前台 Blade 全面動態化 |
| *(進行中)* | feat: 前台缺口 — 應用領域 DB 化 + 最新消息列表 / 內頁 |

---

## 今日計畫

### 已完成
1. **Phase 2** — Filament 後台客製化（全部 Resource 加 label、icon、navigationGroup）
2. **Phase 3** — 前台串 DB（商品列表、商品內頁、首頁 news/hero、詢價 POST）
3. **Phase 4** — Dev 主機部署（cache 重建、storage:link、權限修正）

### 進行中
4. **前台缺口補齊**
   - 首頁「應用領域」區塊從 `application_areas` DB 拉
   - 新建 `/news` 最新消息列表頁
   - 新建 `/news/{slug}` 最新消息內文頁
   - 首頁「閱讀更多 →」改連到 `/news/{slug}`

### 待辦
5. **Phase 5** — 新詢價單進來 → 寄 email 給 admin（Laravel Mail + 簡易 Notification）
6. **Cloudflare Cache Rule** — `/livewire/*`、`/admin/*` 設 Bypass（避免下次 cache 咬人）
