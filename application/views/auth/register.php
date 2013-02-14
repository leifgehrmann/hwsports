<h1>Register an Account</h1>
<p>Please enter your details below to create an account.</p>

<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<?php echo form_open("auth/register");?>

<table>
	<tr>
		<td>First Name:</td>
		<td><?php echo form_input($first_name);?></td>
	</tr>
	<tr>
		<td>Last Name:</td>
		<td><?php echo form_input($last_name);?></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><?php echo form_input($email);?></td>
	</tr>
	<tr>
		<td>Phone:</td>
		<td><?php echo form_input($phone);?></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><?php echo form_input($password);?></td>
	</tr>
	<tr>
		<td>Confirm Password:</td>
		<td><?php echo form_input($password_confirm);?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit('submit', 'Submit Registration');?></td>
	</tr>
</table>

<?php echo form_close();?>