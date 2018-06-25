<div class="wrap">
    <h1>UH Alerts Plugin Settings</h1>

    <form method="post" action="options.php" novalidate="novalidate">
<!--        <input name="option_page" value="general" type="hidden">-->
<!--        <input name="action" value="update" type="hidden">-->
<!--        <input id="_wpnonce" name="_wpnonce" value="076b59da5c" type="hidden">-->
<!--        <input name="_wp_http_referer" value="/ablog/wp-admin/options-general.php" type="hidden">-->
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
                            <label><input name="refresh_rate" value="0" type="radio"> Never (only check once on page load)</label><br>
                            <label><input name="refresh_rate" value="6" type="radio" checked="checked"> Every 6 seconds (10 times per minute)</label><br>
                            <label><input name="refresh_rate" value="15" type="radio"> Every 15 seconds (4 times per minute)</label><br>
                            <label><input name="refresh_rate" value="30" type="radio"> Every 30 seconds (twice per minute)</label><br>
                            <label><input name="refresh_rate" value="60" type="radio"> Every minute</label><br>
                            <label><input name="refresh_rate" value="300" type="radio"> Every five minutes</label><br>
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

        <p class="submit"><input name="submit" id="submit" class="button button-primary" value="Save Changes" type="submit"></p>
    </form>
<pre>
    x = <?php echo json_encode($x ?? null); ?>
    y = <?php echo json_encode($this->y ?? null); ?>
</pre>
</div>
<script>
    !(function ($, window, document, undefined) {
        var api = 'https://www.hawaii.edu/alert/test/api/1.0';
        var campuses = $('#campuses');
        var campuses_api = api + '/campuses';
        var current_campus = 'uhh';
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
