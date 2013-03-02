<?php

// DataTables PHP library
include( "../application/config/constants.php" );
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
	);
		
$out = $editor
	->process($_POST)
	->data();

// When there is no 'action' parameter we are getting data, and in this
// case we want to send extra data from matchData back to the client
if ( !isset($_POST['action']) ) {
	foreach ( $out['aaData'] as $aaDataID => $match ) {
		
		$sportCentreQueryString = "SELECT `centreID` FROM `sports` WHERE `sportID` = {$match['sportID']}";
		$sportCentre = $db->sql($sportCentreQueryString)->fetch();
		$centreID = $sportCentre['centreID'];
		if($centreID != 1) {
			unset($out['aaData'][$aaDataID]);
			continue;
		}
	
		$matchDataQueryString = "SELECT " .
			"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
			"MAX(CASE WHEN `key`='startTime' THEN value END ) AS startTime, " .
			"MAX(CASE WHEN `key`='endTime' THEN value END ) AS endTime, " .
			"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
			"MAX(CASE WHEN `key`='tournamentID' THEN value END ) AS tournamentID " .
			"FROM matchData WHERE matchID = {$match['matchID']}";
		$matchData = $db->sql($matchDataQueryString)->fetch();
		
		$out['aaData'][$aaDataID] = array_merge($match, $matchData);
		$out['aaData'][$aaDataID]['centreID'] = $centreID;

		print_r("test");
		print_r($out['aaData'][$aaDataID]['startTime']);
		print_r(PUBLIC_DATE_TIME_FORMAT);
		print_r(date(PUBLIC_DATE_TIME_FORMAT,$out['aaData'][$aaDataID]['startTime']));
		$out['aaData'][$aaDataID]['startTime'] 	= date(PUBLIC_DATE_TIME_FORMAT,$out['aaData'][$aaDataID]['startTime'])->format();
		$out['aaData'][$aaDataID]['endTime'] 	= date(PUBLIC_DATE_TIME_FORMAT,$out['aaData'][$aaDataID]['endTime']  )->format();

		$sportQueryString = "SELECT DISTINCT `value` FROM `sportData` WHERE `key` = 'name' AND `sportID` = '{$out['aaData'][$aaDataID]['sportID']}'";
		$sportName = $db->sql($sportQueryString)->fetch();
		$out['aaData'][$aaDataID]['sportName'] = $sportName['value'];
		
		$venueQueryString = "SELECT DISTINCT `value` FROM `venueData` WHERE `key` = 'name' AND `venueID` = '{$out['aaData'][$aaDataID]['venueID']}'";
		$venueName = $db->sql($venueQueryString)->fetch();
		$out['aaData'][$aaDataID]['venueName'] = $venueName['value'];
		
		if(!empty($out['aaData'][$aaDataID]['tournamentID'])) {
			$tournamentQueryString = "SELECT DISTINCT `value` FROM `tournamentData` WHERE `key` = 'name' AND `tournamentID` = '{$out['aaData'][$aaDataID]['tournamentID']}'";
			$tournamentName = $db->sql($tournamentQueryString)->fetch();
			$out['aaData'][$aaDataID]['tournamentName'] = $tournamentName['value'];
		} else {
			$out['aaData'][$aaDataID]['tournamentName'] = "None";
		}
	}
	
	$sportQueryString = "SELECT DISTINCT `sportID` AS value, `value` AS label FROM `sportData` WHERE `key` = 'name'";
	$sportData = $db->sql($sportQueryString)->fetchAll();
	$out['sportData'] = $sportData;
	
	$venueQueryString = "SELECT DISTINCT `venueData`.`venueID` AS value, `value` AS label FROM `venueData`  LEFT JOIN `venues` ON `venueData`.`venueID` =  `venues`.`venueID` WHERE `key` = 'name' AND `venues`.`centreID` = 1";
	$venueData = $db->sql($venueQueryString)->fetchAll();
	$out['venueData'] = $venueData;
	
} elseif($_POST['action']=='create') {
	$a = DateTime::createFromFormat(PUBLIC_DATE_FORMAT, $_POST['data']['startTime']);
	$startTime = $a->format(DATE_TIME_FORMAT);
	$a = DateTime::createFromFormat(PUBLIC_DATE_FORMAT, $_POST['data']['endTime']);
	$endTime = $a->format(DATE_TIME_FORMAT);
	/*$a = strptime($_POST['data']['startTime'], '%Y-%m-%d @ %H:%M');
	$startTime = mktime($a['tm_hour'], $a['tm_min'], 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);
	$a = strptime($_POST['data']['endTime'], '%Y-%m-%d @ %H:%M');
	$endTime = mktime($a['tm_hour'], $a['tm_min'], 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);*/

	$matchID = $db->sql("SELECT MAX(matchID) FROM matches")->fetch();
	$matchID = $matchID[0];
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','name','{$_POST['data']['name']}')");
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','startTime','$startTime')");
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','endTime','$endTime')");
	$db->sql("INSERT INTO `matchData` (`matchID`,`key`,`value`) VALUES ('$matchID','description','{$_POST['data']['description']}')");
	
	$matchDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='startTime' THEN value END ) AS startTime, " .
		"MAX(CASE WHEN `key`='endTime' THEN value END ) AS endTime, " .
		"MAX(CASE WHEN `key`='description' THEN value END ) AS description " .
		"FROM matchData WHERE matchID = {$matchID}";
	$matchData = $db->sql($matchDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $matchData);
	$out['row']['startTime'] = date(PUBLIC_DATE_TIME_FORMAT,$out['row']['startTime']);
	$out['row']['endTime'] = date(PUBLIC_DATE_TIME_FORMAT,$out['row']['endTime']);
	
	$sportCentreQueryString = "SELECT `centreID` FROM `sports` WHERE `sportID` = '{$_POST['data']['sportID']}'";
	$sportCentre = $db->sql($sportCentreQueryString)->fetch();
	$out['row']['centreID'] = $sportCentre['centreID'];
	
	$sportQueryString = "SELECT DISTINCT `value` FROM `sportData` WHERE `key` = 'name' AND `sportID` = '{$_POST['data']['sportID']}'";
	$sportName = $db->sql($sportQueryString)->fetch();
	$out['row']['sportName'] = $sportName['value'];
	
	$venueQueryString = "SELECT DISTINCT `value` FROM `venueData` WHERE `key` = 'name' AND `venueID` = '{$_POST['data']['venueID']}'";
	$venueName = $db->sql($venueQueryString)->fetch();
	$out['row']['venueName'] = $venueName['value'];
	
	$out['row']['tournamentName'] = "None";	
} elseif($_POST['action']=='edit') {
	$a = DateTime::createFromFormat(PUBLIC_DATE_FORMAT, $_POST['data']['startTime']);
	$startTime = $a->format(DATE_TIME_FORMAT);
	$a = DateTime::createFromFormat(PUBLIC_DATE_FORMAT, $_POST['data']['endTime']);
	$endTime = $a->format(DATE_TIME_FORMAT);
	/*$a = strptime($_POST['data']['startTime'], '%Y-%m-%d @ %H:%M');
	$startTime = mktime($a['tm_hour'], $a['tm_min'], 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);
	$a = strptime($_POST['data']['endTime'], '%Y-%m-%d @ %H:%M');
	$endTime = mktime($a['tm_hour'], $a['tm_min'], 0, $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);*/
	
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['name']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'name'");
	$db->sql("UPDATE `matchData` SET `value` = '$startTime' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'startTime'");
	$db->sql("UPDATE `matchData` SET `value` = '$endTime' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'endTime'");
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['description']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'description'");
	$db->sql("UPDATE `matchData` SET `value` = '{$_POST['data']['tournamentID']}' WHERE `matchID` = '{$_POST['data']['matchID']}' AND `key` = 'tournamentID'");
	
	$matchDataQueryString = "SELECT " .
		"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
		"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
		"MAX(CASE WHEN `key`='startTime' THEN value END ) AS startTime, " .
		"MAX(CASE WHEN `key`='endTime' THEN value END ) AS endTime, " .
		"MAX(CASE WHEN `key`='tournamentID' THEN value END ) AS tournamentID " .
		"FROM matchData WHERE matchID = {$_POST['data']['matchID']}";
	$matchData = $db->sql($matchDataQueryString)->fetch();
	$out['row'] = array_merge($out['row'], $matchData);
	$out['row']['startTime'] 	= date(PUBLIC_DATE_TIME_FORMAT,$out['row']['startTime']);
	$out['row']['endTime'] 		= date(PUBLIC_DATE_TIME_FORMAT,$out['row']['endTime']);
		
	$sportCentreQueryString = "SELECT `centreID` FROM `sports` WHERE `sportID` = '{$_POST['data']['sportID']}'";
	$sportCentre = $db->sql($sportCentreQueryString)->fetch();
	$out['row']['centreID'] = $sportCentre['centreID'];
	
	$sportQueryString = "SELECT DISTINCT `value` FROM `sportData` WHERE `key` = 'name' AND `sportID` = '{$_POST['data']['sportID']}'";
	$sportName = $db->sql($sportQueryString)->fetch();
	$out['row']['sportName'] = $sportName['value'];
	
	$venueQueryString = "SELECT DISTINCT `value` FROM `venueData` WHERE `key` = 'name' AND `venueID` = '{$_POST['data']['venueID']}'";
	$venueName = $db->sql($venueQueryString)->fetch();
	$out['row']['venueName'] = $venueName['value'];
	
	if(!empty($out['row']['tournamentID'])) {
		$tournamentQueryString = "SELECT DISTINCT `value` FROM `tournamentData` WHERE `key` = 'name' AND `tournamentID` = '{$_POST['data']['tournamentID']}'";
		$tournamentName = $db->sql($tournamentQueryString)->fetch();
		$out['row']['tournamentName'] = $tournamentName['value'];
	} else {
		$out['row']['tournamentName'] = "None";
	}
}

// Send it back to the client
echo json_encode( $out );