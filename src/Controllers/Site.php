<?php
namespace UHAlerts\Controllers;

/**
 * Add stuff to the public site pages.
 *
 * @package UHAlerts
 */
class Site extends Base
{
    public function register()
    {
        add_action('wp_head', array($this, 'addCss'));
        add_action('wp_footer', array($this, 'addJavaScript'));
    }

    public function addCss()
    {
        echo '<style>';
        include "{$this->plugin_path}/assets/uh-alerts.css";
        echo '</style>';
        // wp_enqueue_style('uh-alerts.css', plugins_url('/uh-alerts.css', __FILE__));
        // wp_enqueue_style('uh-alerts.css', "{$this->plugin_url}/assets/uh-alerts.css");
    }

    public function addJavaScript()
    {
        echo '<script>window.console && window.console.log("uh-alerts active on '.$_SERVER['REMOTE_ADDR'].'");</script>';
        echo '<script>';
        include "{$this->plugin_path}/assets/uh-alerts.js";
        echo 'window.UHAlerts({'.PHP_EOL;
        echo 'api_url:"'.UH_ALERTS_API.'"'.PHP_EOL;
        echo ',campus:"'.get_option('uh_alerts_campus_code').'"'.PHP_EOL;
        echo ',refresh_rate:'.get_option('uh_alerts_refresh_rate').PHP_EOL;
        echo ',classes:"'.get_option('uh_alerts_style').'"'.PHP_EOL;
        echo ',debug:true'.PHP_EOL;
        echo '});';
        echo '</script>';
        // wp_enqueue_script('uh-alerts.js', plugins_url('/uh-alerts.js', __FILE__), array(), , true);
        // wp_enqueue_script('uh-alerts.js', "{$this->plugin_url}/assets/uh-alerts.js", array(), , true);
    }

}
