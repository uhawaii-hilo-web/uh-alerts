<?php
namespace UHAlerts;

/**
 * Main plugin initializer.
 *
 * @package UHAlerts
 */
final class Init
{
    /**
     * Get all the services registered.
     *
     * @return array
     */
    public static function getServices()
    {
        return array(
            Controllers\Site::class,
            Controllers\Admin::class,
            Controllers\SettingsLinks::class,
        );
    }

    /**
     * Call each service's register method.
     */
    public static function registerServices()
    {
        foreach (self::getServices() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize a class.
     *
     * @param string $class Class name to instantiate.
     * @return mixed
     */
    private static function instantiate($class)
    {
        return new $class();
    }

}
