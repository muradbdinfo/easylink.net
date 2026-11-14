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
                'packages.plans.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Choose Your Plan'],
                'packages.plans.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Find The Plan That Fits You'],
                'packages.plans.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'No Data Caps, No Hidden Fees. Pick A Speed, Order Online And Our Team Will Take Care Of The Rest.'],
                'packages.plans.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/plans-bg.jpg', 'help' => 'Shown faded behind the plans.'],
                'packages.plans.empty' => ['label' => 'Text when there are no packages', 'type' => 'text', 'default' => 'No Packages Available Right Now.'],
                'packages.plans.footnote' => ['label' => 'Note under the plans', 'type' => 'text', 'default' => 'Prices Are In BDT Per Month. Need Something Bigger? Talk To Us For A Custom Plan.'],
            ],
        ],
        [
            'title' => 'Package card',
            'fields' => [
                'packages.card.popular_badge' => ['label' => 'Badge on the popular plan', 'type' => 'text', 'default' => 'Most Popular'],
                'packages.card.order_button' => ['label' => 'Order button', 'type' => 'text', 'default' => 'Order Now'],
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
                        ['icon' => 'wrench', 'title' => 'Free Installation', 'desc' => 'On All Home Plans'],
                        ['icon' => 'headset', 'title' => '24/7 Support', 'desc' => 'Real People, Any Time'],
                        ['icon' => 'bolt', 'title' => 'Unlimited Fiber', 'desc' => 'No Data Caps'],
                        ['icon' => 'shield-check', 'title' => 'Reliable Network', 'desc' => 'Built For Uptime'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Why choose us',
            'fields' => [
                'packages.why.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Why EasyLink'],
                'packages.why.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Built For The Way You Use The Internet'],
                'packages.why.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'Streaming, Gaming, Video Calls And Work From Home — One Stable Fiber Connection For All Of It.'],
                'packages.why.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/hero/hero-5.jpg'],
                'packages.why.items' => [
                    'label' => 'Cards',
                    'type' => 'list',
                    'fields' => $item('Title'),
                    'default' => [
                        ['icon' => 'film', 'title' => 'Streaming In HD', 'desc' => 'Smooth Video On Every Screen In The House.'],
                        ['icon' => 'rocket-launch', 'title' => 'Low-Latency Gaming', 'desc' => 'A Stable Connection For Online Games.'],
                        ['icon' => 'computer-desktop', 'title' => 'Work From Home', 'desc' => 'Reliable Calls And Fast Uploads.'],
                        ['icon' => 'device-phone-mobile', 'title' => 'All Your Devices', 'desc' => 'Phones, TVs And Laptops Online Together.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Questions & answers',
            'fields' => [
                'packages.faq.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'FAQ'],
                'packages.faq.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Before You Order'],
                'packages.faq.items' => [
                    'label' => 'Questions',
                    'type' => 'list',
                    'fields' => [
                        'question' => ['label' => 'Question', 'type' => 'text'],
                        'answer' => ['label' => 'Answer', 'type' => 'textarea'],
                    ],
                    'default' => [
                        ['question' => 'How Do I Order A Package?', 'answer' => 'Press "Order Now" On Any Plan And Send The Short Form. Our Team Will Call You To Confirm Your Address And Schedule The Installation.'],
                        ['question' => 'Is There A Data Limit?', 'answer' => 'Home Plans Are Unlimited With No Data Caps.'],
                        ['question' => 'Is Installation Free?', 'answer' => 'Yes, Installation Is Free On All Home Plans.'],
                        ['question' => 'Can I Change My Package Later?', 'answer' => 'Yes. Contact Our Support Team Any Time And We Will Switch You To A Different Plan.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Bottom banner',
            'fields' => [
                'packages.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Ready To Get Connected?'],
                'packages.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell Us Where You Live And We Will Find The Best Plan For Your Home.'],
                'packages.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/packages-family.jpg'],
                'packages.cta.primary_label' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Contact Us'],
                'packages.cta.primary_link' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'packages.cta.secondary_label' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'Check Coverage'],
                'packages.cta.secondary_link' => ['label' => 'Second button link', 'type' => 'url', 'default' => '/coverage'],
            ],
        ],
    ],
];
