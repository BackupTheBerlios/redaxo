<?php

/**
 * REX_LINK_BUTTON,
 * REX_LINKLIST_BUTTON,
 * REX_LINKLIST
 * 
 * @package redaxo3
 * @version $Id: class.rex_var_link.inc.php,v 1.8 2007/03/19 13:40:25 kills Exp $
 */

class rex_var_link extends rex_var
{
  // --------------------------------- Actions

  function getACRequestValues($REX_ACTION)
  {
    $values = rex_request('LINK', 'array');
    for ($i = 1; $i < 11; $i++)
    {
      if (!isset ($values[$i]))
        $values[$i] = '';

      $REX_ACTION['LINK'][$i] = stripslashes($values[$i]);
    }
    return $REX_ACTION;
  }

  function setACValues(& $sql, $REX_ACTION, $escape = false)
  {
    global $REX;
    for ($i = 1; $i < 11; $i++)
    {
      if ($escape)
        $this->setValue($sql, 'link'. $i, addslashes($REX_ACTION['LINK'][$i]));
      else
        $this->setValue($sql, 'link'. $i, $REX_ACTION['LINK'][$i]);
    }
  }
  
  // --------------------------------- Output
  
  function getBEOutput(& $sql, $content)
  {
    return $this->getOutput($sql, $content);
  }

  function getBEInput(& $sql, $content)
  {
    $content = $this->getOutput($sql, $content);
    $content = $this->matchLinkButton($sql, $content);
    $content = $this->matchLinkListButton($sql, $content);

    return $content;
  }

  function getOutput(& $sql, $content)
  {
    $content = $this->matchLinkList($sql, $content);
    $content = $this->matchLink($sql, $content);
    $content = $this->matchLinkId($sql, $content);

    return $content;
  }

  function getInputParams($content, $varname)
  {
    $matches = array ();
    $id = '';
    $category = '';

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
          case 'category' :
            $category = (int) $value;
            break;
        }
      }

      $matches[] = array (
        $param_str,
        $id,
        $category
      );
    }

    return $matches;
  }

  /**
   * Button f�r die Eingabe
   */
  function matchLinkButton(& $sql, $content)
  {
    $var = 'REX_LINK_BUTTON';
    $matches = $this->getInputParams($content, $var);
    foreach ($matches as $match)
    {
      list ($param_str, $id, $category) = $match;

      if ($id < 11 && $id > 0)
      {
        $replace = $this->getLinkButton($id, $this->getValue($sql, 'link' . $id), $category);
        $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
      }
    }

    return $content;
  }

  /**
   * Button f�r die Eingabe
   */
  function matchLinkListButton(& $sql, $content)
  {
    $var = 'REX_LINKLIST_BUTTON';
    $matches = $this->getInputParams($content, $var);
    foreach ($matches as $match)
    {
      list ($param_str, $id, $category) = $match;

      if ($id < 11 && $id > 0)
      {
        $replace = $this->getLinklistButton($id, $this->getValue($sql, 'linklist' . $id), $category);
        $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
      }
    }

    return $content;
  }

  /**
   * Wert f�r die Ausgabe
   */
  function matchLink(& $sql, $content)
  {
    $var = 'REX_LINK';
    $matches = $this->getOutputParam($content, $var);
    foreach ($matches as $match)
    {
      list ($param_str, $id) = $match;

      if ($id > 0 && $id < 11)
      {
        $replace = rex_getUrl($this->getValue($sql, 'link' . $id));
        $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
      }
    }

    return $content;
  }

  /**
   * Wert f�r die Ausgabe
   */
  function matchLinkId(& $sql, $content)
  {
    $var = 'REX_LINK_ID';
    $matches = $this->getOutputParam($content, $var);
    foreach ($matches as $match)
    {
      list ($param_str, $id) = $match;

      if ($id > 0 && $id < 11)
      {
        $replace = $this->getValue($sql, 'link' . $id);
        $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
      }
    }

    return $content;
  }

  /**
   * Wert f�r die Ausgabe
   */
  function matchLinkList(& $sql, $content)
  {
    $var = 'REX_LINKLIST';
    $matches = $this->getOutputParam($content, $var);
    foreach ($matches as $match)
    {
      list ($param_str, $id) = $match;

      if ($id > 0 && $id < 11)
      {
        $replace = $this->getValue($sql, 'linklist' . $id);
        $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
      }
    }

    return $content;
  }

  /**
   * Gibt das Button Template zur�ck
   */
  function getLinkButton($id, $article_id, $category = '')
  {
    global $REX;
    
    $art_name = '';
    $clang = '';
    $art = OOArticle :: getArticleById($article_id);
    
    if (OOArticle :: isValid($art))
    {
      $art_name = $art->getName();
			if ($category == '') $category = $art->getCategoryId();
    }
    
    $open_params = '&clang=' . $REX['CUR_CLANG'];
    if ($category != '')
      $open_params .= '&category_id=' . $category;

    $media = '
    <input type="hidden" name="LINK[' . $id . ']" id="LINK_' . $id . '" value="REX_LINK_ID[' . $id . ']" />
    <input type="text" size="30" name="LINK_NAME[' . $id . ']" value="' . $art_name . '" id="LINK_NAME_' . $id . '_" readonly="readonly" />
    <a href="#" onclick="javascript:openLinkMap(' . $id . ', \'' . $open_params . '\');"><img src="pics/file_open.gif" width="16" height="16" alt="Open Linkmap" title="Open Linkmap" /></a>
    <a href="#" onclick="javascript:deleteREXLink(' . $id . ');"><img src="pics/file_del.gif" width="16" height="16" title="Remove Selection" alt="Remove Selection" /></a>';

    $media = $this->stripPHP($media);
    return $media;
  }

  /**
   * Gibt das ListButton Template zur�ck
   * TODO: komplett �berarbeiten
   */
  function getLinklistButton($id, $article_id, $category = '')
  {
    return "";
  }
}
?>