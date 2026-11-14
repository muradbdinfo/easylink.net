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
                'about.story.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Our Story'],
                'about.story.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Who We Are'],
                'about.story.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/about-story.jpg'],
                'about.story.badge_title' => ['label' => 'Badge on the picture - title', 'type' => 'text', 'default' => 'Local Team'],
                'about.story.badge_text' => ['label' => 'Badge on the picture - text', 'type' => 'text', 'default' => 'Engineers You Can Call'],
                'about.story.badge_icon' => ['label' => 'Badge icon', 'type' => 'icon', 'default' => 'headset'],
            ],
        ],
        [
            'title' => 'Mission, vision & values',
            'fields' => [
                'about.pillars.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'What Drives Us'],
                'about.pillars.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Mission, Vision & Values'],
                'about.pillars.subtitle' => ['label' => 'Subtitle', 'type' => 'textarea', 'default' => 'The Promises Behind Every Connection We Install.'],
                'about.pillars.items' => [
                    'label' => 'Cards',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'rocket-launch', 'title' => 'Our Mission', 'text' => 'Deliver Fast, Stable And Fairly Priced Internet To Every Home And Business We Serve.'],
                        ['icon' => 'eye', 'title' => 'Our Vision', 'text' => 'A Fully Connected Community Where Great Internet Is As Dependable As Electricity.'],
                        ['icon' => 'heart', 'title' => 'Our Values', 'text' => 'Honest Pricing, Quick Support And Respect For Every Customer, Big Or Small.'],
                    ],
                    'fields' => $iconTitleText,
                ],
            ],
        ],
        [
            'title' => 'Numbers strip (numbers come from "Stats counter")',
            'fields' => [
                'about.stats.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'In Numbers'],
                'about.stats.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Trusted By Thousands'],
            ],
        ],
        [
            'title' => 'Why choose us',
            'fields' => [
                'about.why.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Why Us'],
                'about.why.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Why Customers Stay With Us'],
                'about.why.items' => [
                    'label' => 'Points',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'bolt', 'title' => 'Reliable Network', 'text' => 'Redundant Fiber Links Keep You Online.'],
                        ['icon' => 'headset', 'title' => 'Real Support', 'text' => 'People Who Pick Up The Phone, Day Or Night.'],
                        ['icon' => 'banknotes', 'title' => 'Fair Pricing', 'text' => 'Clear Plans With No Hidden Fees.'],
                        ['icon' => 'map-pin', 'title' => 'Local Expertise', 'text' => 'Our Engineers Live And Work In Your Area.'],
                    ],
                    'fields' => $iconTitleText,
                ],
            ],
        ],
        [
            'title' => 'Partners, FAQ and call to action',
            'fields' => [
                'about.partners.label' => ['label' => 'Partners strip label', 'type' => 'text', 'default' => 'Technology Partners & Clients'],
                'about.faq.eyebrow' => ['label' => 'FAQ small tag', 'type' => 'text', 'default' => 'FAQ'],
                'about.faq.title' => ['label' => 'FAQ heading', 'type' => 'text', 'default' => 'Frequently Asked Questions'],
                'about.cta.image' => ['label' => 'Call to action picture', 'type' => 'image', 'default' => '/images/pages/about-cta.jpg'],
                'about.cta.title' => ['label' => 'Call to action heading', 'type' => 'text', 'default' => 'Want To Know More?'],
                'about.cta.text' => ['label' => 'Call to action text', 'type' => 'textarea', 'default' => 'Our Team Is Happy To Answer Any Question.'],
                'about.cta.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'Contact Us'],
                'about.cta.button2' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'View Packages'],
            ],
        ],
    ],
];
