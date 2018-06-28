<?php
$api_root    = get_option('uh_alerts_api_root') ? get_option('uh_alerts_api_root') : UH_ALERTS_API;
$api_regions = get_option('uh_alerts_api_regions') ? get_option('uh_alerts_api_regions') : '/campuses/';
$api_alerts  = get_option('uh_alerts_api_alerts') ? get_option('uh_alerts_api_alerts') : '/alerts/';
$debug       = get_option('uh_alerts_debug') ? get_option('uh_alerts_debug') : '0';
?>
<div class="wrap">
    <h1>UH Alerts API Settings</h1>

    <?php settings_errors(); ?>

    <form method="post" action="options.php" novalidate="novalidate">
        <?php settings_fields('uh_alerts_api_group'); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="uh_alerts_api_root">API Root (URL)</label></th>
                <td>
                    <input name="uh_alerts_api_root" id="uh_alerts_api_root" value="<?php echo esc_attr($api_root); ?>" class="regular-text code" type="url">
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="uh_alerts_api_regions">API Regions Route</label></th>
                <td>
                    <input name="uh_alerts_api_regions" id="uh_alerts_api_regions" value="<?php echo esc_attr($api_regions); ?>" class="regular-text code" type="text">
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="uh_alerts_api_alerts">API Alerts Route</label></th>
                <td>
                    <input name="uh_alerts_api_alerts" id="uh_alerts_api_alerts" value="<?php echo esc_attr($api_alerts); ?>" class="regular-text code" type="text">
                </td>
            </tr>

            <tr>
                <th scope="row">Debugger</th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span>Debugger</span></legend>
                        <label><input type="checkbox" name="uh_alerts_debug" value="1" <?php checked('1', $debug); ?> /> Show debugging info in browser console</label>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
