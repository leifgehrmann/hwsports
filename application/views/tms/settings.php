<h1>Centre Settings</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<?php echo form_open("tms/settings");?>
  	
  <p>
    <label for="name">Name:</label>
    <?php echo form_input($name);?>
  </p>

  <p>
    <label for="shortName">Short Name:</label>
    <?php echo form_input($shortName);?>
  </p>

  <p>
    <label for="address">Address:</label>
    <?php echo form_input($address);?>
  </p>
  
  <p>
    <label for="headerColour">Header Colour:</label>
    <?php echo form_input($headerColour);?>
  </p>
  
  <p>
    <label for="backgroundColour">Background Colour:</label>
    <?php echo form_input($backgroundColour);?>
  </p>
  
  <p>
    <label for="footerText">Footer Text:</label>
    <?php echo form_input($footerText);?>
  </p>

    
  <p><?php echo form_submit('submit', 'Submit Changes');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
$('input[name="headerColour"], input[name="backgroundColour"]').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}
}).bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});
</script>

<!-- /#main -->