(function(name, definition) {
    if (typeof module != 'undefined') {
      module.exports = definition();
    } else if (typeof define == 'function' && typeof define.amd == 'object') {
      define(definition);
    } else {
      this[name] = definition();
    }
  }('Router', function() {
  return {
    routes: [{"uri":"show_tables","name":"showTables"},{"uri":"store_tables","name":"storeTables"},{"uri":"delete_row","name":"deleteRow1"},{"uri":"show_category","name":"showCategory"},{"uri":"delete_category","name":"deleteRowCategory"},{"uri":"show_subcat","name":"showSubcat"},{"uri":"delete_subcat","name":"deleteRowSubcat"},{"uri":"show_size","name":"showSize"},{"uri":"delete_size","name":"deleteRowSize"},{"uri":"show_color","name":"showColor"},{"uri":"delete_color","name":"deleteRowColor"},{"uri":"show_descr","name":"showDescr"},{"uri":"delete_descr","name":"deleteRowDescr"},{"uri":"show_pict","name":"showPict"},{"uri":"delete_pict","name":"deleteRowPict"},{"uri":"\/","name":"index"},{"uri":"sucat\/{cat_id}\/{subcat_id}","name":"cat_sub_show"},{"uri":"good\/{cat_id}\/{subcat_id}\/{id}","name":"good"},{"uri":"ajax_bag_user\/{id}","name":"ajax_bag_user"},{"uri":"login","name":"login"},{"uri":"logout","name":"logout"},{"uri":"register","name":"register"},{"uri":"password\/reset","name":"password.request"},{"uri":"password\/email","name":"password.email"},{"uri":"password\/reset\/{token}","name":"password.reset"},{"uri":"home","name":"home"},{"uri":"_debugbar\/open","name":"debugbar.openhandler"},{"uri":"_debugbar\/clockwork\/{id}","name":"debugbar.clockwork"},{"uri":"_debugbar\/assets\/stylesheets","name":"debugbar.assets.css"},{"uri":"_debugbar\/assets\/javascript","name":"debugbar.assets.js"}],
    route: function(name, params) {
      var route = this.searchRoute(name),
          rootUrl = this.getRootUrl(),
          result = "",
          compiled = "";

      if (route) {
        compiled = this.buildParams(route, params);
        result = this.cleanupDoubleSlashes(rootUrl + '/' + compiled);
        result = this.stripTrailingSlash(result);
        return result;
      }

    },
    searchRoute: function(name) {
      for (var i = this.routes.length - 1; i >= 0; i--) {
        if (this.routes[i].name == name) {
          return this.routes[i];
        }
      }
    },
    buildParams: function(route, params) {
      var compiled = route.uri,
          queryParams = {};

      for (var key in params) {
        if (compiled.indexOf('{' + key + '?}') != -1) {
          if (key in params) {
            compiled = compiled.replace('{' + key + '?}', params[key]);
          }
        } else if (compiled.indexOf('{' + key + '}') != -1) {
          compiled = compiled.replace('{' + key + '}', params[key]);
        } else {
          queryParams[key] = params[key];
        }
      }

      compiled = compiled.replace(/\{([^\/]*)\?}/g, "");

      if (!this.isEmptyObject(queryParams)) {
        return compiled + this.buildQueryString(queryParams);
      }

      return compiled;
    },
    getRootUrl: function() {
      return window.location.protocol + '//' + window.location.host;
    },
    buildQueryString: function(params) {
      var ret = [];
      for (var key in params) {
        ret.push(encodeURIComponent(key) + "=" + encodeURIComponent(params[key]));
      }
      return '?' + ret.join("&");
    },
    isEmptyObject: function(obj) {
      var name;
      for (name in obj) {
        return false;
      }
      return true;
    },
    cleanupDoubleSlashes: function(url) {
      return url.replace(/([^:]\/)\/+/g, "$1");
    },
    stripTrailingSlash: function(url) {
      if(url.substr(-1) == '/') {
        return url.substr(0, url.length - 1);
      }
      return url;
    }
  };
}));