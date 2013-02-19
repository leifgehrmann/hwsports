<div class="fancyform">
	<? if(!empty($success)) { ?>
	<script type="text/javascript">
	$('tbody.teamMembers').append('<tr><td><?=$user['id']?></td><td><?=$user['firstName'].' '.$user['lastName']?></td><td><?=$user['email']?></td><td><?=$user['password']?></td></tr>');
	$.fancybox.close();
	</script>
	<? } else { ?>
	<h1>Add New Team Member</h1>
	<p>Please enter the member's details below.</p>

	<? if(!empty($message)){ ?>
	<div id="infoMessage"><?=$message;?></div>
	<? } ?>

	<?php echo form_open("/sis/addTeamMember/$tournamentID/$sectionID");?>
	<table>
		<tbody class="standardInputs">
			<tr>
				<td>First Name:</td>
				<td><?php echo form_input($first_name);?></td>
				<td>Last Name: </td>
				<td><?php echo form_input($last_name);?></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td>Email: </td>
				<td><?php echo form_input($email);?></td>
			</tr>
			<tr>
				<td>Phone: </td>
				<td><?php echo form_input($phone);?></td>
			</tr>
			<tr>
			</tr>
		</tbody>
		<tbody class="extraInputs">
		<? foreach($extraInputs as $input) { ?>
			<tr>
				<td><?=$input['formLabel']?></td>
				<td>
					<? switch( $input['inputType'] ) {
						case "textarea": 
							echo form_textarea($input);
						break;
						case "text": case "phone": case "email": 
							echo form_input($input); 
						break;
						case "checkbox": 
							echo form_checkbox($input);
						break;
					} ?>
				</td>
			</tr>
		<? } ?> 
		</tbody>
	</table>
	<?php echo form_hidden('updateUser', $updateUser);?>
	<p><?php echo form_submit('submit', 'Create Team Member');?></p>

	<?php echo form_close();?>
	<? } ?>
</div>