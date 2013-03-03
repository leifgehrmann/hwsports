<h1><a href="/sis/account">Account</a><div class="icon subsection"></div>Change Password</h1>

<?php echo form_open("auth/change_password");?>

<table>
	<tr>
		<td>Old Password:</td>
		<td><?php echo form_input($old_password);?></td>
	</tr>
	<tr>
		<td>New Password:</td>
		<td><?php echo form_input($new_password);?></td>
	</tr>
	<tr>
		<td>Confirm New Password:</td>
		<td><?php echo form_input($new_password_confirm);?></td>
	</tr>
	<tr>
		<td><?php echo form_input($user_id);?></td>
		<td><?php echo form_submit('submit', 'Change Password');?></td>
	</tr>
</table>

<?php echo form_close();?>
