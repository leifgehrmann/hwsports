<h1>Dashboard</h1>
<div class="widget half matches">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Latest Matches</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(count($latestMatches)==0) { ?>
			<p>There are no latest matches</p>
		<? } else {
			foreach($latestMatches as $match){ 
				var_dump($match);
				die();
				$date = datetime_to_public_date($match['startTime']);
				$time = datetime_to_public_time($match['startTime']);
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
			<p>There are no upcoming matches</p>
		<? } else {
			foreach($upcomingMatches as $match){ 
				$date = datetime_to_public_date($match['startTime']);
				$time = datetime_to_public_time($match['startTime']);
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
		<div class="widget-title-centre">Latest Tournaments</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<div class="match sportCategoryID-9"><div class="icon left margin-right"></div><p><a href="/tms/tournament/dshjf"		>2012 Heriot Watt</a><br/><span style="display: inline-block;padding-left: 40px;">5th-12th February</span></p></div>
		<div class="match sportCategoryID-10"><div class="icon left margin-right"></div><p><a href="/tms/tournament/afjb"		>2012 Rugby</a><br/><span style="display: inline-block;padding-left: 40px;">5th-12th February</span></p></div>
		<div class="match sportCategoryID-11"><div class="icon left margin-right"></div><p><a href="/tms/tournament/sdlkfjsd"	>2012 Summer WattBall</a><br/><span style="display: inline-block;padding-left: 40px;">5th-12th February</span></p></div>
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
		<div class="match sportCategoryID-13"><div class="icon left margin-right"></div><p><a href="/tms/tournament/flksdf">2013 Heriot Watt</a><br/><span style="display: inline-block;padding-left: 40px;">5th-12th February</span></p></div>
		<div class="match sportCategoryID-14"><div class="icon left margin-right"></div><p><a href="/tms/tournament/dsflkjsd">2014 Summer WattBall</a><br/><span style="display: inline-block;padding-left: 40px;">5th-12th February</span></p></div>
		<p><a href="/tms/tournaments/" class="button right blue">View All Tournaments</a></p>
	</div>
</div>
<div class="widget half icons">
	<div class="widget-title">
		<div class="widget-title-centre">Happy small icons</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? for($i=1;$i<=46;$i++) { ?>
			<div class="match 
				sportCategoryID-<?=$i?> 
				tournamentID-<?=$match['tournamentID']?>
			">
				<div style="margin-bottom:20px" class="icon left margin-right"></div>
			</div>
		<? } ?>
	</div>
</div>