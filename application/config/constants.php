<?php  
// Leif: I turned this off because it poses no risk.
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


// Herp derp date times
define('PUBLIC_TIME_FORMAT', "H:i"); 				// Our time representation that should be displayed on websites
define('PUBLIC_DATE_TIME_FORMAT', "Y-m-d @ H:i"); 	// Our datetime representation that should be displayed on websites
define('PUBLIC_DATE_FORMAT', "Y-m-d"); 				// Our date representation that should be displayed on websites
define('DATE_FORMAT', "Y-m-d"); 					// Our database representation for dates
define('DATE_TIME_FORMAT', DateTime::ISO8601); 		// Our database representation for time (and date)
define('DATE_TIME_UNIX_FORMAT', "U"); 				// This is for fullcalendar

/* End of file constants.php */
/* Location: ./application/config/constants.php */