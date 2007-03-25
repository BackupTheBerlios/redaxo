<?php

/**
 * Template Objekt.
 * Zust�ndig f�r die Verarbeitung eines Templates
 * 
 * @package redaxo3
 * @version $Id: class.rex_template.inc.php,v 1.3 2007/03/25 17:55:59 kills Exp $
 */

class rex_template
{
  var $id;

  function rex_template($template_id)
  {
    $this->setId($template_id);
  }

  function getId()
  {
    return $this->id;
  }

  function setId($id)
  {
    $this->id = (int) $id;
  }

  function getTemplate()
  {
    global $REX;

    $file = $REX['INCLUDE_PATH'] . '/generated/templates/' . $this->getId() . '.template';
    $handle = fopen($file, 'r');
    $content = fread($handle, filesize($file));
    fclose($handle);

    return $content;
  }
}
?>