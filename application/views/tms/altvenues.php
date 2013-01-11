<h1>Venues</h1>

<?php 
	$this->load->library('table');

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
	/*$data = array(
             array('Name', 'Color', 'Size'),
             array('Fred', 'Blue', 'Small'),
             array('Mary', 'Red', 'Large'),
             array('John', 'Green', 'Medium')	
             );*/
	echo print_r($this->data['venues']);
	//echo $this->table->generate($data['venues']);
?>

<h1>Create New Venue</h1>

<p>Enter details of new venue below.</p>

<?=form_open("tms/venues");?>

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
	<div id="map" style="width: 400px; height: 250px;"></div>

	<p><?=form_submit('submit', 'Create Venue');?></p>
		
<?=form_close();?>


<!--<script type="text/javascript">
	$(document).ready(function() {
		// a global variable to access the map
		var map;
		var centre_marker;
		var centre_pos  = new google.maps.LatLng( jQuery('input[name="lat"]').val(), jQuery('input[name="lng"]').val() );

		//function zoomIn(){ map.setZoom(map.getZoom()+1);}
		//function zoomOut(){ map.setZoom(map.getZoom()-1);}

		function initialize(){
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 15,
				center: centre_pos,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			
			centre_marker = new google.maps.Marker({ position: centre_pos, map: map, title: "New Venue Location" });

			google.maps.event.addListener(map, 'center_changed', function() {
				var newcentre = map.getCenter();
				centre_marker.setPosition(newcentre);
				jQuery('input[name=lat]').val(newcentre.lat());
				jQuery('input[name=lng]').val(newcentre.lng());
			});
		}

		google.maps.event.addDomListener(window, 'load', initialize);
	}
</script>-->