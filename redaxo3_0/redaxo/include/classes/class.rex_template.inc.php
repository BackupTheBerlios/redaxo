<?php
/**
 * Template Objekt.
 * Zust�ndig f�r die Verarbeitung eines Templates
 * 
 * @package redaxo3
 * @version $Id: class.rex_template.inc.php,v 1.1 2006/10/17 12:22:49 kills Exp $
 */
 
class rex_template
{
   var $id;
   
   function rex_template($template_id)
   {
      $this->id = $template_id;
   }
   
   function getId()
   {
      return $this->id;
   }
   
   function getTemplate()
   {
      global $REX;
      
      $file = $REX['INCLUDE_PATH']. '/generated/templates/'. $this->getId() .'.template';
      $handle = fopen($file, 'r');
      $content = fread($handle, filesize($file));
      fclose($handle);
      
      return $content;
   }
}
?>