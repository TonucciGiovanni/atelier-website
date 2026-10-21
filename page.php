<?php get_header(); ?>
<main class="section content-page"><?php while (have_posts()): the_post(); ?><p class="eyebrow">Atelïer</p><h1><?php the_title(); ?></h1><div class="entry-content"><?php the_content(); ?></div><?php endwhile; ?></main>
<?php get_footer(); ?>

