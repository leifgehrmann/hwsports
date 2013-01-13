<div id="infoMessage"><?=$message;?></div>

<h1>Venue List</h1>
<div id="main">

	<div id="demo">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
			<thead>
				<tr>
					<th width="30%">Centre ID</th>
					<th width="30%">Lat</th>
					<th width="30%">Lng</th>
					<th width="30%">Venue ID</th>
					<th width="30%">Name</th>
					<th width="30%">Description</th>
					<th width="30%">Directions</th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="spacer"></div>
	<div id="map" class="venues-map"></div>
	<div id="centreID" style="display:none;"><?=$centre['id']?></div>
</div><!-- /#main -->

<link rel='stylesheet' href='/css/jquery.dataTables.css'>
<link rel='stylesheet' href='/css/dataTables.tabletools.css'>
<link rel='stylesheet' href='/css/dataTables.editor.css'>
<link rel='stylesheet' href='http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.23/themes/eggplant/jquery-ui.css'>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.23/jquery-ui.min.js"></script>
<script src="/scripts/datatables/jquery.dataTables.min.js"></script>
<script src="/scripts/datatables/dataTables.tabletools.min.js"></script>
<script src="/scripts/datatables/dataTables.editor.min.js"></script>
<script src="/scripts/datatables/venues.js"></script>