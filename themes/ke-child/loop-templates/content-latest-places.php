<ul class="list-group list-group-flush">
    <?php
    // Show recently modified posts
    $recently_updated_posts = new WP_Query( array(
        'post_type'      => 'place',
        'posts_per_page' => 14,
        'orderby'        => 'modified',
        'no_found_rows'  => true, // speed up query when we don't need pagination
    ) );
    if ( $recently_updated_posts->have_posts() ) :
        while( $recently_updated_posts->have_posts() ) : $recently_updated_posts->the_post(); ?>
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent"><a href="<?php the_permalink(); ?>" title="<?php esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a><small class="text-muted"><?php the_modified_author(); ?> - <?php the_modified_date(); ?></small></li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</ul>