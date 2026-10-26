<?php

/*
 * Services listing + detail pages. The banner (title, picture, icon) is in 00-page-headers.php.
 * Items inside lists use sub-fields: icon, title, text.
 */

$item = [
    'icon' => ['label' => 'Icon', 'type' => 'icon'],
    'title' => ['label' => 'Title', 'type' => 'text'],
    'text' => ['label' => 'Text', 'type' => 'textarea'],
];

return [
    'page' => 'Services',
    'sections' => [
        [
            'title' => 'Services list',
            'fields' => [
                'services.list.heading' => ['label' => 'Heading above the cards', 'type' => 'text', 'default' => 'Everything connectivity, one provider'],
                'services.list.subheading' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => 'Pick a service to see what is included, how it works and how to get connected.'],
                'services.card.cta' => ['label' => 'Card link text', 'type' => 'text', 'default' => 'Learn more'],
            ],
        ],
        [
            'title' => 'Why choose us strip',
            'fields' => [
                'services.why.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Why customers stay with EasyLink'],
                'services.why.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/services-network.jpg'],
                'services.why.items' => ['label' => 'Points', 'type' => 'list', 'fields' => $item, 'default' => [
                    ['icon' => 'bolt', 'title' => '99.9% uptime', 'text' => 'Redundant fiber backbone keeps you online.'],
                    ['icon' => 'shield-check', 'title' => 'Secure by design', 'text' => 'DDoS protection and monitored networks.'],
                    ['icon' => 'headset', 'title' => '24/7 support', 'text' => 'Real engineers, any time of the day.'],
                    ['icon' => 'rocket-launch', 'title' => 'Fast installation', 'text' => 'Most connections are live within 48 hours.'],
                ]],
            ],
        ],
        [
            'title' => 'Bottom call-to-action band',
            'fields' => [
                'services.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/services-fiber.jpg'],
                'services.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Not sure which service fits?'],
                'services.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell us what you need and our team will recommend the right plan and set up a free site visit.'],
                'services.cta.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Talk to an expert'],
                'services.cta.button_url' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'services.cta.button2' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'See packages'],
                'services.cta.button2_url' => ['label' => 'Second button link', 'type' => 'url', 'default' => '/packages'],
            ],
        ],
        [
            'title' => 'Service detail page',
            'fields' => [
                'services.detail.back' => ['label' => 'Back link text', 'type' => 'text', 'default' => 'All services'],
                'services.detail.default_image' => ['label' => 'Banner picture (used when a service has no picture of its own)', 'type' => 'image', 'default' => '/images/pages/services-network.jpg'],
                'services.detail.about_title' => ['label' => 'Heading above the description', 'type' => 'text', 'default' => 'About this service'],
                'services.detail.facts' => ['label' => 'Highlights strip', 'type' => 'list', 'fields' => $item, 'default' => [
                    ['icon' => 'check-badge', 'title' => 'SLA backed', 'text' => 'Clear uptime and response commitments.'],
                    ['icon' => 'wrench', 'title' => 'Free site survey', 'text' => 'Our engineers visit and plan the setup.'],
                    ['icon' => 'headset', 'title' => 'Dedicated support', 'text' => 'Reach the NOC team 24/7.'],
                ]],
                'services.detail.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Ask about this service'],
                'services.detail.button_url' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'services.detail.call_title' => ['label' => 'Side card heading', 'type' => 'text', 'default' => 'Need help choosing?'],
                'services.detail.call_text' => ['label' => 'Side card text', 'type' => 'textarea', 'default' => 'Call our support team any time.'],
                'services.detail.related_title' => ['label' => 'Related services heading', 'type' => 'text', 'default' => 'Related services'],
            ],
        ],
    ],
];
