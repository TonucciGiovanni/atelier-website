<?php
if (!defined('ABSPATH')) { exit; }

define('ATELIER_VERSION', '0.1.1');

require_once get_template_directory() . '/inc/content.php';
require_once get_template_directory() . '/inc/inquiries.php';

function atelier_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    register_nav_menus(['primary' => __('Primary navigation', 'atelier')]);
}
add_action('after_setup_theme', 'atelier_setup');

function atelier_assets(): void {
    wp_enqueue_style('atelier-fonts', 'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap', [], null);
    wp_enqueue_style('atelier-theme', get_template_directory_uri() . '/assets/css/theme.css', ['atelier-fonts'], ATELIER_VERSION);
    wp_enqueue_script('atelier-site', get_template_directory_uri() . '/assets/js/site.js', [], ATELIER_VERSION, true);
    wp_localize_script('atelier-site', 'atelierData', [
        'homeUrl' => home_url('/'),
        'rates' => apply_filters('atelier_currency_rates', ['KES' => 1, 'USD' => 129.34, 'GBP' => 175.11, 'EUR' => 149.60]),
        'rateDate' => '2026-09-03',
    ]);
}
add_action('wp_enqueue_scripts', 'atelier_assets');

function atelier_body_classes(array $classes): array {
    $classes[] = 'atelier-site';
    return $classes;
}
add_filter('body_class', 'atelier_body_classes');

function atelier_create_core_pages(): void {
    $pages = ['home' => 'Home', 'about' => 'About', 'services' => 'Services', 'process' => 'Process', 'work' => 'Work', 'start-a-project' => 'Start a Project', 'contact' => 'Contact', 'privacy' => 'Privacy', 'terms' => 'Terms'];
    foreach ($pages as $slug => $title) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(['post_type' => 'page', 'post_status' => 'publish', 'post_title' => $title, 'post_name' => $slug]);
        }
    }
    $home = get_page_by_path('home');
    if ($home) { update_option('show_on_front', 'page'); update_option('page_on_front', $home->ID); }
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'atelier_create_core_pages');

function atelier_page_url(string $slug): string {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/' . $slug . '/');
}
