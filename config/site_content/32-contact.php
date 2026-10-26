<?php

/*
 * Contact page. The banner (title, picture, icon) is in 00-page-headers.php.
 * Phone numbers, e-mail, address and map links come from Settings.
 */

return [
    'page' => 'Contact',
    'sections' => [
        [
            'title' => 'Info cards',
            'fields' => [
                'contact.cards.support_title' => ['label' => 'Support card title', 'type' => 'text', 'default' => 'Support'],
                'contact.cards.email_title' => ['label' => 'Email card title', 'type' => 'text', 'default' => 'Email'],
                'contact.cards.address_title' => ['label' => 'Address card title', 'type' => 'text', 'default' => 'Address'],
                'contact.cards.directions' => ['label' => 'Directions link text', 'type' => 'text', 'default' => 'Get directions →'],
                'contact.cards.hours_title' => ['label' => 'Hours card title', 'type' => 'text', 'default' => 'Support hours'],
                'contact.cards.hours_text' => ['label' => 'Hours card text', 'type' => 'textarea', 'default' => 'Open 24/7, including weekends and holidays.'],
            ],
        ],
        [
            'title' => 'Message form',
            'fields' => [
                'contact.form.title' => ['label' => 'Form heading', 'type' => 'text', 'default' => 'Send us a message'],
                'contact.form.text' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => "Fill in the form and we'll get back to you shortly."],
                'contact.form.name' => ['label' => 'Name label', 'type' => 'text', 'default' => 'Name *'],
                'contact.form.email' => ['label' => 'Email label', 'type' => 'text', 'default' => 'Email *'],
                'contact.form.phone' => ['label' => 'Phone label', 'type' => 'text', 'default' => 'Phone'],
                'contact.form.subject' => ['label' => 'Subject label', 'type' => 'text', 'default' => 'Subject'],
                'contact.form.package' => ['label' => 'Selected package label', 'type' => 'text', 'default' => 'Selected package'],
                'contact.form.message' => ['label' => 'Message label', 'type' => 'text', 'default' => 'Message *'],
                'contact.form.button' => ['label' => 'Send button text', 'type' => 'text', 'default' => 'Send message'],
                'contact.form.sending' => ['label' => 'Button text while sending', 'type' => 'text', 'default' => 'Sending...'],
            ],
        ],
        [
            'title' => 'Promise strip (with picture)',
            'fields' => [
                'contact.strip.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/contact-office.jpg'],
                'contact.strip.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'A real team, ready to help'],
                'contact.strip.items' => ['label' => 'Points', 'type' => 'list', 'fields' => [
                    'icon' => ['label' => 'Icon', 'type' => 'icon'],
                    'title' => ['label' => 'Title', 'type' => 'text'],
                    'text' => ['label' => 'Text', 'type' => 'textarea'],
                ], 'default' => [
                    ['icon' => 'clock', 'title' => 'Quick replies', 'text' => 'We answer most messages within one hour.'],
                    ['icon' => 'headset', 'title' => '24/7 hotline', 'text' => 'Call us any time for urgent problems.'],
                    ['icon' => 'wrench', 'title' => 'Free site visit', 'text' => 'Our engineers visit and plan your connection.'],
                ]],
            ],
        ],
        [
            'title' => 'Map',
            'fields' => [
                'contact.map.title' => ['label' => 'Heading above the map', 'type' => 'text', 'default' => 'Find us'],
                'contact.map.button' => ['label' => 'Open-in-maps button text', 'type' => 'text', 'default' => 'Open in Google Maps'],
            ],
        ],
    ],
];
