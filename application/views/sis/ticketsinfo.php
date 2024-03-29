<h1>Tickets</h1>
<p>To purchase tickets, visit the reception desk at the Riccarton Sports Centre. You have a choice of two tickets, Adult and Concession. The tickets will be handed out immediately at the desk.</p>
<h2>What does a ticket exactly get?</h2>
<p>Tickets are bought for a full day, not a particular match. Tickets cannot be used on any other days.</p>
<h2>How much do tickets cost?</h2>
<p>We have two different tickets that one can purchase.</p>
<table>
	<tr>
		<th>Ticket Type</th>
		<th>Cost</th>
	</tr>
	<tr>
		<td>Adult</td>
		<td>&pound;5</td>
	</tr>
	<tr>
		<td>Concession</td>
		<td>&pound;3</td>
	</tr>
</table>
<? if(
	isset($centre['monOpen']) ||  
	isset($centre['tueOpen']) ||  
	isset($centre['wedOpen']) || 
	isset($centre['thuOpen']) || 
	isset($centre['friOpen']) || 
	isset($centre['satOpen']) || 
	isset($centre['sunOpen'])
) { 
	$wk = array('mon','tue','wed','thu','fri','sat','sun');
	$w = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	?>
<h2>What are the opening times of the sports centre</h2>
<table>
	<tr>
		<th></th>
		<th>Opening</th>
		<th>Closing</th>
	</tr>
	<? for($i=0;$i<count($wk);$i++) { 
		if(isset($centre[$wk[$i].'Open'])) {
		if($centre[$wk[$i].'Open']==1) { 
	?>
	<tr>
		<td><?=$w[$i]?></td>
		<td><?=$centre[$wk[$i].'OpenTime']?></td>
		<td><?=$centre[$wk[$i].'CloseTime']?></td>
	</tr>
	<? } } } ?>
</table>
<? } ?>
<h2>How are tickets used?</h2>
<p>To enter a venue, you must have a ticket at hand. Tickets are handed out at the Sports Centre.</p>

<h2>I have a concession ticket, do I need identification?</h2>
<p>Yes, a student ID will be enough to satisfy identification.</p>