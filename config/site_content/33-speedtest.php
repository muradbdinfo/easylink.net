<?php

/*
 * Speed test page (/speed-test). The banner at the top comes from 00-page-headers.php (speedtest.hero.*).
 * The test is an embedded page (fast.com by default); any address that allows being shown inside another page works.
 */

return [
    'page' => 'Speed test',
    'sections' => [
        [
            'title' => 'Speed test',
            'fields' => [
                'speedtest.heading' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Check your internet speed'],
                'speedtest.subtitle' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => 'The test starts by itself. Close other downloads for the most accurate result.'],
                'speedtest.embed_url' => ['label' => 'Speed test address (embedded)', 'type' => 'url', 'default' => 'https://fast.com/', 'help' => 'The page shown inside the box. Use your own speed test server here if you have one.'],
                'speedtest.embed_height' => ['label' => 'Box height in pixels', 'type' => 'text', 'default' => '560'],
                'speedtest.open_label' => ['label' => 'Link text under the box (opens the test in a new tab)', 'type' => 'text', 'default' => 'Open the speed test in a new tab'],
                'speedtest.note' => ['label' => 'Small print', 'type' => 'textarea', 'default' => 'Wi-Fi, other devices and your phone or computer can lower the result. For the real line speed, use a LAN cable.'],
            ],
        ],
        [
            'title' => 'Tips under the test',
            'fields' => [
                'speedtest.tips' => [
                    'label' => 'Tips',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'wifi', 'title' => 'Use a cable if you can', 'text' => 'A LAN cable shows your real line speed; Wi-Fi is usually slower.'],
                        ['icon' => 'device-phone-mobile', 'title' => 'Pause other devices', 'text' => 'Streaming, updates and downloads on other devices share the same line.'],
                        ['icon' => 'headset', 'title' => 'Still slow?', 'text' => 'Call our support team and we will check your connection.'],
                    ],
                    'fields' => [
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'text' => ['label' => 'Text', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
    ],
];
