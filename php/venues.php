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
$editor = Editor::inst( $db, 'venues', 'venueID' )
	->field( 
		Field::inst( 'venueID' )->set( false )
	);
$out = $editor
	->process($_POST)
	->data();

// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data from venueData back to the client
if ( !isset($_POST['action']) ) {
	foreach ( $out['aaData'] as $aaDataID => $venue ) {
		$venueDataQueryString = "SELECT " .
			"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
			"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
			"MAX(CASE WHEN `key`='directions' THEN value END ) AS directions, " .
			"MAX(CASE WHEN `key`='lat' THEN value END ) AS lat, " .
			"MAX(CASE WHEN `key`='lng' THEN value END ) AS lng " .
			"FROM venueData WHERE venueID = {$venue['venueID']}";
	
		$venueData = $db->sql($venueDataQueryString)->fetch();
		$out['aaData'][$aaDataID] = array_merge($venue, $venueData);
	}
}

// Send it back to the client
echo json_encode( $out );

