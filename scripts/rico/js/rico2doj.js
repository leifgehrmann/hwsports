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

if (typeof dojo=='undefined') throw('This version of Rico requires the Dojo library');

var Rico = {
  Lib: 'dojo',
  LibVersion: dojo.version.toString(),
  extend: dojo.mixin,
  trim: dojo.trim,

  tryFunctions: function() {
    for (var i=0; i<arguments.length; i++) {
      try {
        return arguments[i]();
      } catch(e){}
    }
    return null;
  },

  select: dojo.query,

  eventBind: function(element, eventName, handler) {
    handler.connection=dojo.connect(Rico.$(element), eventName, handler.object, handler.method);
  },

  eventUnbind: function(element, eventName, handler) {
    dojo.disconnect(handler.connection);
  },

  eventElement: function(ev) {
    return ev.target;
  },

  eventStop: dojo.stopEvent,

  eventClient: function(ev) {
    return {x:ev.pageX, y:ev.pageY};
  },

  eventHandle: function(object, method) {
    return { object: object, method: method };
  },

  addClass: dojo.addClass,
  removeClass: dojo.removeClass,
  hasClass: dojo.hasClass,

  getStyle: function(element, name) {
    var camelCase = name.replace(/\-(\w)/g, function(all, letter){
      return letter.toUpperCase();
    });
    return dojo.style(element,camelCase);
  },

  setStyle: dojo.style,

  // tried to use dojo._abs - 1.3.0 was broken in webkit, nightlies broken on IE8
  cumulativeOffset: function(element) {
  //  var offset=dojo._abs(element);
  //  return {top:offset.y, left:offset.x};
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
        p = dojo.style(element,'position');
        if (p == 'relative' || p == 'absolute') break;
      }
    } while (element);
    return {left: valueL, top: valueT};
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

  // logic borrowed from Prototype
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

  docScrollLeft: function() {
    return dojo._docScroll().x;
  },

  docScrollTop: function() {
    return dojo._docScroll().y;
  },

  // Animation

  fadeIn: function(element,duration,onEnd) {
    var a=dojo.fadeIn({node:element, duration:duration});
    if (onEnd) dojo.connect(a,"onEnd",onEnd);
    a.play();
  },

  fadeOut: function(element,duration,onEnd) {
    var a=dojo.fadeOut({node:element, duration:duration});
    if (onEnd) dojo.connect(a,"onEnd",onEnd);
    a.play();
  },

  animate: function(element,options,properties) {
    options.node=element;
    options.properties=properties;
    a=dojo.animateProperty(options);
    a.play();
  },

  // AJAX

  toQueryString: dojo.objectToQuery,

  getJSON: function(xhr) { return dojo.fromJson(xhr.responseText); },

  ajaxRequest: function(url,options) {
    this.dojoSend(url,options);
  }
};

Rico.ajaxRequest.prototype = {
  dojoSend : function(url,options) {
    this.onComplete=options.onComplete;
    this.onSuccess=options.onSuccess;
    this.onFailure=options.onFailure;
    var self=this;
    var dOptions = {
      handle : function(response, ioArgs) { self.dojoComplete(response, ioArgs); },
      error : function(response, ioArgs) { self.dojoError(response, ioArgs); },
      load : function(response, ioArgs) { self.dojoLoad(response, ioArgs); },
      url : url,
      content : options.parameters,
      form : options.form
    }
    var method=options.method.toUpperCase();
    dojo.xhr(method, dOptions, method=='POST');
  },

  dojoComplete : function(dataORerror, ioArgs) {
    if (this.onComplete) this.onComplete(ioArgs.xhr);
  },

  dojoError : function(response, ioArgs) {
    if (this.onFailure) this.onFailure(ioArgs.xhr);
  },

  dojoLoad : function(response, ioArgs) {
    if (this.onSuccess) this.onSuccess(ioArgs.xhr);
  }
};

Rico.ajaxSubmit=function(form,url,options) {
  options.form=form;
  if (!options.method) options.method='post';
  new Rico.ajaxRequest(url,options);
};
