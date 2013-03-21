<?php
class Scheduling_model extends MY_Model {

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * $tournamentID is int(11)
	 * returns an array of matches if the scheduling went well.
	 * an error string if it didn't go well.
	 * @return an array of matches 
	 **/
	public function schedule_football_family($tournamentID)
	{
		echo "<pre>";

		// Get tournament Information
		$tournament = $this->tournaments_model->get($tournamentID);
		$actors 	= $this->tournaments_model->get_actors($tournamentID);
		$venues 	= $this->tournaments_model->get_venues($tournamentID);

		if($tournament==FALSE)
			return FALSE;

		$tournamentStart     = new DateTime($tournament['tournamentStart']);
		$tournamentEnd       = new DateTime($tournament['tournamentEnd']);

		// Returns an associative array of weekday start times.
		// This is for every day of the week.
		for( $i=0; $i<7; $i++ )
		{
			$weekday = $this->get_weekday_string($i);
			$matchWeekdayStartTimes[$weekday] = ( array_key_exists('startTimes'.$weekday,$tournament) ? explode(',',$tournament['startTimes'.$weekday]) : array() );
		}

		$matchDuration = new DateInterval('PT'.$tournament['matchDuration'].'M'); // Match duration is assumed to be in minutes
		$matchUmpiresBoolean = true; // This is hard coded for now. This is whether we need umpires or not.
		$matchMinimumUmpires = 1; // This is hard coded for now. This is the minimum number of umpires that must be present at a match
		$matchMaximumUmpires = 1; // This is hard coded for now. This is the maximum number of umpires that can be present at a match
		$matchMaximumTeamPlays = 1; // This is hard coded for now. This is the maximum number of matches a player must play
		$matchMaximumPlays = 1; // This is hard coded for now. This is the maximum number of matches that can occur in a day

		$umpires  = $actors['Umpire'];
		$teams    = $actors['Team'];

		foreach($umpires as $index=>$umpire){
			$umpires[$index]['tournamentActorData'] = $this->tournament_actors_model->get($umpire['tournamentActorID']);
		}
		
		// If tournament is round robin...

		// Things to consider
		// * At least n Umpires more be present for a match
		// * Matches should be spread across the tournament time period
		// * Teams should only play n times a day

		// 1. GET ALL POSSIBLE MATCHES
		// 2. FILTER BY UMPIRE AVAILABILITY
		// 3. FILTER BY VENUES (this will create large permutations)
		// 4. 

		// We first want all possible matches datetimes. This method
		// returns all the possible combinations of start times
		// and days of the tournament. From here we need to
		// filter it down by umpires, venues, and team competitions
		$matchDateTimes = $this->get_match_date_times($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration);
		echo "Matches dates "."\n";
		// We now check if an umpire is available for a particular
		// match. It it isn't, we just remove it from the list of choices.
		// For each day...
		foreach( $matchDateTimes as $date=>$dateTimes)
		{
			$dateObject = new DateTime($date); // we need to know what day of the week it is
			$weekday = $dateObject->format('l'); // return the weekday String

			// For each start time...
			// Note: I'm checking each startTime because eventually we
			// maybe want to have umpires specify the HOUR they are available.
			// If we only cared about the weekday, then we woulnd't need to check
			// the starttime for availability. This is just code for future development. 
			foreach( $dateTimes as $dateTime=>$data )
			{
				// keep a list of umpires available for this slot.
				$countedUmpireIDs = array();
				// For each umpire
				foreach( $umpires as $umpire ){
					if( !isset($umpire['tournamentActorData']['available'.$weekday]) )
						continue;
					// is the umpire available at that weekday/time?
					if( $umpire['tournamentActorData']['available'.$weekday] == '1' )
						$countedUmpireIDs[] = $umpire['userID'];
				}
				// Are there enough umpires? Well good! Lets select them!
				// Also, if there aren't enough, we remove the match.

				if(count($countedUmpireIDs) >= $matchMinimumUmpires)
					$matchDateTimes[$date][$dateTime]['umpireIDs'] = $countedUmpireIDs;
				else
					unset($matchDateTimes[$date][$dateTime]);
			}
			// If there are no possible datetimes for this day, remove the entire day
			if(count($matchDateTimes[$date]) == 0)
				unset($matchDateTimes[$date]);
		}
		echo "Matches dates with umpires "."\n";
		var_dump($matchDateTimes);
		// We now check if a venue is occupied with some other match.
		// If it isn't, we say that this particular venue works at the
		// particular time on this particular day.
		foreach($matchDateTimes as $date=>$dateTimes)
		{
			// For each start time
			foreach( $dateTimes as $dateTime=>$data )
			{	
				// Get start and end intervals of the match
				$startDateTime = new DateTime($dateTime);
				$endDateTime = clone $startDateTime;
				$endDateTime->add($matchDuration);

				// keep a list of venues available for this slot.
				$matchDateTimes[$date][$dateTime]['venueIDs'] = array();
				// For each venue
				foreach( $venues as $venue )
				{
					// is the venue available at this time?
					$venueMatches = $this->matches_model->get_venue_matches($venue['venueID'],$startDateTime,$endDateTime);

					if( count($venueMatches) == 0 )
						$matchDateTimes[$date][$dateTime]['venueIDs'][] = $venue['venueID'];
				}
				// If we didn't find any available venues, well then we ignore it.
				if( count($matchDateTimes[$date][$dateTime]['venueIDs']) == 0 )
					unset($matchDateTimes[$date][$dateTime]);
			}
			// If there are no possible datetimes for this day, remove the entire day
			if(count($matchDateTimes[$date]) == 0)
				unset($matchDateTimes[$date]);
		}
		echo "Matches dates "."\n";
		echo "The following days and combinations of dates are being considered: "."\n";
		var_dump($matchDateTimes);

		// We now want to create our individual matches for each
		// combination of matches. We want to make sure that no
		// team exceeds the number of times it can play in a day
		// We also want to have the matches spread out, so they
		// don't occur all at the same time.

		// We need to keep a track of how many matches we keep on
		// a certain day. We also need to know how many matches
		// occur at a particular time.

		$scheduledMatches = array(); // Our list of matches that we would like to output
		$matchDateTimesSelected = array(); // associated array of date->datetime->data. This will be used to check for overlapping events
		$matchUsage = array(); // associated array of dates, datetimes, and various other things
		$umpireUsage = array(); // associative array of umpireID to number of matches he/she already manages.

		// Turn teams into list of teamIDs
		$teamIDs = array();
		foreach($teams as $team) {
			$teamIDs[] = $team['tournamentActorID'];
		}

		// We set the initial count for every single array to be 0.
		foreach($matchDateTimes as $date=>$dateTimes)
		{
			$matchUsage[$date]['count'] = 0;
			foreach($dateTimes as $dateTime=>$data)
			{
				$matchUsage[$date][$dateTime]['count'] = 0;
				foreach($teamIDs as $teamID)
					$matchUsage[$date][$dateTime]['teams'][$teamID]['count'] = 0;
			}
			foreach($teamIDs as $teamID)
				$matchUsage[$date]['teams'][$teamID]['count'] = 0;
		}
		foreach( $umpires as $umpire )
			$umpireUsage[$umpire['userID']] = 0;

		// Assuming for now that we only want round robins for now:
		$combinations = $this->round_robin($teamIDs);
		echo "The following teams combinations are being considered: "."\n";
		var_dump($combinations);
		// For every single combination of a game we want.
		foreach($combinations as $combination)
		{
			$added = false; // This will indicate if we could find a place to put this match in.
			$teamA = $combination[0];
			$teamB = $combination[1];

			// Get list of days ordered by a fitness function that encourages
			// the spread of days in a tournament.
			foreach( $matchUsage as $key => $value )
				if($key!="teams" && $key!="count")
					$matchUsageDates[$key] = $value;
			$weightedDates = $this->fitness_generator($matchUsageDates);
			foreach($weightedDates as $date)
			{
				echo "Attempting to add Event at date ".$date." for teams ".$combination[0]." and ".$combination[1]."\n";
				// Has either team A or team B already played on this day the maximum number of times?
				if($matchMaximumPlays <= $matchUsage[$date]['teams'][$teamA]['count']){
					echo "failed ".$dateTime." because team has already played max number of times"."\n";
					continue;
				}
				if($matchMaximumPlays <= $matchUsage[$date]['teams'][$teamB]['count']){
					echo "failed ".$dateTime." because team has already played max number of times"."\n";
					continue;
				}

				// Now we need to find our the time slot. Again, we use our fitness generator...
				$matchUsageDateTimes = array();
				foreach( $matchUsage[$date] as $key => $value )
					if($key!="teams" && $key!="count")
						$matchUsageDateTimes[$key] = $value;
				$weightedDateTimes = $this->fitness_generator($matchUsageDateTimes);
				foreach($weightedDateTimes as $dateTimeWeight=>$dateTime)
				{
					echo "Attempting to add Event at datetime ".$dateTime."\n";
					// Is this match already conflicting with another match where the 
					// same team is performing (It could be the case that a team can play
					// more than once a day if we ignored the rules above)
					$isOverlapping = false;
					if(array_key_exists($date,$matchDateTimesSelected))
						foreach($matchDateTimesSelected[$date] as $dateTimeSelected=>$dateTimeData)
						{
							// Are any of the teams that we care about actually playing during that time?
							if($matchUsage[$date][$dateTimeSelected]['teams'][$teamA]==0 && $matchUsage[$date][$dateTimeSelected]['teams'][$teamB]==0){
								echo "failed ".$dateTime." because team is already playing at that time"."\n";
								continue;
							}

							// Do these times even overlap?
							$dateTimeObject = new DateTime($dateTime);
							$dateTimeSelectedObject = new DateTime($dateTimeSelected);
							if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeSelectedObject,$matchDuration))
								$isOverlapping = true;
						}
					// If there is a conflict, well we better check another time slot.
					if($isOverlapping){
						echo "failed ".$dateTime." because of overlapping"."\n";
						continue;
					}
					
					// For umpires, we just select the umpire with the lowest 
					// amount of work. Because hey, we can't just give the same
					// person all the work just because he is available.

					// BUT we must also consider that the umpire may be assigned
					// already to another match. so again, we have to check for
					// any overlaps NEVERMIND LET'S LET THE UNSET HANDLE THAT
					// IT IS MUCH EASIER!!!

					// calculate the array of umpires by order of least use (aka, 1 means less busy than 4)
					$u = $matchDateTimes[$date][$dateTime]['umpireIDs']; // array of umpires for this match
					usort($u, function($a, $b)
						{
							global $umpireUsage;
							if($umpireUsage[$a] == $umpireUsage[$b])
								return 0;
							return $umpireUsage[$a] < $umpireUsage[$b] ? -1 : 1;
						});
					$matchUmpireIDs = array();
					for($i=0;$i<count($u);$i++)
					{
						$umpireUsage[$u[$i]] = $umpireUsage[$u[$i]] + 1;
						$matchUmpireIDs[] = $u[$i];
					}

					// We don't really care which venue we choose I guess. If the
					// staff want to dictate priority, we can implement it here
					// at some later point.
					// You know what, lets just RANDOMLY select a venue for fun.
					$matchVenueID = array_rand($matchDateTimes[$date][$dateTime]['venueIDs']);

					// Hey thats it! Let's add our result to the selected array and a list of scheduled matches:
					$newMatch = array();
					$newMatch['startTime'] = $dateTime;
					$endTime = new DateTime($dateTime);
					$endTime->add($matchDuration);
					$newMatch['name'] = $teams[$teamA]['name']." vs ".$teams[$teamB]['name'];
					$newMatch['endTime'] = datetime_to_standard($endTime);
					$newMatch['teams'] = array($teamA,$teamB);
					$newMatch['umpires'] = $matchUmpireIDs;
					$newMatch['venue'] = $matchVenueID;
					$matchDateTimesSelected[$date][$dateTime] = array();
					$matchDateTimesSelected[$date][$dateTime]['teamIDs'] = array($teamA,$teamB);
					$matchDateTimesSelected[$date][$dateTime]['umpireIDs'] = $matchUmpireIDs;
					$matchDateTimesSelected[$date][$dateTime]['venueID'] = $matchVenueID;
					$scheduledMatches[] = $newMatch;

					// Now remove the umpires that we selected, and also remove them from
					// the original available options to avoid conflicting schedules
					//$matchDateTimes[$date][$dateTime]['umpireIDs'] = array_diff( $matchDateTimes[$date][$dateTime]['umpireIDs'], $matchUmpireIDs);
					foreach($matchDateTimes[$date] as $dateTimeAlt=>$dateTimeDataAlt)
					{
						// Do these times even overlap? It should at least once
						$dateTimeObject = new DateTime($dateTime);
						$dateTimeAltObject = new DateTime($dateTimeAlt);
						if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeAltObject,$matchDuration))
						{
							$matchDateTimes[$date][$dateTimeAlt]['umpireIDs'] = array_diff( $matchDateTimes[$date][$dateTimeAlt]['umpireIDs'], $matchUmpireIDs);
							if(count($matchDateTimes[$date][$dateTimeAlt]['umpireIDs'])==0){
								unset($matchUsage[$date][$dateTimeAlt]);
								unset($matchDateTimes[$date][$dateTimeAlt]);
								echo "removed ".$dateTime."\n";
							}
						}
					}
					// Now remove the venue that we selected, and also remove it from
					// the original available options to avoid conflicting schedules
					if(array_key_exists($dateTime,$matchDateTimes[$date]))
					{
						//$matchDateTimes[$date][$dateTime]['venueIDs'] = array_diff( $matchDateTimes[$date][$dateTime]['venueIDs'], array($matchVenueID));
						if(count($matchDateTimes[$date][$dateTime]['venueIDs'])==0)
						{
							unset($matchUsage[$date][$dateTime]);
							unset($matchDateTimes[$date][$dateTime]);
							echo "removed ".$dateTime."\n";
						}
						foreach($matchDateTimes[$date] as $dateTimeAlt=>$dateTimeDataAlt)
						{
							// Do these times even overlap? It should at least once
							$dateTimeObject = new DateTime($dateTime);
							$dateTimeAltObject = new DateTime($dateTimeAlt);
							if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeAltObject,$matchDuration))
							{
								$matchDateTimes[$date][$dateTimeAlt]['venueIDs'] = array_diff( $matchDateTimes[$date][$dateTimeAlt]['venueIDs'], array($matchVenueID));
								if(count($matchDateTimes[$date][$dateTimeAlt]['venueIDs'])==0){
									unset($matchUsage[$date][$dateTimeAlt]);
									unset($matchDateTimes[$date][$dateTimeAlt]);
									echo "removed ".$dateTime."\n";
								}
							}
						}
					}

					// We now need to finally update the statistics
					//$matchDateTimesSelected = array(); // associated array of date->datetime->data. This will be our final result
					$matchUsage[$date]['count'] += 1; // $matchDateUsed[$date] = $matchDateUsed[$date] + 1; 
					$matchUsage[$date]['teams'][$teamA]['count'] += 1; // $matchDateTeam[$date][$teamA] = $matchDateTeam[$date][$teamA] + 1;
					$matchUsage[$date]['teams'][$teamB]['count'] += 1; // $matchDateTeam[$date][$teamB] = $matchDateTeam[$date][$teamB] + 1;
					if(array_key_exists($dateTime,$matchDateTimes[$date]))
					{
						$matchUsage[$date][$dateTime]['count'] += 1; // $matchDateTimeUsed[$dateTime] = $matchDateTimeUsed[$dateTime] + 1;
						$matchUsage[$date][$dateTime]['teams'][$teamA]['count'] += 1; // $matchDateTimeTeam[$date][$dateTime][$teamA] = $matchDateTimeTeam[$date][$dateTime][$teamA] + 1;
						$matchUsage[$date][$dateTime]['teams'][$teamB]['count'] += 1; // $matchDateTimeTeam[$date][$dateTime][$teamB] = $matchDateTimeTeam[$date][$dateTime][$teamB] + 1;
					}

					// Stop the loop! We have just added our match!
					echo "Event was added at ".$dateTime." at the venue ".$matchDateTimesSelected[$date][$dateTime]['venueID']." with the teams ".$matchDateTimesSelected[$date][$dateTime]['teamIDs'][0]." and ".$matchDateTimesSelected[$date][$dateTime]['teamIDs'][1];
					$added = true;
					break;
				}
				// If it wasn't added, we continue the loop of course.
				// but if it was, we would like to move onto the next team combination.
				if($added)
					break;
			}
			// This will only occur if the entire thing above did not work.
			// hopefully that doesn't happen a lot when we do testing. :)
			if(!$added){
				echo "Not enough time slots to support this tournament style";
				return FALSE;
			}
		}

		return $scheduledMatches;

	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * $tournamentID is int(11)
	 * returns true if the scheduling went well.
	 * an error string if it didn't go well.
	 * @return boolean 
	 **/

	public function schedule_running($tournamentID)
	{

		// Get tournament Information
		$tournament = $this->tournaments_model->get_tournament($tournamentID);
		$venues     = $this->tournaments_model->get_venues($tournamentID);
		$actors     = $this->tournaments_model->get_actors($tournamentID);
		$athletes   = $actors['Athlete'];

		$tournamentStart     = new DateTime($tournament['tournamentStart']);
		$tournamentEnd       = new DateTime($tournament['tournamentEnd']);

		// Returns an associative array of weekday start times.
		// This is for every day of the week.
		for( $i=0; $i<7; $i++ )
		{
			$weekday = $this->get_weekday_string($i);
			$matchWeekdayStartTimes[$weekday]    = explode(',',$tournament['startTimes'.$weekday]);
		}

		$matchDuration = new DateInterval('PT'.$tournament['matchDuration'].'M'); // Match duration is assumed to be in minutes
		$matchMaximumPlays   = 1; // This is hard coded for now. This is the maximum number of matches a hurdler must play
		$matchMinimumPlayers = 8; // This is hard coded for now. This is the minimum number of hurdlers that must be playing at once.

		// Calculate number of matches we need
		$numberOfMatches = ceil(log(count($athletes)/$matchMinimumPlayers)/log(2)+1);
		$numberOfMatches += 1; // This takes into account the aulifier round.

		// We first want all possible matches datetimes. This method
		// returns all the possible combinations of start times
		// and days of the tournament. from here we need to filter 
		// by venue.
		$matchDateTimes = $this->get_match_date_times($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration);

		foreach($matchDateTimes as $date=>$dateTimes)
		{
			// For each start time
			foreach( $dateTimes as $dateTime=>$data )
			{	
				// Get start and end intervals of the match
				$startDateTime = new DateTime($dateTime);
				$endDateTime = clone $startDateTime;
				$endDateTime->add($matchDuration);

				// keep a list of venues available for this slot.
				$matchDateTimes[$date][$dateTime]['venueIDs'] = array();
				// For each venue
				foreach( $venues as $venue )
				{
					// is the venue available at this time?
					$venueMatches = $this->matches_model->get_venue_matches($venue['venueID'],$startDateTime,$endDateTime);

					if( count($venueMatches) == 0 )
						$matchDateTimes[$date][$dateTime]['venueIDs'][] = $venue['venueID'];
				}
				// If we didn't find any available venues, well then we ignore it.
				if( count($matchDateTimes[$date][$dateTime]['venueIDs']) == 0 )
					unset($matchDateTimes[$date][$dateTime]);
			}
			// If there are no possible datetimes for this day, remove the entire day
			if(count($matchDateTimes[$date]) == 0)
				unset($matchDateTimes[$date]);
		}

		$scheduledMatches = array(); // Our list of matches that we would like to output
		$matchDateTimesSelected = array(); // associated array of date->datetime->data. This will be used to check for overlapping events
		$matchUsage = array(); // associated array of dates, datetimes, and various other things

		// We set the initial count for every single array to be 0.
		foreach($matchDateTimes as $date=>$dateTimes)
		{
			$matchUsage[$date]['count'] = 0;
			foreach($dateTimes as $dateTime=>$data)
			{
				$matchUsage[$date][$dateTime]['count'] = 0;
			}
		}

		// We now iterate through each possible day and time hopefully finding a day that works out just fine.
		$matchIndex = 0;
		for( $matchIndex = 0; $matchIndex < $numberOfMatches; $matchIndex++ )
		{
			$added = false; // This will indicate if we could find a place to put this match in.
			// Get list of days ordered by a fitness function that encourages
			// the spread of days in a tournament.
			foreach( $matchUsage as $key => $value )
				if( $key!="count")
					$matchUsageDates[$key] = $value;
			$weightedDates = $this->fitness_generator($matchUsageDates);
			foreach($weightedDates as $date)
			{
				echo "Attempting to add Event at date ".$date." for match ".$combination[0]." and ".$combination[1]."\n";

				// Have we already exceeded the number of matches that we can add already?
				if($matchMaximumPlays <= $matchUsage[$date]['count']){
					echo "failed ".$dateTime." because team has already played max number of times"."\n";
					continue;
				}

				// Now we need to find our the time slot. Again, we use our fitness generator...
				$matchUsageDateTimes = array();
				foreach( $matchUsage[$date] as $key => $value )
					if( $key!="count")
						$matchUsageDateTimes[$key] = $value;
				$weightedDateTimes = $this->fitness_generator($matchUsageDateTimes);
				foreach($weightedDateTimes as $dateTimeWeight=>$dateTime)
				{
					echo "Attempting to add Event at datetime ".$dateTime."\n";

					// Is this match already conflicting with another match where the 
					// players are already performing?
					$isOverlapping = false;
					if(array_key_exists($date,$matchDateTimesSelected))
						foreach($matchDateTimesSelected[$date] as $dateTimeSelected=>$dateTimeData)
						{
							// Are any of the teams that we care about actually playing during that time?
							if($matchUsage[$date][$dateTimeSelected]['count']==0){
								echo "failed ".$dateTime." because the hurdlers are already playing at that time but in another venue"."\n";
								continue;
							}

							// Do these times even overlap?
							$dateTimeObject = new DateTime($dateTime);
							$dateTimeSelectedObject = new DateTime($dateTimeSelected);
							if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeSelectedObject,$matchDuration))
								$isOverlapping = true;
						}
					// If there is a conflict, well we better check another time slot.
					if($isOverlapping){
						echo "failed ".$dateTime." because of overlapping"."\n";
						continue;
					}

					// We don't really care which venue we choose I guess. If the
					// staff want to dictate priority, we can implement it here
					// at some later point.
					// You know what, lets just RANDOMLY select a venue for fun.
					$matchVenueID = array_rand($matchDateTimes[$date][$dateTime]['venueIDs']);

					// Hey thats it! Lets add our result to the selected array and a list of scheduled matches:
					$newMatch = array();
					$endTime = new DateTime($dateTime);
					$endTime->add($matchDuration);
					$newMatch['endTime'] = datetime_to_standard($endTime);
					$newMatch['venue'] = $matchVenueID;
					$matchDateTimesSelected[$date][$dateTime] = array();
					$matchDateTimesSelected[$date][$dateTime]['venueID'] = $matchVenueID;
					$scheduledMatches[] = $newMatch;

					// Now remove the venue that we selected, and also remove it from
					// the original available options to avoid conflicting schedules
					if(array_key_exists($dateTime,$matchDateTimes[$date]))
					{
						if(count($matchDateTimes[$date][$dateTime]['venueIDs'])==0)
						{
							unset($matchUsage[$date][$dateTime]);
							unset($matchDateTimes[$date][$dateTime]);
							echo "removed ".$dateTime."\n";
						}
						foreach($matchDateTimes[$date] as $dateTimeAlt=>$dateTimeDataAlt)
						{
							// Do these times even overlap? It should at least once
							$dateTimeObject = new DateTime($dateTime);
							$dateTimeAltObject = new DateTime($dateTimeAlt);
							if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeAltObject,$matchDuration))
							{
								$matchDateTimes[$date][$dateTimeAlt]['venueIDs'] = array_diff( $matchDateTimes[$date][$dateTimeAlt]['venueIDs'], array($matchVenueID));
								if(count($matchDateTimes[$date][$dateTimeAlt]['venueIDs'])==0){
									unset($matchUsage[$date][$dateTimeAlt]);
									unset($matchDateTimes[$date][$dateTimeAlt]);
									echo "removed ".$dateTime."\n";
								}
							}
						}
					}
					// We now need to finally update the statistics
					$matchUsage[$date]['count'] += 1; 
					if(array_key_exists($dateTime,$matchDateTimes[$date]))
						$matchUsage[$date][$dateTime]['count'] += 1;

					// Stop the loop! We have just added our match!
					echo "Event was added at ".$dateTime." at the venue ".$matchDateTimesSelected[$date][$dateTime]['venueID']."\n";
					$added = true;
					break;
				}
				// If it wasn't added, we continue the loop of course.
				// but if it was, we would like to move onto the next team combination.
				if($added)
					break;
			}
			// This will only occur if the entire thing above did not work.
			// hopefully that doesn't happen a lot when we do testing. :)
			if(!$added){
				echo "Not enough time slots to support this tournament style";
				return FALSE;
			}
		}

		// Now that we have scheduled matches, we should quickly
		// change the names of all the matches. To do this in
		// order, we need to sort it.
		usort($scheduledMatches,function ($a, $b)
			{
				$af = $a['startTime'];
				$bf = $b['startTime'];
				if ($af == $bf) return 0;
				return ($af < $bf) ? -1 : 1;
			}
		);

		// We go through each match, renaming it.
		$matchIndex = 0;
		foreach($scheduledMatches as $key=>$match)
		{
			if($matchIndex==0)
				$scheduledMatches[$matchIndex]['name'] = "Qualification Round";
			else
				$scheduledMatches[$matchIndex]['name'] = "Round ".$matchIndex;
			$matchIndex++;
		}

		// Of course, now that we have schedules, we need to plan the 
		// first round, which is the qualification round. What we need
		// to know is which players have no previous performance.

		// So here we somehow get a list of all the performances from
		// the database for each actor (i.e. user/ hurdler)

		// Here we select all the hurdlers that don't have any
		// previous performance.
		$qualificationAthletes = array();
		foreach($athletes as $athlete)
			if(!array_key_exists('personalBest',$athlete)){
				$qualificationAthletes[] = $athlete;
				// Some how we add data to our schedule matches 
				$scheduledMatches[0]['Athlete'][] = $qualificationAthletes;
			}

		// We add these hurdles to the scheduled matches.
		$scheduledMatches[0]['Athlete'] = $qualificationHurdlers;

		// We want to now calculate the number of heats required
		// so that we can put people in certain lanes.
		$venue = $venues[$scheduledMatches['venue']];
		if(array_key_exists('lanes',$venue))
			$lanes = $venue['lanes'];
		else
			$lanes = 8; // We just assume for now that the number of lanes is 8. This probably should be modified.
		$participantsCount = count($qualificationAthletes);
		$heats = ceil($participantsCount/$lanes);
		$index = $participantsCount % $heats;
		$athleteIndex = 0;
		for($h=1;$h<=$heats;$h++)
		{
			for($l=1;$l<=$lanes-($index<$h ? 1 : 0);$l++)
			{
				// Some how we add data to our schedule matches 
				$scheduledMatches[0]['AthleteData'][$qualificationAthletes[$athleteIndex]]['heat'] = $h;
				$scheduledMatches[0]['AthleteData'][$qualificationAthletes[$athleteIndex]]['lane'] = $l;
			}
			$athleteIndex++;
		}

		return $scheduledMatches;
	}

	/**
	 * 
	 * 
	 * @param tournamentID		the tournament to continue
	 * @return return a sequence of updated matches (this can be simply added to add match data)
	 */
	public function schedule_running_continue($tournamentID) {

		// Get the current progress so far. i.e. Find out which
		// match has been completed, then continue to the next
		// round of work.

		$matches = $this->tournaments_model->get_matches($tournamentID);

		// Sort the matches so that they are sorted in chrological order
		usort($matches,function($a, $b)
			{
				if ($a['startTime'] == $b['startTime']) return 0;
				return ($a['startTime'] < $b['startTime']) ? -1 : 1;
			}
		);

		// look through each match and find the first instance where
		// the completed section has not been done.
		$index = NULL;
		foreach($matches as $key=>$match)
			if(array_key_exists('status',$match))
				if( $match['status'] != "completed" ) 
					$index = $key;

		// This will occur if there are no more matches to coninue
		// which sorta means the tournament is over.
		if( $index == NULL ){

			// We probably want to submit tournament update information
			// for instance, who the 3 lucky winners are and the
			// runner ups.

			return "tournament is already complete!";
		}
		
		// Now that we have found the match. We would like to look at
		// the previous match and use the results to get a list of
		// all the players who scored sucessfully. We select those that
		// have actually have a performance record where we will use those
		// people in the next round.
		$athletes = $this->matches_model->get_actors($matches[$index]['matchID']);
		$athletes = $athletes['Athlete'];
		$athletesAll = $this->tournaments_model->get_actors($tournamentID);
		$athletesAll = $athletesAll['Athlete'];
		$athletesPerformed = array();
		foreach($athletes as $athlete)
			if(array_key_exists('performance',$athlete['matchActorData']))
				$athletesPerformed[] = $athlete;

		// If an athlete already has performed, but wasn't in the 
		// qualification round, we would also like to consider them
		if($index==0)
			foreach($athletesAll as $athlete)
				if(array_key_exists('personalBest',$athlete['tournamentActorData']))
					$athletesPerformed[] = $athlete;

		// we now sort the athletes by their performance so that we can
		// put them into position for the next tournament.
		usort($athletesPerformed,function($a, $b)
			{
				if(array_key_exists('matchActorData',$a))
					$af = (float) $a['matchActorData']['performance'];
				else
					$af = (float) $a['tournamentActorData']['personalBest'];
				if(array_key_exists('matchActorData',$b))
					$bf = (float) $b['matchActorData']['performance'];
				else
					$bf = (float) $b['tournamentActorData']['personalBest'];
				if ($af == $bf) return 0;
				return ($af < $bf) ? 1 : -1;
			}
		);

		// Now that we have an ordered array of hurdlers we want to allocate
		// them into lanes for the next match.

		// To do this we get the first match
		$nextMatch = $matches[$index+1];
		$updatedMatches = array();

		// We calculate the numberheats that are needed.
		$venue = $nextMatch['venueData'];
		if(array_key_exists('lanes',$venue))
			$lanes = $venue['lanes'];
		else
			$lanes = 8;
		// First we need to trim the number of participants for this round.
		$newParticipantsCount = ceil(count($athletesPerformed)/(2*$lanes))*$lanes;
		$athletesPerformed = array_slice($athletesPerformed, 0, $newParticipantsCount);

		// We now add the athletes to the new match that we want to update.
		$participantsCount = count($athletesPerformed);
		$heats = ceil($participantsCount/$lanes);
		$index = $participantsCount % $heats;
		$athleteIndex = 0;
		for($h=1;$h<=$heats;$h++)
		{
			for($l=1;$l<=$lanes-($index<$h ? 1 : 0);$l++)
			{
				// Some how we add data to our schedule matches 
				$updatedMatch = $match;
				$updatedMatch['ActorData'][$athletesPerformed[$athleteIndex]['AthleteID']]['heat'] = $h;
				$updatedMatch['ActorData'][$athletesPerformed[$athleteIndex]['AthleteID']]['lane'] = $l;
				$updatedMatches[] = $updatedMatch;
				$athleteIndex++;
				if($athleteIndex==$participantsCount)
					break;
			}
			if($athleteIndex==$participantsCount)
				break;
		}

		return $updatedMatches;
	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * Returns a list of match starts, taking also into account the match length
	 * @param tournamentStart 	A datetime for the start of the tournament
	 * @param tournamentEnd 	A datetime for the end of the tournament
	 * @param matchWeekdayStartTimes 	An array of weekdays, with an array of start time strings HH:MM
	 * @param matchDuration		A dateInterval representing the length of a match
	 * @return array of days, with a sub array of match starts
	 **/
	public function get_match_date_times($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration)
	{	
		// Get list of days
		$dates = $this->get_dates($tournamentStart,$tournamentEnd);

		// If no days exist in this period, well we quit.
		if(count($dates)==0)
			return array();

		// Figure out what the first weekday is. This
		// is to reduce to work of always formatting the dateTime object
		// when we want to know what day of the week it is.
		$weekday = $this->get_weekday_index($dates[0]->format('l'));

		// For every day that the tournament exists in...
		$matchDateTimes = array();
		foreach( $dates as $date )
		{
			$dateString = datetime_to_standard($date);
			// For each possible start time that a match can have on
			// this particular weekday
			if(!array_key_exists($this->get_weekday_string($weekday),$matchWeekdayStartTimes))
				$matchWeekdayStartTimes[$this->get_weekday_string($weekday)] = array();
			foreach( $matchWeekdayStartTimes[ $this->get_weekday_string($weekday) ] as $startTime )
			{
				// Set the datetime object for the match
				// to be a specific hour and minute
				if(!preg_match("|[0-9][0-9]:[0-9][0-9]|",$startTime))
					continue;
				list($startHour,$startMinute) = explode(':', $startTime);
				$startDateTime = clone $date;
				$startDateTime->setTime($startHour, $startMinute, 0);
				$endDateTime = clone $startDateTime;
				$endDateTime->add($matchDuration);
				$dateTimeString = datetime_to_standard($startDateTime);

				// If valid date, add it to our array
				if( $endDateTime < $tournamentEnd )
					if( $tournamentStart <= $startDateTime )
						$matchDateTimes[$dateString][$dateTimeString] = array();

			}
			$weekday = ($weekday + 1) % 7; // increase the weekday index
		}
		return $matchDateTimes;
	}

	/**
	 *
	 * Returns a list of days
	 * @param start A datetime for start
	 * @param end 	A datetime for end
	 * @return array of days in DateTime objects
	 **/
	public function get_dates($start,$end)
	{
		$dates = array();
		$date = clone $start;
		$date->setTime(0, 0, 0);
		while($date <= $end)
		{
			$dates[] = clone $date;
			$date->modify('+1 day');
		}
		return $dates;
	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * Returns the earliest match
	 * @param dates 	An array of matches
	 * @param max 		a datetime string that determines how soon the match should be
	 * @return the index of the earliest match
	 **/
	public function get_earliest_match($matches,$max="0"){
		$min = ":";
		$index = -1;
		foreach($matches as $key=>$match){
			if($max<$match['startTime'])
				continue;
			if($match['startTime']<$min){
				$min = $match['startTime'];
				$index = $key;
			}
		}
	}

	/**
	 * @param items is an array of items. Can be a multidimensional array
	 * of teams for example. 
	 * returns an array of tuples. In which case you probably just
	 * want to just use IDs, not full associative arrays
	 * @return array
	 **/
	public function round_robin($items)
	{	
		$combinations = array();
		$n = count($items);
		for($a=0;$a<($n-1);$a++)
		{	
			/*for($b=0;$b<$a;$b++)
				$combinations[] = array($items[$a],$items[$b]);*/

			for($b=$a+1;$b<$n;$b++)
				$combinations[] = array($items[$a],$items[$b]);
		}
		return $combinations;
	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * This method is used for aligning players such that the items that are ordered on the
	 * left hand side of the array are positioned in the middle, and slower players are
	 * positioned on the outside.
	 *
	 * Note: The input array has to be ordered fastest to slowest. 
	 *
	 * For example, given the array 1,2,3,4,5,6,7
	 * The output of this function will be 6,4,2,1,3,5,7
	 * 
	 * @param items 	is a multi dimensional array of items
	 * @return an ordered array of items
	 **/
	public function alternate_items($items)
	{	
		$x = true;
		$a = array();
		foreach( $items as $item )
		{
			if ( $x )
				$a = array_merge($a,array($item));
			else
				$a = array_merge(array($item),$a);
			$x = !$x;
		}
		return $a;
	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * This method returns an associative array of datetime to a fitness value
	 * 
	 * The fitness value of a particular datetime is:
	 *
	 *     MaxDelta / ( Used + 1 )
	 *
	 * MaxDelta is the time to the datetime with the largest highest allocated matches
	 * Used 	is the number of already allocated matches for this particular datetime
	 *
	 * Note: The input array has to be ordered fastest to slowest. 
	 * 
	 * @param used 	an associative array of datetime (as formatted ISO string) to freqeuncy count
	 * @param maxUsed 	A number that helps increase the speed of this algorithm
	 * @return an ordered array of dates, sorted by fitness (best dates are in the front of the array)
	 **/
	public function fitness_generator($used)
	{
		// If we are lazy we won't do anything fancy
		$order = array();
		$i = 0;
		foreach( $used as $date=>$count )
		{
			$order[$i] = $date;
			$i++;
		}
		// For each date in the $used array we would like to find out the position 
		// of the max count so that we can calculate the delta.

		/*foreach( $index = 0;$index < count($used); $index++ )
		{
			$offset = 0;
			$indexDate = new DateTime($used[$index]);
			$max = ;
			$min
			while( $index + $offset < count($used) || 0 < $index - $offset )
			{
				if($index + $offset < count($used))
				{
					$indexDate = new DateTime($used[$index]);
					$indexDate = 0;
				}
				$offset++;
			}
			// If this is the case, then all days are of equal distribution
			// We want to make sure that the events don't occur at the end
			// have a predisposition 
			if($min==$max)

		}*/
		return $order;
	}
	/**
	 * Check if two date ranges overlap. Takes 4 input parameters, all DateTime objects.
	 * This is really just the improve the readability of these checks, so we don't get mixed up with LT/GT symbols
	 * 
	 * @param startTimeA 	datetime object
	 * @param durationA		date interval
	 * @param startTimeB 	datetime object
	 * @param durationB		date interval
	 * @return bool(true) if B starts before A ends, bool(false) if not
	 **/
	public function is_overlapping( $startTimeA, $durationA, $startTimeB, $durationB ) {

		$endTimeA = clone $startTimeA;
		$endTimeB = clone $startTimeB;
		$endTimeA->add($durationA);
		$endTimeB->add($durationB);

		// Date range A is before B, but A ends after B starts, hence overlapping
		if($startTimeA < $startTimeB && $endTimeA > $startTimeB) return true; 
		// Date range B is before A, but B ends after A starts, hence overlapping
		if($startTimeB < $startTimeA && $endTimeB > $startTimeA) return true; 

		// Date range A is within B, hence overlapping
		if($startTimeA > $startTimeB && $endTimeB > $endTimeA) return true; 
		// Date range B is within A, hence overlapping
		if($startTimeB > $startTimeA && $endTimeA > $endTimeB) return true; 
		// Otherwise, no overlap
		return false;
	}
	/**
	 * Return a value from 0-6, indicating the weekday index
	 * starting from Monday and ending on Sunday.
	 * Can be in the format "Monday", "monday", or "mon".
	 * bool(false) is returned if it isn't a valid weekday
	 * 
	 * @param weekday, a string
	 * @return an integer
	 **/
	public function get_weekday_index($weekday) {
		$weekday = strtolower(substr($weekday, 0, 3));
		$weekdays = array('mon','tue','wed','thu','fri','sat','sun');
		$index = array_search($weekday,$weekdays);
		return $index;
	}
	/**
	 * Returns the weekday string based on an integer.
	 * extra care is made for the index, so that we can
	 * do values greater than 6 and less than 0. 0 returns "Monday", as does 7. -1 returns "Sunday".
	 * 
	 * @param weekday, an integer
	 * @return String weekday
	 **/
	public function get_weekday_string($weekday) {
		$weekdays = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		if($weekday<0)
			$weekday = ($weekday%7+7)%7;
		return $weekdays[$weekday%7];
	}
}