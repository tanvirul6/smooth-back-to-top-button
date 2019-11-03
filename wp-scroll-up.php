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
         * and if it does't find one, creates it.
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

            if ( is_admin() ) {
                require_once WPST_ADMIN . '/class-settings-api.php';
                require_once WPST_ADMIN . '/class-settings.php';
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

            $links[] = '<a href="' . admin_url( 'admin.php?page=' ) . 'wp-back-to-top">' . __( 'Settings', 'wpst' ) . '</a>';

            return $links;

        }


        function enqueue_scripts() {
            $is_enable_btn = self::get_settings( 'is_enable_btn' );

            if ( $is_enable_btn != 'on' ) {
                return;
            }

            wp_register_style( 'wpst-fonts', WPST_ASSETS . '/css/fonts.css', array(), WPST_VERSION );
            wp_register_style( 'wpst-style', WPST_ASSETS . '/css/wp-scroll-top.css', array(), WPST_VERSION );
            wp_register_script( 'wpst-script', WPST_ASSETS . '/js/wp-scroll-top.js', array( 'jquery' ), WPST_VERSION, true );

            wp_enqueue_style( 'wpst-fonts' );
            wp_enqueue_style( 'wpst-style' );
            wp_enqueue_script( 'wpst-script' );

        }


        function admin_enqueue_scripts() {

            wp_register_style( 'wpst-fonts', WPST_ASSETS . '/css/fonts.css', array(), WPST_VERSION );
            wp_enqueue_style( 'wpst-fonts' );

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
        public static function get_settings( $key, $default = false, $section = 'wpst_settings' ) {

            $settings = get_option( $section, [] );

            return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;

        }


        public function internal_styles() {
            $is_enable_btn = self::get_settings( 'is_enable_btn' );

            if ( $is_enable_btn != 'on' ) {
                return;
            }

            $icon_type      = self::get_settings( 'icon_type' );
            $button_margin  = absint( self::get_settings( 'button_margin' ) );
            $button_size    = absint( self::get_settings( 'button_size' ) );
            $icon_size      = absint( self::get_settings( 'icon_size' ) );
            $progress_size  = absint( self::get_settings( 'progress_size' ) );
            $button_color   = esc_attr( self::get_settings( 'button_color' ) );
            $border_color   = esc_attr( self::get_settings( 'border_color' ) );
            $icon_color     = esc_attr( self::get_settings( 'icon_color' ) );
            $progress_color = esc_attr( self::get_settings( 'progress_color' ) );
            $hover_color    = esc_attr( self::get_settings( 'hover_color' ) );

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
                    box-shadow: inset 0 0 0 <?php echo $progress_size / 2; ?>px<?php echo $border_color; ?>;
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
            </style>

            <?php
        }


        public function internal_scripts() {
            $is_enable_btn = self::get_settings( 'is_enable_btn' );

            if ( $is_enable_btn != 'on' ) {
                return;
            }

            $button_offset   = absint( self::get_settings( 'button_offset' ) );
            $scroll_duration = absint( self::get_settings( 'scroll_duration' ) );
            ?>

            <script type="text/javascript">
                var offset = <?php echo $button_offset; ?>;
                var duration = <?php echo $scroll_duration; ?>;

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
            </script>

            <?php
        }


        public function add_markup() {
            $is_enable_btn = self::get_settings( 'is_enable_btn' );

            if ( $is_enable_btn != 'on' ) {
                return;
            }

            $size               = absint( self::get_settings( 'progress_size' ) );
            $view_box           = '-' . $size / 2 . ' -' . $size / 2 . ' ' . ( 100 + $size ) . ' ' . ( 100 + $size );
            $button_position    = self::get_settings( 'button_position' );
            $is_enable_progress = self::get_settings( 'is_enable_progress' );
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
function wpx_scroll_top() {
    return WP_Scroll_Top::instance();
}

// Kick Off
wpx_scroll_top();
