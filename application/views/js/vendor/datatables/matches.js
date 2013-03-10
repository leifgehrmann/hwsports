	var editor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatablesserver/matches",
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
					"label": "Start Time",
					"name": "startTime",
					"type": "datetime",
					"dateFormat": $.datepicker.ISO_8601,
					"timeFormat": "HH:mm",
					"separator": " "
				}, {
					"label": "End Time",
					"name": "endTime",
					"type": "datetime",
					"dateFormat": $.datepicker.ISO_8601,
					"timeFormat": "HH:mm",
					"separator": " "
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
			"sAjaxSource": "/datatablesserver/matches",
			"aoColumns": [
				{ "mData": "centreID" },
				{ "mData": "matchID" },
				{ "mData": "sportName" },
				{ "mData": "venueName" },
				{ 
					"mData": "tournamentName",
					"sDefaultContent": ""
				},
				{ "mData": "name" },
				{ "mData": "startTime" },
				{ "mData": "endTime" },
				{ "mData": "description" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "multi",
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