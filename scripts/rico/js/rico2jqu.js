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

if (typeof jQuery=='undefined') throw('This version of Rico requires the jQuery library');

var Rico = {
  Lib: 'jQuery',
  LibVersion: jQuery().jquery,
  extend: jQuery.extend,
  trim: jQuery.trim,
  tryFunctions: function() {
    for (var i=0; i<arguments.length; i++) {
      try {
        return arguments[i]();
      } catch(e){}
    }
    return null;
  },

  _j: function(element) {
    if (typeof element=='string')
      element = document.getElementById(element);
    return jQuery(element);
  },

  select: function(selector, element) {
    return element ? this._j(element).find(selector) : jQuery(selector);
  },

  eventBind: function(element, eventName, handler) {
    this._j(element).bind(eventName, handler);
  },

  eventUnbind: function(element, eventName, handler) {
    this._j(element).unbind(eventName, handler);
  },

  eventHandle: function(object, method) {
    return function(e) {
      return object[method].call(object,e);
    }
  },

  eventElement: function(ev) {
    return ev.target;
  },

  eventClient: function(ev) {
    return {x:ev.clientX, y:ev.clientY};
  },

  eventStop: function(ev) {
    ev.preventDefault();
    ev.stopPropagation();
  },

  addClass: function(element, className) {
    var j=this._j(element);
    if (!j.hasClass(className)) j.addClass(className);
    return j;
  },

  removeClass: function(element, className) {
    return this._j(element).removeClass(className);
  },

  hasClass: function(element, className) {
    return this._j(element).hasClass(className);
  },

  getStyle: function(element, property) {
    return this._j(element).css(property);
  },
  setStyle: function(element, properties) {
    return this._j(element).css(properties);
  },

  /**
   * @returns available height, excluding scrollbar & margin
   */
  windowHeight: function() {
    return jQuery(window).height();
  },

  /**
   * @returns available width, excluding scrollbar & margin
   */
  windowWidth: function() {
    return jQuery(window).width();
  },

  positionedOffset: function(element) {
    return this._j(element).position();
  },

  cumulativeOffset: function(element) {
    return this._j(element).offset();
  },

  docScrollLeft: function() {
    return jQuery('html').scrollLeft();
  },

  docScrollTop: function() {
    return jQuery('html').scrollTop();
  },

  getDirectChildrenByTag: function(element, tagName) {
    return this._j(element).children(tagName);
  },

  toQueryString: jQuery.param,

  // Animation

  fadeIn: function(element,duration,onEnd) {
    this._j(element).fadeIn(duration,onEnd);
  },

  fadeOut: function(element,duration,onEnd) {
    this._j(element).fadeOut(duration,onEnd);
  },

  animate: function(element,options,properties) {
    options.complete=options.onEnd;
    this._j(element).animate(properties,options);
  },

  getJSON: jQuery.httpData ? function(xhr) { return jQuery.httpData(xhr,'json'); } : function(xhr) { return jQuery.parseJSON(xhr.responseText); },

  ajaxRequest: function(url,options) {
    this.jSend(url,options);
  }
};

Rico.ajaxRequest.prototype = {
  jSend: function(url,options) {
    this.onSuccess=options.onSuccess;
    var self=this;
    var jOptions = {
      complete : options.onComplete,
      error: options.onFailure,
      success: function() { self.jSuccess(); },
      type : options.method.toUpperCase(),
      url : url,
      data : options.parameters
    }
    this.xhr=jQuery.ajax(jOptions);
  },

  jSuccess: function() {
    if (this.onSuccess) this.onSuccess(this.xhr);
  }
};

Rico.ajaxSubmit=function(form,url,options) {
  options.parameters=this._j(form).serialize();
  if (!options.method) options.method='post';
  url=url || form.action;
  new Rico.ajaxRequest(url,options);
};
