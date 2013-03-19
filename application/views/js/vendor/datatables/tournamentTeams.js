	var tournamentTeamsEditor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		tournamentTeamsEditor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/tournamentTeams/"+$('#tournamentID').html(),
			"domTable": "#tournamentTeams",
			"fields": [ {
					"label": "Team ID",
					"name": "teamID",
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Description",
					"name": "description"
				}, {
					"label": "Association Number",
					"name": "associationNumber"
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

		$('#tournamentTeams').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/tournamentTeams/"+$('#tournamentID').html(),
			"aoColumns": [
				{ "mData": "teamID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "associationNumber" },
				{ "mData": "detailsLink" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": tournamentTeamsEditor },
					{ "sExtends": "editor_edit",   "editor": tournamentTeamsEditor },
					{ "sExtends": "editor_remove", "editor": tournamentTeamsEditor },
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
			}
		} );
		
	} );