<?php

/**
 * Backend Search Addon
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 *
 * @package redaxo4
 * @version $Id: config.inc.php,v 1.4 2008/02/23 13:29:11 kills Exp $
 */

$mypage = 'be_search';

/* Addon Parameter */
$REX['ADDON']['rxid'][$mypage] = '256';
$REX['ADDON']['page'][$mypage] = $mypage;
//$REX['ADDON']['name'][$mypage] = 'Backend Search';
//$REX['ADDON']['perm'][$mypage] = 'be_search[]';
$REX['ADDON']['version'][$mypage] = '1.0';
$REX['ADDON']['author'][$mypage] = 'Markus Staab';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
//$REX['PERM'][] = 'be_search[]';
if ($REX['REDAXO'])
{
  require $REX['INCLUDE_PATH'].'/addons/be_search/extensions/extension_common.inc.php';
  $I18N_BE_SEARCH = new i18n($REX['LANG'], $REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/lang');

  // Include Extensions
  if(!isset($page) || $page == 'structure' || $page == '')
  {
    require $REX['INCLUDE_PATH'].'/addons/be_search/extensions/extension_search_structure.inc.php';
    rex_register_extension('PAGE_STRUCTURE_HEADER', 'rex_a256_search_structure');
  }
  elseif($page == 'content')
  {
    require $REX['INCLUDE_PATH'].'/addons/be_search/extensions/extension_search_structure.inc.php';
    rex_register_extension('PAGE_CONTENT_HEADER', 'rex_a256_search_structure');
  }
  elseif ($page == 'medienpool')
  {
    require $REX['INCLUDE_PATH'].'/addons/be_search/extensions/extension_search_modules.inc.php';
    rex_register_extension('PAGE_MEDIENPOOL_HEADER', 'rex_a256_search_mpool');
  }
}
?>