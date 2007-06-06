<?php

/**
 * MetaForm Addon
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: extension_oof_metainfo.inc.php,v 1.4 2007/06/06 19:06:52 kills Exp $
 */

rex_register_extension('OOF_META_PARAMS', 'rex_a62_oof_metainfo_params');

/**
 * Modifiziert das Parameter Array und fügt diesem die neuen Meta-Felder hinzu (Variablenerweiterung der OO-Klassen)
 */
function rex_a62_oof_metainfo_params($params)
{
	global $REX;
	
	$new_params = array();
	$fields = new rex_sql();
//	$fields->debugsql = true;
  $fields->setQuery('SELECT name FROM '. $REX['TABLE_PREFIX'] .'62_params p WHERE `name` LIKE "art_%" OR `name` LIKE "cat_%"');
	
	for($i = 0; $i < $fields->getRows(); $i++)
	{
		$new_params[] = array($fields->getValue('name'), substr($fields->getValue('name'), 4)); 
		$fields->next();
	}
	
	return $new_params;
}

?>