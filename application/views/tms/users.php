<h1>Users</h1>
<table>
	<th>
		<td>ID</td>
		<td>First Name</td>
		<td>Last Name</td>
		<td>Phone</td>
		<td>Email</td>
		<td></td>
		<td></td>
	</th>
	<? foreach($users as $user) { ?>
	<tr>
		<td><?=$user['userID']?></td>
		<td><?=$user['firstName']?></td>
		<td><?=$user['lastName']?></td>
		<td><?=$user['phone']?></td>
		<td><?=$user['email']?></td>
		<td><a class="button" href="/tms/user/<?=$user['userid']?>">View</a></td>
	</tr>
	<? } ?>
</table>