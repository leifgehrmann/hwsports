<div class="fancyform">
	<? if($success) { ?>
	<script type="text/javascript">
		window.location.reload(false); 
	</script>
	<? } else { ?>
		<h1>Deletion Dependencies:</h1>
		<?=$dependencies?>
	<? } ?>
</div>