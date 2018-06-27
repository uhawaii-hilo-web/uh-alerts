<?php
$region       = get_option('uh_alerts_region');
$refresh_rate = get_option('uh_alerts_refresh_rate');
$style        = get_option('uh_alerts_style');
$debug        = get_option('uh_alerts_debug');
?>
<div class="wrap">
    <h1>UH Alerts Plugin Settings</h1>

    <?php settings_errors(); ?>

    <form method="post" action="options.php" novalidate="novalidate">
        <?php settings_fields('uh_alerts_options_group'); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">Region</th>
                <td id="regions">
                    Loading region list from the UH Alerts API…
                </td>
            </tr>

            <tr>
                <th scope="row">Refresh Rate</th>
                <td>
                    <fieldset>
                        <legend><span>How often should the page look for new alerts?</span></legend>
                        <p>
                            <label><input name="uh_alerts_refresh_rate" value="0" type="radio"<?php checked('0', $refresh_rate); ?>> Never (only check once on page load)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="6" type="radio"<?php checked('6', $refresh_rate); ?>> Every 6 seconds (10 times per minute)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="15" type="radio"<?php checked('15', $refresh_rate); ?>> Every 15 seconds (4 times per minute)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="30" type="radio"<?php checked('30', $refresh_rate); ?>> Every 30 seconds (twice per minute)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="60" type="radio"<?php checked('60', $refresh_rate); ?>> Every minute</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="300" type="radio"<?php checked('300', $refresh_rate); ?>> Every five minutes</label><br>
                        </p>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Style</th>
                <td>
                    <fieldset>
                        <legend><span>Due to the variety in site templates, not all styles will look as intended in all templates.</span></legend>
                        <p>
                            <label><input type="radio" name="uh_alerts_style" value="banner"<?php checked('banner', $style); ?>> Banner (top)<br><?php include UH_ALERTS_PATH.'/assets/banner.svg'; ?><br>
                            <label><input type="radio" name="uh_alerts_style" value="window-shade"<?php checked('window-shade', $style); ?>> Window shade (overlay top)<br><?php include UH_ALERTS_PATH.'/assets/window-shade.svg'; ?>
                            </label><br>
                            <label><input type="radio" name="uh_alerts_style" value="toast"<?php checked('toast', $style); ?>> Toast (overlay bottom right corner)<br><?php include UH_ALERTS_PATH.'/assets/toast.svg'; ?>
                            </label><br>
                            <label><input type="radio" name="uh_alerts_style" value="modal"<?php checked('modal', $style); ?>> Modal (overlay front and center)<br><?php include UH_ALERTS_PATH.'/assets/modal.svg'; ?>
                            </label><br>
                        </p>
                    </fieldset>
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


<!--            <tr>
                <th scope="row"><label for="uh_alerts_api_root">API Root (URL)</label></th>
                <td><input name="uh_alerts_api_root" id="uh_alerts_api_root" value="https://www.hawaii.edu/alert/test/api/1.0" class="regular-text code" type="url"></td>
            </tr> -->

<!--            <tr>
                <th scope="row"><label for="uh_alerts_api_regions">API Regions Route</label></th>
                <td><input name="uh_alerts_api_regions" id="uh_alerts_api_regions" value="/campuses" class="regular-text code" type="text"></td>
            </tr> -->

<!--            <tr>
                <th scope="row"><label for="uh_alerts_api_alerts">API Alerts Route</label></th>
                <td><input name="uh_alerts_api_alerts" id="uh_alerts_api_alerts" value="/alerts/" class="regular-text code" type="text"></td>
            </tr> -->

            </tbody>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
<script>
    !(function ($, window, document, undefined) {
        var api = '<?php echo UH_ALERTS_API; ?>';
        var regions = $('#regions');
        var regions_api = api + '/campuses';
        var current_region = '<?php echo $region; ?>';
        $.getJSON(regions_api, function (resp) {
            if (resp && resp.length) {
                var o = [];
                for (var i = 0; i < resp.length; i++) {
                    o.push('<label><input name="uh_alerts_region" value="' + resp[i].code + '" type="radio"' + (resp[i].code == current_region ? ' checked="checked"' : '') + '> ' + resp[i].campus + '</label><br>');
                }
                regions.html(o.join('\n'));
            } else {
                regions.html('Could not load the list regions from the API. ' + regions_api);
            }
        });
    })(jQuery, window, document);
</script>
