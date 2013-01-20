<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_Calendar extends MY_Controller {

	function __construct()
	{
		parent::__construct();

	}

	// Input:
	//	* 
	public function getAllMatches() {



		// Should return registration periods

		$this->data['data'] = json_encode(array(
			array(
				'title' => 'Men\'s Hurdling - Preliminary Rounds',
				'start' => mktime(12, 0, 0, 1, 10-3, 2013),
				'end' => mktime(14, 0, 0, 1, 10-3, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Recoba vs. WattBulls',
				'start' => mktime(10, 0, 0, 1, 10-3, 2013),
				'end' => mktime(11, 30, 0, 1, 10-3, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - The Red Cows vs. Hunters',
				'start' => mktime(10, 0, 0, 1, 10-3, 2013),
				'end' => mktime(11, 30, 0, 1, 10-3, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Blue Jays vs. Greens',
				'start' => mktime(14, 0, 0, 1, 10-3, 2013),
				'end' => mktime(15, 30, 0, 1, 10-3, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
					
			// Tuesday
			array(
				'title' => 'Men\'s Hurdling - Round 1',
				'start' => mktime(12, 0, 0, 1, 10-2, 2013),
				'end' => mktime(14, 0, 0, 1, 10-2, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - The Red Cows vs. Greens',
				'start' => mktime(10, 0, 0, 1, 10-2, 2013),
				'end' => mktime(11, 30, 0, 1, 10-2, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Blue Jays vs. Recoba',
				'start' => mktime(10, 0, 0, 1, 10-2, 2013),
				'end' => mktime(11, 30, 0, 1, 10-2, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Hunters vs. WattBulls',
				'start' => mktime(14, 0, 0, 1, 10-2, 2013),
				'end' => mktime(15, 30, 0, 1, 10-2, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),

			// Wednesday
			array(
				'title' => 'Men\'s Hurdling - Round 2',
				'start' => mktime(12, 0, 0, 1, 10-1, 2013),
				'end' => mktime(14, 0, 0, 1, 10-1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - The Red Cows vs. WattBulls',
				'start' => mktime(10, 0, 0, 1, 10-1, 2013),
				'end' => mktime(11, 30, 0, 1, 10-1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Recoba vs. Greens',
				'start' => mktime(14, 0, 0, 1, 10-1, 2013),
				'end' => mktime(15, 30, 0, 1, 10-1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'Wattball - Hunters vs. Blue Jays',
				'start' => mktime(10, 0, 0, 1, 10-1, 2013),
				'end' => mktime(11, 30, 0, 1, 10-1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),

			// Thursday
			array(
				'title' => 'Men\'s Hurdling - Round 3',
				'start' => mktime(12, 0, 0, 1, 10, 2013),
				'end' => mktime(14, 0, 0, 1, 10, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - The Red Cows vs. Blue Jays',
				'start' => mktime(10, 0, 0, 1, 10, 2013),
				'end' => mktime(11, 30, 0, 1, 10, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Recoba vs. Hunters',
				'start' => mktime(14, 0, 0, 1, 10, 2013),
				'end' => mktime(15, 30, 0, 1, 10, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'Wattball - Greens vs. The Red Cows',
				'start' => mktime(10, 0, 0, 1, 10, 2013),
				'end' => mktime(11, 30, 0, 1, 10, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),

			// Friday
			array(
				'title' => 'Men\'s Hurdling - Round 4',
				'start' => mktime(12, 0, 0, 1, 10+1, 2013),
				'end' => mktime(14, 0, 0, 1, 10+1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - The Red Cows vs. Recoba',
				'start' => mktime(10, 0, 0, 1, 10+1, 2013),
				'end' => mktime(11, 30, 0, 1, 10+1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'WattBall - Blue Jays vs. WattBulls',
				'start' => mktime(14, 0, 0, 1, 10+1, 2013),
				'end' => mktime(15, 30, 0, 1, 10+1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),
			array(
				'title' => 'Wattball - Greens vs. Hunters',
				'start' => mktime(10, 0, 0, 1, 10+1, 2013),
				'end' => mktime(11, 30, 0, 1, 10+1, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),

			// Saturday
			array(
				'title' => 'Men\'s Hurdling - Round 5',
				'start' => mktime(12, 0, 0, 1, 10+2, 2013),
				'end' => mktime(14, 0, 0, 1, 10+2, 2013),
				'allDay' => false,
				'color' => '#2966C7'
			),

			// Tournaments
			array(
				'title' => 'Heriot Watt Tournament 2013',
				'start' => mktime(0, 0, 0, 1, 10-3, 2013),
				'end' => mktime(0, 0, 0, 1, 10+2, 2013),
				'color' => '#5AB128'
			),

			// Registration times
			array(
				'title' => 'WattBall Registration Period',
				'start' => mktime(0, 0, 0, 1, 10-30, 2013),
				'end' => mktime(0, 0, 0, 1, 10-5, 2013),
				'color' => '#EA472C'
			),
			array(
				'title' => 'Heriot Hurdling Registration Period',
				'start' => mktime(0, 0, 0, 1, 10-30, 2013),
				'end' => mktime(0, 0, 0, 1, 10-7, 2013),
				'color' => '#EA472C'
			)
		));
		header('Content-Type: application/json');
		$this->load->view('data',$this->data);
	}
	public function getVenueMatches($venueID){

	}
	public function getTournamentMatches($tournamentID){
		// Should return registration periods
	}




	public function get
}