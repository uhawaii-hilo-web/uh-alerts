<?php
namespace UHAlerts\Controllers;

use \UHAlerts\Base\Api\Settings;

/**
 * Add stuff to the admin pages.
 *
 * @package UHAlerts
 */
class Admin extends Base
{
    /**
     * @var \UHAlerts\Base\Api\Settings
     */
    protected $settings;

    /**
     * List of pages.
     *
     * @var array
     */
    protected $pages = array();

    /**
     * List of sub pages.
     *
     * @var array
     */
    protected $sub_pages = array();

    /**
     * Register the controller.
     */
    public function register()
    {
        $this->settings = new Settings();

        $this->setPages();
        $this->setSubPages();

        $this->setSettings();

        $this->settings
            ->addPages($this->pages)
            ->withSubPage('Main Settings')
            ->addSubPages($this->sub_pages)
            ->register();
    }

    /**
     * Add the main menu pages.
     */
    protected function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'UH Alerts Plugin',
                'menu_title' => 'UH Alerts',
                'capability' => 'manage_options',
                'menu_slug'  => 'uh_alerts_plugin',
                'callback'   => array($this, 'index'),
                'icon_url'   => "{$this->plugin_url}/assets/uh-seal-partial-simplified.svg",
                'position'   => 110,
            ),
        );
    }

    /**
     * Add the sub menus pages items.
     */
    protected function setSubPages()
    {
        $this->sub_pages = array(
            array(
                'parent_slug' => 'uh_alerts_plugin',
                'page_title'  => 'API Settings',
                'menu_title'  => 'API Settings',
                'capability'  => 'manage_options',
                'menu_slug'   => 'uh_alerts_api_settings',
                'callback'    => array($this, 'apiSettings'),
            ),
        );
    }

    /**
     * Main admin settings page.
     */
    public function index()
    {
        require_once $this->plugin_path.'/templates/admin.php';
    }

    /**
     * API settings page.
     */
    public function apiSettings()
    {
        require_once $this->plugin_path.'/templates/api-settings.php';
    }

    /**
     * Build the list of settings.
     */
    public function setSettings()
    {
        $args = array(
            // main options group
            array(
                'option_group' => 'uh_alerts_options_group',
                'option_name'  => 'uh_alerts_region',
                'callback'     => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_options_group',
                'option_name'  => 'uh_alerts_refresh_rate',
                'callback'     => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_options_group',
                'option_name'  => 'uh_alerts_style',
                'callback'     => array($this, 'optionsGroup'),
            ),
            // api group
            array(
                'option_group' => 'uh_alerts_api_group',
                'option_name'  => 'uh_alerts_api_root',
                'callback'     => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_api_group',
                'option_name'  => 'uh_alerts_api_regions',
                'callback'     => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_api_group',
                'option_name'  => 'uh_alerts_api_alerts',
                'callback'     => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_api_group',
                'option_name'  => 'uh_alerts_debug',
                'callback'     => array($this, 'optionsGroup'),
            ),
        );
        $this->settings->setSettings($args);
    }

    public function optionsGroup($input)
    {
        return $input;
    }
}
