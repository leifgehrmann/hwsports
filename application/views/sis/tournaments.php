<? 

// We wish to have all our tournaments sorted by 
// year and placed into groups of the year. we
// do this by putting all the tournaments into
// particular year arrays.
$yearTournaments = array();
foreach($tournaments as $tournament) {
	$date = new DateTime($tournament['tournamentStart']);
	$year = date_format($date,'Y');
	$yearTournaments[$year][] = $tournament;
}
function compareTournamentTime($a, $b) {
	return strtotime($a["tournamentStart"]) - strtotime($b["tournamentStart"]);
}

foreach($yearTournaments as $year){
	usort($year, "compareTournamentTime");
}

?>

<? if(!empty($message)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message;?></p></div><? } ?>
<? if(!empty($message_information)){ ?><div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p><?php echo $message_information;?></p></div><? } ?>
<? if(!empty($message_success)){ ?><div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3><p><?php echo $message_success;?></p></div><? } ?>
<? if(!empty($message_error)){ ?><div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p><?php echo $message_error;?></p></div><? } ?>
<? if(!empty($message_warning)){ ?><div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p><?php echo $message_warning;?></p></div><? } ?>

<h1>Tournaments</h1>

<div class="tournaments-list">
	<? foreach($yearTournaments as $year=>$tournaments) { ?>
		<h2><?=$year?></h2>
		<div>
		<? foreach($tournaments as $tournament) { ?>
			<div class="widget half tournament sportCategoryID-<?=$tournament['sportData']['sportCategoryID']?> sportID-<?=$tournament['sportID']?>">
				<a href="/sis/tournament/<?=$tournament['tournamentID']?>">
					<div class="widget-title">
						<div class="widget-title-left icon"></div>
						<div class="widget-title-centre"><?=$tournament['name']?></div>
						<div class="widget-title-right icon chevron"></div>
					</div>
				</a>
				<div class="widget-body">
					<p><b>Duration:</b> <?=datetime_to_public($tournament['tournamentStart'])?> - <?=datetime_to_public($tournament['tournamentEnd'])?></p>
					<div class="right">
						<a href='/sis/tournament/<?=$tournament['tournamentID']?>' class='button normal'>Details</a>
						<? if($tournament['status']=="inRegistration") { ?>
							<a href='/<?=( $this->ion_auth->logged_in() ? "sis/signup" : "auth/register")?>/<?=$tournament['tournamentID']?>' class='button green'>Sign up!</a>
						<? } ?>
					</div>
				</div>
			</div>
		<? } ?>
		</div>
	<? } ?>
</div>