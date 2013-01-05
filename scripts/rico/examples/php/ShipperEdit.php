<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
require "../../plugins/php/dbClass3.php";
require "LoadRicoClient.php";
require "../../plugins/php/ricoLiveGridForms.php";
session_set_cookie_params(60*60);
$GLOBALS['sqltext']='.';
?>
</head>
<body>
<?php
	$oDB = new dbClass();
	if (! $oDB->MySqlLogon("sports_northwind", "sports_northwind", "northwind") ) die('MySqlLogon failed');
	$oForm=new TableEditClass();
	$oForm->SetTableName("shippers");
	$oForm->options["XMLprovider"]="ricoQuery.php";
	$oForm->convertCharSet=true;
	$oForm->options["canAdd"]=1;
	$oForm->options["canEdit"]=1;
	$oForm->options["canDelete"]=1;
	$oForm->options["frozenColumns"]=1;
	$oForm->options["menuEvent"]='click';
	$oForm->options["highlightElem"]='cursorRow';
	
	$oForm->AddEntryFieldW("ShipperID", "ID", "B", "<auto>",50);
	$oForm->AddEntryFieldW("CompanyName", "Company Name", "B", "", 150);
	$oForm->ConfirmDeleteColumn();
	$oForm->SortAsc();
	$oForm->AddEntryFieldW("Phone", "Phone Number", "B", "", 150);

	$oForm->DisplayPage();

	$oDB->dbClose();
?>
</body>
</html>