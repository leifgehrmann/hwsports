<h1><a href="/sis/tournaments">Tournaments</a><div class="icon subsection"></div><?=$tournament['name']?></h1>

<? if ( $tournament['status'] == "inRegistration" ) { ?>
<p><b>Start:</b><?=datetime_to_public_date($tournament['tournamentStart'])?></p>
<p><b>End:</b><?=datetime_to_public_date($tournament['tournamentEnd'])?></p>
<p><?=$tournament['description']?></p>
<table>
	<tr>
		<td><h2><div class="icon subscribe margin-right"></div>Sign up for <?=$tournament['name']?>!</h2></td>
		<td rowspan="2"><a href='/sis/signup/<?=$tournament['tournamentID']?>' class='button green'>Sign Up Now!</a></td>
	</tr>
	<tr>
		<td><p>Registration ends on <?=datetime_to_public_date($tournament['registrationEnd'])?> at <?=datetime_to_public_time($tournament['registrationEnd'])?>.</p></td>
	</tr>
</table>
<? } ?>
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
			events: '/db_calendar/getTournamentMatches/<?=$tournament['tournamentID']?>',
			editable: false
		});
		
	});
</script>