<h1>Appearance</h1>
	
<?php echo form_open("tms/appearance", array('id' => 'settingsForm'));?>
  	
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