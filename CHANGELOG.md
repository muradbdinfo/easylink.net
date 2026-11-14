# Changelog

## 2026-11-14 — Title Case text

### Changed
- All public text now uses Title Case (first letter of every word capital): headings, buttons, labels, subtitles, paragraphs, FAQ and list items in `config/site_content/*.php`, plus the seeders and the content snapshot (`database/data/`). Links, paths, icons, colours, e-mails and camelCase words (e.g. `eBike`) are untouched.
- "Free installation" is now "Free Installation" everywhere.
- Entertainment cards renamed: "Dhaka Movies", "CTG Movies", "Crazy CTG".
- Local database records (blog posts, FAQs, packages, services, sliders, stats, testimonials) were converted the same way.

### Notes
- Live databases keep saved content over new defaults. To bring the live site in line, edit in Admin or run `php artisan site:export` and deploy the generated migration.

## 2026-11-13 — iq-tel.net-style redesign

### Added
- Home page redesigned after iq-tel.net, keeping EasyLink's logo, blue/navy palette and content: full-width crossfading hero, glass plan card cycling through real home packages (count-up speed, animated ring, order button), plans grid, video/features, interactive services grid, CTA banner, why-choose-us, price promo, entertainment, FAQ + coverage, testimonials with photos, clients marquee, blog with photos.
- Top bar with hotline, email and a **Self Care** pill linking to `https://internet.easyiterp.com/portal/login` (editable in Admin → Page content → Header & footer).
- Speed Test page (embedded fast.com) and Payment page (bKash Send Money / Merchant tabs with copy button and reference steps, Nagad, Rocket, bank). Payment numbers are empty until entered in Admin.
- IQTEL-order menu (Home, About, Our Packages, Speed Test, Payment, Services, Contact), white footer with contact, schedule and short link list.
- Four new services: domain registration & web hosting, IP log server, internet billing software, network consultancy (`ExtraServicesSeeder`).
- Updated package list and prices from the price poster (`UpdatePackagesSeeder`): TURBO … HYPER (home), OPTIMA and ALPHA (corporate).
- Stock photos and portraits in `public/images/stock/`; slider speed fields (migration `add_speed_to_sliders_table`).
- Site-wide scroll-reveal and hover effects (respect reduced motion).

### Changed
- Fonts: Rubik, Roboto, Roboto Slab, Noto Sans/Serif Bengali. Wider page container.
- Logo and favicon regenerated from `public/logo/logo.png`; red/violet accents replaced with logo blues.
- Admin-editable content for all new sections (`config/site_content/`).

### Notes
- Live databases keep saved content over new defaults; run the seeders or edit in Admin.
- Upload box in the hero card mirrors the package speed; hide it with `home.speed.show_upload = 0`.

## Earlier
- 2026-10-28 Facebook link and UI updates · 2026-10-27 dashboard redesign, release-asset deploy · 2026-10-26 public page redesign, Page content admin, TinyMCE · 2026-10-12 EasyLink branding.
