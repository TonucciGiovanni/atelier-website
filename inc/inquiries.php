<?php
if (!defined('ABSPATH')) { exit; }

function atelier_register_inquiries(): void {
    register_post_type('atelier_inquiry', [
        'labels' => ['name' => 'Enquiries', 'singular_name' => 'Enquiry'],
        'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-email-alt',
        'supports' => ['title', 'editor', 'custom-fields'],
        'capabilities' => ['create_posts' => 'do_not_allow'], 'map_meta_cap' => true,
    ]);
}
add_action('init', 'atelier_register_inquiries');

function atelier_handle_inquiry(): void {
    if (!isset($_POST['atelier_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['atelier_nonce'])), 'atelier_inquiry')) {
        wp_die('Security check failed.', 403);
    }
    if (!empty($_POST['website'])) { wp_safe_redirect(home_url('/')); exit; }

    $name = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    if ($name === '' || !is_email($email)) {
        wp_safe_redirect(add_query_arg('inquiry', 'invalid', wp_get_referer() ?: home_url('/'))); exit;
    }
    $fields = [
        'company' => sanitize_text_field(wp_unslash($_POST['company'] ?? '')),
        'phone' => sanitize_text_field(wp_unslash($_POST['phone'] ?? '')),
        'project_type' => sanitize_text_field(wp_unslash($_POST['project_type'] ?? '')),
        'currency' => sanitize_text_field(wp_unslash($_POST['currency'] ?? 'KES')),
        'estimate' => sanitize_text_field(wp_unslash($_POST['estimate'] ?? 'Scope review required')),
        'message' => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
    ];
    $id = wp_insert_post(['post_type' => 'atelier_inquiry', 'post_status' => 'private', 'post_title' => $name . ' — ' . ($fields['company'] ?: 'Project enquiry'), 'post_content' => $fields['message']]);
    if (!is_wp_error($id)) {
        update_post_meta($id, '_atelier_email', $email);
        foreach ($fields as $key => $value) { update_post_meta($id, '_atelier_' . $key, $value); }
        $message = "New Atelïer project enquiry\n\nName: {$name}\nEmail: {$email}\nCompany: {$fields['company']}\nPhone: {$fields['phone']}\nProject: {$fields['project_type']}\nEstimate: {$fields['estimate']} {$fields['currency']}\n\n{$fields['message']}";
        wp_mail(get_option('admin_email'), 'New Atelïer project enquiry', $message, ['Reply-To: ' . $name . ' <' . $email . '>']);
    }
    $return = wp_get_referer() ?: atelier_page_url('start-a-project');
    wp_safe_redirect(add_query_arg('inquiry', is_wp_error($id) ? 'error' : 'success', $return)); exit;
}
add_action('admin_post_nopriv_atelier_inquiry', 'atelier_handle_inquiry');
add_action('admin_post_atelier_inquiry', 'atelier_handle_inquiry');

