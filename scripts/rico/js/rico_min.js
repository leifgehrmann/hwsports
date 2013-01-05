Rico.Version="3.0";
Rico.theme={};
Rico.onLoadCallbacks=[];
Rico.windowIsLoaded=false;
Rico.inputtypes={search:0,number:0,range:0,color:0,tel:0,url:0,email:0,date:0,month:0,week:0,time:0,datetime:0,"datetime-local":0};
Rico.windowLoaded=function(){this.windowIsLoaded=true;
if(typeof Rico_CONFIG=="object"){if(Rico_CONFIG.enableLogging){this.enableLogging()
}if(Rico_CONFIG.enableHTML5){this._CheckInputTypes()
}}Rico.writeDebugMsg=Rico.log;
Rico.log("Processing callbacks");
while(this.onLoadCallbacks.length>0){var a=this.onLoadCallbacks.shift();
if(a){a()
}}};
Rico._CheckInputTypes=function(){var a=document.createElement("input");
for(var b in this.inputtypes){a.setAttribute("type","text");
a.setAttribute("type",b);
this.inputtypes[b]=(a.type!=="text")
}};
Rico.onLoad=function(b,a){if(this.windowIsLoaded){b()
}else{if(a){this.onLoadCallbacks.unshift(b)
}else{this.onLoadCallbacks.push(b)
}}};
Rico.isKonqueror=navigator.userAgent.toLowerCase().indexOf("konqueror")>-1;
Rico.isIE=!!(window.attachEvent&&navigator.userAgent.indexOf("Opera")===-1);
Rico.isOpera=navigator.userAgent.indexOf("Opera")>-1;
Rico.isWebKit=navigator.userAgent.indexOf("AppleWebKit/")>-1;
Rico.isGecko=navigator.userAgent.indexOf("Gecko")>-1&&navigator.userAgent.indexOf("KHTML")===-1;
Rico.ieVersion=/MSIE (\d+\.\d+);/.test(navigator.userAgent)?new Number(RegExp.$1):null;
Rico.startTime=new Date();
Rico.timeStamp=function(){var a=new Date();
return(a.getTime()-this.startTime.getTime())+": "
};
Rico.setDebugArea=function(c,a){if(!this.debugArea||a){var b=document.getElementById(c);
if(!b){return
}this.debugArea=b;
b.value=""
}};
Rico.log=function(){};
Rico.enableLogging=function(){if(this.debugArea){this.log=function(b,a){if(a){this.debugArea.value=""
}this.debugArea.value+=this.timeStamp()+b+"\n"
}
}else{if(window.console){if(window.console.firebug){this.log=function(a){window.console.log(this.timeStamp(),a)
}
}else{this.log=function(a){window.console.log(this.timeStamp()+a)
}
}}else{if(window.opera){this.log=function(a){window.opera.postError(this.timeStamp()+a)
}
}}}};
Rico.$=function(a){return typeof a=="string"?document.getElementById(a):a
};
Rico.runLater=function(){var b=Array.prototype.slice.call(arguments);
var c=b.shift();
var a=b.shift();
var d=b.shift();
return setTimeout(function(){a[d].apply(a,b)
},c)
};
Rico.visible=function(a){return Rico.getStyle(a,"display")!="none"
};
Rico.show=function(a){a.style.display=""
};
Rico.hide=function(a){a.style.display="none"
};
Rico.toggle=function(a){a.style.display=a.style.display=="none"?"":"none"
};
Rico.direction=function(a){return(Rico.getStyle(a,"direction")||"ltr").toLowerCase()
};
Rico.viewportOffset=function(a){var b=Rico.cumulativeOffset(a);
b.left-=this.docScrollLeft();
b.top-=this.docScrollTop();
return b
};
Rico.getInnerText=function(f,b,g,e){switch(typeof f){case"string":return f;
case"undefined":return f;
case"number":return f.toString()
}var d=f.childNodes;
var a=d.length;
var h="";
for(var c=0;
c<a;
c++){switch(d[c].nodeType){case 1:if(this.getStyle(d[c],"display")=="none"){continue
}if(e&&this.hasClass(d[c],e)){continue
}switch(d[c].tagName.toLowerCase()){case"img":if(!b){h+=d[c].alt||d[c].title||d[c].src
}break;
case"input":if(!g&&!d[c].disabled&&d[c].type.toLowerCase()=="text"){h+=d[c].value
}break;
case"select":if(!g&&d[c].selectedIndex>=0){h+=d[c].options[d[c].selectedIndex].text
}break;
case"textarea":if(!g&&!d[c].disabled){h+=d[c].value
}break;
default:h+=this.getInnerText(d[c],b,g,e);
break
}break;
case 3:h+=d[c].nodeValue;
break
}}return h
};
Rico.getContentAsString=function(a,b){if(b){return this._getEncodedContent(a)
}if(typeof a.xml!="undefined"){return this._getContentAsStringIE(a)
}return this._getContentAsStringMozilla(a)
};
Rico._getEncodedContent=function(a){if(a.innerHTML){return a.innerHTML
}switch(a.childNodes.length){case 0:return"";
case 1:return a.firstChild.nodeValue;
default:return a.childNodes[1].nodeValue
}};
Rico._getContentAsStringIE=function(a){var c="";
for(var b=0;
b<a.childNodes.length;
b++){var d=a.childNodes[b];
c+=(d.nodeType==4)?d.nodeValue:d.xml
}return c
};
Rico._getContentAsStringMozilla=function(b){var a=new XMLSerializer();
var d="";
for(var c=0;
c<b.childNodes.length;
c++){var e=b.childNodes[c];
if(e.nodeType==4){d+=e.nodeValue
}else{d+=a.serializeToString(e)
}}return d
};
Rico.nan2zero=function(a){if(typeof(a)=="string"){a=parseInt(a,10)
}return isNaN(a)||typeof(a)=="undefined"?0:a
};
Rico.stripTags=function(a){return a.replace(/<\/?[^>]+>/gi,"")
};
Rico.truncate=function(a,b){return a.length>b?a.substr(0,b-3)+"...":a
};
Rico.zFill=function(d,c,b){var a=d.toString(b||10);
while(a.length<c){a="0"+a
}return a
};
Rico.keys=function(c){var b=[];
for(var a in c){b.push(a)
}return b
};
Rico.eventKey=function(a){if(typeof(a.keyCode)=="number"){return a.keyCode
}else{if(typeof(a.which)=="number"){return a.which
}else{if(typeof(a.charCode)=="number"){return a.charCode
}}}return -1
};
Rico.eventLeftClick=function(a){return(((a.which)&&(a.which==1))||((a.button)&&(a.button==1)))
};
Rico.eventRelatedTarget=function(a){return a.relatedTarget
};
Rico.getPreviosSiblingByTagName=function(c,b){var a=c.previousSibling;
while(a){if((a.tagName==b)&&(a.style.display!="none")){return a
}a=a.previousSibling
}return null
};
Rico.getParentByTagName=function(d,a,c){var b=d;
a=a.toLowerCase();
while(b){if(b.tagName&&b.tagName.toLowerCase()==a){if(!c||b.className.indexOf(c)>=0){return b
}}b=b.parentNode
}return null
};
Rico.wrapChildren=function(b,a,e,c){var d=document.createElement(c||"div");
if(e){d.id=e
}if(a){d.className=a
}while(b.firstChild){d.appendChild(b.firstChild)
}b.appendChild(d);
return d
};
Rico.positionCtlOverIcon=function(f,j){j=this.$(j);
var b=this.cumulativeOffset(j);
var i=this.docScrollTop();
var a=this.windowHeight();
if(f.style.display=="none"){f.style.display="block"
}var g=2;
if(Rico.direction(j)=="rtl"){f.style.left=(b.left+j.offsetWidth-f.offsetWidth)+"px"
}else{var d=this.nan2zero(this.getStyle(j,"marginLeft"));
f.style.left=(b.left+d+g)+"px"
}var h=b.top+g;
var e=f.offsetHeight;
var c=j.offsetHeight;
var d=10;
if(h+c+e+d<a+i){h+=c
}else{h=Math.max(h-e,i)
}f.style.top=h+"px"
};
Rico.createFormField=function(d,b,f,g,a){var e;
if(typeof a!="string"){a=g
}if(this.isIE&&this.ieVersion<8){var c=b+' id="'+g+'"';
if(f){c+=' type="'+f+'"'
}if(b.match(/^(form|input|select|textarea|object|button|img)$/)){c+=' name="'+a+'"'
}e=document.createElement("<"+c+" />")
}else{e=document.createElement(b);
if(f){e.type=f
}e.id=g;
if(typeof e.name=="string"){e.name=a
}}d.appendChild(e);
return e
};
Rico.addSelectOption=function(b,c,d){var a=document.createElement("option");
if(typeof c=="string"){a.value=c
}a.text=d;
if(this.isIE){b.add(a)
}else{b.add(a,null)
}return a
};
Rico.getCookie=function(g){var b=g+"=";
var f=b.length;
var a=document.cookie.length;
var d=0;
while(d<a){var c=d+f;
if(document.cookie.substring(d,c)==b){var e=document.cookie.indexOf(";",c);
if(e==-1){e=document.cookie.length
}return unescape(document.cookie.substring(c,e))
}d=document.cookie.indexOf(" ",d)+1;
if(d==0){break
}}return null
};
Rico.getTBody=function(a){return a.tBodies.length==0?a.appendChild(document.createElement("tbody")):a.tBodies[0]
};
Rico.setCookie=function(e,g,f,d,a){var h=e+"="+escape(g);
if(typeof(f)=="number"){var b=new Date();
b.setTime(b.getTime()+(f*24*60*60*1000));
h+="; expires="+b.toGMTString()
}if(typeof(d)=="string"){h+="; path="+d
}if(typeof(a)=="string"){h+="; domain="+a
}document.cookie=h
};
Rico.phrasesById={};
Rico.thouSep=",";
Rico.decPoint=".";
Rico.langCode="en";
Rico.dateFmt="mm/dd/yyyy";
Rico.timeFmt="hh:nn:ss a/pm";
Rico.monthNames=["January","February","March","April","May","June","July","August","September","October","November","December"];
Rico.dayNames=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
Rico.monthAbbr=function(a){return this.monthNamesShort?this.monthNamesShort[a]:this.monthNames[a].substr(0,3)
};
Rico.dayAbbr=function(a){return this.dayNamesShort?this.dayNamesShort[a]:this.dayNames[a].substr(0,3)
};
Rico.addPhraseId=function(b,a){this.phrasesById[b]=a
};
Rico.getPhraseById=function(d){var b=this.phrasesById[d];
if(!b){alert("Error: missing phrase for "+d);
return""
}if(arguments.length<=1){return b
}var c=arguments;
return b.replace(/(\$\d)/g,function(e){var a=parseInt(e.charAt(1),10);
return(a<c.length)?c[a]:""
})
};
Rico.formatPosNumber=function(e,f,c){var b=e.toFixed(f).split(/\./);
if(c){var d=/(\d+)(\d{3})/;
while(d.test(b[0])){b[0]=b[0].replace(d,"$1"+Rico.thouSep+"$2")
}}return b.join(Rico.decPoint)
};
Rico.formatNumber=function(b,c){if(typeof b=="string"){b=parseFloat(b.replace(/,/,"."),10)
}if(isNaN(b)){return"NaN"
}if(typeof c.multiplier=="number"){b*=c.multiplier
}var h=typeof c.decPlaces=="number"?c.decPlaces:0;
var e=typeof c.thouSep=="undefined"?true:c.thouSep;
var d=c.prefix||"";
var f=c.suffix||"";
var a=typeof c.negSign=="string"?c.negSign:"L";
a=a.toUpperCase();
var i,g;
if(b<0){i=this.formatPosNumber(-b,h,e);
if(a=="P"){i="("+i+")"
}i=d+i;
if(a=="L"){i="-"+i
}if(a=="T"){i+="-"
}g="negNumber"
}else{g=b==0?"zeroNumber":"posNumber";
i=d+this.formatPosNumber(b,h,e)
}return"<span class='"+g+"'>"+i+f+"</span>"
};
Rico.formatDate=function(c,a){var b=(typeof a=="string")?a:"translateDate";
switch(b){case"locale":case"localeDateTime":return c.toLocaleString();
case"Long Date":case"localeDate":return c.toLocaleDateString();
case"translate":case"translateDateTime":b=this.dateFmt+" "+this.timeFmt;
break;
case"Short Date":case"translateDate":b=this.dateFmt;
break
}return b.replace(/(yyyy|yy|mmmm|mmm|mm|dddd|ddd|dd|d|hh|nn|ss|a\/p)/gi,function(d){var e;
switch(d){case"yyyy":return c.getFullYear();
case"yy":return c.getFullYear().toString().substr(2);
case"mmmm":return Rico.monthNames[c.getMonth()];
case"mmm":return Rico.monthAbbr(c.getMonth());
case"mm":return Rico.zFill(c.getMonth()+1,2);
case"m":return(c.getMonth()+1);
case"dddd":return Rico.dayNames[c.getDay()];
case"ddd":return Rico.dayAbbr(c.getDay());
case"dd":return Rico.zFill(c.getDate(),2);
case"d":return c.getDate();
case"hh":return Rico.zFill((e=c.getHours()%12)?e:12,2);
case"h":return((e=c.getHours()%12)?e:12);
case"HH":return Rico.zFill(c.getHours(),2);
case"H":return c.getHours();
case"nn":return Rico.zFill(c.getMinutes(),2);
case"ss":return Rico.zFill(c.getSeconds(),2);
case"a/p":return c.getHours()<12?"a":"p"
}})
};
Rico.setISO8601=function(b,f){if(!b){return false
}var e=b.match(/(\d\d\d\d)(?:-?(\d\d)(?:-?(\d\d)(?:[T ](\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|(?:([-+])(\d\d)(?::?(\d\d))?)?)?)?)?)?/);
if(!e){return false
}if(!f){f=0
}var a=new Date(e[1],0,1);
if(e[2]){a.setMonth(e[2]-1)
}if(e[3]){a.setDate(e[3])
}if(e[4]){a.setHours(e[4])
}if(e[5]){a.setMinutes(e[5])
}if(e[6]){a.setSeconds(e[6])
}if(e[7]){a.setMilliseconds(Number("0."+e[7])*1000)
}if(e[8]){if(e[10]&&e[11]){f=(Number(e[10])*60)+Number(e[11])
}f*=((e[9]=="-")?1:-1);
f-=a.getTimezoneOffset()
}var c=(Number(a)+(f*60*1000));
a.setTime(Number(c));
return a
};
Rico.toISO8601String=function(a,e,h){if(!e){e=6
}if(!h){h="Z"
}else{var g=h.match(/([-+])([0-9]{2}):([0-9]{2})/);
var c=(Number(g[2])*60)+Number(g[3]);
c*=((g[1]=="-")?-1:1);
a=new Date(Number(Number(a)+(c*60000)))
}var i=function(d){return((d<10)?"0":"")+d
};
var f=a.getUTCFullYear();
if(e>1){f+="-"+i(a.getUTCMonth()+1)
}if(e>2){f+="-"+i(a.getUTCDate())
}if(e>3){f+="T"+i(a.getUTCHours())+":"+i(a.getUTCMinutes())
}if(e>5){var b=Number(a.getUTCSeconds()+"."+((a.getUTCMilliseconds()<100)?"0":"")+i(a.getUTCMilliseconds()));
f+=":"+i(b)
}else{if(e>4){f+=":"+i(a.getUTCSeconds())
}}if(e>3){f+=h
}return f
};
Rico.createXmlDocument=function(){if(document.implementation&&document.implementation.createDocument){var a=document.implementation.createDocument("","",null);
if(a.readyState==null){a.readyState=1;
a.addEventListener("load",function(){a.readyState=4;
if(typeof a.onreadystatechange=="function"){a.onreadystatechange()
}},false)
}return a
}if(window.ActiveXObject){return Rico.tryFunctions(function(){return new ActiveXObject("MSXML2.DomDocument")
},function(){return new ActiveXObject("Microsoft.DomDocument")
},function(){return new ActiveXObject("MSXML.DomDocument")
},function(){return new ActiveXObject("MSXML3.DomDocument")
})||false
}return null
};
Rico.ajaxUpdater=function(c,b,a){this.updateSend(c,b,a)
};
Rico.ajaxUpdater.prototype={updateSend:function(d,c,b){this.element=d;
this.onComplete=b.onComplete;
var a=this;
b.onComplete=function(e){a.updateComplete(e)
};
new Rico.ajaxRequest(c,b)
},updateComplete:function(a){this.element.innerHTML=a.responseText;
if(this.onComplete){this.onComplete(a)
}}};
try{document.execCommand("BackgroundImageCache",false,true)
}catch(err){}Rico.eventBind(window,"load",Rico.eventHandle(Rico,"windowLoaded"));
Rico.applyShadow=function(b,a){if(typeof a=="undefined"){a=true
}if(a){Rico.addClass(b,"ricoShadow")
}return b
};
Rico._OpenPopupList=[];
Rico._RemoveOpenPopup=function(a){if(a.openIndex>=0&&a.openIndex<Rico._OpenPopupList.length){Rico._OpenPopupList.splice(a.openIndex,1)
}a.openIndex=-1
};
Rico._AddOpenPopup=function(a){a.openIndex=Rico._OpenPopupList.push(a)-1
};
Rico._checkEscKey=function(b){if(Rico.eventKey(b)!=27){return true
}while(Rico._OpenPopupList.length>0){var a=Rico._OpenPopupList.pop();
if(a&&a.visible()){a.openIndex=-1;
Rico.eventStop(b);
a.closeFunc();
return false
}}return true
};
Rico.eventBind(document,"keyup",Rico.eventHandle(Rico,"_checkEscKey"));
Rico.Popup=function(b,a){this.initialize(b,a)
};
Rico.Popup.prototype={initialize:function(b,a){this.options={hideOnClick:false,ignoreClicks:false,position:"absolute",shadow:true,zIndex:2,canDrag:false,dragElement:false,closeFunc:false};
this.openIndex=-1;
if(b){this.setDiv(b,a)
}},createContainer:function(a){this.setDiv(document.createElement("div"),a);
if(a&&a.parent){a.parent.appendChild(this.container)
}else{document.getElementsByTagName("body")[0].appendChild(this.container)
}},setDiv:function(c,b){Rico.extend(this.options,b||{});
this.container=Rico.$(c);
if(this.options.position=="auto"){this.position=Rico.getStyle(this.container,"position").toLowerCase()
}else{this.position=this.container.style.position=this.options.position
}this.content=document.createElement("div");
while(this.container.firstChild){this.content.appendChild(this.container.firstChild)
}this.container.appendChild(this.content);
this.content.className="RicoPopupContent";
if(this.position!="absolute"){return
}if(this.options.closeFunc){this.closeFunc=this.options.closeFunc
}else{var a=this;
this.closeFunc=function(){a.closePopup()
}
}this.container.style.top="0px";
this.container.style.left="0px";
this.container.style.display="none";
if(this.options.zIndex>=0){this.container.style.zIndex=this.options.zIndex
}if(Rico.isIE&&Rico.ieVersion<7&&this.options.shim!==false){this.content.style.position="relative";
this.content.style.zIndex=2;
this.ifr=document.createElement("iframe");
this.ifr.className="RicoShim";
this.ifr.frameBorder=0;
this.ifr.src="javascript:'';";
this.container.appendChild(this.ifr)
}Rico.applyShadow(this.container,this.options.shadow);
if(this.options.hideOnClick){Rico.eventBind(document,"click",Rico.eventHandle(this,"_docClick"))
}this.dragEnabled=false;
this.mousedownHandler=Rico.eventHandle(this,"_startDrag");
this.dragHandler=Rico.eventHandle(this,"_drag");
this.dropHandler=Rico.eventHandle(this,"_endDrag");
if(this.options.canDrag){this.enableDragging()
}if(this.options.ignoreClicks||this.options.canDrag){this.ignoreClicks()
}},clearContent:function(){this.content.innerHTML=""
},setContent:function(a){this.content.innerHTML=a
},enableDragging:function(){if(!this.dragEnabled&&this.options.dragElement){Rico.eventBind(this.options.dragElement,"mousedown",this.mousedownHandler);
this.dragEnabled=true
}return this.dragEnabled
},disableDragging:function(){if(!this.dragEnabled){return
}Rico.eventUnbind(this.options.dragElement,"mousedown",this.mousedownHandler);
this.dragEnabled=false
},setZ:function(a){this.container.style.zIndex=a
},ignoreClicks:function(){Rico.eventBind(this.container,"click",Rico.eventHandle(this,"_ignoreClick"))
},_ignoreClick:function(a){if(a.stopPropagation){a.stopPropagation()
}else{a.cancelBubble=true
}return true
},_docClick:function(a){this.closeFunc();
return true
},move:function(b,a){if(typeof b=="number"){this.container.style.left=b+"px"
}if(typeof a=="number"){this.container.style.top=a+"px"
}},_startDrag:function(b){var a=Rico.eventElement(b);
this.container.style.cursor="move";
this.lastMouse=Rico.eventClient(b);
Rico.eventBind(document,"mousemove",this.dragHandler);
Rico.eventBind(document,"mouseup",this.dropHandler);
Rico.eventStop(b)
},_drag:function(d){var b=Rico.eventClient(d);
var c=parseInt(this.container.style.left,10)+b.x-this.lastMouse.x;
var a=parseInt(this.container.style.top,10)+b.y-this.lastMouse.y;
this.move(c,a);
this.lastMouse=b;
Rico.eventStop(d)
},_endDrag:function(){this.container.style.cursor="";
Rico.eventUnbind(document,"mousemove",this.dragHandler);
Rico.eventUnbind(document,"mouseup",this.dropHandler)
},openPopup:function(b,a){this.move(b,a);
this.container.style.display="";
if(this.container.id){Rico.log("openPopup "+this.container.id+" at "+b+","+a)
}Rico._AddOpenPopup(this)
},centerPopup:function(){this.openPopup();
var d=this.container.offsetWidth;
var c=this.container.offsetHeight;
var a=this.container.parentNode.offsetWidth;
var b=this.container.parentNode.offsetHeight;
this.move(parseInt(Math.max((a-d)/2,0),10),parseInt(Math.max((b-c)/2,0),10))
},visible:function(){return Rico.visible(this.container)
},closePopup:function(){Rico._RemoveOpenPopup(this);
if(!Rico.visible(this.container)){return
}if(this.container.id){Rico.log("closePopup "+this.container.id)
}if(this.dragEnabled){this._endDrag()
}this.container.style.display="none";
if(this.options.onClose){this.options.onClose()
}}};
Rico.closeButton=function(d){var b=document.createElement("a");
b.className="RicoCloseAnchor";
if(Rico.theme.closeAnchor){Rico.addClass(b,Rico.theme.closeAnchor)
}var c=b.appendChild(document.createElement("span"));
c.title=Rico.getPhraseById("close");
new Rico.HoverSet([b],{hoverClass:Rico.theme.hover||"ricoCloseHover"});
Rico.addClass(c,Rico.theme.close||"rico-icon RicoClose");
Rico.eventBind(b,"click",d);
return b
};
Rico.floatButton=function(b,e,f){var c=document.createElement("a");
c.className="RicoButtonAnchor";
Rico.addClass(c,Rico.theme.buttonAnchor||"RicoButtonAnchorNative");
var d=c.appendChild(document.createElement("span"));
if(f){d.title=f
}d.className=Rico.theme[b.toLowerCase()]||"rico-icon Rico"+b;
Rico.eventBind(c,"click",e,false);
new Rico.HoverSet([c]);
return c
};
Rico.clearButton=function(b){var a=document.createElement("span");
a.title=Rico.getPhraseById("clear");
a.className="ricoClear";
Rico.addClass(a,Rico.theme.clear||"rico-icon ricoClearNative");
Rico.eventBind(a,"click",b);
return a
};
Rico.Window=function(c,a,b){this.initialize(c,a,b)
};
Rico.Window.prototype={initialize:function(c,a,b){a=a||{overflow:"auto"};
Rico.extend(this,new Rico.Popup());
this.titleDiv=document.createElement("div");
this.options.canDrag=true;
this.options.dragElement=this.titleDiv;
this.createContainer(a);
this.content.appendChild(this.titleDiv);
b=Rico.$(b);
if(b){this.contentDiv=b;
b.parentNode.insertBefore(this.container,b)
}else{this.contentDiv=document.createElement("div")
}this.content.appendChild(this.contentDiv);
this.titleDiv.className="ricoTitle";
if(Rico.theme.dialogTitle){Rico.addClass(this.titleDiv,Rico.theme.dialogTitle)
}this.titleDiv.style.position="relative";
this.titleContent=document.createElement("span");
this.titleContent.className="ricoTitleSpan";
this.titleDiv.appendChild(this.titleContent);
this.titleDiv.appendChild(Rico.closeButton(Rico.eventHandle(this,"closeFunc")));
if(!c&&b){c=b.title;
b.title=""
}this.setTitle(c||"&nbsp;");
this.contentDiv.className="ricoContent";
if(Rico.theme.dialogContent){Rico.addClass(this.contentDiv,Rico.theme.dialogContent)
}this.contentDiv.style.position="relative";
if(a.height){this.contentDiv.style.height=a.height
}if(a.width){this.contentDiv.style.width=a.width
}if(a.overflow){this.contentDiv.style.overflow=a.overflow
}Rico.addClass(this.container,"ricoWindow");
if(Rico.theme.dialog){Rico.addClass(this.container,Rico.theme.dialog)
}this.content=this.contentDiv
},setTitle:function(a){this.titleContent.innerHTML=a
}};
Rico.Menu=function(a){this.initialize(a)
};
Rico.Menu.prototype={initialize:function(a){Rico.extend(this,new Rico.Popup());
Rico.extend(this.options,{width:"15em",arrowColor:"b",showDisabled:false,hideOnClick:true});
if(typeof a=="string"){this.options.width=a
}else{Rico.extend(this.options,a||{})
}this.hideFunc=null;
this.highlightElem=null
},createDiv:function(a){if(this.container){return
}var b=this;
var c={closeFunc:function(){b.cancelmenu()
}};
if(a){c.parent=a
}this.createContainer(c);
this.content.className=Rico.isWebKit?"ricoMenuSafari":"ricoMenu";
this.content.style.width=this.options.width;
this.direction=Rico.direction(this.container);
this.hidemenu();
this.itemCount=0
},showmenu:function(b,c){Rico.eventStop(b);
this.hideFunc=c;
if(this.content.childNodes.length==0){this.cancelmenu();
return false
}var a=Rico.eventClient(b);
this.openmenu(a.x,a.y,0,0)
},openmenu:function(g,f,j,e,a){var h=g+(a?0:Rico.docScrollLeft());
this.container.style.visibility="hidden";
this.container.style.display="block";
var i=this.container.offsetWidth;
var b=this.content.offsetWidth;
if(this.direction=="rtl"){if(h>i+j){h-=b+j
}}else{if(g+i>Rico.windowWidth()){h-=b+j-2
}}var d=Rico.docScrollTop();
var c=f+(a?0:d);
if(f+this.container.offsetHeight-d>Rico.windowHeight()){c=Math.max(c-this.content.offsetHeight+e,0)
}this.openPopup(h,c);
this.container.style.visibility="visible";
return false
},clearMenu:function(){this.clearContent();
this.defaultAction=null;
this.itemCount=0
},addMenuHeading:function(b){var a=document.createElement("div");
a.innerHTML=b;
a.className="ricoMenuHeading";
this.content.appendChild(a)
},addMenuBreak:function(){var a=document.createElement("div");
a.className="ricoMenuBreak";
this.content.appendChild(a)
},addSubMenuItem:function(b,e,g){var d=this.direction=="rtl"?"left":"right";
var c=this.addMenuItem(b,null,true,null,g);
c.className="ricoSubMenu";
var f=c.appendChild(document.createElement("div"));
f.className="rico-icon rico-"+d+"-"+this.options.arrowColor;
Rico.setStyle(f,{position:"absolute",top:"2px"});
f.style[d]="0px";
c.RicoSubmenu=e;
Rico.eventBind(c,"mouseover",Rico.eventHandle(this,"showSubMenu"))
},showSubMenu:function(c){if(this.openSubMenu){this.hideSubMenu()
}var b=Rico.eventElement(c);
if(!b.RicoSubmenu){b=b.parentNode
}if(!b.RicoSubmenu){return
}this.openSubMenu=b.RicoSubmenu;
this.openMenuAnchor=b;
if(Rico.hasClass(b,"ricoSubMenu")){Rico.removeClass(b,"ricoSubMenu");
Rico.addClass(b,"ricoSubMenuOpen")
}b.RicoSubmenu.openmenu(parseInt(this.container.style.left)+b.offsetWidth,parseInt(this.container.style.top)+b.offsetTop,b.offsetWidth-2,b.offsetHeight+2,true)
},hideSubMenu:function(){if(this.openMenuAnchor){Rico.removeClass(this.openMenuAnchor,"ricoSubMenuOpen");
Rico.addClass(this.openMenuAnchor,"ricoSubMenu");
this.openMenuAnchor=null
}if(this.openSubMenu){this.openSubMenu.hidemenu();
this.openSubMenu=null
}},addMenuItemId:function(c,b,a,e,d){if(arguments.length<3){a=true
}this.addMenuItem(Rico.getPhraseById(c),b,a,e,d)
},addMenuItem:function(b,e,d,g,f){if(arguments.length>=3&&!d&&!this.options.showDisabled){return null
}this.itemCount++;
var c=document.createElement(typeof e=="string"?"a":"div");
if(arguments.length<3||d){if(typeof e=="string"){c.href=e;
if(f){c.target=f
}}else{if(f=="event"){Rico.eventBind(c,"click",e)
}else{c.onclick=e
}}c.className="enabled";
if(this.defaultAction==null){this.defaultAction=e
}}else{c.disabled=true;
c.className="disabled"
}c.innerHTML=b;
if(typeof g=="string"){c.title=g
}c=this.content.appendChild(c);
Rico.eventBind(c,"mouseover",Rico.eventHandle(this,"mouseOver"));
Rico.eventBind(c,"mouseout",Rico.eventHandle(this,"mouseOut"));
return c
},mouseOver:function(b){if(this.highlightElem&&this.highlightElem.className=="enabled-hover"){this.highlightElem.className="enabled";
this.highlightElem=null
}var a=Rico.eventElement(b);
if(a.parentNode==this.openMenuAnchor){a=a.parentNode
}if(this.openMenuAnchor&&this.openMenuAnchor!=a){this.hideSubMenu()
}if(a.className=="enabled"){a.className="enabled-hover";
this.highlightElem=a
}},mouseOut:function(b){var a=Rico.eventElement(b);
if(a.className=="enabled-hover"){a.className="enabled"
}if(this.highlightElem==a){this.highlightElem=null
}},cancelmenu:function(){if(!this.visible()){return
}if(this.hideFunc){this.hideFunc()
}this.hideFunc=null;
this.hidemenu()
},hidemenu:function(){if(this.openSubMenu){this.openSubMenu.hidemenu()
}this.closePopup()
}};
Rico.SelectionSet=function(b,a){this.initialize(b,a)
};
Rico.SelectionSet.prototype={initialize:function(e,b){Rico.log("SelectionSet#initialize");
this.options=b||{};
if(typeof e=="string"){e=Rico.select(e)
}this.previouslySelected=[];
this.selectionSet=[];
this.selectedClassName=this.options.selectedClass||Rico.theme.selected||"selected";
this.selectNode=this.options.selectNode||function(f){return f
};
this.onSelect=this.options.onSelect;
this.onFirstSelect=this.options.onFirstSelect;
var a=this;
this.clickHandler=function(f){a.selectIndex(f)
};
this.selectedIndex=-1;
for(var c=0;
c<e.length;
c++){this.add(e[c])
}if(!this.options.noDefault){var d=this.options.cookieName?this.getCookie():0;
this.selectIndex(d||this.options.selectedIndex||0)
}},getCookie:function(){var b=Rico.getCookie(this.options.cookieName);
if(!b){return 0
}var a=parseInt(b);
return a<this.selectionSet.length?a:0
},reset:function(){this.previouslySelected=[];
this._notifySelected(this.selectedIndex)
},clearSelected:function(){if(this.selected){Rico.removeClass(this.selectNode(this.selected),this.selectedClassName)
}},getIndex:function(b){for(var a=0;
a<this.selectionSet.length;
a++){if(b==this.selectionSet[a]){return a
}}return -1
},select:function(b){if(this.selected==b){return
}var a=this.getIndex(b);
if(a>=0){this.selectIndex(a)
}},_notifySelected:function(a){if(a<0){return
}var b=this.selectionSet[a];
if(this.options.cookieName){Rico.setCookie(this.options.cookieName,a,this.options.cookieDays,this.options.cookiePath,this.options.cookieDomain)
}if(this.onFirstSelect&&!this.previouslySelected[a]){this.onFirstSelect(b,a);
this.previouslySelected[a]=true
}if(this.onSelect){try{this.onSelect(a)
}catch(c){}}},selectIndex:function(a){if(this.selectedIndex==a||a>=this.selectionSet.length){return
}this.clearSelected();
this._notifySelected(a);
this.selectedIndex=a;
this.selected=this.selectionSet[a].element;
Rico.addClass(this.selectNode(this.selected),this.selectedClassName)
},nextSelectIndex:function(){return(this.selectedIndex+1)%this.selectionSet.length
},nextSelectItem:function(){return this.selectionSet[this.nextSelectIndex()]
},selectNext:function(){this.selectIndex(this.nextSelectIndex())
},add:function(b){var a=this.selectionSet.length;
this.selectionSet[a]=new Rico._SelectionItem(b,a,this.clickHandler)
},remove:function(b){if(b==this.selected){this.clearSelected()
}var a=this.getIndex(b);
if(a<0){return
}this.selectionSet[a].remove();
this.selectionSet.splice(a,1)
},removeAll:function(){this.clearSelected();
while(this.selectionSet.length>0){this.selectionSet.pop().remove()
}}};
Rico._SelectionItem=function(b,a,c){this.add(b,a,c)
};
Rico._SelectionItem.prototype={add:function(b,a,c){this.element=b;
this.index=a;
this.callback=c;
this.handle=Rico.eventHandle(this,"click");
Rico.eventBind(b,"click",this.handle)
},click:function(a){this.callback(this.index)
},remove:function(){Rico.eventUnbind(this.element,"click",this.handle)
}};
Rico.HoverSet=function(b,a){this.initialize(b,a)
};
Rico.HoverSet.prototype={initialize:function(c,a){Rico.log("HoverSet#initialize");
a=a||{};
this.hoverClass=a.hoverClass||Rico.theme.hover||"hover";
this.hoverFunc=a.hoverNodes||function(d){return[d]
};
this.hoverSet=[];
if(!c){return
}for(var b=0;
b<c.length;
b++){this.add(c[b])
}},add:function(a){this.hoverSet.push(new Rico._HoverItem(a,this.hoverFunc,this.hoverClass))
},removeAll:function(){while(this.hoverSet.length>0){this.hoverSet.pop().remove()
}}};
Rico._HoverItem=function(b,a,c){this.add(b,a,c)
};
Rico._HoverItem.prototype={add:function(b,a,c){this.element=b;
this.selectFunc=a;
this.hoverClass=c;
this.movehandle=Rico.eventHandle(this,"move");
this.outhandle=Rico.eventHandle(this,"mouseout");
Rico.eventBind(b,"mousemove",this.movehandle);
Rico.eventBind(b,"mouseout",this.outhandle)
},move:function(c){var a=this.selectFunc(this.element);
for(var b=0;
b<a.length;
b++){Rico.addClass(a[b],this.hoverClass)
}},mouseout:function(c){var a=this.selectFunc(this.element);
for(var b=0;
b<a.length;
b++){Rico.removeClass(a[b],this.hoverClass)
}},remove:function(){Rico.eventUnbind(element,"mousemove",this.movehandle);
Rico.eventUnbind(element,"mouseout",this.outhandle)
}};
Rico.ContentTransitionBase=function(){};
Rico.ContentTransitionBase.prototype={initBase:function(e,d,b){this.options=b||{};
this.titles=e;
this.contents=d;
this.hoverSet=new Rico.HoverSet(e,b);
for(var c=0;
c<d.length;
c++){if(d[c]){Rico.hide(d[c])
}}var a=this;
this.selectionSet=new Rico.SelectionSet(e,Rico.extend(b,{onSelect:function(f){a._finishSelect(f)
}}))
},reset:function(){this.selectionSet.reset()
},select:function(a){this.selectionSet.selectIndex(a)
},_finishSelect:function(b){Rico.log("ContentTransitionBase#_finishSelect");
var a=this.contents[b];
if(!a){alert("Internal error: no panel @index="+b);
return
}if(this.selected==a){return
}if(this.transition){if(this.selected){this.transition(a)
}else{a.style.display="block"
}}else{if(this.selected){Rico.hide(this.selected)
}a.style.display="block"
}this.selected=a
},addBase:function(b,a){this.titles.push(b);
this.contents.push(a);
this.hoverSet.add(b);
this.selectionSet.add(b);
Rico.hide(a)
},removeAll:function(){this.hoverSet.removeAll();
this.selectionSet.removeAll()
}};
Rico.Accordion=function(b,a){this.initialize(b,a)
};
Rico.Accordion.prototype=Rico.extend(new Rico.ContentTransitionBase(),{initialize:function(g,e){g=Rico.$(g);
g.style.overflow="hidden";
g.className=e.accClass||Rico.theme.accordion||"Rico_accordion";
if(typeof e.panelWidth=="number"){e.panelWidth+="px"
}if(e.panelWidth){g.style.width=e.panelWidth
}var d=Rico.getDirectChildrenByTag(g,"div");
var c,j=[],h=[];
for(var f=0;
f<d.length;
f++){c=Rico.getDirectChildrenByTag(d[f],"div");
if(c.length>=2){c[0].className=e.titleClass||Rico.theme.accTitle||"Rico_accTitle";
c[1].className=e.contentClass||Rico.theme.accContent||"Rico_accContent";
j.push(c[0]);
h.push(c[1]);
var b=Rico.wrapChildren(c[0],"","","a");
b.href="javascript:void(0)"
}}Rico.log("creating Rico.Accordion for "+g.id+" with "+j.length+" panels");
this.initBase(j,h,e);
this.selected.style.height=this.options.panelHeight+"px";
this.totSteps=(typeof e.duration=="number"?e.duration:200)/25
},transition:function(b){if(!this.options.noAnimate){this.closing=this.selected;
this.opening=b;
this.curStep=0;
var a=this;
this.timer=setInterval(function(){a.step()
},25)
}else{b.style.height=this.options.panelHeight+"px";
if(this.selected){Rico.hide(this.selected)
}b.style.display="block"
}},step:function(){this.curStep++;
var a=Math.round(this.curStep/this.totSteps*this.options.panelHeight);
this.opening.style.height=a+"px";
this.closing.style.height=(this.options.panelHeight-a)+"px";
if(this.curStep==1){this.opening.style.paddingTop=this.opening.style.paddingBottom="0px";
this.opening.style.display="block"
}if(this.curStep==this.totSteps){clearInterval(this.timer);
this.opening.style.paddingTop=this.opening.style.paddingBottom="";
Rico.hide(this.closing)
}},setPanelHeight:function(a){this.options.panelHeight=a;
this.selected.style.height=this.options.panelHeight+"px"
}});
Rico.TabbedPanel=function(b,a){this.initialize(b,a)
};
Rico.TabbedPanel.prototype=Rico.extend(new Rico.ContentTransitionBase(),{initialize:function(d,l){d=Rico.$(d);
l=l||{};
if(typeof l.panelWidth=="number"){l.panelWidth+="px"
}if(typeof l.panelHeight=="number"){l.panelHeight+="px"
}d.className=l.tabClass||Rico.theme.tabPanel||"Rico_tabPanel";
if(l.panelWidth){d.style.width=l.panelWidth
}var g=[];
var k=d.childNodes;
for(var e=0;
e<k.length;
e++){if(k[e]&&k[e].tagName&&k[e].tagName.match(/^div|ul$/i)){g.push(k[e])
}}if(g.length<2){return
}var c=g[0].tagName.toLowerCase()=="ul"?"li":"div";
g[0].className=l.navContainerClass||Rico.theme.tabNavContainer||"Rico_tabNavContainer";
g[0].style.listStyle="none";
g[1].className=l.contentContainerClass||Rico.theme.tabContentContainer||"Rico_tabContentContainer";
var f=Rico.getDirectChildrenByTag(g[0],c);
var b=Rico.getDirectChildrenByTag(g[1],"div");
var j=Rico.direction(d);
if(!l.corners){l.corners="top"
}for(var e=0;
e<f.length;
e++){if(j=="rtl"){Rico.setStyle(f[e],{"float":"right"})
}f[e].className=l.titleClass||Rico.theme.tabTitle||"Rico_tabTitle";
var h=Rico.wrapChildren(f[e],"","","a");
h.href="javascript:void(0)";
b[e].className=l.contentClass||Rico.theme.tabContent||"Rico_tabContent";
if(l.panelHeight){b[e].style.overflow="auto"
}if(l.corners!="none"){if(l.panelHdrWidth){f[e].style.width=l.panelHdrWidth
}Rico.Corner.round(f[e],Rico.theme.tabCornerOptions||l)
}}l.selectedClass=Rico.theme.tabSelected||"selected";
this.initBase(f,b,l);
if(this.selected){this.transition(this.selected)
}},transition:function(a){Rico.log("TabbedPanel#transition "+typeof(a));
if(this.selected){Rico.hide(this.selected)
}Rico.show(a);
if(this.options.panelHeight){a.style.height=this.options.panelHeight
}}});
Rico.Corner={round:function(b,a){b=Rico.$(b);
this.options={corners:"all",bgColor:"fromParent",compact:false,nativeCorners:false};
Rico.extend(this.options,a||{});
if(typeof(Rico.getStyle(b,"border-radius"))=="string"){this._roundCornersStdCss(b)
}else{if(typeof(Rico.getStyle(b,"-webkit-border-radius"))=="string"){this._roundCornersWebKit(b)
}else{if(typeof(Rico.getStyle(b,"-moz-border-radius"))=="string"){this._roundCornersMoz(b)
}else{if(!this.options.nativeCorners){this._roundCornersImpl(b)
}}}}},_roundCornersStdCss:function(b){var a=this.options.compact?"4px":"8px";
if(this._hasString(this.options.corners,"all")){Rico.setStyle(b,{borderRadius:a})
}else{if(this._hasString(this.options.corners,"top","tl")){Rico.setStyle(b,{borderTopLeftRadius:a})
}if(this._hasString(this.options.corners,"top","tr")){Rico.setStyle(b,{borderTopRightRadius:a})
}if(this._hasString(this.options.corners,"bottom","bl")){Rico.setStyle(b,{borderBottomLeftRadius:a})
}if(this._hasString(this.options.corners,"bottom","br")){Rico.setStyle(b,{borderBottomRightRadius:a})
}}},_roundCornersWebKit:function(b){var a=this.options.compact?"4px":"8px";
if(this._hasString(this.options.corners,"all")){Rico.setStyle(b,{WebkitBorderRadius:a})
}else{if(this._hasString(this.options.corners,"top","tl")){Rico.setStyle(b,{WebkitBorderTopLeftRadius:a})
}if(this._hasString(this.options.corners,"top","tr")){Rico.setStyle(b,{WebkitBorderTopRightRadius:a})
}if(this._hasString(this.options.corners,"bottom","bl")){Rico.setStyle(b,{WebkitBorderBottomLeftRadius:a})
}if(this._hasString(this.options.corners,"bottom","br")){Rico.setStyle(b,{WebkitBorderBottomRightRadius:a})
}}},_roundCornersMoz:function(b){var a=this.options.compact?"4px":"8px";
if(this._hasString(this.options.corners,"all")){Rico.setStyle(b,{MozBorderRadius:a})
}else{if(this._hasString(this.options.corners,"top","tl")){Rico.setStyle(b,{MozBorderRadiusTopleft:a})
}if(this._hasString(this.options.corners,"top","tr")){Rico.setStyle(b,{MozBorderRadiusTopright:a})
}if(this._hasString(this.options.corners,"bottom","bl")){Rico.setStyle(b,{MozBorderRadiusBottomleft:a})
}if(this._hasString(this.options.corners,"bottom","br")){Rico.setStyle(b,{MozBorderRadiusBottomright:a})
}}},_roundCornersImpl:function(b){var a=this.options.bgColor=="fromParent"?this._background(b.parentNode):this.options.bgColor;
b.style.position="relative";
if(this._hasString(this.options.corners,"all","top","tl")){this._createCorner(b,"top","left",a)
}if(this._hasString(this.options.corners,"all","top","tr")){this._createCorner(b,"top","right",a)
}if(this._hasString(this.options.corners,"all","bottom","bl")){this._createCorner(b,"bottom","left",a)
}if(this._hasString(this.options.corners,"all","bottom","br")){this._createCorner(b,"bottom","right",a)
}},_createCorner:function(b,c,f,k){var n=document.createElement("div");
n.className="ricoCorner";
Rico.setStyle(n,{width:"6px",height:"5px"});
var o=Rico.getStyle(b,"border-"+c+"-style");
var a=o=="none"?k:Rico.getStyle(b,"border-"+c+"-color");
var j=o=="none"?"0px":"-1px";
n.style[c]=j;
n.style[f]=Rico.isIE&&Rico.ieVersion<7&&f=="right"&&o!="none"?"-2px":"-1px";
b.appendChild(n);
var h=[0,2,3,4,4];
if(c=="bottom"){h.reverse()
}var m=o=="none"?"0px none":"1px solid "+a;
var g=f=="left"?"Right":"Left";
for(var e=0;
e<h.length;
e++){var l=document.createElement("div");
Rico.setStyle(l,{backgroundColor:k,height:"1px"});
l.style["margin"+g]=h[e]+"px";
l.style["border"+g]=m;
n.appendChild(l)
}},_background:function(c){try{var a=Rico.getStyle(c,"backgroundColor");
if(a.match(/^(transparent|rgba\(0,\s*0,\s*0,\s*0\))$/i)&&c.parentNode){return this._background(c.parentNode)
}return a==null?"#ffffff":a
}catch(b){return"#ffffff"
}},_hasString:function(b){for(var a=1;
a<arguments.length;
a++){if(b.indexOf(arguments[a])>=0){return true
}}return false
}};
Rico.toColorPart=function(a){return Rico.zFill(a,2,16)
};
Rico.Color=function(c,b,a){this.initialize(c,b,a)
};
Rico.Color.prototype={initialize:function(c,b,a){this.rgb={r:c,g:b,b:a}
},setRed:function(a){this.rgb.r=a
},setGreen:function(a){this.rgb.g=a
},setBlue:function(a){this.rgb.b=a
},setHue:function(b){var a=this.asHSB();
a.h=b;
this.rgb=Rico.Color.HSBtoRGB(a.h,a.s,a.b)
},setSaturation:function(b){var a=this.asHSB();
a.s=b;
this.rgb=Rico.Color.HSBtoRGB(a.h,a.s,a.b)
},setBrightness:function(a){var c=this.asHSB();
c.b=a;
this.rgb=Rico.Color.HSBtoRGB(c.h,c.s,c.b)
},darken:function(b){var a=this.asHSB();
this.rgb=Rico.Color.HSBtoRGB(a.h,a.s,Math.max(a.b-b,0))
},brighten:function(b){var a=this.asHSB();
this.rgb=Rico.Color.HSBtoRGB(a.h,a.s,Math.min(a.b+b,1))
},blend:function(a){this.rgb.r=Math.floor((this.rgb.r+a.rgb.r)/2);
this.rgb.g=Math.floor((this.rgb.g+a.rgb.g)/2);
this.rgb.b=Math.floor((this.rgb.b+a.rgb.b)/2)
},isBright:function(){var a=this.asHSB();
return this.asHSB().b>0.5
},isDark:function(){return !this.isBright()
},asRGB:function(){return"rgb("+this.rgb.r+","+this.rgb.g+","+this.rgb.b+")"
},asHex:function(){return"#"+Rico.toColorPart(this.rgb.r)+Rico.toColorPart(this.rgb.g)+Rico.toColorPart(this.rgb.b)
},asHSB:function(){return Rico.Color.RGBtoHSB(this.rgb.r,this.rgb.g,this.rgb.b)
},toString:function(){return this.asHex()
}};
Rico.Color.createFromHex=function(d){if(d.length==4){var b=d;
d="#";
for(var c=1;
c<4;
c++){d+=(b.charAt(c)+b.charAt(c))
}}if(d.indexOf("#")==0){d=d.substring(1)
}if(!d.match(/^[0-9A-Fa-f]{6}$/)){return null
}var f=d.substring(0,2);
var e=d.substring(2,4);
var a=d.substring(4,6);
return new Rico.Color(parseInt(f,16),parseInt(e,16),parseInt(a,16))
};
Rico.Color.createColorFromBackground=function(d){if(!d.style){return new Rico.Color(255,255,255)
}var b=Rico.getStyle(d,"background-color");
if(b.match(/^(transparent|rgba\(0,\s*0,\s*0,\s*0\))$/i)&&d.parentNode){return Rico.Color.createColorFromBackground(d.parentNode)
}if(b==null){return new Rico.Color(255,255,255)
}if(b.indexOf("rgb(")==0){var a=b.substring(4,b.length-1);
var c=a.split(",");
return new Rico.Color(parseInt(c[0],10),parseInt(c[1],10),parseInt(c[2],10))
}else{if(b.indexOf("#")==0){return Rico.Color.createFromHex(b)
}else{return new Rico.Color(255,255,255)
}}};
Rico.Color.HSBtoRGB=function(i,e,k){var c=0;
var d=0;
var l=0;
if(e==0){c=parseInt(k*255+0.5,10);
d=c;
l=c
}else{var g=(i-Math.floor(i))*6;
var j=g-Math.floor(g);
var b=k*(1-e);
var a=k*(1-e*j);
var m=k*(1-(e*(1-j)));
switch(parseInt(g,10)){case 0:c=(k*255+0.5);
d=(m*255+0.5);
l=(b*255+0.5);
break;
case 1:c=(a*255+0.5);
d=(k*255+0.5);
l=(b*255+0.5);
break;
case 2:c=(b*255+0.5);
d=(k*255+0.5);
l=(m*255+0.5);
break;
case 3:c=(b*255+0.5);
d=(a*255+0.5);
l=(k*255+0.5);
break;
case 4:c=(m*255+0.5);
d=(b*255+0.5);
l=(k*255+0.5);
break;
case 5:c=(k*255+0.5);
d=(b*255+0.5);
l=(a*255+0.5);
break
}}return{r:parseInt(c,10),g:parseInt(d,10),b:parseInt(l,10)}
};
Rico.Color.RGBtoHSB=function(a,f,l){var h;
var e;
var k;
var m=(a>f)?a:f;
if(l>m){m=l
}var i=(a<f)?a:f;
if(l<i){i=l
}k=m/255;
if(m!=0){e=(m-i)/m
}else{e=0
}if(e==0){h=0
}else{var c=(m-a)/(m-i);
var j=(m-f)/(m-i);
var d=(m-l)/(m-i);
if(a==m){h=d-j
}else{if(f==m){h=2+c-d
}else{h=4+j-c
}}h=h/6;
if(h<0){h=h+1
}}return{h:h,s:e,b:k}
};
Rico.createXmlDocument=function(){if(document.implementation&&document.implementation.createDocument){var a=document.implementation.createDocument("","",null);
if(a.readyState==null){a.readyState=1;
a.addEventListener("load",function(){a.readyState=4;
if(typeof a.onreadystatechange=="function"){a.onreadystatechange()
}},false)
}return a
}if(window.ActiveXObject){return Rico.tryFunctions(function(){return new ActiveXObject("MSXML2.DomDocument")
},function(){return new ActiveXObject("Microsoft.DomDocument")
},function(){return new ActiveXObject("MSXML.DomDocument")
},function(){return new ActiveXObject("MSXML3.DomDocument")
})||false
}return null
};
Rico.CalendarControl=function(b,a){this.initialize(b,a)
};
Rico.CalendarControl.prototype={initialize:function(d,c){this.id=d;
var b=new Date();
this.defaultMin=new Date(b.getFullYear()-50,0,1);
this.defaultMax=new Date(b.getFullYear()+50,11,31);
Rico.extend(this,new Rico.Popup());
Rico.extend(this.options,{ignoreClicks:true,startAt:0,showWeekNumber:0,showToday:1,dateFmt:"ISO8601",minDate:this.defaultMin,maxDate:this.defaultMax});
Rico.extend(this.options,c||{});
this.bPageLoaded=false;
this.Holidays={};
this.re=/^\s*(\w+)(\W)(\w+)(\W)(\w+)/i;
this.setDateFmt(this.options.dateFmt);
var a=this;
Rico.onLoad(function(){a.atLoad()
})
},setDateFmt:function(a){this.dateFmt=(a=="rico")?Rico.dateFmt:a;
Rico.log(this.id+" date format set to "+this.dateFmt);
this.dateParts={};
if(this.re.exec(this.dateFmt)){this.dateParts[RegExp.$1]=0;
this.dateParts[RegExp.$3]=1;
this.dateParts[RegExp.$5]=2
}},addHoliday:function(f,a,g,e,c,b){this.Holidays[this.holidayKey(g,a-1,f)]={desc:e,txtColor:b,bgColor:c||"#DDF"}
},holidayKey:function(c,a,b){return"h"+Rico.zFill(c,4)+Rico.zFill(a,2)+Rico.zFill(b,2)
},atLoad:function(){Rico.log("Calendar#atLoad: "+this.id);
var d=Rico.$(this.id);
if(d){this.setDiv(d)
}else{this.createContainer();
this.container.id=this.id
}Rico.addClass(this.content,Rico.theme.calendar||"ricoCalContainer");
this.direction=Rico.direction(this.container);
var b,h,g,f,n,l,o,e;
this.colStart=this.options.showWeekNumber?1:0;
var k=7+this.colStart;
this.maintab=document.createElement("table");
this.maintab.cellSpacing=2;
this.maintab.cellPadding=0;
this.maintab.border=0;
this.maintab.style.borderCollapse="separate";
this.maintab.className=Rico.theme.calendarTable||"ricoCalTab";
this.thead=this.maintab.createTHead();
b=this.thead.insertRow(-1);
this.heading=b.insertCell(-1);
this.heading.colSpan=k;
this.heading.className="RicoCalHeading";
if(Rico.theme.calendarHeading){Rico.addClass(this.heading,Rico.theme.calendarHeading)
}if(this.options.showToday){this.tfoot=this.maintab.createTFoot();
this.tfoot.className="ricoCalFoot";
b=this.tfoot.insertRow(-1);
this.todayCell=b.insertCell(-1);
this.todayCell.colSpan=k;
this.todayCell.className=Rico.theme.calendarFooter||"ricoCalFoot";
Rico.eventBind(this.todayCell,"click",Rico.eventHandle(this,"selectNow"),false)
}this.tbody=Rico.getTBody(this.maintab);
this.tbody.className="ricoCalBody";
this.content.style.display="block";
if(this.position=="absolute"){this.content.style.width="auto";
this.maintab.style.width="auto"
}else{this.container.style.position="relative";
this.heading.style.position="static";
this.content.style.padding="0px";
this.content.style.width="15em";
this.maintab.style.width="100%"
}this.styles=[];
for(g=0;
g<7;
g++){b=this.tbody.insertRow(-1);
b.className=g==0?"ricoCalDayNames":"row"+g;
if(this.options.showWeekNumber){h=b.insertCell(-1);
h.className="ricoCalWeekNum";
if(g==0){h.innerHTML=Rico.getPhraseById("calWeekHdg")
}}for(f=0;
f<7;
f++){h=b.insertCell(-1);
if(g==0){n=(f+this.options.startAt)%7;
h.innerHTML=Rico.dayAbbr(n);
this.styles[f]="ricoCal"+n
}else{h.className=this.styles[f];
if(Rico.theme.calendarDay){Rico.addClass(h,Rico.theme.calendarDay)
}}}}this.content.appendChild(this.maintab);
new Rico.HoverSet(this.tbody.getElementsByTagName("td"),{hoverNodes:function(a){return a.innerHTML.match(/^\d+$/)?[a]:[]
}});
this.navtab=this.heading.appendChild(document.createElement("table"));
this.navrow=this.navtab.insertRow(-1);
this._createTitleSection("Month");
this.navrow.insertCell(-1).innerHTML="&nbsp;&nbsp;";
this._createTitleSection("Year");
new Rico.HoverSet(this.heading.getElementsByTagName("a"));
if(this.position=="absolute"){this.heading.appendChild(Rico.closeButton(Rico.eventHandle(this,"close")))
}this.monthPopup=new Rico.Popup(document.createElement("div"),{shim:false,zIndex:10});
this.monthPopup.content.className="ricoCalMonthPrompt";
e=document.createElement("table");
e.className="ricoCalMenu";
if(Rico.theme.calendarPopdown){Rico.addClass(e,Rico.theme.calendarPopdown)
}e.cellPadding=2;
e.cellSpacing=0;
e.border=0;
e.style.borderCollapse="separate";
e.style.margin="0px";
for(g=0;
g<4;
g++){b=e.insertRow(-1);
for(f=0;
f<3;
f++){h=b.insertCell(-1);
l=document.createElement("a");
l.innerHTML=Rico.monthAbbr(g*3+f);
l.name=g*3+f;
if(Rico.theme.calendarDay){Rico.addClass(l,Rico.theme.calendarDay)
}h.appendChild(l);
Rico.eventBind(l,"click",Rico.eventHandle(this,"selectMonth"),false)
}}new Rico.HoverSet(e.getElementsByTagName("a"));
this.monthPopup.content.appendChild(e);
this.container.appendChild(this.monthPopup.container);
this.monthPopup.closePopup();
this.yearPopup=new Rico.Popup(document.createElement("div"),{shim:false,zIndex:10});
this.yearPopup.content.className="ricoCalYearPrompt";
if(Rico.theme.calendarPopdown){Rico.addClass(this.yearPopup.content,Rico.theme.calendarPopdown)
}this.yearPrompt=document.createElement("p");
this.yearPrompt.innerHTML="&nbsp;";
var m=document.createElement("p");
this.yearInput=m.appendChild(document.createElement("input"));
this.yearInput.maxlength=4;
this.yearInput.size=4;
Rico.eventBind(this.yearInput,"keyup",Rico.eventHandle(this,"yearKey"),false);
l=Rico.floatButton("Checkmark",Rico.eventHandle(this,"processPopUpYear"));
m.appendChild(l);
l=Rico.floatButton("Cancel",Rico.eventHandle(this,"popDownYear"));
m.appendChild(l);
this.yearPopup.content.appendChild(this.yearPrompt);
this.yearPopup.content.appendChild(m);
this.container.appendChild(this.yearPopup.container);
this.yearPopup.closePopup();
l=this.content.getElementsByTagName("a");
for(g=0;
g<l.length;
g++){l[g].href="javascript:void(0)"
}Rico.eventBind(this.tbody,"click",Rico.eventHandle(this,"saveAndClose"));
this.bPageLoaded=true
},_createTitleSection:function(e){var d=["left","right"];
if(this.direction=="rtl"){d.reverse()
}var f=this.navrow.insertCell(-1);
var b=f.appendChild(document.createElement("a"));
b.className="Rico_"+d[0]+"Arrow";
b.appendChild(this._createNavArrow(d[0]));
Rico.eventBind(b,"click",Rico.eventHandle(this,"dec"+e),false);
f=this.navrow.insertCell(-1);
b=f.appendChild(document.createElement("a"));
Rico.eventBind(b,"click",Rico.eventHandle(this,"popUp"+e),false);
this["title"+e]=b;
f=this.navrow.insertCell(-1);
b=f.appendChild(document.createElement("a"));
b.className="Rico_"+d[1]+"Arrow";
b.appendChild(this._createNavArrow(d[1]));
Rico.eventBind(b,"click",Rico.eventHandle(this,"inc"+e),false)
},_createNavArrow:function(b){var a=document.createElement("span");
a.className=Rico.theme[b+"Arrow"]||"rico-icon Rico_"+b+"Arrow";
a.style.display="inline-block";
return a
},selectNow:function(){var a=new Date();
this.dateNow=a.getDate();
this.monthNow=a.getMonth();
this.yearNow=a.getFullYear();
this.monthSelected=this.monthNow;
this.yearSelected=this.yearNow;
this.constructCalendar()
},isValidMonth:function(a,b){if(a<this.options.minDate.getFullYear()){return false
}if(a==this.options.minDate.getFullYear()&&b<this.options.minDate.getMonth()){return false
}if(a>this.options.maxDate.getFullYear()){return false
}if(a==this.options.maxDate.getFullYear()&&b>this.options.maxDate.getMonth()){return false
}return true
},incMonth:function(b){if(b){Rico.eventStop(b)
}var c=this.monthSelected+1;
var a=this.yearSelected;
if(c>11){c=0;
a++
}if(!this.isValidMonth(a,c)){return
}this.monthSelected=c;
this.yearSelected=a;
this.constructCalendar()
},decMonth:function(b){if(b){Rico.eventStop(b)
}var c=this.monthSelected-1;
var a=this.yearSelected;
if(c<0){c=11;
a--
}if(!this.isValidMonth(a,c)){return
}this.monthSelected=c;
this.yearSelected=a;
this.constructCalendar()
},selectMonth:function(b){var a=Rico.eventElement(b);
this.monthSelected=parseInt(a.name,10);
this.constructCalendar();
Rico.eventStop(b)
},openYrMo:function(b,a){if(this.direction=="rtl"){a=1-a
}b.openPopup();
var c=a?this.content.offsetWidth-b.container.offsetWidth-5:3;
b.move(c,this.heading.offsetHeight+2)
},popUpMonth:function(a){Rico.eventStop(a);
if(this.monthPopup.visible()){this.popDownMonth();
return false
}this.popDownYear();
this.openYrMo(this.monthPopup,0);
return false
},popDownMonth:function(){this.monthPopup.closePopup()
},popDownYear:function(){this.yearPopup.closePopup();
this.yearInput.disabled=true
},popUpYear:function(b){Rico.eventStop(b);
if(this.yearPopup.visible()){this.popDownYear();
return false
}this.popDownMonth();
this.yearPrompt.innerHTML=Rico.getPhraseById("calYearRange",this.options.minDate.getFullYear(),this.options.maxDate.getFullYear());
this.yearInput.disabled=false;
this.yearInput.value="";
this.openYrMo(this.yearPopup,1);
var a=this;
setTimeout(function(){a.yearInput.focus()
},10);
return false
},yearKey:function(a){switch(Rico.eventKey(a)){case 27:this.popDownYear();
Rico.eventStop(a);
return false;
case 13:this.processPopUpYear();
Rico.eventStop(a);
return false
}return true
},processPopUpYear:function(){var a=this.yearInput.value;
a=parseInt(a,10);
if(isNaN(a)||a<this.options.minDate.getFullYear()||a>this.options.maxDate.getFullYear()){alert(Rico.getPhraseById("calInvalidYear"))
}else{this.yearSelected=a;
this.popDownYear();
this.constructCalendar()
}},incYear:function(a){if(a){Rico.eventStop(a)
}if(this.yearSelected>=this.options.maxDate.getFullYear()){return
}this.yearSelected++;
this.constructCalendar()
},decYear:function(a){if(a){Rico.eventStop(a)
}if(this.yearSelected<=this.options.minDate.getFullYear()){return
}this.yearSelected--;
this.constructCalendar()
},WeekNbr:function(h,f,j){var g=new Date(h,f,j);
var c=new Date(h,0,1);
var e=7+1-c.getDay();
if(e==8){e=1
}var b=((Date.UTC(h,g.getMonth(),g.getDate(),0,0,0)-Date.UTC(h,0,1,0,0,0))/1000/60/60/24)+1;
var d=Math.floor((b-e+7)/7);
if(d==0){h--;
var a=new Date(h,0,1);
var i=7+1-a.getDay();
d=(i==2||i==8)?53:52
}return d
},constructCalendar:function(){var l=[31,0,31,30,31,30,31,31,30,31,30,31];
var d=new Date(this.yearSelected,this.monthSelected,1);
var j,e,f,b;
if(typeof this.monthSelected!="number"||this.monthSelected>=12||this.monthSelected<0){alert("ERROR in calendar: monthSelected="+this.monthSelected);
return
}if(this.monthSelected==1){j=new Date(this.yearSelected,this.monthSelected+1,1);
j=new Date(j-(24*60*60*1000));
e=j.getDate()
}else{e=l[this.monthSelected]
}var n=d.getDay()-this.options.startAt;
if(n<0){n+=7
}this.popDownMonth();
this.popDownYear();
if(this.options.showWeekNumber){for(f=1;
f<7;
f++){this.tbody.rows[f].cells[0].innerHTML="&nbsp;"
}}for(f=0;
f<n;
f++){this.resetCell(this.tbody.rows[1].cells[f+this.colStart])
}for(var k=1,a=1;
k<=e;
k++,n++){b=n%7;
if(this.options.showWeekNumber&&b==0){this.tbody.rows[a].cells[0].innerHTML=this.WeekNbr(this.yearSelected,this.monthSelected,k)
}var m=this.tbody.rows[a].cells[b+this.colStart];
m.innerHTML=k;
m.className=this.styles[b];
if((k==this.dateNow)&&(this.monthSelected==this.monthNow)&&(this.yearSelected==this.yearNow)){Rico.addClass(m,Rico.theme.calendarToday||"ricoCalToday")
}if(Rico.theme.calendarDay){Rico.addClass(m,Rico.theme.calendarDay)
}if((k==this.odateSelected)&&(this.monthSelected==this.omonthSelected)&&(this.yearSelected==this.oyearSelected)){Rico.addClass(m,Rico.theme.calendarSelectedDay||"ricoSelectedDay")
}var g=this.Holidays[this.holidayKey(this.yearSelected,this.monthSelected,k)];
if(!g){g=this.Holidays[this.holidayKey(0,this.monthSelected,k)]
}m.style.color=g?g.txtColor:"";
m.style.backgroundColor=g?g.bgColor:"";
m.title=g?g.desc:"";
m.style.visibility="visible";
if(b==6){a++
}}while(n<42){b=n%7;
this.resetCell(this.tbody.rows[a].cells[b+this.colStart]);
n++;
if(b==6){a++
}}this.titleMonth.innerHTML=Rico.monthAbbr(this.monthSelected);
this.titleYear.innerHTML=this.yearSelected;
if(this.todayCell){this.todayCell.innerHTML=Rico.getPhraseById("calToday",this.dateNow,Rico.monthAbbr(this.monthNow),this.yearNow,this.monthNow+1)
}},resetCell:function(a){a.innerHTML="&nbsp;";
a.title="";
a.style.visibility="hidden"
},close:function(a){if(a){Rico.eventStop(a)
}this.closePopup()
},saveAndClose:function(g){Rico.eventStop(g);
var f=Rico.eventElement(g);
var c=f.innerHTML.replace(/&nbsp;/g,"");
if(c==""||f.className=="ricoCalWeekNum"){return
}var b=parseInt(c,10);
if(isNaN(b)){return
}var h=new Date(this.yearSelected,this.monthSelected,b);
var a=Rico.formatDate(h,this.dateFmt=="ISO8601"?"yyyy-mm-dd":this.dateFmt);
if(this.returnValue){this.returnValue(a);
this.closePopup()
}},open:function(c,b){if(!this.bPageLoaded){return
}if(b){this.setDateFmt(b.format.dateFmt);
this.options.minDate=b.format.min||this.defaultMin;
this.options.maxDate=b.format.max||this.defaultMax
}var a=new Date();
this.dateNow=a.getDate();
this.monthNow=a.getMonth();
this.yearNow=a.getFullYear();
this.oyearSelected=-1;
if(typeof c=="object"){this.odateSelected=c.getDate();
this.omonthSelected=c.getMonth();
this.oyearSelected=c.getFullYear()
}else{if(this.dateFmt=="ISO8601"){var e=Rico.setISO8601(c);
if(e){this.odateSelected=e.getDate();
this.omonthSelected=e.getMonth();
this.oyearSelected=e.getFullYear()
}}else{if(this.re.exec(c)){var g=[RegExp.$1,RegExp.$3,RegExp.$5];
this.odateSelected=parseInt(g[this.dateParts.dd],10);
this.omonthSelected=parseInt(g[this.dateParts.mm],10)-1;
this.oyearSelected=parseInt(g[this.dateParts.yyyy],10);
if(this.oyearSelected<100){this.oyearSelected+=this.yearNow-(this.yearNow%100);
var f=this.options.maxDate.getFullYear();
while(this.oyearSelected>f){this.oyearSelected-=100
}}}else{if(c){alert("ERROR: invalid date passed to calendar ("+c+")")
}}}}if(this.oyearSelected>0){this.dateSelected=this.odateSelected;
this.monthSelected=this.omonthSelected;
this.yearSelected=this.oyearSelected
}else{this.dateSelected=this.dateNow;
this.monthSelected=this.monthNow;
this.yearSelected=this.yearNow
}this.constructCalendar();
this.openPopup()
}};
Rico.ColorPicker=function(b,a){this.initialize(b,a)
};
Rico.ColorPicker.prototype={initialize:function(i,d){this.id=i;
this.currentValue="#FFFFFF";
Rico.extend(this,new Rico.Popup());
Rico.extend(this.options,{showColorCode:false,cellsPerRow:18,palette:[]});
var h=["00","33","66","99","CC","FF"];
for(var f=0;
f<h.length;
f++){for(var e=0;
e<h.length;
e++){for(var a=0;
a<h.length;
a++){this.options.palette.push(h[e]+h[f]+h[a])
}}}Rico.extend(this.options,d||{});
var c=this;
Rico.onLoad(function(){c.atLoad()
})
},atLoad:function(){this.createContainer();
this.content.className="ricoColorPicker";
var c=this.options.cellsPerRow;
var d="<TABLE BORDER='1' CELLSPACING='1' CELLPADDING='0'>";
for(var b=0;
b<this.options.palette.length;
b++){if((b%c)==0){d+="<TR>"
}d+='<TD BGCOLOR="#'+this.options.palette[b]+'">&nbsp;</TD>';
if(((b+1)>=this.options.palette.length)||(((b+1)%c)==0)){d+="</TR>"
}}var a=Math.floor(c/2);
if(this.options.showColorCode){d+="<TR><TD COLSPAN='"+a+"' ID='colorPickerSelectedColor'>&nbsp;</TD><TD COLSPAN='"+(c-a)+"' ALIGN='CENTER' ID='colorPickerSelectedColorValue'>#FFFFFF</TD></TR>"
}else{d+="<TR><TD COLSPAN='"+c+"' ID='colorPickerSelectedColor'>&nbsp;</TD></TR>"
}d+="</TABLE>";
this.content.innerHTML=d;
this.open=this.openPopup;
this.close=this.closePopup;
Rico.eventBind(this.container,"mouseover",Rico.eventHandle(this,"highlightColor"),false);
Rico.eventBind(this.container,"click",Rico.eventHandle(this,"selectColor"),false);
this.close()
},selectColor:function(a){Rico.eventStop(a);
if(this.returnValue){this.returnValue(this.currentValue)
}this.close()
},highlightColor:function(b){var a=Rico.eventElement(b);
if(!a.tagName||a.tagName.toLowerCase()!="td"){return
}var g=Rico.Color.createColorFromBackground(a).toString();
this.currentValue=g;
Rico.setStyle("colorPickerSelectedColor",{backgroundColor:g});
var f=Rico.$("colorPickerSelectedColorValue");
if(f){f.innerHTML=g
}}};
Rico.dndMgrList=[];
Rico.registerDraggable=function(b,a){if(typeof a!="number"){a=0
}if(typeof Rico.dndMgrList[a]!="object"){Rico.dndMgrList[a]=new Rico.dndMgr()
}Rico.dndMgrList[a].registerDraggable(b)
};
Rico.registerDropZone=function(b,a){if(typeof a!="number"){a=0
}if(typeof Rico.dndMgrList[a]!="object"){Rico.dndMgrList[a]=new Rico.dndMgr()
}Rico.dndMgrList[a].registerDropZone(b)
};
Rico.dndMgr=function(){this.initialize()
};
Rico.dndMgr.prototype={initialize:function(){this.dropZones=[];
this.draggables=[];
this.currentDragObjects=[];
this.dragElement=null;
this.lastSelectedDraggable=null;
this.currentDragObjectVisible=false;
this.interestedInMotionEvents=false;
this._mouseDown=Rico.eventHandle(this,"_mouseDownHandler");
this._mouseMove=Rico.eventHandle(this,"_mouseMoveHandler");
this._mouseUp=Rico.eventHandle(this,"_mouseUpHandler")
},registerDropZone:function(a){this.dropZones[this.dropZones.length]=a
},deregisterDropZone:function(a){var d=new Array();
var b=0;
for(var c=0;
c<this.dropZones.length;
c++){if(this.dropZones[c]!=a){d[b++]=this.dropZones[c]
}}this.dropZones=d
},clearDropZones:function(){this.dropZones=new Array()
},registerDraggable:function(a){this.draggables[this.draggables.length]=a;
var b=a.getMouseDownHTMLElement();
if(b!=null){b.ricoDraggable=a;
Rico.eventBind(b,"mousedown",Rico.eventHandle(this,"_attachEvents"));
Rico.eventBind(b,"mousedown",this._mouseDown)
}},clearSelection:function(){for(var a=0;
a<this.currentDragObjects.length;
a++){this.currentDragObjects[a].deselect()
}this.currentDragObjects=new Array();
this.lastSelectedDraggable=null
},hasSelection:function(){return this.currentDragObjects.length>0
},setStartDragFromElement:function(a,c){this.origPos=Rico.cumulativeOffset(c);
var b=Rico.eventClient(a);
this.startx=b.x-this.origPos.left;
this.starty=b.y-this.origPos.top;
this.interestedInMotionEvents=this.hasSelection();
Rico.eventStop(a)
},updateSelection:function(a,b){if(!b){this.clearSelection()
}if(a.isSelected()){this.currentDragObjects=this.currentDragObjects.without(a);
a.deselect();
if(a==this.lastSelectedDraggable){this.lastSelectedDraggable=null
}}else{a.select();
if(a.isSelected()){this.currentDragObjects.push(a);
this.lastSelectedDraggable=a
}}},_mouseDownHandler:function(f){if(!Rico.eventLeftClick(f)){return
}var d=Rico.eventElement(f);
var a=d.ricoDraggable;
var c=d;
while(a==null&&c.parentNode){c=c.parentNode;
a=c.ricoDraggable
}if(a==null){return
}this.updateSelection(a,f.ctrlKey);
if(this.hasSelection()){for(var b=0;
b<this.dropZones.length;
b++){this.dropZones[b].clearPositionCache()
}}this.setStartDragFromElement(f,a.getMouseDownHTMLElement())
},_mouseMoveHandler:function(a){if(!this.interestedInMotionEvents){return
}if(!this.hasSelection()){return
}if(!this.currentDragObjectVisible){this._startDrag(a)
}if(!this.activatedDropZones){this._activateRegisteredDropZones()
}this._updateDraggableLocation(a);
this._updateDropZonesHover(a);
Rico.eventStop(a)
},_makeDraggableObjectVisible:function(b){if(!this.hasSelection()){return
}var a;
if(this.currentDragObjects.length>1){a=this.currentDragObjects[0].getMultiObjectDragGUI(this.currentDragObjects)
}else{a=this.currentDragObjects[0].getSingleObjectDragGUI()
}this.dragElemPosition=Rico.getStyle(a,"position");
if(this.dragElemPosition!="absolute"){a.style.position="absolute"
}if(a.parentNode==null||a.parentNode.nodeType==11){document.body.appendChild(a)
}this.dragElement=a;
this._updateDraggableLocation(b);
this.currentDragObjectVisible=true
},_leftOffset:function(a){return a.offsetX?document.body.scrollLeft:0
},_topOffset:function(a){return a.offsetY?document.body.scrollTop:0
},_updateDraggableLocation:function(b){var a=this.dragElement.style;
var c=Rico.eventClient(b);
a.left=(c.x+this._leftOffset(b)-this.startx)+"px";
a.top=(c.y+this._topOffset(b)-this.starty)+"px"
},_updateDropZonesHover:function(b){var a,c=this.dropZones.length;
for(a=0;
a<c;
a++){if(!this._mousePointInDropZone(b,this.dropZones[a])){this.dropZones[a].hideHover()
}}for(a=0;
a<c;
a++){if(this._mousePointInDropZone(b,this.dropZones[a])){if(this.dropZones[a].canAccept(this.currentDragObjects)){this.dropZones[a].showHover()
}}}},_startDrag:function(b){for(var a=0;
a<this.currentDragObjects.length;
a++){this.currentDragObjects[a].startDrag()
}this._makeDraggableObjectVisible(b)
},_mouseUpHandler:function(b){if(!this.hasSelection()){return
}if(!Rico.eventLeftClick(b)){return
}this.interestedInMotionEvents=false;
if(this._placeDraggableInDropZone(b)){this._completeDropOperation(b)
}else{if(this.dragElement!=null){Rico.eventStop(b);
var a=this;
Rico.animate(this.dragElement,{duration:300,onEnd:function(){a._doCancelDragProcessing()
}},{left:this.origPos.left,top:this.origPos.top})
}}Rico.eventUnbind(document.body,"mousemove",this._mouseMove);
Rico.eventUnbind(document.body,"mouseup",this._mouseUp)
},_retTrue:function(){return true
},_completeDropOperation:function(a){if(this.dragElement!=this.currentDragObjects[0].getMouseDownHTMLElement()){if(this.dragElement.parentNode!=null){this.dragElement.parentNode.removeChild(this.dragElement)
}}this._deactivateRegisteredDropZones();
this._endDrag();
this.clearSelection();
this.dragElement=null;
this.currentDragObjectVisible=false;
Rico.eventStop(a)
},_doCancelDragProcessing:function(){this._cancelDrag();
if(this.dragElement==this.currentDragObjects[0].getMouseDownHTMLElement()){this.dragElement.style.position=this.dragElemPosition
}else{if(this.dragElement&&this.dragElement.parentNode!=null){this.dragElement.parentNode.removeChild(this.dragElement)
}}this._deactivateRegisteredDropZones();
this.dragElement=null;
this.currentDragObjectVisible=false
},_placeDraggableInDropZone:function(c){var a=false;
var d=this.dropZones.length;
for(var b=0;
b<d;
b++){if(this._mousePointInDropZone(c,this.dropZones[b])){if(this.dropZones[b].canAccept(this.currentDragObjects)){this.dropZones[b].hideHover();
this.dropZones[b].accept(this.currentDragObjects);
a=true;
break
}}}return a
},_cancelDrag:function(){for(var a=0;
a<this.currentDragObjects.length;
a++){this.currentDragObjects[a].cancelDrag()
}},_endDrag:function(){for(var a=0;
a<this.currentDragObjects.length;
a++){this.currentDragObjects[a].endDrag()
}},_mousePointInDropZone:function(b,c){var a=c.getAbsoluteRect();
var d=Rico.eventClient(b);
return d.x>a.left+this._leftOffset(b)&&d.x<a.right+this._leftOffset(b)&&d.y>a.top+this._topOffset(b)&&d.y<a.bottom+this._topOffset(b)
},_activateRegisteredDropZones:function(){var c=this.dropZones.length;
for(var a=0;
a<c;
a++){var b=this.dropZones[a];
if(b.canAccept(this.currentDragObjects)){b.activate()
}}this.activatedDropZones=true
},_deactivateRegisteredDropZones:function(){var b=this.dropZones.length;
for(var a=0;
a<b;
a++){this.dropZones[a].deactivate()
}this.activatedDropZones=false
},_attachEvents:function(){Rico.eventBind(document.body,"mousemove",this._mouseMove);
Rico.eventBind(document.body,"mouseup",this._mouseUp)
}};
Rico.Draggable=function(a,b){this.initialize(a,b)
};
Rico.Draggable.prototype={initialize:function(a,b){this.type=a;
this.htmlElement=Rico.$(b);
this.selected=false
},getMouseDownHTMLElement:function(){return this.htmlElement
},select:function(){this._select()
},_select:function(){this.selected=true;
if(this.showingSelected){return
}this.showingSelected=true;
var b=this.getMouseDownHTMLElement();
var a=Rico.Color.createColorFromBackground(b);
a.isBright()?a.darken(0.033):a.brighten(0.033);
this.saveBackground=Rico.getStyle(b,"backgroundColor","background-color");
b.style.backgroundColor=a.asHex()
},deselect:function(){this.selected=false;
if(!this.showingSelected){return
}var a=this.getMouseDownHTMLElement();
a.style.backgroundColor=this.saveBackground;
this.showingSelected=false
},isSelected:function(){return this.selected
},startDrag:function(){},cancelDrag:function(){},endDrag:function(){},getSingleObjectDragGUI:function(){return this.htmlElement
},getMultiObjectDragGUI:function(a){return this.htmlElement
},getDroppedGUI:function(){return this.htmlElement
},toString:function(){return this.type+":"+this.htmlElement+":"
}};
Rico.LiveGridDraggable=function(b,a,c){this.initialize(b,a,c)
};
Rico.LiveGridDraggable.prototype=Rico.extend(new Rico.Draggable(),{initialize:function(b,a,c){this.type="RicoCell";
this.htmlElement=b.cell(a,c);
this.liveGrid=b;
this.dragRow=a;
this.dragCol=c
},select:function(){if(this.dragRow>=this.liveGrid.buffer.totalRows){return
}this.selected=true;
this.showingSelected=true
},deselect:function(){this.selected=false;
this.showingSelected=false
},getSingleObjectDragGUI:function(){var a=document.createElement("div");
a.className="LiveGridDraggable";
a.style.width=(this.htmlElement.offsetWidth-10)+"px";
a.innerHTML=this.htmlElement.innerHTML;
return a
}});
Rico.Dropzone=function(a){this.initialize(a)
};
Rico.Dropzone.prototype={initialize:function(a){this.htmlElement=Rico.$(a);
this.absoluteRect=null
},getHTMLElement:function(){return this.htmlElement
},clearPositionCache:function(){this.absoluteRect=null
},getAbsoluteRect:function(){if(this.absoluteRect==null){var a=this.getHTMLElement();
var b=Rico.viewportOffset(a);
this.absoluteRect={top:b.top,left:b.left,bottom:b.top+a.offsetHeight,right:b.left+a.offsetWidth}
}return this.absoluteRect
},activate:function(){var c=this.getHTMLElement();
if(c==null||this.showingActive){return
}this.showingActive=true;
this.saveBackgroundColor=c.style.backgroundColor;
var b="#ffea84";
var a=Rico.Color.createColorFromBackground(c);
if(a==null){c.style.backgroundColor=b
}else{a.isBright()?a.darken(0.2):a.brighten(0.2);
c.style.backgroundColor=a.asHex()
}},deactivate:function(){var a=this.getHTMLElement();
if(a==null||!this.showingActive){return
}a.style.backgroundColor=this.saveBackgroundColor;
this.showingActive=false;
this.saveBackgroundColor=null
},showHover:function(){var a=this.getHTMLElement();
if(a==null||this.showingHover){return
}this.saveBorderWidth=a.style.borderWidth;
this.saveBorderStyle=a.style.borderStyle;
this.saveBorderColor=a.style.borderColor;
this.showingHover=true;
a.style.borderWidth="1px";
a.style.borderStyle="solid";
a.style.borderColor="#ffff00"
},hideHover:function(){var a=this.getHTMLElement();
if(a==null||!this.showingHover){return
}a.style.borderWidth=this.saveBorderWidth;
a.style.borderStyle=this.saveBorderStyle;
a.style.borderColor=this.saveBorderColor;
this.showingHover=false
},canAccept:function(a){return true
},accept:function(b){var d=this.getHTMLElement();
if(d==null){return
}var e=b.length;
for(var a=0;
a<e;
a++){var c=b[a].getDroppedGUI();
if(Rico.getStyle(c,"position")=="absolute"){c.style.position="static";
c.style.top="";
c.style.top=""
}d.appendChild(c)
}}};
Rico.KeywordSearch=function(b,a){this.initialize(b,a)
};
Rico.KeywordSearch.prototype={initialize:function(c,b){this.id=c;
Rico.extend(this,new Rico.Window(Rico.getPhraseById("keywordTitle"),b));
Rico.addClass(this.content,"ricoKeywordSearch");
Rico.extend(this.options,{listLength:10,maxSuggest:20,width:"12em"});
var a=this;
Rico.onLoad(function(){a.atLoad()
})
},atLoad:function(){this.searchField=Rico.createFormField(this.contentDiv,"input","text",this.id+"_search");
this.searchField.style.display="block";
this.searchField.style.width=this.options.width;
Rico.eventBind(this.searchField,"keyup",Rico.eventHandle(this,"filterKeypress"),false);
this.selectList=Rico.createFormField(this.contentDiv,"select",null,this.id+"_list");
this.selectList.size=this.options.listLength;
this.selectList.style.display="block";
this.selectList.style.width=this.options.width;
Rico.eventBind(this.selectList,"change",Rico.eventHandle(this,"listClick"),false);
this.close=this.closePopup;
this.close()
},open:function(a,b){this.column=b;
this.grid=this.column.liveGrid;
this.searchField.value="";
this.selectList.options.length=0;
this.openPopup();
this.searchField.focus();
this.selectValuesRequest("")
},selectValuesRequest:function(c){var d=this.column.index;
var b={};
Rico.extend(b,this.grid.buffer.ajaxOptions);
b.parameters={id:this.grid.tableId,offset:"0",page_size:this.options.maxSuggest,edit:d};
b.parameters[this.grid.actionId]="query";
if(c!=""&&c!="*"){if(c.indexOf("*")==-1){c="*"+c+"*"
}b.parameters["f[1][op]"]="LIKE";
b.parameters["f[1][len]"]=1;
b.parameters["f[1][0]"]=c
}var a=this;
b.onComplete=function(e){a.selectValuesUpdate(e)
};
new Rico.ajaxRequest(this.grid.buffer.dataSource,b)
},selectValuesUpdate:function(b){var a=b.responseXML.getElementsByTagName("ajax-response");
Rico.log("selectValuesUpdate: "+b.status);
if(a==null||a.length!=1){return
}a=a[0];
var h=a.getElementsByTagName("error");
if(h.length>0){var f=Rico.getContentAsString(h[0],this.grid.buffer.isEncoded);
Rico.log("Data provider returned an error:\n"+f);
alert(Rico.getPhraseById("requestError",f));
return null
}this.selectList.options.length=0;
a=a.getElementsByTagName("response")[0];
var g=a.getElementsByTagName("rows")[0];
var j=this.grid.buffer.dom2jstable(g);
Rico.log("selectValuesUpdate: id="+this.selectList.id+" rows="+j.length);
for(var d=0;
d<j.length;
d++){if(j[d].length>0){var e=j[d][0];
var c=(j[d].length>1)?j[d][1]:e;
Rico.addSelectOption(this.selectList,e,c)
}}},filterKeypress:function(c){var a=Rico.eventElement(c);
if(typeof this.lastKeyFilter!="string"){this.lastKeyFilter=""
}if(this.lastKeyFilter==a.value){return
}var b=a.value;
Rico.log("filterKeypress: "+this.index+" "+b);
this.lastKeyFilter=b;
this.selectValuesRequest(b)
},listClick:function(c){var b=Rico.eventElement(c);
if(b.tagName.toLowerCase()!="select"){return
}if(this.returnValue){var a=b.options[b.selectedIndex];
this.returnValue(a.value,a.innerHTML)
}this.close()
}};
Rico.TreeControl=function(c,b,a){this.initialize(c,b,a)
};
Rico.TreeControl.prototype={initialize:function(d,c,b){Rico.extend(this,new Rico.Popup());
Rico.extend(this.options,{ignoreClicks:true,nodeIdDisplay:"none",showCheckBox:false,showFolders:false,showPlusMinus:true,showLines:true,defaultAction:Rico.eventHandle(this,"nodeClick"),height:"300px",width:"300px",leafIcon:"rico-icon rico-doc"});
Rico.extend(this.options,b||{});
this.id=d;
this.dataSource=c;
this.close=this.closePopup;
this.hoverSet=new Rico.HoverSet([]);
var a=this;
Rico.onLoad(function(){a.atLoad()
})
},atLoad:function(){this.treeDiv=document.createElement("div");
this.treeDiv.className="ricoTree";
if(Rico.theme.treeContent){Rico.addClass(this.treeDiv,Rico.theme.treeContent)
}var b=Rico.$(this.id);
if(b){this.setDiv(b,{position:"auto"})
}else{this.treeDiv.id=this.id;
this.createContainer()
}this.treeDiv.style.height=this.options.height;
this.treeDiv.style.width=this.options.width;
this.content.className=Rico.theme.tree||"ricoTreeContainer";
this.content.appendChild(this.treeDiv);
if(this.options.showCheckBox){this.buttonDiv=document.createElement("div");
this.buttonDiv.style.width=this.options.width;
this.buttonDiv.className="ricoTreeButtons";
if(Rico.getStyle(this.container,"position")=="absolute"){var a=document.createElement("span");
a.innerHTML=Rico.getPhraseById("treeSave");
Rico.setStyle(a,{"float":"left",cursor:"pointer"});
this.buttonDiv.appendChild(a);
Rico.eventBind(a,"click",Rico.eventHandle(this,"saveSelection"))
}var a=document.createElement("span");
a.innerHTML=Rico.getPhraseById("treeClear");
Rico.setStyle(a,{"float":"right",cursor:"pointer"});
this.buttonDiv.appendChild(a);
this.content.appendChild(this.buttonDiv);
Rico.eventBind(a,"click",Rico.eventHandle(this,"clrCheckBoxEvent"))
}if(this.position=="absolute"){this.close()
}},setTreeDiv:function(a){this.treeDiv=Rico.$(a);
this.openPopup=function(){}
},open:function(){this.openPopup();
if(this.treeDiv.childNodes.length==0&&this.dataSource){this.loadXMLDoc()
}},loadXMLDoc:function(c){var b={id:this.id};
if(c){b.Parent=c
}Rico.log("Tree loadXMLDoc: "+this.id);
var a=this;
new Rico.ajaxRequest(this.dataSource,{parameters:b,method:"get",onComplete:function(d){a.processResponse(d)
}})
},domID:function(b,a){return"RicoTree_"+a+"_"+this.id+"_"+b
},processResponse:function(d){var b=d.responseXML.getElementsByTagName("ajax-response");
if(b==null||b.length!=1){return
}var f=b[0].getElementsByTagName("rows")[0];
var g=f.getElementsByTagName("tr");
var k=[];
for(var e=0;
e<g.length;
e++){var l=g[e].getElementsByTagName("td");
if(l.length<5){continue
}var h=[];
h[5]=this.options.leafIcon;
for(var c=0;
c<l.length;
c++){h[c]=Rico.getContentAsString(l[c],true)
}h[3]=h[3].match(/^0|L$/i)?0:1;
h[4]=parseInt(h[4]);
k.push(h)
}for(var e=0;
e<k.length;
e++){var a=(e<k.length-1)&&(k[e][0]==k[e+1][0]);
this.addNode(k[e][0],k[e][1],k[e][2],k[e][3],k[e][4],k[e][5],!a)
}},addNode:function(q,l,t,f,u,s,k){var h=Rico.$(this.domID(q,"Parent"));
var v=Rico.$(this.domID(q,"Children"));
var a=h?h.TreeLevel+1:0;
var b=document.createElement("table");
var m=document.createElement("div");
m.id=this.domID(l,"Children");
m.className="ricoTreeBranch";
m.style.display=h?"none":"";
b.border=0;
b.cellSpacing=0;
b.cellPadding=0;
b.id=this.domID(l,"Parent");
b.TreeLevel=a;
b.TreeContainer=f;
b.TreeFetchedChildren=this.dataSource?false:true;
var d=b.insertRow(0);
var g=[];
for(var r=0;
r<a-1;
r++){g[r]=d.insertCell(-1)
}if(a>1){var e=h.getElementsByTagName("td");
for(var r=0;
r<a-2;
r++){g[r].innerHTML=e[r].innerHTML
}var w=document.createElement("div");
w.className="rico-icon rico-tree-"+(v.nextSibling&&this.options.showLines?"nodeline":"nodeblank");
g[a-2].appendChild(w)
}if(a>0){var c=k&&this.options.showLines?"last":"";
var o=this.options.showLines?"node":"";
if(this.options.showPlusMinus&&f){var w=document.createElement("div");
w.name=l;
w.style.cursor="pointer";
Rico.eventBind(w,"click",Rico.eventHandle(this,"clickBranch"));
w.className="rico-icon rico-tree-"+o+"p"+c;
d.insertCell(-1).appendChild(w)
}else{if(this.options.showLines){var w=document.createElement("div");
w.className="rico-icon rico-tree-node"+c;
d.insertCell(-1).appendChild(w)
}}if(this.options.showFolders&&(f||(s&&s!="none"))){var w=document.createElement("div");
if(!f){w.className=s
}else{w.name=l;
w.style.cursor="pointer";
Rico.eventBind(w,"click",Rico.eventHandle(this,"clickBranch"));
w.className="rico-icon rico-folderclosed"
}d.insertCell(-1).appendChild(w)
}}if(u&&this.options.showCheckBox){var n=document.createElement("input");
n.type="checkbox";
n.value=l;
d.insertCell(-1).appendChild(n)
}if(u&&!this.options.showCheckBox){var p=document.createElement("a");
if(typeof u=="string"){p.href=u
}else{p.href="javascript:void(0)";
Rico.eventBind(p,"click",this.options.defaultAction)
}this.hoverSet.add(p)
}else{var p=document.createElement("p")
}p.id=this.domID(l,"Desc");
p.className="ricoTreeLevel"+a;
switch(this.options.nodeIdDisplay){case"last":t+=" ("+l+")";
break;
case"first":t=l+" - "+t;
break;
case"tooltip":p.title=l;
break
}p.appendChild(document.createTextNode(t));
d.insertCell(-1).appendChild(p);
var j=v||this.treeDiv;
j.appendChild(b);
j.appendChild(m)
},nodeClick:function(c){var b=Rico.eventElement(c);
if(this.returnValue){var a=this.domID("","Desc");
this.returnValue(b.id.substr(a.length),b.innerHTML)
}this.close()
},saveSelection:function(a){if(this.returnValue){this.returnValue(this.getCheckedItems())
}this.close()
},getCheckedItems:function(){var b=this.treeDiv.getElementsByTagName("input");
var c=[];
for(var a=0;
a<b.length;
a++){if(b[a].type=="checkbox"&&b[a].checked){c.push(b[a].value)
}}return c
},setCheckBoxes:function(c){var b=this.treeDiv.getElementsByTagName("input");
for(var a=0;
a<b.length;
a++){if(b[a].type=="checkbox"){b[a].checked=c
}}},clrCheckBoxEvent:function(a){Rico.eventStop(a);
this.setCheckBoxes(false)
},clickBranch:function(h){var g=Rico.eventElement(h);
var f=Rico.getParentByTagName(g,"table");
if(!f||!f.TreeContainer){return
}var c=f.id.split("_");
c[1]="Children";
var b=Rico.$(c.join("_"));
Rico.toggle(b);
if(g.tagName=="DIV"){var d=Rico.visible(b);
if(g.className.match(/node(p|m)(last)?$/)){g.className=g.className.replace(/nodep|nodem/,"node"+(d?"m":"p"))
}else{if(g.className.match(/folder(open|closed)$/)){g.className=g.className.replace(/folder(open|closed)/,"folder"+(d?"open":"closed"))
}else{if(g.className.match(/\b(m|p)$/)){g.className=g.className.replace(/(p|m)$/,d?"m":"p")
}}}}if(!f.TreeFetchedChildren){f.TreeFetchedChildren=1;
this.loadXMLDoc(g.name)
}}};
if(typeof Rico=="undefined"){throw ("GridCommon requires the Rico JavaScript framework")
}Rico.GridCommon={baseInit:function(){this.options={saveColumnInfo:{width:true,filter:false,sort:false},cookiePrefix:"RicoGrid.",allowColResize:true,windowResize:true,click:null,dblclick:null,contextmenu:null,menuEvent:null,defaultWidth:-1,scrollBarWidth:19,minScrollWidth:100,frozenColumns:0,exportWindow:"height=400,width=500,scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0,status=0",exportStyleList:["background-color","color","text-align","font-weight","font-size","font-family"],exportImgTags:false,exportFormFields:true,FilterLocation:null,FilterAllToken:"___ALL___",columnSpecs:[]};
this.hdrCells=[];
this.headerColCnt=0;
this.headerRowIdx=0;
this.tabs=new Array(2);
this.thead=new Array(2);
this.tbody=new Array(2)
},attachMenuEvents:function(){var a;
if(!this.options.menuEvent||this.options.menuEvent=="none"){return
}this.hideScroll=navigator.userAgent.match(/Macintosh\b.*\b(Firefox|Camino)\b/i)||(Rico.isOpera&&parseFloat(window.opera.version())<9.5);
this.options[this.options.menuEvent]=Rico.eventHandle(this,"handleMenuClick");
if(this.highlightDiv){switch(this.options.highlightElem){case"cursorRow":this.attachMenu(this.highlightDiv[0]);
break;
case"cursorCell":for(a=0;
a<2;
a++){this.attachMenu(this.highlightDiv[a])
}break
}}for(a=0;
a<2;
a++){this.attachMenu(this.tbody[a])
}},attachMenu:function(a){if(this.options.click){Rico.eventBind(a,"click",this.options.click,false)
}if(this.options.dblclick){if(Rico.isWebKit||Rico.isOpera){Rico.eventBind(a,"click",Rico.eventHandle(this,"handleDblClick"),false)
}else{Rico.eventBind(a,"dblclick",this.options.dblclick,false)
}}if(this.options.contextmenu){if(Rico.isOpera||Rico.isKonqueror){Rico.eventBind(a,"click",Rico.eventHandle(this,"handleContextMenu"),false)
}else{Rico.eventBind(a,"contextmenu",this.options.contextmenu,false)
}}},handleDblClick:function(b){var a=Rico.eventElement(b);
if(this.dblClickElem==a){this.options.dblclick(b)
}else{this.dblClickElem=a;
this.safariTimer=Rico.runLater(300,this,"clearDblClick")
}},clearDblClick:function(){this.dblClickElem=null
},handleContextMenu:function(c){var a;
if(typeof(c.which)=="number"){a=c.which
}else{if(typeof(c.button)=="number"){a=c.button
}else{return
}}if(a==1&&c.ctrlKey){this.options.contextmenu(c)
}},cancelMenu:function(){if(this.menu){this.menu.cancelmenu()
}},getColumnInfo:function(f){Rico.log("getColumnInfo: len="+f.length);
if(f.length==0){return 0
}this.headerRowCnt=f.length;
var d,h,e;
for(d=0;
d<this.headerRowCnt;
d++){var b=f[d];
var a=b.cells;
if(d>=this.hdrCells.length){this.hdrCells[d]=[]
}for(h=0;
h<a.length;
h++){var g={};
g.cell=a[h];
g.colSpan=a[h].colSpan||1;
if(this.options.defaultWidth<0){g.initWidth=a[h].offsetWidth
}this.hdrCells[d].push(g)
}if(b.id.slice(-5)=="_main"){e=this.hdrCells[d].length;
this.headerRowIdx=d
}}if(!e){this.headerRowIdx=this.headerRowCnt-1;
e=this.hdrCells[this.headerRowIdx].length
}Rico.log("getColumnInfo: colcnt="+e);
return e
},addHeadingRow:function(g){var a=this.headerRowCnt++;
this.hdrCells[a]=[];
for(var e=0;
e<2;
e++){var k=this.thead[e].insertRow(-1);
var f="ricoLG_hdg "+this.tableId+"_hdg"+a;
if(g){f+=" "+g
}k.className=f;
var b=e==0?this.options.frozenColumns:this.headerColCnt-this.options.frozenColumns;
for(var j=0;
j<b;
j++){var d=k.insertCell(-1);
var i=Rico.wrapChildren(d,"ricoLG_col");
Rico.wrapChildren(i,"ricoLG_cell");
this.hdrCells[a].push({cell:d,colSpan:1})
}}return a
},createColumnArray:function(d){this.direction=Rico.getStyle(this.outerDiv,"direction").toLowerCase();
this.align=this.direction=="rtl"?["right","left"]:["left","right"];
Rico.log("createColumnArray: dir="+this.direction);
for(var b=0;
b<2;
b++){Rico.addClass(this.thead[b].rows[this.headerRowIdx],"rico_ResizeRow")
}this.columns=[];
for(var f=0;
f<this.headerColCnt;
f++){Rico.log("createColumnArray: c="+f);
var e=f<this.options.frozenColumns?0:1;
var a=new Rico[d](this,f,this.hdrCells[this.headerRowIdx][f],e);
this.columns.push(a);
if(f>0){this.columns[f-1].next=a
}}this.getCookie();
Rico.runLater(100,this,"insertResizers")
},insertResizers:function(){if(!this.options.allowColResize){return
}for(var a=0;
a<this.columns.length;
a++){this.columns[a].insertResizer()
}},createDivs:function(){Rico.log("createDivs start");
this.outerDiv=this.createDiv("outer");
if(Rico.theme.gridContainer){Rico.addClass(this.outerDiv,Rico.theme.gridContainer)
}if(this.outerDiv.firstChild&&this.outerDiv.firstChild.tagName&&this.outerDiv.firstChild.tagName.toUpperCase()=="TABLE"){this.structTab=this.outerDiv.firstChild;
this.structTabLeft=this.structTab.rows[0].cells[0];
this.structTabUR=this.structTab.rows[0].cells[1];
this.structTabLR=this.structTab.rows[1].cells[0]
}else{this.structTab=document.createElement("table");
this.structTab.border=0;
this.structTab.cellPadding=0;
this.structTab.cellSpacing=0;
var b=this.structTab.insertRow(-1);
b.vAlign="top";
this.structTabLeft=b.insertCell(-1);
this.structTabLeft.rowSpan=2;
this.structTabLeft.style.padding="0px";
this.structTabLeft.style.border="none";
var d=this.structTab.insertRow(-1);
d.vAlign="top";
this.structTabUR=b.insertCell(-1);
this.structTabUR.style.padding="0px";
this.structTabUR.style.border="none";
this.structTabLR=d.insertCell(-1);
this.structTabLR.style.padding="0px";
this.structTabLR.style.border="none";
this.outerDiv.appendChild(this.structTab)
}Rico.addClass(this.structTab,"ricoLG_StructTab");
this.frozenTabs=this.createDiv("frozenTabs",this.structTabLeft);
this.innerDiv=this.createDiv("inner",this.structTabUR);
this.scrollDiv=this.createDiv("scroll",this.structTabLR);
this.resizeDiv=this.createDiv("resize",this.outerDiv,true);
this.messagePopup=new Rico.Popup();
this.messagePopup.createContainer({hideOnEscape:false,hideOnClick:false,parent:this.outerDiv});
this.messagePopup.content.className="ricoLG_messageDiv";
if(Rico.theme.gridMessage){Rico.addClass(this.messagePopup.content,Rico.theme.gridMessage)
}this.keywordPopup=new Rico.Window("",{zIndex:-1,parent:this.outerDiv});
Rico.addClass(this.keywordPopup.container,"ricoLG_keywordDiv");
var a=this.keywordPopup.contentDiv.appendChild(document.createElement("p"));
a.innerHTML=Rico.getPhraseById("keywordPrompt");
this.keywordBox=this.keywordPopup.contentDiv.appendChild(document.createElement("input"));
this.keywordBox.size=20;
Rico.eventBind(this.keywordBox,"keypress",Rico.eventHandle(this,"keywordKey"),false);
this.keywordPopup.contentDiv.appendChild(Rico.floatButton("Checkmark",Rico.eventHandle(this,"processKeyword")));
var c=this.keywordPopup.contentDiv.appendChild(document.createElement("p"));
Rico.setStyle(c,{clear:"both"});
Rico.log("createDivs end")
},keywordKey:function(a){switch(Rico.eventKey(a)){case 27:this.closeKeyword();
Rico.eventStop(a);
return false;
case 13:this.processKeyword();
Rico.eventStop(a);
return false
}return true
},openKeyword:function(a){this.keywordCol=a;
this.keywordBox.value="";
this.keywordPopup.setTitle(this.columns[a].displayName);
this.keywordPopup.centerPopup();
this.keywordBox.focus()
},closeKeyword:function(){this.keywordPopup.closePopup();
this.cancelMenu()
},processKeyword:function(){var a=this.keywordBox.value;
this.closeKeyword();
this.columns[this.keywordCol].setFilterKW(a)
},createDiv:function(c,a,b){var e=this.tableId+"_"+c+"Div";
var d=document.getElementById(e);
if(!d){d=document.createElement("div");
d.id=e;
if(a){a.appendChild(d)
}}d.className="ricoLG_"+c+"Div";
if(b){Rico.hide(d)
}return d
},baseSizeDivs:function(){this.setOtherHdrCellWidths();
if(this.options.frozenColumns){Rico.show(this.tabs[0]);
Rico.show(this.frozenTabs);
this.hdrHt=Math.max(Rico.nan2zero(this.thead[0].offsetHeight),this.thead[1].offsetHeight);
this.dataHt=Math.max(Rico.nan2zero(this.tbody[0].offsetHeight),this.tbody[1].offsetHeight);
this.frzWi=this.borderWidth(this.tabs[0])
}else{Rico.hide(this.tabs[0]);
Rico.hide(this.frozenTabs);
this.frzWi=0;
this.hdrHt=this.thead[1].offsetHeight;
this.dataHt=this.tbody[1].offsetHeight
}var d,b;
var c=this.borderWidth(this.columns[0].dataCell);
Rico.log("baseSizeDivs "+this.tableId+": hdrHt="+this.hdrHt+" dataHt="+this.dataHt);
Rico.log(this.tableId+" frzWi="+this.frzWi+" borderWi="+c);
for(b=0;
b<this.options.frozenColumns;
b++){if(this.columns[b].visible){this.frzWi+=parseInt(this.columns[b].colWidth,10)+c
}}this.scrTabWi=this.borderWidth(this.tabs[1]);
this.scrTabWi0=this.scrTabWi;
Rico.log("scrTabWi: "+this.scrTabWi);
for(b=this.options.frozenColumns;
b<this.columns.length;
b++){if(this.columns[b].visible){this.scrTabWi+=parseInt(this.columns[b].colWidth,10)+c
}}this.scrWi=this.scrTabWi+this.options.scrollBarWidth;
if(this.sizeTo=="parent"){if(Rico.isIE){Rico.hide(this.outerDiv)
}d=this.outerDiv.parentNode.offsetWidth;
if(Rico.isIE){Rico.show(this.outerDiv)
}}else{d=Rico.windowWidth()-this.options.scrollBarWidth-8
}if(this.outerDiv.parentNode.clientWidth>0){d=Math.min(this.outerDiv.parentNode.clientWidth,d)
}var a=this.frzWi+this.scrWi-d;
Rico.log("baseSizeDivs "+this.tableId+": scrWi="+this.scrWi+" wiLimit="+d+" overage="+a+" clientWidth="+this.outerDiv.parentNode.clientWidth);
if(a>0&&this.options.frozenColumns<this.columns.length){this.scrWi=Math.max(this.scrWi-a,this.options.minScrollWidth)
}this.scrollDiv.style.width=this.scrWi+"px";
this.frozenTabs.style.width=this.frzWi+"px";
this.outerDiv.style.width=(this.frzWi+this.scrWi)+"px"
},borderWidth:function(c){var a=Rico.nan2zero(Rico.getStyle(c,"borderLeftWidth"));
var b=Rico.nan2zero(Rico.getStyle(c,"borderRightWidth"));
Rico.log((c.id||c.tagName)+" borderWidth: L="+a+", R="+b);
return a+b
},setOtherHdrCellWidths:function(){var k,g,f,a,l,b,m,d,e,h;
for(a=0;
a<this.hdrCells.length;
a++){if(a==this.headerRowIdx){continue
}Rico.log("setOtherHdrCellWidths: r="+a);
k=g=0;
while(g<this.headerColCnt&&k<this.hdrCells[a].length){b=this.hdrCells[a][k];
m=b.cell;
d=e=b.colSpan;
for(l=f=0;
f<d;
f++,g++){if(this.columns[g].hdrCell.style.display=="none"){e--
}else{if(this.columns[g].hdrColDiv.style.display!="none"){l+=parseInt(this.columns[g].colWidth,10)
}}}if(!b.hdrColDiv||!b.hdrCellDiv){h=m.getElementsByTagName("div");
b.hdrColDiv=(h.length<1)?Rico.wrapChildren(m,"ricoLG_col"):h[0];
b.hdrCellDiv=(h.length<2)?Rico.wrapChildren(b.hdrColDiv,"ricoLG_cell"):h[1]
}if(e==0){m.style.display="none"
}else{if(l==0){b.hdrColDiv.style.display="none";
m.colSpan=e
}else{m.style.display="";
b.hdrColDiv.style.display="";
m.colSpan=e;
b.hdrColDiv.style.width=l+"px"
}}k++
}}},initFilterImage:function(a){this.filterAnchor=document.getElementById(this.tableId+"_filterLink");
if(!this.filterAnchor){return
}this.filterRows=Rico.select("tr."+this.tableId+"_hdg"+a);
if(this.filterRows.length!=2){return
}for(var c=0,d=[];
c<2;
c++){d[c]=Rico.select(".ricoLG_cell",this.filterRows[c])
}this.filterElements=d[0].concat(d[1]);
this.saveHeight=this.filterElements[0].offsetHeight;
var e=Rico.getStyle(this.filterElements[0],"paddingTop");
var b=Rico.getStyle(this.filterElements[0],"paddingBottom");
if(e){this.saveHeight-=parseInt(e,10)
}if(b){this.saveHeight-=parseInt(b,10)
}this.rowNum=a;
this.setFilterImage(false)
},toggleFilterRow:function(){if(Rico.visible(this.filterRows[0])){this.slideFilterUp()
}else{this.slideFilterDown()
}},setFilterImage:function(b){var a=Rico.getPhraseById((b?"show":"hide")+"FilterRow");
this.filterAnchor.innerHTML='<img src="'+Rico.imgDir+"tableFilter"+(b?"Expand":"Collapse")+'.gif" alt="'+a+'" border="0">'
},cell:function(a,b){return(0<=b&&b<this.columns.length&&a>=0)?this.columns[b].cell(a):null
},availHt:function(){var a=Rico.cumulativeOffset(this.outerDiv);
return Rico.windowHeight()-a.top-2*this.options.scrollBarWidth-15
},hideMsg:function(){this.messagePopup.closePopup()
},showMsg:function(a){this.messagePopup.setContent(a);
this.messagePopup.centerPopup();
Rico.log("showMsg: "+a)
},listInvisible:function(b){var c=[];
for(var a=0;
a<this.columns.length;
a++){if(!this.columns[a].visible){c.push(b?this.columns[a][b]:this.columns[a])
}}return c
},firstVisible:function(){for(var a=0;
a<this.columns.length;
a++){if(this.columns[a].visible){return a
}}return -1
},showAll:function(){var b=this.listInvisible();
for(var a=0;
a<b.length;
a++){b[a].showColumn()
}},chooseColumns:function(){this.menu.cancelmenu();
var a,f,b,e,d,c;
if(!this.columnChooser){Rico.log("creating columnChooser");
f=Rico.getStyle(this.outerDiv.offsetParent,"zIndex");
if(typeof f!="number"){f=0
}this.columnChooser=new Rico.Window(Rico.getPhraseById("gridChooseCols"),{zIndex:f+2,parent:this.outerDiv});
Rico.addClass(this.columnChooser.container,"ricoLG_chooserDiv");
c=this.columnChooser.contentDiv;
for(a=0;
a<this.columns.length;
a++){b=this.columns[a];
e=c.appendChild(document.createElement("div"));
b.ChooserBox=Rico.createFormField(e,"input","checkbox");
d=e.appendChild(document.createElement("span"));
d.innerHTML=b.displayName;
Rico.eventBind(b.ChooserBox,"click",Rico.eventHandle(b,"chooseColumn"),false)
}}Rico.log("opening columnChooser");
this.columnChooser.openPopup(3,this.hdrHt+3);
for(a=0;
a<this.columns.length;
a++){this.columns[a].ChooserBox.checked=this.columns[a].visible;
this.columns[a].ChooserBox.disabled=!this.columns[a].canHideShow()
}},blankRow:function(a){for(var b=0;
b<this.columns.length;
b++){this.columns[b].clearCell(a)
}},getExportStyles:function(a){var e=this.options.exportStyleList;
var b=Rico.getStyle(a,"backgroundImage");
if(!b||b=="none"){return e
}for(var d=[],c=0;
c<e.length;
c++){if(e[c]!="background-color"&&e[c]!="color"){d.push(e[c])
}}return d
},exportStart:function(){var a,h,f,d,b,e,k,l;
var g=this.getExportStyles(this.thead[0]);
this.exportRows=[];
this.exportText="<html><head></head><body><table border='1' cellspacing='0'>";
for(h=0;
h<this.columns.length;
h++){if(this.columns[h].visible){this.exportText+="<col width='"+parseInt(this.columns[h].colWidth,10)+"'>"
}}this.exportText+="<thead style='display: table-header-group;'>";
if(this.exportHeader){this.exportText+=this.exportHeader
}for(a=0;
a<this.hdrCells.length;
a++){if(this.hdrCells[a].length==0||!Rico.visible(this.hdrCells[a][0].cell.parentNode)){continue
}this.exportText+="<tr>";
for(h=0,f=0;
h<this.hdrCells[a].length;
h++){b=this.hdrCells[a][h];
e=b.colSpan;
for(d=0;
d<b.colSpan;
d++,f++){if(!this.columns[f].visible){e--
}}if(e>0){k=Rico.select(".ricoLG_cell",b.cell);
l=k&&k.length>0?k[0]:b.cell;
this.exportText+="<td style='"+this.exportStyle(l,g)+"'";
if(b.colSpan>1){this.exportText+=" colspan='"+e+"'"
}this.exportText+=">"+Rico.getInnerText(l,!this.options.exportImgTags,!this.options.exportFormFields,"NoExport")+"</td>"
}}this.exportText+="</tr>"
}this.exportText+="</thead><tbody>"
},exportFinish:function(){if(this.hideMsg){this.hideMsg()
}window.status=Rico.getPhraseById("exportComplete");
if(this.exportRows.length>0){this.exportText+="<tr>"+this.exportRows.join("</tr><tr>")+"</tr>"
}if(this.exportFooter){this.exportText+=this.exportFooter
}this.exportText+="</tbody></table></body></html>";
if(this.cancelMenu){this.cancelMenu()
}var a=window.open("","_blank",this.options.exportWindow);
if(a==null){alert(Rico.getPhraseById("disableBlocker"))
}else{a.document.open();
a.document.write(this.exportText);
a.document.close()
}this.exportText=undefined;
this.exportRows=undefined
},exportStyle:function(d,g){for(var b=0,c="";
b<g.length;
b++){try{var a=Rico.getStyle(d,g[b]);
if(a){c+=g[b]+":"+a+";"
}}catch(f){}}return c
},getCookie:function(){var k=Rico.getCookie(this.options.cookiePrefix+this.tableId);
if(!k){return
}var f=k.split(",");
for(var g=0;
g<f.length;
g++){var a=f[g].split(":");
if(a.length!=2){continue
}var h=parseInt(a[0].slice(1),10);
if(h<0||h>=this.columns.length){continue
}var e=this.columns[h];
switch(a[0].charAt(0)){case"w":e.setColWidth(a[1]);
e.customWidth=true;
break;
case"h":if(a[1].toLowerCase()=="true"){e.hideshow(true,true)
}else{e.hideshow(false,true)
}break;
case"s":if(!this.options.saveColumnInfo.sort||!e.sortable){break
}e.setSorted(a[1]);
break;
case"f":if(!this.options.saveColumnInfo.filter||!e.filterable){break
}var d=a[1].split("~");
e.filterOp=d.shift();
e.filterValues=[];
e.filterType=Rico.ColumnConst.USERFILTER;
for(var b=0;
b<d.length;
b++){e.filterValues.push(unescape(d[b]))
}break
}}},setCookie:function(){var d=[];
for(var e=0;
e<this.columns.length;
e++){var c=this.columns[e];
if(this.options.saveColumnInfo.width){if(c.customWidth){d.push("w"+e+":"+c.colWidth)
}if(c.customVisible){d.push("h"+e+":"+c.visible)
}}if(this.options.saveColumnInfo.sort){if(c.currentSort!=Rico.ColumnConst.UNSORTED){d.push("s"+e+":"+c.currentSort)
}}if(this.options.saveColumnInfo.filter&&c.filterType==Rico.ColumnConst.USERFILTER){var b=[c.filterOp];
for(var a=0;
a<c.filterValues.length;
a++){b.push(escape(c.filterValues[a]))
}d.push("f"+e+":"+b.join("~"))
}}Rico.setCookie(this.options.cookiePrefix+this.tableId,d.join(","),this.options.cookieDays,this.options.cookiePath,this.options.cookieDomain)
}};
Rico.ColumnConst={UNFILTERED:0,SYSTEMFILTER:1,USERFILTER:2,UNSORTED:0,SORT_ASC:"ASC",SORT_DESC:"DESC",MINWIDTH:10};
Rico.TableColumnBase=function(){};
Rico.TableColumnBase.prototype={baseInit:function(h,g,e,d){Rico.log("TableColumnBase.baseInit index="+g+" tabIdx="+d);
this.liveGrid=h;
this.index=g;
this.hideWidth=Rico.isKonqueror||Rico.isWebKit||h.headerRowCnt>1?5:2;
this.options=h.options;
this.tabIdx=d;
this.hdrCell=e.cell;
this.body=document.getElementsByTagName("body")[0];
this.displayName=this.getDisplayName(this.hdrCell);
var c=this.hdrCell.getElementsByTagName("div");
this.hdrColDiv=(c.length<1)?Rico.wrapChildren(this.hdrCell,"ricoLG_col"):c[0];
this.hdrCellDiv=(c.length<2)?Rico.wrapChildren(this.hdrColDiv,"ricoLG_cell"):c[1];
var f=d==0?g:g-h.options.frozenColumns;
this.dataCell=h.tbody[d].rows[0].cells[f];
c=this.dataCell.getElementsByTagName("div");
this.dataColDiv=(c.length<1)?Rico.wrapChildren(this.dataCell,"ricoLG_col"):c[0];
this.mouseDownHandler=Rico.eventHandle(this,"handleMouseDown");
this.mouseMoveHandler=Rico.eventHandle(this,"handleMouseMove");
this.mouseUpHandler=Rico.eventHandle(this,"handleMouseUp");
this.mouseOutHandler=Rico.eventHandle(this,"handleMouseOut");
this.format={type:"text"};
var b=h.options.columnSpecs[g];
if(typeof b=="object"){Rico.extend(this.format,b)
}Rico.addClass(this.dataColDiv,this.colClassName());
this.visible=true;
if(typeof this.format.visible=="boolean"){this.visible=this.format.visible
}this.sortable=typeof this.format.canSort=="boolean"?this.format.canSort:h.options.canSortDefault;
this.currentSort=Rico.ColumnConst.UNSORTED;
this.filterable=typeof this.format.canFilter=="boolean"?this.format.canFilter:h.options.canFilterDefault;
this.filterType=Rico.ColumnConst.UNFILTERED;
this.hideable=typeof this.format.canHide=="boolean"?this.format.canHide:h.options.canHideDefault;
var a;
switch(typeof this.format.width){case"number":a=this.format.width;
break;
case"string":a=parseInt(this.format.width,10);
break;
default:a=e.initWidth;
break
}a=(typeof(a)=="number")?Math.max(a,Rico.ColumnConst.MINWIDTH):h.options.defaultWidth;
this.setColWidth(a);
if(!this.visible){this.setDisplay("none")
}},colClassName:function(){return this.format.ClassName?this.format.ClassName:this.liveGrid.tableId+"_col"+this.index
},insertResizer:function(){if(this.format.noResize){return
}var a=document.createElement("div");
a.className="ricoLG_Resize";
a.style[this.liveGrid.align[1]]="0px";
this.hdrCellDiv.appendChild(a);
Rico.eventBind(a,"mousedown",this.mouseDownHandler,false)
},getDisplayName:function(b){var c=b.getElementsByTagName("A");
var a=c.length>0?c[0].innerHTML:Rico.stripTags(b.innerHTML);
return Rico.trim(a)
},_clear:function(a){a.innerHTML="&nbsp;"
},clearCell:function(b){var a=this.cell(b);
this._clear(a,b);
if(this.liveGrid.buffer&&this.liveGrid.buffer.options.acceptStyle){a.style.cssText=""
}},dataTable:function(){return this.liveGrid.tabs[this.tabIdx]
},numRows:function(){return this.dataColDiv.childNodes.length
},clearColumn:function(){var b=this.numRows();
for(var a=0;
a<b;
a++){this.clearCell(a)
}},cell:function(a){return this.dataColDiv.childNodes[a]
},getFormattedValue:function(c,a,d,b){return Rico.getInnerText(this.cell(c),a,d,b)
},setColWidth:function(a){if(typeof a=="number"){a=parseInt(a,10);
if(a<Rico.ColumnConst.MINWIDTH){return
}a=a+"px"
}Rico.log("setColWidth "+this.index+": "+a);
this.colWidth=a;
this.hdrColDiv.style.width=a;
this.dataColDiv.style.width=a
},pluginMouseEvents:function(){if(this.mousePluggedIn==true){return
}Rico.eventBind(this.body,"mousemove",this.mouseMoveHandler,false);
Rico.eventBind(this.body,"mouseup",this.mouseUpHandler,false);
Rico.eventBind(this.body,"mouseout",this.mouseOutHandler,false);
this.mousePluggedIn=true
},unplugMouseEvents:function(){Rico.eventUnbind(this.body,"mousemove",this.mouseMoveHandler,false);
Rico.eventUnbind(this.body,"mouseup",this.mouseUpHandler,false);
Rico.eventUnbind(this.body,"mouseout",this.mouseOutHandler,false);
this.mousePluggedIn=false
},handleMouseDown:function(b){this.resizeStart=Rico.eventClient(b).x;
this.origWidth=parseInt(this.colWidth,10);
var a=Rico.positionedOffset(this.hdrCell);
if(this.liveGrid.direction=="rtl"){this.edge=a.left;
switch(this.tabIdx){case 0:this.edge+=this.liveGrid.innerDiv.offsetWidth;
break;
case 1:this.edge-=this.liveGrid.scrollDiv.scrollLeft;
break
}}else{this.edge=a.left+this.hdrCell.offsetWidth;
if(this.tabIdx>0){this.edge+=Rico.nan2zero(this.liveGrid.tabs[0].offsetWidth)
}}this.liveGrid.resizeDiv.style.left=this.edge+"px";
this.liveGrid.resizeDiv.style.display="";
this.liveGrid.outerDiv.style.cursor="e-resize";
this.tmpHighlight=this.liveGrid.highlightEnabled;
this.liveGrid.highlightEnabled=false;
this.pluginMouseEvents();
Rico.eventStop(b)
},handleMouseMove:function(b){var c=Rico.eventClient(b).x-this.resizeStart;
var a=(this.liveGrid.direction=="rtl")?this.origWidth-c:this.origWidth+c;
if(a<Rico.ColumnConst.MINWIDTH){return
}this.liveGrid.resizeDiv.style.left=(this.edge+c)+"px";
this.colWidth=a;
Rico.eventStop(b)
},handleMouseUp:function(a){this.unplugMouseEvents();
Rico.log("handleMouseUp "+this.liveGrid.tableId);
this.liveGrid.outerDiv.style.cursor="";
this.liveGrid.resizeDiv.style.display="none";
this.setColWidth(this.colWidth);
this.customWidth=true;
this.liveGrid.setCookie();
this.liveGrid.highlightEnabled=this.tmpHighlight;
this.liveGrid.sizeDivs();
Rico.eventStop(a)
},handleMouseOut:function(b){var a=Rico.eventRelatedTarget(b)||b.toElement;
while(a!=null&&a.nodeName.toLowerCase()!="body"){a=a.parentNode
}if(a!=null&&a.nodeName.toLowerCase()=="body"){return true
}this.handleMouseUp(b);
return true
},setDisplay:function(a){this.hdrCell.style.display=a;
this.hdrColDiv.style.display=a;
this.dataCell.style.display=a;
this.dataColDiv.style.display=a
},hideshow:function(b,a){this.setDisplay(b?"":"none");
this.liveGrid.cancelMenu();
this.visible=b;
this.customVisible=true;
if(a){return
}this.liveGrid.setCookie();
this.liveGrid.sizeDivs()
},hideColumn:function(){Rico.log("hideColumn "+this.liveGrid.tableId);
this.hideshow(false,false)
},showColumn:function(){Rico.log("showColumn "+this.liveGrid.tableId);
this.hideshow(true,false)
},chooseColumn:function(b){var a=Rico.eventElement(b);
this.hideshow(a.checked,false)
},setImage:function(){if(this.currentSort==Rico.ColumnConst.SORT_ASC){this.imgSort.style.display="inline-block";
this.imgSort.className=Rico.theme.sortAsc||"rico-icon ricoLG_sortAsc"
}else{if(this.currentSort==Rico.ColumnConst.SORT_DESC){this.imgSort.style.display="inline-block";
this.imgSort.className=Rico.theme.sortDesc||"rico-icon ricoLG_sortDesc"
}else{this.imgSort.style.display="none"
}}if(this.filterType==Rico.ColumnConst.USERFILTER){this.imgFilter.style.display="inline-block";
this.imgFilter.title=this.getFilterText()
}else{this.imgFilter.style.display="none"
}},canHideShow:function(){return this.hideable
}};
if(typeof Rico=="undefined"){throw ("SimpleGrid requires the Rico JavaScript framework")
}Rico.SimpleGrid=function(b,a){this.initialize(b,a)
};
Rico.SimpleGrid.prototype={initialize:function(b,a){Rico.extend(this,Rico.GridCommon);
this.baseInit();
Rico.setDebugArea(b+"_debugmsgs");
Rico.extend(this.options,a||{});
this.tableId=b;
Rico.log("SimpleGrid initialize start: "+b);
this.createDivs();
this.hdrTabs=new Array(2);
this.simpleGridInit();
Rico.log("SimpleGrid initialize end: "+b)
},simpleGridInit:function(){var a;
for(a=0;
a<2;
a++){Rico.log("simpleGridInit "+a);
this.tabs[a]=Rico.$(this.tableId+"_tab"+a);
if(!this.tabs[a]){return
}this.hdrTabs[a]=Rico.$(this.tableId+"_tab"+a+"h");
if(!this.hdrTabs[a]){return
}this.thead[a]=this.hdrTabs[a];
this.tbody[a]=this.tabs[a];
this.headerColCnt=this.getColumnInfo(this.hdrTabs[a].rows);
if(a==0){this.options.frozenColumns=this.headerColCnt
}if(Rico.theme.gridheader){Rico.addClass(this.thead[a],Rico.theme.gridheader)
}if(Rico.theme.gridcontent){Rico.addClass(this.tbody[a],Rico.theme.gridcontent)
}}if(this.headerColCnt==0){alert('ERROR: no columns found in "'+this.tableId+'"');
return
}this.createColumnArray("SimpleGridColumn");
this.pageSize=this.columns[0].dataColDiv.childNodes.length;
this.sizeDivs();
if(typeof(this.options.FilterLocation)=="number"){this.createFilters(this.options.FilterLocation)
}this.attachMenuEvents();
this.scrollEventFunc=Rico.eventHandle(this,"handleScroll");
this.scrollFrozenEventFunc=Rico.eventHandle(this,"handleScrollFrozen");
this.scrollHeadingEventFunc=Rico.eventHandle(this,"handleScrollHeading");
this.pluginScroll();
if(this.options.windowResize){Rico.eventBind(window,"resize",Rico.eventHandle(this,"sizeDivs"),false)
}},filterId:function(a){return"RicoFilter_"+this.tableId+"_"+a
},createFilters:function(a){if(a<0){a=this.addHeadingRow();
this.sizeDivs()
}for(var g=0;
g<this.headerColCnt;
g++){var d=this.columns[g];
var e=d.format;
if(typeof e.filterUI!="string"){continue
}var k=this.hdrCells[a][g].cell;
var j,b=this.filterId(g);
var h=k.getElementsByTagName("div");
switch(e.filterUI.charAt(0)){case"t":j=Rico.createFormField(h[1],"input","text",b,b);
var m=e.filterUI.match(/\d+/);
j.maxLength=e.Length||50;
j.size=m?parseInt(m,10):10;
Rico.eventBind(j,"keyup",Rico.eventHandle(d,"filterKeypress"),false);
break;
case"s":j=Rico.createFormField(h[1],"select",null,b);
Rico.addSelectOption(j,this.options.FilterAllToken,Rico.getPhraseById("filterAll"));
this.getFilterValues(d);
var l=Rico.keys(d.filterHash);
l.sort();
for(var f=0;
f<l.length;
f++){Rico.addSelectOption(j,l[f],l[f]||Rico.getPhraseById("filterBlank"))
}Rico.eventBind(j,"change",Rico.eventHandle(d,"filterChange"),false);
break
}}this.initFilterImage(a)
},getFilterValues:function(b){var e={};
var f=b.numRows();
for(var c=0;
c<f;
c++){var a=Rico.getInnerText(b.cell(c));
var d=e[a];
if(d){d.push(c)
}else{e[a]=[c]
}}b.filterHash=e
},applyFilters:function(){var b=[];
for(var f=0;
f<this.columns.length;
f++){if(this.columns[f].filterRows){b.push(this.columns[f].filterRows)
}}if(b.length==0){this.showAllRows();
return
}for(var d=0;
d<this.pageSize;
d++){var e=true;
for(var a=0;
a<b.length;
a++){if(b[a].indexOf(d)==-1){e=false;
break
}}if(e){this.showRow(d)
}else{this.hideRow(d)
}}this.sizeDivs()
},pluginScroll:function(){if(this.scrollPluggedIn){return
}Rico.eventBind(this.scrollDiv,"scroll",this.scrollEventFunc,false);
Rico.eventBind(this.frozenTabs,"scroll",this.scrollFrozenEventFunc,false);
Rico.eventBind(this.innerDiv,"scroll",this.scrollHeadingEventFunc,false);
this.scrollPluggedIn=true
},unplugScroll:function(){Rico.eventUnbind(this.scrollDiv,"scroll",this.scrollEventFunc,false);
Rico.eventUnbind(this.frozenTabs,"scroll",this.scrollFrozenEventFunc,false);
Rico.eventUnbind(this.innerDiv,"scroll",this.scrollHeadingEventFunc,false);
this.scrollPluggedIn=false
},handleScroll:function(a){this.frozenTabs.scrollTop=this.scrollDiv.scrollTop;
this.innerDiv.scrollLeft=this.scrollDiv.scrollLeft
},handleScrollFrozen:function(a){this.scrollDiv.scrollTop=this.frozenTabs.scrollTop
},handleScrollHeading:function(a){this.scrollDiv.scrollLeft=this.innerDiv.scrollLeft
},registerScrollMenu:function(a){if(!this.menu){this.menu=a
}a.grid=this;
a.showmenu=a.showSimpleMenu;
a.showSubMenu=a.showSimpleSubMenu;
a.createDiv(this.outerDiv)
},handleMenuClick:function(a){if(!this.menu){return
}this.cancelMenu();
this.menuCell=Rico.getParentByTagName(Rico.eventElement(a),"div");
this.highlightEnabled=false;
if(this.hideScroll){this.scrollDiv.style.overflow="hidden"
}if(this.menu.buildGridMenu){this.menu.buildGridMenu(this.menuCell)
}this.menu.showmenu(a,this.closeMenu.bind(this))
},closeMenu:function(){if(this.hideScroll){this.scrollDiv.style.overflow=""
}this.highlightEnabled=true
},sizeDivs:function(){if(this.outerDiv.offsetParent.style.display=="none"){return
}this.baseSizeDivs();
var c=Math.max(this.options.maxHt||this.availHt(),50);
var b=Math.min(this.hdrHt+this.dataHt,c);
Rico.log("sizeDivs "+this.tableId+": hdrHt="+this.hdrHt+" dataHt="+this.dataHt);
this.dataHt=b-this.hdrHt;
if(this.scrWi>0){this.dataHt+=this.options.scrollBarWidth
}this.scrollDiv.style.height=this.dataHt+"px";
this.frozenTabs.style.height=this.scrollDiv.clientHeight+"px";
var a=2;
this.innerDiv.style.width=(this.scrWi-this.options.scrollBarWidth+a)+"px";
b+=a;
this.resizeDiv.style.height=b+"px";
this.handleScroll()
},printVisible:function(){this.showMsg(Rico.getPhraseById("exportInProgress"));
Rico.runLater(10,this,"_printVisible")
},_printVisible:function(){this.exportStart();
var f=this.getExportStyles(this.tbody[0]);
for(var e=0;
e<this.pageSize;
e++){if(this.columns[0].cell(e).style.display=="none"){continue
}var d="";
for(var g=0;
g<this.columns.length;
g++){var b=this.columns[g];
if(b.visible){var a=b.getFormattedValue(e,!this.options.exportImgTags,!this.options.exportFormFields,"NoExport");
if(b.format.exportPrefix){a=b.format.exportPrefix+a
}if(a==""){a="&nbsp;"
}d+="<td style='"+this.exportStyle(b.cell(e),f)+"'>"+a+"</td>"
}}this.exportRows.push(d)
}this.exportFinish()
},hideRow:function(a){if(this.columns[0].cell(a).style.display=="none"){return
}for(var b=0;
b<this.columns.length;
b++){this.columns[b].cell(a).style.display="none"
}},showRow:function(a){if(this.columns[0].cell(a).style.display==""){return
}for(var b=0;
b<this.columns.length;
b++){this.columns[b].cell(a).style.display=""
}},searchRows:function(h,e,c){if(!e){return
}var f=new RegExp(e);
var d=this.columns[h].numRows();
for(var g=0;
g<d;
g++){var b=this.cell(g,h).innerHTML;
var a=(b.match(f)!=null);
if(a!=c){this.hideRow(g)
}}this.sizeDivs();
this.handleScroll()
},showAllRows:function(){for(var a=0;
a<this.pageSize;
a++){this.showRow(a)
}this.sizeDivs()
},openPopup:function(d,e){while(d&&!Rico.hasClass(d,"ricoLG_cell")){d=d.parentNode
}if(!d){return false
}var f=Rico.getParentByTagName(d,"td");
var c=Math.floor(f.offsetLeft-this.scrollDiv.scrollLeft+f.offsetWidth/2);
if(this.direction=="rtl"){if(c>this.width){c-=this.width
}}else{if(c+this.width+this.options.margin>this.scrollDiv.clientWidth){c-=this.width
}}e.divPopup.style.visibility="hidden";
e.divPopup.style.display="block";
var b=e.divPopup.offsetHeight;
var a=Math.floor(d.offsetTop-this.scrollDiv.scrollTop+d.offsetHeight/2);
if(a+b+e.options.margin>this.scrollDiv.clientHeight){a=Math.max(a-b,0)
}e.openPopup(this.frzWi+c,this.hdrHt+a);
e.divPopup.style.visibility="visible";
return d
}};
if(Rico.Menu){Rico.extend(Rico.Menu.prototype,{showSimpleMenu:function(b,c){Rico.eventStop(b);
this.hideFunc=c;
if(this.div.childNodes.length==0){this.cancelmenu();
return false
}var a=Rico.eventElement(b);
this.grid.openPopup(a,this);
return a
},showSimpleSubMenu:function(b,c){if(this.openSubMenu){this.hideSubMenu()
}this.openSubMenu=c;
this.openMenuAnchor=b;
if(b.className=="ricoSubMenu"){b.className="ricoSubMenuOpen"
}var e=parseInt(this.div.style.top,10);
var d=parseInt(this.div.style.left,10);
c.openPopup(d+b.offsetWidth,e+b.offsetTop);
c.div.style.visibility="visible"
}})
}Rico.SimpleGridColumn=function(a,d,c,b){this.initialize(a,d,c,b)
};
Rico.SimpleGridColumn.prototype={initialize:function(a,d,c,b){Rico.extend(this,new Rico.TableColumnBase());
this.baseInit(a,d,c,b)
},setUnfiltered:function(){this.filterRows=null
},filterChange:function(a){var b=Rico.eventElement(a);
if(b.value==this.liveGrid.options.FilterAllToken){this.setUnfiltered()
}else{this.filterRows=this.filterHash[b.value]
}this.liveGrid.applyFilters()
},filterKeypress:function(f){var a=Rico.eventElement(f);
if(typeof this.lastKeyFilter!="string"){this.lastKeyFilter=""
}if(this.lastKeyFilter==a.value){return
}var b=a.value;
Rico.log("filterKeypress: "+this.index+" "+b);
this.lastKeyFilter=b;
if(b){b=b.replace("\\","\\\\");
b=b.replace("(","\\(").replace(")","\\)");
b=b.replace(".","\\.");
if(this.format.filterUI.indexOf("^")>0){b="^"+b
}var d=new RegExp(b,"i");
this.filterRows=[];
var h=this.numRows();
for(var c=0;
c<h;
c++){var g=Rico.getInnerText(this.cell(c));
if(g.match(d)){this.filterRows.push(c)
}}}else{this.setUnfiltered()
}this.liveGrid.applyFilters()
}};
if(!Rico.Buffer){Rico.Buffer={}
}Rico.Buffer.Base=function(b,a){this.initialize(b,a)
};
Rico.Buffer.Base.prototype={initialize:function(b,a){this.clear();
this.updateInProgress=false;
this.lastOffset=0;
this.rcvdRowCount=false;
this.foundRowCount=false;
this.totalRows=0;
this.rowcntContent="";
this.rcvdOffset=-1;
this.options={fixedHdrRows:0,canFilter:true,isEncoded:true,acceptStyle:false,canRefresh:false};
Rico.extend(this.options,a||{});
if(b){this.loadRowsFromTable(b,this.options.fixedHdrRows);
b.parentNode.removeChild(b)
}},registerGrid:function(a){this.liveGrid=a
},setTotalRows:function(a){if(typeof(a)!="number"){a=this.size
}if(this.totalRows==a){return
}this.totalRows=a;
if(!this.liveGrid){return
}Rico.log("setTotalRows, newTotalRows="+a);
switch(this.liveGrid.sizeTo){case"data":this.liveGrid.resizeWindow();
break;
case"datamax":this.liveGrid.setPageSize(a);
break;
default:this.liveGrid.updateHeightDiv();
break
}},loadRowsFromTable:function(h,g){var e=[];
var a=h.getElementsByTagName("tr");
for(var d=g||0;
d<a.length;
d++){var f=[];
var c=a[d].getElementsByTagName("td");
for(var b=0;
b<c.length;
b++){f[b]=c[b].innerHTML
}e.push(f)
}this.loadRows(e)
},loadRowsFromArray:function(b){for(var c=0;
c<b.length;
c++){for(var a=0;
a<b[c].length;
a++){b[c][a]=b[c][a].toString()
}}this.loadRows(b)
},loadRows:function(a){this.baseRows=a;
this.startPos=0;
this.size=this.baseRows.length
},dom2jstable:function(f){Rico.log("dom2jstable: encoded="+this.options.isEncoded);
var e=[];
var a=f.getElementsByTagName("tr");
for(var d=0;
d<a.length;
d++){var g=[];
var c=a[d].getElementsByTagName("td");
for(var b=0;
b<c.length;
b++){g[b]=Rico.getContentAsString(c[b],this.options.isEncoded)
}e.push(g)
}return e
},_blankRow:function(){var a=[];
for(var b=0;
b<this.liveGrid.columns.length;
b++){a[b]=""
}return a
},deleteRows:function(b,a){this.baseRows.splice(b,typeof(a)=="number"?a:1);
this.liveGrid.isPartialBlank=true;
this.size=this.baseRows.length
},insertRow:function(a){var b=this._blankRow();
this.baseRows.splice(a,0,b);
this.size=this.baseRows.length;
this.liveGrid.isPartialBlank=true;
if(this.startPos<0){this.startPos=0
}return b
},appendRows:function(b){var c=[];
for(var a=0;
a<b;
a++){var d=this._blankRow();
this.baseRows.push(d);
c.push(d)
}this.size=this.baseRows.length;
this.liveGrid.isPartialBlank=true;
if(this.startPos<0){this.startPos=0
}return c
},sortFunc:function(b){var a=this;
switch(b){case"number":return function(d,c){return a._sortNumeric(d,c)
};
case"control":return function(d,c){return a._sortControl(d,c)
};
default:return function(d,c){return a._sortAlpha(d,c)
}
}},sortBuffer:function(b){if(!this.baseRows){this.delayedSortCol=b;
return
}this.liveGrid.showMsg(Rico.getPhraseById("sorting"));
this.sortColumn=b;
var a=this.liveGrid.columns[b];
this.getValFunc=a._sortfunc;
this.baseRows.sort(this.sortFunc(a.format.type));
if(a.getSortDirection()=="DESC"){this.baseRows.reverse()
}},_sortAlpha:function(d,c){var e=this.sortColumn<d.length?Rico.getInnerText(d[this.sortColumn]):"";
var f=this.sortColumn<c.length?Rico.getInnerText(c[this.sortColumn]):"";
if(e==f){return 0
}if(e<f){return -1
}return 1
},_sortNumeric:function(d,c){var e=this.sortColumn<d.length?this.nan2zero(Rico.getInnerText(d[this.sortColumn])):0;
var f=this.sortColumn<c.length?this.nan2zero(Rico.getInnerText(c[this.sortColumn])):0;
return e-f
},nan2zero:function(a){if(typeof(a)=="string"){a=parseFloat(a)
}return isNaN(a)||typeof(a)=="undefined"?0:a
},_sortControl:function(d,c){var e=this.sortColumn<d.length?Rico.getInnerText(d[this.sortColumn]):"";
var f=this.sortColumn<c.length?Rico.getInnerText(c[this.sortColumn]):"";
if(this.getValFunc){e=this.getValFunc(e);
f=this.getValFunc(f)
}if(e==f){return 0
}if(e<f){return -1
}return 1
},clear:function(){this.baseRows=[];
this.rows=[];
this.modified=[];
this.attr=null;
this.startPos=-1;
this.size=0;
this.windowPos=0
},isInRange:function(a){var b=Math.min(this.totalRows,a+this.liveGrid.pageSize);
return(a>=this.startPos)&&(b<=this.endPos())
},endPos:function(){return this.startPos+this.rows.length
},fetch:function(a){Rico.log("fetch "+this.liveGrid.tableId+": offset="+a);
this.applyFilters();
this.setTotalRows();
this.rcvdRowCount=true;
this.foundRowCount=true;
if(a<0){a=0
}this.liveGrid.refreshContents(a);
return
},visibleRows:function(){return this.rows.slice(this.windowStart,this.windowEnd)
},setWindow:function(b,a){this.windowStart=b-this.startPos;
Rico.log("setWindow "+this.liveGrid.tableId+": "+b+", "+a+", newstart="+this.windowStart);
this.windowEnd=Math.min(a,this.size);
this.windowPos=b
},isVisible:function(a){return a<this.rows.length&&a>=this.windowStart&&a<this.windowEnd
},bufferRow:function(a){return this.windowStart+a
},getWindowCell:function(c,b){var a=this.bufferRow(c);
return this.isVisible(a)&&b<this.rows[a].length?this.rows[a][b]:null
},getWindowStyle:function(c,b){var a=this.bufferRow(c);
return this.attr&&this.isVisible(a)&&this.attr[a]&&b<this.attr[a].length?this.attr[a][b]:""
},getWindowValue:function(b,a){return this.getWindowCell(b,a)
},setWindowValue:function(d,b,c){var a=this.bufferRow(d);
if(a>=this.windowEnd){return false
}return this.setValue(a,b,c)
},getCell:function(b,a){return b<this.size?this.rows[b][a]:null
},getValue:function(b,a){return this.getCell(b,a)
},setValue:function(d,b,c,a){if(d>=this.size){return false
}if(!this.rows[d][b]){this.rows[d][b]={}
}this.rows[d][b]=c;
if(this.options.acceptStyle&&typeof a=="string"){if(!this.attr){this.attr=[]
}if(!this.attr[d]){this.attr[d]=[]
}this.attr[d][b]=a
}if(!this.modified[d]){this.modified[d]=[]
}this.modified[d][b]=true;
return true
},getRows:function(f,d){var e=f-this.startPos;
var a=Math.min(e+d,this.size);
var c=[];
for(var b=e;
b<a;
b++){c.push(this.rows[b])
}return c
},applyFilters:function(){var g=[],k=[];
var a,h,d,e,f,b;
var j=this.liveGrid.columns;
for(d=0,b=0;
d<j.length;
d++){h=j[d];
if(h.filterType==Rico.ColumnConst.UNFILTERED){continue
}b++;
if(h.filterOp=="LIKE"){k[d]=new RegExp(h.filterValues[0],"i")
}}Rico.log("applyFilters: # of filters="+b);
if(b==0){this.rows=this.baseRows
}else{for(a=0;
a<this.baseRows.length;
a++){f=true;
for(d=0;
d<j.length&&f;
d++){h=j[d];
if(h.filterType==Rico.ColumnConst.UNFILTERED){continue
}switch(h.filterOp){case"LIKE":f=k[d].test(this.baseRows[a][d]);
break;
case"EQ":f=this.baseRows[a][d]==h.filterValues[0];
break;
case"NE":for(e=0;
e<h.filterValues.length&&f;
e++){f=this.baseRows[a][d]!=h.filterValues[e]
}break;
case"LE":if(h.format.type=="number"){f=this.nan2zero(this.baseRows[a][d])<=this.nan2zero(h.filterValues[0])
}else{f=this.baseRows[a][d]<=h.filterValues[0]
}break;
case"GE":if(h.format.type=="number"){f=this.nan2zero(this.baseRows[a][d])>=this.nan2zero(h.filterValues[0])
}else{f=this.baseRows[a][d]>=h.filterValues[0]
}break;
case"NULL":f=this.baseRows[a][d]=="";
break;
case"NOTNULL":f=this.baseRows[a][d]!="";
break
}}if(f){g.push(this.baseRows[a])
}}this.rows=g
}this.rowcntContent=this.size=this.rows.length
},printAll:function(){this.liveGrid.showMsg(Rico.getPhraseById("exportInProgress"));
Rico.runLater(10,this,"_printAll")
},_printAll:function(){this.liveGrid.exportStart();
this.exportBuffer(this.getRows(0,this.totalRows));
this.liveGrid.exportFinish()
},printVisible:function(){this.liveGrid.showMsg(Rico.getPhraseById("exportInProgress"));
Rico.runLater(10,this,"_printVisible")
},_printVisible:function(){this.liveGrid.exportStart();
this.exportBuffer(this.visibleRows());
this.liveGrid.exportFinish()
},exportBuffer:function(l,f){var a,g,k,b,j;
Rico.log("exportBuffer: "+l.length+" rows");
var e=this.liveGrid.getExportStyles(this.liveGrid.tbody[0]);
var i=[];
var d=f||0;
var h=this.liveGrid.columns;
for(g=0;
g<h.length;
g++){if(h[g].visible){i[g]=this.liveGrid.exportStyle(h[g].cell(0),e)
}}for(a=0;
a<l.length;
a++){j="";
for(g=0;
g<h.length;
g++){if(!h[g].visible){continue
}b=h[g];
b.expStyle=i[g];
k=b._export(l[a][g],l[a]);
if(k==""){k="&nbsp;"
}j+="<td style='"+b.expStyle+"'>"+k+"</td>"
}this.liveGrid.exportRows.push(j);
d++;
if(d%10==0){window.status=Rico.getPhraseById("exportStatus",d)
}}}};
Rico.LiveGrid=function(c,a,b){this.initialize(c,a,b)
};
Rico.LiveGrid.prototype={initialize:function(e,b,d){Rico.extend(this,Rico.GridCommon);
Rico.extend(this,Rico.LiveGridMethods);
this.baseInit();
this.tableId=e;
this.buffer=b;
this.actionId="_action_"+e;
Rico.setDebugArea(e+"_debugmsgs");
Rico.extend(this.options,{visibleRows:-3,frozenColumns:0,offset:0,prefetchBuffer:true,minPageRows:2,maxPageRows:50,canSortDefault:true,canFilterDefault:b.options.canFilter,canHideDefault:true,highlightElem:"none",highlightSection:3,highlightMethod:"class",highlightClass:Rico.theme.gridHighlightClass||"ricoLG_selection",maxPrint:5000,headingSort:"link",hdrIconsFirst:true});
var c=this;
this.options.sortHandler=function(){c.sortHandler()
};
this.options.filterHandler=function(){c.filterHandler()
};
this.options.onRefreshComplete=function(f,g){c.bookmarkHandler(f,g)
};
this.options.rowOverHandler=Rico.eventHandle(this,"rowMouseOver");
this.options.mouseDownHandler=Rico.eventHandle(this,"selectMouseDown");
this.options.mouseOverHandler=Rico.eventHandle(this,"selectMouseOver");
this.options.mouseUpHandler=Rico.eventHandle(this,"selectMouseUp");
Rico.extend(this.options,d||{});
switch(typeof this.options.visibleRows){case"string":this.sizeTo=this.options.visibleRows;
switch(this.options.visibleRows){case"data":this.options.visibleRows=-2;
break;
case"body":this.options.visibleRows=-3;
break;
case"parent":this.options.visibleRows=-4;
break;
case"datamax":this.options.visibleRows=-5;
break;
default:this.options.visibleRows=-1;
break
}break;
case"number":switch(this.options.visibleRows){case -1:this.sizeTo="window";
break;
case -2:this.sizeTo="data";
break;
case -3:this.sizeTo="body";
break;
case -4:this.sizeTo="parent";
break;
case -5:this.sizeTo="datamax";
break;
default:this.sizeTo="fixed";
break
}break;
default:this.sizeTo="body";
this.options.visibleRows=-3;
break
}this.highlightEnabled=this.options.highlightSection>0;
this.pageSize=0;
this.createTables();
if(this.headerColCnt==0){alert('ERROR: no columns found in "'+this.tableId+'"');
return
}this.createColumnArray("LiveGridColumn");
if(this.options.headingSort=="hover"){this.createHoverSet()
}this.bookmark=document.getElementById(this.tableId+"_bookmark");
this.sizeDivs();
var a=-1;
if(this.buffer.options.canFilter&&this.options.AutoFilter){a=this.addHeadingRow("ricoLG_FilterRow")
}this.createDataCells(this.options.visibleRows);
if(this.pageSize==0){return
}this.buffer.registerGrid(this);
if(this.buffer.setBufferSize){this.buffer.setBufferSize(this.pageSize)
}this.scrollTimeout=null;
this.lastScrollPos=0;
this.attachMenuEvents();
this.setSortUI(this.options.sortCol,this.options.sortDir);
this.setImages();
if(this.listInvisible().length==this.columns.length){this.columns[0].showColumn()
}this.sizeDivs();
this.scrollDiv.style.display="";
if(this.buffer.totalRows>0){this.updateHeightDiv()
}if(this.options.prefetchBuffer){if(this.bookmark){this.bookmark.innerHTML=Rico.getPhraseById("bookmarkLoading")
}if(this.options.canFilterDefault&&this.options.getQueryParms){this.checkForFilterParms()
}this.scrollToRow(this.options.offset);
this.buffer.fetch(this.options.offset)
}if(a>=0){this.createFilters(a)
}this.scrollEventFunc=Rico.eventHandle(this,"handleScroll");
this.wheelEventFunc=Rico.eventHandle(this,"handleWheel");
this.wheelEvent=(Rico.isIE||Rico.isOpera||Rico.isWebKit)?"mousewheel":"DOMMouseScroll";
if(this.options.offset&&this.options.offset<this.buffer.totalRows){Rico.runLater(50,this,"scrollToRow",this.options.offset)
}this.pluginScroll();
this.setHorizontalScroll();
Rico.log("setHorizontalScroll done");
if(this.options.windowResize){Rico.runLater(100,this,"pluginWindowResize")
}Rico.log("initialize complete for "+this.tableId);
if(this.direction=="rtl"&&(!Rico.isWebKit||this.scrollDiv.clientLeft>0)){this.scrollTab.style.right="0px"
}else{this.scrollTab.style.left="0px";
Rico.setStyle(this.tabs[1],{"float":"left"})
}}};
Rico.LiveGridMethods={createHoverSet:function(){var a=[];
for(var b=0;
b<this.headerColCnt;
b++){if(this.columns[b].sortable){a.push(this.columns[b].hdrCellDiv)
}}this.hoverSet=new Rico.HoverSet(a)
},checkForFilterParms:function(){var b=window.location.search;
if(b.charAt(0)=="?"){b=b.substring(1)
}var c=b.split("&");
for(var a=0;
a<c.length;
a++){if(c[a].match(/^f\[\d+\]/)){this.buffer.options.requestParameters.push(c[a])
}}},drillDown:function(g,f,h){var b=Rico.eventElement(g||window.event);
b=Rico.getParentByTagName(b,"div","ricoLG_cell");
if(!b){return -1
}var a=this.winCellIndex(b);
if(a.row>=this.buffer.totalRows){return -1
}this.unhighlight();
this.menuIdx=a;
this.highlight(a);
var c=this.buffer.getWindowCell(a.row,f);
for(var d=3;
d<arguments.length;
d++){arguments[d].setDetailFilter(h,c)
}return a.row
},setDetailFilter:function(a,d){var b=this.columns[a];
b.format.ColData=d;
b.setSystemFilter("EQ",d)
},createTables:function(){var f,g,b;
var e=document.getElementById(this.tableId)||document.getElementById(this.tableId+"_outerDiv");
if(!e){return false
}if(e.tagName.toLowerCase()=="table"){var a=e.getElementsByTagName("thead");
if(a.length==1){Rico.log("createTables: using thead section, id="+this.tableId);
if(this.options.ColGroupsOnTabHdr&&this.options.ColGroups){var d=a[0].insertRow(0);
this.insertPanelNames(d,0,this.options.frozenColumns,"ricoFrozen");
this.insertPanelNames(d,this.options.frozenColumns,this.options.columnSpecs.length)
}g=a[0].rows
}else{Rico.log("createTables: using tbody section, id="+this.tableId);
g=new Array(e.rows[0])
}f=e
}else{if(this.options.columnSpecs.length>0){if(!e.id.match(/_outerDiv$/)){f=e
}Rico.log("createTables: inserting at "+e.tagName+", id="+this.tableId)
}else{alert("ERROR!\n\nUnable to initialize '"+this.tableId+"'\n\nLiveGrid terminated");
return false
}}this.createDivs();
this.scrollContainer=this.createDiv("scrollContainer",this.structTabLR);
this.scrollContainer.appendChild(this.scrollDiv);
this.scrollTab=this.createDiv("scrollTab",this.scrollContainer);
this.shadowDiv=this.createDiv("shadow",this.scrollDiv);
this.shadowDiv.style.direction="ltr";
this.scrollDiv.style.display="none";
this.scrollDiv.scrollTop=0;
if(this.options.highlightMethod!="class"){this.highlightDiv=[];
switch(this.options.highlightElem){case"menuRow":case"cursorRow":this.highlightDiv[0]=this.createDiv("highlight",this.outerDiv);
this.highlightDiv[0].style.display="none";
break;
case"menuCell":case"cursorCell":for(b=0;
b<2;
b++){this.highlightDiv[b]=this.createDiv("highlight",b==0?this.frozenTabs:this.scrollTab);
this.highlightDiv[b].style.display="none";
this.highlightDiv[b].id+=b
}break;
case"selection":var h=this.options.highlightSection==1?this.frozenTabs:this.scrollTab;
for(b=0;
b<4;
b++){this.highlightDiv[b]=this.createDiv("highlight",h);
this.highlightDiv[b].style.display="none";
this.highlightDiv[b].style.overflow="hidden";
this.highlightDiv[b].id+=b;
this.highlightDiv[b].style[b%2==0?"height":"width"]="0px"
}break
}}for(b=0;
b<3;
b++){this.tabs[b]=document.createElement("table");
this.tabs[b].className=(b<2)?"ricoLG_table":"ricoLG_scrollTab";
this.tabs[b].border=0;
this.tabs[b].cellPadding=0;
this.tabs[b].cellSpacing=0;
this.tabs[b].id=this.tableId+"_tab"+b
}for(b=0;
b<2;
b++){this.thead[b]=this.tabs[b].createTHead();
this.thead[b].className="ricoLG_top";
if(Rico.theme.gridheader){Rico.addClass(this.thead[b],Rico.theme.gridheader)
}}for(b=0;
b<2;
b++){this.tbody[b]=Rico.getTBody(this.tabs[b==0?0:2]);
this.tbody[b].className="ricoLG_bottom";
if(Rico.theme.gridcontent){Rico.addClass(this.tbody[b],Rico.theme.gridcontent)
}this.tbody[b].insertRow(-1)
}this.frozenTabs.appendChild(this.tabs[0]);
this.innerDiv.appendChild(this.tabs[1]);
this.scrollTab.appendChild(this.tabs[2]);
if(f){f.parentNode.insertBefore(this.outerDiv,f)
}if(g){this.headerColCnt=this.getColumnInfo(g);
this.loadHdrSrc(g)
}else{this.createHdr(0,0,this.options.frozenColumns);
this.createHdr(1,this.options.frozenColumns,this.options.columnSpecs.length);
if(this.options.ColGroupsOnTabHdr&&this.options.ColGroups){this.insertPanelNames(this.thead[0].insertRow(0),0,this.options.frozenColumns);
this.insertPanelNames(this.thead[1].insertRow(0),this.options.frozenColumns,this.options.columnSpecs.length)
}for(b=0;
b<2;
b++){this.headerColCnt=this.getColumnInfo(this.thead[b].rows)
}}for(var j=0;
j<this.headerColCnt;
j++){this.tbody[j<this.options.frozenColumns?0:1].rows[0].insertCell(-1)
}if(f){e.parentNode.removeChild(e)
}Rico.log("createTables end");
return true
},createDataCells:function(d){if(d<0){for(var a=0;
a<this.options.minPageRows;
a++){this.appendBlankRow()
}this.sizeDivs();
this.autoAppendRows(this.remainingHt())
}else{for(var c=0;
c<d;
c++){this.appendBlankRow()
}}var b=this.options.highlightSection;
if(b&1){this.attachHighlightEvents(this.tbody[0])
}if(b&2){this.attachHighlightEvents(this.tbody[1])
}},filterId:function(a){return"RicoFilter_"+this.tableId+"_"+a
},createFilters:function(b){for(var h=0;
h<this.headerColCnt;
h++){var e=this.columns[h];
var f=e.format;
if(typeof f.filterUI!="string"){continue
}var l=this.hdrCells[b][h].cell;
var j,d=this.filterId(h);
var i=l.getElementsByTagName("div");
var g=Rico.getStyle(this.cell(0,h),"textAlign");
i[1].style.textAlign=g;
switch(f.filterUI.charAt(0)){case"t":j=Rico.createFormField(i[1],"input",Rico.inputtypes.search?"search":"text",d,"RicoFilter");
var o=f.filterUI.match(/\d+/);
j.maxLength=f.Length||50;
j.size=o?parseInt(o,10):10;
if(j.type!="search"){i[1].appendChild(Rico.clearButton(Rico.eventHandle(e,"filterClear")))
}if(e.filterType==Rico.ColumnConst.USERFILTER&&e.filterOp=="LIKE"){var k=e.filterValues[0];
if(k.charAt(0)=="*"){k=k.substr(1)
}if(k.slice(-1)=="*"){k=k.slice(0,-1)
}j.value=k;
e.lastKeyFilter=k
}Rico.eventBind(j,"keyup",Rico.eventHandle(e,"filterKeypress"),false);
e.filterField=j;
break;
case"m":case"s":j=Rico.createFormField(i[1],"select",null,d,"RicoFilter");
Rico.addSelectOption(j,this.options.FilterAllToken,Rico.getPhraseById("filterAll"));
e.filterField=j;
var n={};
Rico.extend(n,this.buffer.ajaxOptions);
var a=typeof(f.filterCol)=="number"?f.filterCol:h;
n.parameters=this.buffer.formQueryHashXML(0,-1);
n.parameters.distinct=a;
n.onComplete=this.filterValuesUpdateFunc(h);
new Rico.ajaxRequest(this.buffer.dataSource,n);
break;
case"n":j=Rico.createFormField(i[1],"select",null,d,"RicoFilter");
Rico.addSelectOption(j,this.options.FilterAllToken,Rico.getPhraseById("filterAll"));
e.filterField=j;
var m=f.filterUI.length==1?"-0+":f.filterUI.substr(1);
if(m.indexOf("-")>=0){Rico.addSelectOption(j,"LT0","< 0")
}if(m.indexOf("0")>=0){Rico.addSelectOption(j,"EQ0","= 0")
}if(m.indexOf("+")>=0){Rico.addSelectOption(j,"GT0","> 0")
}Rico.eventBind(e.filterField,"change",Rico.eventHandle(e,"nFilterChange"));
break;
case"c":if(typeof e._createFilters=="function"){e._createFilters(i[1],d)
}break
}}this.initFilterImage(b)
},filterValuesUpdateFunc:function(b){var a=this;
return function(c){a.filterValuesUpdate(b,c)
}
},filterValuesUpdate:function(a,g){var f=g.responseXML.getElementsByTagName("ajax-response");
Rico.log("filterValuesUpdate: "+g.status);
if(f==null||f.length!=1){return false
}f=f[0];
var n=f.getElementsByTagName("error");
if(n.length>0){Rico.log("Data provider returned an error:\n"+Rico.getContentAsString(n[0],this.buffer.isEncoded));
alert(Rico.getPhraseById("requestError",Rico.getContentAsString(n[0],this.buffer.isEncoded)));
return false
}f=f.getElementsByTagName("response")[0];
var l=f.getElementsByTagName("rows")[0];
var d=this.columns[parseInt(a,10)];
var r=this.buffer.dom2jstable(l);
var m,b,q;
if(d.filterType==Rico.ColumnConst.USERFILTER&&d.filterOp=="EQ"){q=d.filterValues[0]
}Rico.log("filterValuesUpdate: col="+a+" rows="+r.length);
switch(d.format.filterUI.charAt(0)){case"m":d.mFilter=document.body.appendChild(document.createElement("div"));
d.mFilter.className="ricoLG_mFilter";
Rico.hide(d.mFilter);
var e=d.mFilter.appendChild(document.createElement("div"));
e.className="ricoLG_mFilter_content";
var o=d.mFilter.appendChild(document.createElement("div"));
o.className="ricoLG_mFilter_button";
d.mFilterButton=o.appendChild(document.createElement("button"));
d.mFilterButton.innerHTML=Rico.getPhraseById("apply");
var j=Rico.isWebKit?"mousedown":"click";
Rico.eventBind(d.filterField,j,Rico.eventHandle(d,"mFilterSelectClick"));
Rico.eventBind(d.mFilterButton,"click",Rico.eventHandle(d,"mFilterFinish"));
tab=e.appendChild(document.createElement("table"));
tab.border=0;
tab.cellPadding=2;
tab.cellSpacing=0;
var p=this.filterId(a)+"_";
this.createMFilterItem(tab,this.options.FilterAllToken,Rico.getPhraseById("filterAll"),p+"all",Rico.eventHandle(d,"mFilterAllClick"));
var k=Rico.eventHandle(d,"mFilterOtherClick");
for(var h=0;
h<r.length;
h++){if(r[h].length>0){m=r[h][0];
this.createMFilterItem(tab,m,m||Rico.getPhraseById("filterBlank"),p+h,k)
}}d.mFilterInputs=e.getElementsByTagName("input");
d.mFilterLabels=e.getElementsByTagName("label");
d.mFilterFocus=d.mFilterInputs.length?d.mFilterInputs[0]:d.mFilterButton;
break;
case"s":for(var h=0;
h<r.length;
h++){if(r[h].length>0){m=r[h][0];
b=Rico.addSelectOption(d.filterField,m,m||Rico.getPhraseById("filterBlank"));
if(d.filterType==Rico.ColumnConst.USERFILTER&&m==q){b.selected=true
}}}Rico.eventBind(d.filterField,"change",Rico.eventHandle(d,"filterChange"));
break
}return true
},createMFilterItem:function(j,b,i,a,e){var f=j.insertRow(-1);
f.vAlign="top";
if(f.rowIndex%2==1){f.className="ricoLG_mFilter_oddrow"
}var d=f.insertCell(-1);
var c=f.insertCell(-1);
var h=Rico.createFormField(d,"input","checkbox",a);
h.value=b;
h.checked=true;
var g=c.appendChild(document.createElement("label"));
g.htmlFor=a;
g.innerHTML=i;
Rico.eventBind(h,"click",e)
},unplugHighlightEvents:function(){var a=this.options.highlightSection;
if(a&1){this.detachHighlightEvents(this.tbody[0])
}if(a&2){this.detachHighlightEvents(this.tbody[1])
}},insertPanelNames:function(a,b,d,f){Rico.log("insertPanelNames: start="+b+" limit="+d);
a.className="ricoLG_hdg";
var i=-1,j,e=null,g=0;
for(var h=b;
h<d;
h++){if(i==this.options.columnSpecs[h].ColGroupIdx){j++
}else{if(e){e.colSpan=j
}e=a.insertCell(-1);
if(f){e.className=f
}j=1;
i=this.options.columnSpecs[h].ColGroupIdx;
e.innerHTML=this.options.ColGroups[i]
}}if(e){e.colSpan=j
}},createHdr:function(d,g,b){Rico.log("createHdr: i="+d+" start="+g+" limit="+b);
var a=this.thead[d].insertRow(-1);
a.id=this.tableId+"_tab"+d+"h_main";
a.className="ricoLG_hdg";
for(var f=g;
f<b;
f++){var e=a.insertCell(-1);
e.innerHTML=this.options.columnSpecs[f].Hdg
}},loadHdrSrc:function(g){var b,d,j,e,f,a;
Rico.log("loadHdrSrc start");
for(b=0;
b<2;
b++){for(e=0;
e<g.length;
e++){f=this.thead[b].insertRow(-1);
f.className="ricoLG_hdg "+this.tableId+"_hdg"+e
}}if(g.length==1){a=g[0].cells;
for(j=0;
a.length>0;
j++){this.thead[j<this.options.frozenColumns?0:1].rows[0].appendChild(a[0])
}}else{for(e=0;
e<g.length;
e++){a=g[e].cells;
for(j=0,d=0;
a.length>0;
j++){if(Rico.hasClass(a[0],"ricoFrozen")){if(e==this.headerRowIdx){this.options.frozenColumns=j+1
}}else{d=1
}this.thead[d].rows[e].appendChild(a[0])
}}}Rico.log("loadHdrSrc end")
},sizeDivs:function(){Rico.log("sizeDivs: "+this.tableId);
this.unhighlight();
this.baseSizeDivs();
var d=this.firstVisible();
if(this.pageSize==0||d<0){return
}var c=this.columns[d].dataColDiv.offsetHeight;
this.rowHeight=Math.round(c/this.pageSize);
var b=this.dataHt;
if(this.scrTabWi0==this.scrTabWi){this.innerDiv.style.height=(this.hdrHt+1)+"px";
this.scrollDiv.style.overflowX="hidden"
}else{this.scrollDiv.style.overflowX="scroll";
b+=this.options.scrollBarWidth
}this.scrollDiv.style.height=b+"px";
this.innerDiv.style.width=(this.scrWi)+"px";
this.scrollTab.style.width=(this.scrWi-this.options.scrollBarWidth)+"px";
this.resizeDiv.style.height=(this.hdrHt+this.dataHt+1)+"px";
Rico.log("sizeDivs scrHt="+b+" innerHt="+this.innerDiv.style.height+" rowHt="+this.rowHeight+" pageSize="+this.pageSize);
var a=(this.scrWi-this.scrTabWi<this.options.scrollBarWidth)?2:0;
this.shadowDiv.style.width=(this.scrTabWi+a)+"px";
this.outerDiv.style.height=(this.hdrHt+b)+"px";
this.setHorizontalScroll()
},setHorizontalScroll:function(){var a=(-this.scrollDiv.scrollLeft)+"px";
this.tabs[1].style.marginLeft=a;
this.tabs[2].style.marginLeft=a
},remainingHt:function(){var f=this.outerDiv.offsetHeight;
var g=Rico.windowHeight();
var e=Rico.isIE?15:10;
if(!Rico.isIE&&window.frameElement&&window.frameElement.scrolling=="yes"&&this.sizeTo!="parent"){e+=this.options.scrollBarWidth
}switch(this.sizeTo){case"window":var d=Rico.cumulativeOffset(this.outerDiv).top;
Rico.log("remainingHt/window, winHt="+g+" tabHt="+f+" gridY="+d);
return g-d-f-e;
case"parent":var h=this.offsetFromParent(this.outerDiv);
if(Rico.isIE){Rico.hide(this.outerDiv)
}var b=this.outerDiv.parentNode.clientHeight;
if(Rico.isIE){Rico.show(this.outerDiv)
}Rico.log("remainingHt/parent, parentHt="+b+" offset="+h+" tabHt="+f);
return b-f-h-e;
case"data":case"body":var a=Rico.isIE?document.body.scrollHeight:document.body.offsetHeight;
var c=g-a-e;
if(!Rico.isWebKit){c-=this.options.scrollBarWidth
}Rico.log("remainingHt, winHt="+g+" pageHt="+a+" remHt="+c);
return c;
default:Rico.log("remainingHt, winHt="+g+" tabHt="+f);
if(this.sizeTo.slice(-1)=="%"){g*=parseFloat(this.sizeTo)/100
}else{if(this.sizeTo.slice(-2)=="px"){g=parseInt(this.sizeTo,10)
}}return g-f-e
}},offsetFromParent:function(b){var a=0;
var c=b.parentNode;
do{a+=b.offsetTop||0;
b=b.offsetParent;
if(!b||b==null){break
}var d=Rico.getStyle(b,"position");
if(b.tagName=="BODY"||b.tagName=="HTML"||d=="absolute"){return a-c.offsetTop
}}while(b!=c);
return a
},adjustPageSize:function(){Rico.log("adjustPageSize start");
var a=this.remainingHt();
Rico.log("adjustPageSize remHt="+a+" lastRow="+this.lastRowPos);
if(a>this.rowHeight){this.autoAppendRows(a)
}else{if(a<0||this.sizeTo=="data"){this.autoRemoveRows(-a)
}}Rico.log("adjustPageSize end")
},setPageSize:function(b){Rico.log("setPageSize "+this.tableId+" newRowCount="+b);
b=Math.min(b,this.options.maxPageRows);
b=Math.max(b,this.options.minPageRows);
this.sizeTo="fixed";
var a=this.pageSize;
while(this.pageSize>b){this.removeRow()
}while(this.pageSize<b){this.appendBlankRow()
}this.finishResize(a)
},pluginWindowResize:function(){Rico.log("pluginWindowResize");
this.resizeWindowHandler=Rico.eventHandle(this,"resizeWindow");
Rico.eventBind(window,"resize",this.resizeWindowHandler,false)
},unplugWindowResize:function(){if(!this.resizeWindowHandler){return
}Rico.eventUnbind(window,"resize",this.resizeWindowHandler,false);
this.resizeWindowHandler=null
},resizeWindow:function(){Rico.log("resizeWindow "+this.tableId+" lastRow="+this.lastRowPos+" resizeState="+this.resizeState);
if(this.resizeState=="finish"){Rico.log("resizeWindow postponed");
this.resizeState="resize";
return
}if(!this.sizeTo||this.sizeTo=="fixed"){this.sizeDivs();
return
}if(this.sizeTo=="parent"&&Rico.getStyle(this.outerDiv.parentNode,"display")=="none"){return
}Rico.log("resizeWindow: about to adjustPageSize");
var a=this.pageSize;
this.adjustPageSize();
this.finishResize(a)
},finishResize:function(b){Rico.log("finishResize "+this.tableId);
if(this.pageSize>b&&this.buffer.totalRows>0){this.isPartialBlank=true;
var a=this.adjustRow(this.lastRowPos);
this.buffer.fetch(a)
}else{if(this.pageSize<b){if(this.options.onRefreshComplete){this.options.onRefreshComplete(this.contentStartPos,this.contentStartPos+this.pageSize-1)
}}}this.resizeState="finish";
Rico.runLater(20,this,"finishResize2");
Rico.log("Resize "+this.tableId+" complete. old size="+b+" new size="+this.pageSize)
},finishResize2:function(){Rico.log("finishResize2 "+this.tableId+": resizeState="+this.resizeState);
this.sizeDivs();
this.updateHeightDiv();
if(this.resizeState=="resize"){this.resizeWindow()
}else{this.resizeState=""
}},topOfLastPage:function(){return Math.max(this.buffer.totalRows-this.pageSize,0)
},updateHeightDiv:function(){var b=this.topOfLastPage();
var a=b?this.scrollDiv.clientHeight+Math.floor(this.rowHeight*(b+0.4)):1;
Rico.log("updateHeightDiv, ht="+a+" scrollDiv.clientHeight="+this.scrollDiv.clientHeight+" rowsNotDisplayed="+b);
this.shadowDiv.style.height=a+"px"
},autoRemoveRows:function(a){if(!this.rowHeight){return
}var c=Math.ceil(a/this.rowHeight);
if(this.sizeTo=="data"){c=Math.max(c,this.pageSize-this.buffer.totalRows)
}Rico.log("autoRemoveRows overage="+a+" removeCnt="+c);
for(var b=0;
b<c;
b++){this.removeRow()
}},removeRow:function(){if(this.pageSize<=this.options.minPageRows){return
}this.pageSize--;
for(var b=0;
b<this.headerColCnt;
b++){var a=this.columns[b].cell(this.pageSize);
this.columns[b].dataColDiv.removeChild(a)
}},autoAppendRows:function(a){if(!this.rowHeight){return
}var c=Math.floor(a/this.rowHeight);
Rico.log("autoAppendRows overage="+a+" cnt="+c+" rowHt="+this.rowHeight);
for(var b=0;
b<c;
b++){if(this.sizeTo=="data"&&this.pageSize>=this.buffer.totalRows){break
}this.appendBlankRow()
}},appendBlankRow:function(){if(this.pageSize>=this.options.maxPageRows){return
}Rico.log("appendBlankRow #"+this.pageSize);
var a=this.defaultRowClass(this.pageSize);
for(var d=0;
d<this.headerColCnt;
d++){var b=document.createElement("div");
b.className="ricoLG_cell "+a;
b.id=this.tableId+"_"+this.pageSize+"_"+d;
this.columns[d].dataColDiv.appendChild(b);
if(this.columns[d]._create){this.columns[d]._create(b,this.pageSize)
}else{b.innerHTML="&nbsp;"
}if(this.columns[d].format.canDrag&&Rico.registerDraggable){Rico.registerDraggable(new Rico.LiveGridDraggable(this,this.pageSize,d),this.options.dndMgrIdx)
}}this.pageSize++
},defaultRowClass:function(b){var a;
if(b%2==0){a="ricoLG_evenRow"
}else{a="ricoLG_oddRow"
}return a
},handleMenuClick:function(f){if(!this.menu){return
}this.cancelMenu();
this.unhighlight();
var b;
var a=Rico.eventElement(f);
if(a.className=="ricoLG_highlightDiv"){b=this.highlightIdx
}else{a=Rico.getParentByTagName(a,"div","ricoLG_cell");
if(!a){return
}b=this.winCellIndex(a);
if((this.options.highlightSection&(b.tabIdx+1))==0){return
}}this.highlight(b);
this.highlightEnabled=false;
if(this.hideScroll){this.scrollDiv.style.overflow="hidden"
}this.menuIdx=b;
if(!this.menu.div){this.menu.createDiv()
}this.menu.liveGrid=this;
if(this.menu.buildGridMenu){var d=this.menu.buildGridMenu(b.row,b.column,b.tabIdx);
if(!d){return
}}if(this.options.highlightElem=="selection"&&!this.isSelected(b.cell)){this.selectCell(b.cell)
}var c=this;
this.menu.showmenu(f,function(){c.closeMenu()
});
return false
},closeMenu:function(){if(!this.menuIdx){return
}if(this.hideScroll){this.scrollDiv.style.overflow=""
}this.highlightEnabled=true;
this.menuIdx=null
},winCellIndex:function(b){var d=b.id.lastIndexOf("_",b.id.length);
var a=b.id.lastIndexOf("_",d-1)+1;
var f=parseInt(b.id.substr(d+1));
var e=parseInt(b.id.substr(a,d));
return{row:e,column:f,tabIdx:this.columns[f].tabIdx,cell:b}
},datasetIndex:function(b){var a=this.winCellIndex(b);
a.row+=this.buffer.windowPos;
a.onBlankRow=(a.row>=this.buffer.endPos());
return a
},attachHighlightEvents:function(a){switch(this.options.highlightElem){case"selection":Rico.eventBind(a,"mousedown",this.options.mouseDownHandler,false);
a.ondrag=function(){return false
};
a.onselectstart=function(){return false
};
break;
case"cursorRow":case"cursorCell":Rico.eventBind(a,"mouseover",this.options.rowOverHandler,false);
break
}},detachHighlightEvents:function(a){switch(this.options.highlightElem){case"selection":Rico.eventUnbind(a,"mousedown",this.options.mouseDownHandler,false);
a.ondrag=null;
a.onselectstart=null;
break;
case"cursorRow":case"cursorCell":Rico.eventUnbind(a,"mouseover",this.options.rowOverHandler,false);
break
}},getVisibleSelection:function(){var d=[];
if(this.SelectIdxStart&&this.SelectIdxEnd){var b=Math.max(Math.min(this.SelectIdxEnd.row,this.SelectIdxStart.row)-this.buffer.startPos,this.buffer.windowStart);
var a=Math.min(Math.max(this.SelectIdxEnd.row,this.SelectIdxStart.row)-this.buffer.startPos,this.buffer.windowEnd-1);
var g=Math.min(this.SelectIdxEnd.column,this.SelectIdxStart.column);
var f=Math.max(this.SelectIdxEnd.column,this.SelectIdxStart.column);
for(var h=b;
h<=a;
h++){for(var j=g;
j<=f;
j++){d.push({row:h-this.buffer.windowStart,column:j})
}}}if(this.SelectCtrl){for(var e=0;
e<this.SelectCtrl.length;
e++){if(this.SelectCtrl[e].row>=this.buffer.windowStart&&this.SelectCtrl[e].row<this.buffer.windowEnd){d.push({row:this.SelectCtrl[e].row-this.buffer.windowStart,column:this.SelectCtrl[e].column})
}}}return d
},updateSelectOutline:function(){if(!this.SelectIdxStart||!this.SelectIdxEnd){return
}var d=Math.max(Math.min(this.SelectIdxEnd.row,this.SelectIdxStart.row),this.buffer.windowStart);
var c=Math.min(Math.max(this.SelectIdxEnd.row,this.SelectIdxStart.row),this.buffer.windowEnd-1);
if(d>c){this.HideSelection();
return
}var g=Math.min(this.SelectIdxEnd.column,this.SelectIdxStart.column);
var e=Math.max(this.SelectIdxEnd.column,this.SelectIdxStart.column);
var h=this.columns[g].cell(d-this.buffer.windowStart).offsetTop;
var j=this.columns[g].cell(c-this.buffer.windowStart);
var b=j.offsetTop+j.offsetHeight;
var l=this.columns[g].dataCell.offsetLeft;
var k=this.columns[e].dataCell.offsetLeft;
var a=k+this.columns[e].dataCell.offsetWidth;
this.highlightDiv[0].style.top=this.highlightDiv[3].style.top=this.highlightDiv[1].style.top=(this.hdrHt+h-1)+"px";
this.highlightDiv[2].style.top=(this.hdrHt+b-1)+"px";
this.highlightDiv[3].style.left=(l-2)+"px";
this.highlightDiv[0].style.left=this.highlightDiv[2].style.left=(l-1)+"px";
this.highlightDiv[1].style.left=(a-1)+"px";
this.highlightDiv[0].style.width=this.highlightDiv[2].style.width=(a-l-1)+"px";
this.highlightDiv[1].style.height=this.highlightDiv[3].style.height=(b-h)+"px";
for(var f=0;
f<4;
f++){this.highlightDiv[f].style.display=""
}},HideSelection:function(){var b;
if(this.options.highlightMethod!="class"){for(b=0;
b<this.highlightDiv.length;
b++){this.highlightDiv[b].style.display="none"
}}if(this.options.highlightMethod!="outline"){var a=this.getVisibleSelection();
Rico.log("HideSelection "+a.length);
for(b=0;
b<a.length;
b++){this.unhighlightCell(this.columns[a[b].column].cell(a[b].row))
}}},ShowSelection:function(){if(this.options.highlightMethod!="class"){this.updateSelectOutline()
}if(this.options.highlightMethod!="outline"){var a=this.getVisibleSelection();
for(var b=0;
b<a.length;
b++){this.highlightCell(this.columns[a[b].column].cell(a[b].row))
}}},ClearSelection:function(){Rico.log("ClearSelection");
this.HideSelection();
this.SelectIdxStart=null;
this.SelectIdxEnd=null;
this.SelectCtrl=[]
},selectCell:function(a){this.ClearSelection();
this.SelectIdxStart=this.SelectIdxEnd=this.datasetIndex(a);
this.ShowSelection()
},AdjustSelection:function(a){var b=this.datasetIndex(a);
if(this.SelectIdxStart.tabIdx!=b.tabIdx){return
}this.HideSelection();
this.SelectIdxEnd=b;
this.ShowSelection()
},RefreshSelection:function(){var a=this.getVisibleSelection();
for(var b=0;
b<a.length;
b++){this.columns[a[b].column].displayValue(a[b].row)
}},FillSelection:function(b,f){if(this.SelectIdxStart&&this.SelectIdxEnd){var e=Math.min(this.SelectIdxEnd.row,this.SelectIdxStart.row);
var d=Math.max(this.SelectIdxEnd.row,this.SelectIdxStart.row);
var j=Math.min(this.SelectIdxEnd.column,this.SelectIdxStart.column);
var g=Math.max(this.SelectIdxEnd.column,this.SelectIdxStart.column);
for(var a=e;
a<=d;
a++){for(var k=j;
k<=g;
k++){this.buffer.setValue(a,k,b,f)
}}}if(this.SelectCtrl){for(var h=0;
h<this.SelectCtrl.length;
h++){this.buffer.setValue(this.SelectCtrl[h].row,this.SelectCtrl[h].column,b,f)
}}this.RefreshSelection()
},selectMouseDown:function(d){if(this.highlightEnabled==false){return true
}this.cancelMenu();
var a=Rico.eventElement(d);
if(!Rico.eventLeftClick(d)){return true
}a=Rico.getParentByTagName(a,"div","ricoLG_cell");
if(!a){return true
}Rico.eventStop(d);
var c=this.datasetIndex(a);
if(c.onBlankRow){return true
}Rico.log("selectMouseDown @"+c.row+","+c.column);
if(d.ctrlKey){if(!this.SelectIdxStart||this.options.highlightMethod!="class"){return true
}if(!this.isSelected(a)){this.highlightCell(a);
this.SelectCtrl.push(this.datasetIndex(a))
}else{for(var b=0;
b<this.SelectCtrl.length;
b++){if(this.SelectCtrl[b].row==c.row&&this.SelectCtrl[b].column==c.column){this.unhighlightCell(a);
this.SelectCtrl.splice(b,1);
break
}}}}else{if(d.shiftKey){if(!this.SelectIdxStart){return true
}this.AdjustSelection(a)
}else{this.selectCell(a);
this.pluginSelect()
}}return false
},pluginSelect:function(){if(this.selectPluggedIn){return
}var a=this.tbody[this.SelectIdxStart.tabIdx];
Rico.eventBind(a,"mouseover",this.options.mouseOverHandler,false);
Rico.eventBind(this.outerDiv,"mouseup",this.options.mouseUpHandler,false);
this.selectPluggedIn=true
},unplugSelect:function(){if(!this.selectPluggedIn){return
}var a=this.tbody[this.SelectIdxStart.tabIdx];
Rico.eventUnbind(a,"mouseover",this.options.mouseOverHandler,false);
Rico.eventUnbind(this.outerDiv,"mouseup",this.options.mouseUpHandler,false);
this.selectPluggedIn=false
},selectMouseUp:function(b){this.unplugSelect();
var a=Rico.eventElement(b);
a=Rico.getParentByTagName(a,"div","ricoLG_cell");
if(!a){return
}if(this.SelectIdxStart&&this.SelectIdxEnd){this.AdjustSelection(a)
}else{this.ClearSelection()
}},selectMouseOver:function(b){var a=Rico.eventElement(b);
a=Rico.getParentByTagName(a,"div","ricoLG_cell");
if(!a){return
}this.AdjustSelection(a);
Rico.eventStop(b)
},isSelected:function(a){if(this.options.highlightMethod!="outline"){return Rico.hasClass(a,this.options.highlightClass)
}if(!this.SelectIdxStart||!this.SelectIdxEnd){return false
}var c=Math.max(Math.min(this.SelectIdxEnd.row,this.SelectIdxStart.row),this.buffer.windowStart);
var b=Math.min(Math.max(this.SelectIdxEnd.row,this.SelectIdxStart.row),this.buffer.windowEnd-1);
if(c>b){return false
}var e=Math.min(this.SelectIdxEnd.column,this.SelectIdxStart.column);
var d=Math.max(this.SelectIdxEnd.column,this.SelectIdxStart.column);
var f=this.datasetIndex(a);
return(c<=f.row&&f.row<=b&&e<=f.column&&f.column<=d)
},highlightCell:function(a){Rico.addClass(a,this.options.highlightClass)
},unhighlightCell:function(a){if(a){Rico.removeClass(a,this.options.highlightClass)
}},selectRow:function(a){for(var b=0;
b<this.columns.length;
b++){this.highlightCell(this.columns[b].cell(a))
}},unselectRow:function(a){for(var b=0;
b<this.columns.length;
b++){this.unhighlightCell(this.columns[b].cell(a))
}},rowMouseOver:function(c){if(!this.highlightEnabled){return
}var a=Rico.eventElement(c);
a=Rico.getParentByTagName(a,"div","ricoLG_cell");
if(!a){return
}var b=this.winCellIndex(a);
if((this.options.highlightSection&(b.tabIdx+1))==0){return
}this.highlight(b)
},highlight:function(a){if(this.options.highlightMethod!="outline"){this.cursorSetClass(a)
}if(this.options.highlightMethod!="class"){this.cursorOutline(a)
}this.highlightIdx=a
},cursorSetClass:function(e){switch(this.options.highlightElem){case"menuCell":case"cursorCell":if(this.highlightIdx){this.unhighlightCell(this.highlightIdx.cell)
}this.highlightCell(e.cell);
break;
case"menuRow":case"cursorRow":if(this.highlightIdx){this.unselectRow(this.highlightIdx.row)
}var b=this.options.highlightSection&1;
var a=this.options.highlightSection&2;
var f=b?0:this.options.frozenColumns;
var d=a?this.columns.length:this.options.frozenColumns;
for(var g=f;
g<d;
g++){this.highlightCell(this.columns[g].cell(e.row))
}break;
default:return
}},cursorOutline:function(c){var d;
switch(this.options.highlightElem){case"menuCell":case"cursorCell":d=this.highlightDiv[c.tabIdx];
d.style.left=(this.columns[c.column].dataCell.offsetLeft-1)+"px";
d.style.width=this.columns[c.column].colWidth;
this.highlightDiv[1-c.tabIdx].style.display="none";
break;
case"menuRow":case"cursorRow":d=this.highlightDiv[0];
var b=this.options.highlightSection&1;
var a=this.options.highlightSection&2;
d.style.left=b?"0px":this.frozenTabs.style.width;
d.style.width=((b?this.frozenTabs.offsetWidth:0)+(a?this.innerDiv.offsetWidth:0)-4)+"px";
break;
default:return
}d.style.top=(this.hdrHt+c.row*this.rowHeight-1)+"px";
d.style.height=(this.rowHeight-1)+"px";
d.style.display=""
},unhighlight:function(){switch(this.options.highlightElem){case"menuCell":case"cursorCell":if(this.highlightIdx){this.unhighlightCell(this.highlightIdx.cell)
}if(!this.highlightDiv){return
}for(var a=0;
a<2;
a++){this.highlightDiv[a].style.display="none"
}break;
case"menuRow":case"cursorRow":if(this.highlightIdx){this.unselectRow(this.highlightIdx.row)
}if(this.highlightDiv){this.highlightDiv[0].style.display="none"
}break
}},resetContents:function(){Rico.log("resetContents");
this.ClearSelection();
this.buffer.clear();
this.clearRows();
this.clearBookmark()
},setImages:function(){for(var a=0;
a<this.columns.length;
a++){this.columns[a].setImage()
}},findSortedColumn:function(){for(var a=0;
a<this.columns.length;
a++){if(this.columns[a].isSorted()){return a
}}return -1
},findColumnsBySpec:function(b,c){var a=[];
for(var d=0;
d<this.options.columnSpecs.length;
d++){if(this.options.columnSpecs[d][b]==c){a.push(d)
}}return a
},setSortUI:function(c,b){Rico.log("setSortUI: "+c+" "+b);
var a=this.findSortedColumn();
if(a>=0){b=this.columns[a].getSortDirection()
}else{if(typeof b!="string"){b=Rico.ColumnConst.SORT_ASC
}else{b=b.toUpperCase();
if(b!=Rico.ColumnConst.SORT_DESC){b=Rico.ColumnConst.SORT_ASC
}}switch(typeof c){case"string":a=this.findColumnsBySpec("id",c);
break;
case"number":a=c;
break
}}if(typeof(a)!="number"||a<0){return
}this.clearSort();
this.columns[a].setSorted(b);
this.buffer.sortBuffer(a)
},clearSort:function(){for(var a=0;
a<this.columns.length;
a++){this.columns[a].setUnsorted()
}},clearFilters:function(){for(var a=0;
a<this.columns.length;
a++){this.columns[a].setUnfiltered(true)
}if(this.options.filterHandler){this.options.filterHandler()
}},filterCount:function(){for(var a=0,b=0;
a<this.columns.length;
a++){if(this.columns[a].isFiltered()){b++
}}return b
},sortHandler:function(){this.cancelMenu();
this.ClearSelection();
this.setImages();
var a=this.findSortedColumn();
if(a<0){return
}Rico.log("sortHandler: sorting column "+a);
this.buffer.sortBuffer(a);
this.clearRows();
this.scrollDiv.scrollTop=0;
this.buffer.fetch(0)
},filterHandler:function(){Rico.log("filterHandler");
this.cancelMenu();
if(this.buffer.processingRequest){this.queueFilter=true;
return
}this.unplugScroll();
this.ClearSelection();
this.setImages();
this.clearBookmark();
this.clearRows();
this.buffer.fetch(-1);
Rico.runLater(10,this,"pluginScroll")
},clearBookmark:function(){if(this.bookmark){this.bookmark.innerHTML="&nbsp;"
}},bookmarkHandler:function(a,d){var b;
if(isNaN(a)||!this.bookmark){return
}var c=this.buffer.totalRows;
if(c<d){d=c
}if(c<=0){b=Rico.getPhraseById("bookmarkNoMatch")
}else{if(d<0){b=Rico.getPhraseById("bookmarkNoRec")
}else{if(this.buffer.foundRowCount){b=Rico.getPhraseById("bookmarkExact",a,d,c)
}else{b=Rico.getPhraseById("bookmarkAbout",a,d,c)
}}}this.bookmark.innerHTML=b
},clearRows:function(){if(this.isBlank==true){return
}for(var a=0;
a<this.columns.length;
a++){this.columns[a].clearColumn()
}this.isBlank=true
},refreshContents:function(j){Rico.log("refreshContents1 "+this.tableId+": startPos="+j+" lastRow="+this.lastRowPos+" PartBlank="+this.isPartialBlank+" pageSize="+this.pageSize);
this.hideMsg();
this.cancelMenu();
this.unhighlight();
if(this.queueFilter){Rico.log("refreshContents: cancelling refresh because filter has changed");
this.queueFilter=false;
this.filterHandler();
return
}this.highlightEnabled=this.options.highlightSection!="none";
var h=this.buffer.startPos>j;
var d=h?this.buffer.startPos:j;
this.contentStartPos=d+1;
var b=Math.min(this.buffer.startPos+this.buffer.size,j+this.pageSize);
this.buffer.setWindow(d,b);
Rico.log("refreshContents2 "+this.tableId+": cStartPos="+d+" cEndPos="+b+" vPrecedesBuf="+h+" b.startPos="+this.buffer.startPos);
if(j==this.lastRowPos&&!this.isPartialBlank&&!this.isBlank){return
}this.isBlank=false;
var m=this.options.onRefreshComplete;
if((j+this.pageSize<this.buffer.startPos)||(this.buffer.startPos+this.buffer.size<j)||(this.buffer.size==0)){this.clearRows();
if(m){m(this.contentStartPos,b)
}return
}Rico.log("refreshContents: contentStartPos="+d+" contentEndPos="+b+" viewPrecedesBuffer="+h);
var n=b-d;
var f=this.pageSize-n;
var k=h?0:n;
var e=h?f:0;
for(var a=0;
a<n;
a++){for(var l=0;
l<this.columns.length;
l++){this.columns[l].displayValue(a+e)
}}for(var g=0;
g<f;
g++){this.blankRow(g+k)
}if(this.options.highlightElem=="selection"){this.ShowSelection()
}this.isPartialBlank=f>0;
this.lastRowPos=j;
Rico.log("refreshContents complete, startPos="+j);
if(m){m(this.contentStartPos,b)
}},scrollToRow:function(a){var b=this.rowToPixel(a);
Rico.log("scrollToRow, rowOffset="+a+" pixel="+b);
this.scrollDiv.scrollTop=b;
if(this.options.onscroll){this.options.onscroll(this,a)
}},scrollUp:function(){this.moveRelative(-1)
},scrollDown:function(){this.moveRelative(1)
},pageUp:function(){this.moveRelative(-this.pageSize)
},pageDown:function(){this.moveRelative(this.pageSize)
},adjustRow:function(a){var b=this.topOfLastPage();
if(b==0||!a){return 0
}return Math.min(b,a)
},rowToPixel:function(a){return this.adjustRow(a)*this.rowHeight
},pixeltorow:function(c){var b=this.topOfLastPage();
if(b==0){return 0
}var a=parseInt(c/this.rowHeight,10);
return Math.min(b,a)
},moveRelative:function(b){var a=Math.max(this.scrollDiv.scrollTop+b*this.rowHeight,0);
a=Math.min(a,this.scrollDiv.scrollHeight);
this.scrollDiv.scrollTop=a
},pluginScroll:function(){if(this.scrollPluggedIn){return
}Rico.log("pluginScroll: wheelEvent="+this.wheelEvent);
Rico.eventBind(this.scrollDiv,"scroll",this.scrollEventFunc,false);
for(var a=0;
a<2;
a++){Rico.eventBind(this.tabs[a],this.wheelEvent,this.wheelEventFunc,false)
}this.scrollPluggedIn=true
},unplugScroll:function(){if(!this.scrollPluggedIn){return
}Rico.log("unplugScroll");
Rico.eventUnbind(this.scrollDiv,"scroll",this.scrollEventFunc,false);
for(var a=0;
a<2;
a++){Rico.eventUnbind(this.tabs[a],this.wheelEvent,this.wheelEventFunc,false)
}this.scrollPluggedIn=false
},handleWheel:function(a){var b=0;
if(a.wheelDelta){if(Rico.isOpera){b=a.wheelDelta/120
}else{if(Rico.isWebKit){b=-a.wheelDelta/12
}else{b=-a.wheelDelta/120
}}}else{if(a.detail){b=a.detail/3
}}if(b){this.moveRelative(b)
}Rico.eventStop(a);
return false
},handleScroll:function(g){if(this.scrollTimeout){clearTimeout(this.scrollTimeout)
}this.setHorizontalScroll();
var a=this.scrollDiv.scrollTop;
var b=this.lastScrollPos-a;
if(b==0){return
}var d=this.pixeltorow(a);
if(d==this.lastRowPos&&!this.isPartialBlank&&!this.isBlank){return
}var f=new Date();
Rico.log("handleScroll, newrow="+d+" scrtop="+a);
if(this.options.highlightElem=="selection"){this.HideSelection()
}this.buffer.fetch(d);
if(this.options.onscroll){this.options.onscroll(this,d)
}this.scrollTimeout=Rico.runLater(1200,this,"scrollIdle");
this.lastScrollPos=this.scrollDiv.scrollTop;
var c=new Date()
},scrollIdle:function(){if(this.options.onscrollidle){this.options.onscrollidle()
}}};
Rico.LiveGridColumn=function(a,d,c,b){this.initialize(a,d,c,b)
};
Rico.LiveGridColumn.prototype={initialize:function(liveGrid,colIdx,hdrInfo,tabIdx){Rico.extend(this,new Rico.TableColumnBase());
this.baseInit(liveGrid,colIdx,hdrInfo,tabIdx);
this.buffer=liveGrid.buffer;
if(typeof(this.format.type)!="string"||this.format.EntryType=="tinyMCE"){this.format.type="html"
}if(typeof this.isNullable!="boolean"){this.isNullable=/number|date/.test(this.format.type)
}this.isText=/html|text/.test(this.format.type);
Rico.log(" sortable="+this.sortable+" filterable="+this.filterable+" hideable="+this.hideable+" isNullable="+this.isNullable+" isText="+this.isText);
this.fixHeaders(this.liveGrid.tableId,this.options.hdrIconsFirst);
if(this["format_"+this.format.type]){this._format=this["format_"+this.format.type]
}if(this.format.control){if(typeof this.format.control=="string"){this.format.control=eval(this.format.control)
}for(var property in this.format.control){if(property.charAt(0)=="_"){Rico.log("Copying control property "+property+" to "+this);
this[property]=this.format.control[property]
}}}},sortAsc:function(){this.setColumnSort(Rico.ColumnConst.SORT_ASC)
},sortDesc:function(){this.setColumnSort(Rico.ColumnConst.SORT_DESC)
},setColumnSort:function(a){this.liveGrid.clearSort();
this.setSorted(a);
if(this.liveGrid.options.saveColumnInfo.sort){this.liveGrid.setCookie()
}if(this.options.sortHandler){this.options.sortHandler()
}},isSortable:function(){return this.sortable
},isSorted:function(){return this.currentSort!=Rico.ColumnConst.UNSORTED
},getSortDirection:function(){return this.currentSort
},toggleSort:function(){if(this.buffer&&this.buffer.totalRows==0){return
}if(this.currentSort==Rico.ColumnConst.SORT_ASC){this.sortDesc()
}else{this.sortAsc()
}},setUnsorted:function(){this.setSorted(Rico.ColumnConst.UNSORTED)
},setSorted:function(a){this.currentSort=a
},canFilter:function(){return this.filterable
},getFilterText:function(){var c=[];
for(var b=0;
b<this.filterValues.length;
b++){var a=this.filterValues[b];
c.push(a==""?Rico.getPhraseById("filterBlank"):a)
}switch(this.filterOp){case"EQ":return"= "+c.join(", ");
case"NE":return Rico.getPhraseById("filterNot",c.join(", "));
case"LT":return"< "+c[0];
case"GT":return"> "+c[0];
case"LE":return"<= "+c[0];
case"GE":return">= "+c[0];
case"LIKE":return Rico.getPhraseById("filterLike",c[0]);
case"NULL":return Rico.getPhraseById("filterEmpty");
case"NOTNULL":return Rico.getPhraseById("filterNotEmpty")
}return"?"
},getFilterQueryParm:function(){if(this.filterType==Rico.ColumnConst.UNFILTERED){return""
}var a="&f["+this.index+"][op]="+this.filterOp;
a+="&f["+this.index+"][len]="+this.filterValues.length;
for(var b=0;
b<this.filterValues.length;
b++){a+="&f["+this.index+"]["+b+"]="+escape(this.filterValues[b])
}return a
},setUnfiltered:function(a){this.filterType=Rico.ColumnConst.UNFILTERED;
if(this.liveGrid.options.saveColumnInfo.filter){this.liveGrid.setCookie()
}if(this.removeFilterFunc){this.removeFilterFunc()
}if(this.options.filterHandler&&!a){this.options.filterHandler()
}},setFilterEQ:function(){this.setUserFilter("EQ")
},setFilterNE:function(){this.setUserFilter("NE")
},addFilterNE:function(){this.filterValues.push(this.userFilter);
if(this.liveGrid.options.saveColumnInfo.filter){this.liveGrid.setCookie()
}if(this.options.filterHandler){this.options.filterHandler()
}},setFilterGE:function(){this.setUserFilter("GE")
},setFilterLE:function(){this.setUserFilter("LE")
},setFilterKW:function(a){if(a!=""&&a!=null){this.setFilter("LIKE",a,Rico.ColumnConst.USERFILTER)
}else{this.setUnfiltered(false)
}},setUserFilter:function(a){this.setFilter(a,this.userFilter,Rico.ColumnConst.USERFILTER)
},setSystemFilter:function(a,b){this.setFilter(a,b,Rico.ColumnConst.SYSTEMFILTER)
},setFilter:function(a,c,b,d){this.filterValues=typeof(c)=="object"?c:[c];
this.filterType=b;
this.filterOp=a;
if(b==Rico.ColumnConst.USERFILTER&&this.liveGrid.options.saveColumnInfo.filter){this.liveGrid.setCookie()
}this.removeFilterFunc=d;
if(this.options.filterHandler){this.options.filterHandler()
}},isFiltered:function(){return this.filterType==Rico.ColumnConst.USERFILTER
},filterChange:function(a){var b=Rico.eventElement(a);
if(b.value==this.liveGrid.options.FilterAllToken){this.setUnfiltered()
}else{this.setFilter("EQ",b.value,Rico.ColumnConst.USERFILTER,function(){b.selectedIndex=0
})
}},nFilterChange:function(b){var d=Rico.eventElement(b);
if(d.value==this.liveGrid.options.FilterAllToken){this.setUnfiltered()
}else{var c=d.value.substr(0,2);
var a=d.value.substr(2);
this.setFilter(c,a,Rico.ColumnConst.USERFILTER,function(){d.selectedIndex=0
})
}},filterClear:function(a){this.filterField.value="";
this.setUnfiltered()
},filterKeypress:function(c){var a=Rico.eventElement(c);
if(typeof this.lastKeyFilter!="string"){this.lastKeyFilter=""
}if(this.lastKeyFilter==a.value){return
}var b=a.value;
Rico.log("filterKeypress: "+this.index+" "+b);
this.lastKeyFilter=b;
if(b==""||b=="*"){this.setUnfiltered()
}else{this.setFilter("LIKE",b,Rico.ColumnConst.USERFILTER,function(){a.value=""
})
}},mFilterSelectClick:function(a){Rico.eventStop(a);
if(this.mFilter.style.display!="none"){this.mFilterFinish(a);
if(Rico.isIE&&Rico.ieVersion<=6){this.filterField.focus()
}else{this.filterField.blur()
}}else{var b=Rico.cumulativeOffset(this.filterField);
this.mFilter.style.top=(b.top+this.filterField.offsetHeight)+"px";
this.mFilter.style.left=b.left+"px";
this.mFilter.style.width=Math.min(this.filterField.offsetWidth,parseInt(this.colWidth,10))+"px";
Rico.show(this.mFilter);
this.mFilterFocus.focus()
}},mFilterFinish:function(g){if(!this.mFilterChange){Rico.hide(this.mFilter);
return
}if(this.mFilterInputs[0].checked){this.mFilterReset();
Rico.hide(this.mFilter);
this.setUnfiltered();
return
}var c=[];
var a=[];
for(var d=1;
d<this.mFilterInputs.length;
d++){if(this.mFilterInputs[d].checked){c.push(this.mFilterInputs[d].value);
a.push(this.mFilterLabels[d].innerHTML)
}}if(c.length>0){var f=a.join(", ");
this.filterField.options[0].text=f;
this.filterField.title=f;
Rico.hide(this.mFilter);
this.mFilterChange=false;
var b=this;
this.setFilter("EQ",c,Rico.ColumnConst.USERFILTER,function(){b.mFilterReset()
})
}else{alert("Please select at least one value")
}},mFilterReset:function(){var a=this.mFilterLabels[0].innerHTML;
this.filterField.options[0].text=a;
this.filterField.title=a
},mFilterAllClick:function(c){var a=this.mFilterInputs[0].checked;
for(var b=1;
b<this.mFilterInputs.length;
b++){this.mFilterInputs[b].checked=a
}this.mFilterChange=true
},mFilterOtherClick:function(a){this.mFilterInputs[0].checked=false;
this.mFilterChange=true
},format_text:function(a){if(typeof a!="string"){return"&nbsp;"
}else{return a.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;")
}},format_number:function(a){if(typeof a=="undefined"||a==""||a==null){return"&nbsp;"
}else{return Rico.formatNumber(a,this.format)
}},format_datetime:function(a){if(typeof a=="undefined"||a==""||a==null){return"&nbsp;"
}else{var b=Rico.setISO8601(a);
if(!b){return a
}return(this.format.prefix||"")+Rico.formatDate(b,this.format.dateFmt||"translateDateTime")+(this.format.suffix||"")
}},format_utcaslocaltime:function(a){if(typeof a=="undefined"||a==""||a==null){return"&nbsp;"
}else{var c=new Date();
var b=Rico.setISO8601(a,-c.getTimezoneOffset());
if(!b){return a
}return(this.format.prefix||"")+Rico.formatDate(b,this.format.dateFmt||"translateDateTime")+(this.format.suffix||"")
}},format_date:function(a){if(typeof a=="undefined"||a==null||a==""){return"&nbsp;"
}else{var b=Rico.setISO8601(a);
if(!b){return a
}return(this.format.prefix||"")+Rico.formatDate(b,this.format.dateFmt||"translateDate")+(this.format.suffix||"")
}},fixHeaders:function(d,e){if(this.sortable){var c=Rico.eventHandle(this,"toggleSort");
switch(this.options.headingSort){case"link":var b=Rico.wrapChildren(this.hdrCellDiv,"ricoSort",undefined,"a");
b.href="javascript:void(0)";
Rico.eventBind(b,"click",c);
break;
case"hover":Rico.eventBind(this.hdrCellDiv,"click",c);
break
}}this.imgFilter=document.createElement("span");
this.imgFilter.style.display="none";
this.imgFilter.className="rico-icon ricoLG_filterCol";
this.imgSort=document.createElement("span");
this.imgSort.style.display="none";
this.imgSort.style.verticalAlign="top";
if(e){this.hdrCellDiv.insertBefore(this.imgSort,this.hdrCellDiv.firstChild);
this.hdrCellDiv.insertBefore(this.imgFilter,this.hdrCellDiv.firstChild)
}else{this.hdrCellDiv.appendChild(this.imgFilter);
this.hdrCellDiv.appendChild(this.imgSort)
}if(!this.format.filterUI){Rico.eventBind(this.imgFilter,"click",Rico.eventHandle(this,"filterClick"),false)
}},filterClick:function(a){if(this.filterType==Rico.ColumnConst.USERFILTER&&this.filterOp=="LIKE"){this.liveGrid.openKeyword(this.index)
}},getValue:function(a){return this.buffer.getWindowCell(a,this.index)
},getBufferStyle:function(a){return this.buffer.getWindowStyle(a,this.index)
},setValue:function(b,a){this.buffer.setWindowValue(b,this.index,a)
},_format:function(a){return a
},_display:function(a,b){b.innerHTML=this._format(a)
},_export:function(a){return this._format(a)
},exportBuffer:function(a){return this._export(this.buffer.getValue(a,this.index))
},displayValue:function(c){var a=this.getValue(c);
if(a==null){this.clearCell(c);
return
}var b=this.cell(c);
this._display(a,b,c);
if(this.buffer.options.acceptStyle){b.style.cssText=this.getBufferStyle(c)
}}};
Rico.TableColumn={};
Rico.TableColumn.checkboxKey=function(a){this.initialize(a)
};
Rico.TableColumn.checkboxKey.prototype={initialize:function(a){this._checkboxes=[];
this._spans=[];
this._KeyHash={};
this._showKey=a
},_create:function(a,b){this._checkboxes[b]=Rico.createFormField(a,"input","checkbox",this.liveGrid.tableId+"_chkbox_"+this.index+"_"+b);
this._spans[b]=Rico.createFormField(a,"span",null,this.liveGrid.tableId+"_desc_"+this.index+"_"+b);
this._clear(a,b);
Rico.eventBind(this._checkboxes[b],"click",Rico.eventHandle(this,"_onclick"))
},_onclick:function(c){var b=Rico.eventElement(c);
var d=parseInt(b.id.substr((b.id.lastIndexOf("_",b.id.length)+1)));
var a=this.getValue(d);
if(b.checked){this._addChecked(a)
}else{this._remChecked(a)
}},_clear:function(b,c){var a=this._checkboxes[c];
a.checked=false;
a.style.display="none";
this._spans[c].innerHTML=""
},_display:function(a,c,d){var b=this._checkboxes[d];
b.style.display="";
b.checked=this._KeyHash[a];
if(this._showKey){this._spans[d].innerHTML=a
}},_SelectedKeys:function(){return Rico.keys(this._KeyHash)
},_addChecked:function(a){this._KeyHash[a]=1
},_remChecked:function(a){delete this._KeyHash[a]
}};
Rico.TableColumn.checkbox=function(b,c,a,d){this.initialize(b,c,a,d)
};
Rico.TableColumn.checkbox.prototype={initialize:function(b,c,a,d){this._checkedValue=b;
this._uncheckedValue=c;
this._defaultValue=a||false;
this._readOnly=d||false;
this._checkboxes=[]
},_create:function(a,b){this._checkboxes[b]=Rico.createFormField(a,"input","checkbox",this.liveGrid.tableId+"_chkbox_"+this.index+"_"+b);
this._clear(a,b);
if(this._readOnly){this._checkboxes[b].disabled=true
}else{Rico.eventBind(this._checkboxes[b],"click",Rico.eventHandle(this,"_onclick"))
}},_onclick:function(c){var a=Rico.eventElement(c);
var d=parseInt(a.id.substr((a.id.lastIndexOf("_",a.id.length)+1)));
var b=a.checked?this._checkedValue:this._uncheckedValue;
this.setValue(d,b)
},_clear:function(b,c){var a=this._checkboxes[c];
a.checked=this._defaultValue;
a.style.display="none"
},_display:function(a,c,d){var b=this._checkboxes[d];
b.style.display="";
b.checked=(a==this._checkedValue)
}};
Rico.TableColumn.textbox=function(c,b,a){this.initialize(c,b,a)
};
Rico.TableColumn.textbox.prototype={initialize:function(c,b,a){this._boxSize=c;
this._boxMaxLen=b;
this._readOnly=a||false;
this._textboxes=[]
},_create:function(b,c){var a=Rico.createFormField(b,"input","text",this.liveGrid.tableId+"_txtbox_"+this.index+"_"+c);
a.size=this._boxSize;
a.maxLength=this._boxMaxLen;
this._textboxes[c]=a;
this._clear(b,c);
if(this._readOnly){a.disabled=true
}else{Rico.eventBind(a,"change",Rico.eventHandle(this,"_onchange"))
}},_onchange:function(b){var a=Event.element(b);
var c=parseInt(a.id.substr((a.id.lastIndexOf("_",a.id.length)+1)));
this.setValue(c,a.value)
},_clear:function(b,c){var a=this._textboxes[c];
a.value="";
a.style.display="none"
},_display:function(a,c,d){var b=this._textboxes[d];
b.style.display="";
b.value=a
}};
Rico.TableColumn.bgColor=function(){};
Rico.TableColumn.bgColor.prototype={_clear:function(a,b){a.style.backgroundColor=""
},_display:function(a,b,c){b.style.backgroundColor=a
}};
Rico.TableColumn.link=function(a,c,b){this.initialize(a,c,b)
};
Rico.TableColumn.link.prototype={initialize:function(a,c,b){this._href=a;
this._target=c;
this._linktext=b;
this._anchors=[]
},_create:function(c,d){var b=c.appendChild(document.createElement("a"));
if(this._target){b.target=this._target
}b.href="";
b.innerHTML=Rico.isIE?"&nbsp;":"";
this._anchors[d]=b
},_clear:function(a,b){this._anchors[b].style.display="none"
},_display:function(b,d,f){var c=this.liveGrid.buffer;
var a=this._href=="self"?b:this._href.replace(/\{\d+\}/g,function(g){var h=parseInt(g.substr(1),10);
return encodeURIComponent(c.getWindowValue(f,h))
});
var e=this._linktext||b;
if(a&&e){this._anchors[f].href=a;
this._anchors[f].innerHTML=e;
this._anchors[f].style.display=Rico.isIE?"inline-block":""
}else{this._clear(d,f)
}}};
Rico.TableColumn.image=function(a,b){this.initialize(a,b)
};
Rico.TableColumn.image.prototype={initialize:function(a,b){this._img=[];
this._prefix=a||"";
this._suffix=b||""
},_create:function(a,b){this._img[b]=Rico.createFormField(a,"img",null,this.liveGrid.tableId+"_img_"+this.index+"_"+b);
this._clear(a,b)
},_clear:function(b,c){var a=this._img[c];
a.style.display="none";
a.src=""
},_display:function(b,c,d){var a=this._img[d];
this._img[d].src=this._prefix+b+this._suffix;
a.style.display=""
}};
Rico.TableColumn.lookup=function(c,a,b){this.initialize(c,a,b)
};
Rico.TableColumn.lookup.prototype={initialize:function(d,a,c){this._map=d;
this._defaultCode=a||"";
this._defaultDesc=c||"&nbsp;";
var b=this;
this._sortfunc=function(e){return b._sortvalue(e)
};
this._codes=[];
this._descriptions=[]
},_create:function(a,b){this._descriptions[b]=Rico.createFormField(a,"span",null,this.liveGrid.tableId+"_desc_"+this.index+"_"+b);
this._codes[b]=Rico.createFormField(a,"input","hidden",this.liveGrid.tableId+"_code_"+this.index+"_"+b);
this._clear(a,b)
},_clear:function(a,b){this._codes[b].value=this._defaultCode;
this._descriptions[b].innerHTML=this._defaultDesc
},_sortvalue:function(a){return this._getdesc(a).replace(/&amp;/g,"&").replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&nbsp;/g," ")
},_getdesc:function(a){var b=this._map[a];
return(typeof b=="string")?b:this._defaultDesc
},_export:function(a){return this._getdesc(a)
},_display:function(a,b,c){this._codes[c].value=a;
this._descriptions[c].innerHTML=this._getdesc(a)
}};
Rico.TableColumn.MultiLine=function(){};
Rico.TableColumn.MultiLine.prototype={_display:function(a,c,d){var b=document.createElement("div");
b.innerHTML=this._format(a);
b.style.height="100%";
if(c.firstChild){c.replaceChild(b,c.firstChild)
}else{c.appendChild(b)
}}};
Rico.GridMenu=function(a){this.initialize(a)
};
Rico.GridMenu.prototype={initialize:function(a){this.options={width:"18em",dataMenuHandler:null};
Rico.extend(this.options,a||{});
Rico.extend(this,new Rico.Menu(this.options));
this.sortmenu=new Rico.Menu({width:"15em"});
this.filtermenu=new Rico.Menu({width:"22em"});
this.exportmenu=new Rico.Menu({width:"24em"});
this.hideshowmenu=new Rico.Menu({width:"22em"});
this.createDiv();
this.sortmenu.createDiv();
this.filtermenu.createDiv();
this.exportmenu.createDiv();
this.hideshowmenu.createDiv()
},buildGridMenu:function(a,i){this.clearMenu();
var o=this.liveGrid;
var f=o.buffer;
var m=f.totalRows;
var n=o.options.maxPrint;
var b=(a>=m);
var d=o.columns[i];
if(this.options.dataMenuHandler){var l=this.options.dataMenuHandler(o,a,i,b);
if(!l){return(this.itemCount>0)
}}if(d.sortable&&m>0){this.sortmenu.clearMenu();
this.addSubMenuItem(Rico.getPhraseById("gridmenuSortBy",d.displayName),this.sortmenu,false);
this.sortmenu.addMenuItemId("gridmenuSortAsc",function(){d.sortAsc()
},true);
this.sortmenu.addMenuItemId("gridmenuSortDesc",function(){d.sortDesc()
},true)
}this.filtermenu.clearMenu();
if(d.canFilter()){this.addSubMenuItem(Rico.getPhraseById("gridmenuFilterBy",d.displayName),this.filtermenu,false);
if(!d.format.filterUI&&(!b||d.filterType==Rico.ColumnConst.USERFILTER)){d.userFilter=d.getValue(a);
if(d.filterType==Rico.ColumnConst.USERFILTER){this.filtermenu.addMenuItemId("gridmenuRemoveFilter",function(){d.setUnfiltered(false)
},true);
if(d.filterOp=="LIKE"){this.filtermenu.addMenuItemId("gridmenuChgKeyword",function(){o.openKeyword(i)
},true)
}if(d.filterOp=="NE"&&!b){this.filtermenu.addMenuItemId("gridmenuExcludeAlso",function(){d.addFilterNE()
},true)
}}else{if(!b){this.filtermenu.addMenuItemId("gridmenuInclude",function(){d.setFilterEQ()
},true);
this.filtermenu.addMenuItemId("gridmenuGreaterThan",function(){d.setFilterGE()
},d.userFilter!="");
this.filtermenu.addMenuItemId("gridmenuLessThan",function(){d.setFilterLE()
},d.userFilter!="");
if(d.isText){this.filtermenu.addMenuItemId("gridmenuContains",function(){o.openKeyword(i)
},true)
}this.filtermenu.addMenuItemId("gridmenuExclude",function(){d.setFilterNE()
},true)
}}}if(o.filterCount()>0){this.filtermenu.addMenuItemId("gridmenuRemoveAll",function(){o.clearFilters()
},true)
}if(f.options.canRefresh){this.filtermenu.addMenuItemId("gridmenuRefresh",function(){o.filterHandler()
},true)
}}this.exportmenu.clearMenu();
if(n>0){this.addSubMenuItem(Rico.getPhraseById("gridmenuExport"),this.exportmenu,false);
if(f.printVisibleSQL&&typeof(f.dataSource)=="string"){this.exportmenu.addMenuItemId("gridmenuExportVis2Web",function(){f.printVisibleSQL("html")
});
this.exportmenu.addMenuItemId("gridmenuExportAll2Web",function(){f.printAllSQL("html")
},f.totalRows<=n);
this.exportmenu.addMenuBreak();
this.exportmenu.addMenuItemId("gridmenuExportVis2SS",function(){f.printVisibleSQL("xl")
});
this.exportmenu.addMenuItemId("gridmenuExportAll2SS",function(){f.printAllSQL("xl")
},f.totalRows<=n)
}else{this.exportmenu.addMenuItemId("gridmenuExportVis2Web",function(){f.printVisible()
});
this.exportmenu.addMenuItemId("gridmenuExportAll2Web",function(){f.printAll()
},f.totalRows<=n)
}}var k=o.listInvisible();
for(var e=0,j=0;
j<k.length;
j++){if(k[j].canHideShow()){e++
}}if(e>0||d.canHideShow()){this.hideshowmenu.clearMenu();
this.addSubMenuItem(Rico.getPhraseById("gridmenuHideShow"),this.hideshowmenu,false);
this.hideshowmenu.addMenuItemId("gridmenuChooseCols",function(){o.chooseColumns()
},true,false);
var h=o.columns.length-k.length;
var g=(h>1&&d.visible&&d.canHideShow());
this.hideshowmenu.addMenuItem(Rico.getPhraseById("gridmenuHide",d.displayName),function(){d.hideColumn()
},g);
if(k.length>1){this.hideshowmenu.addMenuItemId("gridmenuShowAll",function(){o.showAll()
})
}}return true
}};
if(typeof Rico=="undefined"){throw ("LiveGridAjax requires the Rico JavaScript framework")
}if(!Rico.Buffer){Rico.Buffer={}
}Rico.Buffer.AjaxLoadOnce=function(c,b,a){this.initialize(c,b,a)
};
Rico.Buffer.AjaxLoadOnce.prototype={initialize:function(c,b,a){Rico.extend(this,new Rico.Buffer.Base());
Rico.extend(this,Rico.Buffer.AjaxXMLMethods);
this.dataSource=c;
this.options.bufferTimeout=20000;
this.options.requestParameters=[];
this.options.waitMsg=Rico.getPhraseById("waitForData");
this.options.canFilter=true;
this.options.fmt="xml";
Rico.extend(this.options,b||{});
this.ajaxOptions={parameters:null,method:"get"};
Rico.extend(this.ajaxOptions,a||{});
this.requestCount=0;
this.processingRequest=false;
this.pendingRequest=-2;
this.fetchData=true;
this.sortParm={}
}};
Rico.Buffer.AjaxXMLMethods={fetch:function(b){if(this.fetchData){this.foundRowCount=true;
this.fetchData=false;
this.processingRequest=true;
this.liveGrid.showMsg(this.options.waitMsg);
this.timeoutHandler=Rico.runLater(this.options.bufferTimeout,this,"handleTimedOut");
this.ajaxOptions.parameters=this.formQueryHashXML(0,-1);
Rico.log("sending request");
var a=this;
if(typeof this.dataSource=="string"){this.ajaxOptions.onComplete=function(c){a.ajaxUpdate(b,c)
};
new Rico.ajaxRequest(this.dataSource,this.ajaxOptions)
}else{this.ajaxOptions.onComplete=function(d,f,c,e){a.jsUpdate(b,d,f,c,e)
};
this.dataSource(this.ajaxOptions)
}}else{if(b<0){this.applyFilters();
this.setTotalRows(this.size);
b=0
}this.liveGrid.refreshContents(b)
}},handleTimedOut:function(){Rico.log("Request Timed Out");
this.liveGrid.showMsg(Rico.getPhraseById("requestTimedOut"))
},formQueryHashXML:function(e,c){var d={id:this.liveGrid.tableId,page_size:(typeof c=="number")?c:this.totalRows,offset:e.toString()};
d[this.liveGrid.actionId]="query";
if(this.options.requestParameters){for(var f=0;
f<this.options.requestParameters.length;
f++){var g=this.options.requestParameters[f];
if(g.name!=undefined&&g.value!=undefined){d[g.name]=g.value
}else{var b=g.indexOf("=");
var h=g.substring(0,b);
var a=g.substring(b+1);
d[h]=a
}}}return d
},clearTimer:function(){if(typeof this.timeoutHandler!="number"){return
}window.clearTimeout(this.timeoutHandler);
delete this.timeoutHandler
},jsUpdate:function(a,c,e,b,d){this.clearTimer();
this.processingRequest=false;
Rico.log("jsUpdate: "+arguments.length);
if(d){Rico.log("jsUpdate: received error="+d);
this.liveGrid.showMsg(Rico.getPhraseById("requestError",d));
return
}this.rcvdRows=c.length;
if(typeof b=="number"){this.rowcntContent=b.toString();
this.rcvdRowCount=true;
this.foundRowCount=true;
Rico.log("jsUpdate: found RowCount="+this.rowcntContent)
}this.updateBuffer(a,c,e);
if(this.options.onAjaxUpdate){this.options.onAjaxUpdate()
}this.updateGrid(a);
if(this.options.TimeOut&&this.timerMsg){this.restartSessionTimer()
}if(this.pendingRequest>=-1){var f=this.pendingRequest;
Rico.log("jsUpdate: found pending request for offset="+f);
this.pendingRequest=-2;
this.fetch(f)
}},ajaxUpdate:function(a,c){this.clearTimer();
this.processingRequest=false;
if(c.status!=200){Rico.log("ajaxUpdate: received http error="+c.status);
this.liveGrid.showMsg(Rico.getPhraseById("httpError",c.status));
return
}Rico.log("ajaxUpdate: startPos="+a);
this._responseHandler=this["processResponse"+this.options.fmt.toUpperCase()];
if(!this._responseHandler(a,c)){return
}if(this.options.onAjaxUpdate){this.options.onAjaxUpdate()
}this.updateGrid(a);
if(this.options.TimeOut&&this.timerMsg){this.restartSessionTimer()
}if(this.pendingRequest>=-1){var b=this.pendingRequest;
Rico.log("ajaxUpdate: found pending request for offset="+b);
this.pendingRequest=-2;
this.fetch(b)
}},processResponseXML:function(k,f){var o=f.responseXML;
if(f.responseText.substring(0,4)=="<!--"){var m=f.responseText.indexOf("-->");
if(m==-1){this.liveGrid.showMsg("Web server error - client side debugging may be enabled");
return false
}o=Rico.createXmlDocument();
o.loadXML(f.responseText.substring(m+3))
}if(!o){alert("Data provider returned an invalid XML response");
Rico.log("Data provider returned an invalid XML response");
return false
}var d=o.getElementsByTagName("ajax-response");
if(d==null||d.length!=1){alert("Received invalid response from server");
return false
}Rico.log("Processing ajax-response");
this.rcvdRows=0;
this.rcvdRowCount=false;
var b=d[0];
var a=b.getElementsByTagName("debug");
for(var g=0;
g<a.length;
g++){Rico.log("ajaxUpdate: debug msg "+g+": "+Rico.getContentAsString(a[g],this.options.isEncoded))
}var l=b.getElementsByTagName("error");
if(l.length>0){var c=Rico.getContentAsString(l[0],this.options.isEncoded);
alert("Data provider returned an error:\n"+c);
Rico.log("Data provider returned an error:\n"+c);
return false
}var j=b.getElementsByTagName("rows")[0];
if(!j){Rico.log("ajaxUpdate: invalid response");
this.liveGrid.showMsg(Rico.getPhraseById("invalidResponse"));
return false
}var n=b.getElementsByTagName("rowcount");
if(n&&n.length==1){this.rowcntContent=Rico.getContentAsString(n[0],this.options.isEncoded);
this.rcvdRowCount=true;
this.foundRowCount=true;
Rico.log("ajaxUpdate: found RowCount="+this.rowcntContent)
}this.updateUI=j.getAttribute("update_ui")=="true";
this.rcvdOffset=j.getAttribute("offset");
Rico.log("ajaxUpdate: rcvdOffset="+this.rcvdOffset);
var h=this.dom2jstable(j);
var e=(this.options.acceptStyle)?this.dom2jstableStyle(j):false;
this.rcvdRows=h.length;
this.updateBuffer(k,h,e);
return true
},dom2jstableStyle:function(f,h){Rico.log("dom2jstableStyle start");
var e=[];
var a=f.getElementsByTagName("tr");
for(var d=h||0;
d<a.length;
d++){var g=[];
var c=a[d].getElementsByTagName("td");
for(var b=0;
b<c.length;
b++){g[b]=c[b].getAttribute("style")||""
}e.push(g)
}Rico.log("dom2jstableStyle end");
return e
},processResponseJSON:function(a,d){var c=Rico.getJSON(d);
if(!c||c==null){alert("Data provider returned an invalid JSON response");
Rico.log("Data provider returned an invalid JSON response");
return false
}if(c.debug){for(var b=0;
b<c.debug.length;
b++){Rico.writeDebugMsg("debug msg "+b+": "+c.debug[b])
}}if(c.error){alert("Data provider returned an error:\n"+c.error);
Rico.writeDebugMsg("Data provider returned an error:\n"+c.error);
return false
}if(c.rowcount){this.rowcntContent=c.rowcount;
this.rcvdRowCount=true;
this.foundRowCount=true;
Rico.writeDebugMsg("loadRows, found RowCount="+c.rowcount)
}this.rcvdRows=c.rows.length;
this.updateBuffer(a,c.rows,c.styles);
return true
},updateBuffer:function(c,a,b){this.baseRows=a;
this.attr=b;
Rico.log("updateBuffer: # of rows="+this.rcvdRows);
this.rcvdRowCount=true;
this.rowcntContent=this.rcvdRows;
if(typeof this.delayedSortCol=="number"){this.sortBuffer(this.delayedSortCol)
}this.applyFilters();
this.startPos=0
},updateGrid:function(f){Rico.log("updateGrid, size="+this.size+" rcv cnt type="+typeof(this.rowcntContent));
var e;
if(this.rcvdRowCount==true){Rico.log("found row cnt: "+this.rowcntContent);
var d=parseInt(this.rowcntContent,10);
var b=this.totalRows;
if(!isNaN(d)&&d!=b){this.setTotalRows(d);
e=Math.min(this.liveGrid.topOfLastPage(),f);
Rico.log("updateGrid: new rowcnt="+d+" newpos="+e);
this.liveGrid.scrollToRow(e);
if(this.isInRange(e)){this.liveGrid.refreshContents(e)
}else{this.fetch(e)
}return
}}else{var a=f+this.rcvdRows;
if(a>this.totalRows){var c=a;
Rico.log("extending totrows to "+c);
this.setTotalRows(c)
}}e=this.liveGrid.pixeltorow(this.liveGrid.scrollDiv.scrollTop);
Rico.log("updateGrid: newpos="+e);
this.liveGrid.refreshContents(e)
}};
Rico.Buffer.AjaxSQL=function(c,b,a){this.initialize(c,b,a)
};
Rico.Buffer.AjaxSQL.prototype={initialize:function(c,b,a){Rico.extend(this,new Rico.Buffer.AjaxLoadOnce());
Rico.extend(this,Rico.Buffer.AjaxSQLMethods);
this.dataSource=c;
this.options.canFilter=true;
this.options.largeBufferSize=7;
this.options.nearLimitFactor=1;
this.options.canRefresh=true;
Rico.extend(this.options,b||{});
Rico.extend(this.ajaxOptions,a||{})
}};
Rico.Buffer.AjaxSQLMethods={registerGrid:function(a){this.liveGrid=a;
this.sessionExpired=false;
this.timerMsg=document.getElementById(a.tableId+"_timer");
if(this.options.TimeOut&&this.timerMsg){if(!this.timerMsg.title){this.timerMsg.title=Rico.getPhraseById("sessionExpireMinutes")
}this.restartSessionTimer()
}},setBufferSize:function(a){this.maxFetchSize=Math.max(50,parseInt(this.options.largeBufferSize*a,10));
this.nearLimit=parseInt(this.options.nearLimitFactor*a,10);
this.maxBufferSize=this.maxFetchSize*3
},restartSessionTimer:function(){if(this.sessionExpired==true){return
}this.sessionEndTime=(new Date()).getTime()+this.options.TimeOut*60000;
if(this.sessionTimer){clearTimeout(this.sessionTimer)
}this.updateSessionTimer()
},updateSessionTimer:function(){var b=(new Date()).getTime();
if(b>this.sessionEndTime){this.displaySessionTimer(Rico.getPhraseById("sessionExpired"));
this.timerMsg.style.backgroundColor="red";
this.sessionExpired=true
}else{var a=Math.ceil((this.sessionEndTime-b)/60000);
this.displaySessionTimer(a);
this.sessionTimer=Rico.runLater(10000,this,"updateSessionTimer")
}},displaySessionTimer:function(a){this.timerMsg.innerHTML="&nbsp;"+a+"&nbsp;"
},refresh:function(b){var a=this.liveGrid.lastRowPos;
this.clear();
if(b){this.setTotalRows(0);
this.foundRowCount=false
}this.liveGrid.clearBookmark();
this.liveGrid.clearRows();
this.fetch(a)
},fetch:function(e){Rico.log("AjaxSQL fetch: offset="+e+", lastOffset="+this.lastOffset);
if(this.processingRequest){Rico.log("AjaxSQL fetch: queue request");
this.pendingRequest=e;
return
}if((typeof e=="undefined")||(e<0)){this.clear();
this.setTotalRows(0);
this.foundRowCount=false;
e=0
}var d=this.lastOffset;
this.lastOffset=e;
if(this.isInRange(e)){Rico.log("AjaxSQL fetch: in buffer");
this.liveGrid.refreshContents(e);
if(e>d){if(e+this.liveGrid.pageSize<this.endPos()-this.nearLimit){return
}if(this.endPos()==this.totalRows&&this.foundRowCount){return
}}else{if(e<d){if(e>this.startPos+this.nearLimit){return
}if(this.startPos==0){return
}}else{return
}}}if(e>=this.totalRows&&this.foundRowCount){return
}this.processingRequest=true;
Rico.log("AjaxSQL fetch: processing offset="+e);
var c=this.getFetchOffset(e);
var a=this.getFetchSize(c);
var f=false;
this.liveGrid.showMsg(this.options.waitMsg);
this.timeoutHandler=Rico.runLater(this.options.bufferTimeout,this,"handleTimedOut");
this.ajaxOptions.parameters=this.formQueryHashSQL(c,a,this.options.fmt);
this.requestCount++;
Rico.log("sending req #"+this.requestCount);
var b=this;
if(typeof this.dataSource=="string"){this.ajaxOptions.onComplete=function(g){b.ajaxUpdate(c,g)
};
new Rico.ajaxRequest(this.dataSource,this.ajaxOptions)
}else{this.ajaxOptions.onComplete=function(h,j,g,i){b.jsUpdate(c,h,j,g,i)
};
this.dataSource(this.ajaxOptions)
}},formQueryHashSQL:function(g,h,d){var k=this.formQueryHashXML(g,h);
if(!this.foundRowCount){k.get_total="true"
}if(d){k._fmt=d
}Rico.extend(k,this.sortParm);
for(var b=0;
b<this.liveGrid.columns.length;
b++){var j=this.liveGrid.columns[b];
if(j.filterType==Rico.ColumnConst.UNFILTERED){continue
}var a=typeof(j.format.filterCol)=="number"?j.format.filterCol:j.index;
k["f["+a+"][op]"]=j.filterOp;
k["f["+a+"][len]"]=j.filterValues.length;
for(var e=0;
e<j.filterValues.length;
e++){var f=j.filterValues[e];
if(j.filterOp=="LIKE"&&f.indexOf("*")==-1){f="*"+f+"*"
}k["f["+a+"]["+e+"]"]=f
}}return k
},getFetchSize:function(a){var b=0;
if(a>=this.startPos){var c=this.maxFetchSize+a;
b=c-a;
if(a==0&&b<this.maxFetchSize){b=this.maxFetchSize
}Rico.log("getFetchSize/append, adjustedSize="+b+" adjustedOffset="+a+" endFetchOffset="+c)
}else{b=Math.min(this.startPos-a,this.maxFetchSize)
}return b
},getFetchOffset:function(b){var a=b;
if(b>this.startPos){a=Math.max(b,this.endPos())
}else{if(b+this.maxFetchSize>=this.startPos){a=Math.max(this.startPos-this.maxFetchSize,0)
}}return a
},updateBuffer:function(d,a,b){Rico.log("updateBuffer: start="+d+", # of rows="+this.rcvdRows);
if(this.rows.length==0){this.rows=a;
this.attr=b;
this.startPos=d
}else{if(d>this.startPos){if(this.startPos+this.rows.length<d){this.rows=a;
this.attr=b;
this.startPos=d
}else{this.rows=this.rows.concat(a.slice(0,a.length));
if(this.attr&&b){this.attr=this.attr.concat(b.slice(0,b.length))
}if(this.rows.length>this.maxBufferSize){var c=this.rows.length;
this.rows=this.rows.slice(this.rows.length-this.maxBufferSize,this.rows.length);
if(this.attr){this.attr=this.attr.slice(this.attr.length-this.maxBufferSize,this.attr.length)
}this.startPos=this.startPos+(c-this.rows.length)
}}}else{if(d+a.length<this.startPos){this.rows=a;
this.attr=b
}else{this.rows=a.slice(0,this.startPos).concat(this.rows);
if(b){this.attr=b.slice(0,this.startPos).concat(this.attr)
}if(this.maxBufferSize&&this.rows.length>this.maxBufferSize){this.rows=this.rows.slice(0,this.maxBufferSize);
if(this.attr){this.attr=this.attr.slice(0,this.maxBufferSize)
}}}this.startPos=d
}}this.size=this.rows.length
},sortBuffer:function(b){this.sortParm={};
var a=this.liveGrid.columns[b];
if(this.options.sortParmFmt){this.sortParm.sort_col=a[this.options.sortParmFmt];
this.sortParm.sort_dir=a.getSortDirection()
}else{this.sortParm["s"+b]=a.getSortDirection()
}this.clear()
},printAllSQL:function(a){var c=this.formQueryHashSQL(0,this.liveGrid.options.maxPrint,a);
c.hidden=this.liveGrid.listInvisible("index").join(",");
var b=this.dataSource+"?"+Rico.toQueryString(c);
window.open(b,"",this.liveGrid.options.exportWindow)
},printVisibleSQL:function(a){var c=this.formQueryHashSQL(this.liveGrid.contentStartPos-1,this.liveGrid.pageSize,a);
c.hidden=this.liveGrid.listInvisible("index").join(",");
var b=this.dataSource+"?"+Rico.toQueryString(c);
window.open(b,"",this.liveGrid.options.exportWindow)
},_printAll:function(){this.liveGrid.exportStart();
this.ajaxOptions.parameters=this.formQueryHashSQL(0,this.liveGrid.options.maxPrint);
var a=this;
this.ajaxOptions.onComplete=function(){a._jsExport()
};
this.dataSource(this.ajaxOptions)
},_jsExport:function(b,d,a,c){Rico.log("_jsExport: "+arguments.length);
if(c){Rico.log("_jsExport: received error="+c);
this.liveGrid.showMsg(Rico.getPhraseById("requestError",c));
return
}this.exportBuffer(b,0);
this.liveGrid.exportFinish()
}};
if(typeof Rico=="undefined"){throw ("LiveGridForms requires the Rico JavaScript framework")
}Rico.TableEdit=function(a){this.initialize(a)
};
Rico.TableEdit.prototype={initialize:function(b){Rico.log("Rico.TableEdit initialize: "+b.tableId);
this.grid=b;
this.options={maxDisplayLen:20,panelHeight:200,panelWidth:500,compact:false,RecordName:Rico.getPhraseById("record"),updateURL:window.location.href,showSaveMsg:"errors"};
Rico.extend(this.options,b.options);
var a=this;
this.menu=b.menu;
this.menu.options.dataMenuHandler=function(d,f,g,e){return a.editMenu(d,f,g,e)
};
this.menu.ignoreClicks();
this.editText=Rico.getPhraseById("editRecord",this.options.RecordName);
this.cloneText=Rico.getPhraseById("cloneRecord",this.options.RecordName);
this.delText=Rico.getPhraseById("deleteRecord",this.options.RecordName);
this.addText=Rico.getPhraseById("addRecord",this.options.RecordName);
this.buttonHover=new Rico.HoverSet();
this.dateRegExp=/^\s*(\w+)(\W)(\w+)(\W)(\w+)/i;
this.createKeyArray();
if(typeof(this.options.ConfirmDeleteCol)!="number"){this.options.ConfirmDeleteCol=this.keys.length>0?-2:-1
}this.createEditDiv();
this.saveMsg=Rico.$(b.tableId+"_savemsg");
Rico.eventBind(document,"click",Rico.eventHandle(this,"clearSaveMsg"));
this.extraMenuItems=[];
this.responseHandler=function(c){a.processResponse(c)
};
Rico.log("Rico.TableEdit.initialize complete")
},createKeyArray:function(){this.keys=[];
for(var a=0;
a<this.grid.columns.length;
a++){if(this.grid.columns[a].format&&this.grid.columns[a].format.isKey){this.keys.push({colidx:a})
}}},createEditDiv:function(){this.requestCount=1;
this.formPopup=this.createWindow();
Rico.addClass(this.formPopup.content.parentNode,"ricoLG_editDiv");
if(this.options.canEdit||this.options.canAdd){this.startForm();
this.createForm(this.form)
}else{var a=this.createButton(Rico.getPhraseById("close"));
Rico.eventBind(a,"click",Rico.eventHandle(this,"cancelEdit"),false);
this.createForm(this.formPopup.contentDiv)
}this.editDivCreated=true;
this.responseDialog=this.grid.createDiv("editResponse",document.body);
this.responseDialog.style.display="none";
var b=document.createElement("button");
b.appendChild(document.createTextNode(Rico.getPhraseById("ok")));
Rico.eventBind(b,"click",Rico.eventHandle(this,"ackResponse"));
this.responseDialog.appendChild(b);
this.responseDiv=this.grid.createDiv("editResponseText",this.responseDialog);
if(this.panelGroup){Rico.log("createEditDiv complete, requestCount="+this.requestCount);
Rico.runLater(50,this,"initPanelGroup")
}},createWindow:function(){var a=this;
return new Rico.Window("",{closeFunc:function(){a.makeFormInvisible()
},overflow:this.options.ColGroups?"hidden":"auto"})
},initPanelGroup:function(){this.requestCount--;
Rico.log("initPanelGroup: "+this.requestCount);
if(this.requestCount>0){return
}var a=parseInt(this.options.panelWidth,10);
if(this.form){if(Rico.isWebKit){this.formPopup.container.style.display="block"
}this.options.bgColor=Rico.Color.createColorFromBackground(this.form).toString()
}this.formPopup.container.style.display="none";
this.formPanels=new Rico.TabbedPanel(this.panelGroup,this.options)
},notEmpty:function(a){return typeof(a)!="undefined"
},startForm:function(){this.form=document.createElement("form");
this.form.onsubmit=function(){return false
};
this.form.autocomplete="off";
this.formPopup.contentDiv.appendChild(this.form);
var e=document.createElement("div");
e.className="ButtonBar";
var d=e.appendChild(this.createButton(Rico.getPhraseById("saveRecord",this.options.RecordName)));
Rico.eventBind(d,"click",Rico.eventHandle(this,"TESubmit"),false);
d=e.appendChild(this.createButton(Rico.getPhraseById("cancel")));
Rico.eventBind(d,"click",Rico.eventHandle(this,"cancelEdit"),false);
this.form.appendChild(e);
this.hiddenFields=document.createElement("div");
this.hiddenFields.style.display="none";
this.action=this.appendHiddenField(this.grid.actionId,"");
var c,a;
for(c=0;
c<this.grid.columns.length;
c++){a=this.grid.columns[c].format;
if(a&&a.FormView&&a.FormView=="hidden"){this.appendHiddenField(a.FieldName,a.ColData)
}}for(var b=0;
b<this.keys.length;
b++){this.keys[b].keyField=this.appendHiddenField("_k"+this.keys[b].colidx,"")
}this.form.appendChild(this.hiddenFields)
},createButton:function(b){var a=document.createElement("a");
a.href="javascript:void(0)";
a.innerHTML=b;
a.className="RicoButton";
if(Rico.theme.button){Rico.addClass(a,Rico.theme.button)
}this.buttonHover.add(a);
return a
},createPanel:function(c){var e=false;
for(var b=0;
b<this.grid.columns.length;
b++){var a=this.grid.columns[b].format;
if(!a){continue
}if(!a.EntryType){continue
}if(a.EntryType=="H"){continue
}if(a.FormView&&a.FormView=="hidden"){continue
}var d=a.ColGroupIdx||0;
if(d==c){e=true;
break
}}if(!e){return null
}this.panelHdr[c]=document.createElement("li");
this.panelHdr[c].innerHTML=this.options.ColGroups[c];
this.panelHdrs.appendChild(this.panelHdr[c]);
this.panelContent[c]=document.createElement("div");
this.panelContents.appendChild(this.panelContent[c]);
this.panelActualIdx[c]=this.panelCnt++;
return this.createFormTable(this.panelContent[c],"tabContent")
},createForm:function(e){var c,f,a,d,b=[];
this.panelCnt=0;
this.panelHdr=[];
this.panelContent=[];
if(this.options.ColGroups){this.panelGroup=document.createElement("div");
this.panelGroup.className="tabPanelGroup";
this.panelHdrs=document.createElement("ul");
this.panelGroup.appendChild(this.panelHdrs);
this.panelContents=document.createElement("div");
this.panelContents.className="tabContentContainer";
this.panelGroup.appendChild(this.panelContents);
this.panelActualIdx=[];
e.appendChild(this.panelGroup);
if(this.grid.direction=="rtl"){for(c=this.options.ColGroups.length-1;
c>=0;
c--){b[c]=this.createPanel(c)
}}else{for(c=0;
c<this.options.ColGroups.length;
c++){b[c]=this.createPanel(c)
}}e.appendChild(this.panelGroup)
}else{f=document.createElement("div");
f.className="noTabContent";
b[0]=this.createFormTable(f);
e.appendChild(f)
}for(c=0;
c<this.grid.columns.length;
c++){a=this.grid.columns[c].format;
if(!a){continue
}d=a.ColGroupIdx||0;
if(b[d]){this.appendFormField(this.grid.columns[c],b[d])
}if(typeof a.pattern=="string"){switch(a.pattern){case"email":a.regexp=/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,3})|(aero|coop|info|museum|name))$/;
break;
case"float-unsigned":a.regexp=/^\d+(\.\d+)?$/;
break;
case"float-signed":a.regexp=/^[-+]?\d+(\.\d+)?$/;
break;
case"int-unsigned":a.regexp=/^\d+$/;
break;
case"int-signed":a.regexp=/^[-+]?\d+$/;
break;
default:a.regexp=new RegExp(a.pattern);
break
}}}},createFormTable:function(b){var a=document.createElement("table");
a.border=0;
b.appendChild(a);
return a
},appendHiddenField:function(a,b){var c=Rico.createFormField(this.hiddenFields,"input","hidden",a,a);
c.value=b;
return c
},appendFormField:function(c,i){var b=c.format;
if(!b.EntryType){return
}if(b.EntryType=="H"){return
}if(b.FormView){return
}Rico.log("appendFormField: "+c.displayName+" - "+b.EntryType);
var j=b.noFormBreak&&i.rows.length>0?i.rows[i.rows.length-1]:i.insertRow(-1);
var h=j.insertCell(-1);
c.formLabel=h;
if(h.noWrap){h.noWrap=true
}var f=j.insertCell(-1);
if(f.noWrap){f.noWrap=true
}h.id="lbl_"+b.FieldName;
var e,a=b.FieldName;
switch(b.EntryType){case"TA":case"tinyMCE":e=Rico.createFormField(f,"textarea",null,a);
e.cols=b.TxtAreaCols;
e.rows=b.TxtAreaRows;
e.innerHTML=b.ColData;
h.style.verticalAlign="top";
break;
case"R":case"RL":e=Rico.createFormField(f,"div",null,a);
if(b.DescriptionField){e.RicoUpdate=b.DescriptionField
}if(b.MultiSelect){Rico.addClass(e,"MultiSelect")
}if(b.isNullable&&!b.MultiSelect){this.addSelectNone(e)
}this.selectValuesRequest(e,c);
break;
case"N":e=Rico.createFormField(f,"select",null,a);
if(b.isNullable){this.addSelectNone(e)
}Rico.eventBind(e,"change",Rico.eventHandle(this,"checkSelectNew"));
this.selectValuesRequest(e,c);
e=document.createElement("span");
e.className="ricoEditLabel";
e.id="labelnew__"+b.FieldName;
e.innerHTML="&nbsp;&nbsp;&nbsp;"+Rico.getPhraseById("formNewValue").replace(" ","&nbsp;");
f.appendChild(e);
a="textnew__"+b.FieldName;
e=Rico.createFormField(f,"input","text",a,a);
break;
case"S":case"SL":if(b.ReadOnly){e=Rico.createFormField(f,"input","text",a,a);
this.initField(e,b)
}else{e=Rico.createFormField(f,"select",null,a);
if(b.MultiSelect){e.multiple=true
}if(b.SelectRows){e.size=parseInt(b.SelectRows,10)
}if(b.isNullable&&!b.MultiSelect){this.addSelectNone(e)
}if(b.DescriptionField){e.RicoUpdate=b.DescriptionField;
Rico.eventBind(e,"change",Rico.eventHandle(this,"selectClick"),false)
}this.selectValuesRequest(e,c)
}break;
case"D":if(!b.isNullable){b.required=true
}if(!b.dateFmt){b.dateFmt=Rico.dateFmt
}if(!b.Help){b.Help=b.dateFmt
}if(typeof b.min=="string"){b.min=Rico.setISO8601(b.min)||new Date(b.min)
}if(typeof b.max=="string"){b.max=Rico.setISO8601(b.max)||new Date(b.max)
}b.Length=Math.max(b.dateFmt.length,10);
if(Rico.inputtypes.date){e=Rico.createFormField(f,"input","date",a,a);
e.required=b.required;
if(b.min){e.min=Rico.toISO8601String(b.min,3)
}if(b.max){e.max=Rico.toISO8601String(b.max,3)
}e.required=b.required;
b.SelectCtl=null
}else{e=Rico.createFormField(f,"input","text",a,a)
}this.initField(e,b);
break;
case"I":if(!b.isNullable){b.required=true
}if(!b.pattern){b.pattern="int-signed"
}if(Rico.inputtypes.number){e=Rico.createFormField(f,"input","number",a,a);
e.required=b.required;
e.min=b.min;
e.max=b.max;
e.step=1
}else{e=Rico.createFormField(f,"input","text",a,a)
}if(typeof b.min=="string"){b.min=parseInt(b.min,10)
}if(typeof b.max=="string"){b.max=parseInt(b.max,10)
}this.initField(e,b);
break;
case"F":if(!b.isNullable){b.required=true
}if(!b.pattern){b.pattern="float-signed"
}e=Rico.createFormField(f,"input","text",a,a);
this.initField(e,b);
if(typeof b.min=="string"){b.min=parseFloat(b.min)
}if(typeof b.max=="string"){b.max=parseFloat(b.max)
}break;
default:e=Rico.createFormField(f,"input","text",a,a);
if(!b.isNullable&&b.EntryType!="T"){b.required=true
}this.initField(e,b);
break
}if(e&&b.SelectCtl){Rico.EditControls.applyTo(c,e,b.EntryType=="D")
}var g="";
h.className="ricoEditLabel";
if(b.Help){h.title=b.Help;
g="&nbsp;<span class='rico-icon rico-info'></span>"
}var d=b.EntryType.length>1&&b.EntryType.charAt(1)=="L"?c.next.displayName:c.displayName;
h.innerHTML=d+g
},addSelectNone:function(a){this.addSelectOption(a,this.options.TableSelectNone,Rico.getPhraseById("selectNone"))
},initField:function(b,a){if(a.Length){b.maxLength=a.Length;
b.size=Math.min(a.Length,this.options.maxDisplayLen)
}b.value=a.ColData
},selectClick:function(c){var b=Rico.eventElement(c);
if(b.readOnly){Rico.eventStop(c);
return false
}if(b.RicoUpdate){var a=b.options[b.selectedIndex];
Rico.$(b.RicoUpdate).value=a.innerHTML
}},radioClick:function(c){var b=Rico.eventElement(c);
if(b.readOnly){Rico.eventStop(c);
return false
}var a=Rico.getParentByTagName(b,"div");
if(a.RicoUpdate){Rico.$(a.RicoUpdate).value=b.nextSibling.innerHTML
}},checkSelectNew:function(a){this.updateSelectNew(Rico.eventElement(a))
},updateSelectNew:function(b){var a=(b.value==this.options.TableSelectNew)?"":"hidden";
Rico.$("labelnew__"+b.id).style.visibility=a;
Rico.$("textnew__"+b.id).style.visibility=a
},selectValuesRequest:function(g,f){var a=f.format;
if(a.SelectValues){var b=a.SelectValues.split(",");
for(var e=0;
e<b.length;
e++){this.addSelectOption(g,b[e],b[e],e)
}}else{this.requestCount++;
var d={},c=this;
Rico.extend(d,this.grid.buffer.ajaxOptions);
d.parameters=this.grid.buffer.formQueryHashXML(0,-1);
d.parameters.edit=f.index;
d.onComplete=function(h){c.selectValuesUpdate(g,h)
};
new Rico.ajaxRequest(this.grid.buffer.dataSource,d);
Rico.log("selectValuesRequest: "+a.FieldName)
}},selectValuesUpdate:function(a,c){var b=c.responseXML.getElementsByTagName("ajax-response");
Rico.log("selectValuesUpdate: "+c.status);
if(b==null||b.length!=1){return
}b=b[0];
var j=b.getElementsByTagName("error");
if(j.length>0){var g=Rico.getContentAsString(j[0],this.grid.buffer.isEncoded);
Rico.log("Data provider returned an error:\n"+g);
alert(Rico.getPhraseById("requestError",g));
return
}b=b.getElementsByTagName("response")[0];
var h=b.getElementsByTagName("rows")[0];
var k=this.grid.buffer.dom2jstable(h);
Rico.log("selectValuesUpdate: id="+a.id+" rows="+k.length);
for(var e=0;
e<k.length;
e++){if(k[e].length>0){var f=k[e][0];
var d=(k[e].length>1)?k[e][1]:f;
this.addSelectOption(a,f,d,e)
}}if(Rico.$("textnew__"+a.id)){this.addSelectOption(a,this.options.TableSelectNew,Rico.getPhraseById("selectNewVal"))
}if(this.panelGroup){Rico.runLater(50,this,"initPanelGroup")
}},addSelectOption:function(c,e,f,a){switch(c.tagName.toLowerCase()){case"div":var b=Rico.createFormField(c,"input",Rico.hasClass(c,"MultiSelect")?"checkbox":"radio",c.id+"_"+a,c.id);
b.value=e;
var d=document.createElement("label");
d.innerHTML=f;
d.htmlFor=b.id;
c.appendChild(d);
Rico.eventBind(b,"click",Rico.eventHandle(this,"radioClick"),false);
break;
case"select":Rico.addSelectOption(c,e,f);
break
}},clearSaveMsg:function(){if(this.saveMsg){this.saveMsg.innerHTML=""
}},addMenuItem:function(c,b,a){this.extraMenuItems.push({menuText:c,menuAction:b,enabled:a})
},editMenu:function(d,h,j,e){this.clearSaveMsg();
if(this.grid.buffer.sessionExpired==true||this.grid.buffer.startPos<0){return false
}this.rowIdx=h;
var g=Rico.$("pageTitle");
var f=g?g.innerHTML:document.title;
this.menu.addMenuHeading(f);
var a=this;
if(e==false){for(var b=0;
b<this.extraMenuItems.length;
b++){this.menu.addMenuItem(this.extraMenuItems[b].menuText,this.extraMenuItems[b].menuAction,this.extraMenuItems[b].enabled)
}this.menu.addMenuItem(this.editText,function(){a.editRecord()
},this.canEdit(h));
this.menu.addMenuItem(this.delText,function(){a.deleteRecord()
},this.canDelete(h));
if(this.options.canClone){this.menu.addMenuItem(this.cloneText,function(){a.cloneRecord()
},this.canAdd(h)&&this.canEdit(h))
}}this.menu.addMenuItem(this.addText,function(){a.addRecord()
},this.canAdd(h));
return true
},canAdd:function(a){return(typeof this.options.canAdd=="function")?this.options.canAdd(a):this.options.canAdd
},canEdit:function(a){return(typeof this.options.canEdit=="function")?this.options.canEdit(a):this.options.canEdit
},canDelete:function(a){return(typeof this.options.canDelete=="function")?this.options.canDelete(a):this.options.canDelete
},cancelEdit:function(a){Rico.eventStop(a);
this.makeFormInvisible();
this.grid.highlightEnabled=true;
this.menu.cancelmenu();
return false
},setField:function(g,m){var p=this.grid.columns[g].format;
var k=Rico.$(p.FieldName);
var n,j,f,c,b,h;
if(!k){return
}Rico.log("setField: "+p.FieldName+"="+m);
switch(k.tagName.toUpperCase()){case"DIV":c=k.getElementsByTagName("INPUT");
f={};
if(p.MultiSelect&&m){n=m.split(",");
for(var j=0;
j<n.length;
j++){f[n[j]]=1
}}else{f[m]=1
}for(j=0;
j<c.length;
j++){c[j].checked=f[c[j].value]==1
}break;
case"INPUT":if(p.EntryType=="D"){n=m.split(/\s|T/);
m=n[0];
if(this.isTextInput(k)){var l=m.toLowerCase()=="today"?new Date():Rico.setISO8601(m);
if(l){m=Rico.formatDate(l,p.dateFmt)
}}}k.value=m;
break;
case"SELECT":b=k.options;
f={};
if(p.MultiSelect&&m){n=m.split(",");
for(var j=0;
j<n.length;
j++){f[n[j]]=1
}for(j=0;
j<b.length;
j++){b[j].selected=f[b[j].value]==1
}}else{for(j=0;
j<b.length;
j++){if(b[j].value==m){k.selectedIndex=j;
break
}}}if(p.EntryType=="N"){h=Rico.$("textnew__"+k.id);
if(!h){alert('Warning: unable to find id "textnew__'+k.id+'"')
}h.value=m;
if(k.selectedIndex!=j){k.selectedIndex=b.length-1
}this.updateSelectNew(k)
}return;
case"TEXTAREA":k.value=m;
if(p.EntryType=="tinyMCE"&&typeof(tinyMCE)!="undefined"&&this.initialized){if(tinyMCE.updateContent){tinyMCE.updateContent(k.id)
}else{tinyMCE.execInstanceCommand(k.id,"mceSetContent",false,m)
}}return
}},setReadOnly:function(h){for(var g,f=0;
f<this.grid.columns.length;
f++){var b=this.grid.columns[f].format;
if(!b){continue
}var k=Rico.$(b.FieldName);
if(!k){continue
}switch(h){case"ins":g=!b.Writeable||b.ReadOnly||b.UpdateOnly;
break;
case"upd":g=!b.Writeable||b.ReadOnly||b.InsertOnly;
break;
default:g=false;
break
}switch(k.tagName.toUpperCase()){case"DIV":var c=k.getElementsByTagName("INPUT");
for(var d=0;
d<c.length;
d++){c[d].disabled=g
}break;
case"SELECT":if(b.EntryType=="N"){var a=Rico.$("textnew__"+k.id);
a.disabled=g
}k.disabled=g;
break;
case"TEXTAREA":case"INPUT":k.disabled=g;
if(b.selectIcon){b.selectIcon.style.display=g?"none":""
}break
}}},hideResponse:function(a){this.responseDiv.innerHTML=a;
this.responseDialog.style.display="none"
},showResponse:function(){var a=Rico.cumulativeOffset(this.grid.outerDiv);
a.top+=Rico.docScrollTop();
this.responseDialog.style.top=a.top+"px";
this.responseDialog.style.left=a.left+"px";
this.responseDialog.style.display=""
},processResponse:function(g){var d,f=true;
Rico.log("Processing response from form submittal: "+typeof(g));
this.responseDiv.innerHTML=g.responseText;
var e=Rico.select(".ricoFormResponse",this.responseDiv);
if(e){Rico.log("Found ricoFormResponse");
var c=Rico.trim(e[0].className).split(/\s+/)[1];
d=Rico.getPhraseById(c,this.options.RecordName)
}else{Rico.log("Processing response text");
var b=this.responseDiv.childNodes;
for(var a=b.length-1;
a>=0;
a--){if(b[a].nodeType==1&&b[a].nodeName!="P"&&b[a].nodeName!="DIV"&&b[a].nodeName!="BR"){this.responseDiv.removeChild(b[a])
}}d=Rico.stripTags(this.responseDiv.innerHTML);
f=(d.toLowerCase().indexOf("error")==-1)
}if(f&&this.options.showSaveMsg!="full"){this.hideResponse("");
this.grid.resetContents();
this.grid.buffer.foundRowCount=false;
this.grid.buffer.fetch(this.grid.lastRowPos||0);
if(this.saveMsg){this.saveMsg.innerHTML="&nbsp;"+d+"&nbsp;"
}}this.processCallback(this.options.onSubmitResponse);
Rico.log("Processing response completed")
},processCallback:function(callback){switch(typeof callback){case"string":return eval(callback);
case"function":return callback()
}},ackResponse:function(a){this.hideResponse("");
this.grid.highlightEnabled=true
},cloneRecord:function(){this.formPopup.setTitle(this.cloneText);
this.displayEditForm("ins")
},editRecord:function(){this.formPopup.setTitle(this.editText);
this.displayEditForm("upd")
},displayEditForm:function(e){this.grid.highlightEnabled=false;
this.menu.cancelmenu();
this.hideResponse(Rico.getPhraseById("saving"));
this.grid.outerDiv.style.cursor="auto";
this.action.value=e;
for(var d=0;
d<this.grid.columns.length;
d++){var f=this.grid.columns[d];
if(f.format){var b=f.getValue(this.rowIdx);
this.setField(d,b);
if(f.format.selectDesc){if(f.format.EntryType.length>1&&f.format.EntryType.charAt(1)=="L"){b=this.grid.columns[d+1].getValue(this.rowIdx)
}b=f._format(b);
if(b===""){b="&nbsp;"
}f.format.selectDesc.innerHTML=b
}if(f.format.SelectCtl){Rico.EditControls.displayClrImg(f,!f.format.InsertOnly)
}}}this.setReadOnly(e);
for(var a=0;
a<this.keys.length;
a++){this.keys[a].keyField.value=this.grid.buffer.getWindowValue(this.rowIdx,this.keys[a].colidx)
}this.makeFormVisible(this.rowIdx)
},addPrepare:function(){this.hideResponse(Rico.getPhraseById("saving"));
this.form.reset();
this.setReadOnly("ins");
this.action.value="ins";
for(var a=0;
a<this.grid.columns.length;
a++){var b=this.grid.columns[a];
if(b.format){this.setField(a,b.format.ColData);
if(b.format.SelectCtl){if(b.format.EntryType!="D"){Rico.EditControls.resetValue(b)
}Rico.EditControls.displayClrImg(b,!b.format.UpdateOnly)
}}}},addRecord:function(){this.menu.cancelmenu();
this.formPopup.setTitle(this.addText);
this.addPrepare();
this.makeFormVisible(-1);
if(this.formPanels){this.formPanels.select(0)
}},drillDown:function(b,a,c){return this.grid.drillDown.apply(this.grid,arguments)
},setDetailFilter:function(a,b){this.grid.setDetailFilter(a,b)
},makeFormVisible:function(k){this.formPopup.container.style.display="block";
var c=this.formPopup.container.offsetWidth;
var h=Rico.cumulativeOffset(this.grid.outerDiv);
var d=Rico.windowWidth();
this.formPopup.container.style.left=c+h.left>d?(d-c)+"px":(h.left+1)+"px";
var g=Rico.docScrollTop();
var a=this.formPopup.container.offsetHeight;
var f=h.top+this.grid.hdrHt+g;
var b=Rico.windowHeight()+g;
if(k>=0){f+=(k+1)*this.grid.rowHeight;
if(f+a>b){f-=(a+this.grid.rowHeight)
}}else{if(f+a>b){f=b-a-2
}}if(this.processCallback(this.options.formOpen)===false){return
}this.formPopup.openPopup(null,Math.max(f,g));
this.formPopup.container.style.visibility="visible";
Rico.EditControls.setZ(Rico.getStyle(this.formPopup.container,"zIndex"));
if(this.initialized){return
}var e,j;
for(e=0;
e<this.grid.columns.length;
e++){j=this.grid.columns[e].format;
if(!j||!j.EntryType||!j.FieldName){continue
}switch(j.EntryType){case"tinyMCE":if(typeof tinyMCE!="undefined"){tinyMCE.execCommand("mceAddControl",true,j.FieldName)
}break
}}this.initialized=true
},makeFormInvisible:function(){for(var a=0;
a<this.grid.columns.length;
a++){if(this.grid.columns[a].format&&this.grid.columns[a].format.SelectCtl){Rico.EditControls.close(this.grid.columns[a].format.SelectCtl)
}}this.formPopup.container.style.visibility="hidden";
this.formPopup.closePopup();
this.processCallback(this.options.formClose)
},getConfirmDesc:function(a){return Rico.stripTags(this.grid.cell(a,this.options.ConfirmDeleteCol).innerHTML).replace("&nbsp;"," ")
},deleteRecord:function(){this.menu.cancelmenu();
var f;
switch(this.options.ConfirmDeleteCol){case -1:f=Rico.getPhraseById("thisRecord",this.options.RecordName);
break;
case -2:f="";
for(var b=0;
b<this.keys.length;
b++){var c=this.keys[b].colidx;
var a=this.grid.columns[c].format;
if(a.EntryType.length>1&&a.EntryType.charAt(1)=="L"){c++
}var e=Rico.trim(Rico.stripTags(this.grid.cell(this.rowIdx,c).innerHTML).replace(/&nbsp;/g," "));
if(f){f+=", "
}f+=this.grid.columns[c].displayName+' "'+e+'"'
}break;
default:f='"'+Rico.truncate(this.getConfirmDesc(this.rowIdx),50)+'"';
break
}if(!this.options.ConfirmDelete.valueOf||confirm(Rico.getPhraseById("confirmDelete",f))){this.hideResponse(Rico.getPhraseById("deleting"));
this.showResponse();
var d={};
d[this.grid.actionId]="del";
for(var b=0;
b<this.keys.length;
b++){var c=this.keys[b].colidx;
var e=this.grid.columns[c].getValue(this.rowIdx);
d["_k"+c]=e
}new Rico.ajaxRequest(this.options.updateURL,{parameters:d,method:"post",onComplete:this.responseHandler})
}this.menu.cancelmenu()
},validationMsg:function(d,c,e){var b=this.grid.columns[c];
if(this.formPanels){this.formPanels.select(this.panelActualIdx[b.format.ColGroupIdx])
}var a=Rico.stripTags(b.formLabel.innerHTML).replace(/&nbsp;/g," ");
var f=Rico.getPhraseById(e,' "'+a+'"');
Rico.log(" Validation error: "+f);
if(b.format.Help){f+="\n\n"+b.format.Help
}alert(f);
setTimeout(function(){try{d.focus();
d.select()
}catch(g){}},10);
return false
},isTextInput:function(a){if(!a){return false
}if(a.tagName.toLowerCase()!="input"){return false
}if(a.type.toLowerCase()!="text"){return false
}if(a.readOnly){return false
}if(!Rico.visible(a)){return false
}return true
},parseDate:function(c,e){dateParts={};
if(!this.dateRegExp.exec(e)){return NaN
}dateParts[RegExp.$1]=0;
dateParts[RegExp.$3]=1;
dateParts[RegExp.$5]=2;
var i=c.split(/\D/);
var g=new Date();
var b=g.getFullYear();
if(i.length==2&&dateParts.yyyy==2){i.push(b)
}if(i.length!=3){return NaN
}var a=parseInt(i[dateParts.dd],10);
if(a==0||a>31){return NaN
}var f=parseInt(i[dateParts.mm],10)-1;
if(f>11){return NaN
}var h=parseInt(i[dateParts.yyyy],10);
if(h<100){h+=b-(b%100)
}return new Date(h,f,a,0,0,0)
},TESubmit:function(j){var g,h,k,l,f,d,c=[];
Rico.eventStop(j);
Rico.log("Event: TESubmit called to validate input");
for(g=0;
g<this.grid.columns.length;
g++){l=this.grid.columns[g].format;
if(!l||!l.EntryType||!l.FieldName){continue
}f=Rico.$(l.FieldName);
if(!this.isTextInput(f)){continue
}switch(this.action.value){case"ins":h=!l.Writeable||l.ReadOnly||l.UpdateOnly;
break;
case"upd":h=!l.Writeable||l.ReadOnly||l.InsertOnly;
break;
default:h=false;
break
}if(h){continue
}Rico.log(" Validating field #"+g+" EntryType="+l.EntryType+" ("+l.FieldName+")");
if(f.value.length==0){if(l.required){return this.validationMsg(f,g,"formPleaseEnter")
}else{continue
}}if(f.value.length>0&&l.regexp&&!l.regexp.test(f.value)){return this.validationMsg(f,g,"formInvalidFmt")
}switch(l.EntryType.charAt(0)){case"I":d=parseInt(f.value,10);
break;
case"F":d=parseFloat(f.value);
break;
case"D":d=this.parseDate(f.value,l.dateFmt);
if(isNaN(d)){return this.validationMsg(f,g,"formInvalidFmt")
}c.push({e:f,v:d});
break;
default:d=NaN;
break
}if(typeof l.min!="undefined"&&!isNaN(d)&&d<l.min){return this.validationMsg(f,g,"formOutOfRange")
}if(typeof l.max!="undefined"&&!isNaN(d)&&d>l.max){return this.validationMsg(f,g,"formOutOfRange")
}}if(this.processCallback(this.options.formSubmit)===false){return false
}for(g=0;
g<this.grid.columns.length;
g++){l=this.grid.columns[g].format;
if(!l||!l.EntryType||!l.FieldName){continue
}if(l.EntryType.charAt(0)!="N"){continue
}var a=Rico.$(l.FieldName);
if(!a||a.value!=this.options.TableSelectNew){continue
}var b=Rico.$("textnew__"+a.id).value;
this.addSelectOption(a,b,b)
}for(g=0;
g<c.length;
g++){c[g].e.value=Rico.formatDate(c[g].v,"yyyy-mm-dd")
}if(typeof tinyMCE!="undefined"){tinyMCE.triggerSave()
}this.makeFormInvisible();
this.sendForm();
this.menu.cancelmenu();
return false
},sendForm:function(){this.setReadOnly("reset");
this.showResponse();
Rico.log("sendForm: "+this.grid.tableId);
Rico.ajaxSubmit(this.form,this.options.updateURL,{method:"post",onComplete:this.responseHandler})
}};
Rico.EditControls={widgetList:{},elemList:{},zIndex:0,register:function(b,c){this.widgetList[b.id]={imgsrc:c,widget:b,currentEl:""};
var a=this;
b.returnValue=function(d,e){a.setValue(b,d,e)
};
Rico.log("Rico.EditControls.register:"+b.id)
},setZ:function(a){this.zIndex=Math.max(this.zIndex,a+10)
},applyTo:function(f,g,b){var d=this.widgetList[f.format.SelectCtl];
if(!d){return
}Rico.log("Rico.EditControls.applyTo: "+f.displayName+" : "+f.format.SelectCtl);
var a,e=document.createElement("span");
if(d.imgsrc.indexOf(".")==-1&&d.imgsrc.indexOf("/")==-1){a=document.createElement("span");
a.className=d.imgsrc
}else{a=document.createElement("img");
a.src=d.imgsrc
}a.style.verticalAlign="top";
a.style.marginLeft="4px";
a.style.cursor="pointer";
a.id=this.imgId(f.format.FieldName);
Rico.eventBind(a,"click",Rico.eventHandle(this,"processClick"));
g.parentNode.appendChild(e);
g.parentNode.appendChild(a);
if(b){e.style.display="none"
}else{g.style.display="none"
}var c;
if(f.format.isNullable){c=Rico.clearButton(Rico.eventHandle(this,"processClear"));
c.id=a.id+"_clear";
g.parentNode.appendChild(c)
}this.elemList[a.id]={descSpan:e,inputCtl:g,widget:d.widget,listObj:d,column:f,clrimg:c};
f.format.selectIcon=a;
f.format.selectDesc=e
},displayClrImg:function(c,a){var b=this.elemList[this.imgId(c.format.FieldName)];
if(b&&b.clrimg){b.clrimg.style.display=a?"inline-block":"none"
}},processClear:function(c){var b=Rico.eventElement(c);
var a=this.elemList[b.id.slice(0,-6)];
if(!a){return
}a.inputCtl.value="";
a.descSpan.innerHTML=a.column._format("")
},processClick:function(c){var b=Rico.eventElement(c);
var a=this.elemList[b.id];
if(!a){return
}if(a.listObj.currentEl==b.id&&a.widget.container.style.display!="none"){a.widget.close();
a.listObj.currentEl=""
}else{a.listObj.currentEl=b.id;
Rico.log("Rico.EditControls.processClick: "+a.widget.id+" : "+a.inputCtl.value);
a.widget.container.style.zIndex=this.zIndex;
a.widget.open(a.inputCtl.value,a.column);
Rico.positionCtlOverIcon(a.widget.container,b)
}},imgId:function(a){return"icon_"+a
},resetValue:function(c){var b=this.elemList[this.imgId(c.format.FieldName)];
if(!b){return
}b.inputCtl.value=c.format.ColData;
var a=c._format(c.format.ColData);
if(a===""){a="&nbsp;"
}b.descSpan.innerHTML=a
},setValue:function(e,a,d){var b=this.widgetList[e.id];
if(!b){return null
}var f=b.currentEl;
if(!f){return null
}var c=this.elemList[f];
if(!c){return null
}c.inputCtl.value=a;
if(!d){d=c.column._format(a)
}c.descSpan.innerHTML=d;
if(c.column.format.DescriptionField){Rico.$(c.column.format.DescriptionField).value=d
}},close:function(b){var a=this.widgetList[b];
if(!a){return
}if(a.widget.container.style.display!="none"){a.widget.close()
}}};
Rico.langCode="en";
Rico.addPhraseId("bookmarkExact","Listing records $1 - $2 of $3");
Rico.addPhraseId("bookmarkAbout","Listing records $1 - $2 of more than $3");
Rico.addPhraseId("bookmarkNoRec","No records");
Rico.addPhraseId("bookmarkNoMatch","No matching records");
Rico.addPhraseId("bookmarkLoading","Loading...");
Rico.addPhraseId("sorting","Sorting...");
Rico.addPhraseId("exportStatus","Exporting row $1");
Rico.addPhraseId("filterAll","(all)");
Rico.addPhraseId("filterBlank","(blank)");
Rico.addPhraseId("filterEmpty","(empty)");
Rico.addPhraseId("filterNotEmpty","(not empty)");
Rico.addPhraseId("filterLike","contains: $1");
Rico.addPhraseId("filterNot","not: $1");
Rico.addPhraseId("requestError","The request for data returned an error:\n$1");
Rico.addPhraseId("keywordPrompt","Enter keyword to search for (use * as a wildcard):");
Rico.addPhraseId("keywordTitle","Keyword Search");
Rico.addPhraseId("apply","Apply");
Rico.addPhraseId("gridmenuSortBy","Sort by: $1");
Rico.addPhraseId("gridmenuSortAsc","Ascending");
Rico.addPhraseId("gridmenuSortDesc","Descending");
Rico.addPhraseId("gridmenuFilterBy","Filter by: $1");
Rico.addPhraseId("gridmenuRefresh","Refresh");
Rico.addPhraseId("gridmenuChgKeyword","Change keyword...");
Rico.addPhraseId("gridmenuExcludeAlso","Exclude this value also");
Rico.addPhraseId("gridmenuInclude","Include only this value");
Rico.addPhraseId("gridmenuGreaterThan","Greater than or equal to this value");
Rico.addPhraseId("gridmenuLessThan","Less than or equal to this value");
Rico.addPhraseId("gridmenuContains","Contains keyword...");
Rico.addPhraseId("gridmenuExclude","Exclude this value");
Rico.addPhraseId("gridmenuRemoveFilter","Remove filter");
Rico.addPhraseId("gridmenuRemoveAll","Remove all filters");
Rico.addPhraseId("gridmenuExport","Print/Export");
Rico.addPhraseId("gridmenuExportVis2Web","Visible rows to web page");
Rico.addPhraseId("gridmenuExportAll2Web","All rows to web page");
Rico.addPhraseId("gridmenuExportVis2SS","Visible rows to spreadsheet");
Rico.addPhraseId("gridmenuExportAll2SS","All rows to spreadsheet");
Rico.addPhraseId("gridmenuHideShow","Hide/Show");
Rico.addPhraseId("gridmenuChooseCols","Choose columns...");
Rico.addPhraseId("gridmenuHide","Hide: $1");
Rico.addPhraseId("gridmenuShow","Show: $1");
Rico.addPhraseId("gridmenuShowAll","Show All");
Rico.addPhraseId("sessionExpireMinutes","minutes before your session expires");
Rico.addPhraseId("sessionExpired","EXPIRED");
Rico.addPhraseId("requestTimedOut","Request for data timed out!");
Rico.addPhraseId("waitForData","Waiting for data...");
Rico.addPhraseId("httpError","Received HTTP error: $1");
Rico.addPhraseId("invalidResponse","Server returned an invalid response");
Rico.addPhraseId("gridChooseCols","Choose columns");
Rico.addPhraseId("exportComplete","Exporting complete");
Rico.addPhraseId("exportInProgress","Export in progress...");
Rico.addPhraseId("disableBlocker","You need to disable your browser's pop-up blocker before exporting.");
Rico.addPhraseId("showFilterRow","Show filter row");
Rico.addPhraseId("hideFilterRow","Hide filter row");
Rico.addPhraseId("ok","OK");
Rico.addPhraseId("selectNone","(none)");
Rico.addPhraseId("selectNewVal","(new value)");
Rico.addPhraseId("record","record");
Rico.addPhraseId("thisRecord","this $1");
Rico.addPhraseId("confirmDelete","Are you sure you want to delete $1?");
Rico.addPhraseId("deleting","Deleting...");
Rico.addPhraseId("formPleaseEnter","Please enter a value for $1");
Rico.addPhraseId("formInvalidFmt","Invalid format for $1");
Rico.addPhraseId("formOutOfRange","Value is out of range for $1");
Rico.addPhraseId("formNewValue","new value:");
Rico.addPhraseId("saving","Saving...");
Rico.addPhraseId("clear","clear");
Rico.addPhraseId("close","Close");
Rico.addPhraseId("saveRecord","Save $1");
Rico.addPhraseId("cancel","Cancel");
Rico.addPhraseId("editRecord","Edit $1");
Rico.addPhraseId("deleteRecord","Delete this $1");
Rico.addPhraseId("cloneRecord","Clone $1");
Rico.addPhraseId("addRecord","Add new $1");
Rico.addPhraseId("addedSuccessfully","$1 added successfully");
Rico.addPhraseId("deletedSuccessfully","$1 deleted successfully");
Rico.addPhraseId("updatedSuccessfully","$1 updated successfully");
Rico.addPhraseId("treeSave","Save Selection");
Rico.addPhraseId("treeClear","Clear All");
Rico.addPhraseId("calToday","Today is $1 $2 $3");
Rico.addPhraseId("calWeekHdg","Wk");
Rico.addPhraseId("calYearRange","Year ($1-$2)");
Rico.addPhraseId("calInvalidYear","Invalid year");
Rico.thouSep=",";
Rico.decPoint=".";
Rico.dateFmt="mm/dd/yyyy";
Rico.monthNames=["January","February","March","April","May","June","July","August","September","October","November","December"];
Rico.dayNames=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];