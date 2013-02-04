<h1>Tournaments</h1>

<div class="tournaments-list">
	<h3>2013</h3>
	<? foreach($tournaments as $tournament) { 
		$registrationStartDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationStart']);
		$registrationEndDate = DateTime::createFromFormat('d/m/Y', $tournament['registrationEnd']);
		$today = new DateTime();
	?>
	<a href="/sis/tournament/<?=$tournament['tournamentID']?>" class="tournament-item">
		<div class="tournament-name"><?=$tournament['name']?></div>
		<div class="tournament-date-start"><?=$tournament['tournamentStart']?></div>
		<div class="tournament-date-end"><?=$tournament['tournamentEnd']?></div>
		<div class="tournament-registration-status"><?=( ($registrationStartDate < $today) && ($today < $registrationEndDate) ? "Registration open!" : "Registration closed" )?></div>
	</a>
	<? } ?>
	<a href="/sis/tournaments-history" class="tournament-button-prev">Previous Tournaments</a>
</div>