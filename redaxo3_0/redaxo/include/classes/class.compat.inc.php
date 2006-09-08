<?php

/**
 * Klasse zur Verbindung und Interatkion mit der Datenbank
 * @version $Id: class.compat.inc.php,v 1.4 2006/09/08 11:59:48 kills Exp $ 
 */

class sql extends rex_sql{

  function sql($DBID = 1)
  {
    parent::rex_sql($DBID);
  }
  
  function getArray($sql = "", $fetch_type = MYSQL_ASSOC)
  {
    return $this->getArray($sql, $fetch_type);
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

function title($head, $subtitle = '', $styleclass = "grey", $width = '770px')
{
  return rex_title($head, $subtitle, $styleclass, $width);
}



?>