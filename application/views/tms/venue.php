<h1><a href="/tms/venues/">Venue</a> &#9656; <?=$this->data["venue"]["name"]?></h1>

<?php
	$fields = array("name","description","directions");
	$labels = array("Venue Name","Description","Directions");
	$widths = array("20%","60%","20%");

	echo "<table>";
	for($i=0;$i<count($fields);$i++){
		echo "\t<tr>";
		echo "\t\t<th style='width:{$widths[0]}'>{$labels[$i]}</th>";
		echo "\t\t<td style='width:{$widths[1]}'><?=$this->data['venue']['{$fields[$i]}']?></td>";
		echo "\t\t<td style='width:{$widths[2]}'><button>Edit</button></td>";
		echo "\t</tr>";
	}
	echo "</table>";
?>

<!--<table>
	<tr>
		<th style="width:20%">Venue Name</th>
		<td style="width:60%"><?=$this->data["venue"]["name"]?></td>
		<td style="width:20%"><button>Edit</button></td>
	</tr>
	<tr>
		<th style="width:20%">Description</th>
		<td style="width:60%"><?=$this->data["venue"]["description"]?></td>
		<td style="width:20%"><button>Edit</button></td>
	</tr>
	<tr class="">
		<th style="width:20%">Directions</th>
		<td style="width:60%"><?=$this->data["venue"]["directions"]?></td>
		<td style="width:20%"><<button>Edit</button></td>
	</tr>
</table>-->

<h2>Occupied Calendar</h2>

<div id='calendar'></div>

<script type='text/javascript'>
	function {

	}
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