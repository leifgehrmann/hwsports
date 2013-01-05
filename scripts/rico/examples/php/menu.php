<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Rico 3.0</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

<script src="../../ricoClient/js/proto_min.js" type="text/javascript"></script>
<script src="../../ricoClient/js/rico2pro.js" type="text/javascript"></script>
<script src="../../ricoClient/js/rico_min.js" type="text/javascript"></script>
<link href="../../ricoClient/css/rico.css" type="text/css" rel="stylesheet" />

<script src="../menu.js" type="text/javascript"></script>
<link href="../menu.css" type="text/css" rel="stylesheet">

<!--[if lt IE 7]>
  <style type="text/css">
ul li {
   height: 1%;
}
 </style>
<![endif]-->
</head>


<body>

<div id="menuheader">
<p>Rico <span id='RicoVersion'></span> <span id='RicoDir'></span> Demo</p>
</div>

<div class='top'>
<form action='' method='get' id='form1' target="content">
<ul>
<li id='demolist'>Example: <span id='demospan'></span>
<li>Theme: <span id='themespan'></span><input type='hidden' name='theme' id='theme' value=''>
<li>Base Lib: <span id='libspan'></span><input type='hidden' name='lib' id='lib' value=''>
<li>PHP Version: <?php echo PHP_VERSION . ' ' . php_ini_loaded_file(); ?>
<li><input type='checkbox' name='log'>&nbsp; Enable console logging
<li><input type='checkbox' name='html5'>&nbsp; Enable HTML5 web form inputs
</ul>
</form>
</div>


<div id="accordion1">

<div>
  <div>Choose the Example</div>
  <div>
<ul>
<li><a id="demo_widgets.php">Rico Widget Overview</a>
<li><a id="demo_ex1.php">LiveGrid sourced from HTML table</a>
<li><a id="demo_ex2xml.php">LiveGrid sourced from SQL database (xml)</a>
<li><a id="demo_ex2json.php">LiveGrid sourced from SQL database (json)</a>
<li><a id="demo_ShipperEdit.php">Editable LiveGrid (basic)</a>
<li><a id="demo_ex2editfilter.php">Editable LiveGrid (advanced)</a>
<li><a id="demo_ex2nosession.php">Editable LiveGrid without session vars</a>
<li><a id="demo_photos.php">LiveGrid sourced from flickr</a>
<li><a id="demo_simplegrid.php">SimpleGrid</a>
<li><a id="demo_tree1.php">Tree control</a>
<li><a id="demo_RicoDbViewer.php">Northwind data browser</a>
</ul>
  </div>
</div>

<div>
  <div>Choose the Theme</div>
  <div>
  <table border='0'>
  <tr>
  <td>Themeroller<br>Themes</td><td>Rico<br>Themes</td>
  </tr>
  <tr valign='top'>
  <td>

    <ul>
<li><a id="theme_j-ui-lightness"><img src="../images/themeroller/theme_30_ui_light.png" alt="UI Lightness" title="UI Lightness" />
<br><span class="themeName">UI lightness</span></a></li>

<li><a id="theme_j-ui-darkness"><img src="../images/themeroller/theme_30_ui_dark.png" alt="UI Darkness" title="UI Darkness" />
<br><span class="themeName">UI darkness</span></a></li>

<li><a id="theme_j-smoothness"><img src="../images/themeroller/theme_30_smoothness.png" alt="Smoothness" title="Smoothness" />
<br><span class="themeName">Smoothness</span></a></li>

<li><a id="theme_j-start"><img src="../images/themeroller/theme_30_start_menu.png" alt="Start" title="Start" />
<br><span class="themeName">Start</span></a></li>

<li><a id="theme_j-redmond"><img src="../images/themeroller/theme_30_windoze.png" alt="Redmond" title="Redmond" />
<br><span class="themeName">Redmond</span></a></li>

<li><a id="theme_j-sunny"><img src="../images/themeroller/theme_30_sunny.png" alt="Sunny" title="Sunny" />
<br><span class="themeName">Sunny</span></a></li>

<li><a  id="theme_j-overcast"><img src="../images/themeroller/theme_30_overcast.png" alt="Overcast" title="Overcast" />
<br><span class="themeName">Overcast</span></a></li>

<li><a  id="theme_j-le-frog"><img src="../images/themeroller/theme_30_le_frog.png" alt="Le Frog" title="Le Frog" />
<br><span class="themeName">Le Frog</span></a></li>

<li><a  id="theme_j-flick"><img src="../images/themeroller/theme_30_flick.png" alt="Flick" title="Flick" />
<br><span class="themeName">Flick</span></a></li>

<li><a  id="theme_j-pepper-grinder"><img src="../images/themeroller/theme_30_pepper_grinder.png" alt="Pepper Grinder" title="Pepper Grinder" />
<br><span class="themeName">Pepper Grinder</span></a></li>

<li><a  id="theme_j-eggplant"><img src="../images/themeroller/theme_30_eggplant.png" alt="Eggplant" title="Eggplant" />
<br><span class="themeName">Eggplant</span></a></li>

<li><a  id="theme_j-dark-hive"><img src="../images/themeroller/theme_30_dark_hive.png" alt="Dark Hive" title="Dark Hive" />
<br><span class="themeName">Dark Hive</span></a></li>

<li><a  id="theme_j-cupertino"><img src="../images/themeroller/theme_30_cupertino.png" alt="Cupertino" title="Cupertino" />
<br><span class="themeName">Cupertino</span></a></li>

<li><a  id="theme_j-south-street"><img src="../images/themeroller/theme_30_south_street.png" alt="South St" title="South St" />
<br><span class="themeName">South Street</span></a></li>

<li><a  id="theme_j-blitzer"><img src="../images/themeroller/theme_30_blitzer.png" alt="Blitzer" title="Blitzer" />
<br><span class="themeName">Blitzer</span></a></li>	

<li><a  id="theme_j-humanity"><img src="../images/themeroller/theme_30_humanity.png" alt="Humanity" title="Humanity" />
<br><span class="themeName">Humanity</span></a></li>

<li><a  id="theme_j-hot-sneaks"><img src="../images/themeroller/theme_30_hot_sneaks.png" alt="Hot Sneaks" title="Hot Sneaks" />
<br><span class="themeName">Hot sneaks</span></a></li>

<li><a  id="theme_j-excite-bike"><img src="../images/themeroller/theme_30_excite_bike.png" alt="Excite Bike" title="Excite Bike" />
<br><span class="themeName">Excite Bike</span></a></li>

<li><a  id="theme_j-vader"><img src="../images/themeroller/theme_30_black_matte.png" alt="Vader" title="Vader" />
<br><span class="themeName">Vader</span></a></li>

<li><a  id="theme_j-dot-luv"><img src="../images/themeroller/theme_30_dot_luv.png" alt="Dot Luv" title="Dot Luv" />
<br><span class="themeName">Dot Luv</span></a></li>

<li><a  id="theme_j-mint-choc"><img src="../images/themeroller/theme_30_mint_choco.png" alt="Mint Choc" title="Mint Choc" />
<br><span class="themeName">Mint Choc</span></a></li>

<li><a  id="theme_j-black-tie"><img src="../images/themeroller/theme_30_black_tie.png" alt="Black Tie" title="Black Tie" />
<br><span class="themeName">Black Tie</span></a></li>

<li><a  id="theme_j-trontastic"><img src="../images/themeroller/theme_30_trontastic.png" alt="Trontastic" title="Trontastic" />
<br><span class="themeName">Trontastic</span></a></li>

<li><a  id="theme_j-swanky-purse"><img src="../images/themeroller/theme_30_swanky_purse.png" alt="Swanky Purse" title="Swanky Purse" />
<br><span class="themeName">Swanky Purse</span></a></li>
    </ul>

    </td><td>

    <ul>
  <li><a id='theme_r-greenHdg'>Green Heading</a></li>
  <li><a id='theme_r-warmfall'>Warm Fall</a></li>
  <li><a id='theme_r-seaglass'>Sea Glass</a></li>
  <li><a id='theme_r-coffee-with-milk'>Coffee with milk</a></li>
  <li><a id='theme_r-grayedout'>Grayed out</a></li>
    </ul>

  </td>
  </tr>
  </table>


  </div>
</div>

<div>
  <div>Choose the Base Library</div>
  <div>
<ul>
<li><a id='lib_prototype/1.6/prototype.js'>Prototype 1.6</a>
<li><a id='lib_prototype/1.7/prototype.js'>Prototype 1.7</a>
<li><a id='lib_jquery/1.3/jquery.min.js'>jQuery 1.3</a>
<li><a id='lib_jquery/1.4/jquery.min.js'>jQuery 1.4</a>
<li><a id='lib_jquery/1.5/jquery.min.js'>jQuery 1.5</a>
<li><a id='lib_mootools/1.2/mootools-yui-compressed.js'>MooTools 1.2</a>
<li><a id='lib_mootools/1.3/mootools-yui-compressed.js'>MooTools 1.3</a>
<li><a id='lib_dojo/1.4/dojo/dojo.xd.js'>dojo 1.4</a>
<li><a id='lib_dojo/1.5/dojo/dojo.xd.js'>dojo 1.5</a>
<li><a id='lib_ext-core/3.0/ext-core.js'>Ext 3.0</a>
<li><a id='lib_ext-core/3.1/ext-core.js'>Ext 3.1</a>
<li><a id='lib_glow_min.js'>Glow 1.7</a>
</ul>
  </div>
</div>

</div>
</body></html>
