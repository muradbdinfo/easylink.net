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
                'services.list.heading' => ['label' => 'Heading above the cards', 'type' => 'text', 'default' => 'Everything Connectivity, One Provider'],
                'services.list.subheading' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => 'Pick A Service To See What Is Included, How It Works And How To Get Connected.'],
                'services.card.cta' => ['label' => 'Card link text', 'type' => 'text', 'default' => 'Learn More'],
            ],
        ],
        [
            'title' => 'Why choose us strip',
            'fields' => [
                'services.why.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Why Customers Stay With EasyLink'],
                'services.why.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/services-network.jpg'],
                'services.why.items' => ['label' => 'Points', 'type' => 'list', 'fields' => $item, 'default' => [
                    ['icon' => 'bolt', 'title' => '99.9% Uptime', 'text' => 'Redundant Fiber Backbone Keeps You Online.'],
                    ['icon' => 'shield-check', 'title' => 'Secure By Design', 'text' => 'DDoS Protection And Monitored Networks.'],
                    ['icon' => 'headset', 'title' => '24/7 Support', 'text' => 'Real Engineers, Any Time Of The Day.'],
                    ['icon' => 'rocket-launch', 'title' => 'Fast Installation', 'text' => 'Most Connections Are Live Within 48 Hours.'],
                ]],
            ],
        ],
        [
            'title' => 'Bottom call-to-action band',
            'fields' => [
                'services.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/services-fiber.jpg'],
                'services.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Not Sure Which Service Fits?'],
                'services.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell Us What You Need And Our Team Will Recommend The Right Plan And Set Up A Free Site Visit.'],
                'services.cta.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Talk To An Expert'],
                'services.cta.button_url' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'services.cta.button2' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'See Packages'],
                'services.cta.button2_url' => ['label' => 'Second button link', 'type' => 'url', 'default' => '/packages'],
            ],
        ],
        [
            'title' => 'Service detail page',
            'fields' => [
                'services.detail.back' => ['label' => 'Back link text', 'type' => 'text', 'default' => 'All Services'],
                'services.detail.default_image' => ['label' => 'Banner picture (used when a service has no picture of its own)', 'type' => 'image', 'default' => '/images/pages/services-network.jpg'],
                'services.detail.about_title' => ['label' => 'Heading above the description', 'type' => 'text', 'default' => 'About This Service'],
                'services.detail.facts' => ['label' => 'Highlights strip', 'type' => 'list', 'fields' => $item, 'default' => [
                    ['icon' => 'check-badge', 'title' => 'SLA Backed', 'text' => 'Clear Uptime And Response Commitments.'],
                    ['icon' => 'wrench', 'title' => 'Free Site Survey', 'text' => 'Our Engineers Visit And Plan The Setup.'],
                    ['icon' => 'headset', 'title' => 'Dedicated Support', 'text' => 'Reach The NOC Team 24/7.'],
                ]],
                'services.detail.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Ask About This Service'],
                'services.detail.button_url' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'services.detail.call_title' => ['label' => 'Side card heading', 'type' => 'text', 'default' => 'Need Help Choosing?'],
                'services.detail.call_text' => ['label' => 'Side card text', 'type' => 'textarea', 'default' => 'Call Our Support Team Any Time.'],
                'services.detail.related_title' => ['label' => 'Related services heading', 'type' => 'text', 'default' => 'Related Services'],
            ],
        ],
    ],
];
