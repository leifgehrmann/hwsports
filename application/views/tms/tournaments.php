<h1>Tournament Management</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<h2>View / Edit Existing Tournament:</h2>
<div id="tournamentSelect">
	<? if(count($tournaments)>0) {
		foreach($tournaments as $tournament) { 
			echo "<a href='/tms/tournament/{$tournament['tournamentID']}'>{$tournament['name']}</a><br />\n";
		}
	   } else {
			echo "No tournaments exist yet.";
	   } ?>
</div>
<br />
<br />

<?php echo form_open("tms/tournaments", array('id' => 'tournamentsForm'));?>
	
	<table>
		<tr>
			<td colspan="4"><h2>Create New Tournament:</h2></td>
		</tr>
		<tr>
			<td><label for="name">Name:</label></td>
			<td><?php echo form_input($name);?></td>
			<td rowspan="2"><label for="description">Description:</label></td>
			<td rowspan="2"><?php echo form_input($name);?></td>
		</tr>
		<tr>
			<td><label for="name">Sport:</label></td>
			<td><?php echo form_dropdown('sport', $sports); ?></td>
		</tr>
		<tr>
			<td><label for="tournamentStart">Start Date:</label></td>
			<td><?php echo form_input($tournamentStart);?></td>
			<td><label for="tournamentEnd">End Date:</label></td>
			<td><?php echo form_input($tournamentEnd);?></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Competitor Registration Period:</h3></td>
		</tr>
		<tr>
			<td><label for="registrationStart">Start Date:</label></td>
			<td><?php echo form_input($tournamentStart);?></td>
			<td><label for="registrationEnd">End Date:</label></td>
			<td><?php echo form_input($registrationStart);?></td>
		</tr>
		<tr>
			<td colspan="1"></td>
			<td><?php echo form_submit('submit', 'Create');?></td>
		</tr>
	</table>
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datepicker({
      dateFormat: "dd/mm/yy"
    });
</script>

<!-- /#main -->