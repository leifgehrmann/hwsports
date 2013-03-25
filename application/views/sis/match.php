<h1><a href="/sis/<?=$match['tournamentData']['tournamentID']?>"><?=$match['tournamentData']['name']?></a><div class="icon subsection"></div><?=$match['name']?></h1>
<div class="widget half match sportCategoryID-<?=$match['sportData']['sportCategoryID']?> sportID-<?=$match['sportID']?>">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Match Details</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<? if(isset($match['description'])) { ?>
		<p><?=$tournament['description']?></p>
		<? } ?>
		<p><b>Date: </b><?=$match['datetime']?></p>
		<p><b>Duration: </b><?=$match['duration']?></p>
	</div>
</div>
<div class="widget half venue?>">
	<div class="widget-title">
		<div class="widget-title-left icon"></div>
		<div class="widget-title-centre">Venue Details</div>
		<div class="widget-title-right icon"></div>
	</div>
	<div class="widget-body">
		<p><b>Name: </b><?=$match['venueData']['name']?></p>
		<? if(isset($match['description'])) { ?>
		<p><b>Directions: </b><?=$match['directions']['datetime']?></p>
		<? } ?>
		<p><a href="http://maps.google.com/maps?q=<?=$match['venueData']['lat']?>,<?=$match['venueData']['lng']?>">View on Google Maps</a></p>
	</div>
</div>