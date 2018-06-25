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


// define some plugin settings
define('UH_ALERTS_PATH', plugin_dir_path(__FILE__));
define('UH_ALERTS_ROOT', plugin_dir_url(__FILE__));
define('UH_ALERTS_PLUGIN', plugin_basename(__FILE__));

// ensure the autoloader exists
if (is_readable(UH_ALERTS_PATH.'/autoloader.php')) {
    // register the plugin class autoloader
    require_once UH_ALERTS_PATH.'/autoloader.php';


    // register the activation and deactivation hooks
    function activateUHAlertsPlugin()
    {
        UHAlerts\Base\Activate::activate();
    }

    register_activation_hook(__FILE__, 'activateUHAlertsPlugin');
    function deactivateUHAlertsPlugin()
    {
        UHAlerts\Base\Deactivate::activate();
    }

    register_deactivation_hook(__FILE__, 'deactivateUHAlertsPlugin');


    // register the rest of the plugin functionality
    if (class_exists('UHAlerts\\Init')) {
        UHAlerts\Init::registerServices();
    }
}

//
// class UHAlertsPlugin
// {
//     public $plugin;
//
//     public function __construct()
//     {
//         $this->plugin = plugin_basename(__FILE__);
//     }
//
//     public function register()
//     {
//         add_action('wp_head', array($this, 'addCss'));
//         add_action('wp_footer', array($this, 'addJavaScript'));
//         // add_action('wp_enqueue_scripts', array($this, 'enqueue'));
//         add_action('admin_menu', array($this, 'add_admin_pages'));
//         add_filter("plugin_action_links_{$this->plugin}", array($this, 'settings_link'));
//     }
//
//     public function settings_link($links)
//     {
//         // add custom settings link
//         $settings_link = '<a href="admin.php?page=uh_alerts_plugin">Settings</a>';
//         array_push($links, $settings_link);
//         return $links;
//     }
//
//
//     public function activate()
//     {
//         // generate a custom post type
//         $this->custom_post_type();
//         // register new settings
//         register_setting()
//         // flush rewrite rules
//         flush_rewrite_rules();
//     }
//
//     public function deactivate()
//     {
//         // flush rewrite rules
//         flush_rewrite_rules();
//     }
//
//     private function custom_post_type()
//     {
//         //register_post_type('book', array('public' => true, 'label' => 'book'));
//     }
//
//     // private function enqueue()
//     // {
//     //     // enqueue all our assets
//     //     $this->addCss();
//     //     $this->addJavaScript();
//     // }
//
//     private function addCss()
//     {
//         echo '<style>';
//         include __DIR__.'/uh-alerts.css';
//         echo '</style>';
//         // wp_enqueue_style('uh-alerts.css', plugins_url('/uh-alerts.css', __FILE__));
//     }
//
//     private function addJavaScript()
//     {
//         echo '<script>window.console && window.console.log("uh-alerts active on '.$_SERVER['REMOTE_ADDR'].'");</script>';
//         echo '<script>';
//         include __DIR__.'/uh-alerts.js';
//         echo 'window.UHAlerts({campus:"uhm",debug:true});';
//         echo '</script>';
//         // wp_enqueue_script('uh-alerts.js', plugins_url('/uh-alerts.js', __FILE__), array(), , true);
//     }
// }
//
// if (class_exists('UHAlertsPlugin')) {
//     $uhAlertsPlugin = new UHAlertsPlugin();
//     $uhAlertsPlugin->register();
//     register_activation_hook(__FILE__, array($uhAlertsPlugin, 'activate'));
//     register_deactivation_hook(__FILE__, array($uhAlertsPlugin, 'deactivate'));
// }
