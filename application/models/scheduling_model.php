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
		$this->load->model('tournaments_model');
		$this->load->model('venues_model');
		// Get tournament Information
		$tournament = $this->tournaments_model->get_tournament($tournamentID);

		$tournamentStart     = new DateTime($tournament['tournamentStart']);
		$tournamentEnd       = new DateTime($tournament['tournamentEnd']);
		$matchWeekdayStartTimes = array();
		$matchWeekdayStartTimes['Monday']    = explode(',',$tournament['startTimesMonday']);
		$matchWeekdayStartTimes['Tuesday']   = explode(',',$tournament['startTimesTuesday']);
		$matchWeekdayStartTimes['Wednesday'] = explode(',',$tournament['startTimesWednesday']);
		$matchWeekdayStartTimes['Thursday']  = explode(',',$tournament['startTimesThursday']);
		$matchWeekdayStartTimes['Friday']    = explode(',',$tournament['startTimesFriday']);
		$matchWeekdayStartTimes['Saturday']  = explode(',',$tournament['startTimesSaturday']);
		$matchWeekdayStartTimes['Sunday']    = explode(',',$tournament['startTimesSunday']);

		// Match duraction is assumed to be in minutes
		$matchDuration = new DateInterval('P'.$tournament['matchDuration'].'M');

		$umpireIDs  = explode(',',$tournament['umpires']);
		$teamIDs    = explode(',',$tournament['teams']);
		$venueIDs   = explode(',',$tournament['venues']);

		$umpires = array();
		foreach($umpireIDs as $umpireID)
		{
			$umpires[] = $this->users_model->get_umpire($umpireID);
		}
		$teams = array();
		foreach($teamsIDs as $teamID)
		{
			$teams[] = $this->teams_model->get_team($teamID);
		}
		$venues = array();
		foreach($venueIDs as $venueID)
		{
			$venues[] = $this->venues_model->get_venue($venueID);
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

		// We first want all possible matches times
		$matchStartTimes = $this->get_match_starts($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration);
		
		// We now want to remove all matches where no umpires are available
		$newMatchStartTimes = array();
		foreach($matchStartTimes as $matchStartTime)
		{
			$weekday = $matchStartTime->format('l'); // get the weekday
			// We count the number of umpires that can exist for this startTime
			foreach($umpires as $umpire)
			{
				// is the umpire available at that weekday/time?
				if($umpire['available'.$weekday]=='1')
					$newMatchStartTimes[] = $matchStartTime;
			}
		}
		$matchStartTimes = $newMatchStartTimes;

		// We now check if a venue is occupied with some other match.
		// Note that this increases our possible permutation of matches to
		// check. So this will increase time complexity ALOT
		foreach($matchStartTimes as $matchStartTime)
		{

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
		// For every individual player

		// Get performance of every individual player

		// Put them in a array

		// Sort that array





	}

	/**
	 * HAS NOT BEEN TESTED
	 *
	 * Returns a list of match starts, taking also into account the match length
	 * @param start A datetime for start
	 * @param end 	A datetime for end
	 * @param matchWeekdayStartTimes 	An array of weekdays, with an array of start time strings HH:MM
	 * @param matchDuration		A dateInterval representing the length of a match
	 * @return array of match starts
	 **/
	private function get_match_starts($tournamentStart,$tournamentEnd,$matchWeekdayStartTimes,$matchDuration)
	{	
		$matchStartTimes = array();
		// for each day of the tournament
		$dateIndexEnd = $dateIndex = clone $tournamentStart;
		$dateIndexEnd->add($matchDuration);
		while($dateIndex <= $tournamentEnd)
		{
			$weekday = $dateIndex->format('l'); // get the weekday
			// For each startTime...
			foreach($matchWeekdayStartTimes[$weekday] as $time)
			{
				($hour,$minute) = explode(':', $time);
				$newDate = clone $dateIndex;
				$newDate->setTime($hour, $minute, 0);
				$matchStartTimes[] = $newDate;
			}
			$dateIndex->modify('+1 day');
		}
		return $matchStartTimes;
	}

	/**
	 * @param items is an array of items. Can be a multidimensional array
	 * of teams for example. 
	 * returns an array of tuples. In which case you probably just
	 * want to just use IDs, not full associative arrays
	 * @return array
	 **/
	private function roundrobin($items)
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
	private function alternateItems($items)
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
}