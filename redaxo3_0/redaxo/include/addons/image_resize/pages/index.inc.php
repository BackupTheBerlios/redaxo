<?php

/**
 * Image-Resize Addon
 * 
 * @author office[at]vscope[dot]at Wolfgang Hutteger
 * @author <a href="http://www.vscope.at">www.vscope.at</a>
 * 
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * 
 * @package redaxo3
 * @version $Id: index.inc.php,v 1.16 2007/05/25 08:50:28 kills Exp $
 */

include $REX['INCLUDE_PATH'].'/layout/top.php';

include_once $REX['INCLUDE_PATH']. '/addons/'. $page .'/functions/function_folder.inc.php';

if (isset($subpage) and $subpage == 'clear_cache'){
    $c = 0;
    $files = readFolderFiles($REX['INCLUDE_PATH'].'/generated/files/');
    if(is_array($files)){
          foreach($files as $var){
              if(eregi('^'. $REX['TEMP_PREFIX'] .'cache_resize___',$var)){
                  unlink($REX['HTDOCS_PATH'].'files/'.$var);
                  $c++;
              }
          }
    }
    $msg = 'Cache cleared - '. $c .' cachefiles removed';
}


// Build Subnavigation 
$subpages = array(
  array('clear_cache','Resize Cache l&ouml;schen'),
);

rex_title('Image Resize Addon ',$subpages);

if (isset($msg) and $msg != '') echo '<table border="0" cellpadding="5" cellspacing="1" width="770"><tr><td class="warning">'.$msg.'</td></tr></table><br />';

?>
<div class="rex-addon-output">
<h2>Instructions</h2>
<div class="rex-addon-content">
<p><b>Features:</b><br /><br />
    Makes resize of images on the fly, with extra cache of resized images so<br />
    performance loss is extremly small.<br />
    <br />
    
    <b>Usage:</b><br /><br />
    
    call an image that way <b>index.php?rex_resize=100w__imagefile</b><br />
    to resize the imagefile to width = 100<br />
    other methods: w = width h=height a=automatic<br />
</p>
</div>
</div>
<?php

include $REX['INCLUDE_PATH'].'/layout/bottom.php';

?>