<?php
/**
 * File triggered on plugin delete.
 *
 * @package  UHAlertsPlugin
 */

// ensure WP environment
defined('WP_UNINSTALL_PLUGIN') or die('WordPress environment missing.');

$options = array(
    'uh_alerts_region',
    'uh_alerts_refresh_rate',
    'uh_alerts_style',

    'uh_alerts_api_root',
    'uh_alerts_api_regions',
    'uh_alerts_api_alerts',
    'uh_alerts_debug',
);

foreach ($options as $option) {
    delete_option($option);
}
