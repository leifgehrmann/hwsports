This page is still under development.<br />
<br /><pre>
<? print_r($users); /*

<? foreach($users as $user) { ?>
<div>
	User ID: <? print_r($user) ?> (<a href="auth/delete_user/">Delete?</a>)<br>
	Sports Centre: <?=$user['centreName']?><br>
	First Name: <?=$user['firstName']?><br>
	Last Name: <?=$user['lastName']?><br>
	Phone: <?=$user['phone']?><br>
	Email: <?=$user['email']?><br>
</div>
<? } */?></pre>