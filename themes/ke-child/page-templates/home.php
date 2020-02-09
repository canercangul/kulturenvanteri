<?php
/**
 * Template Name: Home
 *
 * @package understrap
 */

get_header();
?>

<div class="wrapper" id="full-width-page-wrapper">

    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'loop-templates/content', 'home' ); ?>
    <?php endwhile; // end of the loop. ?>

</div><!-- Wrapper end -->

<?php get_footer(); ?>