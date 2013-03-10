<h1><a href="/tms/teams/">Teams</a><div class="icon subsection"></div><?=$team['name']?></h1>
<table>
	<tr>
		<th>Key</th>
		<th>Value</th>
	</tr>
	<? foreach($team as $key=>$value){ ?>
	<tr>
		<td><?=$key?></td>
		<td><?=$value?></td>
	</tr>
	<? } ?>
	<tr>
		<td></td>
		<td><a class="button red" href="/auth/delete_user/<?=$team['teamID']?>" target="_blank" >Delete</td>
	</tr>
</table>