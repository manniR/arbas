<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05.03.14
 * Time: 23:48
 */


// get page parent id
function get_top_parent_page_id()
{
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