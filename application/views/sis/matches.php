<h1>Matches</h1>

<div class="matches-upcoming">
	<h2>Upcoming Matches</h2>
	
	<? foreach($matches as $match) { ?>
	<a href="/sis/match/<?=$match['matchID']?>" class="match-item">
		<div class="match-name"><?=$match['name']?></div>
		<div class="match-game"><?=$match['sport']?></div>
		<div class="match-tournament"><?=$match['tournament']?></div>
		<div class="match-venue"><?=$match['venue']?></div>
		<div class="match-date"><?=$match['date']?></div>
		<div class="match-time"><?=$match['startTime']?> - <?=$match['endTime']?></div>
	</a>
	<? } ?>
	<a href="/sis/all_matches" class="match-button-next">Full Upcoming List</a>
</div>
