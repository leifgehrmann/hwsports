<h1><?=$group['name']?>: Group Users</h1>

<div id="main">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="groupUsers" width="100%">
		<thead>
			<tr>
				<th>User ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>About</th>
				<th width="5%">&nbsp;</th>
			</tr>
		</thead>
	</table>
	<div class="spacer"></div>
	<div id="groupID" style="display:none;"><?=$group['groupID']?></div>
</div><!-- /#main -->

<script src="/js/vendor/datatables/groupUsers.js"></script>
