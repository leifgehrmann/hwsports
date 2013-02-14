<? 

// We wish to have all our tournaments sorted by 
// year and placed into groups of the year. we
// do this by putting all the tournaments into
// particular year arrays.
$yearTournaments = array();
foreach($tournaments as $tournament) {
	$date = DateTime::createFromFormat('d/m/Y', $tournament['tournamentStart'])
	$year = date_format($date,'Y');
	$yearTournaments[$year][] = $tournament;
}
function compareTournamentTime($a, $b) {
	return strtotime($a["tournamentStart"]) - strtotime($b["tournamentStart"]);
}

foreach($yearTournaments as $year){
	usort($year, "compareTournamentTime");
}

?>

<h1>Tournaments</h1>

<div class="tournaments-list">
	<? print_r($yearTournaments);foreach($yearTournaments as $year=>$tournaments) { ?>
		<h2><?=$year?></h2>
		<div>
		<? foreach($tournaments as $tournament) { 
			$registrationStartDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationStart']);
			$registrationEndDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationEnd']);
			$today = new DateTime();
		?>
			<div class="widget half">
				<a href="/sis/tournament/<?=$tournament['tournamentID']?>">
					<div class="widget-title">
						<div class="widget-title-left icon sport-<?=$tournament['sportID']?>"></div>
						<div class="widget-title-centre"><?=$tournament['name']?></div>
						<div class="widget-title-right icon chevron"></div>
					</div>
				</a>
				<div class="widget-body">
					<p><b>Duration:</b> <?=$tournament['tournamentStart']?> - <?=$tournament['tournamentEnd']?></p>
					<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
					<?=( ($registrationStartDate < $today) && ($today < $registrationEndDate) ? "<a href='/sis/signup/{$tournament['tournamentID']}' class='button right green'>Sign up!</a>" : "" )?>
				</div>
			</div>
		<? } ?>
		</div>
	<? } ?>
	<!--<? foreach($tournaments as $tournament) { 
		$registrationStartDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationStart']);
		$registrationEndDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationEnd']);
		$today = new DateTime();
		?>
		<a href="/sis/tournament/<?=$tournament['tournamentID']?>" class="tournament-item">
			<div class="tournament-name"><?=$tournament['name']?></div>
			<div class="tournament-date-start"><?=$tournament['tournamentStart']?></div>
			<div class="tournament-date-end"><?=$tournament['tournamentEnd']?></div>
			<div class="tournament-registration-status"><span style="font-weight: bold">Registration:</span> <?=( ($registrationStartDate < $today) && ($today < $registrationEndDate) ? "<span class='registrationOpen'>Open!</span>" : "<span class='registrationClosed'>Closed</span>" )?></div>
		</a>
		<? } ?>-->
	<!--<a href="/sis/tournaments_history" class="tournament-button-prev">Previous Tournaments</a>-->
</div>