<h1>Sports List</h1>

<div id="main">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="venues" width="100%">
		<thead>
			<tr>
				<th width="30%">Centre ID</th>
				<th width="30%">Sport ID</th>
				<th width="30%">Name</th>
				<th width="30%">Description</th>
				<th width="30%">Sport Category</th>
			</tr>
		</thead>
	</table>
	<div class="spacer"></div>
	<div id="centreID" style="display:none;"><?=$centre['id']?></div>
</div><!-- /#main -->


<link rel='stylesheet' href='/css/jquery.dataTables.css'>
<link rel='stylesheet' href='/css/dataTables.tabletools.css'>
<link rel='stylesheet' href='/css/dataTables.editor.css'>
<link rel='stylesheet' href='http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.23/themes/eggplant/jquery-ui.css'>
<script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.23/jquery-ui.min.js"></script>
<script src="/scripts/datatables/jquery.dataTables.min.js"></script>
<script src="/scripts/datatables/dataTables.tabletools.min.js"></script>
<script src="/scripts/datatables/dataTables.editor.min.js"></script>
<script src="/scripts/datatables/venues.js"></script>