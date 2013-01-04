<div id="infoMessage"><?=$message;?></div>

<h1>Venue List</h1>

<? if(count($venues)>=1) { ?>
<table id="venuesTable">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Description</th>
		<th>Directions</th>
		<th>Lat/Lng</th>
	</tr>
	<?php foreach ($venues as $venue):?>
		<tr>
			<td><?=$venue['venueID'];?></td>
			<td><?=$venue['name'];?></td>
			<td><?=$venue['description'];?></td>
			<td><?=$venue['directions'];?></td>
			<td><?=$venue['lat'];?> / <?=$venue['lng'];?></td>
		</tr>
	<?php endforeach;?>
</table>
<? } else { ?>
No venues exist for this sports centre yet. Please create one below.
<? } ?>

<h1>Create Venue</h1>

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

	<p>Location:</p>
	<div id="map"></div>

	<p><?=form_submit('submit', 'Login');?></p>
		
<?=form_close();?>

<script type="text/javascript">
// a global variable to access the map
var map;
var centre_pos  = new google.maps.LatLng( $('input[name="lat"]').val(), $('input[name="lng"]').val() );

function zoomIn(){ map.setZoom(map.getZoom()+1);}
function zoomOut(){ map.setZoom(map.getZoom()-1);}

function initialize(){
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: centre_pos,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	google.maps.event.addListener(map, 'dragend', function() {
		var newlocation = map.getCenter();
	});
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
