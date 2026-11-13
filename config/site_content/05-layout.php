<?php

/*
 * Site header (menu, button, top bar) and footer (links, headings, credits).
 * Used by resources/js/Components/Public/SiteHeader.vue and SiteFooter.vue.
 * Links: use a path like /packages for pages on this site, a full https:// address for other sites,
 * or /#entertainment to jump to a section of the home page.
 */

$link = fn (string $label, string $href, string $icon) => ['label' => $label, 'href' => $href, 'icon' => $icon];

$linkFields = [
    'label' => ['label' => 'Text', 'type' => 'text'],
    'href' => ['label' => 'Link', 'type' => 'url'],
    'icon' => ['label' => 'Icon', 'type' => 'icon'],
];

return [
    'page' => 'Header & footer',
    'sections' => [
        [
            'title' => 'Top bar and header',
            'fields' => [
                'layout.header.support_label' => ['label' => 'Label before the support number', 'type' => 'text', 'default' => 'Support:'],
                'layout.header.selfcare_label' => ['label' => 'Self-care login text', 'type' => 'text', 'default' => 'Self Care'],
                'layout.header.selfcare_url' => ['label' => 'Self-care login link', 'type' => 'url', 'default' => 'https://internet.easyiterp.com/portal/login', 'help' => 'Opens in a new tab.'],
                'layout.header.admin_label' => ['label' => 'Admin panel link text (shown to logged-in admins)', 'type' => 'text', 'default' => 'Admin Panel'],
                'layout.header.button_label' => ['label' => 'Header button text', 'type' => 'text', 'default' => 'Get a quote'],
                'layout.header.button_url' => ['label' => 'Header button link', 'type' => 'url', 'default' => '/contact'],
                'layout.header.logo_tagline' => ['label' => 'Text next to the logo (header and footer)', 'type' => 'text', 'default' => 'Internet Service Provider', 'help' => 'Leave empty to hide it.'],
                'layout.header.menu_label' => ['label' => 'Mobile menu button label (for screen readers)', 'type' => 'text', 'default' => 'Toggle menu'],
            ],
        ],
        [
            'title' => 'Main menu',
            'fields' => [
                'layout.menu' => [
                    'label' => 'Menu items (top to bottom)',
                    'type' => 'list',
                    'default' => [
                        $link('Home', '/', 'home'),
                        $link('About', '/about', 'user-group'),
                        $link('Our Packages', '/packages', 'cube'),
                        $link('Speed Test', '/speed-test', 'bolt'),
                        $link('Payment', '/payment', 'banknotes'),
                        $link('Services', '/services', 'wrench'),
                        $link('Contact', '/contact', 'chat-bubble-left-right'),
                    ],
                    'fields' => $linkFields,
                ],
            ],
        ],
        [
            'title' => 'Footer',
            'fields' => [
                'layout.footer.quick_title' => ['label' => 'First link list heading', 'type' => 'text', 'default' => 'Quick links'],
                'layout.footer.quick_links' => [
                    'label' => 'First link list',
                    'type' => 'list',
                    'default' => [
                        $link('Our Packages', '/packages', 'cube'),
                        $link('Services', '/services', 'wrench'),
                        $link('About us', '/about', 'user-group'),
                        $link('Contact', '/contact', 'chat-bubble-left-right'),
                        $link('Self-Care Login', 'https://internet.easyiterp.com/portal/login', 'key'),
                    ],
                    'fields' => $linkFields,
                ],
                'layout.footer.company_title' => ['label' => 'Second link list heading (the list is hidden while it has no links)', 'type' => 'text', 'default' => 'Company'],
                'layout.footer.company_links' => [
                    'label' => 'Second link list',
                    'type' => 'list',
                    'default' => [
                    ],
                    'fields' => $linkFields,
                ],
                'layout.footer.contact_title' => ['label' => 'Contact column heading', 'type' => 'text', 'default' => 'Get in touch'],
                'layout.footer.call_label' => ['label' => 'Footer — text above the phone numbers', 'type' => 'text', 'default' => 'Call us 24/7'],
                'layout.footer.contact_info_title' => ['label' => 'Footer — contact info heading', 'type' => 'text', 'default' => 'Contact info'],
                'layout.footer.about_title' => ['label' => 'Footer — "who we are" heading', 'type' => 'text', 'default' => 'Who we are'],
                'layout.footer.about_text' => ['label' => 'Footer — "who we are" text', 'type' => 'textarea', 'default' => '', 'help' => 'Leave empty to use the short About text from Settings.'],
                'layout.footer.schedule_title' => ['label' => 'Footer — service schedule heading', 'type' => 'text', 'default' => 'Service schedule'],
                'layout.footer.schedule' => [
                    'label' => 'Footer — service schedule',
                    'type' => 'list',
                    'default' => [
                        ['days' => 'Every day', 'time' => 'Support available 24/7'],
                    ],
                    'fields' => [
                        'days' => ['label' => 'Days', 'type' => 'text'],
                        'time' => ['label' => 'Time', 'type' => 'text'],
                    ],
                ],
                'layout.footer.copyright' => ['label' => 'Copyright text after the year and site name', 'type' => 'text', 'default' => 'All rights reserved.'],
                'layout.footer.credit_prefix' => ['label' => 'Credit text', 'type' => 'text', 'default' => 'Developed by'],
                'layout.footer.credit_name' => ['label' => 'Credit name', 'type' => 'text', 'default' => 'Easy IT'],
                'layout.footer.credit_url' => ['label' => 'Credit link', 'type' => 'url', 'default' => 'https://www.easyit.com.bd'],
            ],
        ],
    ],
];
