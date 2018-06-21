!(function (window, document, undefined) {
    "use strict";
    window.UHAlerts = function (options) {
        var settings = {
                alert_info_url: "https://www.hawaii.edu/alert/test/api/1.0/alerts/",
                api_url: "https://www.hawaii.edu/alert/test/api/1.0/alerts/",
                campus: "uhh",
                element_id: "uh-alerts",
                update_frequency: 5000
            },
            alerts_cache,
            bucket;

        function relativeTime(o) {
            var dp = o.split(' ')[0].split('-').map(function (v) { return parseInt(v, 10); });
            var tp = o.split(' ')[1].split(":").map(function (v) { return parseInt(v, 10); });
            var d = new Date(dp[0], dp[1] - 1, dp[2], tp[0], tp[1], tp[2]);
            var a,
                e = Math.round((+new Date-d)/1e3),
                t=60,
                r=60*t,
                n=24*r;
            console.log(e)
            return 30>e?a="moments ago":t>e?a=e+" seconds ago":2*t>e?a="a minute ago":r>e?a=Math.floor(e/t)+" minutes ago":1===Math.floor(e/r)?a="1 hour ago.":n>e?a=Math.floor(e/r)+" hours ago":2*n>e?a="yesterday":a=Math.floor(e/n)+" days ago",a}

        function isOpen() {
            return bucket.getAttribute('class') === 'uh-alerts-active';
        }

        function show() {
            if (!isOpen()) {
                bucket.setAttribute('class', 'uh-alerts-active');
            }
        }

        function hide() {
            if (isOpen()) {
                bucket.setAttribute('class', '');
            }
        }

        function getAlerts() {
            var r = new XMLHttpRequest(),
                data;
            r.open('GET', settings.api_url + settings.campus, true);
            r.onreadystatechange = function () {
                var o = '';
                if (r.readyState === 4) {
                    if (r.status === 200) {
                        if (alerts_cache !== r.response) {
                            // only update if there is a change
                            data = JSON.parse(r.response);
                            if (data && data.length) {
                                o = '<button class="uh-alerts-close">Hide</button>';
                                data.forEach(function (i, v) {
                                    o += '<p><a href="' + settings.alert_info_url + i.id +'">' + i.title + '</a>: ' + i.sms_message + ' <span class="uh-alerts-updated">(Updated ' + relativeTime(i.updated_at || i.created_at) + ')</span></p>';
                                });
                                bucket.innerHTML = o;
                                show();
                            } else {
                                bucket.innerHTML = '';
                                hide();
                            }
                            alerts_cache = r.response;
                        }
                    }
                }
            };
            r.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
            r.send();
        }

        function init() {
            for (var attr in options) {
                settings[attr] = options[attr];
            }
            bucket = document.getElementById(settings.element_id);
            if (!bucket) {
                bucket = document.createElement('div');
                bucket.id = settings.element_id;
                var body = document.getElementsByTagName('body').item(0);
                body && body.insertBefore(bucket, body.firstElementChild);
            }
            getAlerts();
            setInterval(getAlerts, settings.update_frequency);
            bucket.addEventListener('click', function (ev) {
                if (ev.target && ev.target.className === 'uh-alerts-close') {
                    ev.preventDefault();
                    ev.stopPropagation();
                    hide();
                }
            });
        }

        if (window.XMLHttpRequest && window.addEventListener) {
            init();
        }
    };
})(window, document);
