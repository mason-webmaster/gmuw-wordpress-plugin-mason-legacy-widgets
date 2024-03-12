<?php

/**
 * Main plugin file for the Mason WordPress plugin: legacy_widgets
 */

/**
 * Plugin Name:       Mason WordPress: Enable Legacy Widgets
 * Author:            Mason Web Administration
 * Plugin URI:        https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-legacy-widgets
 * Description:       Mason WordPress Plugin to implement legacy widgets in the block editor
 * Version:           0.9
 */


// Exit if this file is not called directly.
if (!defined('WPINC')) {
	die;
}

// Set up auto-updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
'https://github.com/mason-webmaster/gmuw-wordpress-plugin-mason-legacy-widgets/',
__FILE__,
'gmuw-wordpress-plugin-mason-legacy-widgets'
);

//implement support for legacy widgets in the block editor

//https://developer.wordpress.org/block-editor/how-to-guides/widgets/legacy-widget-block/#using-the-legacy-widget-block-in-other-block-editors-advanced

//First, ensure that any styles and scripts required by the legacy widgets are loaded onto the page. A convenient way of doing this is to manually perform all of the hooks that ordinarily run when a user browses to the widgets WP Admin screen.

add_action( 'admin_print_styles', function() {
    if ( get_current_screen()->is_block_editor() ) {
        do_action( 'admin_print_styles-widgets.php' );
    }
} );
add_action( 'admin_print_scripts', function() {
    if ( get_current_screen()->is_block_editor() ) {
        do_action( 'load-widgets.php' );
        do_action( 'widgets.php' );
        do_action( 'sidebar_admin_setup' );
        do_action( 'admin_print_scripts-widgets.php' );
    }
} );
add_action( 'admin_print_footer_scripts', function() {
    if ( get_current_screen()->is_block_editor() ) {
        do_action( 'admin_print_footer_scripts-widgets.php' );
    }
} );
add_action( 'admin_footer', function() {
    if ( get_current_screen()->is_block_editor() ) {
        do_action( 'admin_footer-widgets.php' );
    }
} );

//Then, register the Legacy Widget block using registerLegacyWidgetBlock which is defined in the @wordpress/widgets package.

add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_script( 'wp-widgets' );
    wp_add_inline_script( 'wp-widgets', 'wp.widgets.registerLegacyWidgetBlock()' );
} );
