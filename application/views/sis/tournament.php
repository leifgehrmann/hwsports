<h1><a href="/sis/tournaments">Tournaments</a> &gt; $tournamentName</h1>
<p></p>
<h2>Games</h2>
<?
	$this->load->library('table');

	$data = array(
				array('Name', 'Color'),
				array('<a href="/sis/game/$gameID">Wattball</a>', 'sign up'),
				array('<a href="/sis/game/$gameID">Wattball</a>', 'sign up'),
				array('<a href="/sis/game/$gameID">Wattball</a>', 'sign up')	
			);

	echo $this->table->generate($data);
?>
<h2>Calendar</h2>