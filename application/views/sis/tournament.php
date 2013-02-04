<h1><a href="/sis/tournaments">Tournaments</a> &gt; <?=$tournament['name']?></h1>
<?php
	$tmpl = array (
		'table_open'          => '<table cellspacing="0">',
		'heading_cell_start'  => '<td>',
		'heading_cell_end'    => '</td>',
	);
	$this->table->set_template($tmpl);

	echo $this->table->generate($tournamentTable);

	if ( $registrationOpen ) { ?>
		<div class="tournament-signup-button">
			<a href='/sis/signup/<?=$tournamentID?>' class='tournamentSignupButton'>Sign Up Now!</a>
		</div>
	<? } ?>
<h2>Calendar</h2>
<p>Click the entries for details on individual matches</p>

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
			events: '/db_calendar/getTournamentMatches/',
			editable: false
		});
		
	});
</script>