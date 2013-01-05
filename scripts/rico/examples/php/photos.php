<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Rico LiveGrid-Photo Example</title>

<?php
require "LoadRicoClient.php";
?>
<link href="../demo.css" type="text/css" rel="stylesheet" />

<script type='text/javascript'>

var photoGrid, photoBuffer, imgctl, img_popup, animator;

Rico.onLoad( function() {
  imgctl=new Rico.TableColumn.image();
  var opts = {  
    prefetchBuffer: false,
    defaultWidth  : 100,
    useUnformattedColWidth:false,
    headingSort   : 'hover',
    columnSpecs   : [{control:imgctl,width:90},,,
                     {type:'datetime'},{width:200}]
  };
  photoBuffer=new Rico.Buffer.AjaxLoadOnce('flickrPhotos.php');
  photoGrid=new Rico.LiveGrid ('photogrid', photoBuffer, opts);
  photoGrid.menu=new Rico.GridMenu();
  
  // do something special when the mouse hovers over an image
  for (var i=0; i<imgctl._img.length; i++) {
    Rico.eventBind(imgctl._img[i],'mouseover',Rico.eventHandle(window,'img_mouseover'));
    Rico.eventBind(imgctl._img[i],'mouseout',Rico.eventHandle(window,'img_mouseout'));
  }
  img_popup=Rico.$('img_popup');
});

function img_mouseover(e) {
  Rico.eventStop(e);
  var elem=Rico.eventElement(e);
  img_popup.style.display='block';
  var imgPos=Rico.cumulativeOffset(elem);
  img_popup.src=elem.src.replace(/_s\.jpg/,'_m.jpg');
  img_popup.style.left=(imgPos.left+elem.offsetWidth+10)+'px';
  var winHt=Rico.windowHeight();
  window.status='winHt='+winHt+' imgTop='+imgPos.top
  if (imgPos.top > winHt/2) {
    img_popup.style.bottom=(winHt-imgPos.top-elem.offsetHeight)+'px';
    img_popup.style.top='';
  } else {
    img_popup.style.top=(imgPos.top)+'px';
    img_popup.style.bottom='';
  }
}

function img_mouseout(e) {
  Rico.eventStop(e);
  img_popup.style.display='none';
}

function UpdateGrid() {
  var tags=Rico.$('tags').value;
  if (tags) {
    photoGrid.resetContents(false);
    photoBuffer.fetchData=true;  // force another XML fetch
    photoBuffer.options.requestParameters=[{name:'tags',value:tags}];
    photoGrid.filterHandler();
  } else {
    alert('Please enter one or more keywords separated by commas');
  }
}
</script>

<style type="text/css">
.ricoLG_bottom div.ricoLG_cell { height:80px; }  /* thumbnails are 75x75 pixels */
#explanation * { font-size: 8pt; }
</style>

</head>

<body>

<table id='explanation' border='0' cellpadding='0' cellspacing='5' style='clear:both'><tr valign='top'><td>
<form onsubmit='UpdateGrid(); return false;'>
<p>Get <a href="http://www.flickr.com">Flickr</a> photos tagged with these keywords (separate words with commas):
<p><input type='text' id='tags'>
<input type='submit' value='Get Photos'>
</form>
</td><td>
<p>Base Library: 
<script type='text/javascript'>
document.write(Rico.Lib+' '+Rico.LibVersion);
</script>
<hr>
When fetching data, this script issues an XMLHttpRequest to a proxy script which uses the Flickr API
to process the query and format the response in the Rico LiveGrid XML format.
<p>Try moving your cursor over each photo...
</td>
<td>
<?php
//require "info.php";
?>
</td>
</tr></table>

<p class="ricoBookmark"><span id="photogrid_bookmark">&nbsp;</span></p>
<table id="photogrid" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
  <tr>
	  <th>Photo</th>
	  <th>Title</th>
	  <th>Owner</th>
	  <th>Date Taken</th>
	  <th>Tags</th>
  </tr>
</table>

<img id='img_popup' style='display:none;position:absolute;'>

</body>
</html>

