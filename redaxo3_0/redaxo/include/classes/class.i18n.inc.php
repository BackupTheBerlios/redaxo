<?php


// class.i18n.inc.php
// 
// created 03.04.04 by Carsten Eckelmann, <careck@circle42.com>
// 
// Mission: to supply messages for different language environments

class i18n
{

   var $locale;
   var $locales;
   var $text;
   var $searchpath;
   var $filename;

   /*
    * Constructor
    * the locale must of the common form, eg. de_DE, en_US or just plain en, de.
    * the searchpath is where the language files are located
    */
   function i18n($locale, $searchpath)
   {
      global $REX;
      $this->text = array ();
      $this->locale = $locale;
      $this->searchpath = $searchpath;
      $this->filename = $searchpath."/".$locale.".lang";
      $this->loadTexts();
      // Locale Cache
      $this->locales = array ();
   }

   /* 
    * load texts from file.
    * The filename must be of the form:
    *
    * <locale>.lang
    * eg: de_DE.lang or en_US.lang or en_GB.lang
    *
    * The file must be in the common property format:
    *
    * key = value
    * # comments must be on one line
    * 
    * values may contain placeholders for replacement of variables, e.g.
    * file_not_found = The file {0} could not be found.
    * there can be only 10 placeholders, {0} to {9}.
    */
   function loadTexts()
   {
      if (is_readable($this->filename))
      {
         $f = fopen($this->filename, "r");
         while (!feof($f))
         {
            $buffer = fgets($f, 4096);
            if (preg_match("/^(\w*)\s*=\s*(.*)$/", $buffer, $matches))
            {
               $this->text[$matches[1]] = trim($matches[2]);
            }
         }
         fclose($f);
      }
   }

   /*
    * return a message according to a key from the current locale
    * you can give up to 10 parameters for substitution.
    */
   function msg($key, $p0 = '', $p1 = '', $p2 = '', $p3 = '', $p4 = '', $p5 = '', $p6 = '', $p7 = '', $p8 = '', $p9 = '')
   {
      global $REX;
      $msg = $this->text[$key];

      // falls der key nicht gefunden wurde, auf die fallbacksprache switchen
      if ($msg == '' && $this != $REX['LANG_FALLBACK_OBJ'])
      {
         // fallbackobjekt ggf anlegen
         if ($REX['LANG_FALLBACK_OBJ'] == '')
         {
            rex_create_lang($REX['LANG_FALLBACK'], true, $this->searchpath);
         }

         // suchen des keys in der fallbacksprache
         return $REX['LANG_FALLBACK_OBJ']->msg($key, $p0, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9);
      }

      $patterns = array ('/\{0\}/', '/\{1\}/', '/\{2\}/', '/\{3\}/', '/\{4\}/', '/\{5\}/', '/\{6\}/', '/\{7\}/', '/\{8\}/', '/\{9\}/');
      $replacements = array ($p0, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9);
      return preg_replace($patterns, $replacements, $msg);
   }

   /* 
    * find all defined locales in a searchpath
    * the language files must be of the form: <locale>.lang
    * e.g. de_de.lang or en_gb.lang
    */
   function getLocales($searchpath)
   {
      if (empty ($this->locales) && is_readable($searchpath))
      {
         $this->locales = array ();

         $handle = opendir($searchpath);
         while ($file = readdir($handle))
         {
            if ($file != "." && $file != "..")
            {
               if (preg_match("/^(\w+)\.lang$/", $file, $matches))
               {
                  $this->locales[] = $matches[1];
               }
            }
         }
         closedir($handle);

      }

      return $this->locales;
   }

}

// Funktion zum Anlegen eines Sprache-Objekts
function rex_create_lang($locale, $use_as_fallback = false, $searchpath = '')
{
   global $REX, $I18N;

   if ($searchpath == '')
   {
      $searchpath = $REX['INCLUDE_PATH']."/lang/";
   }

   if ($use_as_fallback)
   {
      $REX['LANG_FALLBACK_OBJ'] = new i18n($locale, $searchpath);
   }
   else
   {
      $REX['LANG_OBJ'] = $I18N = new i18n($locale, $searchpath);
      $REX['LOCALES'] = $I18N->getLocales($searchpath);
   }
}
?>


