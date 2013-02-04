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
		<div class="tournament-registration-status"><span style="font-weight: bold">Registration:</span> <?=( ($registrationStartDate < $today) && ($today < $registrationEndDate) ? "<span class='registrationOpen'>Open!</span>" : "<span class='registrationClosed'>Closed</span>" )?></div>
	</a>
	<? } ?>
	<a href="/sis/tournaments_history" class="tournament-button-prev">Previous Tournaments</a>
</div>