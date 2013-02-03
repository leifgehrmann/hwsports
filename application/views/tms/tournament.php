<h1><a href="/tms/tournaments/">Tournaments</a> &#9656; <span id="title-name"><?=$tournament["name"]?></span></h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>


<?php echo form_open("tms/tournament/{$tournamentID}", array('id' => 'tournamentForm'));?>
  	
	<h2>Tournament Details:</h2>
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
	
	<p><?php echo form_submit('submit', 'Update');?></p>
    
<?php echo form_close();?>

<h1></h1>

<script type="text/javascript">
	$('.date').datepicker({
      dateFormat: "dd/mm/yy"
    });
</script>

<!-- /#main -->