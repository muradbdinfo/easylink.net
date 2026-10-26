<?php

/*
 * Coverage page. The banner (title, picture, icon) is in 00-page-headers.php.
 * Use {upazilla} and {district} in the result messages — they are replaced with the chosen area.
 */

return [
    'page' => 'Coverage',
    'sections' => [
        [
            'title' => 'Search card',
            'fields' => [
                'coverage.search.image' => ['label' => 'Background picture', 'type' => 'image', 'default' => '/images/pages/coverage-city.jpg'],
                'coverage.search.title' => ['label' => 'Card heading', 'type' => 'text', 'default' => 'Is EasyLink available at your place?'],
                'coverage.search.text' => ['label' => 'Card text', 'type' => 'textarea', 'default' => 'Choose your district and thana to check fiber availability instantly.'],
                'coverage.search.district_label' => ['label' => 'District label', 'type' => 'text', 'default' => 'District'],
                'coverage.search.district_placeholder' => ['label' => 'District placeholder', 'type' => 'text', 'default' => 'Select a district'],
                'coverage.search.upazila_label' => ['label' => 'Thana / Upazila label', 'type' => 'text', 'default' => 'Thana / Upazila'],
                'coverage.search.upazila_placeholder' => ['label' => 'Thana / Upazila placeholder', 'type' => 'text', 'default' => 'Select a thana / upazila'],
                'coverage.search.button' => ['label' => 'Button text', 'type' => 'text', 'default' => 'Check availability'],
            ],
        ],
        [
            'title' => 'Result messages',
            'fields' => [
                'coverage.result.available' => ['label' => 'Available message', 'type' => 'text', 'default' => 'Good news! EasyLink is available in {upazilla}, {district}.'],
                'coverage.result.unavailable' => ['label' => 'Not available message', 'type' => 'text', 'default' => "Sorry, we haven't reached {upazilla}, {district} yet."],
                'coverage.result.unavailable_note' => ['label' => 'Not available — extra line', 'type' => 'textarea', 'default' => 'Leave your details and we will tell you as soon as fiber reaches your area.'],
                'coverage.result.packages_button' => ['label' => 'Button when available', 'type' => 'text', 'default' => 'View packages'],
                'coverage.result.contact_button' => ['label' => 'Button when not available', 'type' => 'text', 'default' => 'Contact us'],
            ],
        ],
        [
            'title' => 'Benefits strip',
            'fields' => [
                'coverage.features' => ['label' => 'Benefits', 'type' => 'list', 'fields' => [
                    'icon' => ['label' => 'Icon', 'type' => 'icon'],
                    'title' => ['label' => 'Title', 'type' => 'text'],
                    'text' => ['label' => 'Text', 'type' => 'textarea'],
                ], 'default' => [
                    ['icon' => 'wifi', 'title' => 'Fiber to the home', 'text' => 'Stable, symmetrical speeds on a pure fiber network.'],
                    ['icon' => 'gift', 'title' => 'Free installation', 'text' => 'No setup fee on all home plans.'],
                    ['icon' => 'clock', 'title' => 'Quick activation', 'text' => 'Most new connections go live within 48 hours.'],
                ]],
            ],
        ],
        [
            'title' => 'Areas we cover',
            'fields' => [
                'coverage.areas.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Areas we cover'],
                'coverage.areas.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'We are growing every month. These districts are live today.'],
                'coverage.areas.count_one' => ['label' => 'Label after the count when there is 1 area', 'type' => 'text', 'default' => 'area'],
                'coverage.areas.count_many' => ['label' => 'Label after the count when there are several areas', 'type' => 'text', 'default' => 'areas'],
            ],
        ],
        [
            'title' => 'Bottom call-to-action',
            'fields' => [
                'coverage.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => "Can't find your area?"],
                'coverage.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell us where you are — we prioritise new areas based on demand.'],
                'coverage.cta.button' => ['label' => 'Button text', 'type' => 'text', 'default' => 'Request a connection'],
                'coverage.cta.button_url' => ['label' => 'Button link', 'type' => 'url', 'default' => '/contact'],
            ],
        ],
    ],
];
