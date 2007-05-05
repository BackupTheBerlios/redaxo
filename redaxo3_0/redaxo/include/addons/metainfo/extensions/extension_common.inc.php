<?php

/**
 * MetaForm Addon
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: extension_common.inc.php,v 1.1 2007/05/05 09:39:38 kills Exp $
 */
 
rex_register_extension('ALL_GENERATED', 'rex_a62_metainfo_regenerate_all');

/**
 * Führt das nötige Cleanup nach einem "regenerate all" her. 	
 */
function rex_a62_metainfo_regenerate_all($params)
{
	rex_set_session('A62_MESSAGE', '');
}