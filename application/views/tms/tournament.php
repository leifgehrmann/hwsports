<h1><a href="/tms/tournaments/">Tournaments</a><div class="icon subsection"></div><span id="title-name"><?=$tournament["name"]?></span></h1>

<div class="widget full tournament">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Tournament Details</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<?=form_open("tms/tournament/$tournamentID", array('id' => 'tournamentDetailsForm'), array('form'=>'tournamentDetailsForm'))?>
		<table>
			<tr>
				<td><label for="name">Name</label></td>
				<td><?=form_input($name)?></td>
				<td><label for="sport">Sport</label></td>
				<td><a href="/tms/sports/"><?=$tournament['sportData']['name']?></a></td>
			</tr>
			<tr>
				<td><label for="description">Description</label></td>
				<td colspan="3"><?=form_textarea($description)?></td>
			</tr>
			<tr>
				<? switch($tournament['status']) { 
					case "preRegistration": $tournamentStatusMessage="This tournament has not yet opened for registration. You may change any of the details below."; break;
					case "inRegistration": $tournamentStatusMessage="This tournament is open for registration. You may change any of the tournament details or manage the list of competitors to date."; break;
					case "postRegistration": $tournamentStatusMessage="This tournament has closed for registration. You may change any of the tournament details below. Before matches can be sceduled, you must moderate the list of competitors below."; break;
					case "inTournament": $tournamentStatusMessage="This tournament has completed registration and scheduling and is awaiting the start date. You may change any of the tournament details or manage the list of competitors below."; break;
					case "postTournament": $tournamentStatusMessage="This tournament is in progress. You may change any of the tournament details or manage the list of competitors below, and <a href='/tms/tournament-statistics/'>view statistics here.</a>"; break;
				}
				?>
				<td colspan="4"><p><?=$tournamentStatusMessage?></p></td>
			</tr>
			<tr>
				<td colspan="2"><h3>Tournament Period</h3></td>
				<td colspan="2"><h3>Competitor Registration Period</h3></td>
			</tr>
			<tr>
				<td><label for="tournamentStart">Start Date</label></td>
				<td><?=!in_array($tournament['status'],array("inTournament","postTournament")) ? form_input($tournamentStart) : datetime_to_public($tournament['tournamentStart']) ?></td>
				<td><label for="registrationStart">Start Date</label></td>
				<td><?=in_array($tournament['status'],array("preRegistration")) ? form_input($registrationStart) : datetime_to_public($tournament['registrationStart']) ?></td>
			</tr>
			<tr>
				<td><label for="tournamentEnd">End Date</label></td>
				<td><?=!in_array($tournament['status'],array("postTournament")) ? form_input($tournamentEnd) : datetime_to_public($tournament['tournamentEnd']) ?></td>
				<td><label for="registrationEnd">End Date</label></td>
				<td><?=!in_array($tournament['status'],array("inTournament","postTournament","postRegistration")) ? form_input($registrationEnd) : datetime_to_public($tournament['registrationEnd']) ?></td>
			</tr>
			
			<tr>
				<td colspan="3"></td>
				<td><?=form_submit(array('name'=>"submit", 'value'=>"Update", 'class'=>"green"));?></td>
			</tr>
		</table>
		<?=form_close();?>
	</div>
</div>
<div class="widget full scheduling">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Scheduling Details</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if( $tournament['scheduled'] == "false" ) { ?>
		<?=form_open("tms/tournament/$tournamentID", array('id' => 'schedulingDetailsForm'), array('form'=>'schedulingDetailsForm', 'action'=>'update'))?>
		<table>
			<tr>
				<td width="40%"><h3>Match Duration</h3><p>Enter in the number of minutes that each match will take.</p></td>
				<td width="60%"><?= form_input($matchDuration) ?></td>
			</tr>
			<tr>
				<td><h3>Venues</h3><p><p>Select the venues that you want the matches to take place at.</p></p></td>
				<td>
					<? if( count($venueOptions) != 0 ) { ?>
					<?=form_multiselect('venues',$venueOptions,$venueSelections,"class='chzn-select' data-placeholder='Select Venues...' style='width:300px;'")?>
					<? } else { ?>
					<p>There are no venues to add. To add venues, <a href="/tms/venues/">click here</a>.</p>
					<? } ?>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td colspan="4"><h3>Match Start Times</h3><p>The start times are used to tell the scheduler when the matches should take place.
					For example you may want to have the start time on Monday to be at 10:00 and 14:00 but on Friday have them only occur at 12:00.</p>
				<p>Fields that are left blank ignored.</p></td>
			</tr>
			<?
				$i=0;
				$weekdays = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
				foreach($weekdays as $weekday)
			{ ?>
			<? if($i%2==0){ ?><tr><? } ?>
				<td valign="top"><?=ucfirst($weekday)?></td>
				<td>
					<div id="<?=$weekday?>StartTimes">
						<? 
						$x=0;
						foreach($startTimes[$weekday] as $time) { ?>
							<? if($x==0) { ?>
							<p><input type="text" style="width:70px" name="<?=$weekday?>StartTimes[]" value="<?=$time?>" placeholder="HH:MM" /></p></div>
							<? } else {?>
							<p><input type="text" name="<?=$weekday?>StartTimes[]" value="<?=$time?>" style="width:70px" placeholder="HH:MM" /><a class="button red removeInputButton" href="#" style="margin-left:20px;top:0px;">Remove</a></p>
							<? } ?>
						<? $x++;} ?>
					<a class="button green" href="#" id="<?=$weekday?>StartTimesAdd">Add another start time</a>
				</td>
			<? if($i%2==1){ ?></tr><? } ?>
			<? $i++; } ?>
		</table>
		<?=form_submit(array('name'=>"submit", 'value'=>"Update preferences", 'class'=>"green margin-left right", 'onclick'=>"$('#schedulingDetailsForm input[name=\'action\']').val('update');"));?>
		<?=form_submit(array('name'=>"submit", 'value'=>"Schedule matches", 'class'=>"blue right", 'onclick'=>"$('#schedulingDetailsForm input[name=\'action\']').val('schedule');"));?>
		<?=form_close();?>
		<? } else { ?>
			<? if( $tournament['sportData']['sportCategoryID'] == "46" ) { ?>
				<table><tr>
					<td><p>The matches have been scheduled and are displayed below. Once you have completed a match i.e. filled in the results you can press the button to schedule the next match</p></td>
					<td><?=form_submit(array('name'=>"submit", 'value'=>"Schedule next match", 'class'=>"green", 'onclick'=>"$('#schedulingDetailsForm input[name=\'action\']').val('schedule');"));?></td>
				</tr></table>
				<h3>Rescheduling</h3>
				<p>To reschedule individual matches you can use the table below.</p>
				<p>To reschedule the entire tournament you must clear all matches in the table below.</p>
			<? } else { ?>
				<p>The matches have been scheduled and are displayed below.</p>
				<h3>Rescheduling</h3>
				<p>To reschedule individual matches you can use the table below.</p>
				<p>To reschedule the entire tournament you must clear all matches in the table below.</p>
			<? } ?>
		<? } ?>
	</div>
</div>
<h2>Matches</h2>
<div class="tournamentMatches">
	<p>Displayed below are a list of matches for the tournament. You can edit a match description</p>
	<pre>IF IT IS A TEAM SPORT, TEAMS A and TEAM B SHOULD BE EDITABLE.</pre>
	<pre>IF IT IS A NOT A TEAM SPORT, MATCHES THAT HAVEN'T ALREADY OCCURED CAN BE MOVED TO ANOTHER DATE AND TIME. NO RESITRCTIONS SHOULD BE MADE.</pre>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tournamentMatches" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Tournament</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Description</th>
				<th>Sport</th>
				<th>Venue</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<script src="/js/vendor/datatables/tournamentMatches.js"></script>
</div>
<div class="tournamentTeams">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tournamentTeams" width="100%">
		<thead>
			<tr>
				<th width="30%">Team ID</th>
				<th width="30%">Name</th>
				<th width="30%">Description</th>
				<th width="30%">Association Number</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<script src="/js/vendor/datatables/tournamentTeams.js"></script>
</div>
<h2>Umpires</h2>
<div class="tournamentUmpires">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="tournamentUmpires" width="100%">
		<thead>
			<tr>
				<th>User ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>About</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<script src="/js/vendor/datatables/tournamentUmpires.js"></script>
</div>
<br />
<br />
<div id="tournamentID" style="display:none;"><?=$tournamentID?></div>

<script type="text/javascript">
	$('.date').datetimepicker({
		dateFormat: $.datepicker.ISO_8601,
		separator: ' ',
		timeFormat: 'HH:mm',
		ampm: false
	});
	 $(".chzn-select").chosen();
	 $(".chzn-select-deselect").chosen({allow_single_deselect:true});

	var weekdays =["monday","tuesday","wednesday","thursday","friday","saturday","sunday"];
	for (var x=0;x<weekdays.length;x++){
		$('#'+weekdays[x]+'StartTimesAdd').live('click', function() {
			var z = -1;
			for(var y=0;y<weekdays.length;y++){
				if( $(this).attr("id") == weekdays[y]+'StartTimesAdd' ){
					z = y;
					break;
				}
			}
			console.log(z);
			startTimes = $('#'+weekdays[z]+'StartTimes');
			startTimes.append('<p><input type="text" name="'+weekdays[z]+'StartTimes[]" value="" style="width:70px" placeholder="HH:MM" /><a class="button red removeInputButton" href="#" style="margin-left:20px;top:0px;">Remove</a></p>');

			return false;
		});
	}
	$('.removeInputButton').live('click', function() { 
		var count = $(this).parent().siblings('p').length;
		if( count > 0 ) {
			$(this).parents('p').remove();
		}
		return false;
	});

</script>