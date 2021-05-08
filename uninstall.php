<?php

// If uninstall not called from WordPress exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Delete plugin all settings.
delete_option( 'sbttb_settings' );