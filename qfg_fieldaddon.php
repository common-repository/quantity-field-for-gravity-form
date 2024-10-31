<?php
/*
Plugin Name: Quantity Field for Gravity Form. 
Plugin URI: http://www.dopetheme.com
Description: A simple add-on to add quantity field type to Gravity Form.
Version: 1.0
Author: Dopetheme
Author URI: https://dopetheme.com/products/category/wordpress-plugins/
License: GPLv2 or later
Text Domain: qfgravity
Domain Path: /languages
*/

define( 'QFG_FIELD_ADDON_VERSION', '1.0' );

add_action( 'gform_loaded', array( 'QFG_AddOn_Bootstrap', 'load' ), 5 );

class QFG_AddOn_Bootstrap {
    public static function load() {
        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }
        require_once( 'class-qfg_fieldaddon.php' );
        GFAddOn::register( 'QFGFieldAddOn' );
    }
}