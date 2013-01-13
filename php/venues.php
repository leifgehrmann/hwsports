<?php

// DataTables PHP library
include( "lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;


/*
 * Example PHP implementation used for the joinSelf.html example - the basic idea
 * here is that the join performed is simply to get extra information about the
 * 'manager' (in this case, the name of the manager). To alter the manager for
 * a user, you would change the 'manager' value in the 'users' table, so the
 * information from the join is read-only.
 */
$editor = Editor::inst( $db, 'users', 'userID' )
	->field( 
		Field::inst( 'userID' )->set( false )
	);

$out = $editor
	->process($_POST)
	->data();


// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data back to the client, with the options
// for the 'department' select list and 'access' radio boxes
if ( !isset($_POST['action']) ) {
	foreach ( $out['aaData'] as $aaDataID => $user ) {

	$out['aaData'][$aaDataID]['name'] = print_r( $db->sql("SELECT `value` AS 'name' FROM `users` WHERE `key` = 'name' AND `userID` = '{$user['userID']}'") , 1);
	}
}

// Send it back to the client
echo json_encode( $out );

