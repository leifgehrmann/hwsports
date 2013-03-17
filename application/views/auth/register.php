<h1>Register an Account</h1>
<p>Please enter your details below to create an account.</p>

<?php echo form_open("auth/register");?>

<table>
	<tr>
		<td>First Name:</td>
		<td><?php echo form_input($firstName);?></td>
	</tr>
	<tr>
		<td>Last Name:</td>
		<td><?php echo form_input($lastName);?></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><?php echo form_input($email);?></td>
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