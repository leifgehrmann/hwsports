
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>

	<h2>Sign Up for <?=$tournament['name']?>:</h2>
	<div id="stage1">
		Select role: 
		<select id="role" name="role">
			<option value='1'>Single Player</option>
			<option value='2'>Team Leader</option>
			<option value='3'>Umpire</option>
		</select>
	</div>	
<!-- /#main -->

<script type="text/javascript">
	$(document).ready(function() {
		$("#role").change(function() {
			alert("You are a "+$(this).val()+"! Well done!");
		});
	});
</script>