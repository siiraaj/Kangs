<?php
/*
Plugin Name: STM Configurations
Plugin URI: http://stylemixthemes.com/
Description: STM Configurations
Author: Stylemix Themes
Author URI: http://stylemixthemes.com/
Text Domain: stm-configurations
Version: 2.4
*/

define( 'STM_CONFIGURATIONS', 'stm-post-type' );

$plugin_path = dirname(__FILE__);

if(!is_textdomain_loaded('stm-configurations')) {
	load_plugin_textdomain('stm-configurations', false, 'stm-configurations/languages');
}


/*Post types*/
require_once $plugin_path . '/post-types/post_types.php';