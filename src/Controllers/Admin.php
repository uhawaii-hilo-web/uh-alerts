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
        $this->setSections();
        $this->setFields();

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
                'menu_slug' => 'uh_alerts_plugin',
                'callback' => array($this, 'index'),
                'icon_url' => "{$this->plugin_url}/assets/uh-seal-partial-simplified.svg",
                'position' => 110,
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
                'page_title' => 'Widget Settings',
                'menu_title' => 'Widget',
                'capability' => 'manage_options',
                'menu_slug' => 'uh_alerts_widget',
                'callback' => function () { echo '<h1>UH Alerts Widget Settings</h1><p>Under active development.</p>'; },
            ),
        );
    }

    public function index()
    {
        require_once $this->plugin_path.'/templates/admin.php';
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'uh_alerts_options_group',
                'option_name' => 'uh_alerts_campus_code',
                'callback' => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_options_group',
                'option_name' => 'uh_alerts_refresh_rate',
                'callback' => array($this, 'optionsGroup'),
            ),
            array(
                'option_group' => 'uh_alerts_options_group',
                'option_name' => 'uh_alerts_style',
                'callback' => array($this, 'optionsGroup'),
            ),
        );
        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'uh_alerts_admin_index',
                'title' => 'Settings',
                'callback' => array($this, 'uhAlertsAdminSection'),
                'page' => 'uh_alerts_plugin',
            )
        );
        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array(
            array(
                'id' => 'uh_alerts_campus_code',
                'title' => 'Campus',
                'callback' => array($this, 'uhAlertsCampus'),
                'page' => 'uh_alerts_plugin',
                'section' => 'uh_alerts_admin_index',
                'args' => array(
                    'label_for' => 'campus_code',
                ),
            ),
            array(
                'id' => 'uh_alerts_refresh_rate',
                'title' => 'Refresh Rate',
                'callback' => array($this, 'uhAlertsRefreshRate'),
                'page' => 'uh_alerts_plugin',
                'section' => 'uh_alerts_admin_index',
                'args' => array(
                ),
            ),
            array(
                'id' => 'uh_alerts_style',
                'title' => 'Display Style',
                'callback' => array($this, 'uhAlertsStyle'),
                'page' => 'uh_alerts_plugin',
                'section' => 'uh_alerts_admin_index',
                'args' => array(
                ),
            ),
        );
        $this->settings->setFields($args);
    }

    public function optionsGroup($input)
    {
        return $input;
    }

    public function uhAlertsAdminSection()
    {
        echo 'this is '.__METHOD__;
    }

    public function uhAlertsCampus()
    {
        $value = esc_attr(get_option('campus_code'));
        echo '<input type="text" class="regular-text" name="campus_code" value="'.$value.'" placeholder="uhx" />';
    }

    public function uhAlertsRefreshRate()
    {
        $value = esc_attr(get_option('refresh_rate'));
        echo '<input type="text" class="regular-text" name="refresh_rate" value="'.$value.'" placeholder="number of seconds" />';
    }
}
