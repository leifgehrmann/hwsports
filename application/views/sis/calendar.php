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
			editable: true,
			events: [

				// Matches

					// Monday
					{
						title: 'Mens Hurdling - Preliminary Rounds',
						start: new Date(y, m, d-3, 12, 0),
						end:   new Date(y, m, d-3, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - Recoba vs. WattBulls',
						start: new Date(y, m, d-3, 10, 0),
						end:   new Date(y, m, d-3, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - The Red Cows vs. Hunters',
						start: new Date(y, m, d-3, 10, 0),
						end:   new Date(y, m, d-3, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Blue Jays vs. Greens',
						start: new Date(y, m, d-3, 14, 0),
						end:   new Date(y, m, d-3, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					

					// Tuesday
					{
						title: 'Mens Hurdling - Round 1',
						start: new Date(y, m, d-2, 12, 0),
						end:   new Date(y, m, d-2, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - The Red Cows vs. Greens',
						start: new Date(y, m, d-2, 10, 0),
						end:   new Date(y, m, d-2, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Blue Jays vs. Recoba',
						start: new Date(y, m, d-2, 10, 0),
						end:   new Date(y, m, d-2, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Hunters vs. WattBulls',
						start: new Date(y, m, d-2, 14, 0),
						end:   new Date(y, m, d-2, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},

					// Wednesday

					{
						title: 'Mens Hurdling - Round 2',
						start: new Date(y, m, d-1, 12, 0),
						end:   new Date(y, m, d-1, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},

					// Thursday

					{
						title: 'Mens Hurdling - Round 3',
						start: new Date(y, m, d, 12, 0),
						end:   new Date(y, m, d, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'Wattball - Hunters vs. Blue Jays',
						start: new Date(y, m, d, 10, 0),
						end:   new Date(y, m, d, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/'
					},
					{
						title: 'Wattball - Greens vs. The Red Cows',
						start: new Date(y, m, d, 10, 0),
						end:   new Date(y, m, d, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/'
					},
					{
						title: 'Wattball - Hunters vs. Blue Jays',
						start: new Date(y, m, d, 14, 0),
						end:   new Date(y, m, d, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/'
					},

					// Friday
					{
						title: 'Mens Hurdling - Round 4',
						start: new Date(y, m, d+1, 12, 0),
						end:   new Date(y, m, d+1, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},

				// Tournaments

				{
					title: 'Heriot Watt Tournament 2013',
					start: new Date(y, m, d-3),
					end: new Date(y, m, d+2),
					color: '#5AB128',
					url: '/sis/tournament/1'
				},


				// Registration times

				{
					title: 'WattBall Registration Period',
					start: new Date(y, m, d-30),
					end: new Date(y, m, d-5),
					color: '#EA472C'
				},
				{
					title: 'Heriot Hurdling Registration Period',
					start: new Date(y, m, d-30),
					end: new Date(y, m, d-7),
					color: '#EA472C'
				}
			]
		});
		
	});
	// Gblue '#4986E7'
	// GGreen '#7AD148'
	// Gred '#FA573C'
</script>
<div id='calendar'></div>