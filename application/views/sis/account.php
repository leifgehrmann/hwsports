<? if($this->ion_auth->logged_in()){ ?>
	<h1>Welcome <?=$currentUser->firstName?> <?=$currentUser->lastName?></h1>

	<a class="button tickets" href="/sis/tickets"><div class="icon"></div><div class="label">Buy Tickets</div><div class="subtitle">Purchase and view your tickets for tournaments</div></a>
	<a class="button signup" href="/sis/signup"><div class="icon"></div><div class="label">Sign up</div><div class="subtitle">Sign up for sports tournaments</div></a>
	<a class="button details" href="/sis/details"><div class="icon"></div><div class="label">Edit My Details</div><div class="subtitle">Change your personal details</div></a>
	<? if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin')){ ?>
		<a class="button tms" href="/tms/"><div class="icon"></div><div class="label">Tournament Management System</div><div class="subtitle">Enter the tournament Management System portal</div></a>
	<? } ?>

	<p> </p>
	<p> </p>
	<hr>

	<div id="infoMessage"><?php echo $message;?></div>

	Current User ID: <?=$currentUser->id?> (<a href="auth/delete_user">Delete?</a>)<br />
	Current User Email: <?=$currentUser->email?><br />
	Current User Centre ID: <?=$currentUser->centreID?><br />
	Current User First Name: <?=$currentUser->firstName?><br />
	Current User Last Name: <?=$currentUser->lastName?><br />
	Current User Phone: <?=$currentUser->phone?><br />

<? } else { redirect('/','refresh'); } ?>