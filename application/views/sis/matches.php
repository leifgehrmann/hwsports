<h1>Matches</h1>
<p>Filter the matches using the form below.</p>
<?= form_open("tms/calendar", array('id' => 'filterForm'));?>
<table class="full">
	<tr>
		<td>View: </td>
		<td><?= form_dropdown('viewSelection', $viewOptions, $viewSelection ); ?></td>
		<td>Sport: </td>
		<td><?= form_dropdown('sportSelection', $sportOptions, $sportSelection ); ?></td>
	</tr>
	<tr>
		<td>Tournament: </td>
		<td><?= form_dropdown('tournamentSelection', $tournamentOptions, $tournamentSelection ); ?></td>
		<td>Venue: </td>
		<td><?= form_dropdown('venueSelection', $venueOptions, $venueSelection ); ?></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td><?=form_submit(array('name'=>'submit', 'value'=>'Filter Matches', 'class' => 'green'))?></td>
	</tr>
</table>
<?= form_close();?>

<table class="full matches">
	<thead>
		<tr>
			<th></th>
			<th>Date</th>
			<th>Start</th>
			<th>End</th>
			<th>Title</th>
			<th>Venue</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($matches as $match) { ?>
		<tr class="match sportCategoryID-<?=$match['sportData']['sportCategoryID']?> sportID-<?=$match['sportID']?>">
			<td><div class="icon"></div></td>
			<td><?=$match['date']?></td>
			<td><?=$match['startTime']?></td>
			<td><?=$match['endTime']?></td>
			<td><?=$match['name']?></td>
			<td><?=$match['venueData']['name']?></td>
			<td><a href="/sis/match/<?=$match['matchID']?>">View Details</a></td>
		</tr>
		<? } ?>
	</tbody>
</table>


<script>
$(document).ready(function(){
	$('table.matches').dataTable();
});
</script>