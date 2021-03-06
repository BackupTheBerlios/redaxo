<?php

/**
 * REX_FILE[1],
 * REX_FILELIST[1],
 * REX_FILE_BUTTON[1],
 * REX_FILELIST_BUTTON[1],
 * REX_MEDIA[1],
 * REX_MEDIALIST[1],
 * REX_MEDIA_BUTTON[1],
 * REX_MEDIALIST_BUTTON[1]
 *
 * Alle Variablen die mit REX_FILE beginnnen sind als deprecated anzusehen!
 * @package redaxo4
 * @version $Id: class.rex_var_media.inc.php,v 1.18 2007/10/13 13:52:01 kills Exp $
 */

class rex_var_media extends rex_var
{
  // --------------------------------- Actions

  function getACRequestValues($REX_ACTION)
  {
    $values = rex_request('MEDIA', 'array');
    for ($i = 1; $i < 11; $i++)
    {
      if (!isset ($values[$i]))
        $values[$i] = '';

      $REX_ACTION['MEDIA'][$i] = stripslashes($values[$i]);
    }

    $values = rex_request('MEDIALIST', 'array');
    for ($i = 1; $i < 11; $i++)
    {
      if (!isset ($values[$i]))
        $values[$i] = '';

      $REX_ACTION['MEDIALIST'][$i] = stripslashes($values[$i]);
    }

    return $REX_ACTION;
  }

  function getACDatabaseValues($REX_ACTION, & $sql)
  {
    for ($i = 1; $i < 11; $i++)
    {
      $REX_ACTION['MEDIA'][$i] = $this->getValue($sql, 'file'. $i);
    }

    for ($i = 1; $i < 11; $i++)
    {
      $REX_ACTION['MEDIALIST'][$i] = $this->getValue($sql, 'filelist'. $i);
    }

    return $REX_ACTION;
  }

  function setACValues(& $sql, $REX_ACTION, $escape = false)
  {
    global $REX;

    for ($i = 1; $i < 11; $i++)
    {
      $this->setValue($sql, 'file'. $i, $REX_ACTION['MEDIA'][$i], $escape);
      $this->setValue($sql, 'filelist'. $i, $REX_ACTION['MEDIALIST'][$i], $escape);
    }
  }

  // --------------------------------- Output

  function getBEInput(& $sql, $content)
  {
    $content = $this->matchMediaButton($sql, $content);
    $content = $this->matchMediaListButton($sql, $content);
    $content = $this->getOutput($sql, $content);
    return $content;
  }

  function getBEOutput(& $sql, $content)
  {
    $content = $this->getOutput($sql, $content);
    return $content;
  }

  /**
   * Ersetzt die Value Platzhalter
   */
  function getOutput(& $sql, $content)
  {
    $content = $this->matchMedia($sql, $content);
    $content = $this->matchMediaList($sql, $content);
    return $content;
  }

  function getInputParams($content, $varname)
  {
    $matches = array ();
    $id = '';
    $category = '';
    $filter = '';

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

          case '2' :
          case 'filter' :
            $filter = (string) $value;
            break;
        }
      }

      $matches[] = array (
        $param_str,
        $id,
        $category,
        $filter
      );
    }

    return $matches;
  }

  /**
   * MediaButton f�r die Eingabe
   */
  function matchMediaButton(& $sql, $content)
  {
    $vars = array (
      'REX_FILE_BUTTON',
      'REX_MEDIA_BUTTON'
    );
    foreach ($vars as $var)
    {
      $matches = $this->getInputParams($content, $var);
      foreach ($matches as $match)
      {
        list ($param_str, $id, $category, $filter) = $match;

        if ($id < 11 && $id > 0)
        {
          $replace = $this->getMediaButton($id, $category, $filter);
          $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
        }
      }
    }

    return $content;
  }

  /**
   * MediaListButton f�r die Eingabe
   */
  function matchMediaListButton(& $sql, $content)
  {
    $vars = array (
      'REX_FILELIST_BUTTON',
      'REX_MEDIALIST_BUTTON'
    );
    foreach ($vars as $var)
    {
      $matches = $this->getInputParams($content, $var);
      foreach ($matches as $match)
      {
        list ($param_str, $id, $category, $filter) = $match;

        if ($id < 11 && $id > 0)
        {
          $replace = $this->getMedialistButton($id, $this->getValue($sql, 'filelist' . $id));
          $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
        }
      }
    }

    return $content;
  }

  /**
   * Wert f�r die Ausgabe
   */
  function matchMedia(& $sql, $content)
  {
    $vars = array (
      'REX_FILE',
      'REX_MEDIA'
    );
    foreach ($vars as $var)
    {
      $matches = $this->getOutputParam($content, $var);
      foreach ($matches as $match)
      {
        list ($param_str, $id) = $match;

        if ($id > 0 && $id < 11)
        {
          $replace = $this->getValue($sql, 'file' . $id);
          $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
        }
      }
    }
    return $content;
  }

  /**
   * Wert f�r die Ausgabe
   */
  function matchMediaList(& $sql, $content)
  {
    $vars = array (
      'REX_FILELIST',
      'REX_MEDIALIST'
    );
    foreach ($vars as $var)
    {
      $matches = $this->getOutputParam($content, $var);
      foreach ($matches as $match)
      {
        list ($param_str, $id) = $match;

        if ($id > 0 && $id < 11)
        {
          $replace = $this->getValue($sql, 'filelist' . $id);
          $content = str_replace($var . '[' . $param_str . ']', $replace, $content);
        }
      }
    }
    return $content;
  }

  /**
   * Gibt das Button Template zur�ck
   */
  function getMediaButton($id, $category = '', $filter = '')
  {
    $open_params = '';
    if ($category != '')
    {
      $open_params .= '&amp;rex_file_category=' . $category;
    }

    if ($filter != '')
    {
      $open_params .= '&amp;filter=' . $filter;
    }

    $media = '
    <div class="rex-wdgt">
      <div class="rex-wdgt-mda">
        <p>
          <input type="text" size="30" name="MEDIA[' . $id . ']" value="REX_MEDIA[' . $id . ']" id="REX_MEDIA_' . $id . '" readonly="readonly" />
          <a href="#" onclick="openREXMedia(' . $id . ',\'' . $open_params . '\');return false;"'. rex_tabindex() .'><img src="media/file_open.gif" width="16" height="16" title="Open Mediapool" alt="Open Mediapool" /></a>
          <a href="#" onclick="addREXMedia(' . $id . ');return false;"'. rex_tabindex() .'><img src="media/file_add.gif" width="16" height="16" title="Add New Media" alt="Add New Media" /></a>
          <a href="#" onclick="deleteREXMedia(' . $id . ');return false;"'. rex_tabindex() .'><img src="media/file_del.gif" width="16" height="16" title="Remove Selection" alt="Remove Selection" /></a>
        </p>
      </div>
    </div>
    ';

    return $media;
  }

  /**
   * Gibt das ListButton Template zur�ck
   */
  function getMedialistButton($id, $value, $category = '', $filter = '')
  {
    $open_params = '';
    if ($category != '')
    {
      $open_params .= '&amp;rex_file_category=' . $category;
    }

    if ($filter != '')
    {
      $open_params .= '&amp;filter=' . $filter;
    }

    $options = '';
    $medialistarray = explode(',', $value);
    if (is_array($medialistarray))
    {
      foreach ($medialistarray as $file)
      {
        if ($file != '')
        {
          $options .= '<option value="' . $file . '">' . $file . '</option>';
        }
      }
    }

    $media = '
    <div class="rex-wdgt">
      <div class="rex-wdgt-mdlst">
        <input type="hidden" name="MEDIALIST['. $id .']" id="REX_MEDIALIST_'. $id .'" value="'. $value .'" />
        <p class="rex-slct">
          <select name="MEDIALIST_SELECT[' . $id . ']" id="REX_MEDIALIST_SELECT_' . $id . '" size="8"'. rex_tabindex() .'>
            ' . $options . '
          </select>
        </p>
        <p class="rex-wdgt-icons">
          <a href="#" onclick="moveREXMedialist(' . $id . ',\'top\');return false;"'. rex_tabindex() .'><img src="media/file_top.gif" width="16" height="16" title="Move Selected Item Up To Top" alt="Move Selected Item Up To Top" /></a>
          <a href="#" onclick="openREXMedialist(' . $id . ');return false;"'. rex_tabindex() .'><img src="media/file_open.gif" width="16" height="16" title="Open Mediapool" alt="Open Mediapool" /></a>
          <br />
          <a href="#" onclick="moveREXMedialist(' . $id . ',\'up\');return false;"'. rex_tabindex() .'><img src="media/file_up.gif" width="16" height="16" title="Move Selected Item Upwards" alt="Move Selected Item Upwards" /></a>
          <a href="#" onclick="addREXMedialist('. $id .');return false;"'. rex_tabindex() .'><img src="media/file_add.gif" width="16" height="16" title="Add New Media" alt="Add New Media" /></a>
          <br />
          <a href="#" onclick="moveREXMedialist(' . $id . ',\'down\');return false;"'. rex_tabindex() .'><img src="media/file_down.gif" width="16" height="16" title="Move Selected Item Downwards" alt="Move Selected Item Downwards" /></a>
          <a href="#" onclick="deleteREXMedialist(' . $id . ');return false;"'. rex_tabindex() .'><img src="media/file_del.gif" width="16" height="16" title="Remove Selection" alt="Remove Selection" /></a>
          <br />
          <a href="#" onclick="moveREXMedialist(' . $id . ',\'bottom\');return false;"'. rex_tabindex() .'><img src="media/file_bottom.gif" width="16" height="16" title="Move Selected Item Down To Bottom" alt="Move Selected Item Down To Bottom" /></a>
        </p>
        <div class="rex-clearer"></div>
      </div>
    </div>
    ';

    return $media;
  }

}
?>