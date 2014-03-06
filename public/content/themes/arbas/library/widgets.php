<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 06.03.14
 * Time: 10:35
 */


// adding sidebars to Wordpress (these are created in functions.php)
add_action( 'widgets_init', 'wp_bootstrap_register_sidebars' );