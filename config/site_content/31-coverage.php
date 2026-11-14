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
                'coverage.search.title' => ['label' => 'Card heading', 'type' => 'text', 'default' => 'Is EasyLink Available At Your Place?'],
                'coverage.search.text' => ['label' => 'Card text', 'type' => 'textarea', 'default' => 'Choose Your District And Thana To Check Fiber Availability Instantly.'],
                'coverage.search.district_label' => ['label' => 'District label', 'type' => 'text', 'default' => 'District'],
                'coverage.search.district_placeholder' => ['label' => 'District placeholder', 'type' => 'text', 'default' => 'Select A District'],
                'coverage.search.upazila_label' => ['label' => 'Thana / Upazila label', 'type' => 'text', 'default' => 'Thana / Upazila'],
                'coverage.search.upazila_placeholder' => ['label' => 'Thana / Upazila placeholder', 'type' => 'text', 'default' => 'Select A Thana / Upazila'],
                'coverage.search.button' => ['label' => 'Button text', 'type' => 'text', 'default' => 'Check Availability'],
            ],
        ],
        [
            'title' => 'Result messages',
            'fields' => [
                'coverage.result.available' => ['label' => 'Available message', 'type' => 'text', 'default' => 'Good News! EasyLink Is Available In {Upazilla}, {District}.'],
                'coverage.result.unavailable' => ['label' => 'Not available message', 'type' => 'text', 'default' => "Sorry, We Haven't Reached {Upazilla}, {District} Yet."],
                'coverage.result.unavailable_note' => ['label' => 'Not available — extra line', 'type' => 'textarea', 'default' => 'Leave Your Details And We Will Tell You As Soon As Fiber Reaches Your Area.'],
                'coverage.result.packages_button' => ['label' => 'Button when available', 'type' => 'text', 'default' => 'View Packages'],
                'coverage.result.contact_button' => ['label' => 'Button when not available', 'type' => 'text', 'default' => 'Contact Us'],
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
                    ['icon' => 'wifi', 'title' => 'Fiber To The Home', 'text' => 'Stable, Symmetrical Speeds On A Pure Fiber Network.'],
                    ['icon' => 'gift', 'title' => 'Free Installation', 'text' => 'No Setup Fee On All Home Plans.'],
                    ['icon' => 'clock', 'title' => 'Quick Activation', 'text' => 'Most New Connections Go Live Within 48 Hours.'],
                ]],
            ],
        ],
        [
            'title' => 'Areas we cover',
            'fields' => [
                'coverage.areas.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Areas We Cover'],
                'coverage.areas.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'We Are Growing Every Month. These Districts Are Live Today.'],
                'coverage.areas.count_one' => ['label' => 'Label after the count when there is 1 area', 'type' => 'text', 'default' => 'Area'],
                'coverage.areas.count_many' => ['label' => 'Label after the count when there are several areas', 'type' => 'text', 'default' => 'Areas'],
            ],
        ],
        [
            'title' => 'Bottom call-to-action',
            'fields' => [
                'coverage.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => "Can't Find Your Area?"],
                'coverage.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Tell Us Where You Are — We Prioritise New Areas Based On Demand.'],
                'coverage.cta.button' => ['label' => 'Button text', 'type' => 'text', 'default' => 'Request A Connection'],
                'coverage.cta.button_url' => ['label' => 'Button link', 'type' => 'url', 'default' => '/contact'],
            ],
        ],
    ],
];
