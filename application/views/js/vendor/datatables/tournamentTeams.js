	var tournamentTeamsEditor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		tournamentTeamsEditor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/tournamentTeams/"+$('#tournamentID').html(),
			"domTable": "#tournamentTeams",
			"fields": [ {
					"label": "Team ID",
					"name": "teamID"
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
					if( $('.DTE_Action_Create').length ) {
						$('.DTE_Field_Name_teamID').siblings('.DTE_Field').remove();
					}
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
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "sButtonText": "Add Team to Tournament", "editor": tournamentTeamsEditor },
					{ "sExtends": "editor_edit",  "sButtonText": "Edit Team",   "editor": tournamentTeamsEditor },
					{ "sExtends": "editor_remove", "sButtonText": "Remove Team from Tournament",  "editor": tournamentTeamsEditor },
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