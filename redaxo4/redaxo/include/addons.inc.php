<?php

/**
 * Addonlist
 * @package redaxo4
 * @version $Id: addons.inc.php,v 1.3 2008/02/22 16:27:58 kills Exp $
 */

// ----------------- addons
if (isset($REX['ADDON']['status'])) {
  unset($REX['ADDON']['status']);
}

// ----------------- DONT EDIT BELOW THIS
// --- DYN

// --- /DYN
// ----------------- /DONT EDIT BELOW THIS

foreach(OOAddon::getAvailableAddons() as $addonName)
{
  // Warnungen unterdrücken ist schneller als ein file_exists
  @include $REX['INCLUDE_PATH'].'/addons/'.$addonName.'/config.inc.php';
}

// ----- all addons configs included
rex_register_extension_point( 'ADDONS_INCLUDED');

?>