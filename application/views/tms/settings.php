<h1>Centre Settings</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<?php echo form_open("tms/settings", array('id' => 'settingsForm'));?>
  	
  <h2>Textual Content:</h2>
  <p>
    <label for="name">Name:</label><br />
    <?php echo form_input($name);?>
  </p>
  <p>
    <label for="shortName">Short Name:</label><br />
    <?php echo form_input($shortName);?>
  </p>
  <p>
    <label for="address">Address:</label><br />
    <?php echo form_input($address);?>
  </p>
  <p>
    <label for="footerText">Footer Text:</label><br />
    <?php echo form_input($footerText);?>
  </p>
  
	<h2>Opening Times:</h2>
	<table>
		<tr><td></td><td></td><td>From</td><td>Till</td></tr>
		<tr>
			<td><label for="monOpenTime">Monday:</label></td>
			<td><?php echo form_checkbox($monOpen);?></td>
			<td><?php echo form_input($monOpenTime);?></td>
			<td><?php echo form_input($monCloseTime);?></td>
		</tr>
		<tr>
			<td><label for="tueOpenTime">Tuesday:</label></td>
			<td><?php echo form_checkbox($tueOpen);?></td>
			<td><?php echo form_input($tueOpenTime);?></td>
			<td><?php echo form_input($tueCloseTime);?></td>
		</tr>
		<tr>
			<td><label for="wedOpenTime">Wednesday:</label></td>
			<td><?php echo form_checkbox($wedOpen);?></td>
			<td><?php echo form_input($wedOpenTime);?></td>
			<td><?php echo form_input($wedCloseTime);?></td>
		</tr>
		<tr>
			<td><label for="thuOpenTime">Thursday:</label></td>
			<td><?php echo form_checkbox($thuOpen);?></td>
			<td><?php echo form_input($thuOpenTime);?></td>
			<td><?php echo form_input($thuCloseTime);?></td>
		</tr>
		<tr>
			<td><label for="friOpenTime">Friday:</label></td>
			<td><?php echo form_checkbox($friOpen);?></td>
			<td><?php echo form_input($friOpenTime);?></td>
			<td><?php echo form_input($friCloseTime);?></td>
		</tr>
		<tr>
			<td><label for="satOpenTime">Saturday:</label></td>
			<td><?php echo form_checkbox($satOpen);?></td>
			<td><?php echo form_input($satOpenTime);?></td>
			<td><?php echo form_input($satCloseTime);?></td>
		</tr>
		<tr>
			<td><label for="sunOpenTime">Sunday:</label></td>
			<td><?php echo form_checkbox($sunOpen);?></td>
			<td><?php echo form_input($sunOpenTime);?></td>
			<td><?php echo form_input($sunCloseTime);?></td>
		</tr>
	</table>

  <h2>Website Appearance:</h2>
  <p>
    <label for="headerColour">Header Colour:</label><br />
    <?php echo form_input($headerColour);?>
  </p>
  <p>
    <label for="backgroundColour">Background Colour:</label><br />
    <?php echo form_input($backgroundColour);?>
  </p>
  <br />
  
  <p><?php echo form_submit('submit', 'Submit Changes');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
$('#headerColour, #backgroundColour').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).css('background-color','#'+hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}
}).bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});

$('input.time').timepicker();

</script>

<!-- /#main -->