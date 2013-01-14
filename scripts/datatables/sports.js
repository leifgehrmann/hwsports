	var editor; // use a global for the submit and return data rendering in the examples
	
	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/php/sports.php",
			"domTable": "#sports",
			"fields": [ {
					"label": "centreID",
					"name": "centreID",
					"default": $('#centreID').text(),
					"type": "hidden"
				}, {
					"label": "Sport ID",
					"name": "sportID",
					"type": "hidden"
				}, {
					"label": "Name",
					"name": "name"
				}, {
					"label": "Description",
					"name": "description"
				}, {
					"label": "Category",
					"name": "sportCategoryName.sportCategoryID",
					"type": "select"
				}
			],
			"events": {
				"onCreate": function (json, data) {
					alert( "New venue created." );
				},
				"onEdit": function (json, data) {
					alert( "Edit complete." );
				},
				"onOpen": function ( settings, json ) {
					
				}
			}
		} );

		$('#sports').dataTable( {
			"sDom": "Tfrtip",
			"sAjaxSource": "/php/sports.php",
			"aoColumns": [
				{ "mData": "centreID" },
				{ "mData": "sportID" },
				{ "mData": "name" },
				{ "mData": "description" },
				{ "mData": "sportCategoryName" }
			],
			"aoColumnDefs": [
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
				{ "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] } 
            ],
			"oTableTools": {
				"sRowSelect": "multi",
				"aButtons": [
					{ "sExtends": "editor_create", "editor": editor },
					{ "sExtends": "editor_edit",   "editor": editor },
					{ "sExtends": "editor_remove", "editor": editor }
				]
			},
			"fnInitComplete": function ( settings, json ) {
				editor.field('sportCategoryName.sportCategoryID').update( json.sportCategoryName );
			}
		} );

	} );