<h1>Matches</h1>
<p>Filter the matches using the form below, or browse the </p>
<form>
	<table class="full">
		<tr>
			<td>View: </td>
			<td>
				<select name="time">
					<option value="all">All Matches</option>
					<option value="upcoming">Upcoming Matches</option>
					<option value="recent">Recent Matches</option>
				</select>
			</td>
			<td>Sport: </td>
			<td>
				<select name="sportID">
					<option value="19">Wattball</option>
					<option value="23">Hurdling</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tournament: </td>
			<td>
				<select name="tournamentID">
					<option value="19">Wattball 2013</option>
					<option value="23">Men's Hurdling 2013</option>
					<option value="23">Women's Hurdling 2013</option>
				</select>
			</td>
			<td>Venue: </td>
			<td>
				<select name="venueID">
					<option value="19">Pitch A</option>
					<option value="23">Pitch B</option>
					<option value="23">Pitch C</option>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td><input type="submit" value="Filter" class="green" name="Filter Matches"></td>
		</tr>
	</table>
</form>
<script>
$(document).ready(function(){
	$('table.matches').dataTable();
});
</script>
<table class="full matches">
	<thead>
		<tr>
			<th></th>
			<th>Date</th>
			<th>Start</th>
			<th>Title</th>
			<th>Venue</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($matches as $match) { ?>
		<tr class="match sportname-<?=$match['sport']?> sportid-<?=$match['sportID']?>">
			<td><div class="icon"></div></td>
			<td><?=$match['date']?></td>
			<td><?=$match['startTime']?></td>
			<td><?=$match['name']?></td>
			<td><?=$match['venue']?></td>
			<td><a href="/sis/match/<?=$match['matchID']?>">View Details</a></td>
		</tr>
		<? } ?>
	</tbody>
</table>
<!--
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
</div>-->
