<h1><a href="/sis/tournaments">Tournaments</a> &gt; $tournamentName</h1>
<p></p>
<h2>Games</h2>
<?php


	$tmpl = array (
                    'table_open'          => '<table cellspacing="0">',
                    'heading_cell_start'  => '<td>',
                    'heading_cell_end'    => '</td>',
              );

	$this->table->set_template($tmpl);

	$info = array(
				array('<span class="bold"><a href="/sis/game/$gameID">Wattball</a></span>'              , '<a href="/sis/signup/$gameID">sign up</a>', 'A short descrption can maybe be added here'),
				array('<span class="bold"><a href="/sis/game/$gameID">Mens Heriot Hurdling</a></span>'  , '<a href="/sis/signup/$gameID">sign up</a>', 'A short descrption can maybe be added here'),
				array('<span class="bold"><a href="/sis/game/$gameID">Womens Heriot Hurdling</a></span>', '<a href="/sis/signup/$gameID">sign up</a>', 'A short descrption can maybe be added here')	
			);

	echo $this->table->generate($info);
?>
<h2>Calendar</h2>
<p>Click the entries for details on individual matches</p>

<script type='text/javascript'>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
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
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false
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
					allDay: false
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false
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

</script>
<div id='calendar'></div>

