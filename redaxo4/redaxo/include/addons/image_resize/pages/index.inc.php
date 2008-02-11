<?php

/**
 * Image-Resize Addon
 *
 * @author office[at]vscope[dot]at Wolfgang Hutteger
 * @author markus.staab[at]redaxo[dot]de Markus Staab
 * @author jan.kristinus[at]yakmara[dot]de Jan Kristinus
 *
 * @package redaxo4
 * @version $Id: index.inc.php,v 1.3 2008/02/11 20:13:38 kills Exp $
 */

include $REX['INCLUDE_PATH'] . '/layout/top.php';

if (isset ($subpage) and $subpage == 'clear_cache')
{
  $c = rex_thumbnail::deleteCache();
  $msg = 'Cache cleared - ' . $c . ' cachefiles removed';
}

// Build Subnavigation
$subpages = array (
  	array ('','Erkl&auml;rung'),
  	array ('config','Konfiguration'),
  	array ('clear_cache','Resize Cache l&ouml;schen'),
	);

rex_title('Image Resize', $subpages);

// Include Current Page
switch($subpage)
{
  case 'config' :
  {
    break;
  }

  default:
  {
  	if (isset ($msg) and $msg != '')
		  echo '<p class="rex-warning"><span>' . $msg . '</span></p>';
	  $subpage = 'overview';
  }
}

include $REX['INCLUDE_PATH'] . '/addons/image_resize/pages/'.$subpage.'.inc.php';

include $REX['INCLUDE_PATH'] . '/layout/bottom.php';

?>