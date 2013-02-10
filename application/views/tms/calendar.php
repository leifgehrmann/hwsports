<h1>Calendar</h1>
<p>Below is a list of upcoming matches and tournaments.</p>
<ul>
	<li>Tournaments are coloured as <span style="color:rgb(73, 134, 231);font-weight:bold;">blue</span>.</li>
	<li>Tournament matches are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">green</span>.</li>
	<li>Standard bookings are coloured as <span style="color:rgb(123, 209, 72);font-weight:bold;">brown</span>.</li>
</ul>
<p>Click the matches/tournaments for more information.</p>
<p>Drag a match to change the start date/time, or stretch it from the bottom to change it's length.</p>
<div class="filter">
	<h2>Filter Category</h2>
	<p>Select a category to filter the calendar results.</p>
	<input type="checkbox" name="filter" value="tournament" class="filter-tournament">
	<select name="select_tournament" disabled class="select-tournament">
		<option value="a">A</option>
		<option value="b">B</option>
		<option value="c">C</option>
	</select>
	<input type="checkbox" name="filter" value="venue" class="filter-venue">
	<input type="checkbox" name="filter" value="sport" class="filter-sport">
</div>
<div id='calendar'></div>
<script type='text/javascript' src='/js/fullcalendar/_loader.js'></script>
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
			events: '/db_calendar/getAllEventsTMS/',
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