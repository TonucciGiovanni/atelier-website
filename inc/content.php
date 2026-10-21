<?php
if (!defined('ABSPATH')) { exit; }

function atelier_register_content(): void {
    register_post_type('atelier_service', [
        'labels' => ['name' => 'Services', 'singular_name' => 'Service'],
        'public' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-art',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'rewrite' => ['slug' => 'service'], 'has_archive' => false,
    ]);
    register_post_type('atelier_project', [
        'labels' => ['name' => 'Work', 'singular_name' => 'Project'],
        'public' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes'],
        'rewrite' => ['slug' => 'work'], 'has_archive' => false,
    ]);
}
add_action('init', 'atelier_register_content');

function atelier_service_groups(): array {
    return [
        ['key' => 'design', 'number' => '01', 'short' => 'Design', 'title' => 'Design Your Presence', 'summary' => 'We shape clear, distinctive digital experiences around your brand and audience.', 'services' => ['Web Design', 'Website Redesign']],
        ['key' => 'build', 'number' => '02', 'short' => 'Build', 'title' => 'Build Your Platform', 'summary' => 'We develop reliable digital platforms designed to work smoothly and grow with your business.', 'services' => ['Web Development', 'E-commerce', 'Mobile App Development']],
        ['key' => 'grow', 'number' => '03', 'short' => 'Grow', 'title' => 'Grow Your Business', 'summary' => 'We help your business get discovered, communicate clearly and reach the right audience.', 'services' => ['SEO', 'Marketing']],
    ];
}

function atelier_service_descriptions(): array {
    return [
        'Web Design' => 'Clear, user-focused interfaces shaped around your business and audience.',
        'Website Redesign' => 'A focused rethink for websites that feel dated, unclear or difficult to use.',
        'Web Development' => 'Fast, responsive websites built to remain reliable and easy to manage.',
        'E-commerce' => 'Online stores that make products easy to discover, understand and purchase.',
        'Mobile App Development' => 'Thoughtful mobile-product planning, interface design and development.',
        'SEO' => 'Technical and content foundations that help the right people discover you.',
        'Marketing' => 'Messaging, campaigns and launch content that keep your brand consistent.',
    ];
}

function atelier_projects(): WP_Query {
    return new WP_Query(['post_type' => 'atelier_project', 'posts_per_page' => 6, 'orderby' => ['menu_order' => 'ASC', 'date' => 'DESC']]);
}

