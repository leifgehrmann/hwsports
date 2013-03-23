<? 
$this->method_call =& get_instance();


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
					<p><?=$tournament['description']?></p>
					<p><b>Starts:</b> <?=$this->method_call->datetime_to_public_date($tournament['tournamentStart'])?></p>
					<p><b>End:</b> <?=$this->method_call->datetime_to_public_date($tournament['tournamentEnd'])?></p>
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