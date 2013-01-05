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

if (typeof Prototype=='undefined') throw('This version of Rico requires the Prototype library');

var Rico = {
  Lib: 'Prototype',
  LibVersion: Prototype.Version,
  extend: Object.extend,
  tryFunctions: Try.these,
  trim: function(s) { return s.strip(); },

  toQueryString: Object.toQueryString,
  ajaxRequest: Ajax.Request,
  ajaxSubmit: function(form,url,options) {
    options.parameters=Form.serialize(form);
    if (!options.method) options.method='post';
    url=url || form.action;
    new Ajax.Request(url,options);
  },

  getJSON: function(xhr) { return xhr.responseJSON; },

  select: function(selector, element) {
    return element ? $(element).select(selector) : $$(selector);
  },
    
  eventBind: Event.observe,
  eventUnbind: Event.stopObserving,
  eventElement: Event.element,
  eventStop: Event.stop,
  eventClient: function(ev) {
    return {x:ev.clientX, y:ev.clientY};
  },

  eventHandle: function(object, method) {
    return object[method].bindAsEventListener(object);
  },

  addClass: Element.addClassName,
  removeClass: Element.removeClassName,
  hasClass: Element.hasClassName,

  getStyle: Element.getStyle,
  setStyle: Element.setStyle,
  windowHeight: function() {
    return document.viewport.getHeight();
  },
  windowWidth: function() {
    return document.viewport.getWidth();
  },
  positionedOffset: function(element) {
    return $(element).positionedOffset();
  },
  cumulativeOffset: function(element) {
    return $(element).cumulativeOffset();
  },
  docScrollLeft: function() {
    return document.viewport.getScrollOffsets().left;
  },
  docScrollTop: function() {
    return document.viewport.getScrollOffsets().top;
  },
  getDirectChildrenByTag: function(element, tagName) {
    tagName=tagName.toLowerCase();
    return $(element).childElements().inject([],function(result,child) {
      if (child.tagName && child.tagName.toLowerCase()==tagName) result.push(child);
      return result;});
  }
};

// Animation

Rico._animate=Class.create({
  initialize: function(element,options,properties) {
    this.element=$(element);
    this.properties=[];
    this.totSteps=(typeof options.duration =='number' ? options.duration : 500)/25;
    this.options=options;
    this.curStep=0;
    var m,curval;
    for (var p in properties) {
      curval=this.element.getStyle(p);
      switch (typeof curval) {
        case 'string':
          if (m=curval.match(/(-?\d+\.?\d*)([a-zA-Z]*)$/)) {
            this.properties.push({property:p, vStart:parseFloat(m[1]), vEnd:parseFloat(properties[p]), units:m.length > 2 ? m[2] : ''});
          }
          break;
        case 'number':
          this.properties.push({property:p, vStart:curval, vEnd:parseFloat(properties[p]), units:''});
          break;
      }
    }
    this.px=new PeriodicalExecuter(this.processStep.bind(this),0.025);
  },
  
  processStep: function() {
    this.curStep++;
    if (this.curStep >= this.totSteps) {
      this.px.stop();
      for (var i=0; i<this.properties.length; i++) {
        this.setStyle(i,this.properties[i].vEnd);
      }
      if (this.options.onEnd) this.options.onEnd();
    } else {
      for (var i=0; i<this.properties.length; i++) {
        var n=this.properties[i].vStart + (this.curStep / this.totSteps) * (this.properties[i].vEnd - this.properties[i].vStart);
        this.setStyle(i,n);
      }
    }
  },
  
  setStyle: function(idx, newVal) {
    if (this.properties[idx].units) newVal+=this.properties[idx].units;
    var styleParm={};
    styleParm[this.properties[idx].property]=newVal;
    this.element.setStyle(styleParm);
  }
});

Rico.animate=function(element,options,properties) {
  var a=new Rico._animate(element,options,properties);
};

Rico.fadeIn=function(element,duration,onEnd) {
  new Rico._animate(element, {duration:duration, onEnd:onEnd}, {opacity:1.0})
};

Rico.fadeOut=function(element,duration,onEnd) {
  new Rico._animate(element, {duration:duration, onEnd:onEnd}, {opacity:0.0})
};
