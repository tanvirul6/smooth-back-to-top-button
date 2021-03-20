<?php

if ( ! class_exists( 'SBTTB_Settings' ) ):
    class SBTTB_Settings {

        private $settings_api;

        function __construct() {

            $this->settings_api = new SBTTB_Settings_API();

            add_action( 'admin_init', array( $this, 'admin_init' ) );
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        }

        function admin_init() {

            // Set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );

            // Initialize settings
            $this->settings_api->admin_init();

        }

        function admin_menu() {

            add_options_page( 'Back To Top Button', 'Back To Top Button', 'manage_options', 'smooth-back-to-top', array(
                $this,
                'plugin_page'
            ) );

        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'sbttb_settings',
                    'title' => esc_html__( 'Back To Top Button Settings', 'smooth-back-to-top-button' )
                )
            );

            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields() {
            $settings_fields = array(
                'sbttb_settings' => array(
                    array(
                        'name'    => 'is_enable_btn',
                        'label'   => esc_html__( 'Enable Button', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'Enable back to top button?', 'smooth-back-to-top-button' ),
                        'type'    => 'checkbox',
                        'default' => 'on'
                    ),

                    array(
                        'name'    => 'is_enable_progress',
                        'label'   => esc_html__( 'Enable Scroll Progress', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'Enable scroll progress indicator?', 'smooth-back-to-top-button' ),
                        'type'    => 'checkbox',
                        'default' => 'on'
                    ),

                    array(
                        'name'    => 'is_enable_async',
                        'label'   => esc_html__( 'JavaScript Async', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'To increase site performance, keep it enabled, if there has no conflicts.', 'smooth-back-to-top-button' ),
                        'type'    => 'checkbox',
                        'default' => 'off'
                    ),

                    array(
                        'name'    => 'icon_type',
                        'label'   => esc_html__( 'Icon Type', 'smooth-back-to-top-button' ),
                        'type'    => 'radio',
                        'default' => 'arrow-up-light',
                        'options' => array(
                            'arrow-up-light'        => '<i class="icon-arrow-up-light"></i>',
                            'arrow-up-bold'         => '<i class="icon-arrow-up-bold"></i>',
                            'angle-double-up-black' => '<i class="icon-arrow-up-black"></i>',
                            'angle-up'              => '<i class="icon-angle-up"></i>',
                            'angle-double-up'       => '<i class="icon-angle-double-up"></i>',
                            'finger-up'             => '<i class="icon-finger-up"></i>',
                            'finger-up-o'           => '<i class="icon-finger-up-o"></i>',
                        )
                    ),

                    array(
                        'name'    => 'button_position',
                        'label'   => esc_html__( 'Button Position', 'smooth-back-to-top-button' ),
                        'type'    => 'select',
                        'options' => array(
                            'left-side'  => esc_html__( 'Bottom Left Side', 'smooth-back-to-top-button' ),
                            'right-side' => esc_html__( 'Bottom Right Side', 'smooth-back-to-top-button' ),
                        ),
                        'default' => 'right-side',
                    ),

                    array(
                        'name'    => 'button_margin',
                        'label'   => esc_html__( 'Button Margin', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'in pixels.', 'smooth-back-to-top-button' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '50'
                    ),

                    array(
                        'name'    => 'button_offset',
                        'label'   => esc_html__( 'Button Offset', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'Distance from top in pixels before showing the button.', 'smooth-back-to-top-button' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '50'
                    ),

                    array(
                        'name'    => 'scroll_duration',
                        'label'   => esc_html__( 'Scroll Duration', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'in milliseconds.', 'smooth-back-to-top-button' ),
                        'min'     => 100,
                        'max'     => 1000,
                        'step'    => '100',
                        'type'    => 'number',
                        'default' => '500'
                    ),

                    array(
                        'name'    => 'button_size',
                        'label'   => esc_html__( 'Button Size', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'in pixels.', 'smooth-back-to-top-button' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '46'
                    ),

                    array(
                        'name'    => 'border_size',
                        'label'   => esc_html__( 'Button Border Size', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'in pixels.', 'smooth-back-to-top-button' ),
                        'min'     => 0,
                        'max'     => 10,
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '2'
                    ),

                    array(
                        'name'    => 'icon_size',
                        'label'   => esc_html__( 'Icon Size', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'in pixels.', 'smooth-back-to-top-button' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '24'
                    ),

                    array(
                        'name'    => 'progress_size',
                        'label'   => esc_html__( 'Progress Size', 'smooth-back-to-top-button' ),
                        'desc'    => esc_html__( 'in pixels.', 'smooth-back-to-top-button' ),
                        'step'    => '1',
                        'min'     => 1,
                        'max'     => 10,
                        'type'    => 'number',
                        'default' => '4'
                    ),

                    array(
                        'name'    => 'button_color',
                        'label'   => esc_html__( 'Button Background Color', 'smooth-back-to-top-button' ),
                        'type'    => 'color',
                        'default' => '#ffffff'
                    ),

                    array(
                        'name'    => 'border_color',
                        'label'   => esc_html__( 'Button Border Color', 'smooth-back-to-top-button' ),
                        'type'    => 'color',
                        'default' => '#cccccc'
                    ),

                    array(
                        'name'    => 'icon_color',
                        'label'   => esc_html__( 'Icon Color', 'smooth-back-to-top-button' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

                    array(
                        'name'    => 'progress_color',
                        'label'   => esc_html__( 'Progress Color', 'smooth-back-to-top-button' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

                    array(
                        'name'    => 'hover_color',
                        'label'   => esc_html__( 'Button Hover Color', 'smooth-back-to-top-button' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

	                array(
		                'name'    => 'hide_on_mobile',
		                'label'   => esc_html__( 'Hide on Mobile Layout', 'smooth-back-to-top-button' ),
		                'desc'    => esc_html__( 'Maximum width is 767px.', 'smooth-back-to-top-button' ),
		                'type'    => 'checkbox',
		                'default' => 'off'
	                ),

	                array(
		                'name'    => 'hide_on_tablet',
		                'label'   => esc_html__( 'Hide on Tablet Layout', 'smooth-back-to-top-button' ),
		                'desc'    => esc_html__( 'Minimum width is 768px and maximum width is 991px.', 'smooth-back-to-top-button' ),
		                'type'    => 'checkbox',
		                'default' => 'off'
	                ),

	                array(
		                'name'    => 'sbttb_custom_css',
		                'label'   => esc_html__( 'Custom CSS', 'smooth-back-to-top-button' ),
		                'type'    => 'textarea',
	                ),

                ),

            );

            return $settings_fields;
        }

        function plugin_page() {
            echo '<div class="wrap">';

            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();

            echo '</div>';
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages() {
            $pages         = get_pages();
            $pages_options = array();
            if ( $pages ) {
                foreach ( $pages as $page ) {
                    $pages_options[ $page->ID ] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
endif;

new sbttb_settings();