<?php
/*
Plugin Name: WP Back To Top Button
Plugin URI: http://wpxpress.net/wp-back-to-top-button/
Description: The best WordPress back to top plugin With scroll progress indicator.
Author: wpXpress
Author URI: http://wpxpress.net/
Version: 1.0.0
License: GPLv2+
Text Domain: wpst
Domain Path: /languages
*/

// Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'WP_Scroll_Top' ) ) {
	class WP_Scroll_Top {

		/**
		 * Version
		 *
		 * @since 1.0.0
		 * @var  string
		 */
		public $version = '1.0.0';


		/**
		 * Constructor for the class
		 *
		 * Sets up all the appropriate hooks and actions
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		public function __construct() {

			// Define constants
			$this->define_constants();

			// Include required files
			$this->includes();

			// Initialize the action hooks
			$this->init_hooks();

		}


		/**
		 * Initializes the class
		 *
		 * Checks for an existing instance
		 * and if it does't find one, creates it.
		 *
		 * @return object Class instance
		 * @since 1.0.0
		 *
		 */
		public static function init() {

			static $instance = false;

			if ( ! $instance ) {
				$instance = new self();
			}

			return $instance;

		}


		/**
		 * Define constants
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		private function define_constants() {

			define( 'WPST_VERSION', $this->version );
			define( 'WPST_FILE', __FILE__ );
			define( 'WPST_DIR_PATH', plugin_dir_path( WPST_FILE ) );
			define( 'WPST_DIR_URI', plugin_dir_url( WPST_FILE ) );
			define( 'WPST_INCLUDES', WPST_DIR_PATH . 'inc' );
			define( 'WPST_ADMIN', WPST_DIR_PATH . 'admin' );
			define( 'WPST_ASSETS', WPST_DIR_URI . 'assets' );
		}


		/**
		 * Include required files
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		private function includes() {

			require WPST_INCLUDES . '/functions.php';

			if ( is_admin() ) {
				require WPST_ADMIN . '/admin.php';
			}


		}


		/**
		 * Init Hooks
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		private function init_hooks() {

			add_action( 'init', array( $this, 'localization_setup' ) );
			add_action( 'wp_head', array( $this, 'add_markup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_settings_links' ) );

		}


		/**
		 * Initialize plugin for localization
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		public function localization_setup() {

			load_plugin_textdomain( 'wpst', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		}


		/**
		 * Plugin action links
		 *
		 * @param array $links
		 *
		 * @return array
		 */
		function plugin_settings_links( $links ) {

			$links[] = '<a href="' . admin_url( 'admin.php?page=' ) . '">' . __( 'Settings', 'wpst' ) . '</a>';

			return $links;

		}


		function add_markup() {
			?>
            <div class="progress-wrap">
                <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                    <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
                </svg>
            </div>
			<?php
		}


		function enqueue_scripts() {
			wp_enqueue_style( 'unicons-font', '//s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/unicons.css', array(), '1.0.0' );
			wp_enqueue_style( 'wpst-style', WPST_ASSETS . '/css/wp-scroll-top.css', array(), '1.0.0' );
			wp_enqueue_script( 'wpst-script', WPST_ASSETS . '/js/wp-scroll-top.js', array( 'jquery' ), '1.0.0', true );
		}


	}
}


/**
 * Initialize the plugin
 *
 * @return object
 */
function wpx_scroll_top() {
	return WP_Scroll_Top::init();
}

// Kick Off
wpx_scroll_top();
