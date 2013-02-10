<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input {

    function post($index = '', $xss_clean = FALSE)
    {
        // this will be true if post() is called without arguments 
        if($index === '')
        {
            return ($_SERVER['REQUEST_METHOD'] === 'POST');
        }
        
        // otherwise do as normally
        return parent::post($index, $xss_clean);
    }
} 

?>