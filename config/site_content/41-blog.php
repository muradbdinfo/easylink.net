<?php

/* Blog list and post pages (the list banner lives in 00-page-headers.php). */

return [
    'page' => 'Blog',
    'sections' => [
        [
            'title' => 'Blog list',
            'fields' => [
                'blog.index.featured_label' => ['label' => 'Featured post label', 'type' => 'text', 'default' => 'Featured Story'],
                'blog.index.latest_title' => ['label' => 'Latest posts heading', 'type' => 'text', 'default' => 'Latest Articles'],
                'blog.index.read_more' => ['label' => 'Read more text', 'type' => 'text', 'default' => 'Read More'],
                'blog.index.empty' => ['label' => 'Text when there are no posts', 'type' => 'text', 'default' => 'No Posts Yet.'],
            ],
        ],
        [
            'title' => 'Call to action band (list and post pages)',
            'fields' => [
                'blog.cta.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/blog-cta.jpg'],
                'blog.cta.icon' => ['label' => 'Icon', 'type' => 'icon', 'default' => 'rocket-launch'],
                'blog.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Ready For Faster Internet?'],
                'blog.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Pick A Plan Or Talk To Our Team About Your Home Or Business.'],
                'blog.cta.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'View Packages'],
                'blog.cta.button2' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'Contact Us'],
            ],
        ],
        [
            'title' => 'Post page',
            'fields' => [
                'blog.show.back' => ['label' => 'Back link text', 'type' => 'text', 'default' => 'Back To Blog'],
                'blog.show.read_time' => ['label' => 'Reading time text (after the number)', 'type' => 'text', 'default' => 'Min Read'],
                'blog.show.share' => ['label' => 'Share label', 'type' => 'text', 'default' => 'Share This Post'],
                'blog.show.recent' => ['label' => 'Recent posts heading', 'type' => 'text', 'default' => 'Recent Posts'],
            ],
        ],
    ],
];
