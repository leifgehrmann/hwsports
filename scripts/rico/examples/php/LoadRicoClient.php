<?php

$jsDir="/scripts/rico/js/";       // directory containing Rico's javascript files
$cssDir="/scripts/rico/css/";     // directory containing Rico's css files
$imgDir="/scripts/rico/images/";  // directory containing Rico's image files
$transDir=$jsDir;
$grid_striping=true;       // apply row striping to LiveGrids?
$checkQueryString = true;  // load settings from QueryString? true for demo, false for production
$LoadBaseLib = true;       // load base Javascript library (prototype, jQuery, etc)?
$jQuery_theme_path = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/";

if ($checkQueryString) {
  $ricoLib=$_GET['lib'];
  $ricoTheme=$_GET["theme"];
  $ricoLogging=isset($_GET["log"]);
} else {
  // set your production values here
  $ricoLib="proto_min.js";         // base library
  $ricoTheme="j-ui-lightness";  // jquery themes start with j-, rico themes start with r-
  $ricoLogging=false;
}

SetConfig();
LoadLib($ricoLib, $LoadBaseLib);
setLang();
LoadTheme($ricoTheme);
WriteStyles();


function WriteStyles() {
  global $imgDir,$ricoTheme;
  echo "<style type='text/css'>\n";
  //For Each ctrl As Control In Page.Controls
  //    If TypeOf (ctrl) Is GridBase Then writer.Write(CType(ctrl, GridBase).GridRules())
  //    If TypeOf (ctrl) Is LiveGrid Then writer.Write(CType(ctrl, LiveGrid).ColumnRules())
  //Next
  if ($ricoTheme=="r-grayedout") {
      echo ".Rico_accTitle, .ricoTitle, table.ricoLiveGrid thead th, table.ricoLiveGrid thead td, tr.ricoLG_hdg td, tr.ricoLG_hdg th {\n";
      echo "  background-position: left center;\n";
      echo "  background-repeat: repeat-x;\n";
      echo "  background-image: url('" . $imgDir . "grayedout.gif');\n";
      echo "}\n";
  }
  echo ".ricoLG_Resize {\n";
  echo "  background-repeat: repeat;\n";
  echo "  background-image: url('" . $imgDir . "resize.gif');\n";
  echo "}\n";
  echo ".rico-icon {\n";
  echo "  background-repeat: no-repeat;\n";
  echo "  background-image: url('" . $imgDir . "ricoIcons.gif');\n";
  echo "}\n";
  echo "</style>\n";
}


// initialize Rico
function SetConfig() {
  global $ricoLogging;
  echo "\n<script type='text/javascript'>\n";
  echo "Rico_CONFIG = {\n";
  if ($ricoLogging) echo "enableLogging: true,\n";
  echo "};\n";
  echo "</script>\n";
}


function LoadLib($baseLib, $baseLoadFlag) {
  global $jsDir;
  if ($baseLoadFlag) {
    if (strpos($baseLib,"/") === false) {
      echo "<script src='".$jsDir.$baseLib."' type='text/javascript'></script>\n";
    } else {
      echo "<script src='http://ajax.googleapis.com/ajax/libs/".$baseLib."' type='text/javascript'></script>\n";
    }
  }
  requireRicoJS("2" . substr($baseLib,0,3));
  requireRicoJS("_min");
  requireRicoCSS("rico");
}


// -------------------------------------------------------------
// Check languages accepted by browser
// and see if there is a match
// -------------------------------------------------------------
function setLang() {
  global $transDir;
  $lang=strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
  $arLang=explode(",",$lang);
  for ($i=0; $i<count($arLang); $i++) {
    $lang2=strtolower(substr(trim($arLang[$i]),0,2));
    if ($lang2=='en') break; // already included
    $fname=$transDir."ricoLocale_".$lang2.".js";
    if (file_exists($fname)) {
      echo "<script src='".$fname."' type='text/javascript'></script>\n";
      break;
    } 
  }
}

// set theme
// "j-ui-lightness" for a Themeroller theme
// "r-greenHdg" for a native Rico theme
function LoadTheme($theme) {
  global $cssDir,$grid_striping,$jQuery_theme_path;
  $prefix=substr($theme,0,1);
  $theme=substr($theme,2);
  switch ($prefix) {
    case 'j':
      requireRicoJS("Themeroller");
      echo "<link type='text/css' rel='Stylesheet' href='" . $jQuery_theme_path . $theme."/jquery-ui.css' />\n";
      break;
    case 'r':
      requireRicoCSS($theme);
      break;
  }
  if ($grid_striping) {
    echo "<link type='text/css' rel='stylesheet' href='".$cssDir."striping_".$theme.".css' />\n";
  }
}

function requireRicoJS($filename) {
  global $jsDir;
  echo "<script src='".$jsDir."rico".$filename.".js' type='text/javascript'></script>\n";
}

function requireRicoCSS($filename) {
  global $cssDir;
  echo "<link href='".$cssDir.$filename.".css' type='text/css' rel='stylesheet' />\n";
}

?>