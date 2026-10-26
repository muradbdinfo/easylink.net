<?php

/* Picture panel of the sign-in / password screens. */

return [
    'page' => 'Login screens',
    'sections' => [
        [
            'title' => 'Picture panel',
            'fields' => [
                'auth.brand.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/auth-city.jpg'],
                'auth.brand.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Welcome back'],
                'auth.brand.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Keeping the city connected'],
                'auth.brand.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Manage packages, content and customer messages from one simple dashboard.'],
                'auth.brand.points' => [
                    'label' => 'Highlights',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'shield-check', 'text' => 'Secure sign-in'],
                        ['icon' => 'bolt', 'text' => 'Fast and simple'],
                        ['icon' => 'headset', 'text' => 'Support when you need it'],
                    ],
                    'fields' => [
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'text' => ['label' => 'Text', 'type' => 'text'],
                    ],
                ],
                'auth.login.title' => ['label' => 'Admin login heading', 'type' => 'text', 'default' => 'EasyLink Admin Login'],
                'auth.back_to_site' => ['label' => 'Back-to-website link text', 'type' => 'text', 'default' => 'Back to website'],
            ],
        ],
    ],
];
