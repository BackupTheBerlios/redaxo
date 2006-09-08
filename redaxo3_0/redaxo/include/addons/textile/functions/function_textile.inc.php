<?php
/**
 * 
 * @package redaxo3
 * @version $Id: function_textile.inc.php,v 1.1 2006/09/08 14:55:25 kills Exp $
 */
 
function rex_a79_textile($code)
{
  $textile = rex_a79_textile_instance();
  return $textile->TextileThis($code);
}
 
function rex_a79_textile_instance()
{
  static $instance = null;
  
  if($instance === null)
  {
    $instance = new Textile();
  }
  
  return $instance;
} 
?>