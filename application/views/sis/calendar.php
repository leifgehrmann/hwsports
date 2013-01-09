<h1>Calendar</h1>
<p>Below is a list of upcoming matches and tournaments.</p>
<ul>
	<li>Tournaments are coloured as <span style="color:rgb(73, 134, 231);font-weight:bold;">blue</span>.</li>
	<li>Matches are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">green</span>.</li>
	<li>Registration periods are coloured as <span style="color:rgb(250, 87, 60);font-weight:bold;">red</span>.</li>
</ul>
<p>Click the matches/tournaments for more information.</p>

<script type='text/javascript'>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		//rgb(123, 209, 72) green
		//rgb(73, 134, 231) blue
		$('#calendar').fullCalendar({
			firstDay: '1',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: [

				// Matches

				{
					title: 'Wattball - Hunters vs. Blue Jays',
					start: new Date(y, m, d, 10, 11.5),
					allDay: false,
					color: '#2966C7',
					url: 'http://google.com/'
				},
				{
					title: 'Wattball - Greens vs. The Red Cows',
					start: new Date(y, m, d, 10, 11.5),
					allDay: false,
					color: '#2966C7',
					url: 'http://google.com/'
				},
				{
					title: 'Wattball - Hunters vs. Blue Jays',
					start: new Date(y, m, d, 14, 15.5),
					allDay: false,
					color: '#2966C7',
					url: 'http://google.com/'
				},
				{
					title: 'Mens Hurdling - Round 1',
					start: new Date(y, m, d, 14, 15.5),
					allDay: false,
					color: '#2966C7',
					url: 'http://google.com/'
				},

				// Tournaments

				{
					title: 'Heriot Watt Tournament 2013',
					start: new Date(y, m, d-3),
					end: new Date(y, m, d+2)
					color: '#5AB128',
					url: '/sis/tournament/1'
				},


				// Registration times

				{
					title: 'WattBall Registration Period',
					start: new Date(y, m, d+1),
					end: new Date(y, m, d+1),
					allDay: false,
					color: '#EA472C'
				},
			]
		});
		
	});
	// Gblue '#4986E7'
	// GGreen '#7AD148'
	// Gred '#FA573C'
</script>
<div id='calendar'></div>