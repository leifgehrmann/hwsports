<h1><a href="/sis/tournaments">Tournaments</a> &gt; $tournamentName</h1>
<p></p>
<h2>Games</h2>
<?php


	$tmpl = array (
                    'table_open'          => '<table cellspacing="0">',
                    'heading_cell_start'  => '<td>',
                    'heading_cell_end'    => '</td>',
              );

	$this->table->set_template($tmpl);

	$info = array(
				array('<span class="bold"><a href="/sis/game/$gameID">Wattball</a></span>', '<a href="sis/signup/$gameID">sign up</a>'),
				array('<span class="bold"><a href="/sis/game/$gameID">Wattball</a></span>', '<a href="sis/signup/$gameID">sign up</a>'),
				array('<span class="bold"><a href="/sis/game/$gameID">Wattball</a></span>', '<a href="sis/signup/$gameID">sign up</a>')	
			);

	echo $this->table->generate($info);
?>
<h2>Calendar</h2>