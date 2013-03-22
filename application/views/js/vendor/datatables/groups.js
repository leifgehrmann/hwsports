	var editor; // use a global for the submit and return data rendering in the examples
		
	$(document).ready(function() {
	
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/data/groups/",
			"domTable": "#groups",
			"fields": [ {
					"label": "Group ID",
					"name": "groupID",
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
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
				},
				"onInitCreate": function() {
					
				},
				"onInitRemove": function() {
					$('.DTED_Lightbox_Wrapper').css('visibility','hidden');
					$.fancybox({
						href : '/datatables/predelete/'+$('.DTTT_selected').attr('id'),
						type : 'ajax',
						modal : true,
						'beforeShow' : function() {
							jQuery("#fancycancel").click(function() {
								$.fancybox.close();
								$(".DTED_Lightbox_Close").click();
$('.DTED_Lightbox_Wrapper').css('visibility','visible');							});
							jQuery("#fancyconfirm").click(function() {
								$.fancybox.close();
								$("button:contains('Delete')").click();
$('.DTED_Lightbox_Wrapper').css('visibility','visible');							});
						}
					});
				}
			}
		} );

		$('#groups').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/data/groups/",
			"aoColumns": [
				{ "mData": "groupID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "detailsLink" }
			],
			"aoColumnDefs": [
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": editor },
					{ "sExtends": "editor_edit",   "editor": editor },
					{ "sExtends": "editor_remove", "editor": editor },
					//"select_all", 
					//"select_none",
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