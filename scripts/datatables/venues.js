	var editor; // use a global for the submit and return data rendering in the examples

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
			]
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
	} );