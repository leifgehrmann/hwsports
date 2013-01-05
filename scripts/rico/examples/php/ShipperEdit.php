<html>
<head>
<title>Rico LiveGrid-Shippers (editable)</title>
<?php
require "dbConnect.php";
require "LoadRicoClient.php";
require "../../plugins/php/ricoLiveGridForms.php";
?>
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
  //echo "<p><textarea id='shippers_debugmsgs' rows='5' cols='80' style='font-size:smaller;'></textarea>";
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