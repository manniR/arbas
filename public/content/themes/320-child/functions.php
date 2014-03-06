<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22.01.14
 * Time: 18:42
 */

add_filter('rewrite_rules_array','wp_insertMyRewriteRules');
add_filter('query_vars','wp_insertMyRewriteQueryVars');
//add_filter('init','flushRules');

// Remember to flush_rules() when adding rules
function flushRules(){
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

// Adding a new rule
function wp_insertMyRewriteRules($rules)
{
    $newrules = array();
    $newrules['programm/(.+)'] = 'index.php?pagename=programm&monat=$matches[1]';
    $finalrules = $newrules + $rules;
    return $finalrules;
}

// Adding the var so that WP recognizes it
function wp_insertMyRewriteQueryVars($vars)
{
    array_push($vars, 'monat');
    return $vars;
}

//Stop wordpress from redirecting
remove_filter('template_redirect', 'redirect_canonical');




// get page parent id
function get_top_parent_page_id() {

    global $post;

    $ancestors = $post->ancestors;

    // Check if page is a child page (any level)
    if ($ancestors) {

        //  Grab the ID of top-level page from the tree
        return end($ancestors);

    } else {

        // Page is the top level, so use  it's own id
        return $post->ID;

    }
}

// add active class
add_filter('nav_menu_css_class', 'add_my_active_class', 10, 2 );
add_filter( 'page_css_class', 'add_my_active_class', 10, 5 );

function add_my_active_class($classes, $item) {

    if( in_array( 'current-menu-item', $classes ) ||
        in_array( 'current-menu-ancestor', $classes ) ||
        in_array( 'current-menu-parent', $classes ) ||
        in_array( 'current-page-parent', $classes ) ||
        in_array( 'current-page-item', $classes ) ||
        in_array( 'current_page_item', $classes ) ||
        in_array( 'current-page-ancestor', $classes )
    ) {

        $classes[] = "active";
    }

    return $classes;

}


/*
/*
 *
 * custom walker menu for list pages
 *
 */

// page menu
register_nav_menus(
    array(
        // location => description
         'theme_location' => 'hp_side_menu'
    )
);

function hp_side_nav() {
    // display the wp3 menu if available
    wp_nav_menu(
        array(
            //'menu' => 'main_nav', /* menu name */
            //'menu_class' => 'nav navbar-nav',
            //'theme_location' => 'hp_side_menu', /* where in the theme it's assigned */
            'container' => 'false', /* container class */
            //'fallback_cb' => 'wp_bootstrap_main_nav_fallback', /* menu fallback */
            // 'depth' => '2',  suppress lower levels for now
            'walker' => new MR_Child_Only_Walker(),
            'depth' => 0
        )
    );
}




/**
 * Class child only walker menu
 * @see Walker
 *
 */

class MR_Child_Only_Walker extends Walker_Nav_Menu {


    // Don't start the top level
    function start_lvl(&$output, $depth=0, $args=array()) {

        //$output .='alsdkfj';
        if( 0 == $depth )
            return;
        parent::start_lvl($output, $depth, $args);
    }

    // Don't end the top level
    function end_lvl(&$output, $depth=0, $args=array()) {



        //$output .='aa';
        if( 0 == $depth )
            return;
        parent::end_lvl($output, $depth, $args);
    }

    // Don't print top-level elements
    function start_el(&$output, $object, $depth=0, $args=array(), $current_object_id=0) {

        //$output .='start el: title: '. $object->post_title .' ';


        if( 0 == $depth )
            return;

        parent::start_el($output, $object, $depth = 0, $args, $current_object_id);
    }

    function end_el(&$output, $object, $depth=0, $args=array()) {

        $output .=" end el <br/>";


        if( 0 == $depth )
            return;

        parent::end_el($output, $object, $depth, $args);
    }



    // Only follow down one branch
    function display_element( $object, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        // Check if element as a 'current element' class
        $current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );

       /* echo '<pre>';
        var_dump($object);
        echo '</pre>';*/


        //var_dump($output);
        //$current_class = array_intersect( $current_element_markers, $element->classes );

        // If element has a 'current' class, it is an ancestor of the current element
        $ancestor_of_current = !empty($current_class);

        // If this is a top-level link and not the current, or ancestor of the current menu item - stop here.
        if ( 0 == $depth)
            return;

         return parent::display_element( $object, $children_elements, $max_depth, $depth, $args, $output );
    }
} // end Child only Walker



 /*
  * admin tourdates listing
  * post_type = tourdate
  *
  * */

// table header
add_filter('manage_tourdate_posts_columns', 'mr_tourdate_table_head');

function mr_tourdate_table_head($defaults){
    //$defaults['datum'] = 'Datum';

    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => __('Title'),
        'tourdate'  => __('Tourdate')
    );

    return $columns;
    //return $defaults;

}


//table data
add_action('manage_tourdate_posts_custom_column', 'mr_manage_tourdate_columns', 10,2);

function mr_manage_tourdate_columns($column, $post_id){
    global $post;

    switch($column){
        case 'tourdate':
            //setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
            setlocale(LC_TIME, 'de_DE');//  deutsch Monatsnamen
            echo strftime('%d. %B %Y',strtotime(get_field('datum',$post_id)));
            break;
        default:
            break;
    }
}

//make it sortable
add_filter( 'manage_edit-tourdate_sortable_columns', 'mr_tourdate_sortable_columns' );

function mr_tourdate_sortable_columns( $columns ) {

    $columns['tourdate'] = 'tourdate';
    return $columns;
}


/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'mr_edit_tourdate_load' );

function mr_edit_tourdate_load() {
    add_filter( 'request', 'mr_sort_tourdate' );
}

/* Sorts the tourdates. */
function mr_sort_tourdate( $vars ) {

    /* Check if we're viewing the 'movie' post type. */
    if ( isset( $vars['post_type'] ) && 'touredate' == $vars['post_type'] ) {

        /* Check if 'orderby' is set to 'duration'. */
        if ( isset( $vars['orderby'] ) && 'touredate' == $vars['orderby'] ) {

            /* Merge the query vars with our custom variables. */
            $vars = array_merge(
                $vars,
                array(
                    'meta_key' => 'datum',
                    'orderby' => 'meta_value_num'
                )
            );
        }
    }

    return $vars;
}

// Quick edit - Add to our admin_init function
add_action('quick_edit_custom_box',  'myown_add_quick_edit', 10, 2);

function myown_add_quick_edit($column_name, $post_type) {


    if ($column_name != 'tourdate') return;
    global $post;

    ?>
    <fieldset class="inline-edit-col-left">
        <div class="inline-edit-col">
            <span class="title">Date</span>
            <input id="tourdate" type="hidden" name="tourdate" value="" />
            <input id="myfield" type="text" name="myfield" value="<?php echo get_field('datum', $post->id) ?>"/>
        </div>
    </fieldset>
<?php
}

// gets triggerd when click on edit
add_action('load-post.php', 'mr_edit_post');
function mr_edit_post(){

    /**
     * @var wpbd $wpdb
     */

    /*global $wpdb;

    $post = get_post( $_GET['post']);
    echo $post->post_title;
    //$meta = new stdClass();
    $meta = get_post_meta($_GET['post']);
    //$meta = get_metadata('post',$_GET['post']);

    foreach ($meta as $fa => $fk) {
        echo $fa . '<br/>' ;
        foreach ($fk as $k => $v) {
            echo $k . ':::' . $v . '<br/>';
        }

    }*/


   /* echo '<pre>';
    var_dump($meta);
    echo '</pre>';*/


   //echo $_GET['post'];



    /*echo '<pre>';
     var_dump($wpdb);
     echo '</pre>';*/
}




/*
 controll settings for header image
*/

$args = array(
    //'flex-width'    => true,
    'width'         => 940,
    //'flex-height'   => true,
    'height'        => 360,
    'default-image' => get_template_directory_uri() . '/images/header.jpg',
);
add_theme_support( 'custom-header', $args );


add_action( 'wp_enqueue_scripts', 'theme_styles' );

// enqueue javascript
if( !function_exists( "hp_js" ) ) {
    function hp_js(){

        wp_register_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?',array(), null );
        wp_enqueue_style( 'font-awesome' );
        wp_register_script( 'fittext',
            get_stylesheet_directory_uri() . '/js/jquery.fittext.js',
            array('jquery'),
            '1.2' );
        wp_register_script( 'hp-main',
            get_stylesheet_directory_uri() . '/js/hp-main.js',
            array('jquery'),
            '1.2' );
        wp_enqueue_script('fittext');
        wp_enqueue_script('hp-main');

    }
}
add_action( 'wp_enqueue_scripts', 'hp_js' );


function mr_footer_menu() {
    // display the wp3 menu if available
    wp_nav_menu(
        array(
            'menu' => 'footer_links', /* menu name */
            'menu_class'      => 'nav nav-stacked nav-pills', /*menu class*/
            'menu_id' => 'footer-main-menu',
            'theme_location' => 'footer_links', /* where in the theme it's assigned */
            'container_class' => 'footer-links clearfix', /* container class */
            'fallback_cb' => 'wp_bootstrap_footer_links_fallback' /* menu fallback */
        )
    );
}
