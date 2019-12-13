<?php
/*
Plugin Name: Custom Plugin
Plugin URI: http://www.google.com/
Description: This is my custom plugin description
Author: php trainee
Version: 1.0
Author URI: http://facebook.com/
*/


define('PLUGIN_DIR_PATH',plugin_dir_path(__FILE__));
define('PLUGIN_URL',plugins_url());
define('VERSION',1.0);
//echo PLUGIN_DIR_PATH."<br>".PLUGIN_URL;die;
function add_menu_on_admin_dashboard(){
    add_menu_page(
        '',
        'Custom Menu',
        'manage_options',
        'custom-menu',
        'show_custom_content',
        'dashicons-tag',
        '11'
    );
    add_submenu_page(
        'custom-menu',
        'Page Title 1',
        'Sub Menu 1',
        'manage_options',
        'custom-menu',
        'show_custom_content',
        ''
    );
    add_submenu_page(
        'custom-menu',
        'Page Title 2',
        'Sub Menu 2',
        'manage_options',
        'sub-menu',
        'submenu_content',
        ''
    );
}

add_action('admin_menu','add_menu_on_admin_dashboard');

function show_custom_content(){
    include_once PLUGIN_DIR_PATH."/views/sub-menu-1.php";
}

function submenu_content(){
    include_once PLUGIN_DIR_PATH."/views/sub-menu-2.php";
}

function add_assets_files_here(){
    wp_enqueue_style(
        'custom_style',
        PLUGIN_URL."/custom plugin/assets/css/style.css",
        '',
        VERSION,
        ''
    );

    wp_enqueue_script(
        'custom_script',
        PLUGIN_URL."/custom plugin/assets/js/script.js",
        '',
        VERSION,
        'true'
    );
}

add_action('init','add_assets_files_here');


function create_table_on_plugin_activation(){
    global $wpdb;
    require (ABSPATH.'wp-admin/includes/upgrade.php');

    if (count($wpdb->get_var('SHOW TABLES LIKE "wp_custom_plugin"'))==0){
        $create_table_sql = "CREATE TABLE `wp_custom_plugin` (  `id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(50) DEFAULT NULL,  `email` varchar(50) DEFAULT NULL, `mobile` varchar(20) DEFAULT NULL,  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";

        dbDelta($create_table_sql);
    };



}

register_activation_hook(__FILE__,'create_table_on_plugin_activation');


/*function delete_table_on_deactivation(){
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS wp_custom_plugin");
}

register_uninstall_hook(__FILE__,'delete_table_on_deactivation');*/
