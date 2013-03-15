	var editor; // use a global for the submit and return data rendering in the examples
	
	function predelete(id) {
		$.fancybox({
			href : '/datatables/predelete/'+id,
			type : 'ajax'
		});
	}
	
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/sports",
			"domTable": "#sports",
			"fields": [ {
					"label": "Sport ID",
					"name": "sportID",
					"type": "hidden"
				}, {
					"label": "Centre ID",
					"name": "centreID",
					"default": $('#centreID').text(),
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Description",
					"name": "description"
				}, {
					"label": "Category",
					"name": "sportCategoryID",
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
					var sportID = $('.DTTT_selected').attr('id');
					$('.DTE_Action_Remove .DTE_Footer_Content .DTE_Form_Buttons button').before('<button onclick="predelete('+sportID+');">Check Dependencies</button>');
				}
			}
		} );

		$('#sports').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/sports",
			"aoColumns": [
				{ "mData": "sportID" },
				{ "mData": "centreID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "sportCategoryData.name" }
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
				//editor.field('sportCategoryID').update( json.sportCategoryData );
			}
		} );
		
	} );