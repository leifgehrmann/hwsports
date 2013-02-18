<h2>
	<a href="/sis/tournament/<?=$tournamentID?>"><?=$tournament['name']?></a>
	<div class="icon subsection margin-left margin-right"></div>
	<a href="/sis/signupSelection/<?=$tournamentID?>">Sign Up</a>
	<div class="icon subsection margin-left margin-right"></div>
	<?=$role['name']?>
</h2>
<p>Select a role:</p>
<? 	$counter = 1;
	foreach($roles as $roleID => $role) { 
	$counter++; ?>
<a href="/sis/signupForm/<?=$tournamentID?>/<?=$roleID?>" class="roleButton button <?=($counter%2 ? 'green' : 'red')?>" id="roleButton-<?=$roleID?>"><?=$role['name']?></a>
<? } ?>