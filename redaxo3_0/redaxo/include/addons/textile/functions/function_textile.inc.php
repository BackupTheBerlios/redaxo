<?php
/**
 * Textile Addon
 *  
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: function_textile.inc.php,v 1.2 2007/03/28 18:07:39 kills Exp $
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