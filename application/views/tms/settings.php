<h1>Centre Settings</h1>
	
<?php echo form_open("tms/settings", array('id' => 'settingsForm'));?>
<h2>Opening Times:</h2>
<table>
	<tr><td></td><td></td><td>From</td><td>Till</td></tr>
	<tr>
		<td><label for="monOpenTime">Monday:</label></td>
		<td><?php echo form_checkbox($monOpen);?></td>
		<td><?php echo form_input($monOpenTime);?></td>
		<td><?php echo form_input($monCloseTime);?></td>
	</tr>
	<tr>
		<td><label for="tueOpenTime">Tuesday:</label></td>
		<td><?php echo form_checkbox($tueOpen);?></td>
		<td><?php echo form_input($tueOpenTime);?></td>
		<td><?php echo form_input($tueCloseTime);?></td>
	</tr>
	<tr>
		<td><label for="wedOpenTime">Wednesday:</label></td>
		<td><?php echo form_checkbox($wedOpen);?></td>
		<td><?php echo form_input($wedOpenTime);?></td>
		<td><?php echo form_input($wedCloseTime);?></td>
	</tr>
	<tr>
		<td><label for="thuOpenTime">Thursday:</label></td>
		<td><?php echo form_checkbox($thuOpen);?></td>
		<td><?php echo form_input($thuOpenTime);?></td>
		<td><?php echo form_input($thuCloseTime);?></td>
	</tr>
	<tr>
		<td><label for="friOpenTime">Friday:</label></td>
		<td><?php echo form_checkbox($friOpen);?></td>
		<td><?php echo form_input($friOpenTime);?></td>
		<td><?php echo form_input($friCloseTime);?></td>
	</tr>
	<tr>
		<td><label for="satOpenTime">Saturday:</label></td>
		<td><?php echo form_checkbox($satOpen);?></td>
		<td><?php echo form_input($satOpenTime);?></td>
		<td><?php echo form_input($satCloseTime);?></td>
	</tr>
	<tr>
		<td><label for="sunOpenTime">Sunday:</label></td>
		<td><?php echo form_checkbox($sunOpen);?></td>
		<td><?php echo form_input($sunOpenTime);?></td>
		<td><?php echo form_input($sunCloseTime);?></td>
	</tr>
</table>
<p><?php echo form_submit('submit', 'Submit Changes',$submit);?></p>
    
<?php echo form_close();?>

<script type="text/javascript"> $('input.time').timepicker(); </script>

<!-- /#main -->