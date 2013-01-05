<?php 
ob_start(); 
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Rico SimpleGrid-Example 1</title>

<?php
require "dbConnect.php";
require "LoadRicoClient.php";
require "../../plugins/php/SimpleGrid.php";
?>
<link href="../demo.css" type="text/css" rel="stylesheet" />

<script type='text/javascript'>
var ex1;
Rico.onLoad( function() {
  var opts = {  
    columnSpecs   : [{width:200},'specQty','specQty','specQty','specQty']
  };
  ex1=new Rico.SimpleGrid ('ex1', opts);
});

function ExportGridClient(ExportType) {
  ex1.printVisible(ExportType);
}

function ExportGridServer(ExportType) {
  if (Rico.isIE) {
    location.href+='&fmt='+ExportType;
  } else {
    window.open(location.href+'&fmt='+ExportType);
  }
}
</script>

<style type="text/css">
.CatHead {
  background:blue;
  color:white;
  font-weight:bold !important;
}
.Subtotal {
  background:#888;
  color:white;
  font-weight:bold !important;
}
.GrandTotal {
  background:black;
  color:white;
  font-weight:bold !important;
}
div.ricoLG_cell {
  white-space:nowrap;
}
</style>

</head>


<body>

<table id='explanation' border='0' cellpadding='0' cellspacing='5' style='clear:both'><tr valign='top'><td>
Base Library: 
<script type='text/javascript'>
document.write(Rico.Lib+' '+Rico.LibVersion);
</script>
<hr>
<p><strong>Rico: SimpleGrid</strong></p>
<p>Rico's SimpleGrid is an unbuffered grid - all data exists in the DOM.
It shares many of the same characteristics as Rico's better known LiveGrid.
SimpleGrids have resizable columns, frozen columns on the left, and can use the
same CSS styling as LiveGrids. Sorting and filtering can also be enabled
at the developer's discretion. Unlike LiveGrids, each cell in a SimpleGrid
can be formatted individually.
</td>
<td>
<?php
//require "info.php";
?>
</td>
</tr></table>


<div>
<button onclick="ExportGridClient('plain')">Export from client<br>to HTML Table</button>
<button onclick="ExportGridServer('xl')">Export from server<br>to Excel</button>
<button onclick="ExportGridServer('csv')">Export from server<br>to CSV</button>
</div>

<?php

if (!OpenDB()) {
  echo "<p>ERROR opening database!";
} else {
  $grid=new SimpleGrid();
  FillGrid();
  $fmt=isset($_GET["fmt"]) ? $_GET["fmt"] : "";
  switch (strtolower($fmt)) {
    case "xl": 
      $grid->RenderExcel("rico.xls");
      break;
    case "csv":
      $grid->RenderDelimited("rico.csv", ",", "");
      break;
    default:
      $grid->Render("ex1", 0);   // output html
      break;
  }
}



function FillGrid() {
  global $oDB,$grid;
  $subtotals=array();
  $grandtotals=array();
  for ($i=0; $i<=1; $i++) {
    $grandtotals[$i]=0;
  }
  // define heading
  $grid->AddHeadingRow(true);
  $grid->AddCell("Product");
  $grid->AddCell("Gross Sales");
  $grid->AddCell("Discounts");
  $grid->AddCell("Net Sales");
  $grid->AddCell("Avg Discount");
  $sqltext="select CategoryName,ProductName, SUM(od.UnitPrice*Quantity) as GrossSales, SUM(od.UnitPrice*Quantity*Discount) as Discounts from (Order_Details od inner join Products p on p.ProductID=od.ProductID) inner join Categories c on p.CategoryID=c.CategoryID group by CategoryName,ProductName order by CategoryName,ProductName";
  $rsMain=$oDB->RunQuery($sqltext);
  $lastCategory='';
  while ($oDB->db->FetchRow($rsMain,$row)) {
    $category=$row[0];
    $Gross=$row[2];
    $Discounts=$row[3];
    if ($category != $lastCategory) {
      if (!empty($lastCategory)) {
        AddRow("Subtotal", $subtotals[0], $subtotals[1]);
        $grid->SetRowAttr("class", "Subtotal");
      }
      $grid->AddDataRow();
      $grid->SetRowAttr("class", "CatHead");
      $grid->AddCell($category);
      $grid->AddCell("");
      $grid->AddCell("");
      $grid->AddCell("");
      $grid->AddCell("");
      for ($i=0; $i<=1; $i++) {
        $subtotals[$i]=0;
      }
      $lastCategory=$category;
    }
    $subtotals[0]+=$Gross;
    $grandtotals[0]+=$Gross;
    $subtotals[1]+=$Discounts;
    $grandtotals[1]+=$Discounts;
    AddRow($row[1], $Gross, $Discounts);
  }
  $oDB->rsClose($rsMain);
  if (!empty($lastCategory)) {
    AddRow("Subtotal", $subtotals[0], $subtotals[1]);
    $grid->SetRowAttr("class", "Subtotal");
  }
  AddRow("Grand Total", $grandtotals[0], $grandtotals[1]);
  $grid->SetRowAttr("class", "GrandTotal");
}

function AddRow($ProductName, $Gross, $Discounts) {
  global $grid;
  $grid->AddDataRow();
  $grid->AddCell(htmlspecialchars(utf8_encode($ProductName), ENT_COMPAT, 'UTF-8'));
  $grid->AddCell("$".number_format($Gross)); 
  $grid->AddCell("$".number_format($Discounts));
  $grid->AddCell("$".number_format($Gross-$Discounts));
  $grid->AddCell(round($Discounts / $Gross * 100.0)."%");
}


?>

</body>
</html>

