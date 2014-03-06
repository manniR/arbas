<?php
/*
Plugin Name: Ideenlandkarte
Version: 1.0
Plugin URI: 
Description: geocoding google maps
Author: manni
Author URI: 
*/

$version = "1.0";

function add_dbTables () {
   global $wpdb;
   global $version;

    $table_name = $wpdb->prefix . "ideenlandkarte";

    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    $sql = "CREATE TABLE " . $table_name . "  (
        id bigint(11) NOT NULL AUTO_INCREMENT,
        created TIMESTAMP DEFAULT NOW(),
        cat tinyint (1) NOT NULL DEFAULT '1',
        title VARCHAR(100) NOT NULL,
        city VARCHAR(30) NOT NULL,
        address VARCHAR(50) NOT NULL,
        comment text DEFAULT NULL,
        firstname tinytext NULL,
        lastname tinytext NULL,
        phone VARCHAR(50) NULL,
        email VARCHAR(50) NULL,
        lat FLOAT(15,11) NULL,
        lng FLOAT(15,11) NULL,
        ip VARCHAR(20) NULL,
        UNIQUE KEY id (id))
        ";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      add_option("ideenlandkarte_version", $version);
    }


    //UPDATE OPTIONs

   $installed_ver = get_option( "ideenlandkarte_version" );

   if( $installed_ver != $version ) {
      //update code for table
      $sql = "CREATE TABLE " . $table_name . "  (
        id bigint(11) NOT NULL AUTO_INCREMENT,
        created TIMESTAMP DEFAULT NOW(),
        cat tinyint (1) NOT NULL DEFAULT '1',
        title VARCHAR(100) NOT NULL,
        city VARCHAR(30) NOT NULL,
        address VARCHAR(50) NOT NULL,
        comment text DEFAULT NULL,
        firstname tinytext NULL,
        lastname tinytext NULL,
        phone VARCHAR(50) NULL,
        email VARCHAR(50) NULL,
        lat FLOAT(15,11) NULL,
        lng FLOAT(15,11) NULL,
        ip VARCHAR(20) NULL,
        UNIQUE KEY id (id))
        ";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      update_option( "ideenlandkarte_version", $version );
}

}



//ADMIN area

function ideenlandkarte_admin_init(){

   wp_register_style('admin-ideenlandkarte', WP_PLUGIN_URL . '/ideenlandkarte/admin-ideenlandkarte.css');

}

function ideenlandkarte_admin_menu(){

   $page= add_menu_page('Ideenlandkarte', 'Ideenlandkarte', 1,'Ideenlandkarte', 'ideenlandkarte_print_adminpage');
   add_action('admin_print_styles-' . $page, 'ideenlandkarte_admin_styles');

}

function ideenlandkarte_admin_styles(){
   wp_enqueue_style('admin-ideenlandkarte');
}




function ideenlandkarte_print_adminpage(){
   
//   include('ideenlandkarte_import_admin.php');


   include('ideenlandkarte_admin.php');
  
}





add_action('admin_menu', 'ideenlandkarte_admin_menu');
add_action('admin_init', 'ideenlandkarte_admin_init');

//calling the function
register_activation_hook(__FILE__,'add_dbTables');
