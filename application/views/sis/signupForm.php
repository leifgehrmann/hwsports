<h2>
	<a href="/sis/tournament/<?=$tournamentID?>"><?=$tournament['name']?></a>
	<div class="icon subsection margin-left margin-right"></div>
	<a href="/sis/signupSelection/<?=$tournamentID?>">Sign Up</a>
	<div class="icon subsection margin-left margin-right"></div>
	<?=$role['name']?>
</h2>

<form action="/sis/signupForm/<?=$tournamentID?>/<?=$roleID?>" id="signupForm" method="POST">
	<div class="roleSections" id="roleSections-<?=$roleID?>">
		<? 	$sectionCount = 0;
			foreach($role['inputSections'] as $sectionID => $section) { 
			$sectionCount++; ?>
		<h3 class="sectionHeading" id="sectionHeading-<?=$sectionID?>"><?=$section['label']?></h3>
		<div class="sectionBody" id="sectionBody-<?=$sectionID?>">
			<table>
				<? 	foreach($section['inputs'] as $inputID => $input) { 
					if(strpos($input['inputType'],'tm-') !== false) continue; ?>
				<tr>
					<td><?=$input['formLabel']?></td>
					<td>
						<? switch( $input['inputType'] ) {
							case "textarea": ?> <textarea id="<?=$input['keyName']?>" name="<?=$input['keyName']?>"></textarea><br /> <? break;
							case "text": case "phone": case "email": ?> <input type="text" id="<?=$input['keyName']?>" name="<?=$input['keyName']?>"></input><br /> <? break;
							case "checkbox": ?> <input type="checkbox" id="<?=$input['keyName']?>" name="<?=$input['keyName']?>" value="1"></input><br /> <? break; 
							case "teamMembers": ?> <a href="/sis/addTeamMember/<?=$tournamentID?>/<?=$sectionID?>" class="button green addTeamMember fancybox.ajax">Add Player<br />(Create New Account)</a> <a href="/sis/addLoginTeamMember/<?=$tournamentID?>/<?=$sectionID?>" class="button blue addTeamMember fancybox.ajax">Add Player<br />(Existing Account)</a><? break;
						} ?>
					</td>
				</tr>
				<? } ?> 
			</table>
			<?if( $sectionCount == 1 ) { ?>
			<div class='navButtons'><a href='#' class='button nextButton normal'>Next</a></div>;
			<? } else { ?>
			<div class='navButtons'><a href='#' class='button backButton normal'>Back</a> <a href='#' class='button nextButton normal'>Next</a></div>;
			<? } ?>
		</div>	
		<? } ?>
		<h3 class="sectionHeading" id="sectionHeading-submit">Complete Sign Up Process</h3>
		<input type="hidden" name="role" value="<?=$roleID?>"></input>
	</div>
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
				//get all team member IDs in CSV to submit
				$(".addTeamMember").after(
					"<input type='hidden' name='teamMemberIDs' id='teamMemberIDs' value='" + 
					$('.teamMemberID').map(function() {
						return $(this).text();
					}).get().join(",") + 
					"' />" 
					);

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
						//shiny
						$.fancybox.showLoading();

						var data = $(this).serialize();
						var url = $(this).attr('action')
						
						//post to the server and when we get a response, 
						//draw a new fancybox, and run this function on completion
						//so that we can bind the form and create a new fancybox on submit
						$.post(url, data, function(msg){
							$.fancybox({content:msg,beforeShow:func});
						});
						
						return false; 
					});
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