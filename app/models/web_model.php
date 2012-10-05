<?php
class map_model extends CI_Model {

	public function __construct()
	{
		
	}
	
	public function get_info($id) {
		$output = '';
		
		// Build SQL query to get outlet information for all selected types
		$sql = "SELECT * FROM outlets_info,outlets WHERE outlets.outlet_id = $id AND outlets.outlet_id = outlets_info.outlet_id";
		$query = $this->db->query($sql);
		$row = $query->result_array();
		$row = $row[0];
		
		return $output;
	}
}
?>
