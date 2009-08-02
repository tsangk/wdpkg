<a href="http://www.tinycounter.com" target="_blank" title="free counter"><img border="0" alt="free counter" src="http://mycounter.tinycounter.com/index.php?user=tsangk"></a> pages have been processed since the 1st of Aug. 2009 <br>
<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/json.js">
function show()
{
document.getElementById('info').style.display = 'inline';
document.getElementById('wait').style.display = 'none';
}
</script>
 	
	<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/combined.js"></script>
	
 	<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/OZONE.js"></script>
 	<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/dialog/OZONE.dialog.js"></script>

 	
 
 	

 	
	

 	
 	<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta http-equiv="content-language" content="en"/>
 	
 	<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/WIKIDOT.js"></script>
 	<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/WIKIDOT.page.js"></script>
 	<script type="text/javascript" src="http://gurus.wikicomplete.info/common--javascript/WIKIDOT.editor.js"></script>
 	
   	<style type="text/css" id="internal-style"> 
 @import url(http://gurus.wikicomplete.info/common--modules/css/wiki/pagestagcloud/PagesTagCloudModule.css);
 
 
   		
   		   			@import url(http://gurus.wikicomplete.info/common--theme/base/css/style.css?0); 		   		
     </style>


<?php
if(isset($_GET["id"]))
{
$idx=(int)$_GET["id"];
$idx-=1;
}
else
{
$idx=0;
}
$wiki=$_GET["wiki"];
$url="http://".$wiki.".wikidot.com/";
$pkfile=file_get_contents($_GET["file"])or die("<b>Error:</b> Error in package list file!");
$page=explode("##### break",$pkfile);
$count=count($page);
$countcid=(int)$_GET["id"];
if($countcid>=$count)
{
$die='You have completed installing a package using Wikidot Package Installer V2 beta.<br>You may now:<br><br><a href="http://'.$wiki.'.wikidot.com/">Visit you own wiki</a><br>Go to <a href="http://packages.wikidot.com/">Packages @ Wikidot</a><br>or go to <a href="http://wikidot.com">Wikidot.com</a>';
//die($die);
echo $die;
exit;
end;
}
//preg_match('/## *page (.*) *##/s',$page[$idx],$matches);
preg_match('/## *([a-z]{4}) (.*) *##/s',$page[$idx],$matches);
$par=explode("|",$matches[2]);
$command=$matches[1];
foreach($par as $id => $p)
{
preg_match('/(.*)="(.*)"/',$p,$matches);
$parvar[$id]=$matches[1];
$parval[$id]=$matches[2];
}

foreach($parvar as $id => $variable)
{
$par[$variable]=$parval[$id];
}
?>
<div id="wait" style="display:inline;">Please Wait</div>
<!--<div id="info" style="display:none;"> -->
<?php
if($command=="page")
{
$paroutput="/edit/true";
if(isset($par['parent']))
{
$paroutput.="/parentPage/".$par["parent"];
}
if(isset($par["tags"]))
{
$paroutput.="/tags/".$par["tags"];
}
if(isset($par["title"]))
{
$paroutput.="/title/".$par["title"];
}
$current=$url.$par["page"].$paroutput;
$package=file_get_contents($par["file"])or die("<b>Error:</b> Error in syntax!");
?>
<i>Installing page <?php echo $par["page"];?></i>
<br><form><textarea name="text_area" cols="80" width="100%"><?php echo $package; ?></textarea></br>
<input type="button" value="Select All" onClick="javascript:this.form.text_area.focus();this.form.text_area.select();">
<div class="code">Click on the Select All button and drag and drop all of the contents in the top textbox to the Wikidot one, scroll down and click save.</div>
<?php
}
else if($command=="conf")
{
$paroutput="admin:manage/start/".$par["type"];
$current=$url.$par["page"].$paroutput;
?>
<i>Configuring Wiki to work with package...</i><br><b>Instuctions:</b><br><div class="code">
<?php
echo $par["info"];
?>
</div>
<?php
}
else
{
die("<b>Error:</b> Error in syntax!");
}
?>

<br>Click Next when completed.   <?php
echo '<a href="http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?id=';
echo $idx+2;
echo '&file='.$_GET["file"].'&wiki='.$_GET["wiki"];
echo '">Next Step</a>';
?></form></div>
<iframe name="wikidot" src="<?php echo $current; ?>" width="100%" height="60%" onload="alert("me")">You need a browser that supports iframes to install</iframe>