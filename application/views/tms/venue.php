<h1><a href="/tms/venues/">Venue</a> &#9656; <?=$this->data["venue"]["name"]?></h1>

<?php
	$fields = array("name","description","directions");
	$labels = array("Venue Name","Description","Directions");
	$types = array("text","textfield","textfield");
	$widths = array("15%","40%","20%");

	echo "<table>";
	for($i=0;$i<count($fields);$i++){
		echo "\t<tr>";
		echo "\t\t<th style='width:{$widths[0]}'>{$labels[$i]}</th>";
		if($types[$i]=="text")
			echo "\t\t<td style='width:{$widths[1]}'><input name='{$fields[$i]}' type='text' oldvalue='{$this->data['venue'][$fields[$i]]}' onchange='' value='{$this->data['venue'][$fields[$i]]}'></td>";
		else if($types[$i]=="textfield")
			echo "\t\t<td style='width:{$widths[1]}'><textarea onchange='' oldvalue=''>{$this->data['venue'][$fields[$i]]}</textarea></td>";
		echo "\t\t<td style='width:{$widths[2]}'><button onclick='update(\"{$fields[$i]}\")'>Update</button><button onclick='cancel(\"{$fields[$i]}\")'>Cancel</button></td>";
		echo "\t</tr>";
	}
	echo "</table>";
?>

<h2>Occupied Calendar</h2>

<div id='calendar'></div>

<script type='text/javascript'>
	function toggle(){

	}
	function cancel(fieldname){
		input = document.getElementsByName(fieldname)[0];
		input.val(input.attr('oldvalue'));
	}
	function update(fieldname){
		
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