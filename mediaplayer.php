<?php   
        ini_set( 'display_errors', 1 );
        error_reporting(-1);
        //phpinfo();

 
        
//        echo $_GET["feed"];
        $streamfeed  = $_GET["feed"]; 
        $streamitem  = $_GET["stream"];       
        $streamtype  = $_GET["type"]; 
        $streamtitle   = $_GET["title"]; 
        $streamdesc  = $_GET["desc"]; 

       
$output = ''; 

$output .='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
$output .='<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" ><HEAD><META http-equiv="content-type" content="text/html; charset=UTF-8" />';
$output .= '<link href="/extensions/rssMedia/skin/blue.flag/jplayer.blue.flag.css" rel="stylesheet" type="text/css" /> ';
$output .= '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>';
$output .= '<script type="text/javascript" src="/extensions/rssMedia/js/jquery.jplayer.min.js"></script>';
$output .= '<script type="text/javascript">';


$output .= '$(document).ready(function(){';

$output .= '$("#jquery_jplayer_1").jPlayer({';
$output .= '		ready: function () {';
$output .= '			$(this).jPlayer("setMedia", {';

//check for type.
if( $streamtype == "oga"  ) 
   {
    $output .= '	                  oga:"'.$streamitem.'"';
   }
else 
   {
     $output .= '			  mp3:"'.$streamitem.'"';
   } 


$output .= '			});';
$output .= '		},';
$output .= '		swfPath: "/extensions/rssMedia/js",';

//check for type.
if( $streamtype == "oga"  ) 
   {
     $output .= '		supplied: "oga",'; 
   }
else
   {
    $output .= '		supplied: "mp3",';
   }
 
$output .= '		wmode: "window"';
$output .= '	});';
$output .= '});';

$output .= '</script>';

$output .='</HEAD><BODY>';

$output .='<div id="container">'.$streamtitle.'</div>'; 

$output .= '<div id="left">';

$output .= '		<div id="jquery_jplayer_1" class="jp-jplayer"></div>';


$output .= '		<div id="jp_container_1" class="jp-audio">';
$output .= '			<div class="jp-type-single">';
$output .= '				<div class="jp-gui jp-interface">';
$output .= '					<ul class="jp-controls">';
$output .= '						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>';
$output .= '						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>';
$output .= '						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>';
$output .= '						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>';
$output .= '						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>';
$output .= '						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>';
$output .= '					</ul>';
$output .= '					<div class="jp-progress">';
$output .= '						<div class="jp-seek-bar">';
$output .= '							<div class="jp-play-bar"></div>';

$output .= '						</div>';
$output .= '					</div>';
$output .= '					<div class="jp-volume-bar">';
$output .= '						<div class="jp-volume-bar-value"></div>';
$output .= '					</div>';
$output .= '					<div class="jp-current-time"></div>';
$output .= '					<div class="jp-duration"></div>';
$output .= '					<ul class="jp-toggles">';
$output .= '						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>';
$output .= '						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>';
$output .= '					</ul>';
$output .= '				</div>';

$output .= '				<div class="jp-title">';
$output .= '					<ul>';

//check for type.
if( $streamtype == "oga"  ) 
   {
      $output .= '						<li> <A HREF="'.$streamitem.'" >CURRENT OGG</a> </li>';  
   }
else
   {
      $output .= '						<li> <A HREF="'.$streamitem.'" >CURRENT MP3</a> </li>';
   }

$output .= '					</ul>';

$output .= '					<ul>';
$output .= '						<li> <A HREF="'.$streamfeed.'" >SOURCE RSS</a>  </li>';
$output .= '					</ul>';

$output .= '				</div>';

$output .= '				<div class="jp-no-solution">';
$output .= '					<span>Update Required</span>';
$output .= '					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.';
$output .= '				</div>';
$output .= '			</div>';
$output .= '		</div>';

$output .='</div>';

$output .='<div id="content"><p>'.$streamdesc.'</p></div>';







//$output .= '<div style="background-color: #DDDDDD; width:600px;height: 201px;" >';

//$output .= '  <div style="float: right; background-color: #AAAAAA; width:620px; height: 250px;" >';
//$output .= '					<ul>';
//$output .= '						<li>Cro Magnon Man</li>';
//$output .= '					</ul>';
//$output .= '					<ul>';
//$output .= '						<li> <A HREF="http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3" >MP3</a>  </li>';
//$output .= '					</ul>';
//$output .= '  </div>';

//$output .= '</div>';



$output .='</BODY>';


echo $output; 
  

?>