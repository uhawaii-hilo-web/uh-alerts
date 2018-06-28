<?php
namespace UHAlerts\Base;

/**
 * Class Activate
 *
 * @package UHAlerts
 */
class Activate
{
    public static function activate()
    {
        // register new settings
        if (!get_option('uh_alerts_api_root')) {
            update_option('uh_alerts_api_root', UH_ALERTS_API);
        }
        if (!get_option('uh_alerts_api_regions')) {
            update_option('uh_alerts_api_root', '/campuses/');
        }
        // flush rewrite rules
        flush_rewrite_rules();
    }
}
