/**
  *  Copyright (c) 2009-2011 Matt Brown
  *
  *  Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
  *  file except in compliance with the License. You may obtain a copy of the License at
  *
  *         http://www.apache.org/licenses/LICENSE-2.0
  *
  *  Unless required by applicable law or agreed to in writing, software distributed under the
  *  License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
  *  either express or implied. See the License for the specific language governing permissions
  *  and limitations under the License.
  **/

if (typeof Ext=='undefined') throw('This version of Rico requires the Ext-core library');

var Rico = {
  Lib: 'Ext-core',
  LibVersion: Ext.version,
  extend: Ext.apply,
  trim: function(s) { return s.replace(Ext.DomQuery.trimRe,''); },
  tryFunctions: function() {
    for (var i=0; i<arguments.length; i++) {
      try {
        return arguments[i]();
      } catch(e){}
    }
    return null;
  },

  select: Ext.query,

  eventBind: function(element, eventName, handler) {
    Ext.EventManager.addListener(element, eventName, handler.object[handler.method], handler.object);
  },

  eventUnbind: function(element, eventName, handler) {
    Ext.EventManager.removeListener(element, eventName, handler.object[handler.method], handler.object);
  },

  eventHandle: function(object, method) {
    return { object: object, method: method };
  },

  eventElement: function(ev) {
    return ev.target;
  },

  eventClient: function(ev) {
    return {x:ev.browserEvent.clientX, y:ev.browserEvent.clientY};
  },

  eventStop: function(ev) {
    ev.stopEvent();
  },

  eventRelatedTarget: function(ev) {
    return ev.getRelatedTarget();
  },

  eventKey: function(ev) {
    return ev.getKey();
  },

  eventLeftClick: function(ev) {
    return ev.button===0;
  },

  addClass: function(element, className) {
    var xElem=Ext.get(element);
    if (!xElem.hasClass(className)) xElem.addClass(className);
    return xElem;
  },

  removeClass: function(element, className) {
    return Ext.get(element).removeClass(className);
  },

  hasClass: function(element, className) {
    return Ext.get(element).hasClass(className);
  },

  getStyle: function(element, property) {
    return Ext.get(element).getStyle(property);
  },
  setStyle: function(element, properties) {
    return Ext.get(element).setStyle(properties);
  },

  // logic borrowed from Prototype
  // Ext.lib.Dom.getViewportWidth/Height includes scrollbar in Gecko browsers
  _getWinDimension: function(D) {
    if (this.isWebKit && !document.evaluate) {
      // Safari <3.0 needs self.innerWidth/Height
      return self['inner' + D];
    } else if (this.isOpera && parseFloat(window.opera.version()) < 9.5) {
      // Opera <9.5 needs document.body.clientWidth/Height
      return document.body['client' + D]
    } else {
      return document.documentElement['client' + D];
    }
  },

  windowHeight: function() {
    return this._getWinDimension('Height');
  },

  windowWidth: function() {
    return this._getWinDimension('Width');
  },

  cumulativeOffset: function(element) {
    element=Rico.$(element);
    var valueT = 0, valueL = 0;
    do {
      valueT += element.offsetTop  || 0;
      valueL += element.offsetLeft || 0;
      element = element.offsetParent;
    } while (element);
    return {left: valueL, top: valueT};
  },

  positionedOffset: function(element) {
    element=Rico.$(element);
    var p, valueT = 0, valueL = 0;
    do {
      valueT += element.offsetTop  || 0;
      valueL += element.offsetLeft || 0;
      element = element.offsetParent;
      if (element) {
        p = Ext.get(element).getStyle('position');
        if (p == 'relative' || p == 'absolute') break;
      }
    } while (element);
    return {left: valueL, top: valueT};
  },

  docScrollLeft: function() {
    return Ext.get(document).getScroll().left;
  },

  docScrollTop: function() {
    return Ext.get(document).getScroll().top;
  },

  getDirectChildrenByTag: function(element, tagName) {
    var kids = [];
    var allKids = element.childNodes;
    tagName=tagName.toLowerCase();
    for( var i = 0 ; i < allKids.length ; i++ ) {
      if ( allKids[i] && allKids[i].tagName && allKids[i].tagName.toLowerCase() == tagName )
        kids.push(allKids[i]);
    }
    return kids;
  },

  // Animation

  fadeIn: function(element,duration,onEnd) {
    Ext.get(element).fadeIn({duration:duration/1000.0, callback: onEnd});
  },

  fadeOut: function(element,duration,onEnd) {
    Ext.get(element).fadeOut({duration:duration/1000.0, callback: onEnd});
  },

  animate: function(element,options,properties) {
    var opts={};
    opts.callback=options.onEnd;
    opts.duration=options.duration/1000.0;
    opts.width=properties.width;
    opts.height=properties.height;
    opts.x=properties.left;
    opts.y=properties.top;
    opts.opacity=properties.opacity;
    Ext.get(element).shift(opts);
  },

  // AJAX

  toQueryString: Ext.urlEncode,

  getJSON: function(xhr) { return Ext.util.JSON.decode(xhr.responseText); },

  ajaxRequest: function(url,options) {
    var extOptions = {
      success : options.onSuccess || options.onComplete,
      failure : options.onFailure || options.onComplete,
      method : options.method.toUpperCase(),
      url : url,
      form : options.form,
      params : options.parameters
    }
    Ext.Ajax.request(extOptions);
  },

  ajaxSubmit: function(form,url,options) {
    options.form=form;
    if (!options.method) options.method='post';
    Rico.ajaxRequest(url,options);
  }
};
