<?php
if (!isset ($_SESSION)) session_start();

require "/home/sports/public_html/scripts/rico/plugins/php/dbClass3.php";
$GLOBALS['oDB'] = new dbClass();
if (! $GLOBALS['oDB']->MySqlLogon("sports_web", "sports_web", "group8") ) die('MySqlLogon failed');

require "/home/sports/public_html/scripts/rico/plugins/php/ricoResponse.php";

$id=isset($_GET["id"]) ? $_GET["id"] : "";
$oXmlResp= new ricoXmlResponse();
$errmsg='';
$query='';
$filters=array();

if (!isset($_SESSION[$id])) {
  $errmsg="Your connection with the server was idle for too long and timed out. Please refresh this page and try again. Your GET id var was $id";
} else {
  $query=$_SESSION[$id];
  if (isset($_SESSION[$id . ".filters"])) $filters=$_SESSION[$id . ".filters"];
  $oXmlResp->SetDbConn($GLOBALS['oDB']);
  $oXmlResp->sendDebugMsgs=true;
  $oXmlResp->convertCharSet=true;
}
$oXmlResp->ProcessQuery($id, $query, $filters, $errmsg);
$oXmlResp=NULL;

$GLOBALS['oDB']->dbClose();
?>