<h1>Venues</h1>

<table id="venuesTable">
	<thead>
		<tr>
			<?php
				$venues = $this->data['venues'];
				foreach($venues[0] as $key=>$value){
					echo "<th sort='$key'>$key</th>\n";
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			$venues = $this->data['venues'];
			foreach($venues as $venue){
				echo "<tr>\n";
				foreach($venue as $key=>$value){
					echo "<td>$value</td>\n";
				}
				echo "</tr>\n";
			}
		?>
	</tbody>
	<tfoot class="nav">
		<tr>
			<td colspan="6">
				<div class="pagination"></div>
				<div class="paginationTitle">Page</div>
				<div class="selectPerPage"></div>
				<div class="status"></div>
			</td>
		</tr>
	</tfoot>
</table>

<!--<?php 
	/*$this->load->library('table');

	$out = array();
	$i = 0;
	foreach($this->data['venues'] as $venue){
		if($i==0){
			$head = array();
			foreach($venue as $key=>$value){
				$head[] = $key;
			}
			$out[] = $head;
			$i = 1;
		}
		$row = array();
		foreach($venue as $key=>$value){
			$row[] = $value;
		}
		$out[] = $row;
	}
	//echo print_r($this->data['venues']);
	echo $this->table->generate($out);*/
?>-->

<h2>Create new venue</h2>

<p>Enter details of new venue below.</p>

<?=form_open("#");?>

	<?=form_hidden($createLatLng);?>
		
	<p>
	<label for="name">Name:</label>
	<?=form_input($createName);?>
	</p>
	
	<p>
	<label for="description">Description:</label>
	<?=form_input($createDescription);?>
	</p>
	
	<p>
	<label for="directions">Directions:</label>
	<?=form_input($createDirections);?>
	</p>

	<p>Location (drag map center to venue position):</p>
	<div id="map" class="venues-map"></div>

	<p><?=form_submit('submit', 'Create Venue');?></p>
		
<?=form_close();?>