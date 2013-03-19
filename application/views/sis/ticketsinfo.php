<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<h1>Tickets</h1>
<p>In order to purchase tickets, you have to first <a href="/auth/register/">register an account with us</a>. From your account interface you should then see the options to purchase tickets.</p>
<h2>What does a ticket exactly get?</h2>
<p>Tickets are bought for a full day, not a particular match. Tickets cannot be used the next day.</p>
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
<h2>How are tickets used?</h2>
<p>To enter a venue, you must have a printed ticket to show. This can be checked</p>

<h2>I have a concession ticket, do I need identification?</h2>
<p>Yes, a student ID will be enough to satisfy identification.</p>