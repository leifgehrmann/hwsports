<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	function is_model_loaded($model)
	{
		$ci =& get_instance();      
		$load_arr = (array) $ci->load;

		$mod_arr = array();
		foreach ($load_arr as $key => $value)
		{
			if (substr(trim($key), 2, 50) == "_ci_models")
				$mod_arr = $value;
		}
		//print_r($mod_arr);die;

		if (in_array($model, $mod_arr))
			return TRUE;

		return FALSE;
	}

    function model($model, $name = '', $db_conn = FALSE)
    {
        if (is_array($model))
        {
            foreach ($model as $file => $object_name)
            {
                // Linear array was passed, be backwards compatible.
                // CI already allows loading models as arrays, but does
                // not accept the model name param, just the file name
                if ( ! is_string($file)) 
                {
                    $file = $object_name;
                    $object_name = NULL;
                }
				
				if($this->is_model_loaded($file)) return;
                parent::model($file, $object_name);
            }
            return;
        }

        // Call the default method otherwise
        parent::model($model, $name, $db_conn);
    }
}

?>