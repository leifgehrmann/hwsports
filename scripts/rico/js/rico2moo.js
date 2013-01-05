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

if (typeof MooTools=='undefined') throw('This version of Rico requires the MooTools library');

var Rico = {
  Lib: 'MooTools',
  LibVersion: MooTools.version,
  extend: typeof($extend) != 'undefined' ? $extend : Object.append,
  tryFunctions: typeof($try) != 'undefined' ? $try : Function.attempt,
  trim: function(s) { return s.trim(); },

  select: function(selector, element) {
    return $(element || document).getElements(selector);
  },

  eventBind: function(element, eventName, handler) {
    $(element).addEvent(eventName, handler);
  },

  eventUnbind: function(element, eventName, handler) {
    $(element).removeEvent(eventName, handler);
  },

  eventHandle: function(object, method) {
    return function(e) { object[method].call(object,e); };
  },

  eventElement: function(ev) {
    return ev.target;
  },

  eventClient: function(ev) {
    return ev.client;
  },

  eventKey: function(ev) {
    return ev.code;
  },

  eventStop: function(ev) {
    ev.stop();
  },

  eventLeftClick: function(ev) {
    return !ev.rightClick;
  },

  addClass: function(element, className) {
    return $(element).addClass(className);
  },

  removeClass: function(element, className) {
    return $(element).removeClass(className);
  },

  hasClass: function(element, className) {
    return $(element).hasClass(className);
  },

  getStyle: function(element, property) {
    return $(element).getStyle(property);
  },

  setStyle: function(element, properties) {
    return $(element).setStyles(properties);
  },

  /**
   * @returns available height, excluding scrollbar & margin
   */
  windowHeight: function() {
    return Window.getSize().y;
  },

  /**
   * @returns available width, excluding scrollbar & margin
   */
  windowWidth: function() {
    return Window.getSize().x;
  },

  _fixOffsets: function(o) {
    return {top: o.y, left: o.x};
  },

  positionedOffset: function(element) {
    var p, valueT = 0, valueL = 0;
    do {
      valueT += element.offsetTop  || 0;
      valueL += element.offsetLeft || 0;
      element = element.offsetParent;
      if (element) {
        p = $(element).getStyle('position');
        if (p == 'relative' || p == 'absolute') break;
      }
    } while (element);
    return {left: valueL, top: valueT};
  },

  cumulativeOffset: function(element) {
    return this._fixOffsets($(element).getPosition());
  },

  docScrollLeft: function() {
    return Window.getScroll().x;
  },

  docScrollTop: function() {
    return Window.getScroll().y;
  },

  getDirectChildrenByTag: function(element, tagName) {
    return $(element).getChildren(tagName);
  },

  // Animation

  fadeIn: function(element,duration,onEnd) {
    var a = new Fx.Tween(element, {duration:duration, onComplete:onEnd});
    a.start('opacity', 1);
  },

  fadeOut: function(element,duration,onEnd) {
    var a = new Fx.Tween(element, {duration:duration, onComplete:onEnd});
    a.start('opacity', 0);
  },

  animate: function(element,options,properties) {
    options.onComplete=options.onEnd;
    var effect=new Fx.Morph(element,options);
    effect.start(properties);
    return effect;
  },

  // AJAX

  getJSON: function(xhr) { return JSON.decode(xhr.responseText,true); },

  toQueryString: typeof(Hash) != 'undefined' ? Hash.toQueryString : Object.toQueryString,

  ajaxRequest: function(url,options) {
    this.mooSend(url,options);
  }
};

Rico.ajaxRequest.prototype = {
  mooSend : function(url,options) {
    this.onSuccess=options.onSuccess;
    this.onComplete=options.onComplete;
    var self=this;
    var mooOptions = {
      onComplete : function() { self.mooComplete(); },
      onSuccess : function() { self.mooSuccess(); },
      onFailure : options.onFailure,
      method : options.method,
      data : options.parameters,
      url : url
    }
    this.mooRequest = new Request(mooOptions);
    this.mooRequest.send();
  },

  mooSuccess : function() {
    if (this.onSuccess) this.onSuccess(this.mooRequest.xhr);
  },

  mooComplete : function() {
    if (this.onComplete) this.onComplete(this.mooRequest.xhr);
  }
};

Rico.ajaxSubmit=function(form,url,options) {
  options.parameters=$(form).toQueryString();
  if (!options.method) options.method='post';
  url=url || form.action;
  new Rico.ajaxRequest(url,options);
};
