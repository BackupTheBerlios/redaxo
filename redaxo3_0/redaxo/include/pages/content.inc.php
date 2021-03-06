<?php


/**
 * Verwaltung der Inhalte. EditierModul / Metadaten ...
 * @package redaxo4
 * @version $Id: content.inc.php,v 1.137 2007/12/04 16:00:30 kills Exp $
 */

/*
// TODOS:
// - alles vereinfachen
// - <? ?> $ Problematik bei REX_ACTION
*/

unset ($REX_ACTION);

$slice_id = rex_request('slice_id', 'int', '');
$article_id = rex_request('article_id', 'int');
$category_id = rex_request('category_id', 'int');
$function = rex_request('function', 'string');

$article = new rex_sql;
$article->setQuery("
		SELECT
			article.*, template.attributes as template_attributes
		FROM
			" . $REX['TABLE_PREFIX'] . "article as article
		LEFT JOIN " . $REX['TABLE_PREFIX'] . "template as template
      ON template.id=article.template_id
		WHERE
			article.id='$article_id'
			AND clang=$clang");

if ($article->getRows() == 1)
{

  // ----- ctype holen
  $attributes = $article->getValue('template_attributes');

  // F�r Artikel ohne Template
  if($attributes === null) $attributes = '';

  $REX['CTYPE'] = rex_getAttributes('ctype', $attributes, array ()); // ctypes - aus dem template
  $ctype = rex_request('ctype', 'int');
  if (!array_key_exists($ctype, $REX['CTYPE']))
    $ctype = 1; // default = 1

  // ----- Artikel wurde gefunden - Kategorie holen
  if ($article->getValue('startpage') == 1)
    $category_id = $article->getValue('id');
  else
    $category_id = $article->getValue('re_id');

  // ----- category pfad und rechte
  include $REX['INCLUDE_PATH'] . '/functions/function_rex_category.inc.php';
  // $KATout kommt aus dem include
  // $KATPERM

  if ($page == 'content' && $article_id > 0)
  {
    $KATout .= "\n" . '<p>';

    if ($article->getValue('startpage') == 1)
      $KATout .= $I18N->msg('start_article') . ' : ';
    else
      $KATout .= $I18N->msg('article') . ' : ';

    $catname = str_replace(' ', '&nbsp;', $article->getValue('name'));

    $KATout .= '<a href="index.php?page=content&amp;article_id=' . $article_id . '&amp;mode=edit&amp;clang=' . $clang . '"'. rex_tabindex() .'>' . $catname . '</a>';
    // $KATout .= " [$article_id]";
    $KATout .= '</p>';
  }

  // ----- Titel anzeigen
  rex_title($I18N->msg('content'), $KATout);

  // ----- Sprachenblock
  $sprachen_add = '&amp;category_id=' . $category_id . '&amp;article_id=' . $article_id;
  include $REX['INCLUDE_PATH'] . '/functions/function_rex_languages.inc.php';

	// ----- Request Parameter
  $mode = rex_request('mode', 'string');
  $function = rex_request('function', 'string');
  $message = rex_request('message', 'string');

  // ----- mode defs
  if ($mode != 'meta')
    $mode = 'edit';

  // ----------------- HAT USER DIE RECHTE AN DIESEM ARTICLE ODER NICHT
  if (!($KATPERM || $REX_USER->hasPerm('article[' . $article_id . ']')))
  {
    // ----- hat keine rechte an diesem artikel
    echo rex_warning($I18N->msg('no_rights_to_edit'));

  }
  else
  {
    // ----- hat rechte an diesem artikel

    // ------------------------------------------ Slice add/edit/delete
    if (isset ($save) and ($function == 'add' or $function == 'edit' or $function == 'delete') and $save == 1)
    {

      // ----- check module

      $CM = new rex_sql;
      if ($function == 'edit' || $function == 'delete')
      {
        // edit/ delete
        $CM->setQuery("SELECT * FROM " . $REX['TABLE_PREFIX'] . "article_slice LEFT JOIN " . $REX['TABLE_PREFIX'] . "module ON " . $REX['TABLE_PREFIX'] . "article_slice.modultyp_id=" . $REX['TABLE_PREFIX'] . "module.id WHERE " . $REX['TABLE_PREFIX'] . "article_slice.id='$slice_id' AND clang=$clang");
        if ($CM->getRows() == 1)
          $module_id = $CM->getValue("" . $REX['TABLE_PREFIX'] . "article_slice.modultyp_id");
      }
      else
      {
        // add
        $CM->setQuery("SELECT * FROM " . $REX['TABLE_PREFIX'] . "module WHERE id='$module_id'");
      }

      if ($CM->getRows() != 1)
      {
        // ------------- START: MODUL IST NICHT VORHANDEN
        $message = $I18N->msg('module_not_found');
        $slice_id = '';
        $function = '';
        $module_id = '';
        $save = '';
        // ------------- END: MODUL IST NICHT VORHANDEN

      }
      else
      {
        // ------------- MODUL IST VORHANDEN

        // ----- RECHTE AM MODUL ?
        if (!($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('module[' . $module_id . ']') || $REX_USER->hasPerm('module[0]')))
        {
          // ----- RECHTE AM MODUL: NEIN
          $message = $I18N->msg('no_rights_to_this_function');
          $slice_id = '';
          $function = '';
          $module_id = '';
          $save = '';

        }
        else
        {
          // ----- RECHTE AM MODUL: JA
          $message = '';

          // ***********************  daten einlesen
          $REX_ACTION = array ();
          $REX_ACTION['SAVE'] = true;

          foreach ($REX['VARIABLES'] as $obj)
          {
            $REX_ACTION = $obj->getACRequestValues($REX_ACTION);
          }

          // ----- PRE SAVE ACTION [ADD/EDIT/DELETE]

          if ($function == 'edit')
            $modebit = '2'; // pre-action and edit
          elseif ($function == 'delete')
          	$modebit = '4'; // pre-action and delete
          else
            $modebit = '1'; // pre-action and add

          $ga = new rex_sql;
          $ga->setQuery('SELECT presave FROM ' . $REX['TABLE_PREFIX'] . 'module_action ma,' . $REX['TABLE_PREFIX'] . 'action a WHERE presave != "" AND ma.action_id=a.id AND module_id=' . $module_id . ' AND ((a.presavemode & ' . $modebit . ') = ' . $modebit . ')');

          for ($i = 0; $i < $ga->getRows(); $i++)
          {
            $REX_ACTION['MSG'] = '';
            $iaction = $ga->getValue('presave');

            // *********************** WERTE ERSETZEN
            foreach ($REX['VARIABLES'] as $obj)
            {
              $iaction = $obj->getACOutput($REX_ACTION, $iaction);
            }

            eval ('?>' . $iaction);
            if ($REX_ACTION['MSG'] != '')
              $message .= $REX_ACTION['MSG'] . ' | ';
            $ga->next();
          }

          // ----- / PRE SAVE ACTION

          // Statusspeicherung f�r die rex_article Klasse
          $REX['ACTION'] = $REX_ACTION;

          // Werte werden aus den REX_ACTIONS �bernommen wenn SAVE=true
          if (!$REX_ACTION['SAVE'])
          {
            // ----- DONT SAVE/UPDATE SLICE

            if ($REX_ACTION['MSG'] != '')
              $message = $REX_ACTION['MSG'];
            elseif ($function == 'delete')
            	$message = $I18N->msg('slice_deleted_error');
            else
              $message = $I18N->msg('slice_saved_error');

          }
          else
          {

            // ----- SAVE/UPDATE SLICE

            if ($function == 'add' || $function == 'edit')
            {

              $newsql = new rex_sql;
              // $newsql->debugsql = true;
              $sliceTable = $REX['TABLE_PREFIX'] . 'article_slice';
              $newsql->setTable($sliceTable);

              if ($function == 'edit')
              {
                // edit
                $newsql->setWhere('id=' . $slice_id);
              }
              elseif ($function == 'add')
              {
                // add
                $newsql->setValue($sliceTable .'.re_article_slice_id', $slice_id);
                $newsql->setValue($sliceTable .'.article_id', $article_id);
                $newsql->setValue($sliceTable .'.modultyp_id', $module_id);
                $newsql->setValue($sliceTable .'.clang', $clang);
                $newsql->setValue($sliceTable .'.ctype', $ctype);
              }

              // ****************** SPEICHERN FALLS NOETIG
              foreach ($REX['VARIABLES'] as $obj)
              {
                $obj->setACValues($newsql, $REX_ACTION, true);
              }

              if ($function == 'edit')
              {
                $newsql->addGlobalUpdateFields();
                if ($newsql->update())
                  $message .= $I18N->msg('block_updated');
                else
                  $message .= $newsql->getError();

              }
              elseif ($function == 'add')
              {
                $newsql->addGlobalCreateFields();
                if ($newsql->insert())
                {
                  $last_id = $newsql->getLastId();
                  if ($newsql->setQuery('UPDATE ' . $REX['TABLE_PREFIX'] . 'article_slice SET re_article_slice_id=' . $last_id . ' WHERE re_article_slice_id=' . $slice_id . ' AND id<>' . $last_id . ' AND article_id=' . $article_id . ' AND clang=' . $clang))
                  {
                    $message .= $I18N->msg('block_added');
                    $slice_id = $last_id;
                  }
                  $function = "";
                }
                else
                {
                  $message .= $newsql->getError();
                }
              }
            }
            else
            {
              // make delete
              $re_id = $CM->getValue($REX['TABLE_PREFIX'] . 'article_slice.re_article_slice_id');
              $newsql = new rex_sql;
              $newsql->setQuery('SELECT * FROM ' . $REX['TABLE_PREFIX'] . 'article_slice WHERE re_article_slice_id=' . $slice_id);
              if ($newsql->getRows() > 0)
              {
                $newsql->setQuery('UPDATE ' . $REX['TABLE_PREFIX'] . 'article_slice SET re_article_slice_id=' . $re_id . ' where id=' . $newsql->getValue('id'));
              }
              $newsql->setQuery('DELETE FROM ' . $REX['TABLE_PREFIX'] . 'article_slice WHERE id=' . $slice_id);
              $message = $I18N->msg('block_deleted');
            }
            // ----- / SAVE SLICE

            // ----- artikel neu generieren
            $EA = new rex_sql;
            $EA->setTable($REX['TABLE_PREFIX'] . 'article');
            $EA->setWhere('id='. $article_id .' AND clang='. $clang);
            $EA->addGlobalUpdateFields();
            $EA->update();
            rex_generateArticle($article_id);

            // ----- POST SAVE ACTION [ADD/EDIT/DELETE]

            $ga = new rex_sql;
            $ga->setQuery('SELECT postsave FROM ' . $REX['TABLE_PREFIX'] . 'module_action ma,' . $REX['TABLE_PREFIX'] . 'action a WHERE postsave != "" AND ma.action_id=a.id AND module_id=' . $module_id . ' AND ((a.postsavemode & ' . $modebit . ') = ' . $modebit . ')');

            for ($i = 0; $i < $ga->getRows(); $i++)
            {
              $REX_ACTION['MSG'] = '';
              $iaction = $ga->getValue('postsave');

              // ***************** WERTE ERSETZEN UND POSTACTION AUSF�HREN
              foreach ($REX['VARIABLES'] as $obj)
              {
                $iaction = $obj->getACOutput($REX_ACTION, $iaction);
              }

              eval ('?>' . $iaction);

              if ($REX_ACTION['MSG'] != '')
                $message .= ' | ' . $REX_ACTION['MSG'];

              $ga->next();
            }

            // ----- / POST SAVE ACTION

            // Update Button wurde gedr�ckt?
            if (rex_post('btn_save', 'string'))
            {
              $function = '';
            }

            $save = '';
          }
        }
      }
    }
    // ------------------------------------------ END: Slice add/edit/delete

    // ------------------------------------------ START: Slice move up/down
    if ($function == 'moveup' || $function == 'movedown')
    {
      if ($REX_USER->hasPerm('moveSlice[]'))
      {
        // modul und rechte vorhanden ?

        $CM = new rex_sql;
        $CM->setQuery("select * from " . $REX['TABLE_PREFIX'] . "article_slice left join " . $REX['TABLE_PREFIX'] . "module on " . $REX['TABLE_PREFIX'] . "article_slice.modultyp_id=" . $REX['TABLE_PREFIX'] . "module.id where " . $REX['TABLE_PREFIX'] . "article_slice.id='$slice_id' and clang=$clang");
        if ($CM->getRows() != 1)
        {
          // ------------- START: MODUL IST NICHT VORHANDEN
          $message = $I18N->msg('module_not_found');
          $slice_id = "";
          $function = "";
          $module_id = "";
          $save = "";
          // ------------- END: MODUL IST NICHT VORHANDEN

        }
        else
        {

          // ------------- MODUL IST VORHANDEN
          $module_id = $CM->getValue($REX['TABLE_PREFIX'] . "article_slice.modultyp_id");

          // ----- RECHTE AM MODUL ?
          if ($REX_USER->hasPerm("admin[]") || $REX_USER->hasPerm("dev[]") || $REX_USER->hasPerm("module[$module_id]") || $REX_USER->hasPerm("module[0]"))
          {
            // rechte sind vorhanden
            // ctype beachten
            // verschieben / vertauschen
            // article regenerieren.

            $slice_id = $CM->getValue($REX['TABLE_PREFIX'] . "article_slice.id");
            $slice_article_id = $CM->getValue("article_id");
            $re_slice_id = $CM->getValue($REX['TABLE_PREFIX'] . "article_slice.re_article_slice_id");
            $slice_ctype = $CM->getValue($REX['TABLE_PREFIX'] . "article_slice.ctype");

            $gs = new rex_sql;
            // $gs->debugsql = 1;
            $gs->setQuery("select * from " . $REX['TABLE_PREFIX'] . "article_slice where article_id='$slice_article_id'");
            for ($i = 0; $i < $gs->getRows(); $i++)
            {
              $SID[$gs->getValue("re_article_slice_id")] = $gs->getValue("id");
              $SREID[$gs->getValue("id")] = $gs->getValue("re_article_slice_id");
              $SCTYPE[$gs->getValue("id")] = $gs->getValue("ctype");
              $gs->next();
            }

            $message = $I18N->msg('slice_moved_error');
            // ------ moveup
            if ($function == "moveup")
            {
              if ($SREID[$slice_id] > 0)
              {
                if ($SCTYPE[$SREID[$slice_id]] == $slice_ctype)
                {
                  $gs->setQuery("update " . $REX['TABLE_PREFIX'] . "article_slice set re_article_slice_id='" . $SREID[$SREID[$slice_id]] . "' where id='" . $slice_id . "'");
                  $gs->setQuery("update " . $REX['TABLE_PREFIX'] . "article_slice set re_article_slice_id='" . $slice_id . "' where id='" . $SREID[$slice_id] . "'");
                  if ($SID[$slice_id] > 0)
                    $gs->setQuery("update " . $REX['TABLE_PREFIX'] . "article_slice set re_article_slice_id='" . $SREID[$slice_id] . "' where id='" . $SID[$slice_id] . "'");
                  $message = $I18N->msg('slice_moved');
                  rex_generateArticle($slice_article_id);
                }
              }
            }

            // ------ movedown
            if ($function == "movedown")
            {
              if ($SID[$slice_id] > 0)
              {
                if ($SCTYPE[$SID[$slice_id]] == $slice_ctype)
                {
                  $gs->setQuery("update " . $REX['TABLE_PREFIX'] . "article_slice set re_article_slice_id='" . $SREID[$slice_id] . "' where id='" . $SID[$slice_id] . "'");
                  $gs->setQuery("update " . $REX['TABLE_PREFIX'] . "article_slice set re_article_slice_id='" . $SID[$slice_id] . "' where id='" . $slice_id . "'");
                  if ($SID[$SID[$slice_id]] > 0)
                    $gs->setQuery("update " . $REX['TABLE_PREFIX'] . "article_slice set re_article_slice_id='" . $slice_id . "' where id='" . $SID[$SID[$slice_id]] . "'");
                  $message = $I18N->msg('slice_moved');
                  rex_generateArticle($slice_article_id);
                }
              }
            }
          }
          else
          {
            $message = $I18N->msg('no_rights_to_this_function');
          }
        }
      }
      else
      {
        $message = $I18N->msg('no_rights_to_this_function');
      }
    }
    // ------------------------------------------ END: Slice move up/down

		// ------------------------------------------ START: ARTICLE2STARTARTICLE
    if (rex_post('article2startpage', 'string'))
    {
      if ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('article2startpage[]'))
      {
        if (rex_article2startpage($article_id))
        {
          $message = $I18N->msg('content_tostartarticle_ok');
          header("Location:index.php?page=content&mode=meta&clang=$clang&ctype=$ctype&article_id=$article_id&message=".urlencode($message));
          exit;
        }
        else
        {
          $message = $I18N->msg('content_tostartarticle_failed');
        }
      }
    }
    // ------------------------------------------ END: COPY LANG CONTENT


    // ------------------------------------------ START: COPY LANG CONTENT
    if (rex_post('copycontent', 'string'))
    {
      if ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('copyContent[]'))
      {
        if (rex_copyContent($article_id, $article_id, $clang_a, $clang_b))
        {
          $message = $I18N->msg('content_contentcopy');
        }
        else
        {
          $message = $I18N->msg('content_errorcopy');
        }
      }
    }
    // ------------------------------------------ END: COPY LANG CONTENT

    // ------------------------------------------ START: MOVE ARTICLE
    if (rex_post('movearticle', 'string') && $category_id != $article_id)
    {

      $category_id_new = rex_post('category_id_new', 'int');
      if ($REX_USER->hasPerm('admin[]') || ($REX_USER->hasPerm('moveArticle[]') && ($REX_USER->hasPerm('csw[0]') || $REX_USER->hasPerm('csw[' . $category_id_new . ']'))))
      {
        if (rex_moveArticle($article_id, $category_id, $category_id_new))
        {
          $message = $I18N->msg('content_articlemoved');
          ob_end_clean();
          header('Location: index.php?page=content&article_id=' . $article_id . '&mode=meta&clang=' . $clang . '&ctype=' . $ctype . '&message=' . urlencode($message));
          exit;
        }
        else
        {
          $message = $I18N->msg('content_errormovearticle');
        }
      }
      else
      {
        $message = $I18N->msg('no_rights_to_this_function');
      }
    }
    // ------------------------------------------ END: MOVE ARTICLE

    // ------------------------------------------ START: COPY ARTICLE
    if (rex_post('copyarticle', 'string'))
    {
    	$category_copy_id_new = rex_post('category_copy_id_new', 'int');
      if ($REX_USER->hasPerm('admin[]') || ($REX_USER->hasPerm('copyArticle[]') && ($REX_USER->hasPerm('csw[0]') || $REX_USER->hasPerm('csw[' . $category_copy_id_new . ']'))))
      {
        if ($new_id = rex_copyArticle($article_id, $category_copy_id_new))
        {
          $message = $I18N->msg('content_articlecopied');
          ob_end_clean();
          header('Location: index.php?page=content&article_id=' . $new_id . '&mode=meta&clang=' . $clang . '&ctype=' . $ctype . '&message=' . urlencode($message));
          exit;
        }
        else
        {
          $message = $I18N->msg('content_errorcopyarticle');
        }
      }
      else
      {
        $message = $I18N->msg('no_rights_to_this_function');
      }
    }
    // ------------------------------------------ END: COPY ARTICLE

    // ------------------------------------------ START: MOVE CATEGORY
    if (rex_post('movecategory', 'string'))
    {
    	$category_id_new = rex_post('category_id_new', 'int');
      if ($REX_USER->hasPerm('admin[]') || ($REX_USER->hasPerm('moveCategory[]') && (($REX_USER->hasPerm('csw[0]') || $REX_USER->hasPerm('csw[' . $category_id . ']')) && ($REX_USER->hasPerm('csw[0]') || $REX_USER->hasPerm('csw[' . $category_id_new . ']')))))
      {
        if ($category_id != $category_id_new && rex_moveCategory($category_id, $category_id_new))
        {
          $message = $I18N->msg('category_moved');
          ob_end_clean();
          header('Location: index.php?page=content&article_id=' . $category_id . '&mode=meta&clang=' . $clang . '&ctype=' . $ctype . '&message=' . urlencode($message));
          exit;
        }
        else
        {
          $message = $I18N->msg('content_error_movecategory');
        }
      }
      else
      {
        $message = $I18N->msg('no_rights_to_this_function');
      }
    }
    // ------------------------------------------ END: MOVE CATEGORY

    // ------------------------------------------ START: SAVE METADATA
    if (rex_post('savemeta', 'string'))
    {
      $meta_sql = new rex_sql;
      $meta_sql->setTable($REX['TABLE_PREFIX'] . "article");
      // $meta_sql->debugsql = 1;
      $meta_sql->setWhere("id='$article_id' AND clang=$clang");
      $meta_sql->setValue('name', $meta_article_name);
      $meta_sql->addGlobalUpdateFields();

      if($meta_sql->update())
      {
        $article->setQuery("SELECT * FROM " . $REX['TABLE_PREFIX'] . "article WHERE id='$article_id' AND clang='$clang'");

        $message = $I18N->msg("metadata_updated") . $message;

        rex_generateArticle($article_id);

        // ----- EXTENSION POINT
        $message = rex_register_extension_point('ART_META_UPDATED', $message, array (
          'id' => $article_id,
          'clang' => $clang,
          'name' => $meta_article_name,
        ));
      }
      else
      {
        $message .= $meta_sql->getError();
      }
    }
    // ------------------------------------------ END: SAVE METADATA

    // ------------------------------------------ START: CONTENT HEAD MENUE
    $num_ctypes = count($REX['CTYPE']);

    $tadd = '';
    if ($num_ctypes > 0)
    {
      $tadd = '
                  <ul>';
			if ($num_ctypes > 1) $tadd .= '<li>'.$I18N->msg('content_types').': </li>';
			else $tadd .= '<li>'.$I18N->msg('content_type').': </li>';

      $i = 1;
      foreach ($REX['CTYPE'] as $key => $val)
      {
        $tadd .= '
                        <li>';
        $class = '';
        if ($key == $ctype && $mode == 'edit')
        {
        	$class = ' class="rex-active"';
        }

        $val = rex_translate($val);
        $tadd .= '<a href="index.php?page=content&amp;clang=' . $clang . '&amp;ctype=' . $key . '&amp;category_id=' . $category_id . '&amp;article_id=' . $article_id . '"'. $class .''. rex_tabindex() .'>' . $val . '</a>';

        if ($num_ctypes != $i)
        {
          $tadd .= ' | ';
        }
        $tadd .= '</li>';
        $i++;
      }
      $tadd .= '
                  </ul>';
    }

    $menu = $tadd;

    if ($mode == 'edit')
    {
      $menu_edit = '<a href="index.php?page=content&amp;article_id=' . $article_id . '&amp;mode=edit&amp;clang=' . $clang . '&amp;ctype=' . $ctype . '" class="rex-active"'. rex_tabindex() .'>' . $I18N->msg('edit_mode') . '</a>';
      $menu_meta = '<a href="index.php?page=content&amp;article_id=' . $article_id . '&amp;mode=meta&amp;clang=' . $clang . '&amp;ctype=' . $ctype . '"'. rex_tabindex() .'>' . $I18N->msg('metadata') . '</a>';
    }
    else
    {
      $menu_edit = '<a href="index.php?page=content&amp;article_id=' . $article_id . '&amp;mode=edit&amp;clang=' . $clang . '&amp;ctype=' . $ctype . '"'. rex_tabindex() .'>' . $I18N->msg('edit_mode') . '</a>';
      $menu_meta = '<a href="index.php?page=content&amp;article_id=' . $article_id . '&amp;mode=meta&amp;clang=' . $clang . '&amp;ctype=' . $ctype . '" class="rex-active"'. rex_tabindex() .'>' . $I18N->msg('metadata') . '</a>';
    }

    $menu .= '
            <ul class="rex-cnt-nav">
              <li>' . $menu_edit . ' | </li>
              <li>' . $menu_meta . ' | </li>
              <li><a href="../index.php?article_id=' . $article_id . '&amp;clang=' . $clang . '" target="_blank"'. rex_tabindex() .'>' . $I18N->msg('show') . '</a></li>
            </ul>';
    // ------------------------------------------ END: CONTENT HEAD MENUE

    // ------------------------------------------ START: AUSGABE
    echo '
            <!-- *** OUTPUT OF ARTICLE-CONTENT - START *** -->
            <div class="rex-cnt-hdr">
              ' . $menu . '
            </div>
            ';

    // ------------------------------------------ WARNING
    if ($mode != 'edit' && $message != '')
    {
      echo rex_warning($message);
    }

    echo '
            <div class="rex-cnt-bdy">
            ';

    if ($mode == 'edit')
    {


      // ------------------------------------------ START: MODULE EDITIEREN/ADDEN ETC.
      echo '
                  <!-- *** OUTPUT OF ARTICLE-CONTENT-EDIT-MODE - START *** -->
                  <div class="rex-cnt-editmode">
                  ';
      $CONT = new rex_article;
      $CONT->message = $message;
      $CONT->setArticleId($article_id);
      $CONT->setSliceId($slice_id);
      $CONT->setMode($mode);
      $CONT->setCLang($clang);
      $CONT->setEval(TRUE);
      $CONT->setFunction($function);
      eval ("?>" . $CONT->getArticle($ctype));

      echo '
                  </div>
                  <!-- *** OUTPUT OF ARTICLE-CONTENT-EDIT-MODE - END *** -->
                  ';
      // ------------------------------------------ END: MODULE EDITIEREN/ADDEN ETC.

    }
    elseif ($mode == 'meta')
    {
      // ------------------------------------------ START: META VIEW

      echo '
    	  <div class="rex-cnt-metamode">
          <form action="index.php" method="post" enctype="multipart/form-data" id="REX_FORM">
            <fieldset>
              <legend class="rex-lgnd">' . $I18N->msg('general') . '</legend>

				      <div class="rex-fldst-wrppr">

						  <input type="hidden" name="page" value="content" />
						  <input type="hidden" name="article_id" value="' . $article_id . '" />
						  <input type="hidden" name="mode" value="meta" />
						  <input type="hidden" name="save" value="1" />
						  <input type="hidden" name="clang" value="' . $clang . '" />
						  <input type="hidden" name="ctype" value="' . $ctype . '" />

						<p>
						  <label for="meta_article_name">' . $I18N->msg("name_description") . '</label>
						  <input type="text" id="meta_article_name" name="meta_article_name" value="' . htmlspecialchars($article->getValue("name")) . '" size="30"'. rex_tabindex() .' />
						</p>';

      // ----- EXTENSION POINT
      echo rex_register_extension_point('ART_META_FORM', '', array (
        'id' => $article_id,
        'clang' => $clang,
        'article' => $article
      ));

      echo '
								<p>
								  <input class="rex-sbmt" type="submit" name="savemeta" value="' . $I18N->msg("update_metadata") . '"'. rex_accesskey($I18N->msg('update_metadata'), $REX['ACKEY']['SAVE']) . rex_tabindex() .' />
								</p>
	            </div>
	         </fieldset>';

      // ----- EXTENSION POINT
      echo rex_register_extension_point('ART_META_FORM_SECTION', '', array (
        'id' => $article_id,
        'clang' => $clang
      ));

      // --------------------------------------------------- START - FUNKTION ZUM AUSLESEN DER KATEGORIEN
      function add_cat_options(& $select, & $cat, & $cat_ids)
      {
        global $REX_USER;
        if (empty ($cat))
        {
          return;
        }

        $cat_ids[] = $cat->getId();
        if ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('csw[0]') || $REX_USER->hasPerm('csr[' . $cat->getId() . ']') || $REX_USER->hasPerm('csw[' . $cat->getId() . ']'))
        {
          $select->addOption($cat->getName(), $cat->getId(), $cat->getId(), $cat->getParentId());
          $childs = $cat->getChildren();
          if (is_array($childs))
          {
            foreach ($childs as $child)
            {
              add_cat_options($select, $child, $cat_ids);
            }
          }
        }
      }
      // --------------------------------------------------- ENDE - FUNKTION ZUM AUSLESEN DER KATEGORIEN

      // ------------------------------------------------------------- SONSTIGES START
      if ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('article2startpage[]') || $REX_USER->hasPerm('moveArticle[]') || $REX_USER->hasPerm('copyArticle[]') || ($REX_USER->hasPerm('copyContent[]') && count($REX['CLANG']) > 1))
      {

				// --------------------------------------------------- ZUM STARTARTICLE MACHEN START
				if ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('article2startpage[]'))
				{
					echo '
                <fieldset>
                  <legend class="rex-lgnd">' . $I18N->msg('content_startarticle') . '</legend>
  							  <div class="rex-fldst-wrppr">
									  <p>';

					if ($article->getValue('startpage')==0 && $article->getValue('re_id')==0)
						echo $I18N->msg('content_nottostartarticle');
					else if ($article->getValue('startpage')==1)
						echo $I18N->msg('content_isstartarticle');
					else
						echo '<input class="rex-sbmt" type="submit" name="article2startpage" value="' . $I18N->msg('content_tostartarticle') . '"'. rex_tabindex() .' onclick="return confirm(\'' . $I18N->msg('content_tostartarticle') . '?\')" />';

					echo '
									  </p>
								  </div>
                </fieldset>';
				}
				// --------------------------------------------------- ZUM STARTARTICLE MACHEN END


        // --------------------------------------------------- INHALTE KOPIEREN START
        if (($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('copyContent[]')) && count($REX['CLANG']) > 1)
        {
          $lang_a = new rex_select;
          $lang_a->setId('clang_a');
          $lang_a->setName('clang_a');
          $lang_a->setSize('1');
          $lang_a->setAttribute('tabindex', rex_tabindex(false));
          foreach ($REX['CLANG'] as $key => $val)
          {
            $val = rex_translate($val);
            $lang_a->addOption($val, $key);
          }

          $lang_b = new rex_select;
          $lang_b->setId('clang_b');
          $lang_b->setName('clang_b');
          $lang_b->setSize('1');
          $lang_b->setAttribute('tabindex', rex_tabindex(false));
          foreach ($REX['CLANG'] as $key => $val)
          {
            $val = rex_translate($val);
            $lang_b->addOption($val, $key);
          }

          $lang_a->setSelected(rex_request('clang_a', 'int', null));
          $lang_b->setSelected(rex_request('clang_b', 'int', null));

          echo '
                <fieldset>
                  <legend class="rex-lgnd">' . $I18N->msg('content_submitcopycontent') . '</legend>
  							  <div class="rex-fldst-wrppr">
									  <p>
											<label for="clang_a">' . $I18N->msg('content_contentoflang') . '</label>
											' . $lang_a->get() . '
											<label for="clang_b">' . $I18N->msg('content_to') . '</label>
											' . $lang_b->get() . '
									  </p>
									  <p>
											<input class="rex-sbmt" type="submit" name="copycontent" value="' . $I18N->msg('content_submitcopycontent') . '"'. rex_tabindex() .' onclick="return confirm(\'' . $I18N->msg('content_submitcopycontent') . '?\')" />
									  </p>
								  </div>
                </fieldset>';

        }
        // --------------------------------------------------- INHALTE KOPIEREN ENDE

        // --------------------------------------------------- ARTIKEL VERSCHIEBEN START
        if ($article->getValue('startpage') == 0 && ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('moveArticle[]')))
        {

          // Wenn Artikel kein Startartikel dann Selectliste darstellen, sonst...
          $move_a = new rex_select;
          $move_a->setId('category_id_new');
          $move_a->setName('category_id_new');
          $move_a->setSize('1');
          $move_a->setAttribute('tabindex', rex_tabindex(false));
          $move_a->setSelected($category_id);
          $move_a->addOption('Homepage',0);

          if ($cats = OOCategory :: getRootCategories())
          {
            foreach ($cats as $cat)
            {
              add_cat_options($move_a, $cat, $cat_ids, '');
            }
          }

          echo '
                <fieldset>
                  <legend class="rex-lgnd">' . $I18N->msg('content_submitmovearticle') . '</legend>
						      <div class="rex-fldst-wrppr">
									  <p>
											<label for="category_id_new">' . $I18N->msg('move_article') . '</label>
											' . $move_a->get() . '
									  </p>
									  <p>
											<input class="rex-sbmt" type="submit" name="movearticle" value="' . $I18N->msg('content_submitmovearticle') . '"'. rex_tabindex() .' onclick="return confirm(\'' . $I18N->msg('content_submitmovearticle') . '?\')" />
									  </p>
								  </div>
                </fieldset>';

        }
        // ------------------------------------------------ ARTIKEL VERSCHIEBEN ENDE

        // -------------------------------------------------- ARTIKEL KOPIEREN START
        if ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('copyArticle[]'))
        {
          $move_a = new rex_select;
          $move_a->setName('category_copy_id_new');
          $move_a->setId('category_copy_id_new');
          $move_a->setSize('1');
          $move_a->setSelected($category_id);
          $move_a->setAttribute('tabindex', rex_tabindex(false));

					$move_a->addOption('Homepage',0);

          if ($cats = OOCategory :: getRootCategories())
          {
            foreach ($cats as $cat)
            {
              add_cat_options($move_a, $cat, $cat_ids, '');
            }
          }

          echo '
                  <fieldset>
                    <legend class="rex-lgnd">' . $I18N->msg('content_submitcopyarticle') . '</legend>
    							  <div class="rex-fldst-wrppr">
										  <p>
												<label for="category_copy_id_new">' . $I18N->msg('copy_article') . '</label>
												' . $move_a->get() . '
										  </p>
										  <p>
												<input class="rex-sbmt" type="submit" name="copyarticle" value="' . $I18N->msg('content_submitcopyarticle') . '"'. rex_tabindex() .' onclick="return confirm(\'' . $I18N->msg('content_submitcopyarticle') . '?\')" />
										  </p>
									  </div>
                  </fieldset>';

        }
        // --------------------------------------------------- ARTIKEL KOPIEREN ENDE

        // --------------------------------------------------- KATEGORIE/STARTARTIKEL VERSCHIEBEN START
        if ($article->getValue('startpage') == 1 && ($REX_USER->hasPerm('admin[]') || $REX_USER->hasPerm('moveCategory[]')))
        {
          $move_a = new rex_select;
          $move_a->setId('category_id_new');
          $move_a->setName('category_id_new');
          $move_a->setSize('1');
          $move_a->setSelected($article_id);
          $move_a->setAttribute('tabindex', rex_tabindex(false));

					$move_a->addOption('Homepage',0);

          if ($cats = OOCategory :: getRootCategories())
          {
            foreach ($cats as $cat)
            {
              add_cat_options($move_a, $cat, $cat_ids, '');
            }
          }
          echo '
                  <fieldset>
                    <legend class="rex-lgnd">' . $I18N->msg('content_submitmovecategory') . '</legend>
    							  <div class="rex-fldst-wrppr">
										  <p>
												<label for="category_id_new">' . $I18N->msg('move_category') . '</label>
												' . $move_a->get() . '
										  </p>
										  <p>
												<input class="rex-sbmt" type="submit" name="movecategory" value="' . $I18N->msg('content_submitmovecategory') . '"'. rex_tabindex() .' onclick="return confirm(\'' . $I18N->msg('content_submitmovecategory') . '?\')" />
										  </p>
									  </div>
                  </fieldset>';

        }
        // ------------------------------------------------ KATEGROIE/STARTARTIKEL VERSCHIEBEN ENDE

      }
      // ------------------------------------------------------------- SONSTIGES ENDE

      echo '
                  </form>
            	  </div>';

      // ------------------------------------------ END: META VIEW

    }

    echo '
            </div>
            <!-- *** OUTPUT OF ARTICLE-CONTENT - END *** -->
            ';

    // ------------------------------------------ END: AUSGABE

  }
}
?>