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
            add_options_page( 'Scroll To Top Settings', 'Scroll To Top', 'manage_options', 'scroll-to-top', array($this, 'plugin_page') );
        }

        function get_settings_sections() {
            $sections = array(
                array(
                    'id'    => 'wpst_general',
                    'title' => __( 'Sctoll To Top Settings', 'wpst' )
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
                'wpst_general' => array(
                    array(
                        'name'  => 'is_enable',
                        'label' => __( 'Enable?', 'wpst' ),
                        'type'  => 'checkbox'
                    ),
                ),

                'wpst_basics' => array(
                    array(
                        'name'              => 'text_val',
                        'label'             => __( 'Text Input', 'wpst' ),
                        'desc'              => __( 'Text input description', 'wpst' ),
                        'placeholder'       => __( 'Text Input placeholder', 'wpst' ),
                        'type'              => 'text',
                        'default'           => 'Title',
                        'sanitize_callback' => 'sanitize_text_field'
                    ),
                    array(
                        'name'              => 'number_input',
                        'label'             => __( 'Number Input', 'wpst' ),
                        'desc'              => __( 'Number field with validation callback `floatval`', 'wpst' ),
                        'placeholder'       => __( '1.99', 'wpst' ),
                        'min'               => 0,
                        'max'               => 100,
                        'step'              => '0.01',
                        'type'              => 'number',
                        'default'           => 'Title',
                        'sanitize_callback' => 'floatval'
                    ),
                    array(
                        'name'        => 'textarea',
                        'label'       => __( 'Textarea Input', 'wpst' ),
                        'desc'        => __( 'Textarea description', 'wpst' ),
                        'placeholder' => __( 'Textarea placeholder', 'wpst' ),
                        'type'        => 'textarea'
                    ),
                    array(
                        'name'        => 'html',
                        'desc'        => __( 'HTML area description. You can use any <strong>bold</strong> or other HTML elements.', 'wpst' ),
                        'type'        => 'html'
                    ),
                    array(
                        'name'  => 'checkbox',
                        'label' => __( 'Checkbox', 'wpst' ),
                        'desc'  => __( 'Checkbox Label', 'wpst' ),
                        'type'  => 'checkbox'
                    ),
                    array(
                        'name'    => 'radio',
                        'label'   => __( 'Radio Button', 'wpst' ),
                        'desc'    => __( 'A radio button', 'wpst' ),
                        'type'    => 'radio',
                        'options' => array(
                            'yes' => 'Yes',
                            'no'  => 'No'
                        )
                    ),
                    array(
                        'name'    => 'selectbox',
                        'label'   => __( 'A Dropdown', 'wpst' ),
                        'desc'    => __( 'Dropdown description', 'wpst' ),
                        'type'    => 'select',
                        'default' => 'no',
                        'options' => array(
                            'yes' => 'Yes',
                            'no'  => 'No'
                        )
                    ),
                    array(
                        'name'    => 'password',
                        'label'   => __( 'Password', 'wpst' ),
                        'desc'    => __( 'Password description', 'wpst' ),
                        'type'    => 'password',
                        'default' => ''
                    ),
                    array(
                        'name'    => 'file',
                        'label'   => __( 'File', 'wpst' ),
                        'desc'    => __( 'File description', 'wpst' ),
                        'type'    => 'file',
                        'default' => '',
                        'options' => array(
                            'button_label' => 'Choose Image'
                        )
                    )
                ),
                'wpst_advanced' => array(
                    array(
                        'name'    => 'color',
                        'label'   => __( 'Color', 'wpst' ),
                        'desc'    => __( 'Color description', 'wpst' ),
                        'type'    => 'color',
                        'default' => ''
                    ),
                    array(
                        'name'    => 'password',
                        'label'   => __( 'Password', 'wpst' ),
                        'desc'    => __( 'Password description', 'wpst' ),
                        'type'    => 'password',
                        'default' => ''
                    ),
                    array(
                        'name'    => 'wysiwyg',
                        'label'   => __( 'Advanced Editor', 'wpst' ),
                        'desc'    => __( 'WP_Editor description', 'wpst' ),
                        'type'    => 'wysiwyg',
                        'default' => ''
                    ),
                    array(
                        'name'    => 'multicheck',
                        'label'   => __( 'Multile checkbox', 'wpst' ),
                        'desc'    => __( 'Multi checkbox description', 'wpst' ),
                        'type'    => 'multicheck',
                        'default' => array('one' => 'one', 'four' => 'four'),
                        'options' => array(
                            'one'   => 'One',
                            'two'   => 'Two',
                            'three' => 'Three',
                            'four'  => 'Four'
                        )
                    ),
                )
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