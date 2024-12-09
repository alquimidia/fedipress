<?php
/**
 * Plugin Name: Fedipress
 * Description: A plugin to customize Friends Plugin layout
 * Plugin URI: github.com/alquimidia/fedipress/
 * Version: 1.0
 * Author: Lívia Gouvêa
 * License: GPL3
 * Text Domain: friends
 *
 * @package Fedipress
 */

namespace Friends;

defined( 'ABSPATH' ) || exit;
define( 'FEDIPRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

add_action(
	'friends_load_themes',
	function ( Frontend $friends_frontend ) {
		$friends_frontend->register_theme( 'Fedipress', 'fedipress' );
	}
);

add_action(
	'friends_load_theme_fedipress',
	function() {
		$handle = 'fedipress';
		$file = 'friends.css';
		$version = Friends::VERSION;
		wp_enqueue_style( $handle, plugins_url( $file, FEDIPRESS_PLUGIN_DIR . 'css/friends.css' ), array(), apply_filters( 'friends_debug_enqueue', $version, $handle, FEDIPRESS_PLUGIN_DIR . '/' . $file ) );
        wp_enqueue_script('fedipress-script', plugin_dir_url(__FILE__) . 'js/friends.js', array('jquery'), null, true);
	}
);

add_filter( 'friends_template_paths_theme_fedipress', function( $file_paths ) {
	$file_paths[ 15 ] = FEDIPRESS_PLUGIN_DIR . 'templates';
	return $file_paths;
} );