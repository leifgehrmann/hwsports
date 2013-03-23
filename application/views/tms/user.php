<h1><a href="/tms/users/">Users</a><div class="icon subsection"></div><?=$user['firstName']?> <?=$user['lastName']?></h1>
<h2>General User Details</h2>
<?=form_open("tms/user/$userID", array('id' => 'userDetailsForm'))?>
<table>
	<tr>
		<td>First Name</td>
		<td><?=form_input($firstName)?></td>
		<td>Last Name</td>
		<td><?=form_input($lastName)?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?=$user['email']?></td>
		<td>Phone</td>
		<td><?=form_input($firstName)?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td colspan="3"><?=form_textarea($address)?></td>
	</tr>
	<tr>
		<td>Bio</td>
		<td colspan="3"><?=form_textarea($aboutMe)?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td><?=form_submit(array('name'=>"userDetails", 'value'=>"Update User", 'class'=>"right green"));?></td>
	</tr>
</table>
<?=form_close();?>

<h2>Emergency Contact Details</h2>
<?=form_open("tms/user/$userID", array('id' => 'emergencyDetailsForm'))?>
<table>
	<tr>
		<td>Name</td>
		<td><?=form_input($emergencyName)?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?=form_input($emergencyEmail)?></td>
		<td>Phone</td>
		<td><?=form_input($emergencyPhone)?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td colspan="3"><?=form_textarea($emergencyAddress)?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td><?=form_submit(array('name'=>"emergencyDetails", 'value'=>"Update Emergency Contact", 'class'=>"right green"));?></td>
	</tr>
</table>
<?=form_close();?>

<h2>Tournament User Details</h2>


<!--<td><a id="deleteUser" class="button red" href="#">Delete</a></td>-->
<script>
function preDeleteConfirm(callbackYes,callbackNo) {
    jQuery.fancybox({
        'modal' : true,
		'href' : '/datatables/predelete/users-<?=$user['userID']?>',
		'type' : 'ajax',
        'beforeShow' : function() {
            jQuery("#fancycancel").click(function() {
                $.fancybox.close();
                callbackNo();
            });
            jQuery("#fancyconfirm").click(function() {
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