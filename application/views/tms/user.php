<h1><a href="/tms/users/">Users</a><div class="icon subsection"></div><?=$user['firstName']?> <?=$user['lastName']?></h1>
<table>
	<tr>
		<th>Key</th>
		<th>Value</th>
	</tr>
	<? foreach($user as $key=>$value){ ?>
	<tr>
		<td><?=$key?></td>
		<td><?=$value?></td>
	</tr>
	<? } ?>
	<tr>
		<td></td>
		<td><a class="button red" href="/auth/delete_user/<?=$user['userID']?>" target="_blank" >Delete</td>
	</tr>
</table>