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
  	
	<h2>Create New Tournament:</h2>
	<p>
		<label for="name">Name:</label><br />
		<?php echo form_input($name);?>
	</p>
	<p>
		<label for="description">Description:</label><br />
		<?php echo form_input($description);?>
	</p>
	<p>
		<label for="sport">Sport:</label><br />
		<?php echo form_dropdown('sport', $sports); ?>
	</p>
	<label for="tournamentStart">Start Date:</label> <?php echo form_input($tournamentStart);?> <label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?>
	<br />
	<h3>Competitor Registration Period:</h3>
	<label for="registrationStart">Start Date:</label> <?php echo form_input($registrationStart);?> <label for="registrationEnd">End Date:</label><?php echo form_input($registrationEnd);?> <br />
	
	<p><?php echo form_submit('submit', 'Create');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datepicker({
      dateFormat: "dd/mm/yy"
    });
</script>

<!-- /#main -->