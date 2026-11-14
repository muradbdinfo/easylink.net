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
                'contact.cards.directions' => ['label' => 'Directions link text', 'type' => 'text', 'default' => 'Get Directions →'],
                'contact.cards.hours_title' => ['label' => 'Hours card title', 'type' => 'text', 'default' => 'Support Hours'],
                'contact.cards.hours_text' => ['label' => 'Hours card text', 'type' => 'textarea', 'default' => 'Open 24/7, Including Weekends And Holidays.'],
            ],
        ],
        [
            'title' => 'Message form',
            'fields' => [
                'contact.form.title' => ['label' => 'Form heading', 'type' => 'text', 'default' => 'Send Us A Message'],
                'contact.form.text' => ['label' => 'Text under the heading', 'type' => 'textarea', 'default' => "Fill In The Form And We'll Get Back To You Shortly."],
                'contact.form.name' => ['label' => 'Name label', 'type' => 'text', 'default' => 'Name *'],
                'contact.form.email' => ['label' => 'Email label', 'type' => 'text', 'default' => 'Email *'],
                'contact.form.phone' => ['label' => 'Phone label', 'type' => 'text', 'default' => 'Phone'],
                'contact.form.subject' => ['label' => 'Subject label', 'type' => 'text', 'default' => 'Subject'],
                'contact.form.package' => ['label' => 'Selected package label', 'type' => 'text', 'default' => 'Selected Package'],
                'contact.form.message' => ['label' => 'Message label', 'type' => 'text', 'default' => 'Message *'],
                'contact.form.button' => ['label' => 'Send button text', 'type' => 'text', 'default' => 'Send Message'],
                'contact.form.sending' => ['label' => 'Button text while sending', 'type' => 'text', 'default' => 'Sending...'],
            ],
        ],
        [
            'title' => 'Promise strip (with picture)',
            'fields' => [
                'contact.strip.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/contact-office.jpg'],
                'contact.strip.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'A Real Team, Ready To Help'],
                'contact.strip.items' => ['label' => 'Points', 'type' => 'list', 'fields' => [
                    'icon' => ['label' => 'Icon', 'type' => 'icon'],
                    'title' => ['label' => 'Title', 'type' => 'text'],
                    'text' => ['label' => 'Text', 'type' => 'textarea'],
                ], 'default' => [
                    ['icon' => 'clock', 'title' => 'Quick Replies', 'text' => 'We Answer Most Messages Within One Hour.'],
                    ['icon' => 'headset', 'title' => '24/7 Hotline', 'text' => 'Call Us Any Time For Urgent Problems.'],
                    ['icon' => 'wrench', 'title' => 'Free Site Visit', 'text' => 'Our Engineers Visit And Plan Your Connection.'],
                ]],
            ],
        ],
        [
            'title' => 'Map',
            'fields' => [
                'contact.map.title' => ['label' => 'Heading above the map', 'type' => 'text', 'default' => 'Find Us'],
                'contact.map.button' => ['label' => 'Open-in-maps button text', 'type' => 'text', 'default' => 'Open In Google Maps'],
            ],
        ],
    ],
];
