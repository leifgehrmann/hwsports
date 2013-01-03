<h1>Welcome to HW Sports!</h1>

<div id="infoMessage"><?php echo $message;?></div>

Current User ID: <?=$currentUser->id?><br />
Current User Email: <?=$currentUser->email?><br />
Current User Data: <?print_r($currentUserData)?><br />

<a href="<?= base_url('auth/login') ?>">Login</a>