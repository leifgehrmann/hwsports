<h1><a href="/tms/teams/">Teams</a><div class="icon subsection"></div><?=$team['name']?></h1>

<?=form_open("tms/match/$matchID", array('id' => 'matchDetailsForm'))?>
<table>
	<tr>
		<td>Name</td>
		<td><?=form_input($name)?></td>
	</tr>
	<? if($team['associationNumber']) { ?>
	<tr>
		<td>Association Number</td>
		<td><?=form_input($associationNumber)?></td>
	</tr>
	<? } ?>
	<tr>
		<td>Description</td>
		<td colspan="3"><?=form_textarea($description)?></td>
	</tr>
	<tr>
		<td>Start Time</td>
		<td><?=form_input($startTime)?></td>
		<td>End Time</td>
		<td><?=form_input($endTime)?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td><?=form_submit(array('name'=>"submit", 'value'=>"Update Match", 'class'=>"right green"));?></td>
	</tr>
</table>
<?=form_close();?>

<div id="main">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="teamUsers" width="100%">
		<thead>
			<tr>
				<th>User ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>About</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<div class="spacer"></div>
	<div id="teamID" style="display:none;"><?=$team['teamID']?></div>
	<div id="centreID" style="display:none;"><?=$centre['centreID']?></div>
</div><!-- /#main -->

<script src="/js/vendor/datatables/teamUsers.js"></script>
