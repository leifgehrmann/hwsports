<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
require "dbConnect.php";
require "LoadRicoClient.php";
require "../../plugins/php/ricoLiveGridForms.php";
?>
<link href="../demo.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
if (OpenGridForm("", "shippers")) {
  if ($oForm->action == "table") {
    DisplayTable();
  }
  else {
    DefineFields();
  }
} else {
  echo 'open failed';
}
CloseApp();

function DisplayTable() {
  global $oForm,$oDB;
  
  $oForm->options["frozenColumns"]=1;
  $oForm->options["menuEvent"]='click';
  $oForm->options["highlightElem"]='cursorRow';
  DefineFields();
}

function DefineFields() {
  global $oForm,$oDB;

  $oForm->AddEntryFieldW("ShipperID", "ID", "B", "<auto>",50);
  $oForm->AddEntryFieldW("CompanyName", "Company Name", "B", "", 150);
  $oForm->ConfirmDeleteColumn();
  $oForm->SortAsc();
  $oForm->AddEntryFieldW("Phone", "Phone Number", "B", "", 150);

  $oForm->DisplayPage();
}
?>

</body>
</html>
