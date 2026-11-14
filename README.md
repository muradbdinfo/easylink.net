# EasyLink — ISP Website

A modern, English-language website and admin panel for an internet service provider, built with **Laravel 12/13**, **Inertia.js**, **Vue 3** and **Tailwind CSS 4**.

## Features

**Public website**
- iq-tel.net-style home page: full-width crossfading hero slider with a plan card that rotates through the real home packages (animated speed ring), plans, video/features, services grid, CTA banner, why-choose-us, FAQ + coverage, testimonials, clients and blog
- Top bar with hotline, email and a **Self Care** button (customer portal login)
- Speed test page (embedded fast.com)
- Payment page: bKash (Send Money / Merchant), Nagad, Rocket and bank details
- Scroll-reveal and hover effects across the whole site
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

**Page content** — every text, link, menu item, hero image and payment number is editable in Admin → Page content (schema files in `config/site_content/`). Nothing is hard-coded. **Text style:** write all public text in Title Case (every word starts with a capital letter, e.g. "Free Installation", "Get A Quote").

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

Optional live-safe data updates (no data loss):

```bash
php artisan db:seed --class=UpdatePackagesSeeder   # current home/corporate package prices
php artisan db:seed --class=ExtraServicesSeeder    # domain & hosting, IP log server, billing software, consultancy
```

Seeded admin login: `admin@elbd.net` / `password` — **change this immediately in production.**

## Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md). Content saved in the live Admin overrides the defaults in `config/site_content/`, so changed defaults only show up where no value was saved.

## License

MIT
