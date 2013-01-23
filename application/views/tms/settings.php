<h1>Centre Settings</h1>
	
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<?php echo form_open("tms/settings");?>
  	
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
    <label for="headerColour">Header Colour:</label><br />
    <?php echo form_input($headerColour);?>
  </p>
  
  <p>
    <label for="backgroundColour">Background Colour:</label><br />
    <?php echo form_input($backgroundColour);?>
  </p>
  
  <p>
    <label for="footerText">Footer Text:</label><br />
    <?php echo form_input($footerText);?>
  </p>
  
  <h2>Opening Times:</h2>
  <p>
    <label for="monOpenTime">Monday:</label><br />
    Open? <?php echo form_checkbox($monOpen);?><br />
    From: <?php echo form_input($monOpenTime);?> Till: <?php echo form_input($monCloseTime);?><br />
  </p>
  <p>
    <label for="tueOpenTime">Tuesday:</label><br />
    Open? <?php echo form_checkbox($tueOpen);?><br />
    From: <?php echo form_input($tueOpenTime);?> Till: <?php echo form_input($tueCloseTime);?><br />
  </p>
  <p>
    <label for="wedOpenTime">Wednesday:</label><br />
    Open? <?php echo form_checkbox($wedOpen);?><br />
    From: <?php echo form_input($wedOpenTime);?> Till: <?php echo form_input($wedCloseTime);?><br />
  </p>
  <p>
    <label for="thuOpenTime">Thursday:</label><br />
    Open? <?php echo form_checkbox($thuOpen);?><br />
    From: <?php echo form_input($thuOpenTime);?> Till: <?php echo form_input($thuCloseTime);?><br />
  </p>
  <p>
    <label for="friOpenTime">Friday:</label><br />
    Open? <?php echo form_checkbox($friOpen);?><br />
    From: <?php echo form_input($friOpenTime);?> Till: <?php echo form_input($friCloseTime);?><br />
  </p>
  <p>
    <label for="satOpenTime">Saturday:</label><br />
    Open? <?php echo form_checkbox($satOpen);?><br />
    From: <?php echo form_input($satOpenTime);?> Till: <?php echo form_input($satCloseTime);?><br />
  </p>
  <p>
    <label for="sunOpenTime">Sunday:</label><br />
    Open? <?php echo form_checkbox($sunOpen);?><br />
    From: <?php echo form_input($sunOpenTime);?> Till: <?php echo form_input($sunCloseTime);?><br />
  </p>

    
  <p><?php echo form_submit('submit', 'Submit Changes');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
$('#headerColour, #backgroundColour').ColorPicker({
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