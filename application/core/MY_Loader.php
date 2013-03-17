<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	function is_model_loaded($model) {
		echo "is_model_loaded checking for model: $model in array:<br /><pre>";var_dump($this->_ci_models,1); 
		
		if (in_array($model, $mod_arr))
			return TRUE;

		return FALSE;
	}

    function model($model, $name = '', $db_conn = FALSE) {
		if($this->is_model_loaded($model)) {
			//echo "model $model already loaded, skipping<br />\n"; 
			return;
		} else {
			echo "model $model being loaded for the first time"; 
		}
        // Call the default method otherwise
        parent::model($model, $name, $db_conn);
    }
}

?>