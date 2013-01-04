<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

		$centreSite = TRUE;
		switch($_SERVER['HTTP_HOST']) {
			case "hwsports.co.uk":
				$this->data['slug'] = "hwsports";
				$this->config->set_item('base_url','http://hwsports.co.uk/');
			break;
			case "infusionsports.co.uk":
				$centreSite = FALSE;
				$this->data['slug'] = "product";
				$this->config->set_item('base_url','http://infusionsports.co.uk/');
			break;
			default:
				redirect('http://infusionsports.co.uk');
		}
		
		if($centreSite) {
			// Get Sports Centre ID from slug/domain
			$query = $this->db->query("SELECT `centreID` FROM `centreData` WHERE `key` = 'slug' AND `value` = '{$this->data['slug']}' LIMIT 1");
			$row = $query->row_array(); $this->data['centre']['id'] = $row['centreID'];

			// Get centre data
			$query = $this->db->query("SELECT " .
				"MAX(CASE WHEN `key`='name' THEN value END ) AS name, " .
				"MAX(CASE WHEN `key`='address' THEN value END ) AS address, " .
				"MAX(CASE WHEN `key`='legalText' THEN value END ) AS legalText, " .
				"MAX(CASE WHEN `key`='shortName' THEN value END ) AS shortName " .
				"FROM centreData WHERE centreID = {$this->data['centre']['id']}"
			);
			// Make all centre data accessible from all controllers and views
			$this->data['centre'] = array_merge($this->data['centre'], $query->row_array());
		}
			
    }
}

?>