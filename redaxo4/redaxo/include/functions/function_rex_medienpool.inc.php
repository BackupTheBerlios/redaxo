<?php

/**
 * Funktionensammlung f�r den Medienpool
 *
 * @package redaxo4
 * @version $Id: function_rex_medienpool.inc.php,v 1.7 2008/03/26 16:26:51 kills Exp $
 */

/**
 * Erstellt einen Filename der eindeutig ist f�r den Medienpool
 * @param $FILENAME Dateiname
 */
function rex_medienpool_filename($FILENAME, $doSubindexing = true)
{
  global $REX;

  // ----- neuer filename und extension holen
  $NFILENAME = strtolower($FILENAME);
  $NFILENAME = str_replace(array('�','�', '�', '�'),array('ae', 'oe', 'ue', 'ss'),$NFILENAME);
  $NFILENAME = preg_replace('/[^a-zA-Z0-9.\-\+]/','_',$NFILENAME);
  if (strrpos($NFILENAME,'.') != '')
  {
    $NFILE_NAME = substr($NFILENAME,0,strlen($NFILENAME)-(strlen($NFILENAME)-strrpos($NFILENAME,'.')));
    $NFILE_EXT  = substr($NFILENAME,strrpos($NFILENAME,'.'),strlen($NFILENAME)-strrpos($NFILENAME,'.'));
  }else
  {
    $NFILE_NAME = $NFILENAME;
    $NFILE_EXT  = '';
  }

  // ---- ext checken - alle scriptendungen rausfiltern
  if (in_array($NFILE_EXT,$REX['MEDIAPOOL']['BLOCKED_EXTENSIONS']))
  {
    $NFILE_NAME .= $NFILE_EXT;
    $NFILE_EXT = '.txt';
  }

  $NFILENAME = $NFILE_NAME.$NFILE_EXT;

  if($doSubindexing)
  {
    // ----- datei schon vorhanden -> namen aendern -> _1 ..
    if (file_exists($REX['MEDIAFOLDER'].'/'.$NFILENAME))
    {
      $cnt = 1;
      while(file_exists($REX['MEDIAFOLDER'].'/'.$NFILE_NAME.'_'.$cnt.$NFILE_EXT))
        $cnt++;

      $NFILENAME = $NFILE_NAME.'_'.$cnt.$NFILE_EXT;
    }
  }

  return $NFILENAME;
}

/**
 * Holt ein upgeloadetes File und legt es in den Medienpool
 * Dabei wird kontrolliert ob das File schon vorhanden ist und es
 * wird eventuell angepasst, weiterhin werden die Fileinformationen �bergeben
 *
 * @param $FILE
 * @param $rex_file_category
 * @param $FILEINFOS
 * @param $userlogin
*/
function rex_medienpool_saveMedia($FILE, $rex_file_category, $FILEINFOS, $userlogin = null){

  global $REX,$I18N;

  $rex_file_category = (int) $rex_file_category;

  $gc = new rex_sql();
  $gc->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'file_category WHERE id='. $rex_file_category);
	if ($gc->getRows() != 1)
	{
  	$rex_file_category = 0;
	}

  $isFileUpload = isset($FILE['tmp_name']);

  $FILENAME = $FILE['name'];
  $FILESIZE = $FILE['size'];
  $FILETYPE = $FILE['type'];
  $NFILENAME = rex_medienpool_filename($FILENAME, $isFileUpload);
  $message = '';

  // ----- alter/neuer filename
  $srcFile = $REX['MEDIAFOLDER'].'/'.$FILENAME;
  $dstFile = $REX['MEDIAFOLDER'].'/'.$NFILENAME;

  $success = true;
  if($isFileUpload) // Fileupload?
  {
    if(!@move_uploaded_file($FILE['tmp_name'],$dstFile))
    {
      $message .= $I18N->msg("pool_file_movefailed");
      $success = false;
    }
  }
  else // Filesync?
  {
    if(!@rename($srcFile,$dstFile))
    {
      $message .= $I18N->msg("pool_file_movefailed");
      $success = false;
    }
  }

  if($success)
  {
    @chmod($dstFile, $REX['FILEPERM']);

    // get widht height
    $size = @getimagesize($dstFile);

    if($FILETYPE == '' && isset($size['mime']))
      $FILETYPE = $size['mime'];

    $FILESQL = new rex_sql;
    $FILESQL->setTable($REX['TABLE_PREFIX'].'file');
    $FILESQL->setValue('filetype',$FILETYPE);
    $FILESQL->setValue('title',$FILEINFOS['title']);
    $FILESQL->setValue('filename',$NFILENAME);
    $FILESQL->setValue('originalname',$FILENAME);
    $FILESQL->setValue('filesize',$FILESIZE);

    if($size)
    {
      $FILESQL->setValue('width',$size[0]);
      $FILESQL->setValue('height',$size[1]);
    }

    $FILESQL->setValue('category_id',$rex_file_category);
    // TODO Create + Update zugleich?
    $FILESQL->addGlobalCreateFields($userlogin);
    $FILESQL->addGlobalUpdateFields($userlogin);
    $FILESQL->insert();

    $message .= $I18N->msg("pool_file_added");
  }

  $RETURN['title'] = $FILEINFOS['title'];
  $RETURN['type'] = $FILETYPE;
  $RETURN['msg'] = $message;
  // Aus BC gruenden hier mit int 1/0
  $RETURN['ok'] = $success ? 1 : 0;
  $RETURN['filename'] = $NFILENAME;
  $RETURN['old_filename'] = $FILENAME;

  if($size)
  {
    $RETURN['width'] = $size[0];
    $RETURN['height'] = $size[1];
  }

  // ----- EXTENSION POINT
  if ($success)
    rex_register_extension_point('MEDIA_ADDED','',$RETURN);

  return $RETURN;
}

/**
 * Synchronisiert die Datei $physical_filename des Mediafolders in den
 * Medienpool
 *
 * @param $physical_filename
 * @param $category_id
 * @param $title
 * @param $filesize
 * @param $filetype
 */
function rex_medienpool_syncFile($physical_filename,$category_id,$title,$filesize = null, $filetype = null)
{
  global $REX;

  $abs_file = $REX['MEDIAFOLDER'].'/'. $physical_filename;

  if(!file_exists($abs_file))
  {
    return false;
  }

  if(empty($filesize))
  {
    $filesize = filesize($abs_file);
  }

  if(empty($filetype) && function_exists('mime_content_type'))
  {
    $filetype = mime_content_type($abs_file);
  }

  $FILE = array();
  $FILE['name'] = $physical_filename;
  $FILE['size'] = $filesize;
  $FILE['type'] = $filetype;

  $FILEINFOS = array();
  $FILEINFOS['title'] = $title;

  $RETURN = rex_medienpool_saveMedia($FILE, $category_id, $FILEINFOS);
  return $RETURN['ok'] == 1;
}

/**
 * F�gt einen rex_select Objekt die hierarchische Medienkategorien struktur
 * hinzu
 *
 * @param $select
 * @param $mediacat
 * @param $mediacat_ids
 * @param $groupName
 */
function rex_medienpool_addMediacatOptions( &$select, &$mediacat, &$mediacat_ids, $groupName = '')
{
  global $REX_USER;

  if(empty($mediacat)) return;

  $mname = $mediacat->getName();
  if($REX_USER->hasPerm('advancedMode[]'))
    $mname .= ' ['. $mediacat->getId() .']';

  $mediacat_ids[] = $mediacat->getId();
  $select->addOption($mname,$mediacat->getId(), $mediacat->getId(),$mediacat->getParentId());
  $childs = $mediacat->getChildren();
  if (is_array($childs))
  {
    foreach ( $childs as $child) {
      rex_medienpool_addMediacatOptions( $select, $child, $mediacat_ids, $mname);
    }
  }
}

/**
 * F�gt einen rex_select Objekt die hierarchische Medienkategorien struktur
 * hinzu unter ber�cksichtigung der Medienkategorierechte
 *
 * @param $select
 * @param $mediacat
 * @param $mediacat_ids
 * @param $groupName
 */
function rex_medienpool_addMediacatOptionsWPerm( &$select, &$mediacat, &$mediacat_ids, $groupName = '')
{
  global $PERMALL, $REX_USER;

  if(empty($mediacat)) return;

  $mname = $mediacat->getName();
  if($REX_USER->hasPerm('advancedMode[]'))
    $mname .= ' ['. $mediacat->getId() .']';

  $mediacat_ids[] = $mediacat->getId();
  if ($PERMALL || $REX_USER->hasPerm('media['.$mediacat->getId().']'))
    $select->addOption($mname,$mediacat->getId(), $mediacat->getId(),$mediacat->getParentId());

  $childs = $mediacat->getChildren();
  if (is_array($childs))
  {
    foreach ( $childs as $child) {
      rex_medienpool_addMediacatOptionsWPerm( $select, $child, $mediacat_ids, $mname);
    }
  }
}

/**
 * Ausgabe des Medienpool Formulars
 */
function rex_medienpool_Mediaform($form_title, $button_title, $rex_file_category, $file_chooser, $close_form)
{
  global $I18N, $REX, $REX_USER, $subpage, $ftitle;

  $s = '';

  $cats_sel = new rex_select;
  $cats_sel->setStyle('class="inp100"');
  $cats_sel->setSize(1);
  $cats_sel->setName('rex_file_category');
  $cats_sel->setId('rex_file_category');
  $cats_sel->addOption($I18N->msg('pool_kats_no'),"0");

  $mediacat_ids = array();
  $rootCat = 0;
  if ($rootCats = OOMediaCategory::getRootCategories())
  {
    foreach( $rootCats as $rootCat) {
      rex_medienpool_addMediacatOptionsWPerm( $cats_sel, $rootCat, $mediacat_ids);
    }
  }
  $cats_sel->setSelected($rex_file_category);

  if (isset($msg) and $msg != "")
  {
    $s .= rex_warning($msg);
    $msg = "";
  }

  if (!isset($ftitle)) $ftitle = '';

  $add_file = '';
  if($file_chooser)
  {
    $devInfos = '';
    if($REX_USER->hasPerm('advancedMode[]'))
    {
      $devInfos =
      '<span class="rex-notice">
         '. $I18N->msg('phpini_settings') .':<br />
         '. ((rex_ini_get('file_uploads') == 0) ? '<span>'. $I18N->msg('pool_upload') .':</span> <em>'. $I18N->msg('pool_upload_disabled') .'</em><br />' : '') .'
         <span>'. $I18N->msg('pool_max_uploadsize') .':</span> '. OOMedia::_getFormattedSize(rex_ini_get('upload_max_filesize')) .'<br />
         <span>'. $I18N->msg('pool_max_uploadtime') .':</span> '. rex_ini_get('max_input_time') .'s
       </span>';
    }

    $add_file = '<p>
                   <label for="file_new">'.$I18N->msg('pool_file_file').'</label>
                   <input type="file" id="file_new" name="file_new" size="30" />
                   '. $devInfos .'
                 </p>';
  }

  $add_submit = '';
  if (rex_session('media[opener_input_field]') != '')
  {
    $add_submit = '<input type="submit" class="rex-sbmt" name="saveandexit" value="'.$I18N->msg('pool_file_upload_get').'"'. rex_accesskey($I18N->msg('pool_file_upload_get'), $REX['ACKEY']['SAVE']) .' />';
  }

  $s .= '
      <div class="rex-mpl-oth">
      <form action="index.php" method="post" enctype="multipart/form-data">
           <fieldset>
             <legend class="rex-lgnd"><span >'. $form_title .'</span></legend>
               <input type="hidden" name="page" value="medienpool" />
               <input type="hidden" name="media_method" value="add_file" />
               <input type="hidden" name="subpage" value="'. $subpage .'" />
               <p>
                 <label for="ftitle">'.$I18N->msg('pool_file_title').'</label>
                 <input type="text" size="20" id="ftitle" name="ftitle" value="'.htmlspecialchars(stripslashes($ftitle)).'" />
               </p>
               <p>
                 <label for="rex_file_category">'.$I18N->msg('pool_file_category').'</label>
                 '.$cats_sel->get().'
               </p>';

  // ----- EXTENSION POINT
  $s .= rex_register_extension_point('MEDIA_FORM_ADD', '');

  $s .=        $add_file .'
               <p class="rex-sbmt">
                 <input type="submit" name="save" value="'.$button_title.'"'. rex_accesskey($button_title, $REX['ACKEY']['SAVE']) .' />
                 '. $add_submit .'
               </p>
           </fieldset>
        ';

  if($close_form)
  {
    $s .= '</form></div>'."\n";
  }

  return $s;
}

/**
 * Ausgabe des Medienpool Upload-Formulars
 */
function rex_medienpool_Uploadform($rex_file_category)
{
  global $I18N;

  return rex_medienpool_Mediaform($I18N->msg('pool_file_insert'), $I18N->msg('pool_file_upload'), $rex_file_category, true, true);
}

/**
 * Ausgabe des Medienpool Sync-Formulars
 */
function rex_medienpool_Syncform($rex_file_category)
{
  global $I18N;

  return rex_medienpool_Mediaform($I18N->msg('pool_sync_title'), $I18N->msg('pool_sync_button'), $rex_file_category, false, false);
}

?>