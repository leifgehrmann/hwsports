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
				{
					title: 'All Day Event',
					start: new Date(y, m, 1)
				},
				{
					title: 'Long Event',
					start: new Date(y, m, d-5),
					end: new Date(y, m, d-2)
				},

				// Ficitional Matches

				{
					title: 'Wattball - Hunters vs. Blue Jays',
					start: new Date(y, m, d-3, 10, 11.5),
					allDay: false,
					color: '#2966C7'
				},
				{
					title: 'Wattball - Greens vs. The Red Cows',
					start: new Date(y, m, d-3, 10, 11.5),
					allDay: false,
					color: '#2966C7'
				},
				{
					title: 'Wattball - Hunters vs. Blue Jays',
					start: new Date(y, m, d-3, 14, 15.5),
					allDay: false,
					color: '#2966C7'
				},
				{
					title: 'Mens Hurdling - Round 1',
					start: new Date(y, m, d-3, 14, 15.5),
					allDay: false,
					color: '#2966C7'
				},



				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Meeting',
					start: new Date(y, m, d, 10, 30),
					allDay: false,
					color: '#5AB128'
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false,
					color: '#2966C7'
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false,
					color: '#EA472C'
				},
				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
			]
		});
		
	});
	// Gblue '#4986E7'
	// GGreen '#7AD148'
	// Gred '#FA573C'
</script>
<div id='calendar'></div>