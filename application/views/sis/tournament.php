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
			events: '/db_calendar/getAllMatches/',
			editable: true,
			eventResize: function(match,dayDelta,minuteDelta,revertFunc) {
				//console.log(match);
				var minutesDelta = ((dayDelta*1440)+minuteDelta)*60;
				var request = $.ajax({
					type: "POST",
					url: '/db_calendar/changeMatchEnd',
					data: { 'minutesDelta': minutesDelta, 'id': match.data.id }
				});
 
				request.done(function(msg) {
				 //alert( msg );
				});
				 
				request.fail(function(jqXHR, textStatus) {
				  alert( "Request failed: " + textStatus );
				});
			},
			eventDrop: function(match,dayDelta,minuteDelta,allDay,revertFunc) {
				//console.log(match);
				var minutesDelta = ((dayDelta*1440)+minuteDelta)*60;
				//alert(minutesDelta);
				var request = $.ajax({
					type: "POST",
					url: '/db_calendar/changeMatchStart',
					data: { 'minutesDelta': minutesDelta, 'id': match.data.id }
				});
 
				request.done(function(msg) {
				 //alert( msg );
				});
				 
				request.fail(function(jqXHR, textStatus) {
				  alert( "Request failed: " + textStatus );
				});
			}
		});
		
	});
</script>