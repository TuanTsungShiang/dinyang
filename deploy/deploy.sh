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

# 1. git pull
echo "[deploy] git pull origin develop..." | tee -a "$LOG"
git pull origin develop >> "$LOG" 2>&1

# 2. composer install
echo "[deploy] composer install..." | tee -a "$LOG"
docker compose exec -T php \
    composer install --no-dev --optimize-autoloader --no-interaction >> "$LOG" 2>&1

# 3. npm build（強制重建，避免 entrypoint 因 public/build 已存在而跳過）
echo "[deploy] npm build..." | tee -a "$LOG"
docker compose exec -T php \
    sh -c "npm ci && npm run build" >> "$LOG" 2>&1

# 4. DB migration
echo "[deploy] migrate..." | tee -a "$LOG"
docker compose exec -T php php artisan migrate --force >> "$LOG" 2>&1

# 5. 重建 cache
echo "[deploy] cache..." | tee -a "$LOG"
docker compose exec -T php php artisan config:cache >> "$LOG" 2>&1
docker compose exec -T php php artisan route:cache  >> "$LOG" 2>&1
docker compose exec -T php php artisan view:cache   >> "$LOG" 2>&1

# 6. reload nginx（config 若有異動才需要，restart 輕量快速）
echo "[deploy] reload nginx..." | tee -a "$LOG"
docker compose restart nginx >> "$LOG" 2>&1

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Deploy finished ✅" | tee -a "$LOG"
