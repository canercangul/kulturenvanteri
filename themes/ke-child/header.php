<?php
/**
 * The header
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">

					<!-- Site title -->
					<?php if ( ! has_custom_logo() ) { ?>
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<a class="navbar-brand d-none d-md-block" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>
							<a class="navbar-brand d-block d-md-none" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">Kültür Envanteri Atlası</a>
						<?php endif; ?>
					<?php } else { the_custom_logo(); } ?><!-- end custom logo -->

					<!-- https://gist.github.com/sambody/5787954
					https://developer.wordpress.org/themes/basics/conditional-tags/#check-for-multiple-conditionals -->
					
					<!-- Page Title  -->
					<?php if ( is_tax() ) : ?>
					<?php the_archive_title( '<a class="d-none d-md-block navbar-brand text-primary">', '</a>' );?>
					<?php endif; ?>

					<!-- Buttons -->
					<?php if ( is_tax() ): ?>
						<div class="ml-auto">
						<button class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#button_wiki">Wiki</button>
						<button class="btn btn-sm btn-circle btn-primary ml-1" data-toggle="modal" data-target="#button_search">Ara</button>
						</div>
					<?php endif; ?>


					<?php if ( is_author() || is_single() ) : ?>
						<div class="ml-auto">
							<button class="btn btn-sm btn-circle btn-primary ml-1" data-toggle="modal" data-target="#button_search">Ara</button>
							<button class="btn btn-sm btn-circle btn-primary ml-1" type="button" onclick="history.go(-1);">←</button>
						</div>
					<?php endif; ?>



					<?php if ( is_page(array('harita','etrafta','test') ) ) : ?>
						<div class="ml-auto">
							<button class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#button_filter">Ara</button>
							<button class="btn btn-sm btn-circle btn-primary btn-visiblelist ml-1" data-toggle="modal" data-target="#button_visiblelist">Liste</button>
						</div>
					<?php endif; ?>

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- Menu -->
					<?php wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => 'navbar-nav ml-auto',
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'depth'           => 2,
							'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
						)
					); ?>
					
		</nav><!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->

<!-- #wrapper-navbar end -->

<!-- Modal -->
<div class="modal" id="button_search" tabindex="-1" role="dialog" aria-labelledby="button_searchTitle" aria-hidden="true">
	<div class="modal-dialog modal-search" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<form action="/harita/" method="get">
					<div class="input-group">
						<input id="capitalizeInput" class="field form-control" type="search" placeholder="kültür varlığı adı, şehir veya bir tür girerek arama yapın." name="_ara">
						<span class="input-group-append"><input class="submit btn btn-primary" id="searchsubmit" type="submit" value="Ara"></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>

	/**
	 * Input Capitalize
	 */

	document.getElementById('capitalizeInput').addEventListener("keyup",   () => {
	var inputValue = document.getElementById('capitalizeInput')['value']; 
	if (inputValue[0] === ' ') {
		inputValue = '';
		} else if (inputValue) {
		inputValue = inputValue[0].toLocaleUpperCase() + inputValue.slice(1);
		}
	document.getElementById('capitalizeInput')['value'] = inputValue;
	});

</script>