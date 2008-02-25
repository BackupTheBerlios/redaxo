<?php

/**
 * Backend Search Addon
 *
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 *
 * @package redaxo4
 * @version $Id: extension_search_structure.inc.php,v 1.5 2008/02/24 16:17:31 kills Exp $
 */

function rex_a256_search_structure($params)
{
  global $REX, $REX_USER, $I18N_BE_SEARCH, $category_id, $clang;

  if(!($REX_USER->isAdmin() || $REX_USER->hasPerm('be_search[structure]')))
  {
    return $params['subject'];
  }

  $message = '';
  $search_result = '';
  $editUrl = 'index.php?page=content&article_id=%s&mode=edit&clang=%s';

  // ------------ Parameter
  $a256_article_id   = rex_post('a256_article_id'  , 'int');
  $a256_clang        = rex_post('a256_clang'       , 'int');
  $a256_article_name = rex_post('a256_article_name', 'string');

  // ------------ Suche via ArtikelId
  if($a256_article_id != 0)
  {
    $OOArt = OOArticle::getArticleById($a256_article_id, $a256_clang);
    if(OOArticle::isValid($OOArt))
    {
      header('Location:'. sprintf($editUrl, $a256_article_id, $a256_clang));
      exit();
    }
  }

  // ------------ Suche via ArtikelName
  if($a256_article_name != '')
  {
    $qry = '
    SELECT id
    FROM '. $REX['TABLE_PREFIX'] .'article
    WHERE
      clang = '. $a256_clang .' AND
      (
        name LIKE "%'. $a256_article_name .'%" OR
        catname LIKE "%'. $a256_article_name .'%"
      )';

    if($category_id != 0)
      $qry .= ' AND path LIKE "%|'. $category_id .'|%"';

    $search = new rex_sql();
//    $search->debugsql = true;
    $search->setQuery($qry);
    $foundRows = $search->getRows();

    // Suche ergab nur einen Treffer => Direkt auf den Treffer weiterleiten
    if($foundRows == 1)
    {
      header('Location:'. sprintf($editUrl, $search->getValue('re_id'), $a256_clang));
      exit();
    }
    // Mehrere Suchtreffer, Liste anzeigen
    else if($foundRows > 0)
    {
      $search_result .= '<ul>';
      for($i = 0; $i < $foundRows; $i++)
      {
        $OOArt = OOArticle::getArticleById($search->getValue('id'), $a256_clang);
        $label = $OOArt->getName();

        if($REX_USER->hasCategoryPerm($OOArt->getCategoryId()))
        {
          if($REX_USER->hasPerm('advancedMode[]'))
            $label .= ' ['. $search->getValue('id') .']';

          $search_result .= '<li><a href="'. sprintf($editUrl, $search->getValue('id'), $a256_clang) .'">'. $label .'</a></li>';
        }
        $search->next();
      }
      $search_result .= '</ul>';
    }
    else
    {
      $message = rex_warning($I18N_BE_SEARCH->msg('search_no_results'));
    }
  }

  $subject = $params['subject'];

  $category_select = new rex_category_select();
  $category_select->setName('category_id');
  $category_select->setId('rex-a256-category-id');
  $category_select->setSize('1');
  $category_select->setAttribute('onchange', 'this.form.submit();');
  $category_select->setSelected($category_id);

  $form =
   '  <form method="post">
        <input type="hidden" name="a256_clang" id="rex-a256-article-clang" value="'. $clang .'" />

		    <div class="rex-f-lft">
	        <label for="rex-a256-article-name">'. $I18N_BE_SEARCH->msg('search_article_name') .'</label>
    	    <input type="text" name="a256_article_name" id="rex-a256-article-name" />

        	<label for="rex-a256-article-id">'. $I18N_BE_SEARCH->msg('search_article_id') .'</label>
	        <input type="text" name="a256_article_id" id="rex-a256-article-id" />
    	    <input class="rex-sbmt" type="submit" name="" value="'. $I18N_BE_SEARCH->msg('search_start') .'" />
		    </div>

    		<div class="rex-f-rght">
    			<label for="rex-a256-category-id">'. $I18N_BE_SEARCH->msg('search_quick_navi') .'</label>
    			'. $category_select->get() . '
    			<noscript>
    			  <input type="submit" name="" value="'. $I18N_BE_SEARCH->msg('search_jump_to_category') .'" />
    			</noscript>
        </div>
      </form>';

  $search_bar = $message.
  '<div id="rex-a256-searchbar">
     '. $form .'
     '. $search_result .'
   </div>
   <div class="rex-clearer"></div>';

  return $search_bar . $subject;
}
?>