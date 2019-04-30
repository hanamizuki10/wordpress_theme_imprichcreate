<!DOCTYPE html>
<html <?php language_attributes();?> >
<head>
	<meta charset="<?php bloginfo( 'charset' );?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class();?>>
<div id="page" class="site">
<header class="site-header">
	<!-- ▼▼▼ .site-branding ▼▼▼ -->
	<div class="site-branding">
		<div class="site-branding-logo">
			<a href="#" class="custom-logo-link" rel="home" itemprop="url">
				<img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/logo64.png" class="custom-logo" alt="<?php bloginfo( 'name' ); ?>" itemprop="logo" srcset="<?php echo esc_url( get_template_directory_uri()); ?>/img/logo64.png 240w, <?php echo esc_url( get_template_directory_uri()); ?>/img/logo64.png 150w" sizes="(max-width: 240px) 100vw, 240px">
			</a>
		</div><!-- .site-branding-logo -->
		<div class="site-title-description">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<p class="site-description"><?php bloginfo('description'); ?></p>
		</div>
	</div>
	<!-- .site-branding -->
	<!-- ▲▲▲ .site-branding ▲▲▲ -->

	<button class="menu-toggle"><span class="fas fa-bars" aria-hidden="true"></span>Menu</button>

	<!-- ▼▼▼ #site-navigation ▼▼▼ -->
	<nav id="site-navigation" class="main-navigation" role="navigation">

		<?php
		/**
		* グローバルナビゲーション
		*/
		wp_nav_menu( array(
			'theme_location' => 'header',
			'menu_class' => 'menu',
		) );
		?>

	</nav>
	<!-- ▲▲▲ #site-navigation ▲▲▲ -->
</header>

<?php
// パンくずナビ表示 by functions.php
custom_breadcrumb();

?>
