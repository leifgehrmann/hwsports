<h1>Calendar</h1>
<p>Below is a list of upcoming matches and tournaments.</p>
<ul>
	<li>Tournaments are coloured as <span style="color:rgb(73, 134, 231);font-weight:bold;">blue</span>.</li>
	<li>Matches are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">green</span>.</li>
	<li>Registration periods are coloured as <span style="color:rgb(250, 87, 60);font-weight:bold;">red</span>.</li>
</ul>
<p>Click the matches/tournaments for more information.</p>

<div id='calendar'></div>

<script type='text/javascript' src='/scripts/fullcalendar/_loader.js'></script>
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
			events: '/db_calendar/getAllTournamentEventsSIS/',
			editable: false
		});
		
	});
</script>