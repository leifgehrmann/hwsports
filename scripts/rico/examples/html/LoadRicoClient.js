Rico_CONFIG = {
  jsDir: "../../ricoClient/js/",       // directory containing Rico's javascript files
  cssDir: "../../ricoClient/css/",     // directory containing Rico's css files
  imgResize: "../../ricoClient/images/resize.gif",
  imgIcons: "../../ricoClient/images/ricoIcons.gif",
  enableLogging: false,    // enable console logging
  grid_striping: true,     // apply row striping to LiveGrids?
  LoadBaseLib: true,       // load base Javascript library (prototype, jQuery, etc)?
  jQuery_theme_path: "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/",

  initialize: function(checkQueryString) {
    this.transDir=this.jsDir;
    var theme,lib,aParm,log;
    if (checkQueryString && location.search.length > 1) {
      var s=location.search;
      if (s.charAt(0)=='?') s=s.substr(1);
      var aSearch=s.split(/&/);
      for (var i=0; i<aSearch.length; i++) {
        aParm=aSearch[i].split(/=/);
        switch (aParm[0]) {
          case 'theme': theme=aParm[1]; break;
          case 'lib':   lib=unescape(aParm[1]); break;
          case 'log':   this.enableLogging=true; break;
        }
      }
    } else {
      // set your production values here
      lib="proto_min";         // base library
      theme="j-ui-lightness";  // jquery themes start with j-, rico themes start with r-
    }
    if (lib) this.LoadLib(lib);
    if (theme) this.LoadTheme(theme);
  },

  LoadLib: function(baseLib) {
    if (this.LoadBaseLib) {
      if (baseLib.indexOf('/') > -1) {
        // load from googleapis
        document.write("<script src='http://ajax.googleapis.com/ajax/libs/"+baseLib+"' type='text/javascript'></script>");
      } else {
        document.write("<script src='"+this.jsDir+baseLib+"' type='text/javascript'></script>");
      }
    }
    this.requireRicoJS("");
    this.requireRicoJS("2" + baseLib.substr(0,3));
    this.requireRicoJS("_min");
    this.requireRicoCSS("rico");
    
    // load locale based on browser language (not accept-language)
    var lang=window.navigator.language || window.navigator.userLanguage;
    if (lang) {
      var lang2=lang.substr(0,2);
      var SupportedLangs = "de,es,fr,it,ja,ko,pt,ru,uk,zh";
      if (SupportedLangs.indexOf(lang2) >= 0) this.requireRicoJS("Locale_"+lang2);
    }
  },

  // set theme
  // "j-ui-lightness" for a Themeroller theme
  // "r-greenHdg" for a native Rico theme
  LoadTheme: function(theme) {
    var prefix=theme.charAt(0);
    theme=theme.substr(2);
    switch (prefix) {
      case 'j':
        this.requireRicoJS("Themeroller");
        document.write("<link type='text/css' rel='Stylesheet' href='"+this.jQuery_theme_path+theme+"/jquery-ui.css'>");
        break;
      case 'r':
        this.requireRicoCSS(theme);
        break;
    }
    if (this.grid_striping) document.write("<link type='text/css' rel='stylesheet' href='"+this.cssDir+"striping_"+theme+".css' />");
  },

  requireRicoJS: function(filename) {
    document.write("<script src='"+this.jsDir+"rico"+filename+".js' type='text/javascript'></script>\n");
  },

  requireRicoCSS: function(filename) {
    document.write("<link href='"+this.cssDir+filename+".css' type='text/css' rel='stylesheet'>\n");
  }

}

Rico_CONFIG.initialize(true);  // load settings from QueryString? true for demo, false for production
