(function() {

var qs = window.location.href.match(/(\?.*)?$/)[0];
var legacy = qs.indexOf('legacy') != -1;
var noui = qs.indexOf('noui') != -1;
var debug;
var prefix;
var tags;


startload();

css('/css/vendor/fullcalendar/main.css');
css('/css/vendor/fullcalendar/common.css');
css('/css/vendor/fullcalendar/basic.css');
css('/css/vendor/fullcalendar/agenda.css');
cssprint('/css/vendor/fullcalendar/print.css');

if (debug && (!window.console || !window.console.log)) {
	jslib('../tests/lib/firebug-lite/firebug-lite-compressed.js');
}

js('defaults.js');
js('main.js');
js('Calendar.js');
js('Header.js');
js('EventManager.js');
js('date_util.js');
js('util.js');

js('basic/MonthView.js');
js('basic/BasicWeekView.js');
js('basic/BasicDayView.js');
js('basic/BasicView.js');
js('basic/BasicEventRenderer.js');

js('agenda/AgendaWeekView.js');
js('agenda/AgendaDayView.js');
js('agenda/AgendaView.js');
js('agenda/AgendaEventRenderer.js');

js('common/View.js');
js('common/DayEventRenderer.js');
js('common/SelectionManager.js');
js('common/OverlayManager.js');
js('common/CoordinateGrid.js');
js('common/HoverListener.js');
js('common/HorizontalPositionCache.js');

endload();


if (debug) {
	window.onload = function() {
		$('body').append(
			"<form style='position:absolute;top:0;right:0;text-align:right;font-size:10px;color:#666'>" +
				"<label for='legacy'>legacy</label> " +
				"<input type='checkbox' id='legacy' name='legacy'" + (legacy ? " checked='checked'" : '') +
					" style='vertical-align:middle' onclick='$(this).parent().submit()' />" +
				"<br />" +
				"<label for='ui'>no jquery ui</label> " +
				"<input type='checkbox' id='ui' name='noui'" + (noui ? " checked='checked'" : '') +
					" style='vertical-align:middle' onclick='$(this).parent().submit()' />" +
			"</form>"
		);
	};
}


window.startload = startload;
window.endload = endload;
window.css = css;
window.js = js;
window.jslib = jslib;


function startload() {
	debug = false;
	prefix = '';
	tags = [];
	var scripts = document.getElementsByTagName('script');
	for (var i=0, script; script=scripts[i++];) {
		if (!script._checked) {
			script._checked = true;
			var m = (script.getAttribute('src') || '').match(/^(.*)_loader\.js(\?.*)?$/);
			if (m) {
				prefix = m[1];
				debug = (m[2] || '').indexOf('debug') != -1;
				break;
			}
		}
	}
}


function endload() {
	document.write(tags.join("\n"));
}


function css(file) {
	tags.push("<link rel='stylesheet' type='text/css' href='" + file + "' />");
}


function cssprint(file) {
	tags.push("<link rel='stylesheet' type='text/css' href='" + file + "' media='print' />");
}


function js(file) {
	tags.push("<script type='text/javascript' src='" + prefix + file + "'></script>");
}


function jslib(file) {
	js(file);
}


})();
