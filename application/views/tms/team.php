<h1><?=$team['name']?>: Team Members</h1>

<div id="main">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="teamUsers" width="100%">
		<thead>
			<tr>
				<th>User ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>About</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<div class="spacer"></div>
	<div id="teamID" style="display:none;"><?=$team['teamID']?></div>
	<div id="centreID" style="display:none;"><?=$centre['centreID']?></div>
</div><!-- /#main -->

<script src="/js/vendor/datatables/teamUsers.js"></script>
