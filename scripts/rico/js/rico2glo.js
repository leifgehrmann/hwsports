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

if (typeof glow=='undefined') throw('This version of Rico requires the glow library');

var Rico = {
  Lib: 'Glow',
  LibVersion: glow.VERSION,
  extend: glow.lang.apply,
  trim: glow.lang.trim,
  tryFunctions: function() {
    for (var i=0; i<arguments.length; i++) {
      try {
        return arguments[i]();
      } catch(e){}
    }
    return null;
  },
  _g: function(element) {
    if (typeof element=='string')
      element = document.getElementById(element);
    return glow.dom.get(element);
  },

  select: function(selector, element) {
    return element ? this._g(element).get(selector) : glow.dom.get(selector);
  },

  eventBind: function(element, eventName, handler) {
    handler.id=glow.events.addListener(Rico.$(element), eventName, handler.object[handler.method], handler.object);
  },

  eventUnbind: function(element, eventName, handler) {
    glow.events.removeListener(handler.id);
  },

  eventHandle: function(object, method) {
    return { object: object, method: method };
  },

  eventElement: function(ev) {
    return ev.source;
  },

  eventClient: function(ev) {
    return {x:ev.pageX - document.body.scrollLeft - document.documentElement.scrollLeft,
            y:ev.pageY - document.body.scrollTop - document.documentElement.scrollTop};
  },

  eventStop: function(ev) {
    ev.preventDefault();
    ev.stopPropagation();
  },

  eventKey: function(ev) {
    return ev.keyCode;
  },

  eventLeftClick: function(ev) {
    return ev.button==0;
  },

  addClass: function(element, className) {
    return this._g(element).addClass(className);
  },

  removeClass: function(element, className) {
    return this._g(element).removeClass(className);
  },

  hasClass: function(element, className) {
    return this._g(element).hasClass(className);
  },

/*
ran into bugs on FF and Safari with native Glow function
getStyle=function(element, property) {
  return this._g(element).css(property);
};

Use a modified version of Prototype's method
*/
  getStyle: function(element, style) {
    element = Rico.$(element);
    var camelCase = style.replace(/\-(\w)/g, function(all, letter){
      return letter.toUpperCase();
    });
    style = style == 'float' ? 'cssFloat' : camelCase;
    var value = element.style[style];
    if (!value || value == 'auto') {
      if (element.currentStyle) {
        value=element.currentStyle[style];
      } else if (document.defaultView) {
        var css = document.defaultView.getComputedStyle(element, null);
        value = css ? css[style] : null;
      }
    }
    if (style == 'opacity') return value ? parseFloat(value) : 1.0;
    return value == 'auto' ? null : value;
  },


  setStyle: function(element, properties) {
    var elem=this._g(element);
    for (var prop in properties) {
      elem.css(prop,properties[prop])
    }
  },

  /**
   * @returns available height, excluding scrollbar & margin
   */
  windowHeight: function() {
    return glow.dom.get(window).height();
  },

  /**
   * @returns available width, excluding scrollbar & margin
   */
  windowWidth: function() {
    return glow.dom.get(window).width();
  },

  positionedOffset: function(element) {
    var p, valueT = 0, valueL = 0;
    do {
      valueT += element.offsetTop  || 0;
      valueL += element.offsetLeft || 0;
      element = element.offsetParent;
      if (element) {
        p = glow.dom.get(element).css('position');
        if (p == 'relative' || p == 'absolute') break;
      }
    } while (element);
    return {left: valueL, top: valueT};
  },

  cumulativeOffset: function(element) {
    return this._g(element).offset();
  },

  _docElement: function() {
    return (document.compatMode && document.compatMode.indexOf("CSS")!=-1) ? document.documentElement : document.getElementsByTagName("body")[0];
  },

  docScrollLeft: function() {
    return Rico._docElement.scrollLeft || window.pageXOffset || 0;
  },

  docScrollTop: function() {
    return Rico._docElement.scrollTop || window.pageYOffset || 0;
  },

  getDirectChildrenByTag: function(element, tagName) {
    tagName=tagName.toLowerCase();
    return this._g(element).children().filter(function(i) { return this.tagName && this.tagName.toLowerCase()==tagName; });
  },

  // Animation

  fadeIn: function(element,duration,onEnd) {
    glow.anim.fadeIn(this._g(element), duration/1000.0, {onComplete:onEnd});
  },

  fadeOut: function(element,duration,onEnd) {
    glow.anim.fadeOut(this._g(element), duration/1000.0, {onComplete:onEnd});
  };

  animate: function(element,options,properties) {
    var effect=glow.anim.css(this._g(element), options.duration/1000.0, properties);
    glow.events.addListener(effect, "complete", options.onEnd);
    effect.start();
    return effect;
  },

  // AJAX

  toQueryString: glow.data.encodeUrl,

  getJSON: function(xhr) { return glow.data.decodeJson(xhr.responseText); },

  ajaxRequest=function(url,options) {
    this.glowSend(url,options);
  }
};

Rico.ajaxRequest.prototype = {
  glowSend : function(url,options) {
    this.onComplete=options.onComplete;
    this.onSuccess=options.onSuccess;
    this.onFailure=options.onFailure;
    var self=this;
    options.onLoad=function(response) { self.glowLoad(response); };
    options.onError=function(response) { self.glowError(response); };
    options.useCache=true;
    if (options.method.toLowerCase()=='post') {
      glow.net.post(url,options.parameters,options);
    } else {
      glow.net.get(url+'?'+glow.data.encodeUrl(options.parameters),options);
    }
  },

  glowError : function(response) {
    if (this.onFailure) this.onFailure(response);
    if (this.onComplete) this.onComplete(response.nativeResponse);
  },

  glowLoad : function(response) {
    if (this.onSuccess) this.onSuccess(response.nativeResponse);
    if (this.onComplete) this.onComplete(response.nativeResponse);
  }
};

Rico.ajaxSubmit=function(form,url,options) {
  options.parameters=glow.data.encodeUrl(this._g(form).val());
  if (!options.method) options.method='post';
  url=url || form.action;
  new Rico.ajaxRequest(url,options);
};
