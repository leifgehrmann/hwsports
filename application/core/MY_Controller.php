<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

		
		$centreSite = TRUE;
		switch($_SERVER['HTTP_HOST']) {
			case "hwsports.co.uk":
				$this->data['slug'] = "hwsports";
			break;
			case "infusionsports.co.uk":
				$centreSite = FALSE;
				$this->data['slug'] = "product";
			break;
			default:
				redirect('http://infusionsports.co.uk');
		}
		
		if($centreSite) {
			// Get Sports Centre ID from slug/domain
			$query = $this->db->query("SELECT `centreID` FROM `centreData` WHERE `key` = 'slug' AND `value` = '{$this->data['slug']}' LIMIT 1");
			$row = $query->row_array();
				
			// Give us access to centre database methods
			$this->load->model('centre_model');
			
			// Make all centre data accessible from all controllers and views
			$this->data['centre'] = $this->centre_model->get_centre( $row['centreID'] );
		}	
		
		
		function obj2arr($obj) {
			if(is_object($obj)) $obj = (array) $obj;
			if(is_array($obj)) {
				$new = array();
				foreach($obj as $key => $val) {
					$new[$key] = obj2arr($val);
				}
			}
			else $new = $obj;
			return $new;       
		}
			
		function datetime_to_standard($inDateTime) {
			if(empty($inDateTime)) return '';
			if(is_object($inDateTime)) return $inDateTime->format(DATE_TIME_FORMAT);
			$dateTime = new DateTime($inDateTime);
			return $dateTime->format(DATE_TIME_FORMAT);
		}
		function datetime_to_unix($inDateTime) {
			if(empty($inDateTime)) return '';
			if(is_object($inDateTime)) return $inDateTime->format(DATE_TIME_UNIX_FORMAT);
			$dateTime = new DateTime($inDateTime);
			return $dateTime->format(DATE_TIME_UNIX_FORMAT);
		}
		function datetime_to_public($inDateTime) {
			if(empty($inDateTime)) return '';
			if(is_object($inDateTime)) return $inDateTime->format(PUBLIC_DATE_TIME_FORMAT);
			$dateTime = new DateTime($inDateTime);
			return $dateTime->format(PUBLIC_DATE_TIME_FORMAT);
		}
		
    }
}

?>