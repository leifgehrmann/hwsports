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
					"label": "ID",
					"name": "matchID",
					"type": "hidden"
				}, {
					"label": "Sport",
					"name": "sportID",
					"type": "select"
				}, {
					"label": "Venue",
					"name": "venueID",
					"type": "select"
				}, {
					"label": "Tournament",
					"name": "tournamentID",
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Date / Time",
					"name": "timestamp",
					"type": "datetime",
					"dateFormat": "dd/mm/yy",
					"timeFormat": "HH:mm",
					"separator": " @ "
				}, {
					"label": "Description",
					"name": "description"
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
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/php/matches.php",
			"aoColumns": [
				{ "mData": "centreID" },
				{ "mData": "matchID" },
				{ "mData": "sportID" },
				{ "mData": "tournamentID" },
				{ "mData": "venueID" },
				{ "mData": "name" },
				{ "mData": "timestamp" },
				{ "mData": "description" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/scripts/datatables/copy_csv_xls_pdf.swf",
				"sRowSelect": "multi",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": editor },
					{ "sExtends": "editor_edit",   "editor": editor },
					{ "sExtends": "editor_remove", "editor": editor },
					{
						"sExtends":    "collection",
						"sButtonText": "Save",
						"aButtons":    [
							
							{
								"sExtends": "csv"
							},
							{
								"sExtends": "xls"
							},
							{
								"sExtends": "pdf",
								"mColumns": "visible"
							}
						]
					}
				]
			},
			"fnInitComplete": function ( settings, json ) {
				editor.field('sportID').update( json.sportData );
				editor.field('venueID').update( json.venueData );
			}
		} );

	} );