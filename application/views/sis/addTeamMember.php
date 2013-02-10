<div class="yourFancyBoxClass">
  <? if($success) { ?>
    <h2>Form was submitted!</h2>
	<? if(!empty($message)){ ?>
	  <div id="infoMessage"><?php $message;?></div>
	<? } ?>
  <? } else { ?>
    <form action="/sis/addTeamMember" method="POST">
      <?=$form?>
    </form>
   <? } ?>
</div>