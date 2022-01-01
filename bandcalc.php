<center>
<link href="https://fonts.googleapis.com/css?family=PT+Mono&display=swap" rel="stylesheet">
<style>
	.results{background-color:#ccc;border:5px groove gray; padding:15px;}
	.resulttime{background:linear-gradient(to bottom, #FF5, #5FF);padding:5px;}
	body{font-family; 'PT+Mono', monospace;}
</style>
	<title>BandCalc - Simple calculator for full album length on bandcamp.</title>
<body style="background-color:#777;font-family; 'PT+Mono', monospace;">
<div style="width:500;background-color:#aaa;padding:15px;border:5px groove gray; ">

	<br><b><u><font size=4>Bandcalc</u></b></font><br><br>
Simply enter the album URL and click the button to calculate the length of an album on bandcamp.<br><br><br><br>

<form method="post" style="background-color:#bbb;padding:10px" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<b>album url:</b> <input type="text" name="artisturl"><br><br>
	
  <input type="submit" name="submit" value="Calculate Time">  
</form>

<br>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['artisturl']==""){
//get artist and album
	$artist=$_POST['artistn'];
	$album=$_POST['albumn'];
	
	
	
	
	$artist = str_replace(' ', "", $artist);
	$album = str_replace(' ', "-", $album);
	$artist = str_replace('>', "", $artist);
	$album = str_replace('>', "-", $album);
	$artist = str_replace('<', "", $artist);
	$album = str_replace('<', "-", $album);
	$artist = str_replace(',', "", $artist);
	$artist = str_replace('?', "", $artist);
	$album = str_replace('?', "-", $album);
	$album = str_replace(',', "", $album);
	
	
	$album = strtolower($album);
	$artist = strtolower($artist);
	
	
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); 
        curl_setopt($ch, CURLOPT_URL, "https://$artist.bandcamp.com/album/$album");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//grab html
	$output = curl_exec($ch);
//split by tag openings
	$test = preg_split('/\</', $output);
//get track times
	$result = preg_grep('/time\ssecondaryText..\n./', $test);
//trim out grep pattern
	$arr = preg_replace('/span\sclass\=\"time\ssecondaryText\"\>/','',$result);
//(debugging vestige) put these into a different array and echo
	foreach ($arr as &$value) {$values[] = $value;} unset($value);

function sum_the_time($values) {
      $times = $values;
      $seconds = 0;
      foreach ($times as $time)
      { list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;      $seconds += $minute*60;        $seconds += $second;}
 $hours = floor($seconds/3600);      $seconds -= $hours*3600;      $minutes  = floor($seconds/60);
      $seconds -= $minutes*60;      if($seconds < 9)      {      $seconds = "0".$seconds;
      }      if($minutes < 9)      {      $minutes = "0".$minutes;
      }        if($hours < 9)
      {      $hours = "0".$hours;
      }      return "{$hours}:{$minutes}:{$seconds}";}

$result = sum_the_time($values);


if($result!='00:00:00'){
echo "<div class='results'><h3>$album by $artist has " . count($values) . " tracks. <br>Total runtime is <span class='resulttime'>$result</span></h3></div>";
}else{echo 'you have entered an invalid artist or album';}

echo "<br>";

foreach ($values as &$value) {echo $value . "<br>";} unset($value);

curl_close($ch);
}

else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['artisturl']!="") {
//get artist and album
	
	
	
	
	$artisturl=$_POST['artisturl'];
	
	
	
	
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); 
        curl_setopt($ch, CURLOPT_URL, "$artisturl");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//grab html
	$output = curl_exec($ch);
//split by tag openings
	$test = preg_split('/\</', $output);
//get track times
	$result = preg_grep('/time\ssecondaryText..\n./', $test);
//trim out grep pattern
	$arr = preg_replace('/span\sclass\=\"time\ssecondaryText\"\>/','',$result);
//(debugging vestige) put these into a different array and echo
	foreach ($arr as &$value) {$values[] = $value;} unset($value);

function sum_the_time($values) {
      $times = $values;
      $seconds = 0;
      foreach ($times as $time)
      { list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;      $seconds += $minute*60;        $seconds += $second;}
 $hours = floor($seconds/3600);      $seconds -= $hours*3600;      $minutes  = floor($seconds/60);
      $seconds -= $minutes*60;      if($seconds < 9)      {      $seconds = "0".$seconds;
      }      if($minutes < 9)      {      $minutes = "0".$minutes;
      }        if($hours < 9)
      {      $hours = "0".$hours;
      }      return "{$hours}:{$minutes}:{$seconds}";}

$result = sum_the_time($values);


if($result!='00:00:00'){
echo "<div class='results'><h3>$artisturl has " . count($values) . " tracks. <br>Total runtime is <span class='resulttime'>$result</span></h3></div>";
}else{echo 'you have entered an invalid artist or album';}

echo "<br>";

foreach ($values as &$value) {echo $value . "<br>";} unset($value);

curl_close($ch);
}
   else{
   
   
   echo "Click the button to calculate.";
   
   }
   
   
   
?>
   
   
   
  
	<br><br><br>
<font size=2>made by <a href="https://cybergrunge.net">cybergrunge.net</a></font><br>
   <font size=2>Consider buying me a pack of smokes if this is useful :)
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_donations"><input type="hidden" name="business" value="carrierm89@gmail.com"><input type="hidden" name="currency_code" value="USD"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button"><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></i>
	</font>
	
	
	
	
	
	
	
	
	
	
<?
/*                notes   notes   notes   notes   notes   notes
   notes   notes   notes   notes   notes   notes   notes
   notes   notes   notes   notes   notes   notes   notes



<div class="band-navbar-wrapper flex"> 		<-----  div for band navbar


    <div id="name-section" >			<----- album and artist name
        <h2 class="trackTitle">            <------- albums are refered to as tracks by bandcamp
            Turgid            
        </h2>
        <h3 style="margin:0px;">by 
        <span> 
          <a href="https://licknand.bandcamp.com">LickNand</a>
          </span>        
        </h3>
    </div>


<div id="tralbumArt">       
<a class="popupImage" href="https://f4.bcbits.com/img/a3116347024_10.jpg">  
<img src="https://f4.bcbits.com/img/a3116347024_16.jpg">						<------- album art src
</a></div>



 <div class="inline_player "> 				<----- player div (not fun)
 
 
 
<table class="track_list track_table" id="track_table">					<----- tracks are in this id = track_table



<tr class="track_row_view linked" rel="tracknum=1">         <------ "tracknum" identifies the track

																	see below use 
																		aria-label="Play
																	to get track title
																	
																	class="time secondaryText" for length
																	
                        
<td class="play-col"><a role="button" aria-label="Play Sedated Lysol Hallows">
<div class="play_status disabled"></div></a></td>
<td class="track-number-col"><div class="track_number secondaryText">1.</div></td>
<td class="title-col">
    <div class="title">    
        <a href="/track/sedated-lysol-hallows"><span class="track-title">Sedated Lysol Hallows</span></a>
        <span class="time secondaryText">
            02:25
        </span>
    </div> 
</td>




<h3 class="credits-label">credits</h3>						<----- release date (boring)
            <div class="tralbumData tralbum-credits">
                released September 23, 2021
            </div>



<h3 class="tags-label">tags</h3>												<------- tags, boring
        <div class="tralbumData tralbum-tags tralbum-tags-nu hidden">
            <h3><span class="tags-inline-label">Tags</span></h3>











originaL:
	$ch = curl_init("https://licknand.bandcamp.com/");
	$fp = fopen("index.html", "r");
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	htmlspecialchars(curl_exec($ch));
	if(curl_error($ch)) {fwrite($fp, curl_error($ch));}
	curl_close($ch);
	fclose($fp);
*/
?>
