<?php /* Template Name: Start a Project */ get_header(); ?>
<main><section class="page-hero"><p class="eyebrow">05 · Start a Project</p><h1>Plan the right starting point.</h1><p>Build an indicative estimate, then send us the context needed for a useful first conversation.</p></section>
<?php get_template_part('template-parts/estimator'); ?>
<section class="section"><div class="section-head"><p class="eyebrow">Project brief</p><h2>Tell us what you are building.</h2></div>
<?php if (($_GET['inquiry'] ?? '') === 'success'): ?><div class="notice success">Your project brief has been received. We’ll follow up using the details you supplied.</div><?php elseif (isset($_GET['inquiry'])): ?><div class="notice error">We could not save your brief. Please check the required fields and try again.</div><?php endif; ?>
<form class="project-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
  <input type="hidden" name="action" value="atelier_inquiry"><?php wp_nonce_field('atelier_inquiry', 'atelier_nonce'); ?>
  <label class="honeypot">Website<input name="website" tabindex="-1" autocomplete="off"></label>
  <div class="field-grid"><label>Full name<input name="name" required autocomplete="name"></label><label>Business name<input name="company" autocomplete="organization"></label><label>Email address<input type="email" name="email" required autocomplete="email"></label><label>Phone / WhatsApp<input type="tel" name="phone" autocomplete="tel"></label></div>
  <label>Project type<select name="project_type"><option>Business Website</option><option>Website Redesign</option><option>E-commerce</option><option>Mobile App Development</option><option>SEO or Marketing</option><option>Not sure yet</option></select></label>
  <label>Preferred currency<select name="currency"><option>KES</option><option>USD</option><option>GBP</option><option>EUR</option></select></label>
  <input type="hidden" name="estimate" data-estimate-field value="Not calculated">
  <label>Project goals and requirements<textarea name="message" rows="6" placeholder="What should this project help your business achieve?"></textarea></label>
  <button class="button primary" type="submit">Send my project brief →</button>
</form></section></main><?php get_footer(); ?>

