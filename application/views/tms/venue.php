<h1><a href="/tms/venues/">Venue</a> &#9654; <?=$this->data["venue"]["name"]?></h1>

<?=$this->data["venue"]["name"]?>
<?=$this->data["venue"]["description"]?>
<?=$this->data["venue"]["directions"]?>

<h2>Occupied Calendar</h2>

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
			//events: '/calendar/getVenueMatches/<?=$this->data["venue"]["venueID"]?>',
			editable: true
		});
		
	});
</script>