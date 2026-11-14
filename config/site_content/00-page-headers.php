<?php

/*
 * Top banner (eyebrow, title, subtitle, picture, icon) of every inner page.
 * Used by <PageHero page-key="..."> — see resources/js/Components/Public/PageHero.vue.
 */

$hero = fn (string $key, string $label, string $eyebrow, string $title, string $subtitle, string $image, string $icon) => [
    'title' => $label,
    'fields' => [
        "$key.hero.eyebrow" => ['label' => 'Small tag above the title', 'type' => 'text', 'default' => $eyebrow],
        "$key.hero.title" => ['label' => 'Title', 'type' => 'text', 'default' => $title],
        "$key.hero.subtitle" => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => $subtitle],
        "$key.hero.image" => ['label' => 'Background picture', 'type' => 'image', 'default' => $image, 'help' => 'Wide picture, at least 1600px. A dark overlay is added so the text stays readable.'],
        "$key.hero.icon" => ['label' => 'Icon', 'type' => 'icon', 'default' => $icon],
    ],
];

return [
    'page' => 'Page headers',
    'sections' => [
        $hero('packages', 'Packages page', 'Pricing', 'Internet Packages', 'Pick The Plan That Fits Your Needs. Switch Any Time.', '/images/stock/family-sofa.jpg', 'cube'),
        $hero('corporate', 'Corporate page', 'Enterprise', 'Corporate Solutions', 'Dedicated Bandwidth, SLA Guarantees And 24/7 NOC Monitoring.', '/images/hero/hero-6.jpg', 'building-office'),
        $hero('services', 'Services page', 'Services', 'Our Services', 'From Home To Enterprise — Every Kind Of Connectivity Solution.', '/images/hero/hero-2.jpg', 'wrench'),
        $hero('about', 'About page', 'About Us', 'Built To Keep Bangladesh Connected', 'Your Reliable Internet Partner', '/images/hero/hero-4.jpg', 'user-group'),
        $hero('coverage', 'Coverage page', 'Coverage', 'Check Coverage', 'Find Out If EasyLink Fiber Is Available In Your Area.', '/images/hero/hero-1.jpg', 'map-pin'),
        $hero('contact', 'Contact page', 'Contact', "Let's Talk", "New Connection, A Quote, Or Any Question — Send Us A Message And We'll Reply Quickly.", '/images/stock/support-agent.jpg', 'chat-bubble-left-right'),
        $hero('speedtest', 'Speed test page', 'Speed Test', 'Test Your Speed', 'Check Your Download, Upload And Ping In A Few Seconds.', '/images/stock/man-laptop-home.jpg', 'bolt'),
        $hero('payment', 'Payment page', 'Payment', 'Pay Your Bill', 'Simple Ways To Pay Your Internet Bill.', '/images/stock/woman-phone-laptop.jpg', 'banknotes'),
        $hero('blog', 'Blog page', 'Blog', 'Blog & News', 'Internet, Technology And The Latest From EasyLink.', '/images/pages/blog.jpg', 'newspaper'),
    ],
];
