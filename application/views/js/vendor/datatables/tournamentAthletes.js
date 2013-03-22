	var tournamentAthletesEditor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		tournamentAthletesEditor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/tournamentAthletes/"+$('#tournamentID').html(),
			"domTable": "#tournamentAthletes",
			"fields": [ {
					"label": "User ID",
					"name": "userID",
					"type": "hidden"
				}, {
					"label": "First Name",
					"name": "firstName"
				}, {
					"label": "Last Name",
					"name": "lastName"
				}, {
					"label": "Email",
					"name": "email"
				}, {
					"label": "Phone",
					"name": "phone"
				}, {
					"label": "Address",
					"name": "address"
				}, {
					"label": "Bio",
					"name": "aboutMe"
				}
			],
			"events": {
				"onCreate": function (json, data) {
				},
				"onEdit": function (json, data) {
				},
				"onOpen": function ( settings, json ) {
					if( $('.DTE_Action_Create').length ) {
						$('.DTE_Field_Name_email').siblings('.DTE_Field').hide();
					}
				},
				"onInitCreate": function() {
					
				},
				"onInitRemove": function() {
				}
			}
		} );

		$('#tournamentAthletes').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/tournamentAthletes/"+$('#tournamentID').html(),
			"aoColumns": [
				{ "mData": "userID" },
				{ "mData": "firstName" },
				{ "mData": "lastName" },
				{ "mData": "email" },
				{ "mData": "phone", "sDefaultContent": "" },
				{ "mData": "address", "sDefaultContent": "" },
				{ "mData": "aboutMe", "sDefaultContent": "" },
				{ "mData": "detailsLink" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
				{ "bVisible": false, "aTargets": [ 3, 4, 5 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "sButtonText": "Add User as Athlete", "editor": tournamentAthletesEditor },
					{ "sExtends": "editor_edit", "sButtonText": "Edit User", "editor": tournamentAthletesEditor },
					{ "sExtends": "editor_remove", "sButtonText": "Remove from Tournament", "editor": tournamentAthletesEditor },
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