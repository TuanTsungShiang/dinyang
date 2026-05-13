#!/bin/bash
set -euo pipefail

# ── 路徑設定 ────────────────────────────────────────────────
APP_DIR="$(cd "$(dirname "$0")/.." && pwd)"   # repo 根目錄
LOG="$APP_DIR/deploy/deploy.log"

# ── 開始 ────────────────────────────────────────────────────
echo "" >> "$LOG"
echo "=============================================" >> "$LOG"
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Deploy started" >> "$LOG"

cd "$APP_DIR"

# 1. git pull（先記住舊的 HEAD，之後用來 diff）
echo "[deploy] git pull origin develop..." | tee -a "$LOG"
OLD_HEAD=$(git rev-parse HEAD)
git pull origin develop >> "$LOG" 2>&1
NEW_HEAD=$(git rev-parse HEAD)

# 2. composer install（只在 composer.json / composer.lock 有變動時才跑）
if git diff "$OLD_HEAD" "$NEW_HEAD" --name-only | grep -qE '^web/composer\.(json|lock)$'; then
    echo "[deploy] composer changed → composer install..." | tee -a "$LOG"
    docker compose exec -T php \
        composer install --no-dev --optimize-autoloader --no-interaction >> "$LOG" 2>&1
else
    echo "[deploy] composer 無異動，跳過" | tee -a "$LOG"
fi

# 3. npm build（只在前端相關檔案有變動時才跑）
FRONTEND_PATTERN='^web/(resources/|package\.json|package-lock\.json|vite\.config)'
if git diff "$OLD_HEAD" "$NEW_HEAD" --name-only | grep -qE "$FRONTEND_PATTERN"; then
    echo "[deploy] 前端檔案有異動 → npm build..." | tee -a "$LOG"
    docker compose exec -T php sh -c "npm ci && npm run build" >> "$LOG" 2>&1
else
    echo "[deploy] 前端無異動，跳過 npm build" | tee -a "$LOG"
fi

# 4. DB migration
echo "[deploy] migrate..." | tee -a "$LOG"
docker compose exec -T php php artisan migrate --force >> "$LOG" 2>&1

# 5. 重建 cache
echo "[deploy] cache..." | tee -a "$LOG"
docker compose exec -T php php artisan config:cache >> "$LOG" 2>&1
docker compose exec -T php php artisan route:cache  >> "$LOG" 2>&1
docker compose exec -T php php artisan view:cache   >> "$LOG" 2>&1

# 6. nginx reload（只在 nginx config 有異動時）
if git diff "$OLD_HEAD" "$NEW_HEAD" --name-only | grep -qE '^docker/nginx/'; then
    echo "[deploy] nginx config 有異動 → restart nginx..." | tee -a "$LOG"
    docker compose restart nginx >> "$LOG" 2>&1
else
    echo "[deploy] nginx config 無異動，跳過" | tee -a "$LOG"
fi

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Deploy finished ✅" | tee -a "$LOG"

