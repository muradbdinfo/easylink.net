<?php

/* About page body (the top banner lives in 00-page-headers.php). The story text itself is "About text" in Settings. */

$iconTitleText = [
    'icon' => ['label' => 'Icon', 'type' => 'icon'],
    'title' => ['label' => 'Title', 'type' => 'text'],
    'text' => ['label' => 'Text', 'type' => 'textarea'],
];

return [
    'page' => 'About',
    'sections' => [
        [
            'title' => 'Our story',
            'fields' => [
                'about.story.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Our story'],
                'about.story.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Who we are'],
                'about.story.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/about-story.jpg'],
                'about.story.badge_title' => ['label' => 'Badge on the picture - title', 'type' => 'text', 'default' => 'Local team'],
                'about.story.badge_text' => ['label' => 'Badge on the picture - text', 'type' => 'text', 'default' => 'Engineers you can call'],
                'about.story.badge_icon' => ['label' => 'Badge icon', 'type' => 'icon', 'default' => 'headset'],
            ],
        ],
        [
            'title' => 'Mission, vision & values',
            'fields' => [
                'about.pillars.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'What drives us'],
                'about.pillars.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Mission, vision & values'],
                'about.pillars.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'The promises behind every connection we install.'],
                'about.pillars.items' => [
                    'label' => 'Cards',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'rocket-launch', 'title' => 'Our mission', 'text' => 'Deliver fast, stable and fairly priced internet to every home and business we serve.'],
                        ['icon' => 'eye', 'title' => 'Our vision', 'text' => 'A fully connected community where great internet is as dependable as electricity.'],
                        ['icon' => 'heart', 'title' => 'Our values', 'text' => 'Honest pricing, quick support and respect for every customer, big or small.'],
                    ],
                    'fields' => $iconTitleText,
                ],
            ],
        ],
        [
            'title' => 'Numbers strip (numbers come from "Stats counter")',
            'fields' => [
                'about.stats.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'In numbers'],
                'about.stats.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Trusted by thousands'],
            ],
        ],
        [
            'title' => 'Why choose us',
            'fields' => [
                'about.why.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Why us'],
                'about.why.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Why customers stay with us'],
                'about.why.items' => [
                    'label' => 'Points',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'bolt', 'title' => 'Reliable network', 'text' => 'Redundant fiber links keep you online.'],
                        ['icon' => 'headset', 'title' => 'Real support', 'text' => 'People who pick up the phone, day or night.'],
                        ['icon' => 'banknotes', 'title' => 'Fair pricing', 'text' => 'Clear plans with no hidden fees.'],
                        ['icon' => 'map-pin', 'title' => 'Local expertise', 'text' => 'Our engineers live and work in your area.'],
                    ],
                    'fields' => $iconTitleText,
                ],
            ],
        ],
        [
            'title' => 'Partners, FAQ and call to action',
            'fields' => [
                'about.partners.label' => ['label' => 'Partners strip label', 'type' => 'text', 'default' => 'Technology partners & clients'],
                'about.faq.eyebrow' => ['label' => 'FAQ small tag', 'type' => 'text', 'default' => 'FAQ'],
                'about.faq.title' => ['label' => 'FAQ heading', 'type' => 'text', 'default' => 'Frequently asked questions'],
                'about.cta.image' => ['label' => 'Call to action picture', 'type' => 'image', 'default' => '/images/pages/about-cta.jpg'],
                'about.cta.title' => ['label' => 'Call to action heading', 'type' => 'text', 'default' => 'Want to know more?'],
                'about.cta.text' => ['label' => 'Call to action text', 'type' => 'textarea', 'default' => 'Our team is happy to answer any question.'],
                'about.cta.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Contact us'],
                'about.cta.button2' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'View packages'],
            ],
        ],
    ],
];
