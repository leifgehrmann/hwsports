<h1><a href="/tms/tournaments/">Tournaments</a><div class="icon subsection"></div><span id="title-name"><?=$tournament["name"]?></span></h1>

<div class="widget full tournament">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Tournament Details</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<?=form_open("tms/tournament/$tournamentID", array('id' => 'tournamentDetailsForm'), array('formID' => 'tournamentDetailsForm'))?>
		<
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
		<?=form_open("tms/tournament/$tournamentID", array('id' => 'schedulingDetailsForm'), array('formID' => 'schedulingDetailsForm'))?>
		<table>
			<tr>
				<td width="40%"><h3>Match Duration</h3><p>Enter in the number of minutes that each match will take.</p></td>
				<td width="60%"><input type="text" value="40"/>Minutes</td>
			</tr>
			<tr>
				<td><h3>Venues</h3><p><p>Select the venues that you want the matches to take place at.</p></p></td>
				<td>
					<select data-placeholder="Select Venues..." class="chzn-select" multiple>
						<option value=""></option> 
						<option value="United States">United States</option> 
						<option value="United Kingdom">United Kingdom</option> 
						<option value="Afghanistan">Afghanistan</option> 
						<option value="Aland Islands">Aland Islands</option> 
						<option value="Albania">Albania</option> 
						<option value="Algeria">Algeria</option> 
						<option value="American Samoa">American Samoa</option> 
						<option value="Andorra">Andorra</option> 
						<option value="Angola">Angola</option> 
						<option value="Anguilla">Anguilla</option> 
						<option value="Antarctica">Antarctica</option> 
						<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
						<option value="Argentina">Argentina</option> 
						<option value="Armenia">Armenia</option> 
						<option value="Aruba">Aruba</option> 
						<option value="Australia">Australia</option> 
						<option value="Austria">Austria</option> 
						<option value="Azerbaijan">Azerbaijan</option> 
						<option value="Bahamas">Bahamas</option> 
						<option value="Bahrain">Bahrain</option> 
						<option value="Bangladesh">Bangladesh</option> 
						<option value="Barbados">Barbados</option> 
						<option value="Belarus">Belarus</option> 
						<option value="Belgium">Belgium</option> 
						<option value="Belize">Belize</option> 
						<option value="Benin">Benin</option> 
						<option value="Bermuda">Bermuda</option> 
						<option value="Bhutan">Bhutan</option> 
						<option value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option> 
						<option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option> 
						<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
						<option value="Botswana">Botswana</option> 
						<option value="Bouvet Island">Bouvet Island</option> 
						<option value="Brazil">Brazil</option> 
						<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
						<option value="Brunei Darussalam">Brunei Darussalam</option> 
						<option value="Bulgaria">Bulgaria</option> 
						<option value="Burkina Faso">Burkina Faso</option> 
						<option value="Burundi">Burundi</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2"><h3>Match Start Times</h3></td>
			</tr>
			<tr>
				<td>Monday</td>
				<td>
					<div id="mondayStartTimes">
						<p><input type="text" id="monday_start" name="mondayStartTimes" value="" placeholder="HH:MM" /></p>
					</div>				
					<a class="button green" href="#" id="mondayStartTimesAdd">+</a>
				</td>
			</tr>
			<tr>
				<td>Tuesday</td>
				<td></td>
			</tr>
			<tr>
				<td>Wednesday</td>
				<td></td>
			</tr>
			<tr>
				<td>Thursday</td>
				<td></td>
			</tr>
			<tr>
				<td>Friday</td>
				<td></td>
			</tr>
			<tr>
				<td>Saturday</td>
				<td></td>
			</tr>
			<tr>
				<td>Sunday</td>
				<td></td>
			</tr>
		</table>
		<?=form_close();?>
		<p>If it is wattball, we need to have a form which has the following details:</p>
		<ul>
			<li>Match Duration (Minutes)</li>
			<li>Start Times For each weekday</li>
			<li>Venues</li>
			<li>Button to save preferences</li>
			<li>Button to clear all scheduled matches (if there are any matches)</li>
			<li>Button to schedule matches</li>
			<li>Button</li>
		</ul>
		<p>If it is running, we need to have a form which has the following details</p>
		<ul>
			<li>Match Duration (Minutes)</li>
			<li>Start Times</li>
			<li>Venues with lane number (if it is defined)</li>
			<li>Button to save preferences</li>
			<li>Button to clear all scheduled matches (if there are any matches)</li>
			<li>Button to schedule matches</li>
			<li>Button to prepare next match (If there are any incomplete matches)</li>
		</ul>
	</div>
</div>
<div class="clearfix"></div>
<div class="tournamentMatches">
	<h2>Matches</h2>
	<p>Displayed below are a list of matches for the tournament. You can edit a match description</p>
	<pre>IF IT IS A TEAM SPORT, TEAMS A and TEAM B SHOULD BE EDITABLE.</pre>
	<pre>IF IT IS A NOT A TEAM SPORT, MATCHES THAT HAVEN'T ALREADY OCCURED CAN BE MOVED TO ANOTHER DATE AND TIME. NO RESITRCTIONS SHOULD BE MADE.</pre>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="matches" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Description</th>
				<th>Venue</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
</div>
<div class="tournamentTeams">
	<h2>Teams</h2>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="matches" width="100%">
		<thead>
			<tr>
				<th>Team</th>
				<th>Association Number</th>
				<th>Description</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<p>Or athletes or whatever, point is that we have a series of roles to display here each with the meta data? </p>
</div>
<div class="tournamentUmpires">
	<h2>Umpires</h2>
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="matches" width="100%">
		<thead>
			<tr>
				<th>Team</th>
				<th>Association Number</th>
				<th>Description</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
</div>

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
			var startTimes = $('#mondayStartTimes');
			//eval(weekdays[x]+'StartTimesCount' + i + ' = ' + i $('#mondayStartTimes p').size() + 1);
			//var i =;
			$('<p><input type="text" name="'+weekdays[x]+'StartTimes[]" value="" placeholder="HH:MM" /><a class="button red removeInputButton" href="#">-</a></p>').appendTo(startTimes);
			//i++;
			return false;
		});
	}
	$('.removeInputButton').live('click', function() { 
		var count = $(this).parent().parent('p').length;
		alert(count);
		if( count > 2 ) {
			$(this).parents('p').remove();
		}
		return false;
	});

</script>