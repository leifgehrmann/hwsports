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
		foreach($_POST['data'] as $rowString) {
			$sportID = substr($rowString,4);
			$db->sql("DELETE FROM `sportData` WHERE `sportID` = '{$sportID}'");
		}
	}
}

$editor = Editor::inst( $db, 'sports', 'sportID' )
	->field( 
		Field::inst( 'sportID' )
	)
	->field( 
		Field::inst( 'centreID' )
	);
	
$out = $editor
	->process($_POST)
	->data();

// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data from sportData back to the client
if ( !isset($_POST['action']) ) {
	foreach ( $out['aaData'] as $aaDataID => $sport ) {
		if($sport['centreID'] != 1) {
			unset($out['aaData'][$aaDataID]);
			continue;
		}
	
		$sportCategoryIDQueryString = "SELECT sportCategoryID FROM `sports` WHERE `sportID` = '{$sport['sportID']}'";
		$sportCategoryID = $db->sql($sportCategoryIDQueryString)->fetch();
		$sportCategoryID = $sportCategoryID['sportCategoryID'];
		
		$sportCategoryNameQueryString = "SELECT MAX(CASE WHEN `key`='name' THEN value END ) AS name FROM `sportCategoryData` WHERE `sportCategoryID` = '$sportCategoryID'";
		$sportCategoryName = $db->sql($sportCategoryNameQueryString)->fetch();
		
	
		$sportDataQueryString = "SELECT " .
			"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
			"MAX(CASE WHEN `key`='description' THEN value END ) AS description " .
			"FROM `sportData` WHERE `sportID` = '{$sport['sportID']}'";
		$sportData = $db->sql($sportDataQueryString)->fetch();
		$out['aaData'][$aaDataID] = array_merge($sport, $sportData);

		$out['aaData'][$aaDataID]['sportCategoryName'] = $sportCategoryName['name'];
	}
	
} elseif($_POST['action']=='create') {
	$sportID = $db->sql("SELECT MAX(sportID) FROM sports")->fetch();
	$sportID = $sportID[0];
	$db->sql("INSERT INTO `sportData` (`sportID`,`key`,`value`) VALUES ('$sportID','name','{$_POST['data']['name']}')");
	$db->sql("INSERT INTO `sportData` (`sportID`,`key`,`value`) VALUES ('$sportID','description','{$_POST['data']['description']}')");
	
	$sportDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='description' THEN value END ) AS description " .
		"FROM `sportData` WHERE `sportID` = '{$sportID}'";
	$sportData = $db->sql($sportDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $sportData);
} elseif($_POST['action']=='edit') {
	$db->sql("UPDATE `sportData` SET `value` = '{$_POST['data']['name']}' WHERE `sportID` = '{$_POST['data']['sportID']}' AND `key` = 'name'");
	$db->sql("UPDATE `sportData` SET `value` = '{$_POST['data']['description']}' WHERE `sportID` = '{$_POST['data']['sportID']}' AND `key` = 'description'");
	
	$sportDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='description' THEN value END ) AS description " .
		"FROM `sportData` WHERE `sportID` = '{$_POST['data']['sportID']}'";
	$sportData = $db->sql($sportDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $sportData);
}

// Send it back to the client
echo json_encode( $out );

