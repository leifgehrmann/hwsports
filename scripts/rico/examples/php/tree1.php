<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>Rico-Tree Control</title>

<?php
require "LoadRicoClient.php";
?>

<link href="../demo.css" type="text/css" rel="stylesheet" />

<script type='text/javascript'>
var tree1;

// initialize tree
Rico.onLoad( function() {
  tree1=new Rico.TreeControl("tree1", "CustTree.php");
  tree1.returnValue=function(newVal) { Rico.$('TreeValue1').value=newVal; };
  Rico.eventBind('TreeButton1', 'click', Rico.eventHandle(window,'TreeClick1'));
});

function TreeClick1(e) {
  if (tree1.visible()) {
    tree1.close();
  } else {
    Rico.positionCtlOverIcon(tree1.container,Rico.$('TreeButton1'));
    tree1.open();
  }
  Rico.eventStop(e);
}
</script>

</head>

<body>

<table id='explanation' border='0' cellpadding='0' cellspacing='5' style='clear:both'><tr valign='top'><td>
Base Library: 
<script type='text/javascript'>
document.write(Rico.Lib+' '+Rico.LibVersion);
</script>
<hr>
<p>This example demonstrates a basic, pop-up tree control where the tree nodes are loaded via AJAX.
Only one item is selected from the tree at a time.
Data is from the Northwind customer table.
</td>
<td>
<?php
require "info.php";
?>
</td>
</tr></table>


<p><button id='TreeButton1'>Show Tree</button>
<p><input type='text' id='TreeValue1' size='6'> (selected customer id)

<pre style='border:1px solid black;padding:3px;font-size:8pt;'>
Rico.onLoad( function() {
  tree1=new Rico.TreeControl("tree1", "CustTree.php");
  tree1.atLoad();
  tree1.returnValue=function(newVal) { Rico.$('TreeValue1').value=newVal; };
});
</pre>

</body>
</html>
