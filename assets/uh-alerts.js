!(function (window, document, undefined) {
  "use strict";
  // die on missing features
  if (!(window.XMLHttpRequest && "classList" in document.documentElement && document.querySelector && document.addEventListener)) {
    return;
  }

  window.UHAlerts = function (options) {
    var settings = {
        alert_info_url: "", // base url to view specific alert data (read more link with id appended)
        api_url: "https://www.hawaii.edu/alert/test/api/1.0/alerts/", // base url for data
        campus: "", // campus code
        classes: "", // class(es) for css styling
        element_id: "uh-alerts", // id for css styling
        refresh_rate: 0, // refresh every n seconds
        debug: false // show debugging info in the console?
      },
      alerts_cache,
      bucket,
      refresh_timer;

    function log(message1, message2) {
      if (settings.debug && window.console && window.console.log) {
        if (message2) {
          window.console.log('UH Alerts:', message1, message2);
        } else {
          window.console.log('UH Alerts:', message1);
        }
      }
    }

    function relativeTime(dt) {
      var dp = dt.split(' ')[0].split('-').map(function (v) {
          return parseInt(v, 10)
        }), tp = dt.split(' ')[1].split(":").map(function (v) {
          return parseInt(v, 10)
        }), d = new Date(dp[0], dp[1] - 1, dp[2], tp[0], tp[1], tp[2]), a, e = Math.round((+new Date - d) / 1e3), t = 60,
        r = 60 * t, n = 24 * r;
      return 30 > e ? a = "moments ago" : t > e ? a = e + " seconds ago" : 2 * t > e ? a = "a minute ago" : r > e ? a = Math.floor(e / t) + " minutes ago" : 1 === Math.floor(e / r) ? a = "1 hour ago." : n > e ? a = Math.floor(e / r) + " hours ago" : 2 * n > e ? a = "yesterday" : a = Math.floor(e / n) + " days ago", a
    }

    function isOpen() {
      return bucket.classList.contains('uh-alerts-active');
    }

    function show() {
      log('show()');
      !isOpen() && bucket.classList.add('uh-alerts-active');
    }

    function hide() {
      log('hide()');
      isOpen() && bucket.classList.remove('uh-alerts-active');
    }

    function getAlerts() {
      var r = new XMLHttpRequest(), data;
      log('getAlerts()');
      r.open('GET', settings.api_url + settings.campus, true);
      r.onreadystatechange = function () {
        var o = '';
        if (r.readyState === 4) {
          if (r.status === 200) {
            // only update if there is a change
            if (alerts_cache !== r.response) {
              data = JSON.parse(r.response);
              if (data && data.length) {
                log('got ' + data.length + ' alerts');
                o = '<p class="uh-alerts-close-container"><button class="uh-alerts-close">Hide</button></p>';
                data.forEach(function (i, v) {
                  if (settings.alert_info_url) {
                    o += '<p><a href="' + settings.alert_info_url + i.id + '">' + i.title + '</a>: ' + i.sms_message + ' <span class="uh-alerts-updated">(Updated ' + relativeTime(i.updated_at || i.created_at) + ')</span></p>';
                  } else {
                    o += '<p><strong>' + i.title + '</strong>: ' + i.sms_message + ' <span class="uh-alerts-updated">(Updated ' + relativeTime(i.updated_at || i.created_at) + ')</span></p>';
                  }
                });
                bucket.innerHTML = o;
                show();
              } else {
                log('no alerts');
                bucket.innerHTML = '';
                hide();
              }
              alerts_cache = r.response;
            } else {
              log('new data same as cached');
            }
          }
        }
      };
      r.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
      r.send();
    }

    function init() {
      log('init()');
      for (var attr in options) {
        if (options.hasOwnProperty(attr)) {
          settings[attr] = options[attr];
        }
      }
      if (!settings.campus) {
        log('no campus specified...aborting.');
        return; // short circuit if there's no campus code
      }
      log(settings);
      bucket = document.getElementById(settings.element_id);
      if (!bucket) {
        log('creating bucket');
        bucket = document.createElement('div');
        bucket.id = settings.element_id;
        bucket.className = settings.classes;
        var body = document.querySelector('body');
        log('adding bucket to', body);
        body && body.insertBefore(bucket, body.firstElementChild);
      } else if (settings.classes) {
        bucket.classList.add(settings.classes);
      }

      getAlerts();
      if (settings.refresh_rate > 0) {
        refresh_timer = setInterval(getAlerts, settings.refresh_rate * 1000);
      }

      bucket.addEventListener('click', function (ev) {
        if (ev.target && ev.target.classList.contains('uh-alerts-close')) {
          log('hide button tapped');
          ev.preventDefault();
          ev.stopPropagation();
          hide();
        }
      });

      window.addEventListener('keypress', function (ev) {
        if (ev.key === 'Escape' && isOpen()) {
          hide();
        }
      });
    }

    init();
  };
})(window, document);
