<?php

/* Blog list and post pages (the list banner lives in 00-page-headers.php). */

return [
    'page' => 'Blog',
    'sections' => [
        [
            'title' => 'Blog list',
            'fields' => [
                'blog.index.featured_label' => ['label' => 'Featured post label', 'type' => 'text', 'default' => 'Featured story'],
                'blog.index.latest_title' => ['label' => 'Latest posts heading', 'type' => 'text', 'default' => 'Latest articles'],
                'blog.index.read_more' => ['label' => 'Read more text', 'type' => 'text', 'default' => 'Read more'],
                'blog.index.empty' => ['label' => 'Text when there are no posts', 'type' => 'text', 'default' => 'No posts yet.'],
            ],
        ],
        [
            'title' => 'Call to action band (list and post pages)',
            'fields' => [
                'blog.cta.image' => ['label' => 'Picture', 'type' => 'image', 'default' => '/images/pages/blog-cta.jpg'],
                'blog.cta.icon' => ['label' => 'Icon', 'type' => 'icon', 'default' => 'rocket-launch'],
                'blog.cta.title' => ['label' => 'Heading', 'type' => 'text', 'default' => 'Ready for faster internet?'],
                'blog.cta.text' => ['label' => 'Text', 'type' => 'textarea', 'default' => 'Pick a plan or talk to our team about your home or business.'],
                'blog.cta.button' => ['label' => 'Main button text', 'type' => 'text', 'default' => 'View packages'],
                'blog.cta.button2' => ['label' => 'Second button text', 'type' => 'text', 'default' => 'Contact us'],
            ],
        ],
        [
            'title' => 'Post page',
            'fields' => [
                'blog.show.back' => ['label' => 'Back link text', 'type' => 'text', 'default' => 'Back to blog'],
                'blog.show.read_time' => ['label' => 'Reading time text (after the number)', 'type' => 'text', 'default' => 'min read'],
                'blog.show.share' => ['label' => 'Share label', 'type' => 'text', 'default' => 'Share this post'],
                'blog.show.recent' => ['label' => 'Recent posts heading', 'type' => 'text', 'default' => 'Recent posts'],
            ],
        ],
    ],
];
