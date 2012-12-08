<?php

/**                                                                                                                          
 * MediaWiki rssMedia Extension                                                                                          
 * {{php}}{{Category:Extensions|rssMedia}}                                                                               
 * @package MediaWiki                                                                                                        
 * @subpackage Extensions                                                                                                    
 * @author Daniel Yount  icarusfactor factorf2@yahoo.com                                                                     
 * @licence GNU General Public Licence 3.0 or later                                                                          
 *
 * Installation:                                                                                                                
 * install this file in                                                                                                       
 *                                                                                                                              
 *  ${IP}/extensions/rssMedia/rssMedia.php                                                                                   
 *                                                                                                                             
 * and add the following line at the end of
 * ${IP}/LocalSettings.php :                                                         
 *                                                                                                                             
 * require_once("$IP/extensions/rssMedia/rssMedia.php");                                                                    
**/     

define('RSSMEDIA_VERSION','0.5');

$wgHooks['LanguageGetMagic'][] = 'wfrssMediaLanguageGetMagic';
$wgExtensionFunctions[] = 'wfSetuprssMedia';




/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
**/
if(!defined('MEDIAWIKI')){
	echo("This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die(-1);
}


function wfrssMediaLanguageGetMagic(&$magicWords,$langCode = 0) {
        $magicWords['rssmedia'] = array(0,'rssmedia');
        return true;
}
 
function wfSetuprssMedia() {
        global $wgParser;
        $wgParser->setFunctionHook('rssmedia','wfRenderrssMedia');
        return true;
}




/**
 * An array of extension types and inside that their names, versions, authors and urls. This credit information gets added to the wiki's Special:Version page, allowing users to see which extensions are installed, and to find more information about them.
**/
$wgExtensionCredits['parserhook'][] = array(
        'name'          =>      'rssMedia',
        'version'       =>      RSSMEDIA_VERSION ,
        'author'        =>      'Daniel Yount @icarusfactor factorf2@yahoo.com',
        'url'           =>      'N/A',
        'description'   =>      'Creates a secure iframe / HTML ogg mp3 player '
);

function wfRenderrssMedia( &$parser )
	{
        $html='';
        $control_start=0;
        $control_has=0;
        $itemcount=0;
        $maxitems=1;
        $rsstitle   = array(); 
        $rsssubject = array();
        $rssdate    = array();
        $rsslink    = array();
        //$rssmedia="oga";
        $rssfeed ="FEED";
        $rssmedia="oga";
        $rss_stream="STREAM";
        $rss_desc="DESCRIPTION"; 
        $rss_title="TITLE"; 

        $resultrss = array();  //and OR array if any item finds match mark it and it will be posted to output.
        $arr_count=0;

                  
        $argv = array();
        foreach (func_get_args() as $arg) if (!is_object($arg)) {
                if (preg_match('/^(.+?)\\s*=\\s*(.+)$/',$arg,$match)) $argv[$match[1]]=$match[2];
        }

             
        if(isset($argv['feed']))          {  $rssfeed = $argv['feed']; } else { return $html; }; 
        if(isset($argv['media']))       {  $rssmedia = $argv['media']; } else { $rssmedia = 'oga'; }; 
        if(isset($argv['startswith'])) { $control_start = 1;$starts  = $argv['startswith'];  }
        if(isset($argv['has']))           { $control_has   = 1;$hasthis = $argv['has']; }


        $width  = 675; 
        $height = 240; 
        $scrolling='no';

                
                      
         require_once( 'autoloader.php' );             
        

        $feed = new SimplePie();
        $feed->set_feed_url( $rssfeed );
        //$feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();

         // Load DB into local RSS array.
        foreach ($feed->get_items() as $item): 
          $rsstitle[   $itemcount ] =  $item->get_title(); 
          $rsssubject[ $itemcount ] =  $item->get_description(true);
          $rssdate[    $itemcount ] =  $item->get_date( 'l jS \of F Y h:i:s A' );
          if ($enclosure = $item->get_enclosure())
	  {
	   $rsslink[   $itemcount  ] = $enclosure->get_link();
	  }          
          else
          {
           $rsslink[    $itemcount ] =  $item->get_link();
          } 

          $itemcount++;
        endforeach;
         
        //Get array items count    
        $arr_count = count( $rsstitle );  


        if( $control_start == 1 ) {
                                 $itemcount = 0;
                                 while( $itemcount <= $arr_count )
                                  {
                                   $pattern = '/^'.$starts.'/';
                                   preg_match($pattern, $rsstitle[$itemcount] , $matches);                                                               
                                   // add tick to item array to know if match was found here.                                  
                                   if( $matches == false ) { $resultrss[$itemcount] = 1; }
                                   $itemcount++;
                                  }                      

                                }

        if( $control_has == 1 ) {
                                $itemcount = 0;
                                while( $itemcount <= $arr_count )
                                  {
                                   $pattern = '/'.$hasthis.'/';
                                   preg_match($pattern, $rsstitle[$itemcount] , $matches);                                                                   
                                   // add tick to item array to know if match was found here. 
                                   //check if has been marked off list already.                                 
                                   if( $matches == false ) { $resultrss[$itemcount] = 1; }                                  
                                   $itemcount++;
                                  }                      
                              
                              }

       //This will be the url to the php HTML segment to embed in the iframe. Variables will be added dynamically.
       $url= "/extensions/rssMedia/mediaplayer.php";  
       //Now run array to find what items are tick marked and post them to output.    
       $itemcount = 0;
       $maxcount=0;      
       //$rss_stream="http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3";       
       
 
       while( $itemcount <= $arr_count )
            {  
            

             if( $resultrss[ $itemcount ] == 0 )
               {
                    if( $maxcount >= $maxitems ) { break; }
                     $rss_stream =  $rsslink[$itemcount];
                     $rss_title     =  $rsstitle[$itemcount];
                     $rss_desc    =  $rsssubject[$itemcount];
                    $maxcount++; 
               }
             $itemcount++;
            }                   
        
         //catch empty values and fill them with dummy values.
         if ( !$rss_stream) { $rss_stream="NOSTREAM";  }   
         if ( !$rss_title     ) { $rss_title="NOTITLE";  }
         if ( !$rss_desc     ) { $rss_desc="NODESC";  }

        $data = array('feed'=>$rssfeed, 'stream'=>$rss_stream  ,  'type'=>$rssmedia ,  'title'=>$rss_title   , 'desc'=>$rss_desc   );

        $uquery = http_build_query($data,'','&');
     
        $urlquery = $url.'?'.$uquery;
	 
        $html .= '<iframe height='.$height.' width='.$width.' frameborder=0 scrolling="'.$scrolling.'" src ="'.$urlquery.'" ></iframe>';        
	return $parser->insertStripItem( $html, $parser->mStripState );
         
	}

?>





