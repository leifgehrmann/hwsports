<? $this->method_call =& get_instance();?>
<h1>Dashboard</h1>
<div class="widget half matches">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Recent Matches</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(count($pastMatches)==0) { ?>
			<p>There are no recent matches.</p>
		<? } else {
			foreach($pastMatches as $match){ 
				$date = $this->method_call->datetime_to_public_date($match['startTime']);
				$time = $this->method_call->datetime_to_public_time($match['startTime']);
			?>
			<div class="match 
				matchID-<?=$match['matchID']?> 
				sportID-<?=$match['sportID']?> 
				sportCategoryID-<?=$match['sportData']['sportCategoryID']?> 
				tournamentID-<?=$match['tournamentID']?>
			">
				<div class="icon left margin-right"></div>
				<p>
					<a href="/tms/match/<?=$match['matchID']?>"><?=$match['name']?></a><br/>
					<span style="display: inline-block;padding-left: 40px;"><?=$date?> &mdash; <?=$time?></span>
				</p>
			</div>
			<? } ?>
		<? } ?>
		<p><a href="/tms/matches/" class="button right blue">View All Matches</a></p>
	</div>
</div>
<div class="widget half matches">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Upcoming Matches</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(count($upcomingMatches)==0) { ?>
			<p>There are no upcoming matches.</p>
		<? } else {
			foreach($upcomingMatches as $match){ 
				$date = $this->method_call->datetime_to_public_date($match['startTime']);
				$time = $this->method_call->datetime_to_public_time($match['startTime']);
			?>
			<div class="match 
				matchID-<?=$match['matchID']?> 
				sportID-<?=$match['sportID']?> 
				sportCategoryID-<?=$match['sportData']['sportCategoryID']?> 
				tournamentID-<?=$match['tournamentID']?>
			">
				<div class="icon left margin-right"></div>
				<p>
					<a href="/tms/match/<?=$match['matchID']?>"><?=$match['name']?></a><br/>
					<span style="display: inline-block;padding-left: 40px;"><?=$date?> &mdash; <?=$time?></span>
				</p>
			</div>
			<? } ?>
		<? } ?>
		<p><a href="/tms/matches/" class="button right blue">View All Matches</a></p>
	</div>
</div>
<div class="widget half tournaments">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Current Tournaments</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(count($pastTournaments)==0) { ?>
			<p>There are no currently running tournaments.</p>
		<? } else {
			foreach($pastTournaments as $tournament){ 
				$start = $this->method_call->datetime_to_public_date($tournament['tournamentStart']);
				$end = $this->method_call->datetime_to_public_date($tournament['tournamentEnd']);
			?>
			<div class="tournament 
				tournamentID-<?=$tournament['tournamentID']?> 
				sportID-<?=$tournament['sportID']?> 
				sportCategoryID-<?=$tournament['sportData']['sportCategoryID']?> 
			">
				<div class="icon left margin-right"></div>
				<p>
					<a href="/tms/tournament/<?=$tournament['tournamentID']?>"><?=$tournament['name']?></a><br/>
					<span style="display: inline-block;padding-left: 40px;">Starts: <?=$start?></span><br/>
					<span style="display: inline-block;padding-left: 40px;">Ends: <?=$end?></span>
				</p>
			</div>
			<? } ?>
		<? } ?>
		<p><a href="/tms/tournaments/" class="button right blue">View All Tournaments</a></p>
	</div>
</div>
<div class="widget half tournaments">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Upcoming Tournaments</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(count($upcomingTournaments)==0) { ?>
			<p>There are no upcoming tournaments.</p>
		<? } else {
			foreach($upcomingTournaments as $tournament){ 
				$start = $this->method_call->datetime_to_public_date($tournament['tournamentStart']);
				$end = $this->method_call->datetime_to_public_date($tournament['tournamentEnd']);
			?>
			<div class="tournament 
				tournamentID-<?=$tournament['tournamentID']?> 
				sportID-<?=$tournament['sportID']?> 
				sportCategoryID-<?=$tournament['sportData']['sportCategoryID']?> 
			">
				<div class="icon left margin-right"></div>
				<p>
					<a href="/tms/tournament/<?=$tournament['tournamentID']?>"><?=$tournament['name']?></a><br/>
					<span style="display: inline-block;padding-left: 40px;">Starts: <?=$start?></span><br/>
					<span style="display: inline-block;padding-left: 40px;">Ends: <?=$end?></span>
				</p>
			</div>
			<? } ?>
		<? } ?>
		<p><a href="/tms/tournaments/" class="button right blue">View All Tournaments</a></p>
	</div>
</div>