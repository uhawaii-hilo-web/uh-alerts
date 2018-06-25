<?php
namespace UHAlerts\Base;

/**
 * Class SettingsLinks
 *
 * @package UHAlerts
 */
class SettingsLinks
{
    public function register()
    {

        add_filter("plugin_action_links_".UH_ALERTS_PLUGIN, array($this, 'settingsLink'));
    }

    public function settingsLink($links)
    {
        // add custom settings link
        $settings_link = '<a href="admin.php?page=uh_alerts_plugin">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

}
