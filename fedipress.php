<?php
/**
 * Plugin Name: Fedipress
 * Description: A plugin to customize Frieds Ppugin layout
 * Version: 1.0
 * Author: Lívia Gouvêa
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function fedipress_enqueue_scripts() {
    wp_enqueue_style('meu-plugin-estilo', plugin_dir_url(__FILE__) . 'css/friends.css');
}
add_action('wp_enqueue_scripts', 'fedipress_enqueue_scripts');

