<?php

/*
 * Corporate page (/corporate). The banner at the top comes from 00-page-headers.php (corporate.hero.*).
 * Services, packages, clients and testimonials shown on the page come from their own admin menus.
 */

$card = fn () => [
    'title' => ['label' => 'Title', 'type' => 'text'],
    'icon' => ['label' => 'Icon', 'type' => 'icon'],
    'desc' => ['label' => 'Description', 'type' => 'textarea'],
];

return [
    'page' => 'Corporate',
    'sections' => [
        [
            'title' => 'Highlights (under the banner)',
            'fields' => [
                'corporate.highlights.items' => [
                    'label' => 'Highlights',
                    'type' => 'list',
                    'fields' => $card(),
                    'default' => [
                        ['icon' => 'circle-stack', 'title' => '1:1 dedicated bandwidth', 'desc' => 'Your capacity is never shared.'],
                        ['icon' => 'shield-check', 'title' => '99.9% uptime SLA', 'desc' => 'Backed by a written guarantee.'],
                        ['icon' => 'signal', 'title' => 'Redundant network', 'desc' => 'Backup paths keep you online.'],
                        ['icon' => 'briefcase', 'title' => 'Dedicated account manager', 'desc' => 'One contact for everything.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Introduction',
            'fields' => [
                'corporate.intro.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Why businesses choose us'],
                'corporate.intro.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Connectivity your business can depend on'],
                'corporate.intro.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Dedicated bandwidth, SLA guarantees, DDoS protection and 24/7 NOC monitoring — a complete connectivity solution for offices, factories, banks and hospitals.'],
                'corporate.intro.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/corporate-team.jpg'],
                'corporate.intro.points' => [
                    'label' => 'Checklist',
                    'type' => 'list',
                    'fields' => ['text' => ['label' => 'Point', 'type' => 'text']],
                    'default' => [
                        ['text' => 'Dedicated internet with a service-level agreement'],
                        ['text' => 'DDoS protection and network monitoring'],
                        ['text' => '24/7 NOC and priority support'],
                        ['text' => 'Scalable bandwidth as your business grows'],
                    ],
                ],
                'corporate.intro.button_label' => ['label' => 'Button text', 'type' => 'text', 'default' => 'Get a free consultation'],
                'corporate.intro.button_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/contact'],
            ],
        ],
        [
            'title' => 'Services',
            'fields' => [
                'corporate.services.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Services'],
                'corporate.services.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Corporate services'],
                'corporate.services.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'Everything your company needs to stay connected, secure and online.'],
                'corporate.services.card_cta' => ['label' => 'Card link text', 'type' => 'text', 'default' => 'Learn more'],
            ],
        ],
        [
            'title' => 'Numbers band',
            'fields' => [
                'corporate.stats.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/corporate-towers.jpg'],
                'corporate.stats.items' => [
                    'label' => 'Numbers',
                    'type' => 'list',
                    'fields' => [
                        'value' => ['label' => 'Number', 'type' => 'text'],
                        'label' => ['label' => 'Label', 'type' => 'text'],
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                    ],
                    'default' => [
                        ['value' => '99.9%', 'label' => 'Uptime SLA', 'icon' => 'shield-check'],
                        ['value' => '24/7', 'label' => 'NOC monitoring', 'icon' => 'headset'],
                        ['value' => '1:1', 'label' => 'Dedicated bandwidth', 'icon' => 'circle-stack'],
                        ['value' => '15+', 'label' => 'Years of experience', 'icon' => 'trophy'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'How it works',
            'fields' => [
                'corporate.process.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'How it works'],
                'corporate.process.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'From first call to live connection'],
                'corporate.process.items' => [
                    'label' => 'Steps',
                    'type' => 'list',
                    'fields' => $card(),
                    'default' => [
                        ['icon' => 'chat-bubble-left-right', 'title' => 'Consultation', 'desc' => 'Tell us about your business and bandwidth needs.'],
                        ['icon' => 'map-pin', 'title' => 'Survey & design', 'desc' => 'We survey your site and plan the connection.'],
                        ['icon' => 'wrench', 'title' => 'Installation', 'desc' => 'Our engineers install and test the link.'],
                        ['icon' => 'headset', 'title' => '24/7 support', 'desc' => 'Our NOC monitors the line around the clock.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Packages',
            'fields' => [
                'corporate.plans.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Plans'],
                'corporate.plans.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Dedicated corporate packages'],
                'corporate.plans.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'Choose the bandwidth that fits the size of your business.'],
            ],
        ],
        [
            'title' => 'Clients & testimonials',
            'fields' => [
                'corporate.clients.title' => ['label' => 'Clients heading', 'type' => 'text', 'default' => 'Organizations that trust us'],
                'corporate.testimonials.title' => ['label' => 'Testimonials heading', 'type' => 'text', 'default' => 'What our clients say'],
            ],
        ],
        [
            'title' => 'Bottom banner',
            'fields' => [
                'corporate.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => "Let's build your network"],
                'corporate.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Talk to our enterprise team about a connection designed around your business.'],
                'corporate.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/corporate-towers.jpg'],
                'corporate.cta.primary_label' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Get a free consultation'],
                'corporate.cta.primary_link' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'corporate.cta.secondary_label' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'View all packages'],
                'corporate.cta.secondary_link' => ['label' => 'Second button link', 'type' => 'url', 'default' => '/packages?type=corporate'],
            ],
        ],
    ],
];
