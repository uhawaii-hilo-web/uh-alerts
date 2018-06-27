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

// ensure WP environment
defined('ABSPATH') or die('WordPress environment missing.');


// define plugin environment path
define('UH_ALERTS_PATH', plugin_dir_path(__FILE__));
define('UH_ALERTS_API', 'https://www.hawaii.edu/alert/test/api/1.0');


// ensure the autoloader exists
if (is_readable(UH_ALERTS_PATH.'/autoloader.php')) {
    // register the plugin class autoloader
    require_once UH_ALERTS_PATH.'/autoloader.php';


    // register the activation and deactivation hooks
    register_activation_hook(__FILE__, function () {
        UHAlerts\Base\Activate::activate();
    });

    register_deactivation_hook(__FILE__, function () {
        UHAlerts\Base\Deactivate::deactivate();
    });


    // register the rest of the plugin functionality
    if (class_exists('UHAlerts\\Init')) {
        UHAlerts\Init::registerServices();
    }
}
