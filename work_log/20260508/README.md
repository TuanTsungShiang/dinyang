# 2026-05-08 工作日誌

> 主軸：上午前端收尾 → 下午 Filament 後台從零到完整 → 晚上部署 dev 主機

---

## 重大里程碑

- ✅ Strangler Fig 階段 C 收尾：產品列表 + 內頁版型對齊原稿、聯絡表單去重
- ✅ CMS schema v1 規劃完成（10 表，含 ER + Decisions Log）並更新為更完整建模
- ✅ Filament v3 後台從零安裝到 7 個 Resource 全部跑通（CRUD UI 都能用）
- ✅ 部署到 dev 主機 https://dev-dinyang.ezweb356.online/admin，admin login 正式可用

---

## 文件索引

| 檔案 | 內容 |
|---|---|
| [README.md](README.md) | 本檔：總覽、commit list、明日計畫 |
| [sessions.md](sessions.md) | 上午（前端修正、schema 規劃）+ 下午（Filament 5 phase 實作）|
| [deployment.md](deployment.md) | 晚上部署 dev 主機踩雷紀錄（5 個戰場：擴充缺、restart loop、405、livewire 404、cf cache）|

---

## 全部 commit（12 個）

### 上午 — 前端修正 + schema 規劃
1. `575ccbe` fix: 產品頁版型對齊原稿 + cta-strip 視覺調整
2. `49a5903` docs: 新增 CMS schema 規劃 (sechme/schema/)
3. `b54a722` docs: schema 規劃依 v1 決策更新為更完整建模
4. `e2fcb9f` docs: 新增 work_log/20260508 工程日誌

### 下午 — Filament 5 phase
5. `b40996a` feat: 安裝 Filament v3 後台 + product_categories 整條鏈跑通
6. `d0f9ec6` feat: 新增 3 個獨立 entity 後台 Resource (Phase 1B)
7. `80200dc` feat: products + 2 pivot 表 + 關聯模型 (Phase 1C)
8. `3aa5152` feat: news + inquiries + inquiry_attachments (Phase 1D & 1E)
9. `718afc4` docs: work_log/20260508 補上下午 Filament 5 phase 進度

### 晚上 — 部署 dev 主機
10. `185f2ec` fix: PHP container 加 ext-intl 與 ext-zip 滿足 Filament 依賴
11. `10ea7f8` fix: 信任所有 proxy 讓 Cloudflare X-Forwarded-Proto 生效
12. `dc591df` fix: nginx 靜態資源 location 找不到檔案時 fallback 到 Laravel

---

## 結論

- /admin 在 https://dev-dinyang.ezweb356.online/admin 正式可用
- 7 個 Resource 全部在 sidebar，CRUD 都通
- Memory 多 4 條 deployment gotcha
- **前台跟後台還沒串起來**（Phase 3 工作）— 後台改資料前台不會反應

---

## 數字戰報

- 工作時數：早 + 午 + 晚 約 12 hr
- commit 數：12
- 戰場數：5（晚上部署）+ 多次前端視覺迭代
- 新建檔案：> 100 個（含 Filament published assets）
- 新表：11（含 2 pivot + 1 子表）
- Memory 新增：6 條（4 deployment gotcha + 2 文件慣例）
