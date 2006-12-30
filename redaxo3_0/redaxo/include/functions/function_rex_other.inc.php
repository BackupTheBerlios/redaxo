<?php

/**
 * Funktionen zur Ausgabe der Titel Leiste und Subnavigation
 * @package redaxo3
 * @version $Id: function_rex_other.inc.php,v 1.8 2006/12/30 19:13:05 kills Exp $
 */

/**
 * Berechnet aus einem Relativen Pfad einen Absoluten 
 */
function rex_absPath($rel_path)
{
  $path = realpath('.');
  $stack = explode(DIRECTORY_SEPARATOR, $path);

  foreach (explode('/', $rel_path) as $dir)
  {
    if ($dir == '.')
    {
      continue;
    }

    if ($dir == '..')
    {
      array_pop($stack);
    }
    else
    {
      array_push($stack, $dir);
    }
  }

  return implode('/', $stack);
}

/**
 * Pr�fen ob ein/e Datei/Ordner beschreibbar ist 
 */
function rex_is_writable($item)
{
  return _rex_is_writable_info(_rex_is_writable($item), $item);
}

function _rex_is_writable_info($is_writable, $item = '')
{
  global $I18N;

  $state = true;
  $key = '';
  switch($is_writable)
  {
    case 1:
    {
      $key = 'setup_012';
      break;
    }
    case 2:
    {
      $key = 'setup_014';
      break;
    }
    case 3:
    {
      $key = 'setup_015';
      break;
    }
  }
  
  if($key != '')
  {
    $file = '';
    if($item != '')
    {
      $file = '<b>'. rex_absPath($item) .'</b>';
    }
    $state = $I18N->msg($key, '<span class="rex-error">', '</span>', $file); 
  }
  
  return $state;
}

function _rex_is_writable($item)
{
  // Fehler unterdr�cken, falls keine Berechtigung
  if (@ is_dir($item))
  {
    if (!@ is_writable($item . '/.'))
    {
      return 1;
    }
  }
  // Fehler unterdr�cken, falls keine Berechtigung
  elseif (@ is_file($item))
  {
    if (!@ is_writable($item))
    {
      return 2;
    }
  }
  else
  {
    return 3;
  }

  return 0;
}

function rex_getAttributes($name,$content,$default = null)
{
	$prop = unserialize($content);
	if (isset($prop[$name])) return $prop[$name];
	return $default;
}

function rex_setAttributes($name,$value,$content)
{
	$prop = unserialize($content);
	$prop[$name] = $value;
	return serialize($prop);
}

function array_insert($array, $index, $value)
{
	// In PHP5 akzeptiert array_merge nur arrays. Deshalb hier $value als Array verpacken
  return array_merge(array_slice($array, 0, $index), array($value), array_slice($array, $index));
}

/**
 * F�r Installationen mit PHP < 4.3.0
 */
if (!function_exists('file_get_contents'))
{
  function file_get_contents($filename)
  {
    $fd = fopen($filename, 'rb');
    $content = fread($fd, filesize($filename));
    fclose($fd);
    return $content;
  }
}  

?>