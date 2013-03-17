<h1><a href="/tms/tournaments/">Tournaments</a><div class="icon subsection"></div><span id="title-name"><?=$tournament["name"]?></span></h1>

<div class="widget full tournament">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Tournament Details</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<?=form_open("tms/tournament/$tournamentID", array('id' => 'tournamentDetailsForm'))?>
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
</script>