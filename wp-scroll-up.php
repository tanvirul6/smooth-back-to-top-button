<?php
/*
Plugin Name: WP Scroll Up
Plugin URI: http://wpxpress.net/wp-scroll-up/
Description: This is a back to top plugin With scroll progress indicator.
Author: wpXpress
Author URI: http://wpxpress.net/
Version: 1.0.0
License: GPLv2+
Text Domain: wp-scroll-up
Domain Path: /languages
*/

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpx_markup_add' ) ) {
	function wpx_markup_add() {
		?>
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
            </svg>
        </div>
		<?php
	}

	add_action( 'wp_head', 'wpx_markup_add' );
}

if ( ! function_exists( 'wpx_scripts' ) ) {
	function wpx_scripts() {
		wp_enqueue_style( 'unicons-font', '//s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/unicons.css', array(), '1.0.0' );
		wp_enqueue_style( 'wpx-style', plugin_dir_url( __FILE__ ) . 'assets/css/wp-scroll-up.css', array(), '1.0.0' );
		wp_enqueue_script( 'wpx-script', plugin_dir_url( __FILE__ ) . 'assets/js/wp-scroll-up.js', array( 'jquery' ), '1.0.0', true );
	}

	add_action( 'wp_enqueue_scripts', 'wpx_scripts' );
}

