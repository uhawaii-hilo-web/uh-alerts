<?php
namespace UHAlerts\Base;

/**
 * Class Deactivate
 *
 * @package UHAlerts
 */
class Deactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}
