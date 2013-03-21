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
					"type": "hidden",
					"default": $('#tournamentID').html()
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
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
				{ "bVisible": false, "aTargets": [ 2, 5 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "sButtonText": "Create Tournament Match", "editor": tournamentMatchesEditor },
					{ "sExtends": "editor_edit",  "sButtonText": "Edit Match", "editor": tournamentMatchesEditor },
					{ "sExtends": "editor_remove", "sButtonText": "Delete Match", "editor": tournamentMatchesEditor },
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
				// tournamentMatchesEditor.field('sportID').update( json.sports );
				tournamentMatchesEditor.field('venueID').update( json.venues );
			}
		} );

	} );