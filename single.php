<?php get_header(); ?>
<main class="section content-page"><?php while (have_posts()): the_post(); ?><p class="eyebrow"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></p><h1><?php the_title(); ?></h1><?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?><div class="entry-content"><?php the_content(); ?></div><?php endwhile; ?></main>
<?php get_footer(); ?>

