<section class="section" id="work">
  <div class="section-head">
    <p class="eyebrow">04 · Selected Work</p>
    <h2>Work shown with honesty and context.</h2>
    <p>Independent projects, studio concepts and confidential contributions are always labelled clearly.</p>
  </div>

  <div class="work-grid">
    <?php
    $projects = atelier_projects();

    if ($projects->have_posts()):
        while ($projects->have_posts()):
            $projects->the_post();
            ?>
            <a class="work-card" href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('large'); ?>
              <?php else: ?>
                <span class="work-placeholder"></span>
              <?php endif; ?>

              <span class="work-copy">
                <small>
                  <?php
                  echo esc_html(
                      get_post_meta(get_the_ID(), 'atelier_classification', true)
                      ?: 'Independent Project'
                  );
                  ?>
                </small>

                <strong><?php the_title(); ?></strong>
                <em><?php echo esc_html(get_the_excerpt()); ?></em>
              </span>
            </a>
            <?php
        endwhile;

        wp_reset_postdata();
    else:
        ?>
        <article class="work-card concept">
          <span class="work-copy">
            <small>Web Design · Independent Project</small>
            <strong>Independent Web Project</strong>
            <em>A personal project used to explore a real digital challenge.</em>
          </span>
        </article>

        <article class="work-card mint">
          <span class="work-copy">
            <small>Content &amp; Marketing · Studio Concept</small>
            <strong>Studio Marketing Concept</strong>
            <em>A self-initiated concept created to demonstrate our thinking and approach.</em>
          </span>
        </article>

        <article class="work-card coral">
          <span class="work-copy">
            <small>Digital Product · Confidential Contribution</small>
            <strong>Confidential Product Work</strong>
            <em>Client identity and protected project details are withheld.</em>
          </span>
        </article>
    <?php endif; ?>
  </div>

  <p class="work-note">Every portfolio label reflects the project’s real status. Confidential client information is never disclosed.</p>

  <?php if (!is_page('work')): ?>
    <p class="center-link">
      <a href="<?php echo esc_url(atelier_page_url('work')); ?>">Explore All Work →</a>
    </p>
  <?php endif; ?>
</section>