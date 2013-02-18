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

	<?php echo form_open("/sis/addTeamMember_details/$tournamentID/$sectionID");?>
	<table>
		<? foreach($extraInputs as $input) { ?>
		<tr>
			<td><?=$input['formLabel']?></td>
			<td>
				<? switch( $input['inputType'] ) {
					case "textarea": 
					echo form_textarea($input);
					break;
					case "text": case "phone": case "email": 
					echo form_input($input); 
					break;
					case "checkbox": 
					echo form_checkbox($input);
					break;
				} ?>
			</td>
		</tr>
		<? } ?> 
	</table>
	<p><?php echo form_submit('submit', 'Create Team Member');?></p>

	<?php echo form_close();?>
	<? } ?>
</div>