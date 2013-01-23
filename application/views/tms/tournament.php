<h1>Tournament Management</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
<? } ?>


<?php echo form_open("tms/tournament/{$tournamentID}", array('id' => 'tournamentForm'));?>
  	
	<h2>Tournament Details:</h2>
	<p>
		<label for="name">Name:</label><br />
		<?php echo form_input($name);?>
	</p>
		<label for="description">Description:</label><br />
		<?php echo form_input($description);?>
	</p>
	<br />
	<table>
		<tr>
			<td><label for="registrationStart">Registration Start:</label></td>
			<td><?php echo form_input($registrationStart);?></td>
		</tr>
		<tr>
			<td><label for="registrationEnd">Registration End:</label></td>
			<td><?php echo form_input($registrationEnd);?></td>
		</tr>
	</table>
	<br />
	<table>
		<tr>
			<td><label for="tournamentStart">Tournament Start:</label></td>
			<td><?php echo form_input($tournamentStart);?></td>
		</tr>
		<tr>
			<td><label for="tournamentEnd">Tournament End:</label></td>
			<td><?php echo form_input($tournamentEnd);?></td>
		</tr>
	</table>
	
	<p><?php echo form_submit('submit', 'Update');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datepicker();
</script>

<!-- /#main -->