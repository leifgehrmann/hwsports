<div id="infoMessage"><?=$message;?></div>

<h1>Venue List</h1>

<? 
if (!isset ($_SESSION)) session_start();
print_r($_SESSION); echo "sess1<br /><br />"; ?>

<script type='text/javascript'>Rico_CONFIG={};</script>
<script src='http://ajax.googleapis.com/ajax/libs/prototype/1.7/prototype.js' type='text/javascript'></script>
<script src='/scripts/tiny_mce/tiny_mce.js' type='text/javascript'></script>
<script src='/scripts/rico/js/rico2pro.js' type='text/javascript'></script>
<script src='/scripts/rico/js/rico_min.js' type='text/javascript'></script>
<link href='/scripts/rico/css/rico.css' type='text/css' rel='stylesheet'/>
<script src='/scripts/rico/js/ricoThemeroller.js' type='text/javascript'></script>
<link type='text/css' rel='Stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css'/>
<link type='text/css' rel='stylesheet' href='/scripts/rico/css/striping_ui-lightness.css'/>
<style type='text/css'>
.ricoLG_Resize{
	background-repeat:repeat;
	background-image:url(/scripts/rico/images/resize.gif);
}
.rico-icon{
	background-repeat:no-repeat;
	background-image:url(/scripts/rico/images/ricoIcons.gif)
}
div.ricoLG_cell {
  white-space:nowrap;
}
</style>
<?
require "/home/sports/public_html/scripts/rico/plugins/php/dbClass3.php";
require "/home/sports/public_html/scripts/rico/plugins/php/ricoLiveGridForms.php";
session_set_cookie_params(60*60);
print_r($_SESSION); echo "sess2br /><br />";

$GLOBALS['oDB'] = new dbClass();
if (! $GLOBALS['oDB']->MySqlLogon("sports_web", "sports_web", "group8") ) die('MySqlLogon failed');

print_r($_SESSION); echo "sess3<br /><br />";
$oForm=new TableEditClass();
$oForm->SetTableName("venues");
$oForm->options["XMLprovider"]="/scripts/rico/plugins/php/ricoQuery.php";
$oForm->convertCharSet=true;
$oForm->options["canAdd"]=1;
$oForm->options["canEdit"]=1;
$oForm->options["canDelete"]=1;
$oForm->options["frozenColumns"]=0;
$oForm->options["menuEvent"]='click';
$oForm->options["highlightElem"]='cursorRow';

$oForm->AddEntryFieldW("venueID", "venueID", "B", "",50);
$oForm->AddEntryFieldW("centreID", "centreID", "B", "", 50);

$oForm->ConfirmDeleteColumn();
$oForm->SortAsc();

print_r($_SESSION); echo "sess4<br /><br />";
$oForm->DisplayPage();

$GLOBALS['oDB']->dbClose();
?>

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

	<p>Location (drag map center to venue position):</p>
	<div id="map" style="width: 400px; height: 250px;"></div>

	<p><?=form_submit('submit', 'Create Venue');?></p>
		
<?=form_close();?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

	$(document).ready(function() {
		// a global variable to access the map
		var map;
		var centre_marker;
		var centre_pos  = new google.maps.LatLng( jQuery('input[name="lat"]').val(), jQuery('input[name="lng"]').val() );

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
				jQuery('input[name=lat]').val(newcentre.lat());
				jQuery('input[name=lng]').val(newcentre.lng());
			});
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	}
</script>
