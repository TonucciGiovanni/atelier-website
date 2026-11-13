<section class="section white" id="process">
  <div class="section-head">
    <p class="eyebrow">03 · How We Work</p>
    <h2>From first conversation to a confident launch.</h2>
    <p>We keep the work clear and collaborative, with useful decisions and visible progress at every stage.</p>
  </div>

  <?php
  $steps = [
      [
          'Understand',
          'We start with a conversation about your business, your audience and what the project needs to achieve.',
      ],
      [
          'Plan',
          'We agree on the scope, responsibilities, cost and timeline, so everyone knows what happens next.',
      ],
      [
          'Shape',
          'We bring structure, design and content together, then share the direction for your review.',
      ],
      [
          'Build',
          'We develop the approved direction, test as we go and keep progress visible.',
      ],
      [
          'Launch & Support',
          'We complete the final checks, prepare the launch and stay close while everything settles in.',
      ],
  ];
  ?>

  <div class="process-list">
    <?php foreach ($steps as $i => $step): ?>
      <article>
        <span><?php echo esc_html(sprintf('%02d', $i + 1)); ?></span>
        <h3><?php echo esc_html($step[0]); ?></h3>
        <p><?php echo esc_html($step[1]); ?></p>
      </article>
    <?php endforeach; ?>
  </div>

  <p class="center-link">
    <a href="<?php echo esc_url(atelier_page_url('process')); ?>">Explore Our Process →</a>
  </p>
</section>