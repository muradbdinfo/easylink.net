# Changelog

## 2026-11-16 — Bangla QR on Payment page

### Added
- New "Bangla QR" section on `/payment` showing the Send Money and Merchant Payment QR codes side by side (tap to enlarge). QR images live in `public/banglaqr/`.
- Heading, text, both pictures, titles and captions are editable in Admin → Page content → Payment → "Bangla QR".

## 2026-11-15 — Live content overrides reset

### Fixed
- Entertainment cards (and any other Page content) saved earlier in the live Admin kept their old capitalisation, because saved values override config defaults. New migration `2026_11_15_000002_reset_old_cased_content_overrides` removes a saved value only when it matches the current default apart from case/spacing (e.g. "Browse movies", "DhakaMovies"), so the Title Case default shows. Text the owner really rewrote is left alone.

## 2026-11-15 — About text Title Case

### Changed
- The About paragraph (`about_text`) is now Title Case in `DatabaseSeeder` and the content snapshot.
- New migration `2026_11_15_000001_title_case_about_text` updates the live setting, but only if it still holds the untouched default text (case-insensitive); text edited in Admin is never overwritten.

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
