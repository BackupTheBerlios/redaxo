<?php


/**
 *
 * @package redaxo3
 * @version $Id: setup.inc.php,v 1.67 2007/06/28 09:53:37 kills Exp $
 */

// --------------------------------------------- SETUP FUNCTIONS

/**
 * Ausgabe des Setup spezifischen Titels
 */
function rex_setuptitle($title)
{
  rex_title($title, '');


  echo '<div id="rex-stp">';
}

function rex_setupimport($import_sql, $import_archiv = null)
{
  global $REX, $I18N, $export_addon_dir;

  $err_msg = '';

  if (!is_dir($export_addon_dir))
  {
    $err_msg .= $I18N->msg('setup_03703').'<br />';
  }
  else
  {
    if (file_exists($import_sql) && ($import_archiv === null || $import_archiv !== null && file_exists($import_archiv)))
    {
      require_once $export_addon_dir.'/classes/class.tar.inc.php';
      require_once $export_addon_dir.'/functions/function_folder.inc.php';
      require_once $export_addon_dir.'/functions/function_import_export.inc.php';

      // DB Import
      $state_db = rex_a1_import_db($import_sql);
      if ($state_db['state'] === false)
      {
        $err_msg .= $state_db['message'].'<br />';
      }

      // Archiv optional importieren
      if ($state_db['state'] === true && $import_archiv !== null)
      {
        $state_archiv = rex_a1_import_files($import_archiv);
        if ($state_archiv['state'] === false)
        {
          $err_msg .= $state_archiv['message'].'<br />';
        }
      }
    }
    else
    {
      $err_msg .= $I18N->msg('setup_03702').'<br />';
    }
  }

  return $err_msg;
}

function rex_setup_is_writable($items)
{
  $res = array();

  foreach($items as $item)
  {
    $is_writable = _rex_is_writable($item);
    // 0 => kein Fehler
    if($is_writable != 0)
    {
      $res[$is_writable][] = $item;
    }
  }

  return $res;
}

// --------------------------------------------- END: SETUP FUNCTIONS



$MSG['err'] = "";
$MSG['good'] = "";

if (!isset ($checkmodus))
  $checkmodus = '';
if (!isset ($send))
  $send = '';
if (!isset ($dbanlegen))
  $dbanlegen = '';
if (!isset ($noadmin))
  $noadmin = '';

$export_addon_dir = $REX['INCLUDE_PATH'].'/addons/import_export';

// ---------------------------------- MODUS 0 | Start
if (!($checkmodus > 0 && $checkmodus < 10))
{
  rex_setuptitle('SETUP: SELECT LANGUAGE');

  echo '<ul class="rex-stp-language">
          <li><a href="index.php?checkmodus=0.5&amp;lang=de_de">DEUTSCH</a></li>
          <li><a href="index.php?checkmodus=0.5&amp;lang=en_gb">ENGLISH</a></li>
          <li><a href="index.php?checkmodus=0.5&amp;lang=es_es">ESPA&Ntilde;OL</a></li>
          <li><a href="index.php?checkmodus=0.5&amp;lang=pl_pl">POLSKI</a></li>
          <li><a href="index.php?checkmodus=0.5&amp;lang=tr_tr">TURKYE</a></li>
        </ul>';
}

// ---------------------------------- MODUS 0 | Start

if ($checkmodus == '0.5')
{
  rex_setuptitle('SETUP: START');

  echo $I18N->msg('setup_005', '<h2>', '</h2>');

  echo '<div id="rex-stp-lcns">';

  $Basedir = dirname(__FILE__);
  $license_file = $Basedir.'/../../../_lizenz.txt';
  $hdl = fopen($license_file, 'r');
  $license = nl2br(fread($hdl, filesize($license_file)));
  fclose($hdl);
  echo $license;

  echo '</div>';

  echo '<p><a href="index.php?page=setup&amp;checkmodus=1&amp;lang='.$lang.'">&raquo; '.$I18N->msg("setup_006").'</a></p>';

  $checkmodus = 0;
}

// ---------------------------------- MODUS 1 | Versionscheck - Rechtecheck

if ($checkmodus == 1)
{

  // -------------------------- VERSIONSCHECK

  if (version_compare(phpversion(), '4.3.2', '<') == 1)
  {
    $MSG['err'] .= '<li>'. $I18N->msg('setup_010', phpversion()).'</li>';
  }

  // -------------------------- SCHREIBRECHTE

  $WRITEABLE = array (
    $REX['INCLUDE_PATH'].'/master.inc.php',
    $REX['INCLUDE_PATH'].'/addons.inc.php',
    $REX['INCLUDE_PATH'].'/clang.inc.php',
    $REX['INCLUDE_PATH'].'/generated',
    $REX['INCLUDE_PATH'].'/generated/articles',
    $REX['INCLUDE_PATH'].'/generated/templates',
    $REX['INCLUDE_PATH'].'/generated/files',
    $REX['INCLUDE_PATH'].'/../../files',
    $REX['INCLUDE_PATH'].'/../../files/_readme.txt',
    $REX['INCLUDE_PATH'].'/addons/import_export/files'
  );

  $res = rex_setup_is_writable($WRITEABLE);
  if(count($res) > 0)
  {
    $MSG['err'] .= '<li>';
    foreach($res as $type => $messages)
    {
      if(count($messages) > 0)
      {
        $MSG['err'] .= '<h3>'. _rex_is_writable_info($type) .'</h3>';
        $MSG['err'] .= '<ul>';
        foreach($messages as $message)
        {
          $MSG['err'] .= '<li>'. rex_absPath($message) .'</li>';
        }
        $MSG['err'] .= '</ul>';
      }
    }
    $MSG['err'] .= '</li>';
  }
}

if ($MSG['err'] == '' && $checkmodus == 1)
{
  rex_setuptitle($I18N->msg('setup_step1'));

  echo $I18N->msg('setup_016', '<h2>', '</h2>', '<span class="rex-ok">', '</span>').'
        <p><a href="index.php?page=setup&amp;checkmodus=2&amp;lang='.$lang.'">&raquo; '.$I18N->msg('setup_017').'</a></p>';

}
elseif ($MSG['err'] != "")
{

  rex_setuptitle($I18N->msg('setup_step1'));

  echo '<h2>'.$I18N->msg('setup_headline1').'</h2>
        <ul>'.$MSG['err'].'</ul>

        <p>'.$I18N->msg('setup_018').'</p>
        <p><a href="index.php?page=setup&amp;checkmodus=1&amp;lang='.$lang.'">&raquo; '.$I18N->msg('setup_017').'</a></p>';
}

// ---------------------------------- MODUS 2 | master.inc.php - Datenbankcheck

if ($checkmodus == 2 && $send == 1)
{
  $h = @ fopen($REX['INCLUDE_PATH'].'/master.inc.php', 'r');
  $cont = fread($h, filesize('include/master.inc.php'));
  fclose($h);
  
  $cont = ereg_replace("(REX\['SERVER'\].?\=.?\")[^\"]*", "\\1".$serveraddress, $cont);
  $cont = ereg_replace("(REX\['SERVERNAME'\].?\=.?\")[^\"]*", "\\1".$serverbezeichnung, $cont);
  $cont = ereg_replace("(REX\['LANG'\].?\=.?\")[^\"]*", "\\1".$lang, $cont);
  $cont = ereg_replace("(REX\['INSTNAME'\].?\=.?\")[^\"]*", "\\1"."rex".date("YmdHis"), $cont);
  $cont = ereg_replace("(REX\['ERROR_EMAIL'\].?\=.?\")[^\"]*", "\\1".$error_email, $cont);
  $cont = ereg_replace("(REX\['DB'\]\['1'\]\['HOST'\].?\=.?\")[^\"]*", "\\1".$mysql_host, $cont);
  $cont = ereg_replace("(REX\['DB'\]\['1'\]\['LOGIN'\].?\=.?\")[^\"]*", "\\1".$redaxo_db_user_login, $cont);
  $cont = ereg_replace("(REX\['DB'\]\['1'\]\['PSW'\].?\=.?\")[^\"]*", "\\1".$redaxo_db_user_pass, $cont);
  $cont = ereg_replace("(REX\['DB'\]\['1'\]\['NAME'\].?\=.?\")[^\"]*", "\\1".$dbname, $cont);

  $h = @ fopen($REX['INCLUDE_PATH'].'/master.inc.php', 'w+');
  if ($h && fwrite($h, $cont, strlen($cont)) > 0)
  {
    fclose($h);
  }
  else
  {
    $err_msg = $I18N->msg('setup_020', '<b>', '</b>');
  }

  // -------------------------- DATENBANKZUGRIFF
  $link = @ mysql_connect($mysql_host, $redaxo_db_user_login, $redaxo_db_user_pass);
  if (!$link)
  {
    $err_msg = $I18N->msg('setup_021').'<br />';
  }
  elseif (!@ mysql_select_db($dbname, $link))
  {
    $err_msg = $I18N->msg('setup_022').'<br />';
  }
  elseif ($link)
  {
    $REX['DB']['1']['NAME'] = $dbname;
    $REX['DB']['1']['LOGIN'] = $redaxo_db_user_login;
    $REX['DB']['1']['PSW'] = $redaxo_db_user_pass;
    $REX['DB']['1']['HOST'] = $mysql_host;

    $err_msg = "";
    $checkmodus = 3;
    $send = "";
  }
  @ mysql_close($link);

}
else
{
  $serveraddress = $REX['SERVER'];
  $serverbezeichnung = $REX['SERVERNAME'];
  $error_email = $REX['ERROR_EMAIL'];
  $dbname = $REX['DB']['1']['NAME'];
  $redaxo_db_user_login = $REX['DB']['1']['LOGIN'];
  $redaxo_db_user_pass = $REX['DB']['1']['PSW'];
  $mysql_host = $REX['DB']['1']['HOST'];
}

if ($checkmodus == 2)
{

  rex_setuptitle($I18N->msg('setup_step2'));

  echo '<h2>'.$I18N->msg('setup_023').'</h2>

        <form action="index.php" method="post">
        <fieldset>
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="checkmodus" value="2" />
          <input type="hidden" name="send" value="1" />
          <input type="hidden" name="lang" value="'.$lang.'" />';
    if (isset ($err_msg) and $err_msg != '') {
      echo '<p class="rex-warning"><span>'.$err_msg.'</span></p>';
    }


  echo '
            <legend>'.$I18N->msg("setup_0201").'</legend>
            <p>
              <label for="serveraddress">'.$I18N->msg("setup_024").'</label>
              <input type="text" id="serveraddress" name="serveraddress" value="'.$serveraddress.'" />
            </p>

            <p>
              <label for="serverbezeichnung">'.$I18N->msg("setup_025").'</label>
              <input type="text" id="serverbezeichnung" name="serverbezeichnung" value="'.$serverbezeichnung.'" />
            </p>

            <p>
              <label for="error_email">'.$I18N->msg("setup_026").'</label>
              <input type="text" id="error_email" name="error_email" value="'.$error_email.'" />
            </p>
          </fieldset>

          <fieldset>
            <legend>'.$I18N->msg("setup_0202").'</legend>

            <p>
              <label for="dbname">'.$I18N->msg("setup_027").'</label>
              <input type="text" value="'.$dbname.'" id="dbname" name="dbname" />
            </p>

            <p>
              <label for="mysql_host">MySQL Host</label>
              <input type="text" id="mysql_host" name="mysql_host" value="'.$mysql_host.'" />
            </p>

            <p>
              <label for="redaxo_db_user_login">Login</label>
              <input type="text" id="redaxo_db_user_login" name="redaxo_db_user_login" value="'.$redaxo_db_user_login.'" />
            </p>

            <p>
              <label for="redaxo_db_user_pass">'.$I18N->msg("setup_028").'</label>
              <input type="text" id="redaxo_db_user_pass" name="redaxo_db_user_pass" value="'.$redaxo_db_user_pass.'" />
            </p>

            <p>
              <input class="rex-sbmt" type="submit" value="'.$I18N->msg("setup_029").'" />
            </p>
            </fieldset>
            </form>';
}

// ---------------------------------- MODUS 3 | Datenbank anlegen ...

if ($checkmodus == 3 && $send == 1)
{
  $err_msg = '';

  // -------------------------- Ben�tigte Tabellen pr�fen
  $TBLS = array (
    $REX['TABLE_PREFIX'] .'action' => 0,
    $REX['TABLE_PREFIX'] .'article' => 0,
    $REX['TABLE_PREFIX'] .'article_slice' => 0,
    $REX['TABLE_PREFIX'] .'clang' => 0,
    $REX['TABLE_PREFIX'] .'file' => 0,
    $REX['TABLE_PREFIX'] .'file_category' => 0,
    $REX['TABLE_PREFIX'] .'module_action' => 0,
    $REX['TABLE_PREFIX'] .'modultyp' => 0,
    $REX['TABLE_PREFIX'] .'template' => 0,
    $REX['TABLE_PREFIX'] .'user' => 0
  );

  if ($dbanlegen == 4)
  {
    // ----- vorhandenen seite updaten
    $import_sql = $REX['INCLUDE_PATH'].'/install/redaxo3_0_to_3_3.sql';
    $err_msg .= rex_setupimport($import_sql);
  }elseif ($dbanlegen == 3)
  {
    // ----- vorhandenen Export importieren
    if(empty($import_name))
    {
      $err_msg .= '<p>'.$I18N->msg('setup_03701').'</p>';
    }
    else
    {
      $import_sql = $export_addon_dir.'/files/'.$import_name.'.sql';
      $import_archiv = $export_addon_dir.'/files/'.$import_name.'.tar.gz';
      $err_msg .= rex_setupimport($import_sql, $import_archiv);
    }
  }elseif ($dbanlegen == 2)
  {
    // ----- db schon vorhanden, nichts tun
  }elseif ($dbanlegen == 1)
  {
    // ----- leere Datenbank und alte DB l�schen / drop
    $import_sql = $REX['INCLUDE_PATH'].'/install/redaxo3_0_with_drop.sql';
    $err_msg .= rex_setupimport($import_sql);
  }elseif ($dbanlegen == 0)
  {
    // ----- leere Datenbank und alte DB lassen
    $import_sql = $REX['INCLUDE_PATH'].'/install/redaxo3_0_without_drop.sql';
    $err_msg .= rex_setupimport($import_sql);
  }

  // Pr�fen, welche Tabellen bereits vorhanden sind
  $db = new rex_sql;
  $db->setQuery('SHOW TABLES');

  for ($i = 0; $i < $db->getRows(); $i++, $db->next())
  {
    $tblname = $db->getValue('Tables_in_'.$REX['DB']['1']['NAME']);
    if (substr($tblname, 0, strlen($REX['TABLE_PREFIX'])) == $REX['TABLE_PREFIX'])
    {
      // echo $tblname."<br />";
      if (array_key_exists($tblname, $TBLS))
      {
        $TBLS[$tblname] = 1;
      }
    }
  }

  // ----- Keine Datenbank anlegen
  if (isset($dbanlegen) && $err_msg == "")
  {
    for ($i = 0; $i < count($TBLS); $i++)
    {
      if (current($TBLS) != 1)
      {
        $err_msg .= $I18N->msg('setup_031', key($TBLS)).'<br />';
      }
      next($TBLS);
    }
  }

  if ($err_msg == "")
  {
    $send = "";
    $checkmodus = 4;
  }
}

if ($checkmodus == 3)
{

  rex_setuptitle($I18N->msg('setup_step3'));

  // -------------------------- System AddOns pr�fen
  
  require_once $REX['INCLUDE_PATH'].'/functions/function_rex_addons.inc.php';
      
  $addonErr = '';
  $ADDONS = rex_read_addons_folder();
  foreach($REX['SYSTEM_ADDONS'] as $systemAddon)
  {
    $state = true;
    
    if($state === true && !OOAddon::isInstalled($systemAddon))
      $state = rex_install_addon($ADDONS, $systemAddon);
      
    if($state === true && !OOAddon::isActivated($systemAddon))
        $state = rex_activate_addon($ADDONS, $systemAddon);
        
    if($state !== true)
      $addonErr .= '<li>'. $systemAddon .'<ul><li>'. $state .'</li></ul></li>';
  }
  
  echo '
        <form action="index.php" method="post" id="rex-stp-database">
        <fieldset>
          <input type="hidden" name="page" value="setup" />
          <input type="hidden" name="checkmodus" value="3" />
          <input type="hidden" name="send" value="1" />
          <input type="hidden" name="lang" value="'.$lang.'" />

          <legend>Datenbank anlegen</legend>
        ';

  if($addonErr != '')
  {
    echo '<p class="rex-warning"><span>';
    echo '<ul><li>';
    echo '<h3>'. $I18N->msg('setup_011', '<span class="rex-error">', '</span>') .'</h3>';
    echo '<ul>'. $addonErr .'</ul>';
    echo '</li></ul>';
    echo '</span></p>';
  }
  
  if (isset ($err_msg) and $err_msg != '')
    echo '<p class="rex-warning"><span>'.$err_msg.'<br />'.$I18N->msg('setup_033').'</span></p>';

  if (!isset ($dbchecked0))
    $dbchecked0 = '';
  if (!isset ($dbchecked1))
    $dbchecked1 = '';
  if (!isset ($dbchecked2))
    $dbchecked2 = '';
  if (!isset ($dbchecked3))
    $dbchecked3 = '';
  if (!isset ($dbchecked4))
    $dbchecked4 = '';

  switch ($dbanlegen)
  {
    case 1 :
      $dbchecked1 = ' checked="checked"';
      break;
    case 2 :
      $dbchecked2 = ' checked="checked"';
      break;
    case 3 :
      $dbchecked3 = ' checked="checked"';
      break;
    case 4 :
      $dbchecked4 = ' checked="checked"';
      break;
    default :
      $dbchecked0 = ' checked="checked"';
  }

  // Vorhandene Exporte auslesen
  $sel_export = new rex_select();
  $sel_export->setName('import_name');
  $sel_export->setId('import_name');
  $sel_export->setStyle('class="rex-slct"');
  $sel_export->setAttribute('onchange', 'checkInput(\'dbanlegen_3\')');
  $export_dir = $export_addon_dir. '/files';
  $exports_found = false;

  if (is_dir($export_dir))
  {
    if ($handle = opendir($export_dir))
    {
      $export_archives = array ();
      $export_sqls = array ();

      while (($file = readdir($handle)) !== false)
      {
        if ($file == '.' || $file == '..')
        {
          continue;
        }

        $isSql = (substr($file, strlen($file) - 4) == '.sql');
        $isArchive = (substr($file, strlen($file) - 7) == '.tar.gz');

        if ($isSql)
        {
          $export_sqls[] = substr($file, 0, -4);
          $exports_found = true;
        }
        elseif ($isArchive)
        {
          $export_archives[] = substr($file, 0, -7);
          $exports_found = true;
        }
      }
      closedir($handle);
    }

    foreach ($export_sqls as $sql_export)
    {
      // Es ist ein Export Archiv + SQL File vorhanden
      if (in_array($sql_export, $export_archives))
      {
        $sel_export->addOption($sql_export, $sql_export);
      }
    }
  }

  echo '
      <p>
        <input class="rex-chckbx" type="radio" id="dbanlegen_0" name="dbanlegen" value="0"'.$dbchecked0.' />
        <label class="rex-lbl-right" for="dbanlegen_0">'.$I18N->msg('setup_034').'</label>
      </p>

      <p>
        <input class="rex-chckbx" type="radio" id="dbanlegen_1" name="dbanlegen" value="1"'.$dbchecked1.' />
        <label class="rex-lbl-right" for="dbanlegen_1">'.$I18N->msg('setup_035', '<b>', '</b>').'</label>
      </p>

      <p>
        <input class="rex-chckbx" type="radio" id="dbanlegen_2" name="dbanlegen" value="2"'.$dbchecked2.' />
        <label class="rex-lbl-right" for="dbanlegen_2">'.$I18N->msg('setup_036').'</label>
      </p>

      <p>
        <input class="rex-chckbx" type="radio" id="dbanlegen_4" name="dbanlegen" value="4"'.$dbchecked3.' />
        <label class="rex-lbl-right" for="dbanlegen_4">'.$I18N->msg('setup_038').'</label>
      </p>';

  if($exports_found)
  {
  echo '
      <p>
        <input class="rex-chckbx" type="radio" id="dbanlegen_3" name="dbanlegen" value="3"'.$dbchecked3.' />
        <label class="rex-lbl-right" for="dbanlegen_3">'.$I18N->msg('setup_037').'</label>
      </p>
      <p>'.$sel_export->get().'</p>';
  }
  
  echo '
      <p>
        <input class="rex-sbmt" type="submit" value="'.$I18N->msg('setup_039').'" />
      </p>
    </fieldset>
  </form>
  ';

}

// ---------------------------------- MODUS 4 | User anlegen ...

if ($checkmodus == 4 && $send == 1)
{
  $err_msg = "";
  if ($noadmin != 1)
  {
    if ($redaxo_user_login == '')
    {
      $err_msg .= $I18N->msg('setup_040');
    }
    if ($redaxo_user_pass == '')
    {
      // Falls auch kein Login eingegeben wurde, die Fehlermeldungen mit " " trennen
      if($err_msg != '') $err_msg .= ' ';
      
      $err_msg .= $I18N->msg('setup_041');
    }

    if ($err_msg == "")
    {
      $ga = new rex_sql;
      $ga->setQuery("select * from ".$REX['TABLE_PREFIX']."user where login='$redaxo_user_login'");

      if ($ga->getRows() > 0)
      {
        $err_msg .= $I18N->msg('setup_042');
      }
      else
      {
        if ($REX['PSWFUNC'] != '')
          $redaxo_user_pass = call_user_func($REX['PSWFUNC'], $redaxo_user_pass);

        $insert = "INSERT INTO ".$REX['TABLE_PREFIX']."user (name,login,psw,rights,createdate,createuser,status) VALUES ('Administrator','$redaxo_user_login','$redaxo_user_pass','#admin[]#dev[]#import[]#stats[]#moveSlice[]#','".time()."','setup',1)";
        $link = @ mysql_connect($REX['DB'][1]['HOST'], $REX['DB'][1]['LOGIN'], $REX['DB'][1]['PSW']);
        if (!@ mysql_db_query($REX['DB'][1]['NAME'], $insert, $link))
        {
          $err_msg .= $I18N->msg("setup_043");
        }
      }
    }
  }
  else
  {
    $gu = new rex_sql;
    $gu->setQuery("select * from ".$REX['TABLE_PREFIX']."user LIMIT 1");
    if ($gu->getRows() == 0)
      $err_msg .= $I18N->msg('setup_044');

  }

  if ($err_msg == '')
  {
    $checkmodus = 5;
    $send = '';
  }

}

if ($checkmodus == 4)
{

  rex_setuptitle($I18N->msg("setup_step4"));

  echo '
    <form action="index.php" method="post" id="rex-stp-admin">
      <fieldset>
        <input type="hidden" name="page" value="setup" />
        <input type="hidden" name="checkmodus" value="4" />
        <input type="hidden" name="send" value="1" />
        <input type="hidden" name="lang" value="'.$lang.'" />

        <legend>'.$I18N->msg("setup_045").'</legend>
        ';

  if ($err_msg != "")
    echo '<p class="rex-warning"><span>'.$err_msg.'</span></p>';

  if ($dbanlegen == 1)
    $dbchecked1 = ' checked="checked"';
  elseif ($dbanlegen == 2) $dbchecked2 = ' checked="checked"';
  else
    $dbchecked0 = ' checked="checked"';

  if (!isset ($redaxo_user_login))
    $redaxo_user_login = '';
  if (!isset ($redaxo_user_pass))
    $redaxo_user_pass = '';
  echo '
        <p>
          <label for="redaxo_user_login">'.$I18N->msg("setup_046").':</label>
          <input type="text" value="'.$redaxo_user_login.'" id="redaxo_user_login" name="redaxo_user_login" />
        </p>

        <p>
          <label for="redaxo_user_pass">'.$I18N->msg("setup_047").':</label>
          <input type="text" value="'.$redaxo_user_pass.'" id="redaxo_user_pass" name="redaxo_user_pass" />
        </p>

        <p>
          <input class="rex-chckbx" type="checkbox" id="noadmin" name="noadmin" value="1" />
          <label class="rex-lbl-right" for="noadmin">'.$I18N->msg("setup_048").'</label>
        </p>

        <p>
          <input class="rex-sbmt" type="submit" value="'.$I18N->msg("setup_049").'" />
        </p>

      </fieldset>
    </form>';

}

// ---------------------------------- MODUS 5 | Setup verschieben ...

if ($checkmodus == 5)
{

  $h = @ fopen($REX['INCLUDE_PATH'].'/master.inc.php', 'r');
  $cont = fread($h, filesize($REX['INCLUDE_PATH'].'/master.inc.php'));
  $cont = ereg_replace("(REX\['SETUP'\].?\=.?)[^;]*", '\\1false', $cont);
  fclose($h);
  $h = @ fopen($REX['INCLUDE_PATH'].'/master.inc.php', 'w+');
  if (fwrite($h, $cont, strlen($cont)) > 0)
  {
    $errmsg = "";
  }
  else
  {
    $errmsg = $I18N->msg('setup_050');
  }

  rex_setuptitle($I18N->msg('setup_step5'));
  echo $I18N->msg('setup_051', '<h2>', '</h2>', '<a href="index.php">', '</a>');

}
echo '</div>';
?>
