<?php

/**
 * REX_MODULE_ID,
 * REX_SLICE_ID,
 * REX_CTYPE_ID
 * 
 * @package redaxo3
 * @version $Id: class.rex_var_globals.inc.php,v 1.5 2006/10/17 12:23:51 kills Exp $
 */

class rex_var_globals extends rex_var
{
  function getBEOutput(& $sql, $content)
  {
    // Modulabh�ngige Globale Variablen ersetzen
    $content = str_replace('REX_MODULE_ID', $this->getValue($sql, 'modultyp_id'), $content);
    $content = str_replace('REX_SLICE_ID', $this->getValue($sql, 'id'), $content);
    $content = str_replace('REX_CTYPE_ID', $this->getValue($sql, 'ctype'), $content);

    return $content;
  }
}
?>