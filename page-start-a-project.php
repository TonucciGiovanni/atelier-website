<?php /* Template Name: Start a Project */ get_header(); ?>
<main><section class="page-hero"><p class="eyebrow">05 · Start a Project</p><h1>Plan the right starting point.</h1><p>Build an indicative estimate, then send us the context needed for a useful first conversation.</p></section>
<?php get_template_part('template-parts/estimator'); ?>
<section class="section"><div class="section-head"><p class="eyebrow">Project brief</p><h2>Tell us what you are building.</h2></div>
<?php
$inquiry_status = isset($_GET['inquiry'])
    ? sanitize_key(wp_unslash($_GET['inquiry']))
    : '';

$clean_project_url = remove_query_arg('inquiry');
?>

<?php if ($inquiry_status === 'success'): ?>
    <div class="inquiry-modal-backdrop" data-inquiry-modal>
        <section
            class="inquiry-modal"
            role="dialog"
            aria-modal="true"
            aria-labelledby="inquiry-modal-title"
            aria-describedby="inquiry-modal-description"
            tabindex="-1"
        >
            <a
                class="inquiry-modal-close"
                href="<?php echo esc_url($clean_project_url); ?>"
                data-inquiry-close
                aria-label="Close confirmation"
            >
                ×
            </a>

            <div class="inquiry-modal-icon" aria-hidden="true">
                ✓
            </div>

            <p class="eyebrow">Project brief received</p>

            <h2 id="inquiry-modal-title">
                Your project is now on our table.
            </h2>

            <p id="inquiry-modal-description">
                Thank you. We have received your project details
                and will review the scope before following up using
                the contact information you provided.
            </p>

            <p class="inquiry-modal-next">
                While we review it, you can explore selected work
                or continue looking through this page.
            </p>

            <div class="button-row">
                <a
                    class="button primary"
                    href="<?php echo esc_url(atelier_page_url('work')); ?>"
                >
                    Explore our work
                </a>

                <a
                    class="button secondary"
                    href="<?php echo esc_url($clean_project_url); ?>"
                    data-inquiry-close
                >
                    Stay on this page
                </a>
            </div>
        </section>
    </div>
<?php elseif ($inquiry_status === 'invalid'): ?>
    <div class="notice error" role="alert" aria-live="assertive">
        Please provide your name, a valid email address, consent to be
        contacted, and a project description of at least 20 characters.
    </div>

<?php elseif ($inquiry_status === 'rate_limited'): ?>
    <div class="notice error" role="alert" aria-live="assertive">
        We received a recent submission from this connection. Please wait
        one minute before sending another project brief.
    </div>

<?php elseif ($inquiry_status !== ''): ?>
    <div class="notice error" role="alert" aria-live="assertive">
        We could not save your brief. Please check the required fields
        and try again.
    </div>
<?php endif; ?>
<form
    class="project-form"
    data-project-form
    method="post"
    action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
>
  <input type="hidden" name="action" value="atelier_inquiry"><?php wp_nonce_field('atelier_inquiry', 'atelier_nonce'); ?>
  <label class="honeypot">Website<input name="website" tabindex="-1" autocomplete="off"></label>
  <input
    type="hidden"
    name="form_started"
    value="<?php echo esc_attr((string) time()); ?>"
>
  <div class="field-grid">
    <label>
        Full name
        <input
            name="name"
            required
            minlength="2"
            maxlength="100"
            autocomplete="name"
        >
    </label>

    <label>
        Business name
        <input
            name="company"
            maxlength="150"
            autocomplete="organization"
        >
    </label>

    <label>
        Email address
        <input
            type="email"
            name="email"
            required
            maxlength="190"
            autocomplete="email"
        >
    </label>

    <label>
        Phone or WhatsApp
        <input
            type="tel"
            name="phone"
            maxlength="40"
            autocomplete="tel"
        >
    </label>
</div>
  <label>Project type<select name="project_type"><option>Business Website</option><option>Website Redesign</option><option>E-commerce</option><option>Mobile App Development</option><option>SEO or Marketing</option><option>Not sure yet</option></select></label>
  <label>Preferred currency<select name="currency"><option value="USD" selected>USD</option><option value="GBP">GBP</option><option value="EUR">EUR</option><option value="KES">KES</option></select></label>
  <input type="hidden" name="estimate" data-estimate-field value="Not calculated">
  <input type="hidden" name="page_range" data-page-range-field value="1–3 pages">
<input type="hidden" name="addons" data-addons-field value="None">
  <label for="project-message">
    Project goals and requirements
    <textarea
        id="project-message"
        name="message"
        rows="6"
        required
        minlength="20"
        maxlength="3000"
        aria-describedby="project-message-help"
        placeholder="What should this project help your business achieve?"
    ></textarea>

    <small
        class="field-help"
        id="project-message-help"
    >
        Provide at least 20 characters. Please do not include
        passwords or other sensitive information.
    </small>
</label>
<label class="consent-field">
    <input
        type="checkbox"
        name="consent"
        value="1"
        required
    >

    <span>
        I agree that Atelïer may use these details to respond
        to my enquiry. Read our
        <a href="<?php echo esc_url(atelier_page_url('privacy')); ?>">
            Privacy Policy
        </a>.
    </span>
</label>
  <button
    class="button primary"
    type="submit"
    data-project-submit
>
    Send my project brief
</button>
</form></section></main><?php get_footer(); ?>

