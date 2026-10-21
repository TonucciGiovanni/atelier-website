<?php get_header(); ?>
<main class="section content-page"><div class="section-head"><p class="eyebrow">Atelïer Journal</p><h1><?php bloginfo('name'); ?></h1></div>
<?php if (have_posts()): while (have_posts()): the_post(); ?><article <?php post_class('post-card'); ?>><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article><?php endwhile; the_posts_pagination(); else: ?><p>No content has been published yet.</p><?php endif; ?>
</main><?php get_footer(); ?>

