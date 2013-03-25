<h1><a href="/sis/<?=$match['tournamentData']['tournamentID']?>"><?=$match['tournamentData']['name']?></a><div class="icon subsection"></div><?=$match['name']?></h1>
<table>
	<tr>
		<td>Date:</td>
		<td><?=$match['datetime']?></td>
	</tr>
	<tr>
		<td>Duration:</td>
		<td><?=$match['duration']?></td>
	</tr>
	<? if(isset($match['description'])) { ?>
	<tr>
		<td>Description:</td>
		<td><?=$match['description']?>:</td>
	</tr>
	<? } ?>
	<tr>
		<td>venue:</td>
		<td><?=$match['venueData']['name']?>:</td>
	</tr>
	<tr>
		<td>venue:</td>
		<td><?=$match['venueData']['name']?>:</td>
	</tr>
</table>