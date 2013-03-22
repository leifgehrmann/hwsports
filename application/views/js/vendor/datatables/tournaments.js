	var editor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/datatables/data/tournaments",
			"domTable": "#tournaments",
			"fields": [ {
					"label": "ID",
					"name": "tournamentID",
					"type": "hidden"
				}, {
					"label": "Sport",
					"name": "sportID",
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Start Time",
					"name": "tournamentStart",
					"type": "datetime",
					"dateFormat": $.datepicker.ISO_8601,
					"timeFormat": "HH:mm",
					"separator": " ",
					"type": "hidden"
				}, {
					"label": "End Time",
					"name": "tournamentEnd",
					"type": "datetime",
					"dateFormat": $.datepicker.ISO_8601,
					"timeFormat": "HH:mm",
					"separator": " ",
					"type": "hidden"
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

		$('#tournaments').dataTable( {
			"sDom": 'TC<"clear">Rlfrtip',
			"sAjaxSource": "/datatables/data/tournaments",
			"aaSorting": [[ 3, "desc" ]],
			"aoColumns": [
				{ "mData": "sportIcon" },
				{ "mData": "tournamentID" },
				{ "mData": "name" },
				{ "mData": "tournamentStart" },
				{ "mData": "tournamentEnd" },
				{ "mData": "description" },
				{ "mData": "sportData.name" },
				{ "mData": "detailsLink" }
			],
			"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
				nRow.className += " "+aData['className'];
				return nRow;
			},
			"aoColumnDefs": [
				{ "bSortable": false, "aTargets": [ 0, 7 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 3, 4 ] }
            ],
			"oTableTools": {
				"sSwfPath": "/swf/copy_csv_xls_pdf.swf",
				"sRowSelect": "single",
				"aButtons": [
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
			}
		} );

	} );