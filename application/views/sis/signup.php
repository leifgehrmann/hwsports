
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>

	<h2>Sign Up for <?=$tournament['name']?>:</h2>
	
	<h3 id="actionHeading">Select role:</h3>
	<? foreach($roles as $roleID => $role) { ?>
		<a href="" class="roleButton" id="roleButton-<?=$roleID?>"><?=$role['name']?></a>
		
		<div class="roleSections" id="roleSections-<?=$roleID?>" style="display: none">
			<? foreach($role['inputSections'] as $sectionID => $section) { ?>
			<h3 class="sectionHeading" id="sectionHeading-<?=$sectionID?>"><?=$section['label']?></h3>
			<div class="sectionBody" id="sectionBody-<?=$sectionID?>">
				<? foreach($section['inputs'] as $inputID => $input) { ?>
				<?=$input['formLabel']?><br />
				<? switch( $input['inputType'] ) {
						case "textarea": ?> <textarea id="<?=$input['keyName']?>" name="<?=$input['keyName']?>"></textarea><br /> <? break; 
						case "text": ?> <input type="text" id="<?=$input['keyName']?>" name="<?=$input['keyName']?>"></input><br /> <? break; 
						case "checkbox": ?> <input type="checkbox" id="<?=$input['keyName']?>" name="<?=$input['keyName']?>" value="1"></input><br /> <? break; 
				} ?>
				<br />
				<? } ?>
			</div>	
			<? } ?>
		</div>
		
	<? } ?>
	
<!-- /#main -->

<script type="text/javascript">
	$(document).ready(function() {
		$(".roleButton").click(function(){
			var roleID = $(this).attr('id').substr(11);
			$(".roleButton").hide();
			$("#actionHeading").hide();

			$("#roleSections-"+roleID).show("slow");
			$("#roleSections-"+roleID).accordion();
			return false;
		});
	});
</script>