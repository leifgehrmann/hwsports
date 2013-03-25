<h1>Edit Profile</h1>
<h2>General User Details</h2>
<?=form_open("auth/edit_user/", array('id' => 'userDetailsForm'))?>
<table>
      <tr>
            <td>First Name</td>
            <td><?=form_input($firstName)?></td>
            <td>Last Name</td>
            <td><?=form_input($lastName)?></td>
      </tr>
      <tr>
            <td>Email</td>
            <td><?=$user['email']?></td>
            <td>Phone</td>
            <td><?=form_input($phone)?></td>
      </tr>
      <tr>
            <td>Address</td>
            <td colspan="3"><?=form_textarea($address)?></td>
      </tr>
      <tr>
            <td>Bio</td>
            <td colspan="3"><?=form_textarea($aboutMe)?></td>
      </tr>
      <tr>
            <td colspan="3"></td>
            <td><?=form_submit(array('name'=>"submit", 'value'=>"Update User", 'class'=>"right green"));?></td>
      </tr>
</table>
<?=form_close();?>

<h2>Emergency Contact Details</h2>
<?=form_open("auth/edit_user/", array('id' => 'emergencyDetailsForm'))?>
<table>
      <tr>
            <td>Name</td>
            <td><?=form_input($emergencyName)?></td>
      </tr>
      <tr>
            <td>Email</td>
            <td><?=form_input($emergencyEmail)?></td>
            <td>Phone</td>
            <td><?=form_input($emergencyPhone)?></td>
      </tr>
      <tr>
            <td>Address</td>
            <td colspan="3"><?=form_textarea($emergencyAddress)?></td>
      </tr>
      <tr>
            <td colspan="3"></td>
            <td><?=form_submit(array('name'=>"submit", 'value'=>"Update Emergency Contact", 'class'=>"right green"));?></td>
      </tr>
</table>
<?=form_close();?>

<? if(!empty($message)){ ?>
      <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<?php echo form_open(current_url());?>

      <p>
            First Name: <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            Last Name: <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            Company Name: <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            Phone: <br />
            <?php echo form_input($phone1);?>-<?php echo form_input($phone2);?>-<?php echo form_input($phone3);?>
      </p>

      <p>
            Password: (if changing password)<br />
            <?php echo form_input($password);?>
      </p>

      <p>
            Confirm Password: (if changing password)<br />
            <?php echo form_input($password_confirm);?>
      </p>


      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', 'Save User');?></p>

<?php echo form_close();?>