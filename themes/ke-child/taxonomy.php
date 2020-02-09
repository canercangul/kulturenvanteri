<?php get_header(); ?>

<div class="col-lg-3 col-6 p-3 pt-5 fixed-list nopadding scroll-area bg-primary">
 <?php echo GeoMashup::visible_posts_list() ?>
</div>

<div class="col-12 fixed-map nopadding">
	<?php echo GeoMashup::map('add_map_type_control=true'); ?>
</div>
<?php get_footer(); ?>
