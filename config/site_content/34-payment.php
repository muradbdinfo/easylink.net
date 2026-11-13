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
                'payment.heading' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Pay your internet bill'],
                'payment.intro' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => 'Pay in a minute from your phone. Always write your customer ID as the reference, so we can match your payment right away.'],
                'payment.copy' => ['label' => '"Copy" button', 'type' => 'text', 'default' => 'Copy'],
                'payment.copied' => ['label' => 'Text after copying', 'type' => 'text', 'default' => 'Copied'],
                'payment.no_number' => ['label' => 'Text while a number is not set ({phone} = hotline)', 'type' => 'text', 'default' => 'Call {phone} for the number'],
            ],
        ],
        [
            'title' => 'bKash — Send Money',
            'fields' => [
                'payment.bkash.title' => ['label' => 'bKash block heading', 'type' => 'text', 'default' => 'Pay with bKash'],
                'payment.bkash.text' => ['label' => 'bKash block text', 'type' => 'textarea', 'default' => 'Choose Send Money or Merchant Payment, whichever you like.'],
                'payment.bkash.send_tab' => ['label' => 'Tab name', 'type' => 'text', 'default' => 'Send Money'],
                'payment.bkash.send_number_label' => ['label' => 'Number label', 'type' => 'text', 'default' => 'Our bKash personal number'],
                'payment.bkash.send_number' => ['label' => 'bKash personal number', 'type' => 'text', 'default' => '', 'help' => 'Example: 01XXXXXXXXX. Leave empty to show "call us for the number".'],
                'payment.bkash.send_steps' => ['label' => 'Steps (one per line)', 'type' => 'textarea', 'default' => "Open the bKash app and sign in\nTap Send Money\nEnter our bKash number\nEnter your bill amount\nWrite your customer ID in the Reference box\nEnter your PIN to confirm"],
            ],
        ],
        [
            'title' => 'bKash — Merchant Payment',
            'fields' => [
                'payment.bkash.merchant_tab' => ['label' => 'Tab name', 'type' => 'text', 'default' => 'Merchant Payment'],
                'payment.bkash.merchant_number_label' => ['label' => 'Number label', 'type' => 'text', 'default' => 'Our bKash merchant number'],
                'payment.bkash.merchant_number' => ['label' => 'bKash merchant number', 'type' => 'text', 'default' => '', 'help' => 'Leave empty to show "call us for the number".'],
                'payment.bkash.merchant_counter_label' => ['label' => 'Counter label', 'type' => 'text', 'default' => 'Counter number'],
                'payment.bkash.merchant_counter' => ['label' => 'Counter number (optional)', 'type' => 'text', 'default' => ''],
                'payment.bkash.merchant_steps' => ['label' => 'Steps (one per line)', 'type' => 'textarea', 'default' => "Open the bKash app and sign in\nTap Payment\nEnter our merchant number\nEnter your bill amount\nWrite your customer ID in the Reference box\nEnter your PIN to confirm"],
            ],
        ],
        [
            'title' => 'Reference reminder',
            'fields' => [
                'payment.reference_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Your reference is your customer ID'],
                'payment.reference_text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Without it we cannot tell whose payment it is. You will find your customer ID on your invoice.'],
            ],
        ],
        [
            'title' => 'Other ways to pay',
            'fields' => [
                'payment.methods_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Other ways to pay'],
                'payment.methods' => [
                    'label' => 'Methods',
                    'type' => 'list',
                    'default' => [
                        ['icon' => 'device-phone-mobile', 'name' => 'Nagad', 'number' => '', 'text' => 'Send Money to our Nagad number and write your customer ID as the reference.', 'steps' => ''],
                        ['icon' => 'device-phone-mobile', 'name' => 'Rocket', 'number' => '', 'text' => 'Send Money to our Rocket number and write your customer ID as the reference.', 'steps' => ''],
                        ['icon' => 'building-library', 'name' => 'Bank transfer', 'number' => '', 'text' => 'Transfer to our bank account, then send us the receipt with your customer ID.', 'steps' => ''],
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
                'payment.steps_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'How it works'],
                'payment.steps' => [
                    'label' => 'Steps',
                    'type' => 'list',
                    'default' => [
                        ['title' => 'Find your customer ID', 'text' => 'It is printed on your invoice.'],
                        ['title' => 'Pay and add the reference', 'text' => 'Send the amount and write your customer ID as the reference.'],
                        ['title' => 'Keep the receipt', 'text' => 'If the payment does not show up, send us the receipt.'],
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
                'payment.help_title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Need help with your payment?'],
                'payment.help_text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Call our hotline and we will help you right away.'],
                'payment.help_button' => ['label' => 'Button label', 'type' => 'text', 'default' => 'Contact us'],
                'payment.help_link' => ['label' => 'Button link', 'type' => 'url', 'default' => '/contact'],
            ],
        ],
    ],
];
