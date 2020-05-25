<?php
/**
 * Template Name: Test page
 *
 * @package understrap
 */

get_header();
?>

<div class="wrapper" id="full-width-page-wrapper">
    <div class="container-fluid">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'loop-templates/content', 'test' ); ?>
        <?php endwhile; // end of the loop. ?>
    </div>
</div><!-- Wrapper end -->

<?php get_footer(); ?>
