<?php

/** 
 *  
 * @package redaxo3 
 * @version $Id: structure.inc.php,v 1.61 2006/06/14 13:39:23 kills Exp $ 
 */

/*
 * 
 * Todos: prio geschichten
 *
 * ### erstelle neue prioliste wenn noetig
 *
 */


// --------------------------------------------- EXISTIERT DIESER ZU EDITIERENDE ARTIKEL ?
if (isset ($edit_id) and $edit_id != '')
{
  $thisCat = new sql;
  $thisCat->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'article WHERE id ='.$edit_id.' and clang ='.$clang);
  
  if ($thisCat->getRows() != 1)
  {
    unset ($edit_id, $thisCat);
  }
}
else
{
  unset ($edit_id);
}

// --------------------------------------------- EXISTIERT DIESER ARTIKEL ?
if (isset ($article_id) and $article_id != '')
{
  $thisArt = new sql;
  $thisArt->setQuery('select * from '.$REX['TABLE_PREFIX'].'article where id='.$article_id.' and clang='. $clang);
  
  if ($thisArt->getRows() != 1)
  {
    unset ($article_id, $thisArt);
  }
}
else
{
  unset ($article_id);
}

if(!isset($function)) $function = '';
if(!isset($category_id)) $category_id = 0;

// --------------------------------------------- KATEGORIE PFAD UND RECHTE WERDEN �BERPR�FT

include $REX['INCLUDE_PATH'].'/functions/function_rex_category.inc.php';

// --------------------------------------------- TITLE

rex_title($I18N->msg('title_structure'), $KATout);

$sprachen_add = '&amp;category_id='. $category_id;
include $REX['INCLUDE_PATH'].'/functions/function_rex_languages.inc.php';

// --------------------------------------------- KATEGORIE FUNKTIONEN
if (!empty($catedit_function) && $edit_id != '' && $KATPERM)
{
  // --------------------- KATEGORIE EDIT

  $old_prio = $thisCat->getValue("catprior");
  $new_prio = (int) $Position_Category;
  if ($new_prio == 0)
    $new_prio = 1;
  $re_id = $thisCat->getValue("re_id");

  // --- Kategorie selbst updaten 
  $EKAT = new sql;
  $EKAT->setTable($REX['TABLE_PREFIX']."article");
  $EKAT->where("id=$edit_id AND startpage=1 AND clang=$clang");
  $EKAT->setValue("catname", "$kat_name");
  $EKAT->setValue("catprior", "$new_prio");
  $EKAT->setValue("path", $KATPATH);
  $EKAT->setValue("updatedate", time());
  $EKAT->setValue("updateuser", $REX_USER->getValue("login"));
  $EKAT->update();
  
  // --- Kategorie Kindelemente updaten 
  $ArtSql = new sql();
  $ArtSql->setQuery('SELECT id FROM '.$REX['TABLE_PREFIX'].'article WHERE re_id='.$edit_id .' AND startpage=0 AND clang='.$clang);
  
  for($i = 0; $i < $ArtSql->getRows(); $i++)
  {
    $EART = new sql();
    $EART->setTable($REX['TABLE_PREFIX']."article");
    $EART->where('id='. $ArtSql->getValue('id') .' AND startpage=0 AND clang='.$clang);
    $EART->setValue("catname", "$kat_name");
    $EART->setValue("updatedate", time());
    $EART->setValue("updateuser", $REX_USER->getValue("login"));
    $EART->update();
    
    rex_generateArticle($ArtSql->getValue('id'));
    $ArtSql->next();
  }

  // ----- PRIOR
  rex_newCatPrio($re_id, $clang, $new_prio, $old_prio);

  $message = $I18N->msg("category_updated");

  rex_generateArticle($edit_id);

  // ----- EXTENSION POINT
  $message = rex_register_extension_point('CAT_UPDATED', $message, array (
    "id" => $edit_id,
    "re_id" => $re_id,
    "clang" => $clang,
    "name" => $kat_name,
    "prior" => $new_prio,
    "path" => $KATPATH,
    "status" => $thisCat->getValue('status'
  )));

}
elseif (!empty($catdelete_function) && $edit_id != "" && $KATPERM && !$REX_USER->hasPerm("editContentOnly[]"))
{
  // --------------------- KATEGORIE DELETE
  
  $KAT = new sql;
  $KAT->setQuery("select * from ".$REX['TABLE_PREFIX']."article where re_id='$edit_id' and clang='$clang' and startpage=1");
  if ($KAT->getRows() == 0)
  {
    $KAT->setQuery("select * from ".$REX['TABLE_PREFIX']."article where re_id='$edit_id' and clang='$clang' and startpage=0");
    if ($KAT->getRows() == 0)
    {
      $re_id = $thisCat->getValue("re_id");
      $message = rex_deleteArticle($edit_id);

      // ----- PRIOR
      $CL = $REX['CLANG'];
      reset($CL);
      for ($j = 0; $j < count($CL); $j++)
      {
        $mlang = key($CL);
        rex_newCatPrio($re_id, $mlang, 0, 1);
        next($CL);
      }

      // ----- EXTENSION POINT
      $message = rex_register_extension_point('CAT_DELETED', $message, array (
        "id" => $edit_id,
        "re_id" => $re_id
      ));

    }
    else
    {
      $message = $I18N->msg("category_could_not_be_deleted")." ".$I18N->msg("category_still_contains_articles");
      $function = "edit";
    }
  }
  else
  {
    $message = $I18N->msg("category_could_not_be_deleted")." ".$I18N->msg("category_still_contains_subcategories");
    $function = "edit";
  }

}
elseif ($function == "status" && $edit_id != "" 
       && ($REX_USER->hasPerm("admin[]") || $KATPERM && $REX_USER->hasPerm("publishArticle[]")))
{
  // --------------------- KATEGORIE STATUS
  
  $KAT->setQuery("select * from ".$REX['TABLE_PREFIX']."article where id='$edit_id' and clang=$clang and startpage=1");
  if ($KAT->getRows() == 1)
  {
    if ($KAT->getValue("status") == 1)
      $newstatus = 0;
    else
      $newstatus = 1;

    $EKAT = new sql;
    $EKAT->setTable($REX['TABLE_PREFIX']."article");
    $EKAT->where("id='$edit_id' and clang=$clang and startpage=1");
    $EKAT->setValue("status", "$newstatus");
    $EKAT->setValue("updatedate", time());
    $EKAT->setValue("updateuser", $REX_USER->getValue("login"));
    $EKAT->update();

    $message = $I18N->msg("category_status_updated");
    rex_generateArticle($edit_id);

    // ----- EXTENSION POINT
    $message = rex_register_extension_point('CAT_STATUS', $message, array (
      "id" => $edit_id,
      "clang" => $clang,
      "status" => $newstatus
    ));

  }
  else
  {
    $message = $I18N->msg("no_such_category");
  }

}
elseif (!empty($catadd_function) && $KATPERM && !$REX_USER->hasPerm("editContentOnly[]"))
{
  // --------------------- KATEGORIE ADD
  
  $message = $I18N->msg("category_added_and_startarticle_created");
  $template_id = 0;
  unset ($TMP);
  if ($category_id != "")
  {
    $sql = new sql;
    // $sql->debugsql = 1;
    $sql->setQuery("select clang,template_id from ".$REX['TABLE_PREFIX']."article where id=$category_id and startpage=1");
    for ($i = 0; $i < $sql->getRows(); $i++, $sql->next())
    {
      $TMP[$sql->getValue("clang")] = $sql->getValue("template_id");
    }
  }

  $Position_New_Category = (int) $Position_New_Category;
  if ($Position_New_Category == 0)
    $Position_New_Category = 1;

  unset ($id);
  reset($REX['CLANG']);
  while (list ($key, $val) = each($REX['CLANG']))
  {

    // ### erstelle neue prioliste wenn noetig  

    $template_id = 0;
    if (isset ($TMP[$key]) && $TMP[$key] != "")
      $template_id = $TMP[$key];

    $AART = new sql;
    // $AART->debugsql = 1;
    $AART->setTable($REX['TABLE_PREFIX']."article");
    if (!isset ($id) or !$id)
      $id = $AART->setNewId("id");
    else
      $AART->setValue("id", $id);
    $AART->setValue("clang", $key);
    $AART->setValue("template_id", $template_id);
    $AART->setValue("name", "$category_name");
    $AART->setValue("catname", "$category_name");
    $AART->setValue("catprior", $Position_New_Category);
    $AART->setValue("re_id", $category_id);
    $AART->setValue("prior", 1);
    $AART->setValue("path", $KATPATH);
    $AART->setValue("startpage", 1);
    $AART->setValue("status", 0);
    $AART->setValue("online_from", time());
    $AART->setValue("online_to", mktime(0, 0, 0, 1, 1, 2010));
    $AART->setValue("createdate", time());
    $AART->setValue("createuser", $REX_USER->getValue("login"));
    $AART->setValue("updatedate", time());
    $AART->setValue("updateuser", $REX_USER->getValue("login"));
    $AART->insert();

    // ----- PRIOR
    rex_newCatPrio($category_id, $key, 0, $Position_New_Category);

    // ----- EXTENSION POINT
    $message = rex_register_extension_point('CAT_ADDED', $message, array (
      "id" => $id,
      "re_id" => $category_id,
      "clang" => $key,
      "name" => $category_name,
      "prior" => $Position_New_Category,
      "path" => $KATPATH,
      "status" => 0
    ));

  }

  rex_generateArticle($id);

}

// --------------------------------------------- ARTIKEL FUNKTIONEN

if ($function == "status_article" && $article_id != "" 
    && ($REX_USER->hasPerm("admin[]") || $KATPERM && $REX_USER->hasPerm("publishArticle[]")))
{
  // --------------------- ARTICLE STATUS
  $GA = new sql;
  $GA->setQuery("select * from ".$REX['TABLE_PREFIX']."article where id='$article_id' and clang=$clang");
  if ($GA->getRows() == 1)
  {
    if ($GA->getValue("status") == 1)
      $newstatus = 0;
    else
      $newstatus = 1;

    $EA = new sql;
    $EA->setTable($REX['TABLE_PREFIX']."article");
    $EA->where("id='$article_id' and clang=$clang");
    $EA->setValue("status", "$newstatus");
    $EA->setValue("updatedate", time());
    $EA->setValue("updateuser", $REX_USER->getValue("login"));
    $EA->update();

    $message = $I18N->msg("article_status_updated");
    rex_generateArticle($article_id);

    // ----- EXTENSION POINT
    $message = rex_register_extension_point('ART_STATUS', $message, array (
      "id" => $article_id,
      "clang" => $clang,
      "status" => $newstatus
    ));

  }
  else
  {
    $message = $I18N->msg("no_such_category");
  }

}
elseif (!empty($artadd_function) && $category_id != '' && $KATPERM)
{
  // --------------------- ARTIKEL ADD
  $Position_New_Article = (int) $Position_New_Article;
  if ($Position_New_Article == 0)
    $Position_New_Article = 1;
    
  // ------- Kategorienamen holen
  $sql = new sql();
  $sql->setQuery('SELECT catname FROM '.$REX['TABLE_PREFIX'].'article WHERE id='. $category_id .' and startpage=1 and clang='. $clang);
  
  $category_name = '';
  if($sql->getRows() == 1)
  {
    $category_name = $sql->getValue('catname');
  }

  $amessage = $I18N->msg("article_added");

  unset ($id);
  reset($REX['CLANG']);
  while (list ($key, $val) = each($REX['CLANG']))
  {

    // ### erstelle neue prioliste wenn noetig

    $AART = new sql;
    // $AART->debugsql = 1;
    $AART->setTable($REX['TABLE_PREFIX']."article");
    if (!isset ($id) or !$id)
      $id = $AART->setNewId("id");
    else
      $AART->setValue("id", $id);
    $AART->setValue("name", $article_name);
    $AART->setValue("catname", $category_name);
    $AART->setValue("clang", $key);
    $AART->setValue("re_id", $category_id);
    $AART->setValue("prior", $Position_New_Article);
    $AART->setValue("path", $KATPATH);
    $AART->setValue("startpage", 0);
    $AART->setValue("status", 0);
    $AART->setValue("online_from", time());
    $AART->setValue("online_to", mktime(0, 0, 0, 1, 1, 2010));
    $AART->setValue("createdate", time());
    $AART->setValue("createuser", $REX_USER->getValue("login"));
    $AART->setValue("updatedate", time());
    $AART->setValue("updateuser", $REX_USER->getValue("login"));
    $AART->setValue("template_id", $template_id);
    $AART->insert();

    // ----- PRIOR
    rex_newArtPrio($category_id, $key, 0, $Position_New_Article);
  }

  rex_generateArticle($id);

  // ----- EXTENSION POINT
  $amessage = rex_register_extension_point('ART_ADDED', $amessage, array (
    "id" => $id,
    "status" => 0,
    "name" => $article_name,
    "re_id" => $category_id,
    "prior" => $Position_New_Article,
    "path" => $KATPATH,
    "template_id" => $template_id
  ));

}
elseif (!empty($artedit_function) && $article_id != '' && $KATPERM)
{
  // --------------------- ARTIKEL EDIT
  $Position_Article = (int) $Position_Article;
  if ($Position_Article == 0)
    $Position_Article = 1;

  $amessage = $I18N->msg("article_updated");
  $EA = new sql;
  $EA->setTable($REX['TABLE_PREFIX']."article");
  $EA->where("id='$article_id' and clang=$clang");
  $EA->setValue("name", $article_name);
  $EA->setValue("template_id", $template_id);
  // $EA->setValue("path",$KATPATH);
  $EA->setValue("updatedate", time());
  $EA->setValue("updateuser", $REX_USER->getValue("login"));
  $EA->setValue("prior", $Position_Article);
  $EA->update();

  // ----- PRIOR
  rex_newArtPrio($category_id, $clang, $Position_Article, $thisArt->getValue("prior"));
  rex_generateArticle($article_id);

  // ----- EXTENSION POINT
  $amessage = rex_register_extension_point('ART_UPDATED', $amessage, array (
    "id" => $article_id,
    "status" => $thisArt->getValue("status"
  ), "name" => $article_name, "re_id" => $category_id, "prior" => $Position_Article, "path" => $KATPATH, "template_id" => $template_id));

}
elseif ($function == 'artdelete_function' && $article_id != '' && $KATPERM)
{
  // --------------------- ARTIKEL DELETE

  $message = rex_deleteArticle($article_id);
  $re_id = $thisArt->getValue("re_id");

  // ----- PRIO
  $CL = $REX['CLANG'];
  reset($CL);
  for ($j = 0; $j < count($CL); $j++)
  {
    $mlang = key($CL);
    rex_newArtPrio($thisArt->getValue("re_id"), $mlang, 0, 1);
    next($CL);
  }

  // ----- EXTENSION POINT
  $message = rex_register_extension_point('ART_DELETED', $message, array (
    "id" => $article_id,
    "re_id" => $re_id
  ));

}

// --------------------------------------------- KATEGORIE LISTE

if (isset ($message) and $message != "")
  echo '<p class="rex-warning">'. $message .'</p>';
  
$cat_name = 'Homepage';
if($category_id != '')
{
  $sql = new sql();
//  $sql->debugsql = true;
  $sql->setQuery('SELECT catname FROM '. $REX['TABLE_PREFIX'] .'article WHERE id='. $category_id .' AND clang='. $clang .' AND startpage=1');
  
  if($sql->getRows() == 1)
  {
    $cat_name = $sql->getValue('catname');
  }
}
  
$add_category = '';
if ($KATPERM && !$REX_USER->hasPerm("editContentOnly[]"))
{
  $add_category = '<a href="index.php?page=structure&amp;category_id='.$category_id.'&amp;function=add_cat&amp;clang='.$clang.'"><img src="pics/folder_plus.gif" width="16" height="16" alt="'.$I18N->msg("add_category").'" title="'.$I18N->msg("add_category").'" /></a>';
}

$add_header = '';
$add_col = '';
$data_colspan = 4;
if ($REX_USER->hasPerm('advancedMode[]'))
{
  $add_header = '<th>'.$I18N->msg('header_id').'</th>';
  $add_col = '<col width="5%" />';
  $data_colspan = 5;
}

echo '
<!-- *** OUTPUT CATEGORIES - START *** -->';

if($function == 'add_cat' || $function == 'edit_cat')
{
  echo '
  <form action="index.php" method="post">
    <fieldset>
      <legend><span class="rex-hide">'.$I18N->msg('add_category') .'</span></legend>
      <input type="hidden" name="page" value="structure" />
      <input type="hidden" name="edit_id" value="'. $edit_id .'" />
      <input type="hidden" name="category_id" value="'. $category_id .'" />
      <input type="hidden" name="clang" value="'. $clang .'" />';
}

echo '
      <table class="rex-table" summary="'. $I18N->msg('structure_categories_summary', $cat_name) .'">
        <caption>'.$I18N->msg('structure_categories_caption', $cat_name).'</caption>
        <colgroup>
          <col width="5%" />
          '. $add_col .'
          <col width="*" />
          <col width="7%" />
          <col width="40%" />
          <col width="20%" />
        </colgroup>
        <thead>
          <tr>
            <th>'. $add_category .'</th>
            '. $add_header .'
            <th>'.$I18N->msg('header_category').'</th>
            <th>'.$I18N->msg('header_priority').'</th>
            <th>'.$I18N->msg('header_edit_category').'</th>
            <th>'.$I18N->msg('header_status').'</th>
          </tr>
        </thead>
        <tbody>';

if ($category_id != 0)
{
  echo '<tr>
          <td></td>
          <td colspan="'. $data_colspan .'">..</td>
        </tr>';
}

// --------------------- KATEGORIE ADD FORM

if ($function == 'add_cat' && $KATPERM && !$REX_USER->hasPerm('editContentOnly[]'))
{
  $add_td = '';
  if ($REX_USER->hasPerm('advancedMode[]'))
  {
    $add_td = '<td>-</td>';
  }
  echo '
        <tr class="rex-trow-actv">
          <td><img src="pics/folder.gif" width="16px" height="16px" title="'. $I18N->msg('add_category') .'" alt="'. $I18N->msg('add_category') .'" /></td>
          '. $add_td .'
          <td><input type="text" id="category_name" name="category_name" /></td>
          <td><input type="text" id="Position_New_Category" name="Position_New_Category" value="100" /></td>
          <td colspan="2"><input type="submit" class="rex-fsubmit" name="catadd_function" value="'. $I18N->msg('add_category') .'" /></td>
        </tr>';
}

// --------------------- KATEGORIE LIST

$KAT = new sql;
//$KAT->debugsql = true;
$KAT->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'article WHERE re_id='. $category_id .' AND startpage=1 AND clang='. $clang .' ORDER BY catprior');

for ($i = 0; $i < $KAT->getRows(); $i++)
{
  $i_category_id = $KAT->getValue('id');
  $kat_link = 'index.php?page=structure&amp;category_id='. $i_category_id .'&amp;clang='. $clang;
  $kat_icon_td = '<td><a href='. $kat_link .'><img src="pics/folder.gif" width="16" height="16" alt="'. htmlspecialchars($KAT->getValue("catname")). '" title="'. htmlspecialchars($KAT->getValue("catname")). '"/></a></td>';
    
  if ($KATPERM)
  {
    if ($KAT->getValue('status') == 0)
    {
      $status_class = 'rex-offline';
      $kat_status = $I18N->msg('status_offline');
    }
    else
    {
      $status_class = 'rex-online';
      $kat_status = $I18N->msg('status_online');
    }

    if ($REX_USER->hasPerm('admin[]') || $KATPERM && $REX_USER->hasPerm('publishCategory[]'))
    {
      $kat_status = '<a href="index.php?page=structure&amp;category_id='. $category_id .'&amp;edit_id='. $i_category_id .'&amp;function=status&amp;clang='. $clang .'" class="'. $status_class .'">'. $kat_status .'</a>';
    }

    if (isset ($edit_id) and $edit_id == $i_category_id and $function == 'edit_cat')
    {
      // --------------------- KATEGORIE EDIT FORM
      
      $add_td = '';
      if ($REX_USER->hasPerm("advancedMode[]"))
      {
        $add_td = '<td>'. $i_category_id .'</td>';
      }
      
      $add_buttons = '<input type="submit" class="rex-fsubmit" name="catedit_function" value="'. $I18N->msg('edit_category'). '" />';
      if (!$REX_USER->hasPerm("editContentOnly[]"))
      {
        $add_buttons .= '<input type="submit" class="rex-fsubmit" name="catdelete_function" value="'. $I18N->msg('delete_category'). '" onclick="return confirm(\''. $I18N->msg('delete') .' ?\')" />';
      }
      
      echo '
        <tr class="rex-trow-actv">
          '. $kat_icon_td .'
          '. $add_td .'
          <td><input type="text" id="kat_name" name="kat_name" value="'. htmlspecialchars($KAT->getValue("catname")). '" /></td>
          <td><input type="text" id="Position_Category" name="Position_Category" value="'. htmlspecialchars($KAT->getValue("catprior")) .'" /></td>
          <td>'. $add_buttons .'</td>
          <td>'. $kat_status .'</td>
        </tr>';
    }
    else
    {
      // --------------------- KATEGORIE WITH WRITE
      
      $add_td = '';
      if ($REX_USER->hasPerm("advancedMode[]"))
      {
        $add_td = '<td>'. $i_category_id .'</td>';
      }

      $add_text = $I18N->msg("category_edit_delete");
      if ($REX_USER->hasPerm("editContentOnly[]")) 
      {
        $add_text = $I18N->msg('edit_category');
      }

      echo '
        <tr>
          '. $kat_icon_td .'
          '. $add_td .'
          <td><a href="'. $kat_link .'">'. $KAT->getValue("catname") .'</a></td>
          <td>'. htmlspecialchars($KAT->getValue("catprior")) .'</td>
          <td><a href="index.php?page=structure&amp;category_id='. $category_id .'&amp;edit_id='. $i_category_id .'&amp;function=edit_cat&amp;clang='. $clang .'">'. $add_text .'</a></td>
          <td>'. $kat_status .'</td>
        </tr>';
    }

  }
  elseif ($REX_USER->hasPerm("csr[$i_category_id]") || $REX_USER->hasPerm("csw[$i_category_id]"))
  {
      // --------------------- KATEGORIE WITH READ
      $add_td = '';
      if ($REX_USER->hasPerm("advancedMode[]"))
      {
        $add_td = '<td>'. $i_category_id .'</td>';
      }
      
      echo '
        <tr>
          '. $kat_icon_td .'
          '. $add_td .'
          <td><a href="'. $kat_link .'">'.$KAT->getValue("catname").'</a></td>
          <td>'.htmlspecialchars($KAT->getValue("catprior")).'</td>
          <td>'.$I18N->msg("no_permission_to_edit").'</td>
          <td>'. $kat_status .'</td>
        </tr>';
  }

  $KAT->next();
}

echo '
      </tbody>
    </table>';

if($function == 'add_cat' || $function == 'edit_cat')
{
  $fieldId = $function == 'add_cat' ? 'category_name' :  'kat_name';
  echo '
    <script type="text/javascript"> 
       <!-- 
       var needle = new getObj("'. $fieldId .'");
       needle.obj.focus();
       //--> 
    </script>
  </fieldset>
</form>';
}

echo '
<!-- *** OUTPUT CATEGORIES - END *** -->
';


// --------------------------------------------- ARTIKEL LISTE

echo '
<!-- *** OUTPUT ARTICLES - START *** -->';

// --------------------- READ TEMPLATES

if ($category_id > -1)
{
  $TEMPLATES = new sql;
  $TEMPLATES->setQuery("select * from ".$REX['TABLE_PREFIX']."template order by name");
  $TMPL_SEL = new select;
  $TMPL_SEL->set_name("template_id");
  $TMPL_SEL->set_id("template_id");
  $TMPL_SEL->set_size(1);
  $TMPL_SEL->add_option($I18N->msg("option_no_template"), "0");

  for ($i = 0; $i < $TEMPLATES->getRows(); $i++)
  {
    if ($TEMPLATES->getValue("active") == 1)
    {
      $TMPL_SEL->add_option($TEMPLATES->getValue("name"), $TEMPLATES->getValue("id"));
    }
    $TEMPLATE_NAME[$TEMPLATES->getValue("id")] = $TEMPLATES->getValue("name");
    $TEMPLATES->nextValue();
  }
  $TEMPLATE_NAME[0] = $I18N->msg("template_default_name");

  // --------------------- ARTIKEL LIST

  if (isset ($amessage) and $amessage != "")
  {
    echo '<p class="rex-warning">'. $amessage .'</p>';
  }
  
  $art_add_link = '';
  if ($KATPERM)
  {
    $art_add_link = '<a href="index.php?page=structure&amp;category_id='. $category_id .'&amp;function=add_art&amp;clang='. $clang .'"><img src="pics/document_plus.gif" width="16" height="16" alt="'. $I18N->msg('article_add') .'" title="' .$I18N->msg('article_add') .'" /></a>';
  }
    
  $add_head = '';
  $add_col  = '';
  if ($REX_USER->hasPerm('advancedMode[]'))
  {
    $add_head = '<th>'. $I18N->msg('header_id') .'</th>';
    $add_col  = '<col width="5%" />';
  }
  
  if($function == 'add_art' || $function == 'edit_art')
  {
    echo '
    <form action="index.php" method="post">
      <fieldset>
        <legend><span class="rex-hide">'.$I18N->msg('article_add') .'</span></legend>
        <input type="hidden" name="page" value="structure" />
        <input type="hidden" name="category_id" value="'. $category_id .'" />
        <input type="hidden" name="article_id" value="'. $article_id .'" />
        <input type="hidden" name="clang" value="'. $clang .'" />';
  }
  
  echo '  
      <table class="rex-table" summary="'. $I18N->msg('structure_articles_summary', $cat_name) .'">
        <caption>'.$I18N->msg('structure_articles_caption', $cat_name).'</caption>
        <colgroup>
          <col width="5%" />
          '. $add_col .'
          <col width="*" />
          <col width="7%" />
          <col width="40%" />
          <col width="20%" />
          <col width="10%" span="3"/>
        </colgroup>
        <thead>
          <tr>
            <th>'. $art_add_link .'</th>
            '. $add_head .'
            <th>'.$I18N->msg('header_article_name').'</th>
            <th>'.$I18N->msg('header_priority').'</th>
            <th>'.$I18N->msg('header_template').'</th>
            <th>'.$I18N->msg('header_date').'</th>
            <th>'.$I18N->msg('header_article_type').'</th>
            <th colspan="3">'.$I18N->msg('header_status').'</th>
          </tr>
        </thead>
        <tbody>
        ';


  // --------------------- ARTIKEL ADD FORM

  if ($function == 'add_art' && $KATPERM)
  {
    if (empty($template_id))
    {
      $sql = new sql;
      // $sql->debugsql = true;
      $sql->setQuery('SELECT template_id FROM '.$REX['TABLE_PREFIX'].'article WHERE id='. $category_id .' AND clang='. $clang .' AND startpage=1');
      if ($sql->getRows() == 1)
      {
        $TMPL_SEL->set_selected($sql->getValue('template_id'));
      }
    }
    
    $add_td = '';
    if ($REX_USER->hasPerm('advancedMode[]'))
    {
      $add_td = '<td>-</td>';
    }
    
    echo '<tr>
            <td><img src="pics/document.gif" width="16" height="16" alt="'.$I18N->msg('article_add') .'" title="'.$I18N->msg('article_add') .'" /></td>
            '. $add_td .'
            <td><input type="text" id="article_name" name="article_name" /></td>
            <td><input type="text" id="Position_New_Article" name="Position_New_Article" value="100" /></td>
            <td>'. $TMPL_SEL->out() .'</td>
            <td>'. strftime($I18N->msg("adateformat")) .'</td>
            <td>'. $I18N->msg("article") .'</td>
            <td colspan="3"><input type="submit" class="rex-fsubmit" name="artadd_function" value="'.$I18N->msg('article_add') .'" /></td>
          </tr>';
  }

  // --------------------- ARTIKEL LIST

  $sql = new sql;
//  $sql->debugsql = true;
  $sql->setQuery('SELECT * 
        FROM 
          '.$REX['TABLE_PREFIX'].'article 
        WHERE 
          ((re_id='. $category_id .' AND startpage=0) OR (id='. $category_id .' AND startpage=1)) 
          AND clang='. $clang .'  
        ORDER BY 
          prior, name');

  for ($i = 0; $i < $sql->getRows(); $i++)
  {

    if ($sql->getValue('startpage') == 1)
    {
      $startpage = $I18N->msg('start_article');
      $icon = 'liste.gif';
    }
    else
    {
      $startpage = $I18N->msg('article');
      $icon = 'document.gif';
    }

    // --------------------- ARTIKEL EDIT FORM

    if ($function == 'edit_art' && isset ($article_id) && $sql->getValue('id') == $article_id && $KATPERM)
    {
      $add_td = '';
      if ($REX_USER->hasPerm("advancedMode[]"))
      {
        $add_td = '<td>'. $sql->getValue("id") .'</td>';
      }
      
      $TMPL_SEL->set_selected($sql->getValue('template_id'));
      
      echo '<tr>
              <td><a href="index.php?page=content&amp;article_id='. $sql->getValue('id') .'&amp;category_id='. $category_id .'&amp;clang='. $clang .'"><img src="pics/'. $icon .'" width="16" height="16" alt="' .htmlspecialchars($sql->getValue("name")).'" title="' .htmlspecialchars($sql->getValue("name")).'" /></a></td>
              '. $add_td .'
              <td><input type="text" id="article_name" name="article_name" value="' .htmlspecialchars($sql->getValue('name')).'" /></td>
              <td><input type="text" id="Position_Article" name="Position_Article" value="'. htmlspecialchars($sql->getValue('prior')).'" /></td>
              <td>'. $TMPL_SEL->out() .'</td>
              <td>'. strftime($I18N->msg('adateformat'), $sql->getValue('createdate')) .'</td>
              <td>'. $startpage .'</td>
              <td colspan="3"><input type="submit" class="rex-fsubmit" name="artedit_function" value="'. $I18N->msg('edit_article') .'" /></td>
            </tr>';

    }
    elseif ($KATPERM)
    {
      // --------------------- ARTIKEL NORMAL VIEW | EDIT AND ENTER
      
      $add_td = '';
      if ($REX_USER->hasPerm('advancedMode[]'))
      {
        $add_td = '<td>'. $sql->getValue('id') .'</td>';
      }
  
      $add_extra = '';
      if ($sql->getValue('startpage') == 1)
      {
        $add_extra = '<td><span class="rex-strike">'. $I18N->msg('delete') .'</span></td>
                      <td class="rex-online"><span class="rex-strike">online</span></td>';
      }
      else
      {
        $article_class = '';
        if ($sql->getValue('status') == 0)
        {
          $article_status = $I18N->msg('status_offline');
          $article_class = 'rex-offline';
        }
        elseif ($sql->getValue('status') == 1)
        {
          $article_status = $I18N->msg('status_online');
          $article_class = 'rex-online';
        }
        
        if ($REX_USER->hasPerm('admin[]') || $KATPERM && $REX_USER->hasPerm('publishArticle[]'))
        {
            $article_status = '<a href="index.php?page=structure&amp;article_id='. $sql->getValue('id') .'&amp;function=status_article&amp;category_id='. $category_id .'&amp;clang='. $clang .'" class="'. $article_class .'">'. $article_status .'</a>';
        }
        
        $add_extra = '<td><a href="index.php?page=structure&amp;article_id='. $sql->getValue('id') .'&amp;function=artdelete_function&amp;category_id='. $category_id .'&amp;clang='.$clang .'" onclick="return confirm(\''.$I18N->msg('delete').' ?\')">'.$I18N->msg('delete').'</a></td>
                      <td>'. $article_status .'</td>';
      }

      echo '<tr>
              <td><a href="index.php?page=content&amp;article_id='. $sql->getValue('id') .'&amp;category_id='. $category_id .'&amp;mode=edit&amp;clang='. $clang .'"><img src="pics/'. $icon .'" width="16" height="16" alt="' .htmlspecialchars($sql->getValue('name')).'" title="' .htmlspecialchars($sql->getValue('name')).'" /></a></td>
              '. $add_td .'
              <td><a href="index.php?page=content&amp;article_id='. $sql->getValue('id') .'&amp;category_id='. $category_id .'&amp;mode=edit&amp;clang='. $clang .'">'. $sql->getValue('name'). '</a></td>
              <td>'. htmlspecialchars($sql->getValue('prior')) .'</td>
              <td>'. $TEMPLATE_NAME[$sql->getValue('template_id')] .'</td>
              <td>'. strftime($I18N->msg('adateformat'), $sql->getValue('createdate')) .'</td>
              <td>'. $startpage .'</td>
              <td><a href="index.php?page=structure&amp;article_id='. $sql->getValue('id') .'&amp;function=edit_art&amp;category_id='. $category_id.'&amp;clang='. $clang .'">'. $I18N->msg('change') .'</a></td>
              '. $add_extra .'
            </tr>';

    }
    else
    {
      // --------------------- ARTIKEL NORMAL VIEW | NO EDIT NO ENTER

      $add_td = '';
      if ($REX_USER->hasPerm('advancedMode[]'))
      {
        $add_td = '<td>'. $sql->getValue('id') .'</td>';
      }

      $art_status       = '';
      $art_status_class = '';        
      if ($sql->getValue('status') == 0)
      {
        $art_status = $I18N->msg('status_offline');
        $art_status_class = 'rex-offline';        
      }
      else
      {
        $art_status = $I18N->msg('status_online');
        $art_status_class = 'rex-online';        
      }
      echo '<tr>
              <td><img src="pics/'. $icon .'" width="16" height="16" alt="' .htmlspecialchars($sql->getValue('name')).'" title="' .htmlspecialchars($sql->getValue('name')).'" /></td>
              '. $add_td .'
              <td>'. htmlspecialchars($sql->getValue('name')).'</td>
              <td>'. htmlspecialchars($sql->getValue('prior')).'</td>
              <td>'. $TEMPLATE_NAME[$sql->getValue('template_id')].'</td>
              <td>'. strftime($I18N->msg('adateformat'), $sql->getValue('createdate')).'</td>
              <td>'. $startpage .'</td>
              <td><span class="rex-strike">'.$I18N->msg('change').'</span></td>
              <td><span class="rex-strike">'.$I18N->msg('delete').'</span></td>
              <td class="'. $art_status_class .'"><span class="rex- ">'. $art_status .'</span></td>
            </tr>';
    }
    
    $sql->counter++;
  }
  echo '
        </tbody>
      </table>';
  
  if($function == 'add_art' || $function == 'edit_art')
  {
    echo '
      <script type="text/javascript"> 
         <!-- 
         var needle = new getObj("article_name");
         needle.obj.focus();
         //--> 
      </script>
    </fieldset>
  </form>';
  }
}


echo '
<!-- *** OUTPUT ARTICLES - END *** -->
';
?>