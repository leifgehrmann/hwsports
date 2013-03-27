
	<h2>Sign Up for <?=$tournament['name']?>:</h2>
	
	<form action="/sis/signup/<?=$tournament['tournamentID']?>" id="signupForm" method="POST">
	
	<h3 id="actionHeading">Select role:</h3>
	<? $counter = 1;
		foreach($roles as $roleID => $role) {
			$counter++; ?>
		<a href="" class="roleButton button <?=($counter%2 ? 'green' : 'blue')?>" id="roleButton-<?=$roleID?>"><?=ucfirst($role['sportCategoryRoleName'])?></a>
		
		<div class="roleSections" id="roleSections-<?=$roleID?>" style="display: none">
			<? 	$sectionCount = 0;
				foreach($role['inputSections'] as $sectionID => $section) { 
					$sectionCount++; ?>
					<h3 class="sectionHeading" id="sectionHeading-<?=$sectionID?>"><?=$section['label']?></h3>
					<div class="sectionBody" id="sectionBody-<?=$sectionID?>">
						<table>
						<? foreach($section['inputs'] as $inputID => $input) {
								if(strpos($input['inputType'],'tm-') !== false) continue; 
								if($input['inputType'] == "teamMembers") { ?>
									<thead class="columns">
										<tr>
											<td>User ID</td>
											<td>Name</td>
											<td>Email</td>
											<td>Password</td>
											<td></td>
										</tr>
									</thead>
									<tbody class="teamMembers"></tbody>
									<tfoot class="functions">
										<tr>
											<td colspan="5">
												<a href="/sis/addTeamMember/<?=$tournament['tournamentID']?>/<?=$sectionID?>" class="button green addTeamMember fancybox.ajax">Add Player<br />(Create New Account)</a>
												<a href="/sis/addLoginTeamMember/<?=$tournament['tournamentID']?>/<?=$sectionID?>" class="button blue addTeamMember addLoginTeamMember fancybox.ajax">Add Player<br />(Existing Account)</a>
											</td>
										</tr>
									</tfoot>
								<? } else { ?>
									<tr>
										<td><?=$input['formLabel']?></td>
										<td>
											<? switch( $input['inputType'] ) {
												case "textarea": ?> <textarea id="<?=$input['objectName']?>:<?=$input['tableKeyName']?>" name="<?=$input['objectName']?>:<?=$input['tableKeyName']?>" required><?=isset($currentUser[$input['tableKeyName']]) ? $currentUser[$input['tableKeyName']] : ""?></textarea><br /> <? break;
												case "text": case "phone": case "email": ?> <input type="text" id="<?=$input['objectName']?>:<?=$input['tableKeyName']?>" name="<?=$input['objectName']?>:<?=$input['tableKeyName']?>" value="<?=isset($currentUser[$input['tableKeyName']]) ? $currentUser[$input['tableKeyName']] : ""?>" required></input><br /> <? break;
												case "checkbox": ?> <input type="checkbox" id="<?=$input['objectName']?>:<?=$input['tableKeyName']?>" name="<?=$input['objectName']?>:<?=$input['tableKeyName']?>" value="1" required></input><br /> <? break; 
											} ?>
										</td>
									</tr>
								<? } ?>
						<? } ?> 
						</table>
						<?if( $sectionCount == 1 ) {
							echo "<div class='navButtons'><a href='#' class='button nextButton normal'>Next</a></div>";
						} else {
							echo "<div class='navButtons'><a href='#' class='button backButton normal'>Back</a> <a href='#' class='button nextButton normal'>Next</a></div>";
						} ?>
					</div>	
			<? } ?>
			<h3 class="sectionHeading" id="sectionHeading-submit">Final Step</h3>
			&nbsp;<a href="#" class="submitButton button green">Complete Sign Up Process</a>
			<input type="hidden" name="role" value="<?=$roleID?>"></input>
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
			$("a.submitButton").unbind("click").unbind("dblclick").bind("click dblclick", (function () {
				//get all team member IDs in CSV to submit
				$(".addTeamMember").after(
					"<input type='hidden' name='teamMemberIDs' id='teamMemberIDs' value='" + 
					$('.teamMemberUserID').map(function() {
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