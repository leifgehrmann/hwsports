<h1>Teams</h1>
<table>
	<th>
		<td>Icon</td>
		<td>ID</td>
		<td>Name</td>
		<td>Tournament</td>
		<td>Sport</td>
		<td>Something else</td>
	</th>
	<? foreach($teams as $team) { ?>
	<tr>
		<td><div class="icon"></td>
		<td><?=$team['teamID']?></td>
		<td><?=$team['name']?></td>
		<td></td>
		<td></td>
		<td></td>
		<td><a class="button" href="/tms/user/<?=$team['teamID']?>">View</a></td>
	</tr>
	<? } ?>
</table>