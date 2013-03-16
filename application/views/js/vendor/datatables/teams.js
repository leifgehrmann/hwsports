	var editor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/data/teams",
			"domTable": "#teams",
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
					"name": "association",
					"type": "select"
				}
			],
			"events": {
				"onCreate": function (json, data) {
				},
				"onEdit": function (json, data) {
				},
				"onOpen": function ( settings, json ) {
				},
				"onInitRemove": function() {
					$.fancybox({
						href : '/datatables/predelete/'+$('.DTTT_selected').attr('id'),
						type : 'ajax'
					});
				}
			}
		} );

		$('#teams').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/data/teams",
			"aoColumns": [
				{ "mData": "teamID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "associationNumber" },
				{ "mData": "detailsLink" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] } 
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
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
				//editor.field('sportCategoryID').update( json.sportCategories );
			}
		} );
		
	} );