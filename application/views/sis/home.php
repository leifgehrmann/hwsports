<h1>Welcome to HW Sports!</h1>

<div id="infoMessage"><?php echo $message;?></div>

<? if(!empty($currentUser)) { ?>
	Current User ID: <?=$currentUser->id?> (<a href="auth/delete_user">Delete?</a>)<br />
	Current User Email: <?=$currentUser->email?><br />
	Current User Centre ID: <?=$currentUser->centreID?><br />
	Current User First Name: <?=$currentUser->firstName?><br />
	Current User Last Name: <?=$currentUser->lastName?><br />
	Current User Phone: <?=$currentUser->phone?><br />
<? } else { ?>
	This is the homepage news stuff for public people.
<? } ?>