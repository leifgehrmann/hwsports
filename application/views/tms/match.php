<h1><a href="/tms/matches/">Matches</a><div class="icon subsection"></div><span id="title-name"><?=$this->data["match"]["name"]?></span></h1>
<?=form_open("tms/match/$matchID", array('id' => 'matchDetailsForm'))?>
<table>
	<tr>
		<td>Name</td>
		<td><?=form_input($name)?></td>
		<? if($match['tournamentID']!="0") { ?>
		<td>Tournament</td>
		<td><a href="/tms/tourmament/<?=$match['tournamentID']?>"></a></td>
		<? } ?>
	</tr>
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
		<td><?=form_submit(array('name'=>"submit", 'value'=>"Update", 'class'=>"right green"));?></td>
	</tr>
</table>
<?=form_close();?>

<script type="text/javascript">
$('input.date').datetimepicker({
		dateFormat: $.datepicker.ISO_8601,
		separator: ' ',
		timeFormat: 'HH:mm',
		ampm: false
	});
</script>