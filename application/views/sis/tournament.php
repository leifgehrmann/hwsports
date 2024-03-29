<? $this->method_call =& get_instance(); ?>
<h1><a href="/sis/tournaments">Tournaments</a><div class="icon subsection"></div><?=$tournament['name']?></h1>

<? if ( $tournament['status'] == "inRegistration" && $tournament['hasRoles'] ) { ?>
<p><b>Start:</b><?=$this->method_call->datetime_to_public_date($tournament['tournamentStart'])?> &ndash; <b>End:</b><?=$this->method_call->datetime_to_public_date($tournament['tournamentEnd'])?></p>
<p><?=$tournament['description']?></p>
<table>
	<tr>
		<td><h2><div class="icon subscribe margin-right"></div>Sign up for <?=$tournament['name']?>!</h2></td>
		<td rowspan="2"><a href='/sis/signup/<?=$tournament['tournamentID']?>' class='button green'>Sign Up Now!</a></td>
	</tr>
	<tr>
		<td><p>Registration ends on <?=$this->method_call->datetime_to_public_date($tournament['registrationEnd'])?> at <?=$this->method_call->datetime_to_public_time($tournament['registrationEnd'])?>.</p></td>
	</tr>
</table>
<? } ?>
<? if ( in_array($tournament['status'],array('inTournament','preTournament','postTournament')) ) { ?>
<h2>Matches</h2>
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
			<td><?=$this->method_call->datetime_to_public_date($match['startTime'])?></td>
			<td><?=$this->method_call->datetime_to_public_time($match['startTime'])?></td>
			<td><?=$this->method_call->datetime_to_public_time($match['endTime'])?></td>
			<td><?=$match['name']?></td>
			<td><?=$match['venueData']['name']?></td>
			<td><a href="/sis/match/<?=$match['matchID']?>">View Details</a></td>
		</tr>
		<? } ?>
	</tbody>
</table>
<? } ?>

<script>
$(document).ready(function(){
	$('table.matches').dataTable();
});
</script>

<h2>Calendar</h2>
<p>Click the entries for details on individual matches</p>

<div id='calendar'></div>

<script type='text/javascript' src='/js/vendor/fullcalendar/_loader.js'></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			firstDay: '1',
			contentHeight: 590,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: '/db_calendar/getTournamentEventsSIS/<?=$tournament['tournamentID']?>',
			editable: false
		});
		
	});
</script>