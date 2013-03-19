	var tournamentMatchesEditor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		tournamentMatchesEditor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/tournamentMatches/"+$('#tournamentID').html(),
			"domTable": "#tournamentMatches",
			"fields": [ {
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

		$('#tournamentMatches').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/tournamentMatches/"+$('#tournamentID').html(),
			"aoColumns": [
				{ "mData": "matchID" },
				{ "mData": "name" },
				{ 
					"mData": "tournamentData.name",
					"sDefaultContent": "None"
				},
				{ "mData": "startTime" },
				{ "mData": "endTime" },
				{ "mData": "description" },
				{ "mData": "sportData.name" },
				{ "mData": "venueData.name" },
				{ "mData": "detailsLink" }
			],
			"aoColumnDefs": [
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": tournamentMatchesEditor },
					{ "sExtends": "editor_edit",   "editor": tournamentMatchesEditor },
					{ "sExtends": "editor_remove", "editor": tournamentMatchesEditor },
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
				tournamentMatchesEditor.field('sportID').update( json.sports );
				tournamentMatchesEditor.field('venueID').update( json.venues );
			}
		} );

	} );