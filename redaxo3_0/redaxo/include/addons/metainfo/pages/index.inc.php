<?php

/**
 * MetaForm Addon
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: index.inc.php,v 1.2 2007/03/28 08:11:30 kristinus Exp $
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
  array('articles','Artikel'),
  array('categories','Kategorien'),
);

rex_title('Metainformationen erweitern', $subpages);

// Include Current Page
switch($subpage)
{
  case 'categories' :
    $prefix = 'cat_'; 
    break;
  default:
	  $prefix = 'art_'; 
    break;
}
require $Basedir .'/field.inc.php';

// Include Footer 
include $REX['INCLUDE_PATH'].'/layout/bottom.php';
?>