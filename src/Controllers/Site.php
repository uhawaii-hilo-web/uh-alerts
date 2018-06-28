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
        $api = get_option('uh_alerts_api_root') ? get_option('uh_alerts_api_root') : UH_ALERTS_API;
        echo '<script>';
        include "{$this->plugin_path}/assets/uh-alerts.min.js";
        echo 'window.UHAlerts.init({'.PHP_EOL;
        echo '  api_url:"'.esc_attr($api).'"'.PHP_EOL;
        echo '  ,region:"'.esc_attr(get_option('uh_alerts_region')).'"'.PHP_EOL;
        echo '  ,refresh_rate:'.esc_attr(get_option('uh_alerts_refresh_rate')).PHP_EOL;
        echo '  ,classes:"'.esc_attr(get_option('uh_alerts_style')).'"'.PHP_EOL;
        echo '  ,debug:!!"'.esc_attr(get_option('uh_alerts_debug')).'"'.PHP_EOL;
        echo '});';
        echo '</script>';
        // wp_enqueue_script('uh-alerts.js', plugins_url('/uh-alerts.js', __FILE__), array(), , true);
        // wp_enqueue_script('uh-alerts.js', "{$this->plugin_url}/assets/uh-alerts.js", array(), , true);
    }

}
