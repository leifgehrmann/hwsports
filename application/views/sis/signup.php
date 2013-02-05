
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>

	<h2>Sign Up for <?=$tournament['name']?>:</h2>
	
	<form action="/sis/signup/<?=$tournamentID?>" method="POST">
	
	<h3 id="actionHeading">Select role:</h3>
	<? foreach($roles as $roleID => $role) { ?>
		<a href="" class="roleButton" id="roleButton-<?=$roleID?>"><?=$role['name']?></a>
		
		<div class="roleSections" id="roleSections-<?=$roleID?>" style="display: none">
			<? 	$sectionCount = 0;
				foreach($role['inputSections'] as $sectionID => $section) { 
					$sectionCount++; ?>
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
				<? } 
				if( $sectionCount == 1 ) {
					echo "<div class='navButtons'><a href='#' class='nextButton'>Next</a></div>";
				} elseif( $sectionCount == count( $role['inputSections'] ) ) {
					echo "<div class='navButtons'><a href='#' class='backButton'>Back</a></div>";
				} else {
					echo "<div class='navButtons'><a href='#' class='backButton'>Back</a> <a href='#' class='nextButton'>Next</a></div>";
				} ?>
			</div>	
			<? } ?>
			<h3 class="sectionHeading" id="sectionHeading-submit">Submit Form</h3>
			<div class="sectionBody" id="sectionBody-submit">
				<input type="submit" value="Sign Up!" class="submitButton" />
			</div>
		</div>
		
	<? } ?>
	
<!-- /#main -->

<script type="text/javascript">
	$(document).ready(function() {
		$(".roleButton").click(function(){
			var roleID = $(this).attr('id').substr(11);
			$(".roleButton").remove();
			$("#actionHeading").remove();
			$('.roleSections').not("#roleSections-"+roleID).remove();

			$("#roleSections-"+roleID).show("fast");
			$("#roleSections-"+roleID).accordion({ 
				heightStyle: "content"
			});
			$("#submit").show();
			
				
			$(".nextButton").click(function(){
				var currentActiveSection = $("#roleSections-"+roleID).accordion( "option", "active" );
				$("#roleSections-"+roleID).accordion( "option", "active", currentActiveSection+1 );
				return false;
			});
			$(".backButton").click(function(){
				var currentActiveSection = $("#roleSections-"+roleID).accordion( "option", "active" );
				$("#roleSections-"+roleID).accordion( "option", "active", currentActiveSection-1 );
				return false;
			});
			return false;
		});
		
		
		// If only one role exists, click it - no point wasting the user's time
		if( $(".roleButton").length == 1 ) {
			$(".roleButton").click();
		}
	});
</script>