<?php
namespace UHAlerts\Controllers;

/**
 * Add stuff to the admin pages.
 *
 * @package UHAlerts
 */
class Admin extends Base
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addAdminPages'));
    }

    public function addAdminPages()
    {
        add_menu_page('UH Alerts Plugin', 'UH Alerts', 'manage_options', 'uh_alerts_plugin', array($this, 'index'), "{$this->plugin_url}/assets/uh-seal-partial-simplified.svg", 110);
    }

    public function index()
    {
        // require template
        // $x = 1;
        // $this->y = 2;
        require_once "{$this->plugin_path}/templates/admin.php";
    }

}
