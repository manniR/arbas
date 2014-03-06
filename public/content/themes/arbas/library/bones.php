<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Adding Translation Option
load_theme_textdomain( 'wpbootstrap', TEMPLATEPATH.'/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH."/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

// Cleaning up the Wordpress Head
function wp_bootstrap_head_cleanup() {
	// remove header links
	remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
	remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
	remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
	remove_action( 'wp_head', 'index_rel_link' );                         // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
	remove_action( 'wp_head', 'wp_generator' );                           // WP version
}
	// launching operation cleanup
	add_action('init', 'wp_bootstrap_head_cleanup');
	// remove WP version from RSS
	function wp_bootstrap_rss_version() { return ''; }
	add_filter('the_generator', 'wp_bootstrap_rss_version');

// loading jquery reply elements on single pages automatically
function wp_bootstrap_queue_js(){ if (!is_admin()){ if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script( 'comment-reply' ); }
}
	// reply on comments script
	add_action('wp_print_scripts', 'wp_bootstrap_queue_js');

// Fixing the Read More in the Excerpts
// This removes the annoying […] to a Read More link
function wp_bootstrap_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" class="more-link" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}
add_filter('excerpt_more', 'wp_bootstrap_excerpt_more');

// Adding WP 3+ Functions & Theme Support
function wp_bootstrap_theme_support() {
  add_theme_support('post-thumbnails');      // wp thumbnails (sizes handled in functions.php)
  set_post_thumbnail_size(125, 125, true);   // default thumb size
  add_theme_support( 'custom-background' );  // wp custom background
  add_theme_support('automatic-feed-links'); // rss thingy
  // to add header image support go here: http://themble.com/support/adding-header-background-image-support/
  // adding post format support
  add_theme_support( 'post-formats',      // post formats
    array(
      'aside',   // title less blurb
      'gallery', // gallery of images
      'link',    // quick link to other site
      'image',   // an image
      'quote',   // a quick quote
      'status',  // a Facebook like status update
      'video',   // video
      'audio',   // audio
      'chat'     // chat transcript
    )
  );
  add_theme_support( 'menus' );            // wp menus
  register_nav_menus(                      // wp3+ menus
    array(
      'main_nav' => 'The Main Menu',   // main nav in header
      'footer_links' => 'Footer Links' // secondary nav in footer
    )
  );
}
