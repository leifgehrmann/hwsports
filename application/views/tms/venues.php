<div id="infoMessage"><?=$message;?></div>

<h1>Venue List</h1>


<h1>Create Venue</h1>

<p>Enter details of new venue below.</p>

<?=$apiData;?>

<?=form_open("tms/venues/create");?>

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