<?php
/**
 * @package  UHAlertsPlugin
 */
/*
Plugin Name: UH Alerts
Plugin URI: https://hilo.hawaii.edu/oct/web/wp/uh-alerts/
description: Show any active University of Hawaiʻi alerts.
Version: 1.0-TEST
Author: Sunny Walker
Author URI: https://hilo.hawaii.edu/oct/web/
License: GPL2
*/

//register_activation_hook( $file, $function );

//register_deactivation_hook( $file, $function );

//register_uninstall_hook( $file, $callback );

function add_uh_alerts_css()
{
    echo '<style>';
    include __DIR__.'/uh-alerts.css';
    echo '</style>';
}

function add_uh_alerts_js()
{
    echo '<script>window.console && window.console.log("uh-alerts active on '.$_SERVER['REMOTE_ADDR'].'");</script>';
    echo '<script>';
    include __DIR__.'/uh-alerts.js';
    echo 'window.UHAlerts({campus:"uhm"});';
    echo '</script>';
}

add_action('wp_head', 'add_uh_alerts_css');
add_action('wp_footer', 'add_uh_alerts_js');
