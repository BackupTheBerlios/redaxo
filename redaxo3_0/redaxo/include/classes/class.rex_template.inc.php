<?php

/**
 * Template Objekt.
 * Zust�ndig f�r die Verarbeitung eines Templates
 *
 * @package redaxo4
 * @version $Id: class.rex_template.inc.php,v 1.8 2007/10/18 17:33:59 kills Exp $
 */

class rex_template
{
  var $id;

  function rex_template($template_id = 0)
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

  function getFile()
  {
    // Generated Datei erzeugen
    if($this->generate())
      return $this->getFilePath();

    return FALSE;
  }

  function getFilePath($template_id = 0)
  {
    if($this->getId()<1) return FALSE;

    if(isset($this))
      $template_id = $this->getId();

    return $this->getTemplatesDir() .'/' . $template_id . '.template';
  }

  function getTemplatesDir()
  {
    global $REX;

    return $REX['INCLUDE_PATH'] . '/generated/templates';
  }

  function getTemplate()
  {
		if($this->getId()<1) return FALSE;

    $file = $this->getFilePath();
    if ($handle = @fopen($file, 'r'))
    {
      $content = '';
	    $fs = filesize($file);
	    if ($fs>0) $content = fread($handle, filesize($file));
	    fclose($handle);
	    return $content;
    }else
    {
    	if($this->generate())
      {
        // rekursiv aufrufen, nach dem erfolgreichen generate
        return $this->getTemplate();
    	}
    }
		return FALSE;
  }

  function generate()
  {
    global $REX;

    if($this->getId()<1) return FALSE;

    include_once ($REX['INCLUDE_PATH'].'/functions/function_rex_generate.inc.php');
    return rex_generateTemplate($this->getId());
  }

  function deleteCache()
  {
  	global $REX;

		if($this->id<1) return FALSE;

		$file = $this->getFilePath();
    return @unlink($file);
  }
}
?>