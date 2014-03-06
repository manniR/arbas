<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 05.03.14
 * Time: 23:43
 */

// rewrite rule
add_filter('rewrite_rules_array', 'wp_insertMyRewriteRules');
add_filter('query_vars', 'wp_insertMyRewriteQueryVars');
//add_filter('init','flushRules');

// Remember to flush_rules() when adding rules
function flushRules()
{
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