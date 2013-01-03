<h1>Welcome to HW Sports!</h1>

<div id="infoMessage"><?php echo $message;?></div>

Current User ID: <?=$currentUser->id?><br />
Current User Email: <?=$currentUser->email?><br />
Current User Centre ID: <?=$currentUser->centreID?><br />
Current User First Name: <?=$currentUser->firstName?><br />
Current User Last Name: <?=$currentUser->lastName?><br />
Current User Phone: <?=$currentUser->phone?><br />

<a href="<?= base_url('auth/login') ?>">Login</a>