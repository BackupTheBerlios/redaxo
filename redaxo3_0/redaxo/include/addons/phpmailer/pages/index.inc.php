<?php
/**
 * 
 * @package redaxo3
 * @version $Id: index.inc.php,v 1.1 2006/10/31 10:10:49 kills Exp $
 */
 
// Parameter
$Basedir = dirname(__FILE__);

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

include $REX['INCLUDE_PATH'].'/layout/top.php';

$subpages = array(
  array('','Konfiguration'),
  array('example','Beispiel'),
);

rex_title('PHPMailer', $subpages);

switch($subpage)
{
    case 'example':
        require $Basedir .'/example.inc.php';
    break;
    default:
        require $Basedir .'/settings.inc.php';
}

include $REX['INCLUDE_PATH'].'/layout/bottom.php';

?>