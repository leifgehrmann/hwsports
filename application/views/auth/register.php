<h1>Create User Account</h1>
<p>Please enter your details information below.</p>

<? if(!empty($message)){ ?>
      <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<?php echo form_open("auth/register");?>

      <p>
            First Name: <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            Last Name: <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            Email: <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            Phone: <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            Password: <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            Confirm Password: <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', 'Submit Registration');?></p>

<?php echo form_close();?>