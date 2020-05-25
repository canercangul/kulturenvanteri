<?php
/**
 * Template Name: Editors
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

                <div class="col-12 col-md-6 pt-3 pb-3 entry-content flex-fill" id="modal-ready">
                    <?php the_content(); ?><?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
                </div>
                
                    <?php get_template_part( 'loop-templates/content', 'random-image' ); ?>

            </div>

            <div class="row">

                <div class="col-12 col-md-12 pt-4 pb-1 text-light bg-primary">
                    <p>Kültür Elçileri<p>
                </div>

                <div class="col-12 pt-3 pb-3">
                    <?php get_template_part( 'loop-templates/content', 'editor-list' ); ?>
                </div>

            </div>
            
        </div>

    </article><!-- #post-## -->

    <?php endwhile; // end of the loop. ?>

</div><!-- Wrapper end -->

<?php get_footer(); ?>