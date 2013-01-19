<h1><a href="/tms/venues/">Venue</a> &#9656; <?=$this->data["venue"]["name"]?></h1>

<table>
	<tr>
		<th>Venue Name</th>
		<td><?=$this->data["venue"]["name"]?></td>
		<td><button>Edit</button></td>
	</tr>
	<tr>
		<th>Description</th>
		<td style="width:50%"><?=$this->data["venue"]["description"]?></td>
		<td><button>Edit</button></td>
	</tr>
	<tr>
		<th>Directions</th>
		<td style="width:50%"><?=$this->data["venue"]["directions"]?></td>
		<td><button>Edit</button></td>
	</tr>
</table>

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