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
 * @version $Id: index.inc.php,v 1.17 2007/06/07 11:02:10 kills Exp $
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
    <?php include dirname(__FILE__). '/../help.inc.php'; ?>
  </div>
</div>
<?php

include $REX['INCLUDE_PATH'].'/layout/bottom.php';

?>