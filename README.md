# EasyLink — ISP Website

A modern, English-language website and admin panel for an internet service provider, built with **Laravel 12/13**, **Inertia.js**, **Vue 3** and **Tailwind CSS 4**.

## Features

**Public website**
- Hero slider, live stats, home/corporate package cards, services, testimonials, clients & partners, blog teaser
- Packages page (Home / Corporate toggle) with "Order now" pre-filling the contact form
- Corporate solutions page
- Services listing and detail pages
- Coverage checker (district → thana/upazila availability)
- Blog with pagination and detail pages
- About page with stats, partners and FAQ accordion
- Contact / quote form saved to the admin inbox

**Admin panel** (`/admin`)
- Dashboard with totals and recent messages
- CRUD for sliders, packages, services, blog posts, testimonials, clients/partners, coverage areas, FAQs and stats
- Contact message inbox (mark as read / delete)
- Site settings (name, tagline, contact info, logo, social links, about text)

**Auth** — Laravel Breeze (login, password reset, profile)

## Getting started

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# configure DB_* in .env, then:
php artisan migrate --seed
npm run dev        # or: npm run build
php artisan serve
```

Seeded admin login: `admin@elbd.net` / `password` — **change this immediately in production.**

## Deployment

`.github/workflows/deploy.yml` builds the app and deploys to cPanel over FTP on every push to `main`. It needs these repository secrets: `FTP_USERNAME`, `FTP_PASSWORD`, `FTP_SERVER`, `FTP_SERVER_DIR`, `DEPLOY_HOOK_URL`, `DEPLOY_HOOK_TOKEN`.

## License

MIT
