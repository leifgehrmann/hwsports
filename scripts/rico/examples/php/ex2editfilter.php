<?php
if (!isset ($_SESSION)) session_start();
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: ".gmdate("D, d M Y H:i:s",time()+(-1*60))." GMT");
header('Content-type: text/html; charset=utf-8');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Rico LiveGrid-Example 2 (editable)</title>
<?php
require "dbConnect.php";
require "LoadRicoClient.php";
require "../../plugins/php/ricoLiveGridForms.php";
?>

<script type='text/javascript'>

// ricoLiveGridForms will call orders_FormInit right before grid & form initialization.

function orders_FormInit() {
  var cal=new Rico.CalendarControl("Cal");
  Rico.EditControls.register(cal, 'rico-icon rico-calarrow');
  
  var CustTree=new Rico.TreeControl("CustomerTree","CustTree.asp");
  Rico.EditControls.register(CustTree, 'rico-icon rico-dotbutton');
}
</script>

<link href="../demo.css" type="text/css" rel="stylesheet" />
<style type="text/css">
div.ricoLG_cell {
  white-space:nowrap;
}
</style>
</head>
<body>

<?php
//************************************************************************************************************
//  LiveGrid Plus-Edit Example
//************************************************************************************************************
//  Matt Brown
//************************************************************************************************************
if (OpenGridForm("", "orders")) {
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
  echo "<table id='explanation' border='0' cellpadding='0' cellspacing='5' style='clear:both'><tr valign='top'><td>";
  echo "Base Library: <script type='text/javascript'>document.write(Rico.Lib+' '+Rico.LibVersion);</script>";
  echo "<hr>The data on this grid can be edited using pop-up forms. ";
  echo "Just click on a grid cell and then select Edit, Delete, or Add from the pop-up menu. ";
  echo "The Add and Edit forms are automatically generated by LiveGrid. ";
  echo "Notice on the Add form how you use the Rico Tree control to select the customer. ";
  echo "Notice on the Edit form how the Rico Calendar is used to change dates. ";
  echo "Updates are disabled on the database, so you will get an error message if you try to save.";
  echo "</td><td>";
  //require "info.php";
  echo "</td></tr></table>";
  echo "<p><strong>Orders Table</strong></p>";

  $oForm->options["panelWidth"]=500;
  $oForm->options["frozenColumns"]=1;
  $oForm->options["menuEvent"]='click';
  $oForm->options["highlightElem"]='cursorRow';
  //$GLOBALS['oForm']->options["DebugFlag"]=true;
  //$GLOBALS['oDB']->debug=true;
  DefineFields();
  //echo "<p><textarea id='orders_debugmsgs' rows='5' cols='80' style='font-size:smaller;'></textarea>";
}

function DefineFields() {
  global $oForm,$oDB;
  $oForm->options["FilterLocation"]=-1;

  $oForm->AddPanel("Basic Info");
  $oForm->AddEntryFieldW("OrderID", "Order ID", "B", "<auto>", 50);
  $oForm->ConfirmDeleteColumn();
  $oForm->SortAsc();

  $LookupSQL="select CustomerID,CompanyName from customers order by CompanyName";
  $oForm->AddLookupField("CustomerID",null,"CustID","Customer","CL","",$LookupSQL);
  $oForm->LookupField["SelectCtl"]="CustomerTree";
  $oForm->LookupField["InsertOnly"]=true;   // do not allow customer to be changed once an order is entered
  $oForm->CurrentField["width"]=160;
  $oForm->CurrentField["filterUI"]="t";

  $LookupSQL="select EmployeeID,".$oDB->concat(array("LastName", "', '", "FirstName"), false)." from employees order by LastName,FirstName";
  $oForm->AddLookupField("EmployeeID",null,"EmployeeID","Sales Person","SL","",$LookupSQL);
  $oForm->CurrentField["width"]=140;
  $oForm->CurrentField["filterUI"]="m";

  $oForm->AddEntryField("OrderDate", "Order Date", "D", @strftime('%Y-%m-%d'));
  $oForm->CurrentField["SelectCtl"]="Cal";
  $oForm->CurrentField["width"]=90;
  $oForm->AddEntryField("RequiredDate", "Required Date", "D", @strftime('%Y-%m-%d'));
  $oForm->CurrentField["SelectCtl"]="Cal";
  $oForm->CurrentField["width"]=90;
  $oForm->AddCalculatedField("select sum(UnitPrice*Quantity*(1.0-Discount)) from order_details d where d.OrderID=t.OrderID","Net Sale");
  $oForm->CurrentField["format"]="DOLLAR";
  $oForm->CurrentField["width"]=80;

  $oForm->AddPanel("Ship To");
  $oForm->AddEntryFieldW("ShipName", "Name", "B", "",140);
  $oForm->AddEntryFieldW("ShipAddress", "Address", "B", "",140);
  $oForm->AddEntryFieldW("ShipCity", "City", "B", "",120);
  $oForm->CurrentField["filterUI"]="s";
  $oForm->AddEntryFieldW("ShipRegion", "Region", "T", "",60);
  $oForm->AddEntryFieldW("ShipPostalCode", "Postal Code", "T", "",100);
  
  // display ShipCountry with a link to wikipedia
  $colnum=$oForm->AddEntryFieldW("ShipCountry", "Country", "N", "",100);
  $oForm->CurrentField["control"]="new Rico.TableColumn.link('http://en.wikipedia.org/wiki/{".$colnum."}','_blank')";
  $oForm->CurrentField["filterUI"]="s";

  $oForm->DisplayPage();
}
?>


</body>
</html>
