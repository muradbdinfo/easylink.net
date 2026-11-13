<?php

/*
 * Home page content. Everything that is not a database record (sliders, packages, services, stats,
 * testimonials, clients, blog posts) is edited here — see resources/js/Pages/Home.vue.
 */

$heading = function (string $key, string $eyebrow, string $title, ?string $subtitle = null): array {
    $fields = [
        "$key.eyebrow" => ['label' => 'Small tag above the heading', 'type' => 'text', 'default' => $eyebrow],
        "$key.title" => ['label' => 'Heading', 'type' => 'text', 'default' => $title],
    ];

    if ($subtitle !== null) {
        $fields["$key.subtitle"] = ['label' => 'Subtitle', 'type' => 'textarea', 'default' => $subtitle];
    }

    return $fields;
};


$heroPictures = ['family-sofa', 'team-office', 'father-son-tv', 'support-agent', 'couple-tablet', 'man-laptop-home'];
$hero = [];
for ($i = 1; $i <= 6; $i++) {
    $hero["home.hero.image_$i"] = ['label' => "Default slider picture $i", 'type' => 'image', 'default' => '/images/stock/'.$heroPictures[$i - 1].'.jpg'];
}
$hero['home.hero.image_1']['help'] = 'Shown behind slide 1, 2, 3… when a slider has no picture of its own (slide 7 starts again from picture 1). Wide picture, at least 1600px.';

return [
    'page' => 'Home',
    'sections' => [
        [
            'title' => 'Hero slider',
            'fields' => [
                'home.hero.badge' => ['label' => 'Badge text', 'type' => 'text', 'default' => 'BTRC-approved zonal ISP'],
                ...$hero,
                'home.hero.price' => ['label' => 'Price under the heading', 'type' => 'text', 'default' => '', 'help' => 'Leave empty to show the cheapest home package automatically.'],
                'home.hero.price_unit' => ['label' => 'Text after the price', 'type' => 'text', 'default' => '/Month'],
                'home.hero.phone_label' => ['label' => 'Label above the hotline number', 'type' => 'text', 'default' => 'Customer Service:'],
                'home.hero.coverage_button' => ['label' => '"Check coverage" button label', 'type' => 'text', 'default' => 'Check coverage'],
            ],
        ],
        [
            'title' => 'Hero — plan card (real packages)',
            'fields' => [
                'home.speed.title' => ['label' => 'Card title', 'type' => 'text', 'default' => 'Our plans', 'help' => 'The card shows the real home packages one after another (name, price, speed). Edit them in Admin → Packages.'],
                'home.speed.status' => ['label' => 'Small status text (empty hides it)', 'type' => 'text', 'default' => ''],
                'home.speed.prefix' => ['label' => 'Small text above the number', 'type' => 'text', 'default' => 'Up to'],
                'home.speed.download' => ['label' => 'Download label', 'type' => 'text', 'default' => 'Download'],
                'home.speed.upload' => ['label' => 'Upload label', 'type' => 'text', 'default' => 'Upload'],
                'home.speed.show_upload' => ['label' => 'Show the upload box (1 = yes, 0 = no)', 'type' => 'text', 'default' => '1', 'help' => 'Packages only store one speed. The upload box shows the same speed, so type 0 if your upload is different.'],
                'home.speed.order_button' => ['label' => 'Order button', 'type' => 'text', 'default' => 'Order now'],
                'home.speed.badge_title' => ['label' => 'Bottom line — bold part (empty hides the line)', 'type' => 'text', 'default' => 'Free installation'],
                'home.speed.badge_text' => ['label' => 'Bottom line — rest of the text', 'type' => 'text', 'default' => 'on all home plans'],
            ],
        ],
        [
            'title' => 'Plans section',
            'fields' => [
                ...$heading('home.plans', 'Home internet', 'Simple plans. Unlimited fiber.', 'Pick the speed that fits your household. No data caps, no hidden fees.'),
                'home.plans.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/plans-bg.jpg'],
                'home.plans.button' => ['label' => '"View all" button label', 'type' => 'text', 'default' => 'View all packages'],
            ],
        ],
        [
            'title' => 'Services section',
            'fields' => [
                ...$heading('home.services', 'What we do', 'Everything connectivity, one provider', 'From the living room to the data center — complete solutions under one roof.'),
                'home.services.button' => ['label' => '"All services" button label (empty hides it)', 'type' => 'text', 'default' => 'View all services'],
                'home.services.link_label' => ['label' => 'Link label on each card', 'type' => 'text', 'default' => 'Learn more'],
            ],
        ],
        [
            'title' => 'Why choose us',
            'fields' => [
                ...$heading('home.why', 'Why EasyLink', 'Internet you never have to think about', 'Reliable network, fast support and fair pricing — the way an ISP should be.'),
                'home.why.items' => [
                    'label' => 'Reasons',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'bolt', 'title' => '99.9% uptime', 'desc' => 'Redundant network infrastructure keeps you online.'],
                        ['icon' => 'shield-check', 'title' => 'DDoS protection', 'desc' => 'Enterprise-grade network security built in.'],
                        ['icon' => 'headset', 'title' => '24/7 support', 'desc' => 'Real people ready to help, any time of day.'],
                        ['icon' => 'map', 'title' => 'Nationwide coverage', 'desc' => 'Fiber reaching all 64 districts of Bangladesh.'],
                    ],
                    'fields' => [
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'desc' => ['label' => 'Description', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Free quote card',
            'fields' => [
                'home.quote.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/stock/support-agent.jpg'],
                'home.quote.image_alt' => ['label' => 'Picture description', 'type' => 'text', 'default' => 'EasyLink fiber router'],
                'home.quote.title' => ['label' => 'Title', 'type' => 'text', 'default' => 'Get a free quote'],
                'home.quote.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell us your location and needs — our team will get back to you shortly.'],
                'home.quote.button1_label' => ['label' => 'Button 1 — label', 'type' => 'text', 'default' => 'Contact us now'],
                'home.quote.button1_link' => ['label' => 'Button 1 — link', 'type' => 'url', 'default' => '/contact'],
                'home.quote.button2_label' => ['label' => 'Button 2 — label', 'type' => 'text', 'default' => 'Check coverage'],
                'home.quote.button2_link' => ['label' => 'Button 2 — link', 'type' => 'url', 'default' => '/coverage'],
            ],
        ],
        [
            'title' => 'Entertainment — heading and app banner',
            'fields' => [
                ...$heading('home.ent', 'Free for subscribers', 'Your gateway to endless entertainment', 'Live TV, movies, web content, radio and news — everything you love, one click away.'),
                'home.app.title' => ['label' => 'App banner — title', 'type' => 'text', 'default' => 'Get the QBOX app'],
                'home.app.desc' => ['label' => 'App banner — text', 'type' => 'textarea', 'default' => 'One app for live TV, movies and more — download for phone & Android TV.'],
                'home.app.href' => ['label' => 'App banner — download link', 'type' => 'url', 'default' => 'https://iqflix.net/img/QBOX.apk'],
                'home.app.button' => ['label' => 'App banner — button label', 'type' => 'text', 'default' => 'Download APK ↓'],
                'home.app.icon' => ['label' => 'App banner — icon', 'type' => 'icon', 'default' => 'cloud'],
                'home.ent.disclaimer' => ['label' => 'Small print under the cards', 'type' => 'text', 'default' => 'We do not host any content. All links open external sources.'],
                'home.ent.live_label' => ['label' => '"Live" badge text', 'type' => 'text', 'default' => 'Live'],
            ],
        ],
        [
            'title' => 'Entertainment — cards',
            'fields' => [
                'home.ent.items' => [
                    'label' => 'Cards',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'tv', 'title' => 'Live TV', 'desc' => 'Live broadcasts & channels.', 'cta' => 'Watch now', 'live' => '1', 'color' => 'from-brand-700 via-brand-600 to-accent-500', 'href' => 'http://10.91.91.91'],
                        ['icon' => 'tv', 'title' => 'Live TV 2', 'desc' => 'Live broadcasts & channels, alternate server.', 'cta' => 'Watch now', 'live' => '1', 'color' => 'from-indigo-700 via-indigo-600 to-brand-500', 'href' => 'http://10.91.91.91/index2.html'],
                        ['icon' => 'globe', 'title' => 'TV Web', 'desc' => 'Web-based TV content & shows.', 'cta' => 'Open', 'live' => '', 'color' => 'from-sky-600 via-sky-500 to-cyan-400', 'href' => 'http://172.16.172.115'],
                        ['icon' => 'photo', 'title' => 'DhakaMovies', 'desc' => 'Vast collection of movies & hits.', 'cta' => 'Browse movies', 'live' => '', 'color' => 'from-slate-800 via-slate-700 to-brand-700', 'href' => 'http://dhakamovie.com/'],
                        ['icon' => 'photo', 'title' => 'CTGMovies', 'desc' => 'Movies & shows for Chittagong.', 'cta' => 'Browse movies', 'live' => '', 'color' => 'from-brand-700 via-brand-600 to-accent-500', 'href' => 'http://ctgmovies.com/'],
                        ['icon' => 'sparkles', 'title' => 'CrazyCTG', 'desc' => 'Unique & trending content.', 'cta' => 'Explore', 'live' => '', 'color' => 'from-indigo-700 via-indigo-600 to-brand-500', 'href' => 'https://crazyctg.com/'],
                        ['icon' => 'server', 'title' => 'SAM-FTP', 'desc' => 'High-speed FTP media server.', 'cta' => 'Open', 'live' => '', 'color' => 'from-sky-600 via-sky-500 to-cyan-400', 'href' => 'http://172.16.50.4/'],
                        ['icon' => 'signal', 'title' => 'FM Radio', 'desc' => 'Wide variety of FM radio stations.', 'cta' => 'Listen', 'live' => '', 'color' => 'from-slate-800 via-slate-700 to-brand-700', 'href' => 'https://radio-bd.com/'],
                        ['icon' => 'newspaper', 'title' => 'Newspapers', 'desc' => 'Latest news from Bangla newspapers.', 'cta' => 'Read', 'live' => '', 'color' => 'from-brand-700 via-brand-600 to-accent-500', 'href' => 'https://www.allbanglanewspaper.xyz/'],
                    ],
                    'fields' => [
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'desc' => ['label' => 'Description', 'type' => 'textarea'],
                        'cta' => ['label' => 'Button text', 'type' => 'text'],
                        'href' => ['label' => 'Link', 'type' => 'url'],
                        'live' => ['label' => 'Show "Live" badge (type 1 for yes, empty for no)', 'type' => 'text'],
                        'color' => ['label' => 'Card colour', 'type' => 'select', 'options' => [
                            'from-red-600 via-rose-600 to-orange-500' => 'Red / orange',
                            'from-fuchsia-600 via-pink-600 to-rose-500' => 'Pink / rose',
                            'from-brand-700 via-brand-600 to-accent-500' => 'Blue / cyan',
                            'from-violet-700 via-purple-600 to-fuchsia-500' => 'Violet / purple',
                            'from-indigo-700 via-indigo-600 to-brand-500' => 'Indigo / blue',
                            'from-amber-500 via-orange-500 to-red-500' => 'Amber / orange',
                            'from-slate-800 via-slate-700 to-brand-700' => 'Dark slate',
                            'from-teal-600 via-emerald-600 to-green-500' => 'Teal / green',
                            'from-emerald-700 via-green-600 to-lime-500' => 'Green / lime',
                            'from-sky-600 via-sky-500 to-cyan-400' => 'Sky / aqua',
                            'from-yellow-500 via-amber-500 to-orange-600' => 'Gold / yellow',
                        ]],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Video / features section',
            'fields' => [
                'home.video.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/stock/couple-selfie-tablet.jpg'],
                'home.video.url' => ['label' => 'Video link (YouTube etc.)', 'type' => 'url', 'default' => '', 'help' => 'Leave empty to hide the play button.'],
                'home.video.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Experience the magic of EasyLink internet'],
                'home.video.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'From blazing-fast speeds to seamless connectivity — stream, game, work and study without a worry. Your gateway to the digital world.'],
                'home.video.stats' => [
                    'label' => 'Highlights',
                    'type' => 'list',
                    'default' => [
                        ['value' => '100 Mbps', 'label' => 'YouTube'],
                        ['value' => '100 Mbps', 'label' => 'Facebook'],
                        ['value' => 'Uncap', 'label' => 'BDIX'],
                    ],
                    'fields' => [
                        'value' => ['label' => 'Big text', 'type' => 'text'],
                        'label' => ['label' => 'Small text', 'type' => 'text'],
                    ],
                ],
                'home.video.button' => ['label' => 'Button label', 'type' => 'text', 'default' => 'Try us free'],
                'home.video.button_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/packages'],
            ],
        ],
        [
            'title' => 'Call-to-action banner',
            'fields' => [
                'home.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/stock/team-laptop.jpg'],
                'home.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Need fast & secure broadband? Use EasyLink internet.'],
                'home.cta.button' => ['label' => 'Button label', 'type' => 'text', 'default' => 'View our plans'],
                'home.cta.button_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/packages'],
                'home.cta.or' => ['label' => 'Word between the buttons', 'type' => 'text', 'default' => 'or'],
            ],
        ],
        [
            'title' => 'Affordable price promo',
            'fields' => [
                'home.promo.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Get broadband at a very affordable price'],
                'home.promo.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Fast, stable internet that does not break the bank. Pick a plan, get connected, and enjoy unlimited browsing with friendly 24/7 support.'],
                'home.promo.currency' => ['label' => 'Currency sign', 'type' => 'text', 'default' => '৳'],
                'home.promo.price' => ['label' => 'Price', 'type' => 'text', 'default' => '525'],
                'home.promo.period' => ['label' => 'Text after the price', 'type' => 'text', 'default' => 'per month'],
                'home.promo.note' => ['label' => 'Small text next to the price', 'type' => 'text', 'default' => 'VAT included'],
                'home.promo.button' => ['label' => 'Button label', 'type' => 'text', 'default' => 'Get started'],
                'home.promo.button_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/packages'],
                'home.promo.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/stock/router-wifi.jpg'],
            ],
        ],
        [
            'title' => 'FAQ and coverage',
            'fields' => [
                'home.faq.title' => ['label' => 'FAQ heading (questions are edited in Admin → FAQs)', 'type' => 'text', 'default' => 'Frequently asked questions'],
                'home.coverage.image' => ['label' => 'Coverage picture', 'type' => 'image', 'default' => '/images/pages/coverage-city.jpg'],
                'home.coverage.title' => ['label' => 'Coverage heading', 'type' => 'text', 'default' => 'We are everywhere'],
                'home.coverage.text' => ['label' => 'Coverage text', 'type' => 'textarea', 'default' => 'Check whether EasyLink is available in your district and area.'],
                'home.coverage.button' => ['label' => 'Coverage button label', 'type' => 'text', 'default' => 'Check your network coverage'],
                'home.coverage.button_link' => ['label' => 'Coverage button link', 'type' => 'url', 'default' => '/coverage'],
            ],
        ],
        [
            'title' => 'Testimonials section',
            'fields' => $heading('home.testimonials', 'Testimonials', 'Loved by customers'),
        ],
        [
            'title' => 'Clients & partners strip',
            'fields' => [
                'home.clients.title' => ['label' => 'Caption above the logos', 'type' => 'text', 'default' => 'Trusted by our clients & technology partners'],
            ],
        ],
        [
            'title' => 'Blog section',
            'fields' => [
                ...$heading('home.blog', 'Blog', 'Latest from the blog', 'Tips, news and stories from the EasyLink team.'),
                'home.blog.read_more' => ['label' => 'Link label on each post', 'type' => 'text', 'default' => 'Read more'],
                'home.blog.button' => ['label' => '"View all" button label', 'type' => 'text', 'default' => 'View all posts'],
            ],
        ],
    ],
];
