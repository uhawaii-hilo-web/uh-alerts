<?php
namespace UHAlerts\Pages;

/**
 * Add stuff to the admin pages.
 *
 * @package UHAlerts
 */
class Admin
{
    public function register()
    {
        add_action('admin_menu', array($this, 'addAdminPages'));
    }

    public function addAdminPages()
    {
        add_menu_page('UH Alerts Plugin', 'UH Alerts', 'manage_options', 'uh_alerts_plugin', array($this, 'index'), UH_ALERTS_ROOT.'/assets/uh-seal-partial-simplified.svg', 110);
    }

    public function index()
    {
        // require template
        // $x = 1;
        // $this->y = 2;
        require_once UH_ALERTS_PATH.'/templates/admin.php';
    }

}
