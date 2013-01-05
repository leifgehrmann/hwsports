<div id="infoMessage"><?=$message;?></div>

<h1>Venue List</h1>

<script type='text/javascript'>Rico_CONFIG={};</script>
<script src='http://ajax.googleapis.com/ajax/libs/prototype/1.7/prototype.js' type='text/javascript'></script>
<script src='/scripts/rico/js/rico2pro.js' type='text/javascript'></script>
<script src='/scripts/rico/js/rico_min.js' type='text/javascript'></script>
<link href='/scripts/rico/css/rico.css' type='text/css' rel='stylesheet'/>
<script src='/scripts/rico/js/ricoThemeroller.js' type='text/javascript'></script>
<link type='text/css' rel='Stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css'/>
<link type='text/css' rel='stylesheet' href='/scripts/rico/css/striping_ui-lightness.css'/>
<style type='text/css'>.ricoLG_Resize{background-repeat:repeat;background-image:url(/scripts/rico/images/resize.gif)}.rico-icon{background-repeat:no-repeat;background-image:url(/scripts/rico/images/ricoIcons.gif)}</style>
<?
require "/home/sports/public_html/scripts/rico/plugins/php/dbClass3.php";
require "/home/sports/public_html/scripts/rico/plugins/php/ricoLiveGridForms.php";
session_set_cookie_params(60*60);

$GLOBALS['oDB'] = new dbClass();
if (! $GLOBALS['oDB']->MySqlLogon("sports_northwind", "sports_northwind", "northwind") ) die('MySqlLogon failed');

$oForm=new TableEditClass();/*
$oForm->SetTableName("shippers");
$oForm->options["XMLprovider"]="ricoQuery.php";
$oForm->convertCharSet=true;
$oForm->options["canAdd"]=1;
$oForm->options["canEdit"]=1;
$oForm->options["canDelete"]=1;
$oForm->options["frozenColumns"]=1;
$oForm->options["menuEvent"]='click';
$oForm->options["highlightElem"]='cursorRow';

$oForm->AddEntryFieldW("ShipperID", "ID", "B", "<auto>",50);
$oForm->AddEntryFieldW("CompanyName", "Company Name", "B", "", 150);
$oForm->ConfirmDeleteColumn();
$oForm->SortAsc();
$oForm->AddEntryFieldW("Phone", "Phone Number", "B", "", 150);

$oForm->DisplayPage();

$oDB->dbClose();*/
?>


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
	<div id="map" style="width: 400px; height: 250px;"></div>

	<p><?=form_submit('submit', 'Create Venue');?></p>
		
<?=form_close();?>

<script type="text/javascript">
// a global variable to access the map
var map;
var centre_marker;
var centre_pos  = new google.maps.LatLng( $('input[name="lat"]').val(), $('input[name="lng"]').val() );

function zoomIn(){ map.setZoom(map.getZoom()+1);}
function zoomOut(){ map.setZoom(map.getZoom()-1);}

function initialize(){
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: centre_pos,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	centre_marker = new google.maps.Marker({ position: centre_pos, map: map, title: "New Venue Location" });

	google.maps.event.addListener(map, 'dragend', function() {
		var newcentre = map.getCenter();
		centre_marker.setPosition(newcentre);
		$('input[name=lat]').val(newcentre.lat());
		$('input[name=lng]').val(newcentre.lng());
	});
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
