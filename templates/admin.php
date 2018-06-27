<?php
$campus_code  = get_option('uh_alerts_campus_code');
$refresh_rate = get_option('uh_alerts_refresh_rate');
$style        = get_option('uh_alerts_style');
?>
<div class="wrap">
    <h1>UH Alerts Plugin Settings</h1>

    <?php settings_errors(); ?>

    <form method="post" action="options.php" novalidate="novalidate">
        <?php settings_fields('uh_alerts_options_group'); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">Campus</th>
                <td id="campuses">
                    Loading campus list from the UH Alerts API…
                </td>
            </tr>

            <tr>
                <th scope="row">Refresh Rate</th>
                <td>
                    <fieldset>
                        <legend><span>How often should the page look for new alerts?</span></legend>
                        <p>
                            <label><input name="uh_alerts_refresh_rate" value="0" type="radio"<?php echo $refresh_rate == 0 ? ' checked' : ''; ?>> Never (only check once on page load)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="6" type="radio"<?php echo $refresh_rate == 6 ? ' checked' : ''; ?>> Every 6 seconds (10 times per minute)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="15" type="radio"<?php echo $refresh_rate == 15 ? ' checked' : ''; ?>> Every 15 seconds (4 times per minute)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="30" type="radio"<?php echo $refresh_rate == 30 ? ' checked' : ''; ?>> Every 30 seconds (twice per minute)</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="60" type="radio"<?php echo $refresh_rate == 60 ? ' checked' : ''; ?>> Every minute</label><br>
                            <label><input name="uh_alerts_refresh_rate" value="300" type="radio"<?php echo $refresh_rate == 300 ? ' checked' : ''; ?>> Every five minutes</label><br>
                        </p>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Style</th>
                <td>
                    <fieldset>
                        <p>
                            <label><input type="radio" name="uh_alerts_style" value="banner"<?php echo $style == 'banner' ? ' checked' : ''; ?>> Top banner<br><?php include UH_ALERTS_PATH.'/assets/top-banner.svg'; ?>
                            </label><br>
                            <label><input type="radio" name="uh_alerts_style" value="toast"<?php echo $style == 'toast' ? ' checked' : ''; ?>> Corner toast<br><?php include UH_ALERTS_PATH.'/assets/toast.svg'; ?>
                            </label><br>
                            <label><input type="radio" name="uh_alerts_style" value="modal"<?php echo $style == 'modal' ? ' checked' : ''; ?>> Modal dialog<br><?php include UH_ALERTS_PATH.'/assets/modal.svg'; ?>
                            </label><br>
                        </p>
                    </fieldset>
                </td>
            </tr>


<!--            <tr>-->
<!--                <th scope="row"><label for="api_root">API Root (URL)</label></th>-->
<!--                <td><input name="api_root" id="api_root" value="https://www.hawaii.edu/alert/test/api/1.0/" class="regular-text code" type="url"></td>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <th scope="row">Membership</th>-->
<!--                <td> <fieldset><legend class="screen-reader-text"><span>Membership</span></legend><label for="users_can_register">-->
<!--                            <input name="users_can_register" id="users_can_register" value="1" type="checkbox">-->
<!--                            Anyone can register</label>-->
<!--                    </fieldset></td>-->
<!--            </tr>-->

            </tbody>
        </table>

        <?php submit_button(); ?>
    </form>
</div>
<script>
    !(function ($, window, document, undefined) {
        var api = 'https://www.hawaii.edu/alert/test/api/1.0';
        var campuses = $('#campuses');
        var campuses_api = api + '/campuses';
        var current_campus = '<?php echo $campus_code; ?>';
        $.getJSON(campuses_api, function (resp) {
            if (resp && resp.length) {
                var o = [];
                for (var i = 0; i < resp.length; i++) {
                    o.push('<label><input name="uh_alerts_campus_code" value="' + resp[i].code + '" type="radio"' + (resp[i].code == current_campus ? ' checked="checked"' : '') + '> ' + resp[i].campus + '</label><br>');
                }
                campuses.html(o.join('\n'));
            } else {
                campuses.html('Could not load the list campuses from the API. ' + campuses_api);
            }
        });
    })(jQuery, window, document);
</script>
