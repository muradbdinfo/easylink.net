<?php

/*
 * Payment page (/payment). The banner at the top comes from 00-page-headers.php (payment.hero.*).
 * Numbers are left empty on purpose: add the real bKash / Nagad / Rocket / bank details from the admin panel.
 * While a number is empty the page shows "call us for the number" instead of a made-up one.
 */

return [
    'page' => 'Payment',
    'sections' => [
        [
            'title' => 'Page heading',
            'fields' => [
                'payment.heading' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Pay Your Internet Bill'],
                'payment.intro' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => 'Pay In A Minute From Your Phone. Always Write Your Customer ID As The Reference, So We Can Match Your Payment Right Away.'],
                'payment.copy' => ['label' => '"Copy" button', 'type' => 'text', 'default' => 'Copy'],
                'payment.copied' => ['label' => 'Text after copying', 'type' => 'text', 'default' => 'Copied'],
                'payment.no_number' => ['label' => 'Text while a number is not set ({phone} = hotline)', 'type' => 'text', 'default' => 'Call {Phone} For The Number'],
            ],
        ],
        [
            'title' => 'bKash — Send Money',
            'fields' => [
                'payment.bkash.title' => ['label' => 'bKash block heading', 'type' => 'text', 'default' => 'Pay With bKash'],
                'payment.bkash.text' => ['label' => 'bKash block text', 'type' => 'textarea', 'default' => 'Choose Send Money Or Merchant Payment, Whichever You Like.'],
                'payment.bkash.send_tab' => ['label' => 'Tab name', 'type' => 'text', 'default' => 'Send Money'],
                'payment.bkash.send_number_label' => ['label' => 'Number label', 'type' => 'text', 'default' => 'Our bKash Personal Number'],
                'payment.bkash.send_number' => ['label' => 'bKash personal number', 'type' => 'text', 'default' => '', 'help' => 'Example: 01XXXXXXXXX. Leave empty to show "call us for the number".'],
                'payment.bkash.send_steps' => ['label' => 'Steps (one per line)', 'type' => 'textarea', 'default' => "Open The bKash App And Sign In\nTap Send Money\nEnter Our bKash Number\nEnter Your Bill Amount\nWrite Your Customer ID In The Reference Box\nEnter Your PIN To Confirm"],
            ],
        ],
        [
            'title' => 'bKash — Merchant Payment',
            'fields' => [
                'payment.bkash.merchant_tab' => ['label' => 'Tab name', 'type' => 'text', 'default' => 'Merchant Payment'],
                'payment.bkash.merchant_number_label' => ['label' => 'Number label', 'type' => 'text', 'default' => 'Our bKash Merchant Number'],
                'payment.bkash.merchant_number' => ['label' => 'bKash merchant number', 'type' => 'text', 'default' => '', 'help' => 'Leave empty to show "call us for the number".'],
                'payment.bkash.merchant_counter_label' => ['label' => 'Counter label', 'type' => 'text', 'default' => 'Counter Number'],
                'payment.bkash.merchant_counter' => ['label' => 'Counter number (optional)', 'type' => 'text', 'default' => ''],
                'payment.bkash.merchant_steps' => ['label' => 'Steps (one per line)', 'type' => 'textarea', 'default' => "Open The bKash App And Sign In\nTap Payment\nEnter Our Merchant Number\nEnter Your Bill Amount\nWrite Your Customer ID In The Reference Box\nEnter Your PIN To Confirm"],
            ],
        ],
        [
            'title' => 'Bangla QR',
            'fields' => [
                'payment.qr.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Pay By Scanning A Bangla QR'],
                'payment.qr.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Scan With bKash Or Any Bank App That Supports Bangla QR. No Need To Type The Number.'],
                'payment.qr.merchant_image' => ['label' => 'QR 1 — picture', 'type' => 'image', 'default' => '/banglaqr/bkash-bangla-qr.jpeg'],
                'payment.qr.merchant_label' => ['label' => 'QR 1 — title', 'type' => 'text', 'default' => 'Merchant Payment QR'],
                'payment.qr.merchant_caption' => ['label' => 'QR 1 — small text', 'type' => 'text', 'default' => 'Scan With The bKash App And Choose Payment'],
                'payment.qr.send_image' => ['label' => 'QR 2 — picture', 'type' => 'image', 'default' => '/banglaqr/banglaqr-sendmony-bank.jpeg'],
                'payment.qr.send_label' => ['label' => 'QR 2 — title', 'type' => 'text', 'default' => 'Send Money QR'],
                'payment.qr.send_caption' => ['label' => 'QR 2 — small text', 'type' => 'text', 'default' => 'Scan With bKash Or Any Bank App And Send Money'],
            ],
        ],
        [
            'title' => 'Reference reminder',
            'fields' => [
                'payment.reference_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Your Reference Is Your Customer ID'],
                'payment.reference_text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Without It We Cannot Tell Whose Payment It Is. You Will Find Your Customer ID On Your Invoice.'],
            ],
        ],
        [
            'title' => 'Other ways to pay',
            'fields' => [
                'payment.methods_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Other Ways To Pay'],
                'payment.methods' => [
                    'label' => 'Methods',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'device-phone-mobile', 'name' => 'Nagad', 'number' => '', 'text' => 'Send Money To Our Nagad Number And Write Your Customer ID As The Reference.', 'steps' => ''],
                        ['icon' => 'device-phone-mobile', 'name' => 'Rocket', 'number' => '', 'text' => 'Send Money To Our Rocket Number And Write Your Customer ID As The Reference.', 'steps' => ''],
                        ['icon' => 'building-library', 'name' => 'Bank Transfer', 'number' => '', 'text' => 'Transfer To Our Bank Account, Then Send Us The Receipt With Your Customer ID.', 'steps' => ''],
                    ],
                    'fields' => [
                        'name' => ['label' => 'Name', 'type' => 'text'],
                        'icon' => ['label' => 'Icon', 'type' => 'icon'],
                        'number' => ['label' => 'Number / account (shown big, with a copy button)', 'type' => 'text'],
                        'text' => ['label' => 'Short text', 'type' => 'textarea'],
                        'steps' => ['label' => 'Steps (one per line, optional)', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'How it works',
            'fields' => [
                'payment.steps_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'How It Works'],
                'payment.steps' => [
                    'label' => 'Steps',
                    'type' => 'list',
                    'default' => [
                        ['title' => 'Find Your Customer ID', 'text' => 'It Is Printed On Your Invoice.'],
                        ['title' => 'Pay And Add The Reference', 'text' => 'Send The Amount And Write Your Customer ID As The Reference.'],
                        ['title' => 'Keep The Receipt', 'text' => 'If The Payment Does Not Show Up, Send Us The Receipt.'],
                    ],
                    'fields' => [
                        'title' => ['label' => 'Title', 'type' => 'text'],
                        'text' => ['label' => 'Text', 'type' => 'textarea'],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Help box',
            'fields' => [
                'payment.help_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Need Help With Your Payment?'],
                'payment.help_text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Call Our Hotline And We Will Help You Right Away.'],
                'payment.help_button' => ['label' => 'Button label', 'type' => 'text', 'default' => 'Contact Us'],
                'payment.help_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/contact'],
            ],
        ],
    ],
];
