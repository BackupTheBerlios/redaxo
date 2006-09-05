<?php

/**
 * Klasse zur Verbindung und Interatkion mit der Datenbank
 * @version $Id: class.compat.inc.php,v 1.1 2006/09/05 08:58:33 kristinus Exp $ 
 */

class sql extends rex_sql{

  function sql($DBID = 1)
  {
    parent::rex_sql($DBID);
  }
}

class select extends rex_select{

  function select()
  {
    parent:select();
  }
}

// ----------------------------------------- Redaxo 2.* functions

function getUrlByid($id, $clang = "", $params = "")
{
  return rex_getUrl($id, $clang, $params);
}



?>