<?php

/**
 * MetaForm Addon
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: index.inc.php,v 1.1 2007/02/23 13:14:45 kills Exp $
 */
 
// Parameter
$Basedir = dirname(__FILE__);

$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$func = rex_request('func', 'string');


// Include Header and Navigation
include $REX['INCLUDE_PATH'].'/layout/top.php';

// Build Subnavigation 
$subpages = array(
//  array('categories','Kategorien'),
  array('article','Artikel'),
);

rex_title('Metainformationen erweitern', $subpages);

// Include Current Page
switch($subpage)
{
//	case 'categories' :
//	  $prefix = 'cat_'; 
//    break;
  case '' :
	case 'article': 
	  $prefix = 'art_'; 
    break;
}
require $Basedir .'/field.inc.php';

// Include Footer 
include $REX['INCLUDE_PATH'].'/layout/bottom.php';
?>