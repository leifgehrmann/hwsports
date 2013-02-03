
<? if(!empty($message)){ ?>
  <div id="infoMessage"><?php $message;?></div>
<? } ?>

<?php echo form_open("sis/signup/2", array('id' => 'signupForm'));?>
  	
	<h2>Sign Up for Tournament:</h2>
	<p>
		<?php echo form_dropdown('tournament', $tournaments);?>
	</p>	
	<p><?php echo form_submit('submit', 'Submit');?></p>
    
<?php echo form_close();?>

<script type="text/javascript">
	$('.date').datepicker({
      dateFormat: "dd/mm/yy"
    });
</script>

<!-- /#main -->