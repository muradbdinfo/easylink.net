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
                        ['icon' => 'circle-stack', 'title' => '1:1 Dedicated Bandwidth', 'desc' => 'Your Capacity Is Never Shared.'],
                        ['icon' => 'shield-check', 'title' => '99.9% Uptime SLA', 'desc' => 'Backed By A Written Guarantee.'],
                        ['icon' => 'signal', 'title' => 'Redundant Network', 'desc' => 'Backup Paths Keep You Online.'],
                        ['icon' => 'briefcase', 'title' => 'Dedicated Account Manager', 'desc' => 'One Contact For Everything.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Introduction',
            'fields' => [
                'corporate.intro.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Why Businesses Choose Us'],
                'corporate.intro.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Connectivity Your Business Can Depend On'],
                'corporate.intro.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Dedicated Bandwidth, SLA Guarantees, DDoS Protection And 24/7 NOC Monitoring — A Complete Connectivity Solution For Offices, Factories, Banks And Hospitals.'],
                'corporate.intro.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/corporate-team.jpg'],
                'corporate.intro.points' => [
                    'label' => 'Checklist',
                    'type' => 'list',
                    'fields' => ['text' => ['label' => 'Point', 'type' => 'text']],
                    'default' => [
                        ['text' => 'Dedicated Internet With A Service-Level Agreement'],
                        ['text' => 'DDoS Protection And Network Monitoring'],
                        ['text' => '24/7 NOC And Priority Support'],
                        ['text' => 'Scalable Bandwidth As Your Business Grows'],
                    ],
                ],
                'corporate.intro.button_label' => ['label' => 'Button text', 'type' => 'text', 'default' => 'Get A Free Consultation'],
                'corporate.intro.button_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/contact'],
            ],
        ],
        [
            'title' => 'Services',
            'fields' => [
                'corporate.services.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Services'],
                'corporate.services.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Corporate Services'],
                'corporate.services.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'Everything Your Company Needs To Stay Connected, Secure And Online.'],
                'corporate.services.card_cta' => ['label' => 'Card link text', 'type' => 'text', 'default' => 'Learn More'],
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
                        ['value' => '24/7', 'label' => 'NOC Monitoring', 'icon' => 'headset'],
                        ['value' => '1:1', 'label' => 'Dedicated Bandwidth', 'icon' => 'circle-stack'],
                        ['value' => '15+', 'label' => 'Years Of Experience', 'icon' => 'trophy'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'How it works',
            'fields' => [
                'corporate.process.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'How It Works'],
                'corporate.process.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'From First Call To Live Connection'],
                'corporate.process.items' => [
                    'label' => 'Steps',
                    'type' => 'list',
                    'fields' => $card(),
                    'default' => [
                        ['icon' => 'chat-bubble-left-right', 'title' => 'Consultation', 'desc' => 'Tell Us About Your Business And Bandwidth Needs.'],
                        ['icon' => 'map-pin', 'title' => 'Survey & Design', 'desc' => 'We Survey Your Site And Plan The Connection.'],
                        ['icon' => 'wrench', 'title' => 'Installation', 'desc' => 'Our Engineers Install And Test The Link.'],
                        ['icon' => 'headset', 'title' => '24/7 Support', 'desc' => 'Our NOC Monitors The Line Around The Clock.'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Packages',
            'fields' => [
                'corporate.plans.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Plans'],
                'corporate.plans.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Dedicated Corporate Packages'],
                'corporate.plans.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'Choose The Bandwidth That Fits The Size Of Your Business.'],
            ],
        ],
        [
            'title' => 'Clients & testimonials',
            'fields' => [
                'corporate.clients.title' => ['label' => 'Clients heading', 'type' => 'text', 'default' => 'Organizations That Trust Us'],
                'corporate.testimonials.title' => ['label' => 'Testimonials heading', 'type' => 'text', 'default' => 'What Our Clients Say'],
            ],
        ],
        [
            'title' => 'Bottom banner',
            'fields' => [
                'corporate.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => "Let's Build Your Network"],
                'corporate.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Talk To Our Enterprise Team About A Connection Designed Around Your Business.'],
                'corporate.cta.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/corporate-towers.jpg'],
                'corporate.cta.primary_label' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Get A Free Consultation'],
                'corporate.cta.primary_link' => ['label' => 'Main button link', 'type' => 'url', 'default' => '/contact'],
                'corporate.cta.secondary_label' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'View All Packages'],
                'corporate.cta.secondary_link' => ['label' => 'Second button link', 'type' => 'url', 'default' => '/packages?type=corporate'],
            ],
        ],
    ],
];
