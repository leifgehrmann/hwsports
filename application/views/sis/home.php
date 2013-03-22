
<div class="widget full welcome-message">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Welcome to Riccarton Tournaments</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<img style="float:right;width:40%;padding-left:20px;" src="http://www.hw.ac.uk/img/football-800x450.jpg" />
		<p>On this website you can get the latest information about tournament events occuring on campus. This includes the calendar, scores of the matches, and winners of tournaments. You can also register here to purchase tickets and sign up for sports events.</p>
		<a href="sis/help" class="button blue">More Information</a>
	</div>
</div>
<div class="widget half matches">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Latest Matches</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(count($latestMatches)==0) { ?>
			<p>There are no recent or current matches.</p>
		<? } else {
			foreach($latestMatches as $match){ 
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
			<p>There are no upcoming matches.</p>
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
		<? if(count($latestTournaments)==0) { ?>
			<p>There are no recent or currently running tournaments.</p>
		<? } else {
			foreach($latestTournaments as $tournament){ 
				$start = datetime_to_public_date($tournament['tournamentStart']);
				$end = datetime_to_public_date($tournament['tournamentEnd']);
			?>
			<div class="tournament 
				tournamentID-<?=$match['tournamentID']?> 
				sportID-<?=$match['sportID']?> 
				sportCategoryID-<?=$match['sportData']['sportCategoryID']?> 
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
				$start = datetime_to_public_date($tournament['tournamentStart']);
				$end = datetime_to_public_date($tournament['tournamentEnd']);
			?>
			<div class="tournament 
				tournamentID-<?=$match['tournamentID']?> 
				sportID-<?=$match['sportID']?> 
				sportCategoryID-<?=$match['sportData']['sportCategoryID']?> 
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
<!--<div class="widget half icons">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
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
</div>-->



















<!--<table class="full">
	<tr>
		<td colspan="2"><h2><div class="icon subscribe margin-right"></div>Subscribe to our announcements!</h2></td>
	</tr>
	<tr>
		<td style="width:40%">
			<p>Enter in your email below to get any updates we post on the site.</p>
		</td>
		<td style="width:60%">
			<form method="POST" action="/subscribe/">
				<input style="margin-right:20px" placeholder="Your email..." name="email">
				<input type="submit" value="Subscribe" class="green" name="Subscribe">
			</form>
		</td>
	</tr>
</table>-->
<!--<h1>Announcements (<a href="#announcement-list">Full List</a>)</h1>
<div class="widget full announcement">
	<a href="#newsarticle">
		<div class="widget-title">
			<div class="widget-title-left icon"></div>
			<div class="widget-title-centre">Register now!</div>
			<div class="widget-title-right icon"></div>
		</div>
	</a>
	<div class="widget-body">
		<p><b>Published:</b> 14/02/2013 ~ 13:20</p>
		<img src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Hurdling_Kraenzlein.png" width="100%"/>
		<p>Want to participate in the Heriot Watt Tournament, well now you can register on this website! We are offering the following sports this year.</p>
		<ul>
			<li>Heriot Hurdling (Men &amp; Womens)</li>
			<li>Wattball</li>
		</ul>
		<p>If you have already made an account, be sure to check into your account and sign up for the games you want to participate in.</p>
		<p>If you want to create a team in the Wattball tournament, you only need one member to bla bla bla.</p>
		<a href="#newsarticle" class="button right normal">View Announcement</a>
	</div>
</div>
<div>
	<div class="widget half announcement">
		<a href="#newsarticle">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">2013 Tournaments announced!</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Published:</b> 10/02/2013 ~ 16:20</p>
			<p>Within a couple of days, we will allow you all to register online for the sports
				tournaments. Before you can participate directly, it would be best to register
				now.
			</p>
			<a href="#newsarticle" class="button right normal">View Announcement</a>
		</div>
	</div>
	<div class="widget half announcement">
		<a href="#newsarticle">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">Congratulations to the winners!</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Published:</b> 12/08/2012 ~ 18:42</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
				incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
				nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
				Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
				fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
				culpa qui officia deserunt mollit anim id est laborum.
			</p>
			<a href="#newsarticle" class="button right normal">View Announcement</a>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('table.announcements').dataTable();
});
</script>
<a id="announcement-list"></a><h2>Complete List of Announcements</h2>
<table class="full announcements">
	<thead>
		<tr>
			<th>Date</th>
			<th>Announcement Title</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>2012/02/12</td>
			<td>Information about upcoming tournaments</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
		<tr>
			<td>2012/01/16</td>
			<td>Sign up for basketball</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
		<tr>
			<td>2011/12/23</td>
			<td>Bring it all back to you</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
		<tr>
			<td>2011/12/31</td>
			<td>Magical Transistor Radio</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
		<tr>
			<td>2010/11/24</td>
			<td>Duck Ellington</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
		<tr>
			<td>2010/13/42</td>
			<td>Friendships, Relationships, and all those other ships.</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
		<tr>
			<td>2009/01/02</td>
			<td>Mr Bojangles</td>
			<td><a href="#newsarticle">View Announcement</a></td>
		</tr>
	</tbody>
</table>-->