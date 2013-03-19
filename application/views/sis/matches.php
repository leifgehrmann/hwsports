
<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<h1>Matches</h1>
<p>Filter the matches using the form below.</p>
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