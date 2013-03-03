<h1><a href="/tms/tournaments/">Tournaments</a> &#9656; <span id="title-name"><?=$tournament["name"]?></span></h1>
	
<?=form_open("tms/tournament/$tournamentID", array('id' => 'tournamentForm'))?>
<? $formTop = "
			<h2>Tournament Details:</h2>
			<p>
				<label for='name'>Name:</label><br />
				".form_input($name)."
			</p>
			<p>
				<label for='description'>Description:</label><br />
				".form_input($description)."
			</p>
			<p>
				<label for='sport'>Sport:</label>
				<span class='tournamentSport'>{$tournament['sportName']}</span>
			</p>"; ?>

	<? switch($tournament['status']) { 
		case "preRegistration": ?>
			<h3 class="tournamentStatusMessage preRegistration">This tournament has not yet opened for registration. You may change any of the details below.</h3>
			<?=$formTop?>
			<label for="tournamentStart">Start Date:</label> <?php echo form_input($tournamentStart);?> <label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?>
			<br />
			<h3>Competitor Registration Period:</h3>
			<label for="registrationStart">Start Date:</label> <?php echo form_input($registrationStart);?> <label for="registrationEnd">End Date:</label><?php echo form_input($registrationEnd);?> <br />		
		<? break; ?>
		<? case "inRegistration": ?>
			<h3 class="tournamentStatusMessage inRegistration">This tournament is open for registration. You may change any of the tournament details or manage the list of competitors to date.</h3>
			<?=$formTop?>
			<label for="tournamentStart">Start Date:</label> <?php echo form_input($tournamentStart);?> <label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?>
			<br />
			<h3>Competitor Registration Period:</h3>
			<label for="registrationEnd">End Date:</label><?php echo form_input($registrationEnd);?> <br />
		<? break; ?>
		<? case "postRegistration": ?>
			<h3 class="tournamentStatusMessage postRegistration">This tournament has closed for registration. You may change any of the tournament details below. Before matches can be sceduled, you must moderate the list of competitors below.</h3>
			<?=$formTop?>
			<label for="tournamentStart">Start Date:</label> <?php echo form_input($tournamentStart);?> <label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?> <br />
		<? break; ?>
		<? case "preTournament": ?>
			<h3 class="tournamentStatusMessage preTournament">This tournament has completed registration and scheduling and is awaiting the start date. You may change any of the tournament details or manage the list of competitors below.</h3>
			<?=$formTop?>
			<label for="tournamentStart">Start Date:</label> <?php echo form_input($tournamentStart);?> <label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?> <br />
		<? break; ?>
		<? case "inTournament": ?>
			<h3 class="tournamentStatusMessage inTournament">This tournament is in progress. You may change any of the tournament details or manage the list of competitors below, and <a href="/tms/tournament-statistics/">view statistics here.</a></h3>
			<?=$formTop?>
			<br />
			<label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?> <br />
		<? break; ?>
		<? case "postTournament": ?>
			<h3 class="tournamentStatusMessage postTournament">This tournament has finished. You may <a href="/tms/tournament-statistics/">view statistics here.</a></h3>
			<h2>Tournament Details:</h2>
			<p>
				<label for='name'>Name:</label><br /><?=$tournament['name']?>
			</p>
			<p>
				<label for='description'>Description:</label><br /><?=$tournament['description']?>
			</p>
			<p>
				<label for='sport'>Sport:</label>
				<span class='tournamentSport'><?=$tournament['sportName']?></span>
			</p>
			<br />
		<? break;
		default: ?>
			<h3 class="tournamentStatusMessage invalidDates"><?=$tournament['status']?></h3>
			<?=$formTop?>
			<label for="tournamentStart">Start Date:</label> <?php echo form_input($tournamentStart);?> <label for="tournamentEnd">End Date:</label> <?php echo form_input($tournamentEnd);?>
			<br />
			<h3>Competitor Registration Period:</h3>
			<label for="registrationStart">Start Date:</label> <?php echo form_input($registrationStart);?> <label for="registrationEnd">End Date:</label><?php echo form_input($registrationEnd);?> <br />		
		<? break; ?>	
	<? } ?>
	<p><?php echo form_submit('submit', 'Update');?></p>
	<p><a href="/tms/delete_tournament/<?=$tournamentID?>" class="deleteTournament">Delete</a></p>
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datetimepicker({ timeFormat: $.timepicker.ISO_8601Z });
</script>

<!-- /#main -->