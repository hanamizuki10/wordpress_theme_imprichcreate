<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Dan
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function dan_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'dan_woocommerce_setup' );

/**
 * WooCommerce & stylesheets.
 *
 * @return void
 */
function dan_woocommerce_scripts() {
	wp_enqueue_style( 'dan-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css' );
	wp_style_add_data( 'dan-woocommerce-style', 'rtl', 'replace' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'dan-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'dan_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function dan_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'dan_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function dan_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'dan_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function dan_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'dan_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function dan_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'dan_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function dan_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'dan_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'dan_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function dan_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'dan_woocommerce_wrapper_before' );

if ( ! function_exists( 'dan_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function dan_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'dan_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'dan_woocommerce_header_cart' ) ) {
			dan_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'dan_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function dan_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		dan_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'dan_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'dan_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function dan_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'dan' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'dan' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'dan_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function dan_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php dan_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

if ( ! function_exists( 'dan_woocommerce_breadcrumb_menu' ) ) {
	/**
	 * Change the breadcrumbs html markup.
	 */
	function dan_woocommerce_breadcrumb_menu() {
		return array(
			'delimiter'   => '', // no delimiter
			'wrap_before' => '<nav class="woocommerce-breadcrumb"><ol class="woocommerce-breadcrumb-list">',
			'wrap_after'  => '</ol></nav>',
			'before'      => '<li class="woocommerce-breadcrumb-item">',
			'after'       => '</li>',
			'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
		);
	}
}
add_filter( 'woocommerce_breadcrumb_defaults', 'dan_woocommerce_breadcrumb_menu' );

if ( ! function_exists( 'dan_woocommerce_widget_tag_cloud_args' ) ) {
	/**
	 * Modifies WooCommerce tag cloud widget arguments to display all tags in the same font size
	 * and use list format for better accessibility.
	 *
	 * @param array $args Arguments for tag cloud widget.
	 * @return array The filtered arguments for tag cloud widget.
	 */
	function dan_woocommerce_widget_tag_cloud_args( $args ) {
		$args['largest']  = 14;
		$args['smallest'] = 14;
		$args['unit']     = 'px';
		$args['format']   = 'list';

		return $args;
	}
}
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'dan_woocommerce_widget_tag_cloud_args' );

if ( ! function_exists( 'dan_woocommerce_pagination_args' ) ) {
	/**
	 * Change the breadcrumbs html markup.
	 */
	function dan_woocommerce_pagination_args() {
		return array(
			'prev_text'          => '<span class="fas fa-angle-double-left" aria-hidden="true"></span> ' . __( 'Previous page', 'dan' ),
			'next_text'          => __( 'Next page', 'dan' ) . ' <span class="fas fa-angle-double-right" aria-hidden="true"></span>',
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'dan' ) . '</span>',
		);
	}
}
add_filter( 'woocommerce_pagination_args', 'dan_woocommerce_pagination_args' );