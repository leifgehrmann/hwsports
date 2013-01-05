<?php
namespace Rico;

// Requires PHP 5.3+
// Using static members in a class makes this combatible with PHP 5.0+ and effectively gives us a namespace

class Client {

  // Load Rico client files and create style sheet

  static public $jsDir="/scripts/rico/js/";       // directory containing Rico's javascript files
  static public $cssDir="/scripts/rico/css/";     // directory containing Rico's css files
  static public $imgDir="/scripts/rico/images/";  // directory containing Rico's image files
  static public $transDir;
  static public $checkQueryString = false; // load settings from QueryString? true only for demo

  // The base Javascript library to load from http://ajax.googleapis.com/ajax/libs/, possible values include:
  //
  //   prototype/1.6/prototype.js
  //   prototype/1.7/prototype.js
  //   jquery/1.3/jquery.min.js
  //   jquery/1.4/jquery.min.js
  //   jquery/1.5/jquery.min.js
  //   jquery/1.6/jquery.min.js
  //   mootools/1.2/mootools-yui-compressed.js
  //   mootools/1.3/mootools-yui-compressed.js
  //   dojo/1.5/dojo/dojo.xd.js
  //   dojo/1.6/dojo/dojo.xd.js
  //   ext-core/3.0/ext-core.js
  //   ext-core/3.1/ext-core.js
  //
  // Default value is "proto_min.js", which loads prototype 1.7 from jsDir.
  static public $BaseLib = "proto_min.js";

  // Enable Javascript console logging? Useful for debugging. Default is false.
  static public $Logging = false;

  // Enable HTML5 web form elements in browsers that support them.
  // Default is false because the quality of the HTML5 web form elements is uneven across browsers.
  static public $HTML5 = false;

  // Best left unset, in which case language will be set automatically based on request's HTTP_ACCEPT_LANGUAGE
  // However, if you want to present the same locale settings to all users, then you can set this value to force the desired locale.
  static public $Language;

  // Load base Javascript library (prototype, jQuery, etc)?
  // Default is true.
  // Set to false if library is being loaded another way. In this case, a BaseLib value is still required to indicate
  // which library Rico should connect to.
  static public $LoadBaseLib = true;

  // Apply row striping to LiveGrids? Default is true. Applies only when themes are used.
  static public $Striping = true;

  // Background image for grid headings and window titles.
  // Should be left unset, as it is used only for the grayedout theme (in which case it is set automatically).
  static public $ImgHeading;

  // Comma separated list of 2 letter locales that Rico supports.
  // Do not set unless you have developed your own locale file.
  static public $SupportedLangs = "de,es,fr,it,ja,ko,pt,ru,uk,zh";

  // URL to load jQuery themes from.
  // Default is http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/
  // Override this value if you have a jQuery theme on your own server.
  static public $jQueryThemePath = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/";

  static public $theme;  // jquery themes start with j-, rico themes start with r-
  static protected $lang2;

  // set locale
  static public function SetLocale() {
    $lang=strtolower(isset(self::$Language) ? self::$Language : $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    $arLang=explode(",",$lang);
    $transdir=isset(self::$transdir) ? self::$transdir : self::$jsDir;
    for ($i=0; $i<count($arLang); $i++) {
      $lang2=substr(trim($arLang[$i]),0,2);
      if ($lang2=='en') break; // already included
      if (strpos(self::$SupportedLangs,$lang2) !== false) {
      //if (file_exists($fname)) {
        $fname=$transDir."ricoLocale_".$lang2.".js";
        echo "<script src='".$fname."' type='text/javascript'></script>\n";
        break;
      }
    }
    self::$lang2 = $i<count($arLang) ? $lang2 : "en";
  }

  // Returns the 2 character string representing the Rico locale file that was actually used on the client.
  // if there is no match between the requested languages and the available locale files, then english is used.
  // Only available after renderHead has been called.
  function LoadedLanguage() {
    return self::$lang2;
  }

}


// initializes the class with the values in the options associative array
function init($options) {
  foreach ($options as $property => $value) {
    Client::$$property = $value;
  }
}

// This function writes out the required Rico settings in the head section of the html document
function renderHead() {
  if (Client::$checkQueryString) {
    Client::$BaseLib=$_GET['lib'];
    Client::$theme=$_GET["theme"];
    Client::$Logging=isset($_GET["log"]);
    Client::$HTML5=isset($_GET["html5"]);
  }

  $a=array();
  if (Client::$Logging) $a[] = "enableLogging: true";
  if (Client::$HTML5) $a[] = "enableHTML5: true";
  if (count($a) > 0) {
    echo "\n<script type='text/javascript'>\n";
    echo "Rico_CONFIG = { " . implode(", ", $a) . " };\n";
    echo "</script>\n";
  }

  if (Client::$LoadBaseLib) {
    if (strpos(Client::$BaseLib,"/") === false) {
      echo "<script src='".Client::$jsDir.Client::$BaseLib."' type='text/javascript'></script>\n";
    } else {
      echo "<script src='http://ajax.googleapis.com/ajax/libs/".Client::$BaseLib."' type='text/javascript'></script>\n";
    }
  }
  requireRicoJS("2" . substr(Client::$BaseLib,0,3));
  requireRicoJS("_min");
  requireRicoCSS("rico");
  
  Client::SetLocale();

  // load theme

  if (isset(Client::$theme) && strlen(Client::$theme) > 2) {
    $prefix=substr(Client::$theme,0,1);
    $themeName=substr(Client::$theme,2);
    switch ($prefix) {
      case 'j':
        requireRicoJS("Themeroller");
        echo "<link type='text/css' rel='Stylesheet' href='" . Client::$jQueryThemePath . $themeName . "/jquery-ui.css' />\n";
        break;
      case 'r':
        requireRicoCSS($themeName);
        break;
    }
    if (Client::$Striping) {
      echo "<link type='text/css' rel='stylesheet' href='".Client::$cssDir."striping_".$themeName.".css' />\n";
    }
  }

  // write css styles

  echo "<style type='text/css'>\n";
  //For Each ctrl As Control In Page.Controls
  //    if TypeOf (ctrl) Is GridBase Then writer.Write(CType(ctrl, GridBase).GridRules())
  //    if TypeOf (ctrl) Is LiveGrid Then writer.Write(CType(ctrl, LiveGrid).ColumnRules())
  //Next
  if (!isset(Client::$ImgHeading) && Client::$theme=="r-grayedout") Client::$ImgHeading=Client::$imgDir."grayedout.gif";
  if (isset(Client::$ImgHeading)) {
    echo ".Rico_accTitle, .ricoTitle, table.ricoLiveGrid thead th, table.ricoLiveGrid thead td, tr.ricoLG_hdg td, tr.ricoLG_hdg th {\n";
    echo "  background-position: left center;\n";
    echo "  background-repeat: repeat-x;\n";
    echo "  background-image: url('" . Client::$ImgHeading . "');\n";
    echo "}\n";
  }
  echo ".ricoLG_Resize {\n";
  echo "  background-repeat: repeat;\n";
  echo "  background-image: url('" . Client::$imgDir . "resize.gif');\n";
  echo "}\n";
  echo ".rico-icon {\n";
  echo "  background-repeat: no-repeat;\n";
  echo "  background-image: url('" . Client::$imgDir . "ricoIcons.gif');\n";
  echo "}\n";
  echo "</style>\n";
}

function requireRicoJS($filename) {
  echo "<script src='".Client::$jsDir."rico".$filename.".js' type='text/javascript'></script>\n";
}

function requireRicoCSS($filename) {
  echo "<link href='".Client::$cssDir.$filename.".css' type='text/css' rel='stylesheet' />\n";
}  
  

abstract class GridBase {
  protected $id;
  
  // Name of grid Javascript object
  public function gridVar() {
    return $this->id . ".grid";
  }
  
  // Name of grid options Javascript object
  public function optionsVar() {
    return $this->id . ".options";
  }
  
  // If enabled, an additional row is added to the grid header where column filters are placed. 
  // See the EditCol.filterUI property to customize each column's filter.
  public $AutoFilter = false;
  
  // The token in select filters used to indicate "show all values" (default: "___ALL___").
  public $FilterAllToken;

  // if unset, then use column heading width, otherwise this is the default width in pixels
  public $defaultWidth;

  // Allow user to resize columns? Default is true.
  public $allowColResize;

  // Number of frozen columns on the left (or right if direction=rtl). Default is 0.
  public $frozenColumns;

  // Height of one line of text in ems. Default is 1.2, which should be fine for almost all situations.
  public $RowLineHtEms = 1.2;

  // Resize grid when browser window is resized? Default is true.
  public $windowResize;
  
  // Specifies when the grid's popup menu should be invoked
  public $menuEvent;
  
}

?>

