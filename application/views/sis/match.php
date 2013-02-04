<h1><a href="/sis/matches">Matches</a> &gt; <?=$match['name']?></h1>
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
