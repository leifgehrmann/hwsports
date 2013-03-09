<?php
class Scheduling_model extends MY_Model {

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * $tournamentID is int(11)
	 * returns true if the scheduling went well.
	 * an error string if it didn't go well.
	 * @return boolean 
	 **/
	public function schedule_football_family($tournamentID)
	{
		$this->load->model('users_model');
		$this->load->model('matches_model');
		$this->load->model('tournaments_model');

		// Get tournament Information
		$tournament = $this->tournaments_model->get_tournament($tournamentID);

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
		$matchMaximumPlays = 1; // This is hard coded for now. This is the maximum number of matches a player must play


		$umpireIDs  = explode(',',$tournament['umpireIDs']);
		$teamIDs    = explode(',',$tournament['teamIDs']);
		$venueIDs   = explode(',',$tournament['venueIDs']);

		$umpires = array();
		foreach($umpireIDs as $umpireID)
		{
			$umpires[] = $this->users_model->get_user($umpireID);
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
		var_dump($tournamentStart);
		var_dump($tournamentEnd);
		var_dump($matchWeekdayStartTimes);
		$matchDateTimes = $this->get_match_date_times($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration);

		var_dump($matchDateTimes);
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
					var_dump($umpire);
					// is the umpire available at that weekday/time?
					if( $umpire['available'.$weekday] == '1' )
						$countedUmpireIDs[] = $umpire['userID'];
				}
				// Are there enough umpires? Well good! Lets select them!
				// Also, if there aren't enough, we remove the match.
				if(count($countedUmpireIDs) > $matchMinimumUmpires)
					$matchDateTimes[$date][$dateTime]['umpireIDs'] = $countedUmpireIDs;
				else
					unset($matchDateTimes[$date][$dateTime]);
			}
			if(count($matchDateTimes[$date]) == 0)
				unset($matchDateTimes[$date]);
		}
		var_dump($matchDateTimes);
		die();

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
				foreach( $venuesIDs as $venueID )
				{
					// is the venue available at this time?
					$venueMatches = $this->matches_model->get_venue_matches($startDateTime,$endDateTime);
					if( count($venueMatches) != 0 )
						$matchDateTimes[$date][$dateTime]['venueIDs'][] = $venueID;
				}
				// If we didn't find any available venues, well then we ignore it.
				if( count($matchDateTimes[$date][$dateTime]['venueIDs']) == 0 )
					unset($matchDateTimes[$date][$dateTime]);
			}
		}

		// We now want to create our individual matches for each
		// combination of matches. We want to make sure that no
		// team exceeds the number of times it can play in a day
		// We also want to have the matches spread out, so they
		// don't occur all at the same time.

		// We need to keep a track of how many matches we keep on
		// a certain day. We also need to know how many matches
		// occur at a particular time.

		$matchDateTimesSelected = array(); // associated array of date->datetime->data. This will be our final result
		$matchDateUsed     = array(); // associative array of date to number of matches on that day
		$matchDateTimeUsed = array(); // associative array of date->datetime to number of matches during that slot
		$matchDateTeam     = array(); // associative array of date->team to number of matches on that day
		$matchDateTimeTeam = array(); // associative array of date->datetime->team to number of matches during that slot
		$umpireCount = array(); // associative array of umpireID to number of matches he/she already manages.
		$matchDateUsedMax = 0;

		// We set the initial count for every single array to be 0.
		foreach($matchDateTimes as $date=>$dateTimes)
		{
			$matchDateUsed[$date] = 0;
			foreach($dateTimes as $dateTime=>$data)
			{
				$matchDateUsed[$date][$dateTime] = 0;
				foreach($teamIDs as $teamID)
					$matchDateTeam[$date][$dateTime][$teamID] = 0;
			}
			foreach($teamIDs as $teamID)
				$matchDateTeam[$date][$teamID] = 0;
		}
		foreach( $umpires as $umpire )
			$matchUmpire[$umpire['userID']] = 0;

		// Assuming for now that we only want round robins for now:
		$combinations = $this->round_robin($teamIDs);

		// For every single combination of a game we want.
		foreach($combinations as $combination)
		{
			$added = false; // This will indicate if we could find a place to put this match in.
			$teamA = $combination[0];
			$teamB = $combination[1];

			// Get list of days ordered by a fitness function that encourages
			// the spread of days in a tournament.
			$optimallySortedDates = $this->fitness_generator($matchDateUsed);
			foreach($optimallySortedDates as $date)
			{
				// Has either team A or team B already played on this day the maximum number of times?
				if($matchMaximumPlays <= $matchDateTeam[$date][$teamA])
					continue;
				if($matchMaximumPlays <= $matchDateTeam[$date][$teamB])
					continue;

				// Now we need to find our the time slot. Again, we use our fitness generator...
				// we use -1 to indicate that we don't know the maximum. We could probably find
				// out, but I'm to lazy to code it here. 
				$weightedDateTimes = $this->fitness_generator($matchDateTimeUsed[$date]);
				foreach($weightedDateTimes as $dateTimeWeight=>$dateTime)
				{
					// Is this match already conflicting with another match where the 
					// same team is performing (It could be the case that a team can play
					// more than once a day if we ignored the rules above)
					$isOverlapping = false;
					foreach($matchDateTimesSelected[$date] as $dateTimeSelected=>$dateTimeData)
					{
						// Are any of the teams that we care about actually playing during that time?
						if($matchDateTimeTeam[$date][$dateTimeSelected][$teamA]==0 && $matchDateTimeTeam[$date][$dateTimeSelected][$teamB]==0)
							continue;

						// Do these times even overlap?
						$dateTimeObject = new DateTime($dateTime);
						$dateTimeSelectedObject = new DateTime($dateTimeSelected);
						if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeSelectedObject,$matchDuration))
							$isOverlapping = true;
					}
					// If there is a conflict, well we better check another time slot.
					if($isOverlapping)
						continue;
					
					// For umpires, we just select the umpire with the lowest 
					// amount of work. Because hey, we can't just give the same
					// person all the work just because he is available.

					// BUT we must also consider that the umpire may be assigned
					// already to another match. so again, we have to check for
					// any overlaps NEVERMIND LET'S LET THE UNSET HANDLE THAT
					// IT IS MUCH EASIER!!!

					// First the array of umpires by order of least use (aka, 1 means less busy than 4)
					$u = $matchDateTimes[$date][$dateTime]['umpireIDs']; // array of umpires for this match
					usort($u, function($a, $b)
						{
							if($umpireCount[$a] == $umpireCount[$b])
								return 0;
							return $umpireCount[$a] < $umpireCount[$b] ? -1 : 1;
						});
					$matchUmpireIDs = array();
					for($i=0;$i<count($u);$i++)
					{
						$umpireCount[$u[$i]] = $umpireCount[$u[$i]] + 1;
						$matchUmpireIDs[] = $u[$i];
					}

					// We don't really care which venue we choose I guess. If the
					// staff want to dictate priority, we can implement it here
					// at some later point.
					// You know what, lets just RANDOMLY select a venue for fun.
					$matchVenueID = array_rand($matchDateTimes[$date][$dateTime]['venueIDs']);



					// Hey thats it! Let's add our result to the selected array:
					$matchDateTimesSelected[$date][$dateTime] = array();
					$matchDateTimesSelected[$date][$dateTime]['teamIDs'] = array($teamA,$teamB);
					$matchDateTimesSelected[$date][$dateTime]['umpireIDs'] = $matchUmpireIDs;
					$matchDateTimesSelected[$date][$dateTime]['venueID'] = $matchVenueID;
					$added = true;
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
							if(count($matchDateTimes[$date][$dateTimeAlt]['umpireIDs'])==0)
								unset($matchDateTimes[$date][$dateTimeAlt]);
						}
					}
					// Now remove the venue that we selected, and also remove it from
					// the original available options to avoid conflicting schedules
					//$matchDateTimes[$date][$dateTime]['venueIDs'] = array_diff( $matchDateTimes[$date][$dateTime]['venueIDs'], array($matchVenueID));
					if(count($matchDateTimes[$date][$dateTime]['venueIDs'])==0)
						unset($matchDateTimes[$date][$dateTime]);
					foreach($matchDateTimes[$date] as $dateTimeAlt=>$dateTimeDataAlt)
					{
						// Do these times even overlap? It should at least once
						$dateTimeObject = new DateTime($dateTime);
						$dateTimeAltObject = new DateTime($dateTimeAlt);
						if($this->is_overlapping($dateTimeObject,$matchDuration,$dateTimeAltObject,$matchDuration))
						{
							$matchDateTimes[$date][$dateTimeAlt]['venueIDs'] = array_diff( $matchDateTimes[$date][$dateTimeAlt]['venueIDs'], array($matchVenueID));
							if(count($matchDateTimes[$date][$dateTimeAlt]['venueIDs'])==0)
								unset($matchDateTimes[$date][$dateTimeAlt]);
						}
					}

					// We now need to finally update the statistics
					$matchDateTimesSelected = array(); // associated array of date->datetime->data. This will be our final result
					$matchDateUsed[$date] = $matchDateUsed[$date] + 1; 
					$matchDateTimeUsed[$dateTime] = $matchDateTimeUsed[$dateTime] + 1; 
					$matchDateTeam[$date][$teamA] = $matchDateTeam[$date][$teamA] + 1;
					$matchDateTeam[$date][$teamB] = $matchDateTeam[$date][$teamB] + 1;
					$matchDateTimeTeam[$date][$dateTime][$teamA] = $matchDateTimeTeam[$date][$dateTime][$teamA] + 1;
					$matchDateTimeTeam[$date][$dateTime][$teamB] = $matchDateTimeTeam[$date][$dateTime][$teamB] + 1;
					if( $matchDateUsedMax < $matchDateUsed[$date] )
						$matchDateUsedMax = $matchDateUsed[$date];

					// Stop the loop! We have just added our match!
					break;
				}
				// If it wasn't added, we continue the loop of course.
				// but if it was, we would like to move onto the next team combination.
				if($added)
					break;
			}
			// This will only occur if the entire thing above did not work.
			// hopefully that doesn't happen a lot when we do testing. :)
			if(!$added)
				return "Not enough time slots to support this tournament style";
		}


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
		$this->load->model('users_model');
		$this->load->model('matches_model');
		$this->load->model('tournaments_model');

		// Get tournament Information
		$tournament = $this->tournaments_model->get_tournament($tournamentID);

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
		$matchMinimumUmpires = 1; // This is hard coded for now. This is the minimum number of umpires that must be present at a match
		$matchMaximumPlays = 1; // This is hard coded for now. This is the maximum number of matches a player must play

		$umpireIDs  = explode(',',$tournament['umpires']);
		$teamIDs    = explode(',',$tournament['teams']);
		$venueIDs   = explode(',',$tournament['venues']);

		$umpires = array();
		foreach($umpireIDs as $umpireID)
		{
			$umpires[] = $this->users_model->get_umpire($umpireID);
		}
		// Calculate number of matches we need

		// For every individual player

		// Get performance of every individual player

		// Put them in a array

		// Sort that array





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
	 * HAS NOT BEEN TESTED
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
	 * HAS NOT BEEN TESTED
	 *
	 * are these two events overlapping?
	 * 
	 * @param startTimeA 	datetime object
	 * @param durationA 	datetime object
	 * @param startTimeB 	datetime object
	 * @param durationB 	datetime object
	 * @return boolean
	 **/
	public function is_overlapping( $startTimeA, $durationA, $startTimeB, $durationB )
	{
		// 
		$endTimeA = clone $startTimeA;
		$endTimeB = clone $startTimeB;
		$endTimeA->add($durationA);
		$endTimeB->add($durationB);
		
		if($endTimeA < $startTimeB || $endTimeB < $startTimeA)
			return false;
		return true;
	}
	/**
	 * HAS NOT BEEN TESTED
	 *
	 * Return a value from 0-6, indicating the weekday index
	 * starting from Monday and ending on sunday.
	 * -1 is returned if it isn't a valid weekday
	 * 
	 * @param weekday, a string
	 * @return an integer
	 **/
	public function get_weekday_index($weekday)
	{
		$weekday = strtolower(substr($weekday, 0, 3));
		$weekdays = array('mon','tue','wed','thu','fri','sat','sun');
		$index = array_search($weekday,$weekdays);
		return $index;
	}
	/**
	 * HAS NOT BEEN TESTED
	 *
	 * Returns the weekday string based on an integer.
	 * extra care is made for the index, so that we can
	 * do values greater than 6 and less than  0
	 * 
	 * @param weekday, an integer
	 * @return a string
	 **/
	public function get_weekday_string($weekday)
	{
		$weekdays = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		if($weekday<0)
			$weekday = ($weekday%7+7)%7;
		return $weekdays[$weekday%7];
	}
}