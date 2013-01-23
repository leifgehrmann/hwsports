<? if($this->ion_auth->logged_in()){ ?>
	<h1>Welcome <?=$currentUser->firstName?> <?=$currentUser->lastName?></h1>

	<? if(!empty($message)){ ?>
		<div id="infoMessage"><?php echo $message;?></div>
	<? } ?>

	<a class="button tickets" href="/sis/tickets"><div class="icon"></div><div class="label">Buy Tickets</div><div class="subtitle">Purchase and view your tickets for tournaments</div></a>
	<a class="button signup" href="/sis/signup"><div class="icon"></div><div class="label">Sign up</div><div class="subtitle">Sign up for sports tournaments</div></a>
	<a class="button details" href="/sis/details"><div class="icon"></div><div class="label">Edit My Details</div><div class="subtitle">Change your personal details</div></a>
	<? if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin')){ ?>
		<a class="button tms" href="/tms/"><div class="icon"></div><div class="label">Tournament Management System</div><div class="subtitle">Enter the tournament Management System portal</div></a>
	<? } ?>

	<div style="clear:both;"></div>
<? } else { redirect('/','refresh'); } ?>