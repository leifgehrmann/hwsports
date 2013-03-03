<h1><a href="/auth/login">Log In</a><div class="icon subsection"></div>Forgot Password</h1>
<p>Please enter your email address so we can send you an email to reset your password.</p>

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