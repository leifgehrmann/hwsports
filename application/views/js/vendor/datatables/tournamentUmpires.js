	var tournamentUmpiresEditor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		tournamentUmpiresEditor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/tournamentUmpires/"+$('#tournamentID').html(),
			"domTable": "#tournamentUmpires",
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
						$('.DTE_Field_Name_email').siblings('.DTE_Field').remove();
					}
				},
				"onInitCreate": function() {
					
				},
				"onInitRemove": function() {
				}
			}
		} );

		$('#tournamentUmpires').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/tournamentUmpires/"+$('#tournamentID').html(),
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
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
				{ "bVisible": false, "aTargets": [ 3, 4, 5 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "sButtonText": "Add User as Umpire", "editor": tournamentUmpiresEditor },
					{ "sExtends": "editor_edit", "sButtonText": "Edit User", "editor": tournamentUmpiresEditor },
					{ "sExtends": "editor_remove", "sButtonText": "Remove from Tournament", "editor": tournamentUmpiresEditor },
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