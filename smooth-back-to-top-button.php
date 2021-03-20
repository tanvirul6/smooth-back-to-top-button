<?php
/*
Plugin Name: Smooth Back To Top Button
Plugin URI: https://wordpress.org/plugins/smooth-back-to-top-button/
Description: The best WordPress smooth back to top button plugin with scroll progress indicator.
Author: Tanvirul Haque
Author URI: http://wpxpress.net/
Version: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: smooth-back-to-top-button
Domain Path: /languages
*/

// Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class
 * @since 1.0.0
 */
if ( ! class_exists( 'Smooth_Back_To_Top_Button' ) ) {
	class Smooth_Back_To_Top_Button {

		/**
		 * Version
		 *
		 * @since 1.0.0
		 * @var  string
		 */
		public $version = '1.0.5';


		/**
		 * The single instance of the class.
		 */
		protected static $instance = null;


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
		 * and if it doesn't find one, creates it.
		 *
		 * @return object Class instance
		 * @since 1.0.0
		 *
		 */
		public static function instance() {

			if ( null === self::$instance ) {

				self::$instance = new self();

			}

			return self::$instance;

		}


		/**
		 * Define constants
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		private function define_constants() {

			define( 'SBTTB_VERSION', $this->version );
			define( 'SBTTB_FILE', __FILE__ );
			define( 'SBTTB_DIR_PATH', plugin_dir_path( SBTTB_FILE ) );
			define( 'SBTTB_DIR_URI', plugin_dir_url( SBTTB_FILE ) );
			define( 'SBTTB_ADMIN', SBTTB_DIR_PATH . 'admin' );
			define( 'SBTTB_ASSETS', SBTTB_DIR_URI . 'assets' );

		}


		/**
		 * Include required files
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 */
		private function includes() {

			if ( is_admin() ) {
				require_once SBTTB_ADMIN . '/class-sbttb_settings_api.php';
				require_once SBTTB_ADMIN . '/class-sbttb_settings.php';
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
			add_action( 'wp_head', array( $this, 'internal_styles' ) );
			add_action( 'wp_head', array( $this, 'add_markup' ) );
			add_action( 'wp_footer', array( $this, 'internal_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
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

			load_plugin_textdomain( 'smooth-back-to-top-button', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		}


		/**
		 * Plugin action links
		 *
		 * @param array $links
		 *
		 * @return array
		 */
		public function plugin_settings_links( $links ) {

			$links[] = '<a href="' . admin_url( 'admin.php?page=' ) . 'smooth-back-to-top">' . __( 'Settings', 'smooth-back-to-top-button' ) . '</a>';

			return $links;

		}


		public function enqueue_scripts() {
			$is_enable_btn = self::get_settings( 'is_enable_btn', 'on' );

			if ( $is_enable_btn != 'on' ) {
				return;
			}

			wp_register_style( 'sbttb-fonts', SBTTB_ASSETS . '/css/sbttb-fonts.css', array(), SBTTB_VERSION );
			wp_register_style( 'sbttb-style', SBTTB_ASSETS . '/css/smooth-back-to-top-button.css', array(), SBTTB_VERSION );
			wp_register_script( 'sbttb-script', SBTTB_ASSETS . '/js/smooth-back-to-top-button.js', array( 'jquery' ), SBTTB_VERSION, true );

			wp_enqueue_style( 'sbttb-fonts' );
			wp_enqueue_style( 'sbttb-style' );
			wp_enqueue_script( 'sbttb-script' );

		}


		public function admin_enqueue_scripts() {

			wp_register_style( 'sbttb-fonts', SBTTB_ASSETS . '/css/sbttb-fonts.css', array(), SBTTB_VERSION );
			wp_enqueue_style( 'sbttb-fonts' );

		}


		/**
		 * Get Settings Function
		 *
		 * @param $key
		 * @param bool $default
		 * @param string $section
		 *
		 * @return bool
		 */
		public static function get_settings( $key, $default = false, $section = 'sbttb_settings' ) {

			$settings = get_option( $section, [] );

			return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;

		}


		/**
		 * Add Internal Style
		 */
		public function internal_styles() {
			$is_enable_btn = self::get_settings( 'is_enable_btn', 'on' );

			if ( $is_enable_btn != 'on' ) {
				return;
			}

			$icon_type      = self::get_settings( 'icon_type', 'arrow-up-light' );
			$button_margin  = absint( self::get_settings( 'button_margin', '50' ) );
			$button_size    = absint( self::get_settings( 'button_size', '46' ) );
			$border_size    = absint( self::get_settings( 'border_size', '2' ) );
			$icon_size      = absint( self::get_settings( 'icon_size', '24' ) );
			$progress_size  = absint( self::get_settings( 'progress_size', '4' ) );
			$button_color   = esc_attr( self::get_settings( 'button_color', '#0000' ) );
			$border_color   = esc_attr( self::get_settings( 'border_color', '#cccccc' ) );
			$icon_color     = esc_attr( self::get_settings( 'icon_color', '#1f2029' ) );
			$progress_color = esc_attr( self::get_settings( 'progress_color', '#1f2029' ) );
			$hover_color    = esc_attr( self::get_settings( 'hover_color', '#1f2029' ) );
			$is_hide_mobile = self::get_settings( 'hide_on_mobile', 'off' );
			$is_hide_tablet = self::get_settings( 'hide_on_tablet', 'off' );
			$custom_css     = wp_filter_nohtml_kses( self::get_settings( 'sbttb_custom_css', '' ) );

			switch ( $icon_type ) {
				case 'arrow-up-bold' :
					$icon = '\e911';
					break;
				case 'angle-double-up-black' :
					$icon = '\e908';
					break;
				case 'angle-up' :
					$icon = '\e90c';
					break;
				case 'angle-double-up' :
					$icon = '\e90a';
					break;
				case 'finger-up' :
					$icon = '\e904';
					break;
				case 'finger-up-o' :
					$icon = '\e905';
					break;
				default:
					$icon = '\e900';
			}
			?>

            <style type="text/css">
                .progress-wrap {
                    bottom: <?php echo $button_margin; ?>px;
                    height: <?php echo $button_size; ?>px;
                    width: <?php echo $button_size; ?>px;
                    border-radius: <?php echo $button_size; ?>px;
                    background-color: <?php echo $button_color; ?>;
                    box-shadow: inset 0 0 0 <?php echo $border_size; ?>px<?php echo $border_color; ?>;
                }

                .progress-wrap.btn-left-side {
                    left: <?php echo $button_margin; ?>px;
                }

                .progress-wrap.btn-right-side {
                    right: <?php echo $button_margin; ?>px;
                }

                .progress-wrap::after {
                    width: <?php echo $button_size; ?>px;
                    height: <?php echo $button_size; ?>px;
                    color: <?php echo $icon_color; ?>;
                    font-size: <?php echo $icon_size; ?>px;
                    content: '<?php echo $icon; ?>';
                    line-height: <?php echo $button_size; ?>px;
                }

                .progress-wrap:hover::after {
                    color: <?php echo $hover_color; ?>;
                }

                .progress-wrap svg.progress-circle path {
                    stroke: <?php echo $progress_color; ?>;
                    stroke-width: <?php echo $progress_size; ?>px;
                }

                <?php echo $custom_css ? $custom_css : ''; ?>

                <?php if ( $is_hide_tablet == 'on' ) { ?>
                @media only screen and (min-width: 768px) and (max-width: 991px) {
                    .progress-wrap {
                        display: none;
                    }
                }
                <?php } ?>

                <?php if ( $is_hide_mobile == 'on' ) { ?>
                @media only screen and (max-width: 767px) {
                    .progress-wrap {
                        display: none;
                    }
                }
                <?php } ?>

            </style>

			<?php
		}


		/**
		 * Add Internal JavaScript
		 */
		public function internal_scripts() {
			$is_enable_btn = self::get_settings( 'is_enable_btn', 'on' );

			if ( $is_enable_btn != 'on' ) {
				return;
			}

			$button_offset   = absint( self::get_settings( 'button_offset', '50' ) );
			$scroll_duration = absint( self::get_settings( 'scroll_duration', '500' ) );
			$is_enable_async = self::get_settings( 'is_enable_async', 'off' );
			$js_async		 = ( 'on' == $is_enable_async ) ? ' async="async" defer="defer"' : '' ;
			?>

            <script type="text/javascript"<?php echo $js_async; ?>>
                var offset = <?php echo $button_offset; ?>;
                var duration = <?php echo $scroll_duration; ?>;

                jQuery(window).on('load', function () {
                	jQuery(window).on('scroll', function () {
	                    if (jQuery(this).scrollTop() > offset) {
	                        jQuery('.progress-wrap').addClass('active-progress');
	                    } else {
	                        jQuery('.progress-wrap').removeClass('active-progress');
	                    }
	                });

	                jQuery('.progress-wrap').on('click', function (e) {
	                    e.preventDefault();
	                    jQuery('html, body').animate({scrollTop: 0}, duration);
	                    return false;
	                })
                })
            </script>

			<?php
		}


		/**
		 * Add Markup
		 */
		public function add_markup() {
			$is_enable_btn = self::get_settings( 'is_enable_btn', 'on' );

			if ( $is_enable_btn != 'on' ) {
				return;
			}

			$size               = absint( self::get_settings( 'progress_size', '4' ) );
			$view_box           = '-' . $size / 2 . ' -' . $size / 2 . ' ' . ( 100 + $size ) . ' ' . ( 100 + $size );
			$button_position    = self::get_settings( 'button_position', 'right-side' );
			$is_enable_progress = self::get_settings( 'is_enable_progress', 'on' );
			$position_class     = ( $button_position == 'left-side' ) ? 'btn-left-side' : 'btn-right-side';
			?>

            <div class="progress-wrap <?php echo $position_class; ?>">
				<?php if ( $is_enable_progress == 'on' ) { ?>
                    <svg class="progress-circle" width="100%" height="100%" viewBox="<?php echo $view_box; ?>">
                        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
                    </svg>
				<?php } ?>
            </div>

			<?php
		}

	}
}


/**
 * Initialize the plugin
 *
 * @return object
 */
function smooth_back_to_top_button() {
	return Smooth_Back_To_Top_Button::instance();
}

// Kick Off
smooth_back_to_top_button();
