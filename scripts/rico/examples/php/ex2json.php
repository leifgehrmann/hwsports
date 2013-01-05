<?php
if (!isset ($_SESSION)) session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Rico LiveGrid-Example 2</title>

<?php
require "dbConnect.php";
require "LoadRicoClient.php";

session_set_cookie_params(60*60);
$sqltext="select OrderID,CustomerID,ShipName,ShipCity,ShipCountry,OrderDate,ShippedDate from orders order by OrderID";
if (isset($_GET["id"])) {
  OpenDB(); // the addQuotes function requires a db connection when using MySQL
  $id=trim($_GET["id"]);
  if (strlen($id) == 5) $sqltext.=" where CustomerID=".$GLOBALS['oDB']->addQuotes($id);
  CloseApp();
}
$_SESSION['ex2']=$sqltext;
?>
<link href="../demo.css" type="text/css" rel="stylesheet" />

<script type='text/javascript'>

var orderGrid,buffer;

Rico.onLoad( function() {
  var opts = {  
    menuEvent     : 'click',
    frozenColumns : 1,
    highlightElem: 'cursorRow',
    columnSpecs   : [,,,,,{type:'date'},{type:'date'}]
  };
  buffer=new Rico.Buffer.AjaxSQL('ricoQuery.php', {fmt:'json', TimeOut:<?php $c=session_get_cookie_params(); print $c["lifetime"]/60; ?>});
  orderGrid=new Rico.LiveGrid ('ex2', buffer, opts);
  orderGrid.menu=new Rico.GridMenu({});
});

</script>

<style type="text/css">
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
This example uses AJAX to fetch order data, as required, from the server. 
Notice how the number of visible rows is set automatically based
on the size of the window. Try the different grid styles that
are available. 
Click on a cell to see available actions.
<a href='ricoQuery.php?id=ex2&offset=0&page_size=10&_fmt=json'>View the AJAX response (JSON)</a>
(requires JSONview or similar extension in FF).
</td>
<td>
<?php
//require "info.php";
?>
</td>
</tr></table>

<p class="ricoBookmark"><span id='ex2_timer' class='ricoSessionTimer'></span><span id="ex2_bookmark">&nbsp;</span></p>
<table id="ex2" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
<colgroup>
<col style='width:40px;' >
<col style='width:60px;' >
<col style='width:150px;'>
<col style='width:80px;' >
<col style='width:90px;' >
<col style='width:100px;'>
<col style='width:100px;'>
</colgroup>
  <tr>
	  <th>Order#</th>
	  <th>Customer#</th>
	  <th>Ship Name</th>
	  <th>Ship City</th>
	  <th>Ship Country</th>
	  <th>Order Date</th>
	  <th>Ship Date</th>
  </tr>
</table>
<!--
<textarea id='ex2_debugmsgs' rows='5' cols='80'></textarea>
-->
</body>
</html>

