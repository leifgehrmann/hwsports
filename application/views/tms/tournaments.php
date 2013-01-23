<h1>Tournament Management</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
  print_r($tournaments);
<? } ?>

<h2>View / Edit Existing Tournament:</h2>
<select id="tournamentSelect">
	<? foreach($tournaments as $tournament) { 
		echo "<option value='{$tournament['tournamentID']}'>{$tournament['name']}</option>\n";
	 } ?>
</select>
<button id="viewEditTournament">Proceed</button>
<br />
<br />

<?php echo form_open("tms/tournaments", array('id' => 'tournamentsForm'));?>
  	
	<h2>Create New Tournament:</h2>
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
	
	<p><?php echo form_submit('submit', 'Create');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datepicker();
	$('#viewEditTournament').click( function() {
		document.location.href='/tms/tournament/' + $("#tournamentSelect option:selected").value();
	});
</script>

<!-- /#main -->