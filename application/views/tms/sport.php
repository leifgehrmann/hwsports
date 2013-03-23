<h1><a href="/tms/sports/">Sports</a><div class="icon subsection"></div><span id="title-name"><?=$this->data["sport"]["name"]?></span></h1>
<?=form_open("tms/sport/$sportID", array('id' => 'sportDetailsForm'))?>
<table>
	<tr>
		<td>Name</td>
		<td><?=form_input($name)?></td>
		<td>Sport Cateogyr</td>
		<td><?=$sport['sportCategoryData']['name']?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td colspan="3"><?=form_textarea($description)?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td><?=form_submit(array('name'=>"submit", 'value'=>"Update Venue", 'class'=>"right green"));?></td>
	</tr>
</table>
<?=form_close();?>


<h2>Calendar</h2>

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
			events: '/db_calendar/getSportEventsTMS/<?=$sportID?>',
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