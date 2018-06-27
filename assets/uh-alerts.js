!(function (window, document, undefined) {
  "use strict";
  // die on missing features
  if (!(window.XMLHttpRequest && "classList" in document.documentElement && document.querySelector && document.addEventListener)) {
    return;
  }

  var UHAlerts = {};
  var features = 'querySelector' in document && 'addEventListener' in window && 'classList' in document.createElement('_'); // Feature test
  var defaults = {
      alert_info_url: "", // base url to view specific alert data (read more link with id appended)
      api_url: "", // base url for data
      campus: "", // campus code
      classes: "", // class(es) for css styling
      element_id: "uh-alerts", // id where the alerts get injected
      refresh_rate: 0, // refresh every n seconds
      debug: false // show debugging info in the console?
    };
  var running = false;
  var settings, alerts_cache, bucket, refresh_timer;

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
    r.open('GET', settings.api_url + '/alerts/' + settings.campus, true);
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

  function hideButtonHandler(ev) {
    if (ev.target && ev.target.classList.contains('uh-alerts-close')) {
      log('hide button tapped');
      ev.preventDefault();
      ev.stopPropagation();
      hide();
    }
  }

  function hideKeyHandler(ev) {
    if (ev.key === 'Escape' && isOpen()) {
      log('hiding via escape key');
      hide();
    }
  }


  UHAlerts.destroy = function () {
    if (!settings) { return; }
    log('destroy()');
    document.documentElement.classList.remove('UHAlerts');
    if (bucket) {
      bucket.removeEventListener('click', hideButtonHandler);
    }
    window.removeEventListener('keypress', hideButtonHandler);
    clearTimeout(refresh_timer);
    settings = null;
  };

  UHAlerts.init = function (options) {
    if (!features) return;
    UHAlerts.destroy();
    // build the settings from defaults and options
    settings = {};
    for (var attr in defaults) {
      if (defaults.hasOwnProperty(attr)) {
        settings[attr] = defaults[attr];
      }
    }
    for (var attr in options) {
      if (options.hasOwnProperty(attr)) {
        settings[attr] = options[attr];
      }
    }
    // ensure we have a campus and api_url
    if (!settings.campus || !settings.api_url) {
      log('missing campus and/or api_url...aborting.');
      return;
    }
    log(settings);
    // get or build the bucket
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
      log('using existing bucket');
      bucket.classList.add(settings.classes);
    }
    getAlerts();
    if (settings.refresh_rate > 0) {
      running = true;
      refresh_timer = setInterval(getAlerts, settings.refresh_rate * 1000);
    }
    // add event handlers
    bucket.addEventListener('click', hideButtonHandler, false);
    window.addEventListener('keypress', hideKeyHandler, false);
  };

  UHAlerts.pause = function () {
    log('pause()');
    if (running) {
      log('paused');
      running = false;
      clearInterval(refresh_timer);
    } else {
      log('not running');
    }
  };

  UHAlerts.resume = function () {
    log('resume()');
    if (settings.refresh_rate) {
      log('resumed');
      running = true;
      getAlerts();
      refresh_timer = setInterval(getAlerts, settings.refresh_rate * 1000);
    } else {
      log('no refresh rate to resume');
    }
  };

  window.UHAlerts = UHAlerts;
})(window, document);
