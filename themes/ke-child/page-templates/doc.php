<?php
/**
 * Template Name: Documentation
 *
 * @package understrap
 */

get_header();
?>

<div class="wrapper" id="full-width-page-wrapper">

    <?php while ( have_posts() ) : the_post(); ?>
        
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <div class="container-fluid">

            <div class="row d-flex" style="min-height:calc(100vh - 62px);">

                <div class="col-12 col-md-6 pt-3 pb-3 entry-content flex-fill">
                    <?php the_content(); ?><?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
                </div>

                <div class="pt-3 pb-3 bg-primary flex-fill">
                </div>

            </div>
            
        </div>

    </article><!-- #post-## -->

    <?php endwhile; // end of the loop. ?>

</div><!-- Wrapper end -->

<?php get_footer(); ?>