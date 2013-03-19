
<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<h1><a href="/sis/matches">Matches</a><div class="icon subsection"></div><?=$match['name']?></h1>
<h2>Match Details</h2>
<?php
	$tmpl = array (
		'table_open'          => '<table cellspacing="0">',
		'heading_cell_start'  => '<td>',
		'heading_cell_end'    => '</td>',
	);
	$this->table->set_template($tmpl);

	echo $this->table->generate($matchTable);
?>
