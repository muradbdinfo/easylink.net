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
        $hero('packages', 'Packages page', 'Pricing', 'Internet packages', 'Pick the plan that fits your needs. Switch any time.', '/images/plans-bg.jpg', 'cube'),
        $hero('corporate', 'Corporate page', 'Enterprise', 'Corporate solutions', 'Dedicated bandwidth, SLA guarantees and 24/7 NOC monitoring.', '/images/hero/hero-6.jpg', 'building-office'),
        $hero('services', 'Services page', 'Services', 'Our services', 'From home to enterprise — every kind of connectivity solution.', '/images/hero/hero-2.jpg', 'wrench'),
        $hero('about', 'About page', 'About us', 'Built to keep Bangladesh connected', 'Your reliable internet partner', '/images/hero/hero-4.jpg', 'user-group'),
        $hero('coverage', 'Coverage page', 'Coverage', 'Check coverage', 'Find out if EasyLink fiber is available in your area.', '/images/hero/hero-1.jpg', 'map-pin'),
        $hero('contact', 'Contact page', 'Contact', "Let's talk", "New connection, a quote, or any question — send us a message and we'll reply quickly.", '/images/pages/contact.jpg', 'chat-bubble-left-right'),
        $hero('blog', 'Blog page', 'Blog', 'Blog & news', 'Internet, technology and the latest from EasyLink.', '/images/pages/blog.jpg', 'newspaper'),
    ],
];
