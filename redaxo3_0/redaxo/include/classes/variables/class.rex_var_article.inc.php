<?php

/**
 * REX_ARTICLE[1]
 * 
 * REX_ARTICLE_VARS['description']
 * REX_ARTICLE_VARS['id']
 * REX_ARTICLE_VARS['category_id']
 * ...
 * 
 * @package redaxo3
 * @version $Id: class.rex_var_article.inc.php,v 1.1 2006/10/17 12:23:35 kills Exp $
 */

class rex_var_article extends rex_var
{
  // --------------------------------- Output
  
  function getBEOutput(& $sql, $content)
  {
    $content = $this->matchArticleVar(&$sql, $content);
    return $this->matchArticle(&$sql, $content);
  }

  function getArticleVarInputParams($content, $varname)
  {
    $matches = array ();

    $match = $this->matchVar($content, $varname);
    foreach ($match as $param_str)
    {
      $matches[] = array (
        $param_str
      );
    }

    return $matches;
  }

  function getArticleInputParams($content, $varname)
  {
    $matches = array ();
    $id = '';
    $clang = '';

    $match = $this->matchVar($content, $varname);
    foreach ($match as $param_str)
    {
      $params = $this->splitString($param_str);

      foreach ($params as $name => $value)
      {
        switch ($name)
        {
          case '0' :
          case 'id' :
            $id = (int) $value;
            break;
          case '1' :
          case 'clang' :
            $clang = (int) $value;
            break;
        }
      }

      $matches[] = array (
        $param_str,
        $id,
        $clang
      );
    }

    return $matches;
  }

  /**
   * Wert f�r die Ausgabe
   */
  function matchArticleVar(& $sql, $content)
  {
    global $article_id, $clang;
    
    $var = 'REX_ARTICLE_VARS';
    $matches = $this->getArticleVarInputParams($content, $var);

    $article = OOArticle::getArticleById($article_id, $clang);
    foreach ($matches as $match)
    {
      list ($param_str) = $match;
      
      $content = str_replace($var . '[' . $param_str . ']', $article->getValue($param_str), $content);
    }

    return $content;
  }
  
  /**
   * Wert f�r die Ausgabe
   */
  function matchArticle(& $sql, $content)
  {
    $var = 'REX_ARTICLE';
    $matches = $this->getArticleInputParams($content, $var);

    foreach ($matches as $match)
    {
      list ($param_str, $article_id, $clang) = $match;
      
      $article = new rex_article($article_id, $clang);
      $content = str_replace($var . '[' . $param_str . ']', $article->getArticle(), $content);
    }

    return $content;
  }
}
?>