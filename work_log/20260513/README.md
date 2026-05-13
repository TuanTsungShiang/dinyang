# 2026-05-13 工作日誌

> 主軸：GCP 測試環境上線驗證、前台細節修正、LINE 通知規劃

---

## 重大里程碑

- ✅ GCP 測試環境 HTTPS 修正（APP_URL + docker container 重建）
- ✅ 產品列表 / 內頁縮圖顯示修正（thumbnail + gallery）
- ✅ 首頁應用領域、最新消息圖片串 DB
- ✅ 產品分類 filter 連通 `?cat=` URL 參數（server-side render，無閃爍）
- ✅ 搜尋結果頁卡片對齊 products / news 樣式
- ✅ Footer 加手機號碼 + 可點擊撥打 / LINE / Email
- ✅ 人才招募改為 104 / yes123 平台連結卡片
- ✅ CTA 文案全站去詢價語氣統一更新
- 🔲 LINE Messaging API 新詢價通知（待實作）

---

## 待實作：LINE 詢價通知

### 需求
新詢價單進來時，自動推播 LINE 訊息到管理員（老闆）的個人 LINE。

### 技術方案
**LINE Messaging API Push Message**

### 設定步驟（一次性，需客戶操作）
1. 至 [LINE Developers Console](https://developers.line.biz/) 建立 Messaging API Channel
2. 取得 **Channel Access Token**（長效版）
3. 老闆將官方帳號加為好友並傳一則訊息
4. 從 Webhook log 取得老闆的 **LINE User ID**（格式：`U1234567890abcdef`）
5. 填入 server `.env`：
   ```
   LINE_CHANNEL_ACCESS_TOKEN=your_token_here
   LINE_NOTIFY_USER_ID=Uxxxxxxxxxxxxxxxx
   ```

### 實作範圍（已規劃）
- `app/Notifications/NewInquiryNotification.php`（LINE Push Message）
- `InquiryController::store()` 觸發通知
- 訊息格式：公司名、聯絡人、電話、Email、需求摘要、後台連結

### 訊息預覽
```
📩 新詢價通知

公司：XXX 有限公司
聯絡人：王大明
電話：0912-345-678
Email：test@example.com

需求：需要 100 條 M12 連接器線組...

👉 前往後台查看
https://dev-dinyang.ezweb356.online/admin/inquiries
```

### 前置條件（需客戶提供）
- [ ] LINE Developers Channel Access Token
- [ ] 管理員 LINE User ID

---

## 今日 Commits

| Hash | 訊息 |
|---|---|
| `5679d9e` | fix: production 環境強制 HTTPS scheme |
| `c29a60c` | fix: 應用領域有圖時移除 app-image::after 內框 |
| `2f5a2e4` | fix: 首頁最新消息卡片顯示 cover_image |
| `6f8fcbd` | feat: 首頁產品分類卡片連結到對應 category filter |
| `887baee` | fix: products filter 改由 PHP server-side render |
| `354d7d7` | feat: 人才招募改為 104 / yes123 求職平台連結卡片 |
| `4974a41` | fix: 求職平台 logo 圖放大至 100px |
| `237bc80` | fix: product-main-img 有圖時移除 ::after 虛線框 |
| `4e035f0` | feat: header nav 加應用領域連結 + LINE 按鈕改文案 |
| `f55e9b1` | fix: 搜尋結果頁產品卡片加 thumbnail、消息卡片加 cover_image |
