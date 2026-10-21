<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
  <a class="wordmark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Atelïer home">Atel<span>ï</span>er</a>
  <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">Menu</button>
  <nav id="site-navigation" class="site-nav" aria-label="Primary navigation">
  <a href="<?php echo esc_url(atelier_page_url('about')); ?>">About</a>
  <a href="<?php echo esc_url(atelier_page_url('services')); ?>">Services</a>
  <a href="<?php echo esc_url(atelier_page_url('process')); ?>">Process</a>
  <a href="<?php echo esc_url(atelier_page_url('work')); ?>">Work</a>
  <a href="<?php echo esc_url(atelier_page_url('contact')); ?>">Contact</a>
  <a class="nav-cta" href="<?php echo esc_url(atelier_page_url('start-a-project')); ?>">Start a Project</a>
</nav>
</header>

