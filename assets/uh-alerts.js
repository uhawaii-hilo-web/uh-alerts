/**
 * University of Hawaiʻi Emergency Alerts
 * Copyright 2018 University of Hawaiʻi
 * @license GPL2
 */
!(function (window, document, undefined) {
  "use strict";
  // die if missing any of these features
  if (!(window.XMLHttpRequest && "classList" in document.documentElement && document.querySelector && document.addEventListener)) {
    return;
  }

  var UHAlerts = {};
  var features = 'querySelector' in document && 'addEventListener' in window && 'classList' in document.createElement('_'); // Feature test
  var defaults = {
    alert_info_url: "", // base url to view specific alert data (read more link with id appended)
    api_url: "", // base url for data (required to function)
    classes: "", // class(es) for css styling
    debug: false, // show debugging info in the console?,
    element_id: "uh-alerts", // id where the alerts get injected
    refresh_rate: 0, // refresh every n seconds
    region: "", // region / campus code (required to function)
    wrapper_id: "uh-alerts-wrapper" // id of the whole alerts plugin bucket
  };
  var running = false;
  var settings, alerts_cache, wrapper, bucket, refresh_timer;

  function log(message1, message2) {
    if (settings.debug && window.console && window.console.log) {
      if (message2) {
        window.console.log('UH Alerts:', message1, message2);
      } else {
        window.console.log('UH Alerts:', message1);
      }
    }
  }

  function intVal(v) { return parseInt(v, 10); }

  function relativeTime(dt) {
    var dp = dt.split(' ')[0].split('-');
    var tp = dt.split(' ')[1].split(":");
    var d = new Date(intVal(dp[0]), intVal(dp[1]) - 1, intVal(dp[2]), intVal(tp[0]), intVal(tp[1]), intVal(tp[2])),
      e = Math.round((+new Date - d) / 1e3),
      t = 60,
      r = 60 * t,
      n = 24 * r;
    return 30 > e ? "moments ago" : t > e ? e + " seconds ago" : 2 * t > e ? "a minute ago" : r > e ? Math.floor(e / t) + " minutes ago" : 1 === Math.floor(e / r) ? "1 hour ago." : n > e ? Math.floor(e / r) + " hours ago" : 2 * n > e ? "yesterday" : Math.floor(e / n) + " days ago";
  }

  UHAlerts.isOpen = function () {
    return wrapper.classList.contains('uh-alerts-active');
  };

  UHAlerts.show = function () {
    log('show()');
    !UHAlerts.isOpen() && wrapper.classList.add('uh-alerts-active');
  };

  UHAlerts.hide = function () {
    log('hide()');
    UHAlerts.isOpen() && wrapper.classList.remove('uh-alerts-active');
  };

  function getAlerts() {
    var r = new XMLHttpRequest(), data;
    log('getAlerts()');
    r.open('GET', settings.api_url + '/alerts/' + settings.region, true);
    r.onreadystatechange = function () {
      var o = '';
      if (r.readyState === 4) {
        if (r.status === 200) {
          // only update if there is a change
          if (alerts_cache !== r.response) {
            data = JSON.parse(r.response);
            if (data && data.length) {
              log('got ' + data.length + ' alerts');
              o = '';
              for (var i = 0; i < data.length; i++) {
                var m = data[i];
                if (settings.alert_info_url) {
                  o += '<p><a href="' + settings.alert_info_url + m.id + '">' + m.title + '</a>: ' + m.sms_message + ' <span class="uh-alerts-updated">(Updated ' + relativeTime(m.updated_at || m.created_at) + ')</span></p>';
                } else {
                  o += '<p><strong>' + m.title + '</strong>: ' + m.sms_message + ' <span class="uh-alerts-updated">(Updated ' + relativeTime(m.updated_at || m.created_at) + ')</span></p>';
                }
              }
              bucket.innerHTML = o;
              UHAlerts.show();
            } else {
              log('no alerts');
              bucket.innerHTML = '';
              UHAlerts.hide();
            }
            alerts_cache = r.response;
          } else {
            log('new data same as cached');
          }
        } else {
          log(r);
        }
      }
    };
    r.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    r.send();
  }

  function hideButtonHandler(ev) {
    if (ev.target && ev.target.classList.contains('uh-alerts-hide')) {
      log('hide button tapped');
      ev.preventDefault();
      ev.stopPropagation();
      UHAlerts.hide();
    }
  }

  function hideKeyHandler(ev) {
    if (ev.key === 'Escape' && isOpen()) {
      log('hiding via escape key');
      UHAlerts.hide();
    }
  }

  UHAlerts.destroy = function () {
    if (!settings) { return; }
    log('destroy()');
    document.documentElement.classList.remove('UHAlerts');
    if (wrapper) {
      wrapper.removeEventListener('click', hideButtonHandler);
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
    // ensure we have a region and api_url
    if (!settings.region || !settings.api_url) {
      log('missing region and/or api_url...aborting.');
      return;
    }
    log(settings);
    // get or build the bucket
    wrapper = document.getElementById(settings.wrapper_id);
    if (!wrapper) {
      log('creating wrapper');
      wrapper = document.createElement('div'); // create the wrapper
      wrapper.id = settings.wrapper_id;
      wrapper.className = 'uh-alerts-wrapper';
      wrapper.setAttribute('role', 'alert');
      var inner_div = document.createElement('div'); // create a div inside the wrapper
      inner_div.innerHTML = '<p class="uh-alerts-hide-wrapper"><button class="uh-alerts-hide">Hide</button></p>';
      bucket = document.createElement('div'); // create the alerts bucket
      bucket.className = 'uh-alerts-alerts';
      bucket.id = settings.element_id;
      inner_div.appendChild(bucket); // the bucket goes in the inner div
      wrapper.appendChild(inner_div); // the inner div goes in the wrapper
      document.body.insertBefore(wrapper, document.body.firstElementChild); // the wrapper becomes the first child of the body
    } else {
      log('using existing wrapper');
    }
    if (settings.classes) {
      wrapper.classList.add(settings.classes);
    }
    getAlerts();
    if (settings.refresh_rate > 0) {
      running = true;
      refresh_timer = setInterval(getAlerts, settings.refresh_rate * 1000);
    }
    // add event handlers
    wrapper.addEventListener('click', hideButtonHandler, false);
    window.addEventListener('keypress', hideKeyHandler, false);
  };

  UHAlerts.pause = function () {
    log('pause()');
    if (running) {
      log('paused updates');
      running = false;
      clearInterval(refresh_timer);
    } else {
      log('not running');
    }
  };

  UHAlerts.resume = function () {
    log('resume()');
    if (settings.refresh_rate) {
      log('resuming updates every ' + settings.refresh_rate + ' seconds');
      running = true;
      getAlerts();
      refresh_timer = setInterval(getAlerts, settings.refresh_rate * 1000);
    } else {
      log('no refresh rate to resume');
    }
  };

  window.UHAlerts = UHAlerts;
})(window, document);
