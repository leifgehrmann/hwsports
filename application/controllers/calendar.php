<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends MY_Controller {

	function __construct()
	{
		parent::__construct();

	}
	public function getAllMatches()
	{
		$this->data['data'] = <<<EOF
		[

				// Matches

					// Monday
					{
						title: 'Men\'s Hurdling - Preliminary Rounds',
						start: new Date(y, m, d-3, 12, 0),
						end:   new Date(y, m, d-3, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - Recoba vs. WattBulls',
						start: new Date(y, m, d-3, 10, 0),
						end:   new Date(y, m, d-3, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - The Red Cows vs. Hunters',
						start: new Date(y, m, d-3, 10, 0),
						end:   new Date(y, m, d-3, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Blue Jays vs. Greens',
						start: new Date(y, m, d-3, 14, 0),
						end:   new Date(y, m, d-3, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					

					// Tuesday
					{
						title: 'Men\'s Hurdling - Round 1',
						start: new Date(y, m, d-2, 12, 0),
						end:   new Date(y, m, d-2, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - The Red Cows vs. Greens',
						start: new Date(y, m, d-2, 10, 0),
						end:   new Date(y, m, d-2, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Blue Jays vs. Recoba',
						start: new Date(y, m, d-2, 10, 0),
						end:   new Date(y, m, d-2, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Hunters vs. WattBulls',
						start: new Date(y, m, d-2, 14, 0),
						end:   new Date(y, m, d-2, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},

					// Wednesday

					{
						title: 'Men\'s Hurdling - Round 2',
						start: new Date(y, m, d-1, 12, 0),
						end:   new Date(y, m, d-1, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - The Red Cows vs. WattBulls',
						start: new Date(y, m, d-1, 10, 0),
						end:   new Date(y, m, d-1, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Recoba vs. Greens',
						start: new Date(y, m, d-1, 14, 0),
						end:   new Date(y, m, d-1, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'Wattball - Hunters vs. Blue Jays',
						start: new Date(y, m, d-1, 10, 0),
						end:   new Date(y, m, d-1, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/'
					},

					// Thursday

					{
						title: 'Men\'s Hurdling - Round 3',
						start: new Date(y, m, d, 12, 0),
						end:   new Date(y, m, d, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - The Red Cows vs. Blue Jays',
						start: new Date(y, m, d, 10, 0),
						end:   new Date(y, m, d, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Recoba vs. Hunters',
						start: new Date(y, m, d, 14, 0),
						end:   new Date(y, m, d, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'Wattball - Greens vs. The Red Cows',
						start: new Date(y, m, d, 10, 0),
						end:   new Date(y, m, d, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/'
					},

					// Friday
					{
						title: 'Men\'s Hurdling - Round 4',
						start: new Date(y, m, d+1, 12, 0),
						end:   new Date(y, m, d+1, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},
					{
						title: 'WattBall - The Red Cows vs. Recoba',
						start: new Date(y, m, d+1, 10, 0),
						end:   new Date(y, m, d+1, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'WattBall - Blue Jays vs. WattBulls',
						start: new Date(y, m, d+1, 14, 0),
						end:   new Date(y, m, d+1, 15, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/2'
					},
					{
						title: 'Wattball - Greens vs. Hunters',
						start: new Date(y, m, d+1, 10, 0),
						end:   new Date(y, m, d+1, 11, 30),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/'
					},

					// Saturday
					{
						title: 'Men\'s Hurdling - Round 5',
						start: new Date(y, m, d+2, 12, 0),
						end:   new Date(y, m, d+2, 14, 0),
						allDay: false,
						color: '#2966C7',
						url: '/sis/match/1'
					},


				// Tournaments

				{
					title: 'Heriot Watt Tournament 2013',
					start: new Date(y, m, d-3),
					end: new Date(y, m, d+2),
					color: '#5AB128',
					url: '/sis/tournament/1'
				},


				// Registration times

				{
					title: 'WattBall Registration Period',
					start: new Date(y, m, d-30),
					end: new Date(y, m, d-5),
					color: '#EA472C'
				},
				{
					title: 'Heriot Hurdling Registration Period',
					start: new Date(y, m, d-30),
					end: new Date(y, m, d-7),
					color: '#EA472C'
				}
			]
		
EOF;
		$this->load->view('data',$this->data);
	}
}