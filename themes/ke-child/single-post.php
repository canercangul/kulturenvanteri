<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">
            <div class="col-12 col-lg-6">

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'post' ); ?>

					<?php understrap_post_nav(); ?>

				<?php endwhile; // end of the loop. ?>

            </main><!-- #main -->
                   
            </div>
		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
