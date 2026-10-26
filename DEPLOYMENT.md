# Deploying Laravel + Inertia to Shared cPanel (No SSH)

> **In one sentence:** push to GitHub → it builds your app → uploads it over FTP → a small PHP script on the server finishes the job (migrations, caching, moving files into place). No terminal, no SSH, no manual uploads after the first setup.

This guide is written from a real deployment (`muradbdinfo/easylink.net` → `elbd.net`), including every mistake that was hit and how it was actually diagnosed and fixed. Use it as a checklist for a new project, or as a script if you're recording a tutorial from it.

---

## Table of contents

1. [The problem, in plain terms](#1-the-problem-in-plain-terms)
2. [What you'll need before starting](#2-what-youll-need-before-starting)
3. [One-time setup: cPanel](#3-one-time-setup-cpanel)
4. [One-time setup: GitHub](#4-one-time-setup-github)
5. [The deploy-hook.php script](#5-the-deploy-hookphp-script)
6. [Database: migrate vs. real content](#6-database-migrate-vs-real-content)
7. [Day-to-day workflow](#7-day-to-day-workflow)
8. [Troubleshooting playbook](#8-troubleshooting-playbook)

---

## 1. The problem, in plain terms

Most cheap/shared cPanel hosting gives you **no SSH or Terminal access**. That means you normally can't run the commands a Laravel app needs on the server itself:

- `composer install` (installs PHP packages)
- `npm run build` (builds the frontend)
- `php artisan migrate` (creates database tables)
- `php artisan config:cache` (speeds the app up)

This guide's fix: do all of that **before** it reaches the server (on GitHub's servers, for free, automatically), then hand the server only two things: the finished files, and a tiny PHP script that can run the last few database/cache commands by itself — because PHP scripts *can* run on the server even without a terminal.

```
git push  →  GitHub Actions builds everything  →  uploaded over FTP  →  deploy-hook.php finishes the job
```

---

## 2. What you'll need before starting

- [ ] A GitHub repository for the project
- [ ] cPanel login for the hosting account
- [ ] An FTP account (cPanel → FTP Accounts) — note its **host**, **username**, **password**, and which folder it actually opens into (this trips people up — see [Step 3](#3-one-time-setup-cpanel))
- [ ] A MySQL database created in cPanel (cPanel → MySQL Databases)
- [ ] 15–20 minutes for the one-time setup (Steps 3–4). After that, every future deploy is one command.

---

## 3. One-time setup: cPanel

### 3.1 Understand your folder layout first

This is the single most confusing part, so read it before touching anything.

**`public_html`** is the folder your website actually serves from. **Your FTP account's folder is usually a *different* folder** — FTP often cannot reach `public_html` at all, only cPanel's File Manager can write there. Check this with your FTP client, or with:

```bash
curl --ftp-ssl "ftp://your-ftp-host/" --user "username:password" --list-only
```

If what you see isn't `public_html`'s contents, you have two separate folders — exactly the setup this guide assumes:

```
/home/youraccount/
├── public_html/              ← the real website (only File Manager can reach this)
│   ├── index.php             ← small, edited to point at the app folder below
│   ├── deploy-hook.php       ← the automation script
│   ├── build/ images/ logo/  ← copies of your compiled frontend (kept in sync automatically)
│   └── .htaccess
│
└── your-app-folder/          ← where FTP actually uploads to = your whole Laravel app
    ├── app/ config/ database/ resources/ routes/ storage/ vendor/
    ├── artisan, composer.json, composer.lock
    ├── public/                ← Laravel's own public folder (the "source of truth")
    └── .env                   ← lives ONLY here, never uploaded automatically
```

### 3.2 Steps

1. **Confirm the PHP version.** cPanel → MultiPHP Manager → set the version your `composer.json` requires (e.g. PHP 8.3+).
2. **Move `public/`'s contents (not the folder) up into `public_html`.** Then edit `public_html/index.php` so its two `require` lines point at your real app folder instead of the default `../vendor` path.
3. **Create the database.** cPanel → MySQL Databases → note the database name, username and password.
4. **Hand-upload a `.env` file** straight into the app folder (not through any automated process — see [Step 4](#4-one-time-setup-github)) with your real database details and a random `DEPLOY_HOOK_TOKEN`.

> ⚠️ **Gotcha worth knowing in advance:** cPanel's MultiPHP Manager secretly writes a "which PHP version to use" line into `public_html/.htaccess`. If you later replace that whole file with Laravel's normal rewrite rules, you accidentally delete that line too — and the site falls back to an old PHP version, breaking *everything*, even plain files like `robots.txt`. **If a totally static file 500-errors, this is almost always why.** Fix: keep both the PHP-version line and Laravel's rewrite rules in the same `.htaccess`, and re-apply the PHP version in MultiPHP Manager after any `.htaccess` change.

---

## 4. One-time setup: GitHub

Create `.github/workflows/deploy.yml` in your repo:

```yaml
name: Deploy to cPanel
on:
  push:
    branches: [main]
  workflow_dispatch: {}   # lets you trigger a deploy manually from GitHub too
jobs:
  build-and-deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: "8.4" }
      - run: composer install --no-dev --optimize-autoloader --no-interaction
      - uses: actions/setup-node@v4
        with: { node-version: "20", cache: "npm" }
      - run: npm ci
      - run: npm run build
      - name: Create deploy archive
        run: |
          zip -rq "$RUNNER_TEMP/deploy-incoming.zip" . \
            -x ".git/*" ".github/*" "node_modules/*" "tests/*" \
            -x ".env" ".env.example" \
            -x "storage/framework/cache/*" "storage/framework/sessions/*" "storage/framework/views/*"
      - name: Upload via FTP
        run: |
          curl --ftp-ssl -k --fail-with-body -sS \
            -T "$RUNNER_TEMP/deploy-incoming.zip" \
            --user "${{ secrets.FTP_USERNAME }}:${{ secrets.FTP_PASSWORD }}" \
            "ftp://${{ secrets.FTP_SERVER }}${{ secrets.FTP_SERVER_DIR }}deploy-incoming.zip"
      - name: Run deploy hook
        run: |
          curl --fail-with-body -sS -X POST \
            -H "Authorization: Bearer ${{ secrets.DEPLOY_HOOK_TOKEN }}" \
            "${{ secrets.DEPLOY_HOOK_URL }}"
```

Then add 6 secrets in **GitHub repo → Settings → Secrets and variables → Actions**:

| Secret | What to put there |
| --- | --- |
| `FTP_SERVER` | FTP host, e.g. `ftp.example.com` |
| `FTP_USERNAME` | your FTP account's username |
| `FTP_PASSWORD` | its password |
| `FTP_SERVER_DIR` | folder to upload into — often just `/` if the FTP account already opens straight into the app folder ([check with `--list-only`](#31-understand-your-folder-layout-first)) |
| `DEPLOY_HOOK_URL` | the public web address of `deploy-hook.php`, e.g. `https://example.com/deploy-hook.php` |
| `DEPLOY_HOOK_TOKEN` | a random secret string (generate with `php -r "echo bin2hex(random_bytes(32));"`) — must be the exact same value as `DEPLOY_HOOK_TOKEN` in the server's `.env` |

**If the FTP step fails from GitHub but works from your own computer:** some hosts block or slow down traffic specifically from cloud servers like GitHub's. In that case just run the upload command yourself from your own PC — it's the same `curl` command, only run manually (see [Day-to-day workflow](#7-day-to-day-workflow)).

---

## 5. The deploy-hook.php script

This file lives in `public_html`, right beside `index.php`. It does four things, in order:

1. Checks a secret token so random visitors can't trigger it
2. Unzips the uploaded files into place
3. Runs the database/cache commands a terminal normally would
4. Copies the app's compiled frontend into `public_html` (since FTP can't reach `public_html` directly — this is what means you never have to manually re-upload a build folder again)

```php
<?php

require __DIR__.'/../<your-app-folder>/vendor/autoload.php';
$app = require_once __DIR__.'/../<your-app-folder>/bootstrap/app.php';

/** @var \Illuminate\Foundation\Application $app */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain; charset=utf-8');

// config(), NOT env() — env() stops reading .env once config:cache has
// run (which this very script triggers below), so a second deploy would
// otherwise always fail this check.
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

$zipPath = base_path('deploy-incoming.zip');

if (file_exists($zipPath)) {
    $zip = new ZipArchive;
    if ($zip->open($zipPath) === true) {
        $zip->extractTo(base_path());
        $zip->close();
        unlink($zipPath);
        echo "Extracted deploy-incoming.zip.\n\n";
    }
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
    if ($exitCode !== 0) {
        http_response_code(500);
        echo "Stopped: {$command} failed.\n";
        exit;
    }
}

// Copy the app's public/ assets into this file's own folder (public_html),
// which FTP alone can't reach on a jailed account.
function syncDirRecursive(string $from, string $to): void
{
    if (! is_dir($from)) return;
    if (! is_dir($to)) mkdir($to, 0755, true);
    foreach (scandir($from) as $item) {
        if ($item === '.' || $item === '..') continue;
        $src = $from.'/'.$item;
        $dst = $to.'/'.$item;
        is_dir($src) ? syncDirRecursive($src, $dst) : copy($src, $dst);
    }
}

foreach (['build', 'images', 'logo'] as $dir) {
    syncDirRecursive(base_path('public/'.$dir), __DIR__.'/'.$dir);
}
foreach (['favicon.ico', 'robots.txt'] as $file) {
    $src = base_path('public/'.$file);
    if (file_exists($src)) copy($src, __DIR__.'/'.$file);
}

echo "\nDeploy hook finished successfully.\n";
```

**Two small things this script needs elsewhere:**

- In `config/app.php`, add: `'deploy_hook_token' => env('DEPLOY_HOOK_TOKEN'),` — this is what lets `config('app.deploy_hook_token')` above keep working even after caching.
- Replace `<your-app-folder>` in the two `require` lines with the real relative path from `public_html` to your app folder.

**To run it manually any time** (e.g. right after the one-time setup, before your first automated push):

```bash
curl -X POST -H "Authorization: Bearer <your-token>" https://example.com/deploy-hook.php
```

---

## 6. Database: migrate vs. real content

**Important distinction:** `php artisan migrate` only creates *empty tables* — it never copies your actual data (admin users, saved content, settings). If your local project already has real content in it, you need one extra manual step, once:

```bash
mysqldump -h127.0.0.1 -uroot \
  --no-create-info --no-tablespaces --skip-add-locks --single-transaction \
  --ignore-table=<db>.cache --ignore-table=<db>.sessions \
  --ignore-table=<db>.migrations --ignore-table=<db>.jobs \
  <your_local_database> > data-backup.sql
```

Then import `data-backup.sql` through **cPanel → phpMyAdmin → Import** on the production database. (Shared hosts almost always lock MySQL to local connections only — phpMyAdmin, running on the server itself, is the only way in without SSH.)

**For a later content update** (prices changed, new pages added), be careful: if you deleted old rows locally and created new ones, they'll have different IDs — importing just the new rows will *add* them next to the old ones instead of replacing them. Either explicitly `DELETE` the old rows too, or keep the same IDs so the import genuinely overwrites them.

---

## 7. Day-to-day workflow

Once the setup above is done, shipping any future change is simply:

```bash
git add -A
git commit -m "your message"
git push origin main
```

GitHub builds it, uploads it, and `deploy-hook.php` finishes the rest — automatically. The only time you still need to touch cPanel directly is for actual database **content** changes (not schema), which still need the export/import step in [Section 6](#6-database-migrate-vs-real-content).

**If GitHub's automated FTP step is unreliable on your host**, run the same thing from your own computer instead:

```bash
composer install --no-dev --optimize-autoloader
npm run build
zip -r deploy-incoming.zip . -x ".git/*" "node_modules/*" ".env"
curl --ftp-ssl -T deploy-incoming.zip "ftp://<server><folder>/deploy-incoming.zip" --user "<user>:<pass>"
curl -X POST -H "Authorization: Bearer <token>" https://example.com/deploy-hook.php
```

---

## 8. Troubleshooting playbook

Real errors hit while building this pipeline, and what they actually meant — most of these looked nothing like their real cause at first glance.

| What you see | What's actually wrong | How to fix it |
| --- | --- | --- |
| **404** when calling `deploy-hook.php` | The file hasn't landed in `public_html` yet — often it's one folder too deep (e.g. still inside `public_html/public/`) | Move it so it sits directly in `public_html` |
| **500**, and even a plain `.txt` file also 500s | `public_html/.htaccess` is broken, or is missing cPanel's PHP-version line (see the [gotcha in Step 3](#32-steps)) | Put both the PHP-version line and Laravel's rewrite rules back in `.htaccess`; re-apply the PHP version in MultiPHP Manager |
| `Fatal error: require(.../vendor/autoload.php): No such file` | The `require` path in `deploy-hook.php`/`index.php` still assumes the old folder layout | Point the `require` lines at your real app folder explicitly |
| `Composer detected issues... requires PHP >= 8.4, running 8.0.x` | The PHP version you set didn't actually take effect yet (often caused by the `.htaccess` gotcha above wiping it) | Re-apply the PHP version in MultiPHP Manager, then test again |
| Deploy hook always says `DEPLOY_HOOK_TOKEN is not set`, even though `.env` has it | `env()` stops reading `.env` after `config:cache` runs (which the hook itself does) — so it works once, then fails forever after | Read the token with `config('app.deploy_hook_token')` instead, backed by the `config/app.php` line in [Step 5](#5-the-deploy-hookphp-script) |
| Homepage loads but is **blank/white**, no visible errors | The page is asking for a JS file that doesn't actually exist at that address yet (an incomplete upload) | Check the exact file the page references with `curl -o /dev/null -w "%{http_code}" <url>`; re-sync the `build/` folder |
| Old *and* new data both show up after importing | An update-style import only touches matching IDs — brand-new rows just get added alongside the old ones | Delete the old rows explicitly (by name or another stable column), separately from adding the new ones |
| FTP works from your own PC but times out from GitHub | Some hosts block traffic from cloud/CI servers specifically — it's not an FTP account problem | Just run deploys manually from your own computer (see [Section 7](#7-day-to-day-workflow)) |

**The technique that found most of these:** test the live URL directly with `curl -i` (bypasses browser cache, shows real status codes), and when you get a blank/generic error page, temporarily add this to the very top of the suspect PHP file to see the real error instead of a canned one:

```php
ini_set('display_errors', '1');
error_reporting(E_ALL);
```
