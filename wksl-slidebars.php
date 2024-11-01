<?php
/*
Plugin Name: Slidebars
Plugin URI:  https://www.webkinder.ch
Description: Let's you create and customize slide-in sidebars
Version:     1.0.1
Author:      WebKinder
Author URI:  https://www.webkinder.ch
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: slidebars
*/

require_once( plugin_dir_path( __FILE__ ) . 'PluginFactory.php' );
require_once( plugin_dir_path( __FILE__ ) . 'Plugin.php' );
WebKinder\Slidebars\PluginFactory::create();
