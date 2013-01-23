This page is still under development.<br />
<br />

<? foreach($users as $user) { ?>
<div>
	User ID: <?=$user['id']?> (<a href="/auth/delete_user/<?=$user['id']?>" target="_blank">Delete?</a>)<br>
	Sports Centre: <?=$user['centreName']?><br>
	First Name: <?=$user['firstName']?><br>
	Last Name: <?=$user['lastName']?><br>
	Phone: <?=$user['phone']?><br>
	Email: <?=$user['email']?><br>
</div>
<br />
<? } ?>