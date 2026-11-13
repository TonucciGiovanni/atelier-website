<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the enquiries post type.
 */
function atelier_register_inquiries(): void
{
    register_post_type(
        'atelier_inquiry',
        [
            'labels' => [
                'name'          => 'Enquiries',
                'singular_name' => 'Enquiry',
                'menu_name'     => 'Enquiries',
                'edit_item'     => 'View Enquiry',
            ],
            'public'             => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-email-alt',
            'supports'           => ['title', 'editor', 'custom-fields'],
            'capabilities'       => [
                'create_posts' => 'do_not_allow',
            ],
            'map_meta_cap'       => true,
            'exclude_from_search' => true,
        ]
    );
}
add_action('init', 'atelier_register_inquiries');

/**
 * Add the read-only enquiry details box.
 */
function atelier_add_inquiry_details_meta_box(WP_Post $post): void
{
    add_meta_box(
        'atelier-inquiry-details',
        'Enquiry Details',
        'atelier_render_inquiry_details_meta_box',
        'atelier_inquiry',
        'normal',
        'high'
    );
}
add_action(
    'add_meta_boxes_atelier_inquiry',
    'atelier_add_inquiry_details_meta_box'
);

/**
 * Display the submitted enquiry information.
 */
function atelier_render_inquiry_details_meta_box(WP_Post $post): void
{
    $details = [
        'Email address' => get_post_meta(
            $post->ID,
            '_atelier_email',
            true
        ),
        'Company' => get_post_meta(
            $post->ID,
            '_atelier_company',
            true
        ),
        'Phone number' => get_post_meta(
            $post->ID,
            '_atelier_phone',
            true
        ),
        'Project type' => get_post_meta(
            $post->ID,
            '_atelier_project_type',
            true
        ),
        'Page range' => get_post_meta(
            $post->ID,
            '_atelier_page_range',
            true
        ),
        'Selected add-ons' => get_post_meta(
            $post->ID,
            '_atelier_addons',
            true
        ),
        'Currency' => get_post_meta(
            $post->ID,
            '_atelier_currency',
            true
        ),
        'Estimated range' => get_post_meta(
            $post->ID,
            '_atelier_estimate',
            true
        ),
        'Consent to respond' => get_post_meta(
            $post->ID,
            '_atelier_consent',
            true
        ),
        'Consent recorded at' => get_post_meta(
            $post->ID,
            '_atelier_consent_recorded_at',
            true
        ),
        'Notification email sent' => get_post_meta(
            $post->ID,
            '_atelier_notification_sent',
            true
        ),
    ];
    ?>

    <table class="widefat striped">
        <tbody>
            <?php foreach ($details as $label => $value) : ?>
                <tr>
                    <th scope="row" style="width: 220px;">
                        <?php echo esc_html($label); ?>
                    </th>

                    <td>
                        <?php
                        echo esc_html(
                            $value !== '' ? $value : 'Not provided'
                        );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
}

/**
 * Return the length of text safely.
 */
function atelier_text_length(string $text): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($text);
    }

    return strlen($text);
}

/**
 * Redirect back to the project page with a result status.
 */
function atelier_redirect_inquiry(string $status): void
{
    $return_url = wp_get_referer();

    if (!$return_url) {
        $return_url = home_url('/start-a-project/');
    }

    $return_url = remove_query_arg('inquiry', $return_url);
    $return_url = add_query_arg('inquiry', $status, $return_url);

    wp_safe_redirect($return_url);
    exit;
}

/**
 * Process a project enquiry.
 */
function atelier_handle_inquiry(): void
{
    $nonce = isset($_POST['atelier_nonce'])
        ? sanitize_text_field(
            wp_unslash($_POST['atelier_nonce'])
        )
        : '';

    if (
        $nonce === ''
        || !wp_verify_nonce($nonce, 'atelier_inquiry')
    ) {
        atelier_redirect_inquiry('invalid');
    }

    /*
     * A real visitor should never complete the hidden website field.
     */
    $honeypot = isset($_POST['website'])
        ? sanitize_text_field(
            wp_unslash($_POST['website'])
        )
        : '';

    if ($honeypot !== '') {
        wp_safe_redirect(home_url('/'));
        exit;
    }

    /*
     * Reject submissions completed unrealistically quickly.
     */
    $form_started = isset($_POST['form_started'])
        ? absint($_POST['form_started'])
        : 0;

    if (
        $form_started === 0
        || (time() - $form_started) < 3
    ) {
        atelier_redirect_inquiry('invalid');
    }

    $name = isset($_POST['name'])
        ? sanitize_text_field(
            wp_unslash($_POST['name'])
        )
        : '';

    $email = isset($_POST['email'])
        ? sanitize_email(
            wp_unslash($_POST['email'])
        )
        : '';

    $message = isset($_POST['message'])
        ? sanitize_textarea_field(
            wp_unslash($_POST['message'])
        )
        : '';

    $consent = isset($_POST['consent'])
        && sanitize_text_field(
            wp_unslash($_POST['consent'])
        ) === '1';

    $name_length    = atelier_text_length($name);
    $message_length = atelier_text_length($message);

    if (
        $name_length < 2
        || $name_length > 100
        || !is_email($email)
        || $message_length < 20
        || $message_length > 3000
        || !$consent
    ) {
        atelier_redirect_inquiry('invalid');
    }

    $allowed_project_types = [
        'Business Website',
        'Website Redesign',
        'E-commerce',
        'Mobile App Development',
        'SEO or Marketing',
        'Not sure yet',
    ];

    $project_type = isset($_POST['project_type'])
        ? sanitize_text_field(
            wp_unslash($_POST['project_type'])
        )
        : '';

    if (!in_array($project_type, $allowed_project_types, true)) {
        $project_type = 'Not sure yet';
    }

    $allowed_currencies = [
        'USD',
        'GBP',
        'EUR',
        'KES',
    ];

    $currency = isset($_POST['currency'])
        ? sanitize_text_field(
            wp_unslash($_POST['currency'])
        )
        : 'USD';

    if (!in_array($currency, $allowed_currencies, true)) {
        $currency = 'USD';
    }

    /*
     * Limit successful enquiries to one per IP address per minute.
     * The address is hashed and is not saved as readable personal data.
     */
    $client_ip = isset($_SERVER['REMOTE_ADDR'])
        ? sanitize_text_field(
            wp_unslash($_SERVER['REMOTE_ADDR'])
        )
        : '';

    $rate_source = $client_ip !== ''
        ? $client_ip
        : strtolower($email);

    $rate_key = 'atelier_inquiry_rate_' . hash_hmac(
        'sha256',
        $rate_source,
        wp_salt('nonce')
    );

    if (get_transient($rate_key)) {
        atelier_redirect_inquiry('rate_limited');
    }

    $company = isset($_POST['company'])
        ? sanitize_text_field(
            wp_unslash($_POST['company'])
        )
        : '';

    $phone = isset($_POST['phone'])
        ? sanitize_text_field(
            wp_unslash($_POST['phone'])
        )
        : '';

    $page_range = isset($_POST['page_range'])
        ? sanitize_text_field(
            wp_unslash($_POST['page_range'])
        )
        : 'Not selected';

    $addons = isset($_POST['addons'])
        ? sanitize_text_field(
            wp_unslash($_POST['addons'])
        )
        : 'None';

    $estimate = isset($_POST['estimate'])
        ? sanitize_text_field(
            wp_unslash($_POST['estimate'])
        )
        : 'Not calculated';

    $post_id = wp_insert_post(
        [
            'post_type'    => 'atelier_inquiry',
            'post_status'  => 'private',
            'post_title'   => $name . ': '
                . ($company !== '' ? $company : 'Project enquiry'),
            'post_content' => $message,
        ],
        true
    );

    if (is_wp_error($post_id)) {
        atelier_redirect_inquiry('error');
    }

    $consent_time = current_time('mysql');

    $metadata = [
        '_atelier_email'               => $email,
        '_atelier_company'             => $company,
        '_atelier_phone'               => $phone,
        '_atelier_project_type'        => $project_type,
        '_atelier_page_range'          => $page_range,
        '_atelier_addons'              => $addons,
        '_atelier_currency'            => $currency,
        '_atelier_estimate'            => $estimate,
        '_atelier_consent'             => 'Yes',
        '_atelier_consent_recorded_at' => $consent_time,
    ];

    foreach ($metadata as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }

    /*
     * Start the rate limit only after WordPress saves the enquiry.
     */
    set_transient(
        $rate_key,
        '1',
        MINUTE_IN_SECONDS
    );

    $notification_subject = sprintf(
        'New Atelïer project enquiry from %s',
        $name
    );

    $notification_message = implode(
        "\n",
        [
            'New Atelïer project enquiry',
            '',
            'Name: ' . $name,
            'Email: ' . $email,
            'Company: ' . ($company ?: 'Not provided'),
            'Phone: ' . ($phone ?: 'Not provided'),
            'Project type: ' . $project_type,
            'Page range: ' . $page_range,
            'Add-ons: ' . $addons,
            'Currency: ' . $currency,
            'Estimate: ' . $estimate,
            'Consent to respond: Yes',
            'Consent recorded at: ' . $consent_time,
            '',
            'Project description:',
            $message,
        ]
    );

    $headers = [
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $email_sent = wp_mail(
        get_option('admin_email'),
        $notification_subject,
        $notification_message,
        $headers
    );

    update_post_meta(
        $post_id,
        '_atelier_notification_sent',
        $email_sent ? 'Yes' : 'No'
    );

    atelier_redirect_inquiry('success');
}

add_action(
    'admin_post_nopriv_atelier_inquiry',
    'atelier_handle_inquiry'
);

add_action(
    'admin_post_atelier_inquiry',
    'atelier_handle_inquiry'
);