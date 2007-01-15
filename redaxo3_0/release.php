<?php

/**
 * Erstellt ein REDAXO Release.
 * 
 * Vorgehensweise:
 *  - Ordnerstruktur kopieren nach release/redaxo_<Datum>
 *  - Dateien kopieren
 *  - CVS Ordner l�schen
 *  - master.inc.php anpassen
 * 
 * Verwendung in der Console:
 *  "php -f release.php"
 */

buildRelease(null);

function buildRelease($name = null)
{
	$cfg_path = 'release';
	$path = $cfg_path;
	
  if (!$name)
    $name = 'redaxo_' . date('ymd');

  if(substr($path, -1) != '/')
  	$path .= '/';
  
  if (!is_dir($path))
    mkdir($path);

  $dest = $path . $name;
  
  if (is_dir($dest))
    trigger_error('release folder already exists!', E_USER_ERROR);
  else
    mkdir($dest);

	// Ordner und Dateien auslesen
	$structure = readFolderStructure('.', array('CVS', 'generated', $cfg_path));
	
	// Ordner/Dateien kopieren
  foreach($structure as $path => $content)
  {
  	// Zielordnerstruktur anlegen
  	$temp_path = '';
  	foreach(explode('/', $dest .'/'. $path) as $pathdir)
  	{
  		if(!is_dir($temp_path . $pathdir .'/'))
  		{
  			mkdir($temp_path . $pathdir .'/');
  		}
  		$temp_path .= $pathdir .'/';
  	}
  	
  	// Dateien kopieren/Ordner anlegen
  	foreach($content as $dir)
  	{
  		if(is_file($path.'/'.$dir))
	  		copy($path.'/'.$dir, $dest .'/'. $path.'/'.$dir);
  		elseif(is_dir($path.'/'.$dir))
  			mkdir($dest .'/'. $path.'/'.$dir);
  	}
  }
  
  // Ordner die wir nicht mitkopiert haben anlegen
  // Der generated Ordner enth�lt sehr viele Daten,
  // das kopieren w�rde sehr lange dauern und ist unn�tig
  mkdir($dest .'/redaxo/include/generated');
  mkdir($dest .'/redaxo/include/generated/articles');
  mkdir($dest .'/redaxo/include/generated/templates');
  mkdir($dest .'/redaxo/include/generated/files');
  
  // Setup aktivieren
  $h = fopen($dest.'/redaxo/include/master.inc.php', 'r');
  $cont = fread($h, filesize($dest.'/redaxo/include/master.inc.php'));
  fclose($h);
  
  $cont = ereg_replace("(REX\['SETUP'\].?\=.?)[^;]*", '\\1true', $cont);
  $cont = ereg_replace("(REX\['SERVER'\].?\=.?)[^;]*", '\\1"redaxo.de"', $cont);
  $cont = ereg_replace("(REX\['SERVERNAME'\].?\=.?)[^;]*", '\\1"REDAXO"', $cont);
  $cont = ereg_replace("(REX\['ERROR_EMAIL'\].?\=.?)[^;]*", '\\1"jan.kristinus@pergopa.de"', $cont);
  $cont = ereg_replace("(REX\['LANG'\].?\=.?)[^;]*", '\\1"de_de"', $cont);
  $cont = ereg_replace("(REX\['START_ARTICLE_ID'\].?\=.?)[^;]*", '\\11', $cont);
  $cont = ereg_replace("(REX\['NOTFOUND_ARTICLE_ID'\].?\=.?)[^;]*", '\\11', $cont);

  $h = fopen($dest.'/redaxo/include/master.inc.php', 'w+');
  if (fwrite($h, $cont, strlen($cont)) > 0)
	  fclose($h);
	  
	unlink($dest .'/release.php');
}

/**
 * Returns the content of the given folder
 * 
 * @param $dir Path to the folder
 * @return Array Content of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */
function readFolder($dir)
{
  if (!is_dir($dir))
  {
    trigger_error('Folder "' . $dir . '" is not available or not a directory');
    return false;
  }
  $hdl = opendir($dir);
  $folder = array ();
  while (false !== ($file = readdir($hdl)))
  {
    $folder[] = $file;
  }

  return $folder;
}

/**
 * Returns the content of the given folder.
 * The content will be filtered with the given $fileprefix
 * 
 * @param $dir Path to the folder
 * @param $fileprefix Fileprefix to filter
 * @return Array Filtered-content of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */

function readFilteredFolder($dir, $fileprefix)
{
  $filtered = array ();
  $folder = readFolder($dir);

  if (!$folder)
  {
    return false;
  }

  foreach ($folder as $file)
  {
    if (endsWith($file, $fileprefix))
    {
      $filtered[] = $file;
    }
  }

  return $filtered;
}

/**
 * Returns the files of the given folder
 * 
 * @param $dir Path to the folder
 * @return Array Files of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */
function readFolderFiles($dir)
{
  $folder = readFolder($dir);
  $files = array ();

  if (!$folder)
  {
    return false;
  }

  foreach ($folder as $file)
  {
    if (is_file($dir . '/' . $file))
    {
      $files[] = $file;
    }
  }

  return $files;
}

/**
 * Returns the subfolders of the given folder
 * 
 * @param $dir Path to the folder
 * @param $ignore_dots True if the system-folders "." and ".." should be ignored
 * @return Array Subfolders of the folder or false on error
 * @author Markus Staab <staab@public-4u.de>
 */
function readSubFolders($dir, $ignore_dots = true)
{
  $folder = readFolder($dir);
  $folders = array ();

  if (!$folder)
  {
    return false;
  }

  foreach ($folder as $file)
  {
    if ($ignore_dots && ($file == '.' || $file == '..'))
    {
      continue;
    }
    if (is_dir($dir . '/' . $file))
    {
      $folders[] = $file;
    }
  }

  return $folders;
}

function readFolderStructure($dir, $except = array ())
{
	$result = array ();
	
	_readFolderStructure($dir, $except, $result);
	
	uksort($result, 'sortFolderStructure');
  
  return $result;
}

function _readFolderStructure($dir, $except = array (), & $result = array ())
{
  $files = readFolderFiles($dir);
  $subdirs = readSubFolders($dir);

	if(is_array($subdirs))
	{
	  foreach ($subdirs as $key => $subdir)
	  {
	    if (in_array($subdir, $except))
	    {
	    	unset($subdirs[$key]);
	      continue;
	    }
	
	    _readFolderStructure($dir .'/'. $subdir, $except, $result);
	  }
	}

  $result[$dir] = array_merge($files, $subdirs);
  
  return $result;
}

function sortFolderStructure($path1, $path2)
{
	return strlen($path1) > strlen($path2) ? 1 : -1;
}
?>