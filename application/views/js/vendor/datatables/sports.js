	var editor; // use a global for the submit and return data rendering in the examples
	
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
					var oldFooter = $('.DTE_Action_Remove .DTE_Footer').html();
					$('.DTE_Action_Remove .DTE_Body').html('Click next to check for other objects which depend on the object you are trying to delete:');
					$('.DTE_Action_Remove .DTE_Footer').html('<a href="/datatables/predelete/8">Next</a>');
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
				//editor.field('sportCategoryID').update( json.sportCategoryData );
			}
		} );
		
		// show user what will be deleted if they click delete
		$(".predelete").fancybox({
			beforeShow:function (){			
				//grab this function so that we can pass it back to
				//`onComplete` of the new fancybox we're going to create
				var func = arguments.callee;

				//bind the submit of our new form
				$('.fancyform form').unbind('submit').bind("submit", function() {
					//shiny
					$.fancybox.showLoading();

					var data = $(this).serialize();
					var url = $(this).attr('action')
					
					//post to the server and when we get a response, 
					//draw a new fancybox, and run this function on completion
					//so that we can bind the form and create a new fancybox on submit
					$.post(url, data, function(msg){
						$.fancybox({content:msg,beforeShow:func});
					});
					
					return false; 
				});
			}
		});
		
	} );