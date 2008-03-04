<?php

/**
 * PHPMailer Addon
 *  
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * 
 * @package redaxo4
 * @version $Id: index.inc.php,v 1.3 2008/03/04 15:01:08 kills Exp $
 */
 
// Parameter
$Basedir = dirname(__FILE__);

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');

require $REX['INCLUDE_PATH'].'/layout/top.php';

$subpages = array(
  array('',$I18N_A93->msg('configuration')),
  array('example',$I18N_A93->msg('example')),
);

rex_title($I18N_A93->msg('title'), $subpages);

switch($subpage)
{
    case 'example':
        require $Basedir .'/example.inc.php';
    break;
    default:
        require $Basedir .'/settings.inc.php';
}

require $REX['INCLUDE_PATH'].'/layout/bottom.php';

?>