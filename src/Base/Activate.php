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
        // generate a custom post type
        // $this->custom_post_type();
        // register new settings
        // register_setting();
        // flush rewrite rules
        flush_rewrite_rules();
    }
}
