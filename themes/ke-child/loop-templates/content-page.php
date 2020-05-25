<?php
/**
 * Partial template for content in page.php
 * Varsayılan
 * 
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="container-fluid">

		<div class="row">

			<div class="col-12">
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>

		</div>
	</div>

<footer class="entry-footer">

<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

</footer><!-- .entry-footer -->

</article><!-- #post-## -->