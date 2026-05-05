#!/bin/sh
set -e

# 安裝 composer 依賴（首次部署或 vendor 不存在時）
if [ ! -d "vendor" ]; then
    echo "[entrypoint] 安裝 composer 依賴..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# 建置前端資源（dist 不存在時）
if [ ! -d "public/build" ]; then
    echo "[entrypoint] 建置前端資源..."
    npm ci && npm run build && rm -rf node_modules
fi

# 設定目錄權限
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 建立 storage 符號連結（若不存在）
php artisan storage:link --force 2>/dev/null || true

# 執行資料庫 migration
echo "[entrypoint] 執行 migration..."
php artisan migrate --force

# 清除並重建 cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[entrypoint] 啟動 php-fpm..."
exec "$@"
