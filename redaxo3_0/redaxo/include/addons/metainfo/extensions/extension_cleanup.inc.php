<?php

/**
 * MetaForm Addon
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: extension_cleanup.inc.php,v 1.2 2007/09/02 13:34:33 kills Exp $
 */

rex_register_extension('A1_BEFORE_DB_IMPORT', 'rex_a62_metainfo_cleanup');

/**
 * Alle Metafelder l�schen, nicht das nach einem Import in der Parameter Tabelle
 * noch Datens�tze zu Feldern stehen, welche nicht als Spalten in der
 * rex_article angelegt wurden!
 */
function rex_a62_metainfo_cleanup($params)
{
	global $REX;

	$sql = new rex_sql();
	$sql->setQuery('DELETE FROM '. $REX['TABLE_PREFIX'] .'62_params');
}

?>