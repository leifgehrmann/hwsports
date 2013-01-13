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
if ( isset($_POST['action']) ) {
	if($_POST['action']=='remove') {
		// Clean up venue data
		foreach($_POST['data'] as $rowString) {
			$venueID = substr($rowString,3);
			$db->sql("DELETE FROM `venueData` WHERE `venueID` = '{$venueID}')");
		}
	}
}

$editor = Editor::inst( $db, 'venues', 'venueID' )
	->field( 
		Field::inst( 'venueID' )
	)
	->field( 
		Field::inst( 'centreID' )
	);
		
$out = $editor
	->process($_POST)
	->data();

// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data from venueData back to the client
if ( !isset($_POST['action']) ) {
	foreach ( $out['aaData'] as $aaDataID => $venue ) {
		if($venue['centreID'] != 1) {
			unset($out['aaData'][$aaDataID]);
			continue;
		}
	
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
} elseif($_POST['action']=='create') {
	$venueID = $db->sql("SELECT MAX(venueID) FROM venues")->fetch();
	$venueID = $venueID[0];
	$db->sql("INSERT INTO `venueData` (`venueID`,`key`,`value`) VALUES ('$venueID','name','{$_POST['data']['name']}')");
	$db->sql("INSERT INTO `venueData` (`venueID`,`key`,`value`) VALUES ('$venueID','description','{$_POST['data']['description']}')");
	$db->sql("INSERT INTO `venueData` (`venueID`,`key`,`value`) VALUES ('$venueID','directions','{$_POST['data']['directions']}')");
	$db->sql("INSERT INTO `venueData` (`venueID`,`key`,`value`) VALUES ('$venueID','lat','{$_POST['data']['lat']}')");
	$db->sql("INSERT INTO `venueData` (`venueID`,`key`,`value`) VALUES ('$venueID','lng','{$_POST['data']['lng']}')");
	
	$venueDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
		"MAX(CASE WHEN `key`='directions' THEN value END ) AS directions, " .
		"MAX(CASE WHEN `key`='lat' THEN value END ) AS lat, " .
		"MAX(CASE WHEN `key`='lng' THEN value END ) AS lng " .
		"FROM venueData WHERE venueID = {$venueID}";
	$venueData = $db->sql($venueDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $venueData);
} elseif($_POST['action']=='update') {
	print_r($_POST);
}

// Send it back to the client
echo json_encode( $out );

