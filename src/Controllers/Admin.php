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

    protected $pages = array();

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
        //$this->setSections();
        //$this->setFields();

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

    public function index()
    {
        require_once $this->plugin_path.'/templates/admin.php';
    }

    public function apiSettings()
    {
        require_once $this->plugin_path.'/templates/api-settings.php';
    }

    public function setSettings()
    {
        $args = array(
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
/*
    public function setSections()
    {
        $args = array(
            array(
                'id'       => 'uh_alerts_admin_index',
                'title'    => 'Settings',
                'callback' => array($this, 'uhAlertsAdminSection'),
                'page'     => 'uh_alerts_plugin',
            ),
        );
        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array(
            array(
                'id'       => 'uh_alerts_region',
                'title'    => 'Campus',
                'callback' => array($this, 'uhAlertsCampus'),
                'page'     => 'uh_alerts_plugin',
                'section'  => 'uh_alerts_admin_index',
                'args'     => array(
                    'label_for' => 'region',
                ),
            ),
            array(
                'id'       => 'uh_alerts_refresh_rate',
                'title'    => 'Refresh Rate',
                'callback' => array($this, 'uhAlertsRefreshRate'),
                'page'     => 'uh_alerts_plugin',
                'section'  => 'uh_alerts_admin_index',
                'args'     => array(),
            ),
            array(
                'id'       => 'uh_alerts_style',
                'title'    => 'Display Style',
                'callback' => array($this, 'uhAlertsStyle'),
                'page'     => 'uh_alerts_plugin',
                'section'  => 'uh_alerts_admin_index',
                'args'     => array(),
            ),
        );
        $this->settings->setFields($args);
    }
*/
    public function optionsGroup($input)
    {
        return $input;
    }
/*
    public function uhAlertsAdminSection()
    {
        echo 'this is '.__METHOD__;
    }

    public function uhAlertsCampus()
    {
        $value = esc_attr(get_option('uh_alerts_region'));
        echo '<input type="text" class="regular-text" name="region" value="'.$value.'" />';
    }

    public function uhAlertsRefreshRate()
    {
        $value = esc_attr(get_option('uh_alerts_refresh_rate'));
        echo '<input type="text" class="regular-text" name="refresh_rate" value="'.$value.'" />';
    }
    public function uhAlertsStyle()
    {
        $value = esc_attr(get_option('uh_alerts_style'));
        echo '<input type="text" class="regular-text" name="style" value="'.$value.'" />';
    }*/
}
