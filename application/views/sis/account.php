<? if($this->ion_auth->logged_in()){ ?>
	<h1>Hi <?=$currentUser->firstName?>,</h1>

	<a class="account-button tickets" href="/sis/tickets"><div class="icon"></div><div class="label">Tickets</div><div class="subtitle">See which tickets you have purchased</div></a>
	<a class="account-button tickets" href="/sis/signup"><div class="icon"></div><div class="label">Sign up</div><div class="subtitle">Sign up for sports tournaments</div></a>
	<? if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin')){ ?>
		<a class="account-button tickets" href="/tms/"><div class="icon"></div><div class="label">Tournament Management System</div><div class="subtitle">Enter the tournament Management System portal</div></a>
	<? } ?>

	<div id="infoMessage"><?php echo $message;?></div>

	Current User ID: <?=$currentUser->id?> (<a href="auth/delete_user">Delete?</a>)<br />
	Current User Email: <?=$currentUser->email?><br />
	Current User Centre ID: <?=$currentUser->centreID?><br />
	Current User First Name: <?=$currentUser->firstName?><br />
	Current User Last Name: <?=$currentUser->lastName?><br />
	Current User Phone: <?=$currentUser->phone?><br />

<? } else { redirect('/','refresh'); } ?>