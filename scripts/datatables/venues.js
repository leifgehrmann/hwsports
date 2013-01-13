	var editor; // use a global for the submit and return data rendering in the examples
	// a global variable to access the map
	var map;
	var centre_marker;
	var centre_pos  = new google.maps.LatLng( jQuery('#centreLat').text(), jQuery('#centreLng').text() );

	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/php/venues.php",
			"domTable": "#example",
			"fields": [ {
					"label": "centreID",
					"name": "centreID",
					"default": $('#centreID').text(),
					"type": "hidden"
				}, {
					"label": "Lat",
					"name": "lat",
					"type": "hidden"
				}, {
					"label": "Lng",
					"name": "lng",
					"type": "hidden"
				}, {
					"label": "Venue ID",
					"name": "venueID",
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Description",
					"name": "description"
				}, {
					"label": "Directions",
					"name": "directions"
				}
			],
			"events": {
				"onCreate": function (json, data) {
					alert( "A new row was created!" );
				},
				"onEdit": function (json, data) {
					alert( "A new row was edited!" );
				},
				"onOpen": function ( settings, json ) {
					$('.DTE_Action_Create .DTE_Body_Content').append("<div id='mapcontainer'></div>");
					$('#mapcontainer').append(map.getDiv());
					google.maps.event.trigger(map, 'resize');
				}
			}
		} );

		$('#example').dataTable( {
			"sDom": "Tfrtip",
			"sAjaxSource": "/php/venues.php",
			"aoColumns": [
				{ "mData": "centreID" },
				{ "mData": "lat" },
				{ "mData": "lng" },
				{ "mData": "venueID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "directions" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 2 ] }
            ],
			"oTableTools": {
				"sRowSelect": "multi",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": editor },
					{ "sExtends": "editor_edit",   "editor": editor },
					{ "sExtends": "editor_remove", "editor": editor }
				]
			},
			"fnInitComplete": function ( settings, json ) {
				// Set the allowed values for the select field based on
				// what is available in the database
				//editor.field('manager').update( json.userList );
			}
		} );

		function initialize(){
			map = new google.maps.Map(document.getElementById('venuemap'), {
				zoom: 15,
				center: centre_pos,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			
			centre_marker = new google.maps.Marker({ position: centre_pos, map: map, title: "New Venue Location" });

			google.maps.event.addListener(map, 'center_changed', function() {
				var newcentre = map.getCenter();
				centre_marker.setPosition(newcentre);
				//jQuery('input[name=lat]').val(newcentre.lat());
				//jQuery('input[name=lng]').val(newcentre.lng());
			});
		}

		google.maps.event.addDomListener(window, 'load', initialize);

	} );