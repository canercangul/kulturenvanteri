<?php
/**
 * Single Actor Template
 * Template Name: Actor
 * Template Post Type: actor
 *
 * @package understrap
 */

get_header();
?>
<div class="wrapper" id="single-wrapper">

	<div class="container-fluid" id="content" tabindex="-1">

		<main class="site-main" id="main">
			
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'loop-templates/content', 'place' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
