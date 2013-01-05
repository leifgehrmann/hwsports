<?php
if (!isset ($_SESSION)) session_start();

require "/home/sports/public_html/scripts/rico/plugins/php/ricoResponse.php";

$id=isset($_GET["id"]) ? $_GET["id"] : "";
$oXmlResp= new ricoXmlResponse();
$errmsg='';
$query='';
$filters=array();

if (!isset($_SESSION[$id])) {
  $errmsg="Your connection with the server was idle for too long and timed out. Please refresh this page and try again.";
} else {
  $query=$_SESSION[$id];
  if (isset($_SESSION[$id . ".filters"])) $filters=$_SESSION[$id . ".filters"];
  $oXmlResp->SetDbConn($oDB);
  $oXmlResp->sendDebugMsgs=true;
  $oXmlResp->convertCharSet=true;  // MySQL sample database is encoded with ISO-8859-1
}
$oXmlResp->ProcessQuery($id, $query, $filters, $errmsg);
$oXmlResp=NULL;

?>