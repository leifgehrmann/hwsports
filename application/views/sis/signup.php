
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>

	<h2>Sign Up for <?=$tournament['name']?>:</h2>
	
	<pre><? print_r($roles) ?></pre>
	
	<div id="accordion">
		<h3>Select role:</h3>
		<div id="stage1">
			<select id="role" name="role">
				<option></option>
				<option value='1'>Single Player</option>
				<option value='2'>Team Leader</option>
				<option value='3'>Umpire</option>
			</select>
		</div>
		<h3>Enter personal details:</h3>
		<div id="stage2">
			Address: <br />
			<textarea id="address" name="address"></textarea><br />
			<br />
			Emergency Contact:<br />
			 Name: <input type="text" name="emergencyName"></input><br />
			 Number: <input type="text" name="emergencyNumber"></input>
		</div>	
	</div>
	
<!-- /#main -->

<script type="text/javascript">
	$(document).ready(function() {
		var accordionReference = $("#accordion").accordion();
		
		$("#role").change(function() {
			accordionReference.accordion('option', 'active', 1 );
		});
	});
</script>