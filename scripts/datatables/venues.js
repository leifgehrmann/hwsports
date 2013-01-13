	var editor; // use a global for the submit and return data rendering in the examples

	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/php/venues.php",
			"domTable": "#example",
			"fields": [ {
					"label": "Venue ID",
					"name": "venueID"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Description",
					"name": "description"
				}, {
					"label": "Directions",
					"name": "directions"
				}, {
					"label": "Lat",
					"name": "lat"
				}, {
					"label": "Lng",
					"name": "lng"
				}
			]
		} );

		$('#example').dataTable( {
			"sDom": "Tfrtip",
			"sAjaxSource": "/php/venues.php",
			"aoColumns": [
				{ "mData": "venueID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "directions" },
				{ "mData": "lat" },
				{ "mData": "lng" }
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
	} );