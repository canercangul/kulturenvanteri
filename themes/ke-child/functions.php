<?php

// function understrap_remove_scripts() {
// // wp_dequeue_style( 'understrap-styles' );
// // wp_deregister_style( 'understrap-styles' );
// // wp_dequeue_script( 'understrap-scripts' );
// // wp_deregister_script( 'understrap-scripts' );
// }

// function theme_enqueue_styles() {
// // Get the theme data
// $the_theme = wp_get_theme();
// // wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
// // wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
// }

// add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );
// add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Additional JS and CSS
add_action( 'wp_enqueue_scripts', function () {
wp_enqueue_script( 'masonry', '//cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js' );
wp_enqueue_script( 'masonry-gallery', get_stylesheet_directory_uri() . '/js/masonry-gallery.js', array('jquery'), '1.0.0', true);
wp_enqueue_script( 'magnific_popup_script', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js' , array('jquery'), '1.0.0', true  );
wp_enqueue_script( 'magnific_init_script', get_stylesheet_directory_uri(). '/js/jquery.magnific-popup-init.js', array('jquery'), '1.0.0', true  );
wp_enqueue_style( 'ke_style', get_stylesheet_directory_uri(). '/css/ke-style.css', array() );
}, 100 );

/*********
* GUTENBERG Wide
************/

function custom_admin_css() {
    echo '<style type="text/css">
    .wp-block { max-width: 1300px; }
    </style>';
    }
add_action('admin_head', 'custom_admin_css');

/*********
* Add title to <a> in [gallery] shortcode.
************/

function as_get_attachment_link( $output, $id ) {
	$attachment = get_post( $id );
	return str_replace( '<a', "<a title='{$attachment->post_excerpt}'", $output );
}
add_filter( 'wp_get_attachment_link', 'as_get_attachment_link', 10, 2 );

/*********
* Gallery Defaults
************/

add_filter( 'shortcode_atts_gallery',
    function( $out )
    {
        $out['link'] = 'file';
        $out['size'] = 'medium';
        return $out;
    }
);

/*********
 * Gravity Bootstrap 
************/

add_filter( 'gform_field_container', 'add_bootstrap_container_class', 10, 6 );
function add_bootstrap_container_class( $field_container, $field, $form, $css_class, $style, $field_content ) {
  $id = $field->id;
  $field_id = is_admin() || empty( $form ) ? "field_{$id}" : 'field_' . $form['id'] . "_$id";
  return '<li id="' . $field_id . '" class="' . $css_class . ' form-group">{FIELD_CONTENT}</li>';
}

/*********
* Gravity Bootstrap Submit
************/

add_filter("gform_submit_button", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
    return "<button class='button btn btn-primary' id='gform_submit_button_{$form["id"]}'><span>Submit</span></button>";
}

/*********
 * Add the 'modal-link' class to the output of the_author_posts_link()
************/

// add_filter( 'the_author_posts_link', function( $link )
// {
//     return str_replace( 'rel="author"', 'class="modal-link"', $link );
// });

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

/*********
* Remove Emoji Codes
************/

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

/*********
* Remove wlwmanifest, shortlink, rsd link, feed links, wp generator
************/

remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');
remove_action ('wp_head', 'rsd_link');
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'wp_generator');

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
* Remove Admin Bar for All
************/

add_filter('show_admin_bar', '__return_false');

/********************************************************/
// Adding Dashicons in WordPress Front-end
/********************************************************/
// add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
// function load_dashicons_front_end() {
//   wp_enqueue_style( 'dashicons' );
// }

/*********
* Wikipedia
************/

// Find and replace
// https://stackoverflow.com/questions/14883967/use-php-to-replace-html-with-html
function print_processed_html($string)
{ 
    $search  = Array('href="/wiki/', 'href="/w/');
    $replace = Array('target="_blank" class="iframe-popup" href="https://tr.m.wikipedia.org/wiki/', 'target="_blank" class="iframe-popup" href="https://tr.m.wikipedia.org/w/');
    $processed_string = str_replace($search, $replace , $string);
    echo $processed_string;
}

/*********
* Add automatic parent terms
************/

add_action('save_post', 'assign_parent_terms', 10, 2);

function assign_parent_terms($post_id, $post){

    if($post->post_type != 'place')
        return $post_id;

    // get all assigned terms   
    $terms = wp_get_post_terms($post_id, 'place_location' );
    foreach($terms as $term){
        while($term->parent != 0 && !has_term( $term->parent, 'place_location', $post )){
            // move upward until we get to 0 level terms
            wp_set_post_terms($post_id, array($term->parent), 'place_location', true);
            $term = get_term($term->parent, 'place_location');
        }
    }
}

/*********
* Hide Admin items for spesific user roles
* https://dessky.com/snippet/remove-menu-items-in-wp-admin-depending-on-user-role/
************/

/* Remove Tools admin menu item for everyone other than Administrator */
// add_action( 'admin_init', 'remove_menu_pages_for_all_except_admin' );
// function remove_menu_pages_for_all_except_admin() {
 
//     global $user_ID;
 
//     if ( !current_user_can('administrator') ) {
//         remove_menu_page('edit.php', 'edit.php');
//     }
// }

add_action( 'admin_init', 'remove_yoast_seo_admin_filters', 20 );
function remove_yoast_seo_admin_filters() {
    global $wpseo_meta_columns ;
    if ( $wpseo_meta_columns  ) {
        remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown' ) );
        remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
    }
}

/*********
* Add Custom Dashboard Widget
************/

add_action('wp_dashboard_setup', 'ke_custom_dashboard_widgets');
  
function ke_custom_dashboard_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget('custom_help_widget', 'Kültür Envanteri Atlası', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {
echo '<p>Hoşgeldiniz. Bir kültür varlığı girişi yapmadan önce lütfen veritabanımızda var olup olmadığını kontrol edin. Detaylı arama için: <a href="https://kulturenvanteri.com/wp-admin/index.php?page=relevanssi_admin_search">Admin Search</a> sayfasını kullanın. <a href="mailto:kulturenvanteriatlasi@gmail.com" target="_blank">E-posta</a> adresimizi veya Telegram Kültür Elçisi Grubumuzu kullanarak bize ulaşabilirsiniz.</p>';
echo '<p>Keyifli vakit geçirmeniz dileği ile...</p>';

}

/*********
*  FacetWP Search Results.
************/

add_filter( 'facetwp_result_count', function( $output, $params ) {
    $output = $params['total'] . ' sonuçtan ' . $params['lower'] . ' - ' . $params['upper'] . ' arası görüntüleniyor. ';
    return $output;
}, 10, 2 );

/*********
*  FacetWP Century Order
************/

add_filter( 'facetwp_facet_orderby', function( $orderby, $facet ) {
      if ( 'yuzyillar' == $facet['name'] ) {
          // to sort by raw value, use "f.facet_value" instead
          $orderby = 'FIELD(f.facet_value, "21-yy", "20-yy", "19-yy","18-yy","17-yy","16-yy","15-yy","14-yy","13-yy","12-yy","11-yy","10-yy","9-yy","8-yy","7-yy","6-yy","5-yy","4-yy","3-yy","2-yy","1-yy","mo-1-yy","mo-2-yy","mo-3-yy","mo-4-yy","mo-5-yy","mo-6-yy","mo-7-yy","mo-8-yy","mo-9-yy","mo-10-yy","mo-11-yy","mo-12-yy","mo-13-yy","mo-14-yy","mo-15-yy","mo-16-yy","mo-17-yy","mo-18-yy","mo-19-yy","mo-20-yy","mo-21-yy","mo-31-yy","mo-31-yy","mo-51-yy","mo-61-yy","mo-71-yy","mo-75-yy","mo-84-yy","mo-88-yy","mo-89-yy","mo-90-yy")';
      }
      return $orderby;
  }, 10, 2 );

/*********
*  FacetWP Search
************/

// Uppercase Input Value
// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toLocaleUpperCase
// https://stackoverflow.com/questions/11100041/how-do-you-automatically-set-text-box-to-uppercase

// add_filter( 'facetwp_facet_html', function( $output, $params ) {
// if ( 'search' == $params['facet']['name'] ) { // change 'search' to name of your facet
//       $output = str_replace ( '<input type="text" ' , '<input type="text" oninput="this.value = this.value.toLocaleUpperCase()" ' , $output );
// }
// return $output;
// }, 10, 2 );

/*********
*  FacetWP Limit Autocomplete to a Specific Country
************/

// add_filter( 'facetwp_proximity_autocomplete_options', function( $options ) {
//     $options['componentRestrictions'] = array(
//         'country' => 'tr',
//     );
//     return $options;
// });

/*********
*  FacetWP Change Proximity Label Text
************/

function change_proximity_label( $translated_text ) {
    if ( 'Enter location' == $translated_text ) {
        return 'Bir konum yazın';
    }
    return $translated_text;
}
add_filter( 'gettext', 'change_proximity_label' );

/*********
*  FacetWP Uzaklığa göre sırala
************/

// add_action( 'pre_get_posts', function( $query ) {
//       if ( ! class_exists( 'FacetWP_Helper' ) ) {
//           return;
//       }
  
//       $facets_in_use = FWP()->facet->facets;
//       $prefix = FWP()->helper->get_setting( 'prefix' );
//       $using_sort = isset( FWP()->facet->http_params['get'][ $prefix . 'sort' ] );
  
//       $is_main_query = false;
//       if ( is_array( FWP()->facet->template ) ) {
//           if ( 'wp' != FWP()->facet->template['name'] || true === $query->get( 'facetwp' ) ) {
//               $is_main_query = true;
//           }
//       }
  
//       if ( ! empty( $facets_in_use ) && ! $using_sort && $is_main_query ) {
//           foreach ( $facets_in_use as $f ) {
//               if ( 'proximity' == $f['type'] && ! empty( $f['selected_values'] ) ) {
//                   $query->set( 'orderby', 'post__in' );
//                   $query->set( 'order', 'ASC' );
//               }
//           }
//       }
//   });

/*********
* Author page query
* https://stackoverflow.com/questions/26399347/pagination-custom-post-in-author-php-not-found-in-second-page
************/

function custom_author_archive( &$query ) {
    if ($query->is_author)
        $query->set( 'post_type', 'place' ); //custom post type name 
}
add_action( 'pre_get_posts', 'custom_author_archive' );

/*********
* User Links for Navigation Menu
************/

/* To add a metabox in admin menu page */
add_action( 'admin_head-nav-menus.php', 'ke_add_custommenu_metabox' );
function ke_add_custommenu_metabox() {
      add_meta_box( 'add-ke_custommenu', __( 'Kullanıcı Bağlantıları' ), 'ke_custommenu_metabox', 'nav-menus', 'side', 'default' );
}

/* The metabox code. */
function ke_custommenu_metabox( $object ) {
      global $nav_menu_selected_id;

      $menukeywords = array(
            '#ke_login#' => __( 'Log In' ),
            '#ke_logout#' => __( 'Log Out' ),
            '#ke_loginout#' => __( 'Log In/Out' ),
            '#ke_register#' => __( 'Register/Sign Up' ),
            '#ke_profile#' => __( 'Profile' )
      );

      class keCustomMenuItems {
            public $db_id = 0;
            public $object = 'ke_custommenu';
            public $object_id;
            public $menu_item_parent = 0;
            public $type = 'custom';
            public $title;
            public $url;
            public $target = '';
            public $attr_title = '';
            public $classes = array();
            public $xfn = '';
      }

      $menukeywords_obj = array();
      foreach ( $menukeywords as $value => $title ) {
            $menukeywords_obj[ $title ] 				= new keCustomMenuItems();
            $menukeywords_obj[ $title ]->object_id		= esc_attr( $value );
            $menukeywords_obj[ $title ]->title			= esc_attr( $title );
            $menukeywords_obj[ $title ]->url			= esc_attr( $value );
      }
      $walker = new Walker_Nav_Menu_Checklist( array() );
      ?>
      <div id="ke-custommenu" class="loginlinksdiv">
            <div id="tabs-panel-ke-custommenu-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
                  <ul id="ke-custommenuchecklist" class="list:ke-custommenu categorychecklist form-no-clear">
                        <?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $menukeywords_obj ), 0, (object) array( 'walker' => $walker ) ); ?>
                  </ul>
            </div>

            <p class="button-controls">
                  <span class="list-controls">
                        <a href="<?php echo admin_url('/nav-menus.php?ke_custommenu-tab=all&amp;selectall=1#ke-custommenu');?>" class="select-all aria-button-if-js" role="button">Select All</a>
                  </span>
                  <span class="add-to-menu">
                        <input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-ke-custommenu-menu-item" id="submit-ke-custommenu" />
                        <span class="spinner"></span>
                  </span>
            </p>
      </div>
      <?php
}

/* Replace the #keyword# by links */
add_filter( 'wp_setup_nav_menu_item', 'ke_setup_nav_menu_item' );
function ke_setup_nav_menu_item( $menu_item ) {
      global $currentpage;

      $menukeywords = array( '#ke_login#', '#ke_logout#', '#ke_loginout#', '#ke_register#', '#ke_profile#' );

      if ( isset( $menu_item->object, $menu_item->url )
            && $currentpage != 'nav-menus.php'
            && !is_admin()
            && 'custom'== $menu_item->object
            && in_array( $menu_item->url, $menukeywords ) ) {
            
            $item_url = substr( $menu_item->url, 0, strpos( $menu_item->url, '#', 1 ) ) . '#';

            $item_redirect = str_replace( $item_url, '', $menu_item->url );

            if( $item_redirect == '%actualpage%') {
                  $item_redirect = $_SERVER['REQUEST_URI'];
            }

            switch ( $item_url ) {
                  case '#ke_login#'    : $menu_item->url = wp_login_url( $item_redirect ); break;
                  case '#ke_logout#'   : $menu_item->url = wp_logout_url( $item_redirect ); break;
                  case '#ke_profile#'   :
                        if( is_user_logged_in() ) {
                              $current_user = wp_get_current_user();
                              $menu_item->title = $current_user->display_name;
                              //$menu_item->title = '<span class="dashicons dashicons-admin-users"></span>';
                              $menu_item->url = home_url() . '/author/' . get_the_author_meta( 'user_login', wp_get_current_user()->ID );
                        }else{
                              $menu_item->title = '#ke_profile#';
                        }
                  break;

                  case '#ke_register#' :
                        if( is_user_logged_in() ) {
                              $menu_item->title = '#ke_register#';
                        } else {
                              $menu_item->url = wp_registration_url();
                        }
                  break;

                  case '#ke_loginout#' :
                        if( is_user_logged_in() ) {
                              $menu_item->title = 'Log Out';
                              $menu_item->url = wp_logout_url();
                        } else {
                              $menu_item->title = 'Log In';
                              $menu_item->url = wp_login_url();
                        }
                  break;
            }

            $menu_item->url = esc_url( $menu_item->url );
      }

      return $menu_item;
}

add_filter( 'wp_nav_menu_objects', 'ke_nav_menu_objects' );
function ke_nav_menu_objects( $sorted_menu_items ) {
      foreach ( $sorted_menu_items as $k => $item ) {
            if ( $item->title==$item->url && '#ke_register#' == $item->title ) {
                  unset( $sorted_menu_items[ $k ] );
            }

            if ( $item->title==$item->url && '#ke_profile#' == $item->title ) {
                  unset( $sorted_menu_items[ $k ] );
            }

      }
      return $sorted_menu_items;
}



