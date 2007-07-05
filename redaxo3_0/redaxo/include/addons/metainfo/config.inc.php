<?php

/**
 * MetaForm Addon
 * 
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * 
 * @package redaxo3
 * @version $Id: config.inc.php,v 1.11 2007/07/05 19:48:05 kills Exp $
 */

$mypage = 'metainfo';

if ($REX['REDAXO'])
  $I18N_META_INFOS = new i18n($REX['LANG'], $REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/lang');

$REX['ADDON']['rxid'][$mypage] = '62';
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['name'][$mypage] = 'Meta Infos';
$REX['ADDON']['perm'][$mypage] = 'metainfo[]';

$REX['PERM'][] = 'metainfo[]';

if ($REX['REDAXO'])
{
  // Include Extensions
  if (isset ($page))
  {
    require_once ($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/extensions/extension_common.inc.php');

    if ($page == 'content' && isset ($mode) && $mode == 'meta')
    {
      require_once ($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/extensions/extension_art_metainfo.inc.php');
    }
    elseif ($page == 'structure')
    {
      require_once ($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/extensions/extension_cat_metainfo.inc.php');
    }
    elseif ($page == 'medienpool' && isset ($subpage) && $subpage == 'detail')
    {
      require_once ($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/extensions/extension_med_metainfo.inc.php');
    }
    elseif ($page == 'import_export')
    {
      require_once ($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/extensions/extension_cleanup.inc.php');
    }
  }
}

require_once ($REX['INCLUDE_PATH'] . '/addons/' . $mypage . '/extensions/extension_oof_metainfo.inc.php');

?>