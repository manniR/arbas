<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22.01.14
 * Time: 18:42
 */
// Get Bones and Core Up & Running!
require_once('library/bones.php');
require_once('library/admin.php');
require_once('library/menus.php');
require_once('library/extras.php');
require_once('library/extras.php');
require_once('library/helper.php');




// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'wpbs-featured', 780, 300, true );
add_image_size( 'wpbs-featured-home', 970, 311, true);
add_image_size( 'wpbs-featured-carousel', 970, 400, true);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

// ADD DEFAULT TWITTER BOOTSTRAP ACTIVE CLASS

add_filter('nav_menu_css_class', 'add_my_active_class', 10, 2);
add_filter('page_css_class', 'add_my_active_class', 10, 5);

function add_my_active_class($classes, $item)
{
  if (in_array('current-menu-item', $classes) ||
    in_array('current-menu-ancestor', $classes) ||
    in_array('current-menu-parent', $classes) ||
    in_array('current-page-parent', $classes) ||
    in_array('current-page-item', $classes) ||
    in_array('current_page_item', $classes) ||
    in_array('current-page-ancestor', $classes)
  ) {

    $classes[] = "active";
  }

  return $classes;

}

// CUSTOM HEADER IMAGE THEME SUPPORT
$args = array(
  //'flex-width'    => true,
  'width' => 940,
  //'flex-height'   => true,
  'height' => 360,
  'default-image' => get_template_directory_uri() . '/images/header.jpg',
);
add_theme_support('custom-header', $args);


//THEME STYLES
if (!function_exists("theme_styles")) {
  function theme_scripts(){
    wp_register_style('boostrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css?', array(), null);
    wp_register_style('font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?', array(), null);

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('font-awesome');
  }
}

add_action('wp_enqueue_scripts', 'theme_styles');

// enqueue javascript
if (!function_exists("theme_scripts")) {
  function theme_scripts()
  {
    wp_register_script('modernizer',get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array('jquery'), '1.2');
    wp_register_script('bootstrap-js',get_stylesheet_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), '1.2');
    wp_register_script('jquery-lightbox',get_stylesheet_directory_uri() . '/js/jquery.lightbox.js', array('jquery'), '1.2');
    wp_register_script('fittext',get_stylesheet_directory_uri() . '/js/jquery.fittext.js', array('jquery'), '1.2');

    wp_enqueue_script('modernizer');
    wp_enqueue_script('bootstrap-js');
    wp_enqueue_script('jquery-lightbox');
    wp_enqueue_script('main');
  }
}
add_action('wp_enqueue_scripts', 'theme_scripts');


function mr_footer_menu()
{
  // display the wp3 menu if available
  wp_nav_menu(
    array(
      'menu' => 'footer_links', /* menu name */
      'menu_class' => 'nav nav-stacked nav-pills', /*menu class*/
      'menu_id' => 'footer-main-menu',
      'theme_location' => 'footer_links', /* where in the theme it's assigned */
      'container_class' => 'footer-links clearfix', /* container class */
      'fallback_cb' => 'wp_bootstrap_footer_links_fallback' /* menu fallback */
    )
  );
}


// Disable jump in 'read more' link
function remove_more_jump_link( $link ) {
  $offset = strpos($link, '#more-');
  if ( $offset ) {
    $end = strpos( $link, '"',$offset );
  }
  if ( $end ) {
    $link = substr_replace( $link, '', $offset, $end-$offset );
  }
  return $link;
}
add_filter( 'the_content_more_link', 'remove_more_jump_link' );

// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
  $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
  return $html;
}



// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'wpbs-featured', 780, 300, true );
add_image_size( 'wpbs-featured-home', 970, 311, true);
add_image_size( 'wpbs-featured-carousel', 970, 400, true);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/



