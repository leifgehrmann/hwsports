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
				<td><?=form_submit(array('name'=>'submit',"label"=>"Update", "class"=>"green"));?></td>
			</tr>
		</table>
		<?=form_close();?>
	</div>
</div>
<p>A scheduling form</p>
<p>A list of matches</p>
<p>A list of actors (teams, umpires)</p>

<script type="text/javascript">
	$('.date').datetimepicker({
		dateFormat: $.datepicker.ISO_8601,
		separator: ' ',
		timeFormat: 'HH:mm',
		ampm: false
	});
</script>