<?php

require "/home/sports/public_html/scripts/rico/plugins/php/dbClass3.php";
$GLOBALS['oDB'] = new dbClass();
if (! $GLOBALS['oDB']->MySqlLogon("sports_web", "sports_web", "group8") ) die('MySqlLogon failed');

require "/home/sports/public_html/scripts/rico/plugins/php/ricoResponse.php";

$id=isset($_GET["id"]) ? $_GET["id"] : "";
$oXmlResp= new ricoXmlResponse();
$errmsg='';
$query='';
$filters=array();

//if (!isset($_SESSION[$id])) {
//  $errmsg="Session error. Please reload page. Your GET id var was $id and SESSION is ";
print_r($_SESSION); die();
/*} else {
  $oXmlResp->SetDbConn($GLOBALS['oDB']);
  $oXmlResp->sendDebugMsgs=true;
  $oXmlResp->convertCharSet=true;
}*/
$oXmlResp->ProcessQuery($id, $query, $filters, $errmsg);
$oXmlResp=NULL;

$GLOBALS['oDB']->dbClose();
?>