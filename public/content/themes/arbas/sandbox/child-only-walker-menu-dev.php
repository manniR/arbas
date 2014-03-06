<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05.03.14
 * Time: 23:45
 */


/*
 * custom walker menu for list pages
 */

// page menu
register_nav_menus(
  array(
    // location => description
    'theme_location' => 'hp_side_menu'
  )
);

function hp_side_nav()
{
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
class MR_Child_Only_Walker extends Walker_Nav_Menu
{


  // Don't start the top level
  function start_lvl(&$output, $depth = 0, $args = array())
  {

    //$output .='alsdkfj';
    if (0 == $depth)
      return;
    parent::start_lvl($output, $depth, $args);
  }

  // Don't end the top level
  function end_lvl(&$output, $depth = 0, $args = array())
  {


    //$output .='aa';
    if (0 == $depth)
      return;
    parent::end_lvl($output, $depth, $args);
  }

  // Don't print top-level elements
  function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0)
  {

    //$output .='start el: title: '. $object->post_title .' ';


    if (0 == $depth)
      return;

    parent::start_el($output, $object, $depth = 0, $args, $current_object_id);
  }

  function end_el(&$output, $object, $depth = 0, $args = array())
  {

    $output .= " end el <br/>";


    if (0 == $depth)
      return;

    parent::end_el($output, $object, $depth, $args);
  }


  // Only follow down one branch
  function display_element($object, &$children_elements, $max_depth, $depth = 0, $args, &$output)
  {
    // Check if element as a 'current element' class
    $current_element_markers = array('current-menu-item', 'current-menu-parent', 'current-menu-ancestor');

    /* echo '<pre>';
     var_dump($object);
     echo '</pre>';*/


    //var_dump($output);
    //$current_class = array_intersect( $current_element_markers, $element->classes );

    // If element has a 'current' class, it is an ancestor of the current element
    $ancestor_of_current = !empty($current_class);

    // If this is a top-level link and not the current, or ancestor of the current menu item - stop here.
    if (0 == $depth)
      return;

    return parent::display_element($object, $children_elements, $max_depth, $depth, $args, $output);
  }
} // end Child only Walker