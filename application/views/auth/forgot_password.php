<h1><a href="/auth/login">Log In</a><div class="icon subsection">Forgot Password</h1>
<p>Please enter your email address so we can send you an email to reset your password.</p>

<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<?php echo form_open("auth/forgot_password");?>
<table>
	<tr>
		<td>Email Address:</td>
		<td><?php echo form_input($email);?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit('submit', 'Submit');?></td>
	</tr>
</table>
<?php echo form_close();?>