	var editor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/php/matches.php",
			"domTable": "#matches",
			"fields": [ {
					"label": "Centre ID",
					"name": "centreID",
					"default": $('#centreID').text(),
					"type": "hidden"
				}, {
					"label": "Match ID",
					"name": "matchID",
				}, {
					"label": "Sport ID",
					"name": "sportID"
				}, {
					"label": "Venue ID",
					"name": "venueID"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Description",
					"name": "description"
				}, {
					"label": "Timestamp",
					"name": "timestamp"
				}
			],
			"events": {
				"onCreate": function (json, data) {
				},
				"onEdit": function (json, data) {
				},
				"onOpen": function ( settings, json ) {
				}
			}
		} );

		$('#matches').dataTable( {
			"sDom": "Tfrtip",
			"sAjaxSource": "/php/matches.php",
			"aoColumns": [
				{ "mData": "centreID" },
				{ "mData": "matchID" },
				{ "mData": "sportID" },
				{ "mData": "venueID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "timestamp" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
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
				//editor.field('matchCategoryID').update( json.matchCategoryData );
			}
		} );

	} );