<h1>Calendar</h1>
<p>Below is a list of upcoming matches and tournaments.</p>
<ul>
	<li>Tournaments are coloured as <span style="color:rgb(73, 134, 231);font-weight:bold;">blue</span>.</li>
	<li>Tournament matches are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">green</span>.</li>
	<li>Standard bookings are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">brown</span>.</li>
</ul>
<p>Click the matches/tournaments for more information.</p>

<div id='calendar'></div>

<script type='text/javascript'>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			firstDay: '1',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: '/db_calendar/getAllMatches/',
			editable: true
		});
		
	});
</script>