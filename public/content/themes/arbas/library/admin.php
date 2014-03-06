<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05.03.14
 * Time: 23:42
 */




// Add Editor Style
function mr_theme_add_editor_styles() {
  add_editor_style( 'editor-style.css' );
}
add_action( 'init', 'mr_theme_add_editor_styles' );




/*
 * ADMIN TOURDATE LISTING
 * post_type = tourdate
 *
 * */

// table header
add_filter('manage_tourdate_posts_columns', 'mr_tourdate_table_head');

function mr_tourdate_table_head($defaults)
{
  //$defaults['datum'] = 'Datum';

  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __('Title'),
    'tourdate' => __('Tourdate')
  );

  return $columns;
  //return $defaults;

}


//table data
add_action('manage_tourdate_posts_custom_column', 'mr_manage_tourdate_columns', 10, 2);

function mr_manage_tourdate_columns($column, $post_id)
{
  global $post;

  switch ($column) {
    case 'tourdate':
      //setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
      setlocale(LC_TIME, 'de_DE'); //  deutsch Monatsnamen
      echo strftime('%d. %B %Y', strtotime(get_field('datum', $post_id)));
      break;
    default:
      break;
  }
}

//make it sortable
add_filter('manage_edit-tourdate_sortable_columns', 'mr_tourdate_sortable_columns');

function mr_tourdate_sortable_columns($columns)
{

  $columns['tourdate'] = 'tourdate';
  return $columns;
}


/* Only run our customization on the 'edit.php' page in the admin. */
add_action('load-edit.php', 'mr_edit_tourdate_load');

function mr_edit_tourdate_load()
{
  add_filter('request', 'mr_sort_tourdate');
}

/* Sorts the tourdates. */
function mr_sort_tourdate($vars)
{

  /* Check if we're viewing the 'movie' post type. */
  if (isset($vars['post_type']) && 'touredate' == $vars['post_type']) {

    /* Check if 'orderby' is set to 'duration'. */
    if (isset($vars['orderby']) && 'touredate' == $vars['orderby']) {

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



// gets triggerd when click on edit
add_action('load-post.php', 'mr_edit_post');
function mr_edit_post()
{

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

