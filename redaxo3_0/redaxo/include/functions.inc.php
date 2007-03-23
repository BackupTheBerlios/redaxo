<?php
/** 
 * Bindet n�tige Klassen/Funktionen ein
 * @package redaxo3 
 * @version $Id: functions.inc.php,v 1.74 2007/03/23 15:26:38 kristinus Exp $ 
 */ 

// ----------------- TIMER
include_once $REX['INCLUDE_PATH']."/functions/function_rex_time.inc.php";

$REX_TEMP = $REX;

// ----------------- MAGIC QUOTES CHECK
if (!get_magic_quotes_gpc()) include $REX['INCLUDE_PATH']."/functions/function_rex_mquotes.inc.php";

// ----------------- REGISTER GLOBALS CHECK
if (!ini_get('register_globals'))
{
        // register_globals = off;
        
        if (isset($_COOKIE) and $_COOKIE) extract($_COOKIE);
        if (isset($_ENV) and $_ENV) extract($_ENV);
        if (isset($_FILES) and $_FILES) extract($_FILES);
        if (isset($_GET) and $_GET) extract($_GET);
        if (isset($_POST) and $_POST) extract($_POST);
        if (isset($_SERVER) and $_SERVER) extract($_SERVER);
        if (isset($_SESSION) and $_SESSION) extract($_SESSION);
}else
{
        // register_globals = on;
        
}

$REX = $REX_TEMP;

// ----------------- REX PERMS

// ----- allgemein
$REX['PERM'] = array();
$REX['PERM'][] = 'addon[]';
$REX['PERM'][] = 'specials[]';
$REX['PERM'][] = 'mediapool[]';
$REX['PERM'][] = 'module[]';
$REX['PERM'][] = 'template[]';
$REX['PERM'][] = 'user[]';

// ----- optionen
$REX['EXTPERM'] = array();
$REX['EXTPERM'][] = 'advancedMode[]';
$REX['EXTPERM'][] = 'moveSlice[]';
$REX['EXTPERM'][] = 'copyContent[]';
$REX['EXTPERM'][] = 'moveArticle[]';
$REX['EXTPERM'][] = 'copyArticle[]';
$REX['EXTPERM'][] = 'moveCategory[]';
$REX['EXTPERM'][] = 'publishArticle[]';
$REX['EXTPERM'][] = 'publishCategory[]';
$REX['EXTPERM'][] = 'article2startpage[]';

// ----- extras
$REX['EXTRAPERM'] = array();
$REX['EXTRAPERM'][] = 'editContentOnly[]';

// ----- standard variables
$REX['VARIABLES'] = array();
$REX['VARIABLES'][] = 'rex_var_globals';
$REX['VARIABLES'][] = 'rex_var_article';
$REX['VARIABLES'][] = 'rex_var_template';
$REX['VARIABLES'][] = 'rex_var_value';
$REX['VARIABLES'][] = 'rex_var_link';
$REX['VARIABLES'][] = 'rex_var_media';


// ----------------- REDAXO INCLUDES
include_once $REX['INCLUDE_PATH'].'/classes/class.i18n.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.rex_sql.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.rex_select.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.rex_article.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.rex_template.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.rex_login.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.ooredaxo.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.oocategory.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.ooarticle.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.ooarticleslice.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.oomediacategory.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.oomedia.inc.php';
include_once $REX['INCLUDE_PATH'].'/classes/class.ooaddon.inc.php';

if (!$REX['GG'])
{
  include_once $REX['INCLUDE_PATH'].'/functions/function_rex_title.inc.php';
  include_once $REX['INCLUDE_PATH'].'/functions/function_rex_generate.inc.php';
  include_once $REX['INCLUDE_PATH'].'/classes/class.rex_formatter.inc.php';
  include_once $REX['INCLUDE_PATH'].'/classes/class.rex_form.inc.php';
  include_once $REX['INCLUDE_PATH'].'/classes/class.rex_list.inc.php';
  include_once $REX['INCLUDE_PATH'].'/classes/class.rex_var.inc.php';
  foreach($REX['VARIABLES'] as $key => $value)
  {
    require_once ($REX['INCLUDE_PATH'].'/classes/variables/class.'.$value.'.inc.php');
    $REX['VARIABLES'][$key] = new $value;
  }
}

// ----- EXTRA CLASSES
// include_once $REX['INCLUDE_PATH'].'/classes/class.compat.inc.php';

// ----- FUNCTIONS
include_once $REX['INCLUDE_PATH'].'/functions/function_rex_globals.inc.php';
include_once $REX['INCLUDE_PATH'].'/functions/function_rex_url.inc.php';
include_once $REX['INCLUDE_PATH'].'/functions/function_rex_extension.inc.php';
include_once $REX['INCLUDE_PATH'].'/functions/function_rex_other.inc.php';


// ----- SET CLANG
include_once $REX['INCLUDE_PATH'].'/clang.inc.php';
$clang = rex_request('clang','int');
if (empty($REX['CLANG'][$clang]))
{
  $REX['CUR_CLANG'] = 0;
  $clang = 0;
}else
{
  $REX['CUR_CLANG'] = $clang;
}

// ----- INCLUDE ADDONS
include_once $REX['INCLUDE_PATH']."/addons.inc.php";

?>