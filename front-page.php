<?php get_header(); ?>
<main>
  <section class="hero">
  <div class="mesh"></div>

  <div class="hero-inner">
    <span class="badge"><i></i>Independent Digital Studio</span>

    <h1>
      Every digital experience,
      <em>pattern-drafted</em><br>
      to fit your business.
    </h1>

    <p>We bring strategy, design, technology and communication into one connected process, creating digital experiences that feel clear, distinctive and built to move your business forward.</p>

    <div class="button-row">
      <a class="button primary" href="<?php echo esc_url(atelier_page_url('start-a-project')); ?>">Start a Project →</a>
      <a class="button secondary" href="<?php echo esc_url(atelier_page_url('work')); ?>">See the Work</a>
    </div>
  </div>
</section>

  <section class="brand-promise" aria-label="Atelïer brand promise">
    <p>
      <span>Close enough to stay connected.</span>
      <em>Skilled enough to move the work.</em>
    </p>
  </section>

 <section class="section white centered">
  <p class="eyebrow">01 · About Atelïer</p>

  <h2>
    Every business has its own story.
    <em>Its digital presence should feel like it.</em>
  </h2>

  <p>Atelïer brings design, development, content and marketing into one connected practice. The result is thoughtful work that feels true to the business behind it.</p>

  <p>Wherever you are, conversations stay personal, progress stays visible and the right people stay close to the work.</p>

  <p class="center-link">
    <a href="<?php echo esc_url(atelier_page_url('about')); ?>">Meet the Studio →</a>
  </p>
</section>

  <section class="section">

<div class="section-head">
  <p class="eyebrow">02 · Services</p>
  <h2>Three connected ways to move your business forward.</h2>
  <p>Start where you need us most, or bring all three together for one clear and consistent digital presence.</p>
</div>
    <div class="offer-grid"><?php foreach (atelier_service_groups() as $group): ?><article class="offer-card"><span class="offer-number"><?php echo esc_html($group['number']); ?></span><p class="eyebrow"><?php echo esc_html($group['short']); ?></p><h3><?php echo esc_html($group['title']); ?></h3><p><?php echo esc_html($group['summary']); ?></p><div class="service-tags"><?php foreach ($group['services'] as $service): ?><span><?php echo esc_html($service); ?></span><?php endforeach; ?></div><a href="<?php echo esc_url(atelier_page_url('services')); ?>">Explore our services ↗</a></article><?php endforeach; ?></div>
  </section>

  <section class="section">
  <div class="launch-kit">
    <div>
      <p class="eyebrow teal">A Connected Starting Point</p>

      <h2>
        The Atelïer <em>Launch Kit.</em>
      </h2>

      <p>For businesses preparing to launch or refresh their digital presence. We bring the website, messaging, search foundations and launch content into one coordinated project.</p>

      <a class="button primary" href="<?php echo esc_url(atelier_page_url('start-a-project')); ?>">Plan Your Launch</a>
    </div>

    <ul>
      <li>Custom website design and development</li>
      <li>Website messaging and copy</li>
      <li>SEO and analytics foundations</li>
      <li>Launch content and campaign direction</li>
      <li>Supported handover after launch</li>
    </ul>
  </div>
</section>

  <?php get_template_part('template-parts/process'); ?>
  <?php get_template_part('template-parts/work'); ?>
  <?php get_template_part('template-parts/estimator'); ?>
</main>
<?php get_footer(); ?>

