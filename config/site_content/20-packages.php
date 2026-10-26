<?php

/*
 * Packages page (/packages) and the shared package card (also used on Home and Corporate).
 * The banner at the top comes from 00-page-headers.php (packages.hero.*).
 */

$item = fn (string $label) => [
    'title' => ['label' => $label, 'type' => 'text'],
    'icon' => ['label' => 'Icon', 'type' => 'icon'],
    'desc' => ['label' => 'Description', 'type' => 'textarea'],
];

return [
    'page' => 'Packages',
    'sections' => [
        [
            'title' => 'Package list',
            'fields' => [
                'packages.tab_home' => ['label' => 'Tab: home packages', 'type' => 'text', 'default' => 'Home'],
                'packages.tab_corporate' => ['label' => 'Tab: corporate packages', 'type' => 'text', 'default' => 'Corporate'],
                'packages.plans.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Choose your plan'],
                'packages.plans.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Find the plan that fits you'],
                'packages.plans.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'No data caps, no hidden fees. Pick a speed, order online and our team will take care of the rest.'],
                'packages.plans.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/plans-bg.jpg', 'help' => 'Shown faded behind the plans.'],
                'packages.plans.empty' => ['label' => 'Text when there are no packages', 'type' => 'text', 'default' => 'No packages available right now.'],
                'packages.plans.footnote' => ['label' => 'Note under the plans', 'type' => 'text', 'default' => 'Prices are in BDT per month. Need something bigger? Talk to us for a custom plan.'],
            ],
        ],
        [
            'title' => 'Package card',
            'fields' => [
                'packages.card.popular_badge' => ['label' => 'Badge on the popular plan', 'type' => 'text', 'default' => 'Most popular'],
                'packages.card.order_button' => ['label' => 'Order button', 'type' => 'text', 'default' => 'Order now'],
                'packages.card.unit_home' => ['label' => 'Home plan speed label', 'type' => 'text', 'default' => 'Unlimited'],
                'packages.card.unit_corporate' => ['label' => 'Corporate plan speed label', 'type' => 'text', 'default' => 'Dedicated'],
            ],
        ],
        [
            'title' => 'Trust strip (under the banner)',
            'fields' => [
                'packages.trust.items' => [
                    'label' => 'Points',
                    'type' => 'list',
                    'fields' => $item('Title'),
                    'default' => [
                        ['icon' => 'wrench', 'title' => 'Free installation', 'desc' => 'On all home plans'],
                        ['icon' => 'headset', 'title' => '24/7 support', 'desc' => 'Real people, any time'],
                        ['icon' => 'bolt', 'title' => 'Unlimited fiber', 'desc' => 'No data caps'],
                        ['icon' => 'shield-check', 'title' => 'Reliable network', 'desc' => 'Built for uptime'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Why choose us',
            'fields' => [
                'packages.why.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Why EasyLink'],
                'packages.why.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Built for the way you use the internet'],
                'packages.why.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'Streaming, gaming, video calls and work from home — one stable fiber connection for all of it.'],
                'packages.why.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/hero/hero-5.jpg'],
                'packages.why.items' => [
                    'label' => 'Cards',
                    'type' => 'list',
                    'fields' => $item('Title'),
                    'default' => [
                        ['icon' => 'film', 'title' => 'Streaming in HD', 'desc' => 'Smooth video on every screen in the house.'],
                        ['icon' => 'rocket-launch', 'title' => 'Low-latency gaming', 'desc' => 'A stable connection for online games.'],
                        ['icon' => 'computer-desktop', 'title' => 'Work from home', 'desc' => 'Reliable calls and fast uploads.'],
                        ['icon' => 'device-phone-mobile', 'title' => 'All your devices', 'desc' => 'Phones, TVs and laptops online together.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Questions & answers',
            'fields' => [
                'packages.faq.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'FAQ'],
                'packages.faq.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Before you order'],
                'packages.faq.items' => [
                    'label' => 'Questions',
                    'type' => 'list',
                    'fields' => [
                        'question' => ['label' => 'Question', 'type' => 'text'],
                        'answer' => ['label' => 'Answer', 'type' => 'textarea'],
                    ],
                    'default' => [
                        ['question' => 'How do I order a package?', 'answer' => 'Press "Order now" on any plan and send the short form. Our team will call you to confirm your address and schedule the installation.'],
                        ['question' => 'Is there a data limit?', 'answer' => 'Home plans are unlimited with no data caps.'],
                        ['question' => 'Is installation free?', 'answer' => 'Yes, installation is free on all home plans.'],
                        ['question' => 'Can I change my package later?', 'answer' => 'Yes. Contact our support team any time and we will switch you to a different plan.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Bottom banner',
            'fields' => [
                'packages.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Ready to get connected?'],
                'packages.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell us where you live and we will find the best plan for your home.'],
                'packages.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/packages-family.jpg'],
                'packages.cta.primary_label' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Contact us'],
                'packages.cta.primary_link' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'packages.cta.secondary_label' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'Check coverage'],
                'packages.cta.secondary_link' => ['label' => 'Second button link', 'type' => 'url', 'default' => '/coverage'],
            ],
        ],
    ],
];
