<?php 
    $blogusers = get_users( [ 'role__in' => [ 'administrator', 'Editor' ] ] );
    // Array of WP_User objects.
    foreach ( $blogusers as $user ) {
        echo '<a href="/author/' . esc_html( $user->nickname ) . '">';
        echo ' ● ' . $user->display_name . '</a>';
    }
?>
