	var editor; // use a global for the submit and return data rendering in the examples
	// a global variable to access the map
	var map;
	var centre_pos  = new google.maps.LatLng( jQuery('#centreLat').text(), jQuery('#centreLng').text() );
	var centre_marker;

	function mapInitialize(){
		map = new google.maps.Map(document.getElementById('venuemap'), {
			zoom: 15,
			center: centre_pos,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		
		centre_marker = new google.maps.Marker({ position: centre_pos, map: map, title: "New Venue Location" });
		
		google.maps.event.addListener(map, 'center_changed', function() {
			var newcentre = map.getCenter();
			centre_marker.setPosition(newcentre);
			editor.set( 'lat', newcentre.lat() );
			editor.set( 'lng', newcentre.lng() );
		});
	}

	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/data/venues",
			"domTable": "#venues",
			"fields": [ {
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
				"onOpen": function ( settings, json ) {
					if($('.DTE_Header_Content').text() != 'Delete') {
						$('.DTE_Body_Content').append($('#mapcontainer'));
						$('#mapcontainer').append($('#venuemap'));
						$('#mapcontainer').show();
						$('#venuemap').show();
						mapInitialize();
						var existingLat = editor.get('lat');
						var existingLng = editor.get('lng');
						if(existingLat.length != 0) {
							var existingVenuePosition = new google.maps.LatLng(existingLat,existingLng);
							centre_marker.setPosition(existingVenuePosition);
							map.setCenter(existingVenuePosition);
						}
					} else {
						$('#mapcontainer').hide();
						$('#venuemap').hide();
					}
				},
				"onInitRemove": function() {
					$.fancybox({
						href : '/datatables/predelete/'+$('.DTTT_selected').attr('id'),
						type : 'ajax'
					});
				}
			}
		} );

		$('#venues').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/data/venues",
			"aoColumns": [
				{ "mData": "lat" },
				{ "mData": "lng" },
				{ "mData": "venueID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "directions" },
				{
	                "mData": null,
	                "sDefaultContent": ""
            	}
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 2 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": editor },
					{ "sExtends": "editor_edit",   "editor": editor },
					{ "sExtends": "editor_remove", "editor": editor },
					"select_all", 
					"select_none",
					{
						"sExtends":    "collection",
						"sButtonText": "Export",
						"aButtons":    [
							
							{
								"sExtends": "csv"
							},
							{
								"sExtends": "xls"
							},
							{
								"sExtends": "pdf",
								"mColumns": [ 4, 5, 6 ]
							}
						]
					}
				]
			},
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
				$('td:eq(3)', nRow).html( '<a href="/tms/venue/'+aData['venueID']+'" class="editor-details">Details</a>' );
			},
			"fnInitComplete": function ( settings, json ) {
				// Set the allowed values for the select field based on
				// what is available in the database
				//editor.field('manager').update( json.userList );
			}
		} );

	} );