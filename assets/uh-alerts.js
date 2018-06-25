!(function (window, document, undefined) {
    "use strict";
    window.UHAlerts = function (options) {
        var settings = {
                alert_info_url: "https://www.hawaii.edu/alert/test/api/1.0/alerts/",
                api_url: "https://www.hawaii.edu/alert/test/api/1.0/alerts/",
                campus: "uhh",
                element_id: "uh-alerts",
                update_frequency: 5000,
                debug: false
            },
            alerts_cache,
            bucket;

        function relativeTime(dt) {
            var dp=dt.split(' ')[0].split('-').map(function(v){return parseInt(v,10)}),tp=dt.split(' ')[1].split(":").map(function(v){return parseInt(v,10)}),d=new Date(dp[0],dp[1]-1,dp[2],tp[0],tp[1],tp[2]),a,e=Math.round((+new Date-d)/1e3),t=60,r=60*t,n=24*r;
            return 30>e?a="moments ago":t>e?a=e+" seconds ago":2*t>e?a="a minute ago":r>e?a=Math.floor(e/t)+" minutes ago":1===Math.floor(e/r)?a="1 hour ago.":n>e?a=Math.floor(e/r)+" hours ago":2*n>e?a="yesterday":a=Math.floor(e/n)+" days ago",a}

        function isOpen() {
            return bucket.getAttribute('class') === 'uh-alerts-active';
        }

        function show() {
            settings.debug && window.console.log('UH Alerts: show()');
            !isOpen() && bucket.setAttribute('class', 'uh-alerts-active');
        }

        function hide() {
            settings.debug && window.console.log('UH Alerts: hide()');
            isOpen() && bucket.setAttribute('class', '');
        }

        function getAlerts() {
            var r = new XMLHttpRequest(),
                data;
            // settings.debug && window.console.log('UH Alerts: getAlerts()');
            r.open('GET', settings.api_url + settings.campus, true);
            r.onreadystatechange = function () {
                var o = '';
                if (r.readyState === 4) {
                    if (r.status === 200) {
                        if (alerts_cache !== r.response) {
                            // only update if there is a change
                            data = JSON.parse(r.response);
                            if (data && data.length) {
                                settings.debug && window.console.log('UH Alerts: got ' + data.length + ' alerts');
                                o = '<button class="uh-alerts-close">Hide</button>';
                                data.forEach(function (i, v) {
                                    o += '<p><a href="' + settings.alert_info_url + i.id +'">' + i.title + '</a>: ' + i.sms_message + ' <span class="uh-alerts-updated">(Updated ' + relativeTime(i.updated_at || i.created_at) + ')</span></p>';
                                });
                                bucket.innerHTML = o;
                                show();
                            } else {
                                settings.debug && window.console.log('UH Alerts: no alerts');
                                bucket.innerHTML = '';
                                hide();
                            }
                            alerts_cache = r.response;
                        } else if (settings.debug) {
                            window.console.log('UH Alerts: getAlerts().data same as cache');
                        }
                    }
                }
            };
            r.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
            r.send();
        }

        function init() {
            settings.debug && window.console.log('UH Alerts: init()');
            for (var attr in options) {
                settings[attr] = options[attr];
            }
            bucket = document.getElementById(settings.element_id);
            if (!bucket) {
                settings.debug && window.console.log('UH Alerts: creating bucket');
                bucket = document.createElement('div');
                bucket.id = settings.element_id;
                var body = document.getElementsByTagName('body').item(0);
                settings.debug && window.console.log('UH Alerts: adding', bucket, 'to', body);
                body && body.insertBefore(bucket, body.firstElementChild);
            }
            getAlerts();
            setInterval(getAlerts, settings.update_frequency);
            bucket.addEventListener('click', function (ev) {
                if (ev.target && ev.target.className === 'uh-alerts-close') {
                    settings.debug && window.console.log('UH Alerts: hide button tapped');
                    ev.preventDefault();
                    ev.stopPropagation();
                    hide();
                }
            });
        }

        if (window.XMLHttpRequest && window.addEventListener) {
            init();
        } else if (settings.debug) {
            window.console.log('UH Alerts: Missing support for XHR or addEventListener');
        }
    };
})(window, document);
