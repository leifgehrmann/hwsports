<h1>Matches</h1>


This should be replaced with a static table of matches, preferably from datatables.

<div class="matches-upcoming">
	<? foreach($matches as $match) { ?>
	<div class="widget half match">
		<a href="/sis/match/<?=$match['matchID']?>">
			<div class="widget-title">
				<div class="widget-title-left icon sportname-<?=$match['sport']?> sportid-<?=$match['sportID']?>"></div>
				<div class="widget-title-centre"><?=$match['name']?></div>
				<div class="widget-title-right icon chevron"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Date:</b> <?=$match['date']?></p>
			<p><b>Duration:</b> <?=$match['startTime']?> - <?=$match['endTime']?></p>
			<p><b>Venue:</b> <?=$match['venue']?></p>
			<a href='/sis/match/<?=$match['matchID']?>' class='button right normal'>Details</a>
		</div>
	</div>
	<? } ?>
	<a href="/sis/all_matches" class="button blue match-button-next">Full Upcoming List</a>
</div>
