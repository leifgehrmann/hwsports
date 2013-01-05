var acc;
Rico.onLoad( function() {
  Rico.$('RicoVersion').innerHTML=Rico.Version;
  arPath=location.pathname.split('/');
  Rico.$('RicoDir').innerHTML=arPath[arPath.length-2].toUpperCase().replace(/DOT/,'.');
  Rico.Corner.round('menuheader');
  acc=new Rico.Accordion( 'accordion1', {panelHeight:100} );
  //WinResize();
  setLinks(Rico.select('#accordion1 ul a'));
  setParm(Rico.$('lib_prototype/1.7/prototype.js'));
  setParm(Rico.$('theme_j-ui-lightness'));
  setTimeout(WinResize,5);
  setTimeout(function() {Event.observe(top, "resize", WinResize, false);},100);
});

function setLinks(links) {
  for (var i=0; i<links.length; i++) {
    links[i].href='javascript:void(0)';
    Rico.eventBind(links[i],"click", Rico.eventHandle(window,'processClick'));
  }
};

function CalcAccHt() {
  var winht=Rico.windowHeight();
  var txtht=Rico.$('accordion1').offsetTop;
  var titleht=acc.titles.length * (acc.titles[0].offsetHeight + 5);
  return Math.max(winht-txtht-titleht-35,60);
}

function WinResize(e) {
  acc.setPanelHeight(CalcAccHt());
}

function processClick(e) {
  var elem=Rico.eventElement(e);
  if (elem.tagName != 'A') elem=Rico.getParentByTagName(elem,'a');
  //alert(elem.tagName+' '+elem.id);
  setParm(elem);
  var form=document.forms[0];
  if (!form.action) {
    alert('Select an example first!');
    return;
  }
  // IE6 requires a delay
  setTimeout(function() { form.submit(); return false; }, 20);
}

function setParm(elem) {
  var idx=elem.id.indexOf('_');
  if (idx < 0) return;
  var prefix=elem.id.substr(0,idx);
  var suffix=elem.id.substr(idx+1);
  //alert(prefix+' * '+suffix);
  var form=document.forms[0];
  if (prefix=='demo') {
    form.setAttribute("action", suffix);
  } else {
    Rico.$(prefix).value=suffix;
  }
  var spanid=prefix+'span';
  Rico.$(spanid).innerHTML=Rico.stripTags(elem.innerHTML);
}
