<?php

/**
 * Klasse zur Verbindung und Interatkion mit der Datenbank
 * @version $Id: class.compat.inc.php,v 1.2 2006/09/05 09:04:40 kristinus Exp $ 
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
    parent::select();
  }
}

class article extends rex_article{

  function article($article_id = null, $clang = null)
  {
    parent::rex_article($article_id, $clang);
  }
}


// ----------------------------------------- Redaxo 2.* functions

function getUrlByid($id, $clang = "", $params = "")
{
  return rex_getUrl($id, $clang, $params);
}



?>