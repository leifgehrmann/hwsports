<h1>Appearance</h1>

<?php echo form_open("tms/appearance", array('id' => 'settingsForm'));?>

<h2>Main Textual Content</h2>
<table>
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

</script>
<? /*
<script charset="utf-8" src="/js/vendor/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor,|,formatselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,undo,redo,|,link,unlink,anchor,|,cleanup,styleprops,code,|,preview,fullscreen",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,charmap,image,iespell,media,advhr,|,help",
	theme_advanced_buttons4 : "styleprops",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	// height of the editor
	height : "480",

	// Example content CSS (should be your site CSS)
	content_css : "css/example.css",

	// Skin options
	skin : "o2k7",
	skin_variant : "silver",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});
</script>
<form method="post" action="somepage">
	<textarea name="content" style="width:100%"></textarea>
</form> 
*/ ?>
<!-- /#main -->