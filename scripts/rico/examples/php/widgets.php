<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>Rico widgets styled user-selectable themes</title>
<?php
require "LoadRicoClient.php";
?>

<script>

var dialog;

Rico.onLoad( function() {
  var grid_options = {
    defaultWidth : 90,
    useUnformattedColWidth: false,
    menuEvent     : 'click',
    frozenColumns : 1,
    visibleRows   : 6,
    highlightElem: 'cursorRow',
    columnSpecs  : [{width:200},{type: 'number'},{type: 'number'},{type: 'number'},{type: 'number'},{type: 'number'}]
  };
  var grid=new Rico.LiveGrid ('population', new Rico.Buffer.AjaxLoadOnce('../data/population.xml'), grid_options);
  grid.menu=new Rico.GridMenu();
  new Rico.Accordion( 'accExample', {panelHeight:160});
  new Rico.TabbedPanel( 'tabsExample', {panelHeight:160});
  var cal=new Rico.CalendarControl("ricoCal",{position:'auto'});
  cal.selectNow();
  dialog=new Rico.Window('',{height:'250px',width:'300px',overflow:'auto'}, 'GettysburgContent');
});

function openWindow(btn) {
  dialog.openPopup();
  Rico.positionCtlOverIcon(dialog.container,btn);
}
</script>

<link href="../demo.css" type="text/css" rel="stylesheet" />
<style type="text/css">
#accExample {
  width: 27em;
}
#tabsExample {
  width: 30em;
}
div.ricoLG_cell {
  white-space:nowrap;
}
div.population_col1 .ricoLG_cell { text-align:right; }
div.population_col2 .ricoLG_cell { text-align:right; }
div.population_col3 .ricoLG_cell { text-align:right; }
div.population_col4 .ricoLG_cell { text-align:right; }
div.population_col5 .ricoLG_cell { text-align:right; }
</style>

</head>


<body>

<table id='explanation' border='0' cellpadding='5' cellspacing='0' style='clear:both'><tr valign='top'><td>
Base Library:
<script type='text/javascript'>
document.write(Rico.Lib+' '+Rico.LibVersion);
</script>
<hr>
This example displays some of the widgets that come with Rico.
The widgets are compatible with all base libraries and themes.
</td>
<td>
<?php
//require "info.php";
?>
</td>
</tr></table>


<p>&nbsp;</p>

<h2 style='margin-bottom:1px;'>Rico LiveGrid</h2>
<p style='margin-top:1px;'>Click on a cell to see available actions</p>

<p class="ricoBookmark"><span id="population_bookmark">&nbsp;</span></p>
<table class="ricoLiveGrid" id="population">
<thead>
 <tr>  <td class='ricoFrozen'></td>  <td colspan=5>Population (thousands)</td> </tr>
 <tr>  <th class='ricoFrozen'>Country or area</th>  <th>1950</th>  <th>2009</th>  <th>2015</th>  <th>2025</th>  <th>2050</th> </tr>
</thead>
</table>

<p style='font-size:smaller;'>Data source: <a href="http://www.un.org/esa/population/unpop.htm">Population Division of the
Department of Economic and Social Affairs of the United Nations Secretariat</a> (2009).
<em>World Population Prospects: The 2008 Revision. Highlights.</em> New York: United Nations.</p>


<p>&nbsp;</p>

<h2>Rico Accordion</h2>

<div id="accExample">

   <div>
     <div>Stanza 1</div>
     <div>
<p>Two roads diverged in a yellow wood,
<br>And sorry I could not travel both
<br>And be one traveler, long I stood
<br>And looked down one as far as I could
<br>To where it bent in the undergrowth.
     </div>
   </div>
   <div>
     <div>Stanza 2</div>
     <div>
<p>Then took the other, as just as fair,
<br>And having perhaps the better claim,
<br>Because it was grassy and wanted wear;
<br>Though as for that the passing there
<br>Had worn them really about the same.
     </div>
   </div>
   <div>
     <div>Stanza 3</div>
     <div>
<p>And both that morning equally lay
<br>In leaves no step had trodden black.
<br>Oh, I kept the first for another day!
<br>Yet knowing how way leads on to way,
<br>I doubted if I should ever come back.
     </div>
   </div>
   <div>
     <div>Stanza 4</div>
     <div>
<p>I shall be telling this with a sigh
<br>Somewhere ages and ages hence:
<br>Two roads diverged in a wood, and I--
<br>I took the one less traveled by,
<br>And that has made all the difference.
<p style='font-size:9pt;'><strong>Robert Frost: The Road Not Taken (1915)</strong>
     </div>
  </div>

</div>

<p>&nbsp;</p>

<h2>Rico Tabbed Panel</h2>

<div id="tabsExample">
   <ul>
     <li>Stanza 1</li>
     <li>Stanza 2</li>
     <li>Stanza 3</li>
     <li>Stanza 4</li>
   </ul>

   <div>
     <div>
<p>Two roads diverged in a yellow wood,
<br>And sorry I could not travel both
<br>And be one traveler, long I stood
<br>And looked down one as far as I could
<br>To where it bent in the undergrowth.
     </div>
     <div>
<p>Then took the other, as just as fair,
<br>And having perhaps the better claim,
<br>Because it was grassy and wanted wear;
<br>Though as for that the passing there
<br>Had worn them really about the same.
     </div>
     <div>
<p>And both that morning equally lay
<br>In leaves no step had trodden black.
<br>Oh, I kept the first for another day!
<br>Yet knowing how way leads on to way,
<br>I doubted if I should ever come back.
     </div>
     <div>
<p>I shall be telling this with a sigh
<br>Somewhere ages and ages hence:
<br>Two roads diverged in a wood, and I--
<br>I took the one less traveled by,
<br>And that has made all the difference.
<p style='font-size:9pt;'><strong>Robert Frost: The Road Not Taken (1915)</strong>
     </div>
  </div>

</div>

<p>&nbsp;</p>

<h2>Rico Dialog Window</h2>

<p><button onclick='openWindow(this)'>Open Dialog Window</button>
<div id='GettysburgContent' title='The Gettysburg Address'>
<p>Four score and seven years ago our fathers brought forth on this continent, a new nation, conceived in Liberty, and dedicated to the proposition that all men are created equal.
<p>Now we are engaged in a great civil war, testing whether that nation, or any nation so conceived and so dedicated, can long endure. We are met on a great battle-field of that war. We have come to dedicate a portion of that field, as a final resting place for those who here gave their lives that that nation might live. It is altogether fitting and proper that we should do this.
<p>But, in a larger sense, we can not dedicate -- we can not consecrate -- we can not hallow -- this ground. The brave men, living and dead, who struggled here, have consecrated it, far above our poor power to add or detract. The world will little note, nor long remember what we say here, but it can never forget what they did here. It is for us the living, rather, to be dedicated here to the unfinished work which they who fought here have thus far so nobly advanced. It is rather for us to be here dedicated to the great task remaining before us -- that from these honored dead we take increased devotion to that cause for which they gave the last full measure of devotion -- that we here highly resolve that these dead shall not have died in vain -- that this nation, under God, shall have a new birth of freedom -- and that government of the people, by the people, for the people, shall not perish from the earth.
</div>

<p>&nbsp;</p>

<h2>Rico Calendar</h2>

<div id="ricoCal"></div>

</body>
</html>
