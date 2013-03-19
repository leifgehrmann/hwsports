<div class="fancyform">
	<? if(!empty($success)) { ?>
	<script type="text/javascript">
	<? /*$('a.addTeamMember').before('<p class="teamMember"><?=$user['firstName'].' '.$user['lastName']?> (ID: <span class="teamMemberID"><?=$user['id']?></span>)</p>'); ?>*/?>
	$('tbody.teamMembers').append('<tr class="teamMemberRow"><td class="teamMemberUserID"><?=$user['id']?></td><td><?=$user['firstName'].' '.$user['lastName']?></td><td><?=$user['email']?></td><td><?=$user['password']?></td><td><a href="#" onclick="$(this).parents(\'tr\').remove();" class="deleteTeamMember">(X)</a></td></tr>');
	$.fancybox.close();
	</script>
	<? } else { ?>
	<h1>Log In</h1>
	<p>Please sign in with your email and password<br />to add your user account to this team.</p>

	<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
	<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
	<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
	<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
	<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

	<?php echo form_open("/sis/addLoginTeamMember/$tournamentID/$sectionID");?>

	<table>
		<tr>
			<td><label for="email">Email:</label></td>
			<td><?php echo form_input($email);?></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label></td>
			<td><?php echo form_input($password);?></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo form_submit('submit', 'Login');?></td>
		</tr>
	</table>

	<?php echo form_close();?>
	<? } ?>
</div>