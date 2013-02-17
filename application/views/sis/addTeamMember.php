<div class="fancyform">
	<? if(!empty($success)) { ?>
	<script type="text/javascript">
	$('a.addTeamMember').before('<p class="teamMember"><?=$user['firstName'].' '.$user['lastName']?> (ID: <span class="teamMemberID"><?=$user['id']?></span>)</p>');
	$.fancybox.close();
	</script>
	<? } else { ?>
	<h1>Add New Team Member</h1>
	<p>Please enter the member's details below.</p>

	<? if(!empty($message)){ ?>
	<div id="infoMessage"><?=$message;?></div>
	<? } ?>

	<?php echo form_open("/sis/addTeamMember");?>
	<table>
		<tr>
			<td>First Name:</td>
			<td><?php echo form_input($first_name);?></td>
		</tr>
		<tr>
			<td>Last Name: </td>
			<td><?php echo form_input($last_name);?></td>
		</tr>
		<tr>
			<td>Email: </td>
			<td><?php echo form_input($email);?></td>
		</tr>
		<tr>
			<td>Phone: </td>>
			<td><?php echo form_input($phone);?></td>
		</tr>
	</table>
	<p><?php echo form_submit('submit', 'Create Team Member');?></p>

	<?php echo form_close();?>
	<? } ?>
</div>