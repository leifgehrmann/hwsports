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
				<td colspan="2"><h3>Tournament Period</h3></td>
				<td colspan="2"><h3>Competitor Registration Period</h3></td>
			</tr>
			<tr>
				<td><label for="tournamentStart">Start Date</label></td>
				<td><?=form_input($tournamentStart)?></td>
				<td><label for="registrationStart">Start Date</label></td>
				<td><?=form_input($registrationStart)?></td>
			</tr>
			<tr>
				<td><label for="tournamentEnd">End Date</label></td>
				<td><?=form_input($tournamentEnd)?></td>
				<td><label for="registrationEnd">End Date</label></td>
				<td><?=form_input($registrationEnd)?></td>
			</tr>
			
			<tr>
				<td colspan="3"></td>
				<td><?=form_submit(array('name'=>"submit", 'value'=>"Update", 'class'=>"right green"));?></td>
			</tr>
		</table>
		<?=form_close();?>
	</div>
</div>
<? if( $tournament['status'] == 'postRegistration' ) { ?>
<div class="widget full scheduling">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Schedule Matches</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if( $tournament['scheduled'] == FALSE || count($matches) == 0 ) { ?>
		<?=form_open("tms/tournament/$tournamentID", array('id' => 'scheduleMatchesForm'), array('form'=>'scheduleMatchesForm', 'action'=>'update'))?>
		<table>
			<tr>
				<td width="40%"><h3>Match Duration</h3><p>Enter in the number of minutes that each match will take.</p></td>
				<td width="60%"><?= form_input($matchDuration) ?></td>
			</tr>
			<tr>
				<td><h3>Venues</h3><p><p>Select the venues that you want the matches to take place at.</p></p></td>
				<td>
					<? if( count($venueOptions) != 0 ) { ?>
					<?=form_multiselect('venues[]',$venueOptions,$venueSelections,"class='chzn-select' data-placeholder='Select Venues...' style='width:300px;'")?>
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
				<td valign="top">
					<div id="startTimes<?=ucfirst($weekday)?>">
						<? if(count($startTimes[$weekday])==0){ ?>
						<p><input type="text" class="time" style="width:70px" name="startTimes<?=ucfirst($weekday)?>[]" value="" placeholder="HH:MM" /></p></div>
						<? } ?>
						<? 
						$x=0;
						foreach($startTimes[$weekday] as $time) { ?>
							<? if($x==0) { ?>
							<p><input type="text" class="time" style="width:70px" name="startTimes<?=ucfirst($weekday)?>[]" value="<?=$time?>" placeholder="HH:MM" /></p></div>
							<? } else {?>
							<p><input type="text" class="time" name="startTimes<?=ucfirst($weekday)?>[]" value="<?=$time?>" style="width:70px" placeholder="HH:MM" /><a class="button red removeInputButton" href="#" style="margin-left:20px;top:0px;">Remove</a></p>
							<? } ?>
						<? $x++;} ?>
					<a class="button green" href="#" id="startTimes<?=ucfirst($weekday)?>Add">Add another start time</a>
				</td>
			<? if($i%2==1){ ?></tr><? } ?>
			<? $i++; } ?>
		</table>
		<?=form_submit(array('name'=>"submit", 'value'=>"Schedule matches", 'class'=>"blue right", 'onclick'=>"$('#schedulingDetailsForm input[name=\'action\']').val('schedule');"));?>
		<?=form_close();?>
		<? } else { ?>
			<? if( $tournament['sportData']['sportCategoryID'] == "46" ) { ?>
				<!--<table><tr>
					<td><p>The matches have been scheduled and are displayed below. Once you have completed a match (i.e. filled in the results) you can press the button to schedule the next match</p></td>
					<td><?=form_submit(array('name'=>"submit", 'value'=>"Schedule next match", 'class'=>"green", 'onclick'=>"$('#schedulingDetailsForm input[name=\'action\']').val('schedule');"));?></td>
				</tr></table>-->
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
<? } ?>
<h2>Matches</h2>
<p>Displayed below are a list of matches for the tournament.</p>
<div class="tournamentMatches">
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
<? foreach($roles as $roleID=>$roleName) { ?>
	<? if($roleName=="team") { ?>
		<h2>Teams</h2>
		<p>Displayed below are a list of teams for the tournament. </p>
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
	<? } else if($roleName=="umpire") { ?>
		<h2>Umpires</h2>
		<p>Displayed below are a list of umpires for the tournament. </p>
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
	<? } else if($roleName=="athlete") { ?>
		<h2>Athletes</h2>
		<p>Displayed below are a list of athletes for the tournament. </p>
		<div class="tournamentAthletes">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="tournamentAthletes" width="100%">
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
			<script src="/js/vendor/datatables/tournamentAthletes.js"></script>
		</div>
	<? } else { ?>
		<?=$roleName?>rolnema dfksjdfosdhf <?=$roleID?>
	<? } ?>
<? } ?>

<div id="tournamentID" style="display:none;"><?=$tournamentID?></div>

<script type="text/javascript">
	$(document).ready(function() {
	$('input.date').datetimepicker({
		dateFormat: $.datepicker.ISO_8601,
		separator: ' ',
		timeFormat: 'HH:mm',
		ampm: false
	});
	$('input.time').timepicker({
		timeFormat: 'HH:mm',
		ampm: false
	});
	$(".chzn-select").chosen();
	$(".chzn-select-deselect").chosen({allow_single_deselect:true});
	function ucfirst(string)
	{
    	return string.charAt(0).toUpperCase() + string.slice(1);
	}

	var weekdays =["monday","tuesday","wednesday","thursday","friday","saturday","sunday"];
	for (var x=0;x<weekdays.length;x++){
		$('#startTimes'+ucfirst(weekdays[x])+'Add').live('click', function() {
			var z = -1;
			for(var y=0;y<weekdays.length;y++){
				if( $(this).attr("id") == 'startTimes'+ucfirst(weekdays[y])+'Add' ){
					z = y;
					break;
				}
			}
			console.log(z);
			startTimes = $('#startTimes'+ucfirst(weekdays[z]));
			startTimes.append('<p><input type="text" class="time" name="startTimes'+ucfirst(weekdays[z])+'[]" value="" style="width:70px" placeholder="HH:MM" /><a class="button red removeInputButton" href="#" style="margin-left:20px;top:0px;">Remove</a></p>');
			$('input.time').timepicker({
				timeFormat: 'HH:mm',
				ampm: false
			});

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
	});

</script>