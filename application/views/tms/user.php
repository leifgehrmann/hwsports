<h1><a href="/tms/users/">Users</a><div class="icon subsection"></div><?=$user['firstName']?><?=$user['lastName']?></h1>
<table>
	<th>
		<td>Key</td>
		<td>Value</td>
	</th>
	<? foreach($user as $key=>$value){ ?>
	<tr>
		<td><?=$key?></td>
		<td><?=$value?></td>
	</tr>
	<tr>
		<td><?=$key?></td>
		<td><a class="button red" href="/auth/delete_user/<?=$user['id']?>" target="_blank" >Delete</td>
	</tr>
</table>