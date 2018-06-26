<?php
$campus_code = get_option('campus_code');
$refresh_rate = get_option('refresh_rate');
?>
<div class="wrap">
    <h1>UH Alerts Plugin Settings</h1>

    <?php settings_errors(); ?>

<!--    <p><strong>campus_code</strong>: --><?php //echo json_encode($campus_code); ?><!--</p>-->
<!--    <p><strong>refresh_rate</strong>: --><?php //echo json_encode($refresh_rate); ?><!--</p>-->
<!---->
<!--    <form method="post" action="options.php">-->
<!--        --><?php
//         settings_fields('uhalerts_options_group');
//         do_settings_sections('uhalerts_plugin');
//         submit_button();
//         ?>
<!--    </form>-->
<!---->
<!--    <hr>-->

    <form method="post" action="options.php" novalidate="novalidate">
        <?php settings_fields('uhalerts_options_group'); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">Campus</th>
                <td id="campuses">
                    Loading…
<!--                    <label><input name="campus_code" value="uhh" checked="checked" type="radio"> UH Hilo</label><br>-->
<!--                    <label><input name="campus_code" value="uhm" type="radio"> UH Manoa vicinity (includes Outreach College, JABSOM, EWC, RCUH, UHF)</label><br>-->
<!--                    <label><input name="campus_code" value="hcc" type="radio"> Honolulu CC</label><br>-->
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="refresh_rate">Refresh Rate</label></th>
                <td>
                    <fieldset>
                        <legend><span>How often should the page look for new alerts?</span></legend>
                        <p>
                            <label><input name="refresh_rate" value="0" type="radio"<?php echo $refresh_rate == 0 ? ' checked' : ''; ?>> Never (only check once on page load)</label><br>
                            <label><input name="refresh_rate" value="6" type="radio"<?php echo $refresh_rate == 6 ? ' checked' : ''; ?>> Every 6 seconds (10 times per minute)</label><br>
                            <label><input name="refresh_rate" value="15" type="radio"<?php echo $refresh_rate == 15 ? ' checked' : ''; ?>> Every 15 seconds (4 times per minute)</label><br>
                            <label><input name="refresh_rate" value="30" type="radio"<?php echo $refresh_rate == 30 ? ' checked' : ''; ?>> Every 30 seconds (twice per minute)</label><br>
                            <label><input name="refresh_rate" value="60" type="radio"<?php echo $refresh_rate == 60 ? ' checked' : ''; ?>> Every minute</label><br>
                            <label><input name="refresh_rate" value="300" type="radio"<?php echo $refresh_rate == 300 ? ' checked' : ''; ?>> Every five minutes</label><br>
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
                    o.push('<label><input name="campus_code" value="' + resp[i].code + '" type="radio"' + (resp[i].code == current_campus ? ' checked="checked"' : '') + '> ' + resp[i].campus + '</label><br>');
                }
                campuses.html(o.join('\n'));
            } else {
                campuses.html('Could not load the list campuses from the API. ' + campuses_api);
            }
        });
    })(jQuery, window, document);
</script>
