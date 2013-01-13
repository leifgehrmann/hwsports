<h1>Venues</h1>

<table id="venuesTable">
	<thead>
		<tr>
			<?php
				$columnID = array('venueID','name','description','view','maps');
				$columnNames = array('venueID'=>'ID','name'=>'Venue Name','description'=>'Description','view'=>'','maps'=>'');
				$columnWidths = array('venueID'=>30,'name'=>100,'description'=>180,'view'=>100,'maps'=>100);
				$columnSortable = array('venueID'=>true,'name'=>true,'description'=>true,'view'=>false,'maps'=>false);
				
				foreach($columnID as $key){
					echo "<th style='width:".$columnWidths[$key]."px'";
					if($columnSortable[$key])
						echo " sort='$key'";
					echo ">".$columnNames[$key]."</th>\n";
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			$venues = $this->data['venues'];
			foreach($venues as $venue){
				echo "<tr>\n";
				foreach($columnID as $key){
					echo "<td>\n";
					switch ($columnID) {
						case 'venueID':
							echo $venue['venueID']; break;
						case 'name':
							echo "<a href='/tms/venue/".$venue['venueID']."'>".$venue['name']."</a>"; break;
						case 'description':
							echo $venue['description']; break;
						case 'view':
							echo "<a href='/tms/venue/".$venue['venueID']."'>View Details</a>"; break;
						case 'maps':
							echo "<a target='_blank' href='http://maps.google.com/maps?q=".$venue['lat'].",".$venue['lng']."'>View on Map</a>"; break;
					}
					echo "</td>\n";
				}
				echo "</tr>\n";
			}
		?>
	</tbody>
	<tfoot class="nav">
		<tr>
			<td colspan="<?=count($columnID)?>">
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

<?=form_open("",array('id'=>'createVenue'));?>

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