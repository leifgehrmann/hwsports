<h1>Venues</h1>

<table id="venuesTable">
	<thead>
		<tr>
			<?php
				$columnID = array('venueID','name','description','view','maps');
				$columnNames = array('venueID'=>'ID','name'=>'Venue Name','description'=>'Description','view'=>'','maps'=>'');
				$columnWidths = array('venueID'=>30,'name'=>100,'description'=>230,'view'=>100,'maps'=>100);
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
					switch ($key) {
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

<h2>Create new venue</h2>

<p>Enter details of new venue below.</p>

<?=form_open("",array('id'=>'createVenue'));?>

	<?=form_hidden($createLatLng);?>
	
	<table>
		<tr>
			<td><label for="name">Name:</label></td>
			<td><?=form_input($createName);?></td>
		</tr>
		<tr>
			<td><label for="description">Description:</label></td>
			<td><?=form_input($createDescription);?></td>
		</tr>
		<tr>
			<td><label for="directions">Directions:</label></td>
			<td><?=form_input($createDirections);?></td>
		</tr>
		<tr>
			<td>Location:</td>
			<td><div id="map" class="venues-map"></div></td>
		</tr>
		<tr>
			<td></td>
			<td><?=form_submit('submit', 'Create Venue');?></td>
		</tr>
	</table>
<?=form_close();?>
<div id="message"></div>