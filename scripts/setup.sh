#!/usr/bin/env bash
set -e

APP_NAME=${1:-myapp}

echo ">> Creating Laravel app: $APP_NAME"
composer create-project laravel/laravel "$APP_NAME"
cd "$APP_NAME"

echo ">> Requiring packages"
composer require beyondcode/laravel-websockets:^1.16 minishlink/web-push:^9.0 box/spout:^4.6
composer require predis/predis --dev || true

echo ">> NPM deps"
npm install laravel-echo pusher-js

echo ">> Copying overlay"
OVERLAY_DIR="$(cd "$(dirname "$0")/.." && pwd)"
rsync -a "$OVERLAY_DIR/app/" app/ || true
rsync -a "$OVERLAY_DIR/config/" config/ || true
rsync -a "$OVERLAY_DIR/database/" database/ || true
rsync -a "$OVERLAY_DIR/resources/" resources/ || true
rsync -a "$OVERLAY_DIR/routes/" routes/ || true
rsync -a "$OVERLAY_DIR/public/" public/ || true
rsync -a "$OVERLAY_DIR/tests/" tests/ || true

echo ">> Update composer.json (scripts)"
php -r '
$j=json_decode(file_get_contents("composer.json"),true);
$j["scripts"]["post-root-package-install"]=["php -r \"file_exists(\\\".env\\\") || copy(\\\".env.example\\\", \\\".env\\\");\""];
$j["scripts"]["post-create-project-cmd"]=["php artisan key:generate --ansi"];
file_put_contents("composer.json",json_encode($j,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
'

echo ">> ENV updates"
php -r '
$env = file_get_contents(".env");
$add = "\nBROADCAST_DRIVER=pusher\nQUEUE_CONNECTION=database\n\nPUSHER_APP_ID=app-id\nPUSHER_APP_KEY=app-key\nPUSHER_APP_SECRET=app-secret\nPUSHER_HOST=127.0.0.1\nPUSHER_PORT=6001\nPUSHER_SCHEME=http\nPUSHER_APP_CLUSTER=mt1\n\nVAPID_PUBLIC_KEY=\nVAPID_PRIVATE_KEY=\n";
file_put_contents(".env",$env.$add);
'

echo ">> Publish websockets config & migrations"
php artisan vendor:publish --provider="BeyondCode\\LaravelWebSockets\\WebSocketsServiceProvider" --force

echo ">> Migrate & seed"
php artisan migrate
php artisan db:seed

echo ">> Build"
php artisan storage:link
npm run build || npm run dev

echo ">> Done. Start services:"
echo "php artisan websockets:serve"
echo "php artisan queue:work"
echo "php artisan serve"
