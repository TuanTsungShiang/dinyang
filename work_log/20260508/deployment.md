# 部署到 dev 主機 — 連續踩雷集

> 時間：2026-05-08 晚上
> 結果：✅ Filament admin 在 https://dev-dinyang.ezweb356.online/admin 正式登入成功

---

## 戰場時間軸

從「執行部署指令」到「Super Admin 登入後台」總共踩了 **5 個雷**，每個都堵住，最後一個個拆。

### 戰場 1：composer install 失敗 — PHP container 缺擴充

**症狀**：
```
filament/support v3.3.50 requires ext-intl * → 缺
openspout/openspout v4.28.5 requires ext-zip * → 缺
```

**根因**：原本的 `docker/php/Dockerfile` 只安裝 `pdo / pdo_mysql / gd / exif / pcntl / bcmath`，沒包含 Filament 必要的 `intl` 跟 `zip` 兩個擴充。

**修復**（commit `185f2ec`）：Dockerfile 補
- `apk add icu-dev libzip-dev`（Alpine 對應的 dev libraries）
- `docker-php-ext-install intl zip`（編譯擴充）

`docker-compose build php` 重 build image，編譯 7 個擴充約 3-5 分鐘（intl 用到 ICU 是大坨）。

---

### 戰場 2：容器卡 restart loop

**症狀**：build 完 image、`docker-compose up -d` 起來後，再跑 composer install，這次不是 platform check 錯，而是：

```
In AdminPanelProvider.php line 21:
  Class "Filament\PanelProvider" not found
```

接著容器死掉，Docker `restart: unless-stopped` 把它拉起來，重啟又跑 composer install 又掛 → **死循環**，連 `docker exec` 都打不進去：

```
Error response from daemon: Container ... is restarting, wait until the container is running
```

**根因**：
- 之前 composer install 失敗時 vendor 已進到半灌狀態（部分 Filament 套件下載了，但 filament/support 沒裝）
- 即使 ext-intl / ext-zip 補上了，半灌的 vendor 觸發 composer 的 post-autoload-dump 鉤子 → 自動跑 `php artisan package:discover`
- AdminPanelProvider extends 不存在的 `Filament\PanelProvider`（因為 filament/support 沒裝）→ exception
- entrypoint.sh 的 `set -e` 讓任何錯誤都讓 script exit
- 容器退出 → Docker 自動重啟 → 再跑一次

**修復**：
1. `docker-compose stop php` 停掉迴圈
2. 用 `docker-compose run --rm --entrypoint sh php -c "rm -rf vendor && composer install --no-scripts"` 跑一次性容器修 vendor
   - `--entrypoint sh` 繞過 entrypoint.sh
   - `--no-scripts` 跳過會失敗的 post-install 腳本
3. `docker-compose up -d php` 重啟原容器（這次 entrypoint 看到 vendor 存在會跳過 composer install）
4. 手動 `php artisan package:discover --ansi` 補回剛跳過的步驟
5. `composer dump-autoload --optimize` 重新生 autoload

**踩雷教訓**：composer install 的 post-autoload-dump 預設會自動觸發 `php artisan package:discover`，如果套件相依沒灌齊就 chain reaction 整個 abort。`--no-scripts` 是保命用的，部署 Filament 這種「安裝 + 自動註冊 provider」的套件時要記得用。

---

### 戰場 3：登入 405 Method Not Allowed

**症狀**：成功進 `/admin/login` 看到 Filament 表單，但輸入帳密按下登入後跳出 Laravel debug 頁：

```
Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
The POST method is not supported for route admin/login. Supported methods: GET, HEAD.
```

注意 error 顯示的 URL 是 `http://...` 不是 `https://...`。

**根因鏈（4 層）**：
1. Cloudflare → origin 走 HTTP（Flexible SSL 場景）
2. Laravel 預設不信任 X-Forwarded-Proto: https header → 看不到真實 https scheme
3. Laravel 產生的 asset URL 全是 `http://`，但用戶在 `https://` 頁面 → 瀏覽器 mixed-content 擋掉
4. Livewire JS 沒載 → 登入 form fallback 成 HTML form POST → Filament 沒註冊這條 POST 路由 → 405

**修復嘗試**：
- **第一次**（沒解）：改 `web/.env` 的 `APP_URL=http://...` 為 `https://...`，`config:clear`。
  - 結果：Laravel 知道 APP_URL 是 https，但實際 request 進來的 scheme 還是 http（Cloudflare 那段），所以動態判斷的 URL 還是錯。
- **第二次**（成功 — commit `10ea7f8`）：`web/bootstrap/app.php` 的 `withMiddleware` 加 `$middleware->trustProxies(at: '*');`，讓 Laravel 信任 Cloudflare 帶的所有 X-Forwarded-* headers。

**踩雷教訓**：Cloudflare Flexible SSL 場景下 trustProxies 是必須的，光改 APP_URL 不夠。

---

### 戰場 4：livewire.js 還是 404

**症狀**：trustProxies 修好後重新登入，Console 還是看到：
```
livewire.js: Failed to load resource: the server responded with a status of 404
```

**診斷過程**：
1. `php artisan route:list --path=livewire` → 5 條 livewire 路由都存在 ✓
   ```
   GET   livewire/livewire.js
   GET   livewire/livewire.min.js.map
   POST  livewire/update
   POST  livewire/upload-file
   ```
2. 從 php container 內 `wget http://nginx/livewire/livewire.js` → **HTTP/1.1 200 OK** 387252 bytes ✓
3. 結論：origin 端 100% 正常，問題在中間層

**根因**：`docker/nginx/default.conf` 有：
```nginx
location ~* \.(css|js|png|jpg|...)$ {
    expires 30d;
    add_header Cache-Control "public, no-transform";
    try_files $uri =404;
}
```
這條 regex（優先級高於 prefix match）把所有 `.js` 結尾的 request 都進來，找不到實體檔就直接 404，**不 fallback 給 Laravel**。`/livewire/livewire.js` 是動態回傳的，沒實體檔，所以 nginx 直接 404 沒讓 PHP 處理。

**修復**（commit `dc591df`）：把 `try_files $uri =404` 改成 `try_files $uri /index.php?$query_string`。靜態檔仍 nginx 直送，找不到才 fallback Laravel。

`docker-compose restart nginx` 即可生效（config 是 mount 的，不用 rebuild image）。

---

### 戰場 5：Cloudflare cache 吃住舊 404

**症狀**：nginx 修好後，從 host curl 確認 origin 是 200 OK，但瀏覽器還是 404。

**根因**：Cloudflare 預設 cache 靜態副檔名（`.js / .css` 等）的 response，**包括 404 response**。之前 nginx 還沒修好時的 404 已被 Cloudflare cache 起來，即使 origin 修好回 200，CDN 仍吐舊的 404 給瀏覽器。

**修復**：Cloudflare dashboard → `ezweb356.online` → Caching → Configuration → **Purge Everything** 一鍵清掉。

**長期解（待補）**：加 Cache Rule 把 `/livewire/*`、`/admin/*` 設為 Bypass cache，永絕後患（動態內容本來就不該 cache）。

---

## 終局

清完 Cloudflare cache、瀏覽器 Ctrl+Shift+R 重整 → Filament 登入頁正常 → 輸入剛在 VM 建的 admin user → **進入 Dashboard，看到「Super Admin」歡迎卡** 🎉

7 個 Resource 全部在 sidebar 出現：
- Product Categories
- Application Areas
- News Categories
- Hero Slides
- Products
- News
- Inquiries

CRUD 都通。

---

## 部署期間的 commit

| Hash | 訊息 |
|---|---|
| `185f2ec` | fix: PHP container 加 ext-intl 與 ext-zip 滿足 Filament 依賴 |
| `10ea7f8` | fix: 信任所有 proxy 讓 Cloudflare X-Forwarded-Proto 生效 |
| `dc591df` | fix: nginx 靜態資源 location 找不到檔案時 fallback 到 Laravel |

---

## 寫入 memory 的 4 條新踩雷紀錄

存進 [`project_deployment_gotchas.md`](../../../../../Users/ruby0/.claude/projects/c--code-dinyang/memory/project_deployment_gotchas.md)：

5. **部署 Filament 時容器卡 restart loop** — 缺擴充 + entrypoint set -e + restart unless-stopped 死循環
6. **Cloudflare Flexible SSL → 必須 trustProxies(at: '*')** — 否則 Laravel 看不到 https，asset URL 全錯
7. **nginx static asset location 要 fallback /index.php** — 不要 `=404`，否則動態 .js 路由全擋
8. **Cloudflare 會 cache .js 的 404 response** — 修好 origin 後要 purge 或加 Bypass cache rule

---

## 經驗值統計

- 總戰場：5
- 修了多少設定檔：4（Dockerfile / bootstrap/app.php / nginx default.conf / .env）
- 最久卡關：戰場 4（livewire.js 404，繞了 nginx + cf cache 兩層才搞定）
- 最坑：戰場 2（restart loop 連 exec 都進不去，要繞 entrypoint）

---

## 下一步（明天）

1. **Cloudflare Cache Rule** — 加 `/livewire/*`、`/admin/*` Bypass，避免下次 cache 又咬人
2. **Phase 2 — Filament Resource 客製化**
   - 全站文案中文化（locale=zh_TW + 各 Resource 加 navigationLabel / modelLabel / 欄位 ->label()）
   - Dashboard widgets 改寫（拿掉 FilamentInfoWidget、加自訂統計）
   - 品牌色 / logo / 字型對齊定陽
   - JSON 欄位用 Repeater、Inquiries status 用 BadgeColumn 等
3. **Phase 3 — 前台 Blade 動態化**
   - 寫 controllers，把 hardcode 的內容換成 DB query
   - 聯絡表單 POST 真的寫進 inquiries 表
   - 從 News + Hero 開始（簡單）→ Products（複雜）

預估 Phase 2 + 3 共 6-10 hr 工程，可分 2-3 天完成。
