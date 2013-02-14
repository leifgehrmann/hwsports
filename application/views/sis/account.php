<? if($this->ion_auth->logged_in()){ ?>
	<h1>Welcome <?=$currentUser->firstName?> <?=$currentUser->lastName?></h1>

	<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
	<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
	<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
	<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
	<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

	<a class="button tickets" href="/sis/tickets"><div class="icon"></div><div class="label">Buy Tickets</div><div class="subtitle">Purchase and view your tickets for tournaments</div></a>
	<a class="button signup" href="/sis/tournaments"><div class="icon"></div><div class="label">Sign up</div><div class="subtitle">Sign up for sports tournaments</div></a>
	<a class="button details" href="/sis/details"><div class="icon"></div><div class="label">Edit My Details</div><div class="subtitle">Change your personal details</div></a>
	<? if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('centreadmin')){ ?>
		<a class="button tms" href="/tms/"><div class="icon"></div><div class="label">Tournament Management System</div><div class="subtitle">Enter the tournament Management System portal</div></a>
	<? } ?>

	<div style="clear:both;"></div>
<? } else { redirect('/','refresh'); } ?>