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

$hero = [];
for ($i = 1; $i <= 6; $i++) {
    $hero["home.hero.image_$i"] = ['label' => "Default slider picture $i", 'type' => 'image', 'default' => "/images/hero/hero-$i.jpg"];
}
$hero['home.hero.image_1']['help'] = 'Shown behind slide 1, 2, 3… when a slider has no picture of its own (slide 7 starts again from picture 1). Wide picture, at least 1600px.';

return [
    'page' => 'Home',
    'sections' => [
        [
            'title' => 'Hero slider',
            'fields' => [
                'home.hero.badge' => ['label' => 'Badge text', 'type' => 'text', 'default' => 'BTRC-approved zonal ISP'],
                'home.hero.coverage_button' => ['label' => '"Check coverage" button label', 'type' => 'text', 'default' => 'Check coverage'],
                ...$hero,
            ],
        ],
        [
            'title' => 'Hero — live speed card',
            'fields' => [
                'home.speed.title' => ['label' => 'Card title', 'type' => 'text', 'default' => 'Live speed'],
                'home.speed.status' => ['label' => 'Status text', 'type' => 'text', 'default' => 'Online'],
                'home.speed.value' => ['label' => 'Big number', 'type' => 'text', 'default' => '35'],
                'home.speed.unit' => ['label' => 'Unit', 'type' => 'text', 'default' => 'Mbps'],
                'home.speed.rows' => [
                    'label' => 'Bars',
                    'type' => 'list',
                    'default' => [
                        ['label' => 'Download', 'value' => '35 Mbps', 'percent' => '92'],
                        ['label' => 'Upload', 'value' => '35 Mbps', 'percent' => '88'],
                        ['label' => 'Latency', 'value' => '4 ms', 'percent' => '12'],
                    ],
                    'fields' => [
                        'label' => ['label' => 'Name', 'type' => 'text'],
                        'value' => ['label' => 'Value shown on the right', 'type' => 'text'],
                        'percent' => ['label' => 'Bar length (0-100)', 'type' => 'text'],
                    ],
                ],
                'home.speed.badge_title' => ['label' => 'Floating badge — title', 'type' => 'text', 'default' => 'Free installation'],
                'home.speed.badge_text' => ['label' => 'Floating badge — text', 'type' => 'text', 'default' => 'on all home plans'],
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
                'home.quote.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/router.svg'],
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
                        ['icon' => 'tv', 'title' => 'Live TV', 'desc' => 'Live broadcasts & channels.', 'cta' => 'Watch now', 'live' => '1', 'color' => 'from-red-600 via-rose-600 to-orange-500', 'href' => 'http://10.91.91.91'],
                        ['icon' => 'tv', 'title' => 'Live TV 2', 'desc' => 'Live broadcasts & channels, alternate server.', 'cta' => 'Watch now', 'live' => '1', 'color' => 'from-fuchsia-600 via-pink-600 to-rose-500', 'href' => 'http://10.91.91.91/index2.html'],
                        ['icon' => 'globe', 'title' => 'TV Web', 'desc' => 'Web-based TV content & shows.', 'cta' => 'Open', 'live' => '', 'color' => 'from-brand-700 via-brand-600 to-accent-500', 'href' => 'http://172.16.172.115'],
                        ['icon' => 'photo', 'title' => 'DhakaMovies', 'desc' => 'Vast collection of movies & hits.', 'cta' => 'Browse movies', 'live' => '', 'color' => 'from-violet-700 via-purple-600 to-fuchsia-500', 'href' => 'http://dhakamovie.com/'],
                        ['icon' => 'photo', 'title' => 'CTGMovies', 'desc' => 'Movies & shows for Chittagong.', 'cta' => 'Browse movies', 'live' => '', 'color' => 'from-indigo-700 via-indigo-600 to-brand-500', 'href' => 'http://ctgmovies.com/'],
                        ['icon' => 'sparkles', 'title' => 'CrazyCTG', 'desc' => 'Unique & trending content.', 'cta' => 'Explore', 'live' => '', 'color' => 'from-amber-500 via-orange-500 to-red-500', 'href' => 'https://crazyctg.com/'],
                        ['icon' => 'server', 'title' => 'SAM-FTP', 'desc' => 'High-speed FTP media server.', 'cta' => 'Open', 'live' => '', 'color' => 'from-slate-800 via-slate-700 to-brand-700', 'href' => 'http://172.16.50.4/'],
                        ['icon' => 'signal', 'title' => 'FM Radio', 'desc' => 'Wide variety of FM radio stations.', 'cta' => 'Listen', 'live' => '', 'color' => 'from-teal-600 via-emerald-600 to-green-500', 'href' => 'https://radio-bd.com/'],
                        ['icon' => 'newspaper', 'title' => 'Newspapers', 'desc' => 'Latest news from Bangla newspapers.', 'cta' => 'Read', 'live' => '', 'color' => 'from-emerald-700 via-green-600 to-lime-500', 'href' => 'https://www.allbanglanewspaper.xyz/'],
                    ],
                    'fields' => [
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'desc' => ['label' => 'Description', 'type' => 'textarea'],
                        'cta' => ['label' => 'Button text', 'type' => 'text'],
                        'href' => ['label' => 'Link', 'type' => 'url'],
                        'live' => ['label' => 'Show "Live" badge (type 1 for yes, empty for no)', 'type' => 'text'],
                        'color' => ['label' => 'Background colour (Tailwind gradient classes)', 'type' => 'text'],
                    ],
                ],
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
