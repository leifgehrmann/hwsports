	var editor; // use a global for the submit and return data rendering in the examples

	$(document).ready(function() {
		editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "/php/joinSelf.php",
			"domTable": "#example",
			"fields": [ {
					"label": "First name:",
					"name": "first_name"
				}, {
					"label": "Last name:",
					"name": "last_name"
				}, {
					"label": "Manager:",
					"name": "manager",
					"type": "select"
				}
			]
		} );

		$('#example').dataTable( {
			"sDom": "Tfrtip",
			"sAjaxSource": "/php/joinSelf.php",
			"aoColumns": [
				{ "mData": "first_name" },
				{ "mData": "last_name" },
				{
					"mData": "manager.first_name",
					"mRender": function ( val, type, row ) {
						if ( val ) {
							return val +' '+ row.manager.last_name;
						}
						return "";
					},
					"sDefaultContent": ""
				}
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
				// Set the allowed values for the select field based on
				// what is available in the database
				editor.field('manager').update( json.userList );
			}
		} );
	} );