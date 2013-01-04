<h1><a href="/sis/tournaments">Tournaments</a> &gt; $tournamentName</h1>
<p></p>
<h2>Games</h2>
<?
	$this->load->library('table');


	$tmpl = array (
                    'table_open'          => '<table border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

	$this->table->set_template($tmpl);

	$info = array(
				array('Name', 'Color'),
				array('<a href="/sis/game/$gameID">Wattball</a>', 'sign up'),
				array('<a href="/sis/game/$gameID">Wattball</a>', 'sign up'),
				array('<a href="/sis/game/$gameID">Wattball</a>', 'sign up')	
			);

	echo $this->table->generate($info);
?>
<h2>Calendar</h2>