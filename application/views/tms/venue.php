<h1><a href="/tms/venues/">Venues</a> &#9656; <?=$this->data["venue"]["name"]?></h1>
<div id='message'></div>
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
			echo "\t\t<td style='width:{$widths[1]}'><input id='form-{$fields[$i]}' type='text' oldvalue='{$this->data['venue'][$fields[$i]]}' onchange='changed(\"{$fields[$i]}\")' value='{$this->data['venue'][$fields[$i]]}'></td>";
		else if($types[$i]=="textfield")
			echo "\t\t<td style='width:{$widths[1]}'><textarea id='form-{$fields[$i]}' onchange='changed(\"{$fields[$i]}\")' oldvalue='{$this->data['venue'][$fields[$i]]}'>{$this->data['venue'][$fields[$i]]}</textarea></td>";
		echo "\t\t<td id='edit-{$fields[$i]}' style='width:{$widths[2]}'><button style='display:none' onclick='update(\"{$fields[$i]}\")'>Update</button><button style='display:none' onclick='cancel(\"{$fields[$i]}\")'>Cancel</button></td>";
		echo "\t</tr>";
	}
	echo "</table>";
?>

<h2>Occupied Calendar</h2>

<div id='calendar'></div>

<script type='text/javascript'>
	function changed(fieldname){
		$("#edit-"+fieldname).next('button').show();
	}
	function cancel(fieldname){
		input = $("#form-"+fieldname);
		input.val(input.attr('oldvalue'));
		$("#edit-"+fieldname).next('button').hide();
	}
	function update(fieldname){
		var form_data = {};
		form_data[fieldname] = $("#form-"+fieldname).val();
		jQuery.ajax({
			url: "/db_venues/update_venue/<?=$this->data['venue']['venueID']?>",
			type: 'POST',
			async : false,
			data: form_data,
			success: function(msg) {
				$("#edit-"+fieldname).next('button').show();
			}
		});
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