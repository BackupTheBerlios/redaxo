<?php

/**
 *
 * @package redaxo3
 * @version $Id: master.inc.php,v 1.33 2007/08/09 16:05:58 kills Exp $
 */

// -----------------

if (!$REX['GG']) $REX['GG'] = false;

// ----------------- SERVER VARS

// Setupservicestatus - if everything ok -> false; if problem set to true;
$REX['SETUP'] = false;
$REX['SERVER'] = "redaxo.de";
$REX['SERVERNAME'] = "REDAXO";
$REX['ERROR_EMAIL'] = "jan.kristinus@pergopa.de";
$REX['VERSION'] = "3";
$REX['SUBVERSION'] = "3";

// Is set first time SQL Object ist initialised
$REX['MYSQL_VERSION'] = "";

// Homepage ArticleId
$REX['START_ARTICLE_ID'] = 1;

// if there is no article -> change to this article
$REX['NOTFOUND_ARTICLE_ID'] = 1;

// default language
$REX['LANG'] = "de_de";

// activate frontend mod_rewrite support for url-rewriting
$REX['MOD_REWRITE'] = false;

// activate output gzip support
// reduces amount of data need to be send to the client, but increases cpu load of the server
// true/false/fronted/backend
$REX['USE_GZIP'] = "false";

// activate frontend e-tag support
// tag content with an md5 sum to improve usage of client cache
$REX['USE_ETAG'] = false;

// activate frontend last-modified support
// tag content with a last-modified timestamp to improve usage of client cache
$REX['USE_LAST_MODIFIED'] = false;

$REX['INCLUDE_PATH'] = realpath($REX['HTDOCS_PATH']."redaxo/include"); //
$REX['MEDIAFOLDER'] = $REX['HTDOCS_PATH']."files"; //
$REX['TABLE_PREFIX'] = "rex_";
$REX['TEMP_PREFIX'] = "tmp_";
$REX['FILEPERM'] = octdec(775); // oktaler wert
$REX['INSTNAME'] = "rex20070808200632";

// Passwortverschlüsselung, z.B: md5 / mcrypt ...
$REX['PSWFUNC'] = "";

// bei fehllogin 5 sekunden kein relogin moeglich
$REX['RELOGINDELAY'] = 5;

// maximal erlaubte versuche
$REX['MAXLOGINS'] = 50;

// Page auf die nach dem Login weitergeleitet wird
$REX['START_PAGE'] = 'structure';

// ----------------- OTHER VARS
$REX['SYSTEM_ADDONS'] = array('import_export','metainfo');
$REX['MEDIAPOOL']['BLOCKED_EXTENSIONS'] = array('.php','.php3','.php4','.php5','.php6','.phtml','.pl','.asp','.aspx','.cfm','.jsp');

// ----------------- DB1
$REX['DB']['1']['HOST'] = "localhost";
$REX['DB']['1']['LOGIN'] = "root";
$REX['DB']['1']['PSW'] = "";
$REX['DB']['1']['NAME'] = "redaxo3_3";

// ----------------- DB2 - if necessary
$REX['DB']['2']['HOST'] = "";
$REX['DB']['2']['LOGIN'] = "";
$REX['DB']['2']['PSW'] = "";
$REX['DB']['2']['NAME'] = "";

// ----------------- default values
if (!isset($REX['NOFUNCTIONS'])) $REX['NOFUNCTIONS'] = false;

// ----------------- INCLUDE FUNCTIONS
if(!$REX['NOFUNCTIONS']) include_once ($REX['INCLUDE_PATH'].'/functions.inc.php');

?>