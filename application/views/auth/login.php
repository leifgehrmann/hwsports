<h1>Log In</h1>
<p>Please sign in with your email and password below.</p>

<?php echo form_open("auth/login");?>

<table>
    <tr>
        <td><label for="identity">Email:</label></td>
        <td><?php echo form_input($identity);?></td>
    </tr>
    <tr>
        <td><label for="password">Password:</label></td>
        <td><?php echo form_input($password);?></td>
    </tr>
    <tr>
        <td><label for="remember">Remember Me:</label></td>
        <td><?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo form_submit('submit', 'Login');?></td>
    </tr>
</table>

<?php echo form_close();?>

<p><a href="forgot_password">Forgot your password?</a></p>

<p><a href="/auth/register">Don't have an account? Click here to register.</a></p>