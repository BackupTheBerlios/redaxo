<?php
/**
 * Image-Resize Addon
 *
 * @author office[at]vscope[dot]at Wolfgang Hutteger
 * @author <a href="http://www.vscope.at">www.vscope.at</a>
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 *
 * @package redaxo4
 * @version $Id: extension_wysiwyg.inc.php,v 1.3 2007/11/09 14:14:47 kills Exp $
 */

// Resize WYSIWYG Editor Images
function rex_resize_wysiwyg_output($params)
{
  global $REX;

  $content = $params['subject'];

  preg_match_all('/<img[^>]*ismap="ismap"[^>]*>/imsU', $content, $matches);

  if (is_array($matches[0]))
  {
    foreach ($matches[0] as $var)
    {
      preg_match('/width="(.*)"/imsU', $var, $width);
      if (!$width)
      {
        preg_match('/width: (.*)px/imsU', $var, $width);
      }
      preg_match('/height="(.*)"/imsU', $var, $height);
      if (!$height)
      {
        preg_match('/height: (.*)px/imsU', $var, $height);
      }
      if ($width)
      {
        preg_match('/src="(.*files\/(.*))"/imsU', $var, $src);
        if (file_exists($REX['HTDOCS_PATH'] . 'files/' . $src[2]))
        {
          $realsize = getimagesize($REX['HTDOCS_PATH'] . 'files/' . $src[2]);
          if (($realsize[0] != $width[1]) or ($realsize[1] != $height[1]))
          {
            $newsrc = 'index.php?rex_resize=' . $width[1] . 'w__' . $height[1] . 'h__' . $src[2];
            $newimage = str_replace($src[1], $newsrc, $var);
            $content = str_replace($var, $newimage, $content);
          }
        }
      }
    }
  }
  return $content;
}
?>