<div class="fancyform">
	<? if(!empty($success)) { ?>
	<script type="text/javascript">
	$('tbody.teamMembers').append('<tr><td class="teamMemberUserID"><?=$user['id']?></td><td><?=$user['firstName'].' '.$user['lastName']?></td><td><?=$user['email']?></td><td><?=$user['password']?></td></tr>');
	$.fancybox.close();
	</script>
	<? } else { ?>
	<h1>Add New Team Member</h1>
	<p><?=$updateUser ? "Please fill in your missing details below" : "Please enter the member's details below."?></p>

	<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
	<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
	<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
	<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
	<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>
	
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