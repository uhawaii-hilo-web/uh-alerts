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
/*
Copyright 2018, University of Hawaiʻi

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
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
