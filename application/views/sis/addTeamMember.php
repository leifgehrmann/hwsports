<div class="fancyform">
	<? if(!empty($success)) { ?>
	<script type="text/javascript">
	$('a.addTeamMember').before('<p class="teamMember"><?=$user['firstName'].' '.$user['lastName']?> (ID: <span class="teamMemberID"><?=$user['id']?></span>)</p>');
	$.fancybox.close();
	</script>
	<? } else { ?>
	<h1>Add New Team Member</h1>
	<p>Please enter the member's details below.</p>

	<? if(!empty($message)){ ?>
	<div id="infoMessage"><?=$message;?></div>
	<? } ?>

	<?php echo form_open("/sis/addTeamMember");?>
	<table class="standardInputs">
		<tbody>
			<tr>
				<td>First Name:</td>
				<td><?php echo form_input($first_name);?></td>
				<td>Last Name: </td>
				<td><?php echo form_input($last_name);?></td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td>Email: </td>
				<td><?php echo form_input($email);?></td>
				<td rowspan="2">Address: </td>
				<td rowspan="2"><?php echo form_textarea($address);?></td>
			</tr>
			<tr>
				<td>Phone: </td>
				<td><?php echo form_input($phone);?></td>
			</tr>
			<tr>
			</tr>
		</tbody>
		<tbody class="extraInputs">
		<? foreach($extraInputs as $input) { print_r($input); continue; ?>
			<tr>
				<td><?=$input['formLabel']?></td>
				<td>
					<? switch( $input['inputType'] ) {
						case "textarea": ?> <textarea id="<?=$input['keyName']?>" name="<?=$input['keyName']?>"></textarea><br /> <? break;
						case "text": case "phone": case "email": ?> <input type="text" id="<?=$input['keyName']?>" name="<?=$input['keyName']?>"></input><br /> <? break;
						case "checkbox": ?> <input type="checkbox" id="<?=$input['keyName']?>" name="<?=$input['keyName']?>" value="1"></input><br /> <? break;
					} ?>
				</td>
			</tr>
		<? } ?> 
		</tbody>
	</table>
	<p><?php echo form_submit('submit', 'Create Team Member');?></p>

	<?php echo form_close();?>
	<? } ?>
</div>