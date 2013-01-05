<?php
if (!isset ($_SESSION)) session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Rico-Table Detail</title>

<link href="../demo.css" type="text/css" rel="stylesheet" />

<?php
require "dbConnect.php";
require "LoadRicoClient.php";


$arColumns=array();
$columnlist="";
$colspecs="";
if (isset($_GET["id"]) && OpenDB()) {
  $id=trim($_GET["id"]);
  $arColumns=$oDB->GetColumnInfo($id);
  for ($i=0; $i<count($arColumns); $i++) {
    $coltype=$arColumns[$i]->ColType;
    if ($coltype=='image' || $coltype=='text' || $coltype=='ntext') continue;
    if (!empty($columnlist)) {
      $columnlist.=",";
      $colspecs.=",";
    }
    $columnlist.=$arColumns[$i]->ColName;
    //$colspecs.="{Hdg:'".$coltype."'";   // for debugging
    $colspecs.="{Hdg:'".$arColumns[$i]->ColName."'";
    if ($coltype == "DATETIME") {
      $colspecs.=",type:'datetime'";
    }
    $colspecs.="}";
  }
  $_SESSION[$id]="select ".$columnlist." from ".$id." order by ".$arColumns[0]->ColName;
  CloseApp();
}
?>


<script type='text/javascript'>
Rico.onLoad( function() {
  var opts = {  
    useUnformattedColWidth: false,
    menuEvent: 'click',
    highlightElem: 'cursorRow',
    columnSpecs: [
<?php
echo $colspecs;
?>
    ]
  };
  var buffer=new Rico.Buffer.AjaxSQL('ricoQuery.php', {TimeOut:<?php $c=session_get_cookie_params(); print $c["lifetime"]/60; ?>});
  var grid=new Rico.LiveGrid ('<?php echo $id; ?>', buffer, opts);
  grid.menu = new Rico.GridMenu();
});
</script>

<style type="text/css">
html { border: none; }
div.ricoLG_cell {
  white-space:nowrap;
}
</style>
</head>


<body>
<p><strong><?php echo $id; ?></strong>
<p class="ricoBookmark"><span id='<?php echo $id; ?>_timer' class='ricoSessionTimer'></span><span id="<?php echo $id; ?>_bookmark">&nbsp;</span></p>
<div id="<?php echo $id; ?>"></div>
</body>
</html>

