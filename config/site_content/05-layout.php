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
                'layout.header.selfcare_label' => ['label' => 'Self-care login text', 'type' => 'text', 'default' => 'Self-Care Login'],
                'layout.header.selfcare_url' => ['label' => 'Self-care login link', 'type' => 'url', 'default' => 'https://internet.easyit.com.bd/portal/login', 'help' => 'Opens in a new tab.'],
                'layout.header.admin_label' => ['label' => 'Admin panel link text (shown to logged-in admins)', 'type' => 'text', 'default' => 'Admin Panel'],
                'layout.header.button_label' => ['label' => 'Header button text', 'type' => 'text', 'default' => 'Get a quote'],
                'layout.header.button_url' => ['label' => 'Header button link', 'type' => 'url', 'default' => '/contact'],
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
                        $link('Packages', '/packages', 'cube'),
                        $link('Corporate', '/corporate', 'building-office'),
                        $link('Services', '/services', 'wrench'),
                        $link('Entertainment', '/#entertainment', 'tv'),
                        $link('Coverage', '/coverage', 'map-pin'),
                        $link('Blog', '/blog', 'newspaper'),
                        $link('About', '/about', 'user-group'),
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
                        $link('Packages', '/packages', 'cube'),
                        $link('Corporate solutions', '/corporate', 'building-office'),
                        $link('Services', '/services', 'wrench'),
                        $link('Check coverage', '/coverage', 'map-pin'),
                        $link('Blog', '/blog', 'newspaper'),
                    ],
                    'fields' => $linkFields,
                ],
                'layout.footer.company_title' => ['label' => 'Second link list heading', 'type' => 'text', 'default' => 'Company'],
                'layout.footer.company_links' => [
                    'label' => 'Second link list',
                    'type' => 'list',
                    'default' => [
                        $link('About us', '/about', 'user-group'),
                        $link('Contact', '/contact', 'chat-bubble-left-right'),
                        $link('Self-Care Login', 'https://internet.easyit.com.bd/portal/login', 'key'),
                    ],
                    'fields' => $linkFields,
                ],
                'layout.footer.contact_title' => ['label' => 'Contact column heading', 'type' => 'text', 'default' => 'Get in touch'],
                'layout.footer.copyright' => ['label' => 'Copyright text after the year and site name', 'type' => 'text', 'default' => 'All rights reserved.'],
                'layout.footer.credit_prefix' => ['label' => 'Credit text', 'type' => 'text', 'default' => 'Developed by'],
                'layout.footer.credit_name' => ['label' => 'Credit name', 'type' => 'text', 'default' => 'Easy IT'],
                'layout.footer.credit_url' => ['label' => 'Credit link', 'type' => 'url', 'default' => 'https://www.easyit.com.bd'],
            ],
        ],
    ],
];
