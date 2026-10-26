<?php

/**
 * Post-deploy hook for hosts without SSH/Terminal access (e.g. shared cPanel).
 *
 * The GitHub Actions workflow calls this over HTTPS right after uploading
 * files, so `php artisan migrate --force`, `config:cache`, etc. still run
 * on every deploy even though nobody can open a shell on the server.
 *
 * Protected by a random bearer token stored only in:
 *  - the server's .env as DEPLOY_HOOK_TOKEN
 *  - the GitHub repo secret DEPLOY_HOOK_TOKEN
 * Keep that token secret — anyone with it can trigger migrations on this app.
 *
 * Generate one with: php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
 */

require __DIR__.'/../elbd.net/ftpuser/vendor/autoload.php';

$app = require_once __DIR__.'/../elbd.net/ftpuser/bootstrap/app.php';

/** @var \Illuminate\Foundation\Application $app */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain; charset=utf-8');

$configuredToken = config('app.deploy_hook_token');

if (empty($configuredToken)) {
    http_response_code(503);
    echo "DEPLOY_HOOK_TOKEN is not set in .env on the server. Refusing to run.\n";
    exit;
}

$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$providedToken = '';
if (preg_match('/^Bearer\s+(.+)$/i', $authHeader, $m)) {
    $providedToken = trim($m[1]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $providedToken === '' || ! hash_equals($configuredToken, $providedToken)) {
    http_response_code(403);
    echo "Forbidden.\n";
    exit;
}

// If CI uploaded a deploy archive, extract it over the app root first.
// One zip upload over FTP is dramatically faster than thousands of
// individual file transfers, and doesn't need any shell/SSH access.
$zipPath = base_path('deploy-incoming.zip');

if (file_exists($zipPath)) {
    echo "Extracting deploy-incoming.zip...\n";

    $zip = new ZipArchive;
    $openResult = $zip->open($zipPath);

    if ($openResult !== true) {
        http_response_code(500);
        echo "Failed to open deploy-incoming.zip (error code {$openResult}).\n";
        exit;
    }

    if (! $zip->extractTo(base_path())) {
        http_response_code(500);
        echo "Failed to extract deploy-incoming.zip.\n";
        $zip->close();
        exit;
    }

    $zip->close();
    unlink($zipPath);
    echo "Extracted ".basename($zipPath)." and removed the archive.\n\n";
}

$commands = [
    ['migrate', ['--force' => true]],
    ['storage:link', []],
    ['config:cache', []],
    ['route:cache', []],
    ['view:cache', []],
];

foreach ($commands as [$command, $params]) {
    echo "\$ php artisan {$command}\n";
    $exitCode = Illuminate\Support\Facades\Artisan::call($command, $params);
    echo Illuminate\Support\Facades\Artisan::output();
    echo "(exit code: {$exitCode})\n\n";

    if ($exitCode !== 0) {
        http_response_code(500);
        echo "Stopped: {$command} failed.\n";
        exit;
    }
}

// public_html (this file's own directory, __DIR__) is a separate, non-FTP
// -jailed location from the app root (base_path()). The app's own public/
// folder (build/, images/, logo/, favicon.ico, robots.txt) is the source of
// truth after every deploy; mirror it into __DIR__ so the live site actually
// serves the new assets, without needing a second manual upload each time.
function syncDirRecursive(string $from, string $to): void
{
    if (! is_dir($from)) {
        return;
    }

    if (! is_dir($to)) {
        mkdir($to, 0755, true);
    }

    foreach (scandir($from) as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $src = $from.'/'.$item;
        $dst = $to.'/'.$item;

        if (is_dir($src)) {
            syncDirRecursive($src, $dst);
        } else {
            copy($src, $dst);
        }
    }
}

echo "Syncing public assets into web root...\n";

foreach (['build', 'images', 'logo'] as $dir) {
    syncDirRecursive(base_path('public/'.$dir), __DIR__.'/'.$dir);
    echo "  synced {$dir}/\n";
}

foreach (['favicon.ico', 'robots.txt'] as $file) {
    $src = base_path('public/'.$file);
    if (file_exists($src)) {
        copy($src, __DIR__.'/'.$file);
        echo "  synced {$file}\n";
    }
}

echo "\nDeploy hook finished successfully.\n";
