<?php
/**
 * Autoload classes for the UH Alerts Plugin within the UHAlerts\ namespace.
 *
 * @package UHAlertsPlugin
 */
if (!function_exists('uh_alerts_autoloader')) {
    function uh_alerts_autoloader($class)
    {
        // only handle UHAlerts\ namespace
        if (strpos($class, 'UHAlerts\\') !== 0) {
            return;
        }
        $file = UH_ALERTS_PATH.'src'.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 9)).'.php';
        if (is_readable($file)) {
            require_once $file;
        } else {
            die("$file is not readable");
            //trigger_error("$file is not readable by ".__FILE__);
        }
    }
    spl_autoload_register('uh_alerts_autoloader');
}
