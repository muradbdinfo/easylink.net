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
                'speedtest.heading' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Check Your Internet Speed'],
                'speedtest.subtitle' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => 'The Test Starts By Itself. Close Other Downloads For The Most Accurate Result.'],
                'speedtest.embed_url' => ['label' => 'Speed test address (embedded)', 'type' => 'url', 'default' => 'https://fast.com/', 'help' => 'The page shown inside the box. Use your own speed test server here if you have one.'],
                'speedtest.embed_height' => ['label' => 'Box height in pixels', 'type' => 'text', 'default' => '560'],
                'speedtest.open_label' => ['label' => 'Link text under the box (opens the test in a new tab)', 'type' => 'text', 'default' => 'Open The Speed Test In A New Tab'],
                'speedtest.note' => ['label' => 'Small print', 'type' => 'textarea', 'default' => 'Wi-Fi, Other Devices And Your Phone Or Computer Can Lower The Result. For The Real Line Speed, Use A LAN Cable.'],
            ],
        ],
        [
            'title' => 'Tips under the test',
            'fields' => [
                'speedtest.tips' => [
                    'label' => 'Tips',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'wifi', 'title' => 'Use A Cable If You Can', 'text' => 'A LAN Cable Shows Your Real Line Speed; Wi-Fi Is Usually Slower.'],
                        ['icon' => 'device-phone-mobile', 'title' => 'Pause Other Devices', 'text' => 'Streaming, Updates And Downloads On Other Devices Share The Same Line.'],
                        ['icon' => 'headset', 'title' => 'Still Slow?', 'text' => 'Call Our Support Team And We Will Check Your Connection.'],
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
