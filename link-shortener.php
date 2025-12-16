<?php
/**
 * Plugin Name: Nepsus Link Shortener
 * Plugin URI:  https://nepsus.com/
 * Description: A lightweight and fast URL shortener for WordPress using is.gd API.
 * Version:     1.0.0
 * Author:      Nepsus Tech
 * Author URI:  https://nepsus.com/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: nepsus-link-shortener
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

/**
 * Plugin constants
 */
define( 'NEPSUS_LS_VERSION', '1.0.0' );
define( 'NEPSUS_LS_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEPSUS_LS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Include required files
 */
require_once NEPSUS_LS_PATH . 'includes/shortcode.php';

/**
 * Enqueue frontend assets
 */
function nepsus_ls_enqueue_assets() {

    // CSS
    wp_enqueue_style(
        'nepsus-link-shortener-style',
        NEPSUS_LS_URL . 'assets/css/shortener.css',
        array(),
        NEPSUS_LS_VERSION
    );

    // JS
    wp_enqueue_script(
        'nepsus-link-shortener-script',
        NEPSUS_LS_URL . 'assets/js/shortener.js',
        array(),
        NEPSUS_LS_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'nepsus_ls_enqueue_assets' );