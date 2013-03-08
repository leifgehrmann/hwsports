<?php
class Scheduling_model extends CI_Model {

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

		$tournamentStart     = new DateTime($tournament['tournamentStart']);
		$tournamentEnd       = new DateTime($tournament['tournamentEnd']);

		// Returns an associative array of weekday start times.
		// This is for every day of the week.
		for( i=0; i<7; i++ )
		{
			$weekday = $this->get_weekday_string(i);
			$matchWeekdayStartTimes[$weekday]    = explode(',',$tournament['startTimes'.$weekday]);
		}

		$matchDuration = new DateInterval('P'.$tournament['matchDuration'].'M'); // Match duration is assumed to be in minutes
		$matchMinimumUmpires = 1; // This is hard coded for now

		$umpireIDs  = explode(',',$tournament['umpires']);
		$teamIDs    = explode(',',$tournament['teams']);
		$venueIDs   = explode(',',$tournament['venues']);

		$umpires = array();
		foreach($umpireIDs as $umpireID)
		{
			$umpires[] = $this->users_model->get_umpire($umpireID);
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



		// We first want all possible matches times. This method
		// returns all the possible combinations of start times
		// and days of the tournament. From here we need to
		// filter it down by umpires, venues, and team competitions
		$matchStartTimes = $this->get_match_start_times($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration);


		
		// For each day
		foreach( $matchStartTimes as $day=>$startTimes)
		{
			$dayDateTime = new DateTime($day); // we need to know what day of the week it is
			$weekday = $startDateTime->format('l'); // return the weekday String

			// For each start time...
			// Note: I'm checking each startTime because eventually we
			// maybe want to have umpires specify the HOUR they are available.
			// If we only cared about the weekday, then we woulnd't need to check
			// the start time. 
			foreach( $startTimes as $startTime=>$data )
			{
				// keep a list of umpires available for this slot.
				$countedUmpireIDs = array();
				// For each umpire
				foreach( $umpires as $umpire )
					// is the umpire available at that weekday/time?
					if( $umpire['available'.$weekday] == '1' )
						$countedUmpireIDs[] = $umpire['userID'];
				if(count($countedUmpires) > $matchMinimumUmpires)
					$matchStartTimes[$day][$startTime]['umpiresIDs'] = $countedUmpireIDs;
				else
					unset($matchStartTimes[$day][$startTime]);
			}
		}

		

		// We now check if a venue is occupied with some other match.
		// Note that this increases our possible permutation of matches to
		// check. So this will increase time complexity ALOT
		foreach($matchStartTimes as $matchStartTime)
		{
			// For each start time
			foreach( $startTimes as $startTime=>$data )
			{	
				// Get start and end intervals of the match
				$startDateTime = new DateTime($startTime);
				$endDateTime = clone $startDateTime;
				$endDateTime->add($matchDuration);

				// keep a list of venues available for this slot.
				$matchStartTimes[$day][$startTime]['venues'] = array();
				// For each venue
				foreach( $venuesIDs as $venueID )
					// is the venue available at this time?
					$venueMatches = $this->matches_model->get_venue_matches($startDateTime,$endDateTime);
					if( count($venueMatches) != 0 )
						$matchStartTimes[$day][$startTime]['venues'][] = $venueID;
				// If we didn't find any available venues, well then we ignore it.
				if( count($matchStartTimes[$day][$startTime]['venues']) == 0 )
					unset($matchStartTimes[$day][$startTime]);
			}
		}

		// We now want to create our individual matches for each
		// combination of matches. We want to make sure that no
		// team exceeds the number of times it can play in a day
		// We also want to have the matches spread out, so they
		// don't occur all at the same time.



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
	private function get_match_start_times($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration)
	{	
		// Get list of days
		$days = $this->get_days($tournamentStart,$tournamentEnd);

		// If no days exist in this period, well we quit.
		if(count($days)==0)
			return array();

		// Figure out what the first weekday is. This
		// is to reduce to work of always formatting the dateTime object
		// when we want to know what day of the week it is.
		$weekday = $this->get_weekday_index($days[0]->format('l'));

		// For every day that the tournament exists in...
		$startTimes = array();
		foreach( $days as $day )
		{
			$dayString = datetime_to_standard($day);
			// For each possible start time that a match can have on
			// this particular weekday
			foreach( $matchWeekdayStartTimes[ $this->get_weekday_string($weekday) ] as $startTime )
			{
				// Set the datetime object for the match
				// to be a specific hour and minute
				($startHour,$startMinute) = explode(':', $startTime);
				$startDateTime = clone $day;
				$startDateTime->setTime($startHour, $startMinute, 0);
				$endDateTime = clone $startDateTime;
				$endDateTime->add($matchDuration);
				$startDateTimeString = datetime_to_standard($startDateTime);

				// If valid date, add it to our array
				if($endDateTime<$tournamentEnd)
					if($tournamentStart<=$startDateTime)
						$matchStartTimes[$dayString][$startDateTimeString] = array();
			}
			$weekday = ($weekday + 1) % 7; // Increase the weekday index
		}
		return $matchStartTimes;
	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * Returns a list of days
	 * @param start A datetime for start
	 * @param end 	A datetime for end
	 * @return array of match starts
	 **/
	private function get_days($start,$end)
	{
		$days = array();
		$day = clone $start;
		$day->setTime(0, 0, 0);
		while($day <= $end)
		{
			$days[] = $day;
			$day->modify('+1 day');
		}
		return $days
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
	private function round_robin($items)
	{	
		$combinations = array();
		$n = count($items);
		for(a=0;a<(n-1);a++)
		{	
			for(b=0;b<a;b++)
				$combinations[] = array($items[a],$items[a]);

			for(b=a+1;b<(n-1);b++)
				$combinations[] = array($teams[a],$teams[a]);
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
	private function alternate_items($items)
	{	
		$x = true;
		$a = array();
		foreach($items as $item)
		{
			if ( $x )
				a = a + array($item);
			else
				a = array($item) + a;
			$x = !$x;
		}
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
	private function get_weekday_index($weekday)
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
	private function get_weekday_string($weekday)
	{
		$weekdays = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		if($weekday<0)
			$weekday = ($weekday%7+7)%7;
		return $weekdays[$weekday%7];
	}
}