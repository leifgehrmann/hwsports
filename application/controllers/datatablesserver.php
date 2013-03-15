<?php 
// Alias Editor classes so they are easy to use
define("DATATABLES", true, true);

// DataTables PHP library
require( FCPATH.APPPATH."libraries/DataTables/DataTables.php" );
require( FCPATH.APPPATH."libraries/DataTables/Database/Database.php" );
						
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;

class DatatablesServer extends MY_Controller {

	function __construct() {
		parent::__construct();
		//
		// Database connection
		//   Database connection it globally available
		//
		$this->dtdb = new Database();

		// Leif was here :)
		$this->dtdb->sql("SET character_set_client=utf8");
		$this->dtdb->sql("SET character_set_connection=utf8");
		$this->dtdb->sql("SET character_set_results=utf8");
	}

	public function sports() {
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
			)
			->field( 
				Field::inst( 'sportCategoryID' )
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
				
				$sportDataQueryString = "SELECT " .
					"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
					"MAX(CASE WHEN `key`='description' THEN value END ) AS description " .
					"FROM `sportData` WHERE `sportID` = '{$sport['sportID']}'";
				$sportData = $db->sql($sportDataQueryString)->fetch();
				$out['aaData'][$aaDataID] = array_merge($sport, $sportData);
				
				$sportCategoryNameQueryString = "SELECT MAX(CASE WHEN `key`='name' THEN value END ) AS name FROM `sportCategoryData` WHERE `sportCategoryID` = '{$sport['sportCategoryID']}'";
				$sportCategoryName = $db->sql($sportCategoryNameQueryString)->fetch();
				
				$out['aaData'][$aaDataID]['sportCategoryName'] = $sportCategoryName['name'];
			}
			
			$sportCategoryDataQueryString = "SELECT `sportCategoryID` AS value, `value` AS label FROM `sportCategoryData` WHERE `key` = 'name'";
			$sportCategoryData = $db->sql($sportCategoryDataQueryString)->fetchAll();
			$out['sportCategoryData'] = $sportCategoryData;
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
			
			$sportCategoryNameQueryString = "SELECT MAX(CASE WHEN `key`='name' THEN value END ) AS name FROM `sportCategoryData` WHERE `sportCategoryID` = '{$_POST['data']['sportCategoryID']}'";
			$sportCategoryName = $db->sql($sportCategoryNameQueryString)->fetch();
			$out['row']['sportCategoryName'] = $sportCategoryName['name'];
		} elseif($_POST['action']=='edit') {
			$db->sql("UPDATE `sportData` SET `value` = '{$_POST['data']['name']}' WHERE `sportID` = '{$_POST['data']['sportID']}' AND `key` = 'name'");
			$db->sql("UPDATE `sportData` SET `value` = '{$_POST['data']['description']}' WHERE `sportID` = '{$_POST['data']['sportID']}' AND `key` = 'description'");
			
			$sportDataQueryString = "SELECT " .
				"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
				"MAX(CASE WHEN `key`='description' THEN value END ) AS description " .
				"FROM `sportData` WHERE `sportID` = '{$_POST['data']['sportID']}'";
			$sportData = $db->sql($sportDataQueryString)->fetch();
			$out['row'] = array_merge($out['row'], $sportData);
			
			$sportCategoryNameQueryString = "SELECT MAX(CASE WHEN `key`='name' THEN value END ) AS name FROM `sportCategoryData` WHERE `sportCategoryID` = '{$_POST['data']['sportCategoryID']}'";
			$sportCategoryName = $db->sql($sportCategoryNameQueryString)->fetch();
			$out['row']['sportCategoryName'] = $sportCategoryName['name'];
		}

		// Send it back to the client
		echo json_encode( $out );
	
	}
	
	public function venues() {
		if ( isset($_POST['action']) ) {
			if($_POST['action']=='remove') {
				// Clean up venue data
				foreach($_POST['data'] as $rowString) {
					$venueID = substr($rowString,4);
					$db->sql("DELETE FROM `venueData` WHERE `venueID` = '{$venueID}'");
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
		} elseif($_POST['action']=='edit') {
			$db->sql("UPDATE `venueData` SET `value` = '{$_POST['data']['name']}' WHERE `venueID` = '{$_POST['data']['venueID']}' AND `key` = 'name'");
			$db->sql("UPDATE `venueData` SET `value` = '{$_POST['data']['description']}' WHERE `venueID` = '{$_POST['data']['venueID']}' AND `key` = 'description'");
			$db->sql("UPDATE `venueData` SET `value` = '{$_POST['data']['directions']}' WHERE `venueID` = '{$_POST['data']['venueID']}' AND `key` = 'directions'");
			$db->sql("UPDATE `venueData` SET `value` = '{$_POST['data']['lat']}' WHERE `venueID` = '{$_POST['data']['venueID']}' AND `key` = 'lat'");
			$db->sql("UPDATE `venueData` SET `value` = '{$_POST['data']['lng']}' WHERE `venueID` = '{$_POST['data']['venueID']}' AND `key` = 'lng'");
			
			$venueDataQueryString = "SELECT " .
				"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
				"MAX(CASE WHEN `key`='description' THEN value END ) AS description, " .
				"MAX(CASE WHEN `key`='directions' THEN value END ) AS directions, " .
				"MAX(CASE WHEN `key`='lat' THEN value END ) AS lat, " .
				"MAX(CASE WHEN `key`='lng' THEN value END ) AS lng " .
				"FROM venueData WHERE venueID = {$_POST['data']['venueID']}";
			$venueData = $db->sql($venueDataQueryString)->fetch();
			$out['row'] = array_merge($out['row'], $venueData);
		}

		// Send it back to the client
		echo json_encode( $out );
	
	}
	
	public function matches() {
	
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

				/*print_r("test");
				print_r($out['aaData'][$aaDataID]['startTime']);
				print_r(DATE_TIME_FORMAT);
				print_r(DateTime::createFromFormat(DATE_TIME_FORMAT,$out['aaData'][$aaDataID]['startTime']));
				print_r(DateTime::createFromFormat(DATE_TIME_FORMAT,$out['aaData'][$aaDataID]['startTime'])->format(PUBLIC_DATE_TIME_FORMAT));*/
				$out['aaData'][$aaDataID]['startTime'] = new DateTime($out['aaData'][$aaDataID]['startTime']);
				$out['aaData'][$aaDataID]['startTime'] = $out['aaData'][$aaDataID]['startTime']->format(PUBLIC_DATE_TIME_FORMAT);
				$out['aaData'][$aaDataID]['endTime'] = new DateTime($out['aaData'][$aaDataID]['endTime']);
				$out['aaData'][$aaDataID]['endTime'] = $out['aaData'][$aaDataID]['endTime']->format(PUBLIC_DATE_TIME_FORMAT);

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
			$a = DateTime::createFromFormat(PUBLIC_DATE_TIME_FORMAT, $_POST['data']['startTime']);
			$startTime = $a->format(DATE_TIME_FORMAT);
			$a = DateTime::createFromFormat(PUBLIC_DATE_TIME_FORMAT, $_POST['data']['endTime']);
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
			$out['row']['startTime'] 	= DateTime::createFromFormat(DATE_TIME_FORMAT,$out['row']['startTime'])->format(PUBLIC_DATE_TIME_FORMAT);
			$out['row']['endTime'] 		= DateTime::createFromFormat(DATE_TIME_FORMAT,$out['row']['endTime'])->format(PUBLIC_DATE_TIME_FORMAT);
			/*$out['row']['startTime'] = date(PUBLIC_DATE_TIME_FORMAT,$out['row']['startTime']);
			$out['row']['endTime'] = date(PUBLIC_DATE_TIME_FORMAT,$out['row']['endTime']);*/
			
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
			$a = DateTime::createFromFormat(PUBLIC_DATE_TIME_FORMAT, $_POST['data']['startTime']);
			$startTime = $a->format(DATE_TIME_FORMAT);
			$a = DateTime::createFromFormat(PUBLIC_DATE_TIME_FORMAT, $_POST['data']['endTime']);
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
			$out['row']['startTime'] 	= DateTime::createFromFormat(DATE_TIME_FORMAT,$out['row']['startTime'])->format(PUBLIC_DATE_TIME_FORMAT);
			$out['row']['endTime'] 		= DateTime::createFromFormat(DATE_TIME_FORMAT,$out['row']['endTime'])->format(PUBLIC_DATE_TIME_FORMAT);
				
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
	}
}