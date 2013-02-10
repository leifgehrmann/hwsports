
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>

	<h2>Sign Up for <?=$tournament['name']?>:</h2>
	
	<form action="/sis/signup/<?=$tournamentID?>" id="signupForm" method="POST">
	
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
								case "teamMembers": ?> <a href="/sis/addTeamMember" class="addTeamMember fancybox.ajax">Add Team Member</a> <? break;
						} ?>
						<br />
						<? } 
						if( $sectionCount == 1 ) {
							echo "<div class='navButtons'><a href='#' class='nextButton'>Next</a></div>";
						} else {
							echo "<div class='navButtons'><a href='#' class='backButton'>Back</a> <a href='#' class='nextButton'>Next</a></div>";
						} ?>
					</div>	
			<? } ?>
			<h3 class="sectionHeading" id="sectionHeading-submit">Complete Sign Up Process</h3>
		</div>
		
	<? } ?>
	
	</form>
	
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
			
			// functionality of next/back buttons - open new section	
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
			//functionality of submit button
			$("#sectionHeading-submit").unbind("click").unbind("dblclick").bind("click dblclick", (function () {
				$("#signupForm").submit();
				return false;
			}));
			
			//open up form to take team member details
			$(".addTeamMember").fancybox({
				beforeShow:function (){			
					//grab this function so that we can pass it back to
					//`onComplete` of the new fancybox we're going to create
					var func = arguments.callee;

					console.log("we're in the onComplete function of a fancybox!");
					
					
					//bind the submit of our new form
					$('.fancyform form').unbind('submit').bind("submit", function() {

						var data = $(this).serialize();
						var url = $(this).attr('action')
						
						alert( $('.fancyform input[type=submit]').text() );
						
						return false; 
					});
					/*
					//bind the submit of our new form
					$('.fancyform form').unbind('submit').bind("submit", function() {
						console.log("we're in the submit function of a fancyform!");

						//post to the server and when we get a response, 
						//draw a new fancybox, and run this function on completion
						//so that we can bind the form and create a new fancybox on submit
						$.post(url, data, function(msg){
							alert(msg);
							//$.fancybox({content:msg,beforeShow:func});
						});
						
						return false; 
					});
					*/
				}
			});
			
			// put cursor in first input inside newly opened section for usability
			$("#roleSections-"+roleID).on( "accordionactivate", function( event, ui ) {
				console.log(ui);
				$("input", ui.newPanel).first().focus();
			});
			return false;
		});
		
		// make anchors follow the same UX experience as input buttons - pressing spacebar clicks them
		$("a").die("keypress").live("keypress", function(e) {
			if (e.which == 32) {
				$(this).trigger("click");
				e.preventDefault();
			}
		});
		
		// If only one role exists, click it - no point wasting the user's time
		if( $(".roleButton").length == 1 ) {
			$(".roleButton").click();
		}
	});
</script>