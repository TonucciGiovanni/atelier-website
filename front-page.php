<?php get_header(); ?>
<main>
  <section class="hero"><div class="mesh"></div><div class="hero-inner">
    <span class="badge"><i></i>Design, Content &amp; Technology</span>
    <h1>Every digital experience, <em>pattern-drafted</em><br>to fit your business.</h1>
    <p>Atelïer designs and builds websites, online stores and mobile products supported by SEO, content and marketing for businesses ready to communicate clearly and grow with purpose.</p>
    <div class="button-row"><a class="button primary" href="<?php echo esc_url(atelier_page_url('start-a-project')); ?>">Start a Project →</a><a class="button secondary" href="<?php echo esc_url(atelier_page_url('work')); ?>">See the Work</a></div>
  </div></section>

  <section class="brand-promise" aria-label="Atelïer brand promise">
    <p>
      <span>Close enough to stay connected.</span>
      <em>Skilled enough to move the work.</em>
    </p>
  </section>

  <section class="section white centered"><p class="eyebrow">01 · About Atelïer</p><h2>Every business has its own story. <em>Its digital presence should feel like it.</em></h2><p>Atelïer is an independent digital studio bringing design, development, content and marketing into one connected practice. The result is work that feels thoughtful, technically sound and true to the business behind it.</p>
<p>We work closely with founders and growing teams across borders and time zones. Distance never changes the experience: communication stays personal, progress stays visible and the right people stay close to the work.</p></section>

  <section class="section"><div class="section-head"><p class="eyebrow">02 · Services</p><h2>Three ways we help your business move forward.</h2><p>From shaping your presence to building the platform and helping it reach the right audience, our services work together around your business.</p></div>
    <div class="offer-grid"><?php foreach (atelier_service_groups() as $group): ?><article class="offer-card"><span class="offer-number"><?php echo esc_html($group['number']); ?></span><p class="eyebrow"><?php echo esc_html($group['short']); ?></p><h3><?php echo esc_html($group['title']); ?></h3><p><?php echo esc_html($group['summary']); ?></p><div class="service-tags"><?php foreach ($group['services'] as $service): ?><span><?php echo esc_html($service); ?></span><?php endforeach; ?></div><a href="<?php echo esc_url(atelier_page_url('services')); ?>">Explore our services ↗</a></article><?php endforeach; ?></div>
  </section>

  <section class="section"><div class="launch-kit"><div><p class="eyebrow teal">Featured Offer</p><h2>The Atelïer <em>Launch Kit.</em></h2><p>A coordinated website, search and content launch. We plan everything together so nothing important is left for later.</p><a class="button primary" href="<?php echo esc_url(atelier_page_url('start-a-project')); ?>">Plan a Launch Kit</a></div><ul><li>Custom business website</li><li>Website copy and messaging</li><li>SEO and analytics foundations</li><li>Marketing launch content</li><li>Post-launch support</li></ul></div></section>

  <?php get_template_part('template-parts/process'); ?>
  <?php get_template_part('template-parts/work'); ?>
  <?php get_template_part('template-parts/estimator'); ?>
</main>
<?php get_footer(); ?>

