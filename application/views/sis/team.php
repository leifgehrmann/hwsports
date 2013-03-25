<h1>Teams<div class="icon subsection"></div><?=$team['name']?></h1>
<? if( isset($team['associationNumber']) || isset($team['description']) ) ?>
<table>
	<? if(isset($team['description'])) ?>
	<tr>
		<td><b>Description:</b></td>
		<td><?=$team['description']?></td>
	</tr>
	<? } ?>
	<? if(isset($team['associationNumber'])) ?>
	<tr>
		<td><b>Association Number:</b></td>
		<td><?=$team['assocationNumber']?></td>
	</tr>
	<? } ?>
</table>
<? } ?>
<h2>Team Members</h2>
<? if(isset($team['users'])) { ?>
<? if(count($team['users'])!=0) { ?>
<table>
	<? foreach($team['users'] as $member ) { ?>
	<tr><td><?=$member['firstName'].' '.$member['lastName']?></td></tr>
	<? } ?>
</table>
<? } ?>
<? } ?>