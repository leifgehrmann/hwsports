<h1><a href="/sis/tournaments">Tournaments</a><div class="icon subsection"></div><?=$tournament['name']?></h1>

<? if ( $tournament['status'] == "inRegistration" ) { ?>
<table class="">
	<tr>
		<td><div class="icon subscribe margin-right"></div><p>Registration ends on <?=datetime_to_public_date($tournament['registrationEnd'])?> at <?=datetime_to_public_time($tournament['registrationEnd'])?>.</p></td>
		<td><a href='/sis/signup/<?=$tournament['tournamentID']?>' class='button green'>Sign Up Now!</a></td>
	</tr>
</table>
<? } ?>
<p><?=$tournament['description']?></p>
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