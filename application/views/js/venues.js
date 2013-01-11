// a global variable to access the map
var map;
var centre_marker;
var centre_pos  = new google.maps.LatLng( jQuery('input[name="lat"]').val(), jQuery('input[name="lng"]').val() );

function initialize(){
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: centre_pos,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	centre_marker = new google.maps.Marker({ position: centre_pos, map: map, title: "New Venue Location" });

	google.maps.event.addListener(map, 'center_changed', function() {
		var newcentre = map.getCenter();
		centre_marker.setPosition(newcentre);
		jQuery('input[name=lat]').val(newcentre.lat());
		jQuery('input[name=lng]').val(newcentre.lng());
	});
}

google.maps.event.addDomListener(window, 'load', initialize);

/******     The data table section      ******/

$(function () { 
	$('#venuesTable').jTPS( {perPages:[2]} );
});
