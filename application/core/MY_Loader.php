<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	function is_model_loaded($model) {
		echo "is_model_loaded checking for model: $model in array:<br /><pre>";var_dump($this);echo "</pre>"; 
		
		if (in_array($model, $this->_ci_models))
			return TRUE;

		return FALSE;
	}

	function model($model, $name = '', $db_conn = FALSE) {
		if($name=='test')
			die();
		if($this->is_model_loaded($model)) {
			//echo "model $model already loaded, skipping<br />\n"; 
			return;
		} 
		
		// echo "model $model being loaded for the first time"; 

		// Call the default method otherwise
		parent::model($model, $name."test", $db_conn);
	}
}

?>