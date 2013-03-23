
<h1>Welcome <?=$currentUser['firstName']?> <?=$currentUser['lastName']?></h1>
<div>
	<div class="widget half profile">
		<a href="/auth/edit_user">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">Profile</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Name:</b> <?=$currentUser['firstName']?> <?=$currentUser['lastName']?></p>
			<p><b>Email:</b> <?=$currentUser['email']?></p>
			<? if(isset($currentUser['aboutMe'])) { ?>
			<p><b>Bio:</b> <?=$currentUser['aboutMe']?></p>
			<? } ?>
			<a href="/auth/edit_user" class="button right normal">Edit Profile</a>
		</div>
	</div>
	<!--<div class="widget half tickets">
		<a href="/sis/userTickets">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">Tickets</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>2012/04/12</b> Ticket</p>
			<p><b>2012/04/13</b> Ticket</p>
			<p><b>2012/04/14</b> Ticket</p>
			<a href="/sis/userTickets" class="button margin-right normal">View All Tickets</a>
			<a href="/sis/tickets" class="button green">Buy Tickets</a>
		</div>
	</div>-->
	<div class="widget half teams">
		<div class="widget-title">
			<div class="widget-title-left icon"></div>
			<div class="widget-title-centre">Team Membership</div>
			<div class="widget-title-right icon"></div>
		</div>
		<div class="widget-body">
			<? if(count($user['teams'])==0) { ?>
			<p>You aren't a member in any of the teams.</p>
			<? } else { ?>
			<? foreach($user['teams'] as $team) { ?>
			<div class="team teamID-<?=$team['teamID']?>">
			<p>
				<a href="/sis/team/<?=$team['teamID']?>"><?=$team['name']?></a>
			</p>
			</div>
			<? } ?>
			<? } ?>
		</div>
	</div>
	<div class="widget half participation">
		<a href="/sis/tournaments">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">Tournament Participation</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<? if(count($user['tournaments'])==0) { ?>
			<p>You are not signed up in any of the tournaments.</p>
			<? } else { ?>
			<? foreach($user['tournaments'] as $tournament) { ?>
			<div class="tournament tournamentID-<?=$tournament['tournamentID']?> sportID-<?=$tournament['sportID']?> sportCategoryID-<?=$tournament['sportData']['sportCategoryID']?>">
			<p>
				<div class="icon"></div>
				<a href="/sis/tournament/<?=$tournament['tournamentID']?>"><?=$tournament['name']?></a>
			</p>
			</div>
			<? } ?>
			<? } ?>
			<a href="/sis/tournaments" class="button right normal">Sign up for Tournaments</a>
		</div>
	</div>
	<? if($this->ion_auth->is_admin()){ ?>
	<div class="widget half tms">
		<a href="/tms/">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">Tournament Management System</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<a href="/tms" class="button right normal">Enter the tournament Management System portal</a>
		</div>
	</div>
	<? } ?>
</div>