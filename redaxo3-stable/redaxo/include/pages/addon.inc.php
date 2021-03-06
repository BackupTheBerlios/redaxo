<?php

/** 
 *  
 * @package redaxo3 
 * @version $Id: addon.inc.php,v 1.1 2008/03/26 13:35:36 kills Exp $ 
 */

include_once $REX['INCLUDE_PATH']."/functions/function_rex_other.inc.php";
include_once $REX['INCLUDE_PATH']."/functions/function_rex_addons.inc.php";

rex_title($I18N->msg("addon"), "");

$ADDONS = rex_read_addons_folder();
$addonname = isset ($addonname) && array_search($addonname, $ADDONS) !== false ? $addonname : '';
$SP = true; // SHOW PAGE ADDON LIST

// ----------------- HELPPAGE
if (isset ($spage) && $spage == 'help' && $addonname != '')
{
  echo '<table class="rex" style="table-layout:auto;" cellpadding="5" cellspacing="1">';
  echo '<tr><th>'.$I18N->msg("addon_help").' '.$addonname.'</th></tr>';
  echo '<tr><td>';
  if (!is_file($REX['INCLUDE_PATH']."/addons/$addonname/help.inc.php"))
  {
    echo $I18N->msg("addon_no_help_file");
  }
  else
  {
    include $REX['INCLUDE_PATH']."/addons/$addonname/help.inc.php";
  }
  echo '&nbsp;</td></tr>';
  echo '<tr><td><a href="index.php?page=addon">'.$I18N->msg("addon_back").'</a></td></tr>';
  echo '</table>';
  $SP = false;
}

// ----------------- FUNCTIONS
// $addonname pr�fen ob vorhanden
if ($addonname != '')
{
  if (isset ($install) and $install == 1) // ----------------- ADDON INSTALL
  {
    if (($errmsg = rex_install_addon($ADDONS, $addonname)) === true)
    {
      $errmsg = $I18N->msg("addon_installed", $addonname);
    }
  }
  elseif (isset ($activate) and $activate == 1) // ----------------- ADDON ACTIVATE
  {
    if (($errmsg = rex_activate_addon($ADDONS, $addonname)) === true)
    {
      $errmsg = $I18N->msg("addon_activated", $addonname);
    }
  }
  elseif (isset ($activate) and $activate == 0) // ----------------- ADDON DEACTIVATE
  {
    if (($errmsg = rex_deactivate_addon($ADDONS, $addonname)) === true)
    {
      $errmsg = $I18N->msg("addon_deactivated", $addonname);
    }
  }
  elseif (isset ($uninstall) and $uninstall == 1) // ----------------- ADDON UNINSTALL
  {
    if (($errmsg = rex_uninstall_addon($ADDONS, $addonname)) === true)
    {
      $errmsg = $I18N->msg("addon_uninstalled", $addonname);
    }
  }
  elseif (isset ($delete) and $delete == 1) // ----------------- ADDON DELETE
  {
    if (($errmsg = rex_delete_addon($ADDONS, $addonname)) === true)
    {
      $errmsg = $I18N->msg("addon_deleted", $addonname);
      $addonkey = array_search( $addonname, $ADDONS);
      unset($ADDONS[$addonkey]);
    }
  }
}

// ----------------- OUT
if ($SP)
{

  // Vergleiche Addons aus dem Verzeichnis addons/ mit den Eintraegen in include/addons.inc.php
  // Wenn ein Addon in der Datei fehlt oder nicht mehr vorhanden ist, aendere den Dateiinhalt.
  if (count(array_diff(array_keys(array_flip($ADDONS)), array_keys($REX['ADDON']['install']))) > 0 || 
      count(array_diff(array_keys($REX['ADDON']['install']), array_keys(array_flip($ADDONS)))) > 0)
  {

    if (($state = rex_generateAddons($ADDONS)) !== true)
    {
      $errmsg = $state;
    }
  }

  if (isset ($errmsg) and $errmsg != "")
    echo '<table border="0" cellpadding="5" cellspacing="1" width="770"><tr><td class="warning">'.$errmsg.'</td></tr></table><br />';

  if (!isset ($user_id))
  {
    $user_id = '';
  }
  echo '<form action="index.php" method="post">
      <input type="hidden" name="page" value="user">
      <input type="hidden" name="user_id" value="'.$user_id.'">
  
      <table class="rex" style="table-layout:auto;" cellpadding="5" cellspacing="1">
      <colgroup>
        <col width="*"/>
        <col width="150px"/>
        <col width="150px"/>
        <col width="120px"/>
        <col width="120px"/>
      </colgroup>
      <tr>
        <th>'.$I18N->msg("addon_hname").'</th>
        <th style="text-align: center;">'.$I18N->msg("addon_hinstall").'</th>
        <th style="text-align: center;">'.$I18N->msg("addon_hactive").'</th>
        <th colspan="2" style="text-align: center;">'.$I18N->msg("addon_hdelete").'</th>
      </tr>';

  foreach ($ADDONS as $cur)
  {
    $delete = '<a href="index.php?page=addon&amp;addonname='.$cur.'&amp;delete=1" onclick="return confirm(\''.$I18N->msg('delete').' ?\')">'.$I18N->msg("addon_delete").'</a>';

    if ($REX['ADDON']['install'][$cur] == 1)
    {
      $install = $I18N->msg("addon_yes").' - <a href="index.php?page=addon&amp;addonname='.$cur.'&amp;install=1">'.$I18N->msg("addon_reinstall").'</a>';
      $uninstall = '<a href="index.php?page=addon&amp;addonname='.$cur.'&amp;uninstall=1" onclick="return confirm(\''.$I18N->msg("addon_uninstall").' ?\')">'.$I18N->msg("addon_uninstall").'</a>';
    }
    else
    {
      $install = $I18N->msg("addon_no").' - <a href="index.php?page=addon&amp;addonname='.$cur.'&amp;install=1">'.$I18N->msg("addon_install").'</a>';
      $uninstall = $I18N->msg("addon_notinstalled");
    }
    
    if ($REX['ADDON']['status'][$cur] == 1)
    {
      $status = $I18N->msg("addon_yes").' - <a href="index.php?page=addon&amp;addonname='.$cur.'&amp;activate=0">'.$I18N->msg("addon_deactivate").'</a>';
    }
    elseif ($REX['ADDON']['install'][$cur] == 1)
    {
      $status = $I18N->msg("addon_no").' - <a href="index.php?page=addon&amp;addonname='.$cur.'&amp;activate=1">'.$I18N->msg("addon_activate").'</a>';
    }
    else
    {
      $status = $I18N->msg("addon_notinstalled");
    }

    echo ' <tr>
          <td>'.$cur.' [<a href="index.php?page=addon&amp;spage=help&amp;addonname='.$cur.'">?</a>]</td>
          <td>'.$install.'</td>
          <td>'.$status.'</td>
          <td>'.$uninstall.'</td>
          <td>'.$delete.'</td>
        </tr>'."\n   ";
  }

  echo '</table>';
  echo '</form>';
}
?>