<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Output extends CI_Output
{
 /**
  * Write a Cache File
  *
  * @access    public
  * @return    void
  */
 function _write_cache($output)
 {
  $CI =& get_instance();
  $path = $CI->config->item('cache_path');

  $cache_path = ($path == '') ? APPPATH.'cache/' : $path;

  if ( ! is_dir($cache_path) OR ! is_really_writable($cache_path))
  {
   log_message('error', "Unable to write cache file: ".$cache_path);
   return;
  }

  $uri = $CI->config->item('base_url').
  $CI->config->item('index_page').
  $CI->uri->uri_string();

  $cache_path .= md5($uri);

  if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
  {
   log_message('error', "Unable to write cache file: ".$cache_path);
   return;
  }

  $expire = time() + ($this->cache_expiration * 60);
  $headers = array();

  foreach($this->headers as $header)
  {
   $headers[] = $header[0].(int)(boolean)$header[1];
  }

  $headers = implode("\n", $headers);

  if (flock($fp, LOCK_EX))
  {
   fwrite($fp, $expire .'TS--->'. $headers .'H--->'. $output);
   flock($fp, LOCK_UN);
  }
  else
  {
   log_message('error', "Unable to secure a file lock for file at: ".$cache_path);
   return;
  }
  fclose($fp);
  @chmod($cache_path, FILE_WRITE_MODE);

  log_message('debug', "Cache file written: ".$cache_path);
 }

 /**
  * Update/serve a cached file
  *
  * @access    public
  * @return    void
  */
 function _display_cache(&$CFG, &$URI)
 {
  $cache_path = ($CFG->item('cache_path') == '') ? APPPATH.'cache/' : $CFG->item('cache_path');

  // Build the file path.  The file name is an MD5 hash of the full URI
  $uri = $CFG->item('base_url').
  $CFG->item('index_page').
  $URI->uri_string;

  $filepath = $cache_path.md5($uri);

  if ( ! @file_exists($filepath))
  {
   return FALSE;
  }

  if ( ! $fp = @fopen($filepath, FOPEN_READ))
  {
   return FALSE;
  }

  flock($fp, LOCK_SH);

  $cache = '';
  if (filesize($filepath) > 0)
  {
   $cache = fread($fp, filesize($filepath));
  }

  flock($fp, LOCK_UN);
  fclose($fp);

   // Strip out the embedded timestamp and headers
  $ts = strpos($cache, 'TS--->');
  $h = strpos($cache, 'H--->');
  if ( ! $ts || ! $h ) {
   return FALSE;
  }
  $match = array();
  $match['1'] = substr($cache, 0, $ts);
  $match['2'] = substr($cache, $ts+6, $h-$ts-6);
  $match['0'] = $match['1'].'TS--->'.$match['2'].'H--->';

  // Has the file expired? If so we'll delete it.
  if (time() >= trim(str_replace('TS--->', '', $match['1'])))
  {
   @unlink($filepath);
   log_message('debug', "Cache file has expired. File deleted");
   return FALSE;
  }

  // Extract the headers
  $headers = explode("\n", $match['2']);
  foreach($headers as $header)
  {
   $this->headers[] = array(substr($header, 0, -1), substr($header, -1));
  }
  
  // Display the cache
  $this->_display(str_replace($match['0'], '', $cache));
  log_message('debug', "Cache file is current. Sending it to browser.");
  return TRUE;
 }
} 
?>