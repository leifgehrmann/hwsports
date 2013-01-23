<h1>Tournament Management</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<?php echo form_open("tms/tournaments", array('id' => 'tournamentsForm'));?>
  	
	<h2>Create Tournament:</h2>
	<p>
	<label for="name">Name:</label><br />
		<?php echo form_input($name);?>
	</p>
	<label for="description">Description:</label><br />
		<?php echo form_input($description);?>
	</p>

	<p><?php echo form_submit('submit', 'Create');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
	//$('input.time').timepicker();
</script>

<!-- /#main -->