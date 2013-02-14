<h1>Matches</h1>

<div class="matches-upcoming">
	<h2>Upcoming Matches</h2>
	
	<? foreach($matches as $match) { ?>
	<div class="widget half">
		<a href="/sis/match/<?=$match['matchID']?>">
			<div class="widget-title">
				<div class="widget-title-left icon sportname-<?=$match['sport']?> sportid-<?=$tournament['sportID']?>"></div>
				<div class="widget-title-centre"><?=$match['name']?></div>
				<div class="widget-title-right icon chevron"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Date:</b> <?=$match['date']?></p>
			<p><b>Duration:</b> <?=$match['startTime']?> - <?=$match['endTime']?></p>
			<p><b>Venue:</b> <?=$match['venue']?></p>
			<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
			<?=( ($registrationStartDate < $today) && ($today < $registrationEndDate) ? "<a href='/sis/signup/{$tournament['tournamentID']}' class='button right green'>Sign up!</a>" : "" )?>
		</div>
	</div>
	<? } ?>
	<a href="/sis/all_matches" class="match-button-next">Full Upcoming List</a>
</div>
