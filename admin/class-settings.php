<?php

if ( !class_exists('WPST_Settings' ) ):
    class WPST_Settings {

        private $settings_api;

        function __construct() {
            $this->settings_api = new Settings_API();

            add_action( 'admin_init', array($this, 'admin_init') );
            add_action( 'admin_menu', array($this, 'admin_menu') );
        }

        function admin_init() {

            // Set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );

            // Initialize settings
            $this->settings_api->admin_init();
        }

        function admin_menu() {
            add_options_page( 'Scroll To Top Settings', 'Scroll To Top', 'manage_options', 'wp-back-to-top', array($this, 'plugin_page') );
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'wpst_settings',
                    'title' => __( 'Scroll To Top Settings', 'wpst' )
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
                        'name'  => 'is_enable',
                        'label' => esc_html__( 'Enable?', 'wpst' ),
                        'desc'        => __( 'Enable scroll top?', 'wpst' ),
                        'type'  => 'checkbox',
                        'default'  => 'on'
                    ),

                    array(
                        'name'    => 'icon_type',
                        'label'   => __( 'Icon Type', 'wpst' ),
                        'type'    => 'radio',
                        'default' => 'arrow-up-light',
                        'options' => array(
                            'arrow-up-light'   => '<i class="icon-arrow-up-light"></i>',
                            'arrow-up-bold'   => '<i class="icon-arrow-up-bold"></i>',
                            'angle-double-up-black'   => '<i class="icon-arrow-up-black"></i>',
                            'angle-up'   => '<i class="icon-angle-up"></i>',
                            'angle-double-up'   => '<i class="icon-angle-double-up"></i>',
                            'finger-up'   => '<i class="icon-finger-up"></i>',
                            'finger-up-o'   => '<i class="icon-finger-up-o"></i>',
                        )
                    ),

                    array(
                        'name' => 'button_position',
                        'label' => esc_html__( 'Button Position', 'wpst' ),
                        'type' => 'select',
                        'options' => array(
                            'left-side' => esc_html__( 'Bottom Left Side', 'wpst' ),
                            'right-side' => esc_html__( 'Bottom Right Side', 'wpst'),
                        ),
                        'default' => 'right-side',
                    ),

                    array(
                        'name'              => 'button_margin',
                        'label'             => __( 'Button Margin', 'wpst' ),
                        'desc'              => __( 'in px', 'wpst' ),
                        'step'              => '1',
                        'type'              => 'number',
                        'default'           => '50'
                    ),

                    array(
                        'name'              => 'button_offset',
                        'label'             => __( 'Button Offset', 'wpst' ),
                        'desc'              => __( 'in px', 'wpst' ),
                        'step'              => '1',
                        'type'              => 'number',
                        'default'           => '50'
                    ),

                    array(
                        'name'              => 'scroll_duration',
                        'label'             => __( 'Scroll Duration', 'wpst' ),
                        'desc'              => __( 'in ms', 'wpst' ),
                        'min'               => 100,
                        'max'               => 1000,
                        'step'              => '100',
                        'type'              => 'number',
                        'default'           => '500'
                    ),

                    array(
                        'name'              => 'button_duration',
                        'label'             => __( 'Button Fade Duration', 'wpst' ),
                        'desc'              => __( 'in ms', 'wpst' ),
                        'min'               => 100,
                        'max'               => 1000,
                        'step'              => '100',
                        'type'              => 'number',
                        'default'           => '200'
                    ),

                    array(
                        'name'              => 'button_size',
                        'label'             => __( 'Button Size', 'wpst' ),
                        'desc'              => __( 'in px', 'wpst' ),
                        'step'              => '1',
                        'type'              => 'number',
                        'default'           => '46'
                    ),

                    array(
                        'name'              => 'icon_size',
                        'label'             => __( 'Icon Size', 'wpst' ),
                        'desc'              => __( 'in px', 'wpst' ),
                        'step'              => '1',
                        'type'              => 'number',
                        'default'           => '24'
                    ),

                    array(
                        'name'              => 'progress_size',
                        'label'             => __( 'Progress Size', 'wpst' ),
                        'desc'              => __( 'in px', 'wpst' ),
                        'step'              => '1',
                        'min'               => 1,
                        'max'               => 10,
                        'type'              => 'number',
                        'default'           => '4'
                    ),

                    array(
                        'name'    => 'button_color',
                        'label'   => __( 'Button Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

                    array(
                        'name'    => 'icon_color',
                        'label'   => __( 'Icon Color', 'wpst' ),
                        'type'    => 'color',
                        'default' => '#1f2029'
                    ),

                    array(
                        'name'    => 'progress_color',
                        'label'   => __( 'Progress Color', 'wpst' ),
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
            $pages = get_pages();
            $pages_options = array();
            if ( $pages ) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }
endif;

new WPST_Settings();