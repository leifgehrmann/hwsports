<h1><a href="/tms/groups/">Groups</a><div class="icon subsection"></div><?=$group['name']?></h1>

<a href="/tms/fixGroups/<?=$group['groupID']?>">Fix permissions</a> (Add ungrouped users to this group)<br />

<div id="main">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="groupUsers" width="100%">
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
	<div id="groupID" style="display:none;"><?=$group['groupID']?></div>
</div><!-- /#main -->


<script src="/js/vendor/datatables/groupUsers.js"></script>
