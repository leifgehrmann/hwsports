<h1>Venue List</h1>

<div id="venuemap"></div>
<div id="centreLat" style="display:none;"><?=$centreLat?></div>
<div id="centreLng" style="display:none;"><?=$centreLng?></div>

<div id="main">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="venues" width="100%">
		<thead>
			<tr>
				<th width="0%">Centre ID</th>
				<th width="0%">Lat</th>
				<th width="0%">Lng</th>
				<th width="0%">Venue ID</th>
				<th width="20%">Name</th>
				<th width="30%">Description</th>
				<th width="45%">Directions</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<div class="spacer"></div>
	<div id="centreID" style="display:none;"><?=$centre['id']?></div>
</div>

<!-- /#main -->
<script src="/scripts/datatables/venues.js"></script>