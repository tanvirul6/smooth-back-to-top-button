<?php

if ( ! class_exists( 'WPST_Settings' ) ):
    class WPST_Settings {

        private $settings_api;

        function __construct() {
            $this->settings_api = new Settings_API();

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
            add_options_page( 'Back To Top Button', 'Back To Top Button', 'manage_options', 'wp-back-to-top', array(
                $this,
                'plugin_page'
            ) );
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'wpst_settings',
                    'title' => __( 'Back To Top Button Settings', 'wpst' )
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
                'wpst_settings' => array(
                    array(
                        'name'    => 'is_enable_btn',
                        'label'   => esc_html__( 'Enable Button', 'wpst' ),
                        'desc'    => __( 'Enable back to top button?', 'wpst' ),
                        'type'    => 'checkbox',
                        'default' => 'on'
                    ),

                    array(
                        'name'    => 'is_enable_progress',
                        'label'   => esc_html__( 'Enable Scroll Progress', 'wpst' ),
                        'desc'    => __( 'Enable scroll progress indicator?', 'wpst' ),
                        'type'    => 'checkbox',
                        'default' => 'on'
                    ),

                    array(
                        'name'    => 'icon_type',
                        'label'   => __( 'Icon Type', 'wpst' ),
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
                        'label'   => esc_html__( 'Button Position', 'wpst' ),
                        'type'    => 'select',
                        'options' => array(
                            'left-side'  => esc_html__( 'Bottom Left Side', 'wpst' ),
                            'right-side' => esc_html__( 'Bottom Right Side', 'wpst' ),
                        ),
                        'default' => 'right-side',
                    ),

                    array(
                        'name'    => 'button_margin',
                        'label'   => esc_html__( 'Button Margin', 'wpst' ),
                        'desc'    => esc_html__( 'in px', 'wpst' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '50'
                    ),

                    array(
                        'name'    => 'button_offset',
                        'label'   => esc_html__( 'Button Offset', 'wpst' ),
                        'desc'    => esc_html__( 'in px', 'wpst' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '50'
                    ),

                    array(
                        'name'    => 'scroll_duration',
                        'label'   => esc_html__( 'Scroll Duration', 'wpst' ),
                        'desc'    => esc_html__( 'in ms', 'wpst' ),
                        'min'     => 100,
                        'max'     => 1000,
                        'step'    => '100',
                        'type'    => 'number',
                        'default' => '500'
                    ),

                    array(
                        'name'    => 'button_size',
                        'label'   => esc_html__( 'Button Size', 'wpst' ),
                        'desc'    => esc_html__( 'in px', 'wpst' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '46'
                    ),

                    array(
                        'name'    => 'border_size',
                        'label'   => esc_html__( 'Button border Size', 'wpst' ),
                        'desc'    => esc_html__( 'in px', 'wpst' ),
                        'min'     => 1,
                        'max'     => 10,
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '2'
                    ),

                    array(
                        'name'    => 'icon_size',
                        'label'   => esc_html__( 'Icon Size', 'wpst' ),
                        'desc'    => esc_html__( 'in px', 'wpst' ),
                        'step'    => '1',
                        'type'    => 'number',
                        'default' => '24'
                    ),

                    array(
                        'name'    => 'progress_size',
                        'label'   => esc_html__( 'Progress Size', 'wpst' ),
                        'desc'    => esc_html__( 'in px', 'wpst' ),
                        'step'    => '1',
                        'min'     => 1,
                        'max'     => 10,
                        'type'    => 'number',
                        'default' => '4'
                    ),

                    array(
                        'name'    => 'button_color',
                        'label'   => esc_html__( 'Button Background Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#0000'
                    ),

                    array(
                        'name'    => 'border_color',
                        'label'   => esc_html__( 'Button Border Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#cccccc'
                    ),

                    array(
                        'name'    => 'icon_color',
                        'label'   => esc_html__( 'Icon Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

                    array(
                        'name'    => 'progress_color',
                        'label'   => esc_html__( 'Progress Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

                    array(
                        'name'    => 'hover_color',
                        'label'   => esc_html__( 'Button Hover Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#cccccc'
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

new WPST_Settings();