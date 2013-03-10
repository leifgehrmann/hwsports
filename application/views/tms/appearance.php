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
<script charset="utf-8" src="/js/vendor/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor,|,formatselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,preview",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,charmap,iespell,media,advhr,|,fullscreen",
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
<!-- /#main -->