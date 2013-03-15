<h1>Calendar</h1>
<p>Click the matches/tournaments for more information.</p>
<p>Drag a match to change the start date/time, or stretch it from the bottom to change it's length.</p>
<ul>
	<li>Tournaments are coloured as <span style="color:rgb(73, 134, 231);font-weight:bold;">blue</span>.</li>
	<li>Tournament matches are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">green</span>.</li>
	<li>Standard bookings are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">brown</span>.</li>
</ul>
<?php echo form_open("tms/calendar", array('id' => 'filterForm'));?>
<h2>Filter Category</h2>
<table>
	<tr>
		<td>View</td>
		<td>form_dropdown('viewSelect', $viewOptions, $viewSelection );</td>
		<td>Sport</td>
		<td>form_dropdown('sportSelect', $sportOptions, $sportSelection );</td>
	</tr>
	<tr>
		<td>Tournament</td>
		<td>form_dropdown('tournamentSelect', $tournamentOptions, $tournamentSelection );</td>
		<td>Venue</td>
		<td>form_dropdown('venueSelect', $venueOptions, $venueSelection );</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td><?php echo form_submit('submit', 'Submit Changes', array('class' => 'green'));?></td>
	</tr>
</table>
<?php echo form_close();?>
<div id='calendar'></div>
<script type='text/javascript' src='/js/vendor/fullcalendar/_loader.js'></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			firstDay: '1',
			contentHeight: 600,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: '/db_calendar/getAllEventsTMS/',
			editable: true,
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				//console.log(match);
				var secondsDelta = ((dayDelta*1440)+minuteDelta)*60;
				var request = $.ajax({
					type: "POST",
					url: '/db_calendar/change_event_end',
					data: { 'secondsDelta': secondsDelta, 'id': event.data.id }
				});
 
				request.done(function(msg) {
					if(msg.indexOf("Error") != -1) {
						revertFunc();
						$("<div id='calendarErrorDialog'>"+msg+"</div>").dialog({show: 'slide', hide: 'explode', buttons: { 'Close': function() { $(this).dialog('close'); } }, closeOnEscape: true, resizable: false});
					}
				});
				 
				request.fail(function(jqXHR, textStatus) {
					revertFunc();
					alert( "Internal error occurred, please contact Infusion Systems: "+jqXHR.responseText );
				});
			},
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
				//console.log(match);
				var secondsDelta = ((dayDelta*1440)+minuteDelta)*60;
				//alert(minutesDelta);
				var request = $.ajax({
					type: "POST",
					url: '/db_calendar/move_event',
					data: { 'secondsDelta': secondsDelta, 'id': event.data.id }
				});
 				
				request.done(function(msg) {
					if(msg.indexOf("Error") != -1) {
						revertFunc();
						$("<div id='calendarErrorDialog'>"+msg+"</div>").dialog({show: 'slide', hide: 'explode', buttons: { 'Close': function() { $(this).dialog('close'); } }, closeOnEscape: true, resizable: false});
					}
				});
				 
				request.fail(function(jqXHR, textStatus) {
					revertFunc();
					alert( "Internal error occurred, please contact Infusion Systems: "+jqXHR.responseText );
				});
			}
		});
			
	});
</script>