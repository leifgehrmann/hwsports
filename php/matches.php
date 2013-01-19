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
			$matchID = substr($rowString,4);
			$db->sql("DELETE FROM `matchData` WHERE `matchID` = '{$matchID}'");
		}
	}
}

$editor = Editor::inst( $db, 'matches', 'matchID' )
	->field( 
		Field::inst( 'matchID' )
	)
	->field( 
		Field::inst( 'sportID' )
	)
	->field( 
		Field::inst( 'venueID' )
	)
	->join(
        Join::inst( 'sports', 'array' )
            ->join( 'sportID', 'sportID' )
            ->field(
                Field::inst( 'centreID' )
            )
	);
		
$out = $editor
	->process($_POST)
	->data();

// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data from matchData back to the client
if ( !isset($_POST['action']) ) {
	foreach ( $out['aaData'] as $aaDataID => $match ) {
		if($match['sports']['centreID'] != 1) {
			unset($out['aaData'][$aaDataID]);
			continue;
		}
	
		$matchDataQueryString = "SELECT " .
			"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
			"MAX(CASE WHEN `key`='timestamp' THEN value END ) AS timestamp, " .
			"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
			"MAX(CASE WHEN `key`='tournamentID' THEN value END ) AS tournamentID " .
			"FROM matchData WHERE matchID = {$match['matchID']}";
		$matchData = $db->sql($matchDataQueryString)->fetch();
		
		$out['aaData'][$aaDataID] = array_merge($match, $matchData);
	}
	
	$sportQueryString = "SELECT DISTINCT `sportID` AS value, `value` AS label FROM `sportData` WHERE `key` = 'name'";
	$sportData = $db->sql($sportQueryString)->fetchAll();
	$out['sportData'] = $sportData;
	
	$venueQueryString = "SELECT DISTINCT `venueData`.`venueID` AS value, `value` AS label FROM `venueData`  LEFT JOIN `venues` ON `venueData`.`venueID` =  `venues`.`venueID` WHERE `key` = 'name' AND `venues`.`centreID` = 1";
	$venueData = $db->sql($venueQueryString)->fetchAll();
	$out['venueData'] = $venueData;
	
} elseif($_POST['action']=='create') {
	$matchID = $db->sql("SELECT MAX(matchID) FROM matches")->fetch();
	$matchID = $matchID[0];
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','name','{$_POST['data']['name']}')");
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','timestamp','{$_POST['data']['timestamp']}')");
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','description','{$_POST['data']['description']}')");
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','tournamentID','{$_POST['data']['tournamentID']}')");
	
	$matchDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='timestamp' THEN value END ) AS timestamp, " .
		"MAX(CASE WHEN `key`='directions' THEN value END ) AS directions " .
		"FROM matchData WHERE matchID = {$matchID}";
	$matchData = $db->sql($matchDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $matchData);
} elseif($_POST['action']=='edit') {
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['name']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'name'");
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['timestamp']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'timestamp'");
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['description']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'description'");
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['tournamentID']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'tournamentID'");
	
	$matchDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
		"MAX(CASE WHEN `key`='timestamp' THEN value END ) AS timestamp, " .
		"MAX(CASE WHEN `key`='tournamentID' THEN value END ) AS tournamentID " .
		"FROM matchData WHERE matchID = {$_POST['data']['matchID']}";
	$matchData = $db->sql($matchDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $matchData);
}

// Send it back to the client
echo json_encode( $out );

