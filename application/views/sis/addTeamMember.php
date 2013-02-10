<div class="fancyform">
  <? if(!empty($success)) { ?>
		<div id="infoMessage"><?=$success;?></div>
  <? } else { ?>
		<h1>Add New Team Member</h1>
		<p>Please enter the member's details below.</p>

		<? if(!empty($message)){ ?>
			  <div id="infoMessage"><?php echo $message;?></div>
		<? } ?>

		<?php echo form_open("/sis/addTeamMember");?>

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

			  <p><?php echo form_submit('submit', 'Create Team Member');?></p>

		<?php echo form_close();?>
   <? } ?>
</div>