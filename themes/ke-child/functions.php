<?php

function understrap_remove_scripts() {
// wp_dequeue_style( 'understrap-styles' );
// wp_deregister_style( 'understrap-styles' );

wp_dequeue_script( 'understrap-scripts' );
wp_deregister_script( 'understrap-scripts' );
}

function theme_enqueue_styles() {
// Get the theme data
$the_theme = wp_get_theme();
// wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}

add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Additional JS and CSS
add_action( 'wp_enqueue_scripts', function () {
wp_enqueue_script( 'masonry', '//cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js' );
wp_enqueue_script( 'masonry-gallery', get_stylesheet_directory_uri() . '/js/masonry-gallery.js', array('jquery'), '1.0.0', true);
wp_enqueue_script( 'magnific_popup_script', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js' , array('jquery'), '1.0.0', true  );
wp_enqueue_script( 'magnific_init_script', get_stylesheet_directory_uri(). '/js/jquery.magnific-popup-init.js', array('jquery'), '1.0.0', true  );
// wp_enqueue_style( 'magnific_popup_style', get_stylesheet_directory_uri(). '/css/magnific-popup.css', array() );
wp_enqueue_style( 'eko_style', get_stylesheet_directory_uri(). '/css/ke-style.css', array() );
}, 100 );

/*********
* GUTENBERG
************/

function custom_admin_css() {
    echo '<style type="text/css">
    .wp-block { max-width: 1300px; }
    </style>';
    }
    add_action('admin_head', 'custom_admin_css');

/*********
* Hide Admin Stick
************/

add_filter('show_admin_bar', '__return_false');

/*********
* Add title to <a> in [gallery] shortcode.
************/

function as_get_attachment_link( $output, $id ) {
	$attachment = get_post( $id );
	return str_replace( '<a', "<a title='{$attachment->post_excerpt}'", $output );
}
add_filter( 'wp_get_attachment_link', 'as_get_attachment_link', 10, 2 );

/*********
 * Gravity bootsrap 
************/

add_filter( 'gform_field_container', 'add_bootstrap_container_class', 10, 6 );
function add_bootstrap_container_class( $field_container, $field, $form, $css_class, $style, $field_content ) {
  $id = $field->id;
  $field_id = is_admin() || empty( $form ) ? "field_{$id}" : 'field_' . $form['id'] . "_$id";
  return '<li id="' . $field_id . '" class="' . $css_class . ' form-group">{FIELD_CONTENT}</li>';
}

/*********
 * Add the 'modal-link' class to the output of the_author_posts_link()
************/

add_filter( 'the_author_posts_link', function( $link )
{
    return str_replace( 'rel="author"', 'class="modal-link"', $link );
});

/*********
* Delete taxonomy name title
************/

function as_archive_title( $title ) 
{
    if ( is_category() ) 
    {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'as_archive_title' );



 /*********************************************************
 * FACET WP Hide template if no query


add_action( 'wp_footer', function() {
    ?>
    <script>
    (function($) {
        $(document).on('facetwp-loaded', function() {
            if (FWP.build_query_string()) {
                $('.facetwp-template').addClass('visible');
                $('.mapglobal').removeClass('visible');
            }
            else {
                $('.facetwp-template').removeClass('visible');
                $('.mapglobal').addClass('visible');
             }
         });
    })(jQuery);
    </script>
    <?php
    }, 100 );
    
 *********************************************************/

// End bootstrap_styles_for_gravityforms_fields()
add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
    return "<button class='button btn btn-primary' id='gform_submit_button_{$form["id"]}'><span>Submit</span></button>";
}

/*********
* Remove Emoji Codes
************/

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );


/*********
* Remove WP Version From Styles and Scripts	
************/

add_filter( 'style_loader_src', 'as_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'as_remove_ver_css_js', 9999 );
function as_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

/*********
* Remove Comments	
************/
 
add_action( 'admin_menu', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'init', 'remove_comment_support', 100 );
function remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

/*********
* Remove HTML Comments	
************/

function callback($buffer){ $buffer = preg_replace('/<!--(.|s)*?-->/', '', $buffer); return $buffer; }
function buffer_start(){ ob_start("callback"); }
function buffer_end(){ ob_end_flush(); }
add_action('get_header', 'buffer_start');
add_action('wp_footer', 'buffer_end');


/*********
* SELECTED VALUES yok ise template'i yükleme
************/

// function fwp_override_template( $return, $class ) {
//     foreach ( $class->ajax_params['facets'] as $facet ) {
//         if ( ! empty( $facet['selected_values'] ) ) {
//             return false; // don't override
//         }
//     }
//     return ''; // override
// }
// add_filter( 'facetwp_template_html', 'fwp_override_template', 10, 2 );