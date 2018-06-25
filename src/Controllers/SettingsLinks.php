<?php
namespace UHAlerts\Controllers;

/**
 * Class SettingsLinks
 *
 * @package UHAlerts
 */
class SettingsLinks extends Base
{
    public function register()
    {
        add_filter("plugin_action_links_{$this->plugin}", array($this, 'settingsLink'));
    }

    public function settingsLink($links)
    {
        // add custom settings link
        $settings_link = '<a href="admin.php?page=uh_alerts_plugin">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

}
