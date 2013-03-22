<h1>Tournaments</h1>

<div>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tournaments" width="100%">
		<thead>
			<tr>
				<th width="2%">&nbsp;</th>
				<th width="3%">ID</th>
				<th>Name</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Description</th>
				<th>Sport</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<script src="/js/vendor/datatables/tournaments.js"></script>
</div>

<h2>Create a New Tournament</h2>
<?php echo form_open("tms/tournaments", array('id' => 'tournamentsForm'));?>
	<table>
		<tr>
			<td><label for="name">Name:</label></td>
			<td><?php echo form_input($name);?></td>
			<td><label for="name">Sport:</label></td>
			<td><?php echo form_dropdown('sport', $sports); ?></td>
		</tr>
		<tr>
			<td><label for="description">Description:</label></td>
			<td colspan="3"><?php echo form_textarea($description);?></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Competitor Registration Period:</h3></td>
		</tr>
		<tr>
			<td><label for="registrationStart">Start Date:</label></td>
			<td><?php echo form_input($registrationStart);?></td>
			<td><label for="registrationEnd">End Date:</label></td>
			<td><?php echo form_input($registrationEnd);?></td>
		</tr>
		<tr>
			<td colspan="4"><h3>Match Scheduling Period:</h3></td>
		</tr>
		<tr>
			<td><label for="tournamentStart">Start Date:</label></td>
			<td><?php echo form_input($tournamentStart);?></td>
			<td><label for="tournamentEnd">End Date:</label></td>
			<td><?php echo form_input($tournamentEnd);?></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<?php 
				$submitStyle = array(
					'name'  => 'submit',
					'value' => 'Create',
					'class' => 'green'
				);
			?>
			<td><p><?php echo form_submit($submitStyle);?></p></td>
		</tr>
	</table>
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datetimepicker({
		dateFormat: $.datepicker.ISO_8601,
		separator: ' ',
		timeFormat: 'HH:mm',
		ampm: false
	});
</script>

<!-- /#main -->