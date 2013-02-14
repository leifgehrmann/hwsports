<h1>Change Password</h1>

<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<?php echo form_open("auth/change_password");?>

<table>
	<tr>
		<td>Old Password:<td>
		<td><?php echo form_input($old_password);?></td>
	</tr>
	<tr>
		<td>New Password (at least <?php echo $min_password_length;?> characters long):</td>
		<td><?php echo form_input($new_password);?></td>
	</tr>
	<tr>
		<td>Confirm New Password:</td>
		<td><?php echo form_input($new_password_confirm);?></td>
	</tr>
	<tr>
		<td><?php echo form_input($user_id);?></td>
		<td><?php echo form_submit('submit', 'Change');?></td>
	</tr>
</table>

<?php echo form_close();?>
