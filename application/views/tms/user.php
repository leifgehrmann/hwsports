<h1><a href="/tms/users/">Users</a><div class="icon subsection"></div><?=$user['firstName']?> <?=$user['lastName']?></h1>
<table>
	<tr>
		<th>Key</th>
		<th>Value</th>
	</tr>
	<? foreach($user as $key=>$value){ ?>
	<tr>
		<td><?=$key?></td>
		<td><?=$value?></td>
	</tr>
	<? } ?>
	<tr>
		<td></td>
		<td><a id="deleteUser" class="button red" href="#">Delete</a></td>
	</tr>
</table>

<script>
function preDeleteConfirm(callbackYes,callbackNo) {
    jQuery.fancybox({
        'modal' : true,
		'href' : '/datatables/predelete/users-<?=$user['userID']?>',
		'type' : 'ajax'
        'beforeShow' : function() {
            jQuery("#fancyconfirm_cancel").click(function() {
                $.fancybox.close();
                callbackNo();
            });
            jQuery("#fancyConfirm_ok").click(function() {
                $.fancybox.close();
                callbackYes();
            });
        }
    });
}

$(document).ready(function() {
    $("#deleteUser").click(function() {
        preDeleteConfirm(function() {
            jQuery.fancybox({
				'modal' : true,
				'href' : '/auth/delete_user/<?=$user['userID']?>',
				'type' : 'ajax'
			});
        }, function() { });
    });
});
</script>