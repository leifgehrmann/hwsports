<?php
class Db_venues extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('venues_model');
	}

	/*

		Andrew is probably going to read this and go... WTF is Leif
		DOING??? Well Andrew, I'm creating a controller than can be
		used via jQuery. This will hopefully make interactions much
		easier to handle by offering JSON I/O with client/server.

		Example, if the user wants to change the name or any other 
		field, they would have to reload the page to see their updates.
		If we instead use jQuery, the database can be updated immedietly
		and not annoy the customer.
		
		
		We need to make sure that every function cannot be accessed
		from users who do not have to correct creditials. This can
		be done using ion-auth (checking if they are admin or staff
		and if they are at the correct centre).

		

	*/

	public function get_venues($centreID)
	{

	}


	public function insert_venue($centreID)
	{

	}

	public function update_venue($venueID, $data){

	}
}