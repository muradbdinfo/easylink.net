<?php

/* Picture panel of the sign-in / password screens. */

return [
    'page' => 'Login screens',
    'sections' => [
        [
            'title' => 'Picture panel',
            'fields' => [
                'auth.brand.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/auth-city.jpg'],
                'auth.brand.eyebrow' => ['label' => 'Small tag', 'type' => 'text', 'default' => 'Welcome Back'],
                'auth.brand.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Keeping The City Connected'],
                'auth.brand.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Manage Packages, Content And Customer Messages From One Simple Dashboard.'],
                'auth.brand.points' => [
                    'label' => 'Highlights',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'shield-check', 'text' => 'Secure Sign-In'],
                        ['icon' => 'bolt', 'text' => 'Fast And Simple'],
                        ['icon' => 'headset', 'text' => 'Support When You Need It'],
                    ],
                    'fields' => [
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'text' => ['label' => 'Text', 'type' => 'text'],
                    ],
                ],
                'auth.login.title' => ['label' => 'Admin login heading', 'type' => 'text', 'default' => 'EasyLink Admin Login'],
                'auth.back_to_site' => ['label' => 'Back-to-website link text', 'type' => 'text', 'default' => 'Back To Website'],
            ],
        ],
    ],
];
