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
			<td><?=$venue['id'];?></td>
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

	<p><?=form_submit('submit', 'Login');?></p>
		
<?=form_close();?>