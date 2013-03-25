<h1>Appearance</h1>

<?php echo form_open("tms/appearance", array('id' => 'settingsForm'));?>

<h2>Main Textual Content</h2>
<table class="yui-skin-sam">
	<tr>
		<td><label for="name">Name:</label></td>
		<td><?php echo form_input($name);?></td>
		<td><label for="shortName">Short Name:</label></td>
		<td><?php echo form_input($shortName);?></td>
	</tr>
	<tr>
		<td><label for="address">Address:</label></td>
		<td colspan="3"><?php echo form_textarea($address);?></td>
	</tr>
	<tr>
		<td><label for="publicFooterLinks">Public Footer Links:</label></td>
		<td colspan="3"><?php echo form_textarea($publicFooterLinks);?></td>
	</tr>
	<tr>
		<td><label for="publicFooterContact">Public Contact Details:</label></td>
		<td colspan="3"><?php echo form_textarea($publicFooterContact);?></td>
	</tr>
</table>
<h2>Website Appearance</h2>
<table>
	<tr>
		<td><label for="headerColour">Interface Colour:</label></td>
		<td><?php echo form_input($headerColour);?></td>
		<td><label for="backgroundColour">Background Colour:</label></td>
		<td><?php echo form_input($backgroundColour);?></td>
	</tr>
</table>

<p><?php echo form_submit('submit', 'Submit Changes', array('class' => 'green'));?></p>

<?php echo form_close();?>

<script type="text/javascript">
	$(document).ready(function() {
	
		$('input.color').ColorPicker({
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

		var yuiEditorLinks = new YAHOO.widget.SimpleEditor('publicFooterLinks', {
			height: '250px',
			width: '400px',
			dompath: true, //Turns on the bar at the bottom
			animate: true //Animates the opening, closing and moving of Editor windows
		});
		yuiEditorLinks.render();
		
		var yuiEditorContact = new YAHOO.widget.SimpleEditor('publicFooterContact', {
			height: '250px',
			width: '400px',
			dompath: true, //Turns on the bar at the bottom
			animate: true //Animates the opening, closing and moving of Editor windows
		});
		yuiEditorContact.render();
	});
</script>

<!-- /#main -->