<?php
namespace UHAlerts\Controllers;

/**
 * Base controller class.
 *
 * @package UHAlerts
 */
class Base
{
    /**
     * Full disk path to the base plugin directory.
     *
     * @var string
     */
    protected $plugin_path;

    /**
     * Base URL to the plugin.
     *
     * @var string
     */
    protected $plugin_url;

    /**
     * Base name of the plugin.
     *
     * @var string
     */
    protected $plugin;

    /**
     * Base constructor.
     */
    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url  = plugin_dir_url(dirname(__FILE__, 2));
        $name              = plugin_basename(dirname(__FILE__, 3));
        $this->plugin      = "{$name}/{$name}.php";
    }
}
