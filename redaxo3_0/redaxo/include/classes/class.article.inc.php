<?php

/**
 * Artikel Objekt. Zust�ndig f�r die Ausgabe eines Artikel mit/ohne Template
 * @package redaxo3
 * @version $Id: class.article.inc.php,v 1.58 2006/07/03 12:20:38 kills Exp $
 */

class article
{

  var $slice_id;
  var $article_id;
  var $mode;
  var $article_content;
  var $function;
  var $eval;
  var $category_id;
  var $CONT;
  var $template_id;
  var $ViewSliceId;
  var $contents;
  var $setanker;
  var $save;
  var $ctype;
  var $clang;
  var $getSlice;

  // ----- Konstruktor
  function article( $article_id = null)
  {
    $this->article_id = 0;
    $this->template_id = 0;
    $this->clang = 0;
    $this->ctype = -1; // zeigt alles an
    $this->slice_id = 0;
    $this->mode = "view";
    $this->article_content = "";
    $this->eval = FALSE;
    $this->setanker = true;


    // AUSNAHME: modul ausw�hlen problem
    // action=index.php#1212 problem
    if (strpos($_SERVER["HTTP_USER_AGENT"],"Mac") and strpos($_SERVER["HTTP_USER_AGENT"],"MSIE") ) $this->setanker = FALSE;

    if ( $article_id !== null) {
      $this->setArticleId( $article_id);
    }
  }

  // ----- Slice Id setzen f�r Editiermodus
  function setSliceId($value)
  {
    $this->slice_id = $value;
  }

  function setCLang($value)
  {
    global $REX;
    if ($REX['CLANG'][$value] == "") $value = 0;
    $this->clang = $value;
  }

  function setArticleId($article_id)
  {
    global $REX;

    $article_id = (int) $article_id;
    $this->article_id = (int) $article_id;

    if (!$REX['GG'])
    {

      // ---------- select article
      $this->ARTICLE = new sql;
      // $this->ARTICLE->debugsql = 1;
      $this->ARTICLE->setQuery("select * from ".$REX['TABLE_PREFIX']."article where ".$REX['TABLE_PREFIX']."article.id='$article_id' and clang='".$this->clang."'");

      if ($this->ARTICLE->getRows() == 1)
      {
        $this->template_id = $this->ARTICLE->getValue($REX['TABLE_PREFIX']."article.template_id");
        $this->category_id = $this->getValue("category_id");
        return TRUE;
      }else
      {
        $this->article_id = 0;
        $this->template_id = 0;
        $this->category_id = 0;
        return FALSE;
      }
    }else
    {
      if (@include $REX['INCLUDE_PATH']."/generated/articles/".$article_id.".".$this->clang.".article")
      {
        $this->category_id = $REX['ART'][$article_id]['re_id'][$this->clang];
        $this->template_id = $REX['ART'][$article_id]['template_id'][$this->clang];
        return TRUE;
      }else
      {
        return FALSE;
      }
    }
  }

  function setTemplateId($template_id)
  {
    $this->template_id = $template_id;
  }

  function getTemplateId()
  {
    return $this->template_id;
  }

  function setMode($mode)
  {
    $this->mode = $mode;
  }

  function setFunction($function)
  {
    $this->function = $function;
  }

  function setEval($value)
  {
    if ($value) $this->eval = TRUE;
    else $this->eval = FALSE;
  }

  function getValue($value)
  {
    global $REX;

    if ($value == "category_id")
    {
      if ($this->getValue("startpage")!=1) $value = "re_id";
      else if($REX['GG']) $value = "article_id";
      else $value = "id";
    }

    if ($REX['GG']) return $REX['ART'][$this->article_id][$value][$this->clang];
    else return $this->ARTICLE->getValue($value);
  }

  // ----- 
  function getArticle($curctype = -1)
  {
    global $module_id,$FORM,$REX_USER,$REX,$REX_SESSION,$REX_ACTION,$I18N;

    $this->ctype = $curctype;

    $sliceLimit = '';
    if ($this->getSlice){
      //$REX['GG'] = 0;
      $sliceLimit = " and ".$REX['TABLE_PREFIX']."article_slice.id = '" . $this->getSlice . "' ";
    }
    
    // ----- start: article caching
    ob_start();

    if ($REX['GG'] && !$this->getSlice)
    {
      if ($this->article_id != 0)
      {
        $this->contents = "";
        $filename = $REX['INCLUDE_PATH']."/generated/articles/".$this->article_id.".".$this->clang.".content";
        if ($fd = @fopen ($filename, "r"))
        {
          $this->contents = fread ($fd, filesize ($filename));
          fclose ($fd);
          eval($this->contents);
        }
      }
    }else
    {
      if ($this->article_id != 0)
      {
        // ---------- alle teile/slices eines artikels auswaehlen
        $sql = "select ".$REX['TABLE_PREFIX']."modultyp.id, ".$REX['TABLE_PREFIX']."modultyp.name, ".$REX['TABLE_PREFIX']."modultyp.ausgabe, ".$REX['TABLE_PREFIX']."modultyp.eingabe, ".$REX['TABLE_PREFIX']."modultyp.php_enable, ".$REX['TABLE_PREFIX']."modultyp.html_enable, ".$REX['TABLE_PREFIX']."article_slice.*, ".$REX['TABLE_PREFIX']."article.re_id
          from
            ".$REX['TABLE_PREFIX']."article_slice
          left join ".$REX['TABLE_PREFIX']."modultyp on ".$REX['TABLE_PREFIX']."article_slice.modultyp_id=".$REX['TABLE_PREFIX']."modultyp.id
          left join ".$REX['TABLE_PREFIX']."article on ".$REX['TABLE_PREFIX']."article_slice.article_id=".$REX['TABLE_PREFIX']."article.id
          where
            ".$REX['TABLE_PREFIX']."article_slice.article_id='".$this->article_id."' and
            ".$REX['TABLE_PREFIX']."article_slice.clang='".$this->clang."' and
            ".$REX['TABLE_PREFIX']."article.clang='".$this->clang."'";
        $sql .= $sliceLimit;
        $sql .= "order by
            ".$REX['TABLE_PREFIX']."article_slice.re_article_slice_id";

        $this->CONT = new sql;
        $this->CONT->setQuery($sql);
        
        // ---------- SLICE IDS/MODUL SETZEN - speichern der daten
        for ($i=0;$i<$this->CONT->getRows();$i++)
        {
          $RE_CONTS[$this->CONT->getValue("re_article_slice_id")] = $this->CONT->getValue($REX['TABLE_PREFIX']."article_slice.id");
          $RE_CONTS_CTYPE[$this->CONT->getValue("re_article_slice_id")] = $this->CONT->getValue($REX['TABLE_PREFIX']."article_slice.ctype");
          $RE_MODUL_OUT[$this->CONT->getValue("re_article_slice_id")] = $this->CONT->getValue($REX['TABLE_PREFIX']."modultyp.ausgabe");
          $RE_MODUL_IN[$this->CONT->getValue("re_article_slice_id")] = $this->CONT->getValue($REX['TABLE_PREFIX']."modultyp.eingabe");
          $RE_MODUL_ID[$this->CONT->getValue("re_article_slice_id")] = $this->CONT->getValue($REX['TABLE_PREFIX']."modultyp.id");
          $RE_MODUL_NAME[$this->CONT->getValue("re_article_slice_id")] = $this->CONT->getValue($REX['TABLE_PREFIX']."modultyp.name");
          $RE_C[$this->CONT->getValue("re_article_slice_id")] = $i;
          $this->CONT->nextValue();
        }

        // ---------- moduleselect: nur module nehmen auf die der user rechte hat
        if($this->mode=="edit")
        {
          $MODULE = new sql;
          $MODULE->setQuery("select * from ".$REX['TABLE_PREFIX']."modultyp order by name");

          $MODULESELECT = new select;
          $MODULESELECT->set_name("module_id");
          $MODULESELECT->set_id("module_id");
          $MODULESELECT->set_size("1");
          $MODULESELECT->set_selectextra("onchange='this.form.submit();'");
          $MODULESELECT->add_option("----------------------------  ".$I18N->msg("add_block"),'');
  
          for ($i=0;$i<$MODULE->getRows();$i++)
          {
            if ($REX_USER->hasPerm("module[".$MODULE->getValue("id")."]") || $REX_USER->hasPerm("admin[]")) $MODULESELECT->add_option($MODULE->getValue("name"),$MODULE->getValue("id"));
            $MODULE->next();
          }
        }

        // ---------- SLICE IDS SORTIEREN UND AUSGEBEN
        $I_ID = 0;
        $PRE_ID = 0;
        $this->article_content = "";
        $this->CONT->resetCounter();

        for ($i=0;$i<$this->CONT->getRows();$i++)
        {

	      // ----- ctype unterscheidung
          if ($i==0 && $this->mode != "edit") $this->article_content = "<?php if (\$this->ctype == '".$RE_CONTS_CTYPE[$I_ID]."' || (\$this->ctype == '-1')) { ?>";

          // ------------- EINZELNER SLICE - AUSGABE
          $this->CONT->counter = $RE_C[$I_ID];
          $slice_content = "";
          $SLICE_SHOW = TRUE;

          if($this->mode=="edit")
          {
            $form_url = 'index.php';
            if ($this->setanker) $form_url .= '#addslice';

            $this->ViewSliceId = $RE_CONTS[$I_ID];

			// ----- BLOCKAUSWAHL - SELECT
            $amodule = '
            <form action="'. $form_url .'" method="get">
              <fieldset>
                <legend><span class="rex-hide">'. $I18N->msg("add_block") .'</span></legend>
                <input type="hidden" name="article_id" value="'. $this->article_id .'" />
                <input type="hidden" name="page" value="content" />
                <input type="hidden" name="mode" value="'. $this->mode .'" />
                <input type="hidden" name="slice_id" value="'. $I_ID .'" />
                <input type="hidden" name="function" value="add" />
                <input type="hidden" name="clang" value="'.$this->clang.'" />
                <input type="hidden" name="ctype" value="'.$this->ctype.'" />

                <p>
                  '. $MODULESELECT->out() .'
                  <noscript><input type="submit" class="rex-fsubmit" name="btn_add" value="'. $I18N->msg("add_block") .'" /></noscript>
                </p>

              </fieldset>
            </form>';

            // ----- add select box einbauen
            if($this->function=="add" && $this->slice_id == $I_ID)
            {
              $slice_content = $this->addSlice($I_ID,$module_id);
            }else
            {
              $slice_content .= $amodule;
            }

            // ----- EDIT/DELETE BLOCK - Wenn Rechte vorhanden
            if($REX_USER->hasPerm("module[".$RE_MODUL_ID[$I_ID]."]") || $REX_USER->hasPerm("admin[]"))
            {
              $mne = '
			       	<div class="rex-cnt-editmode-slc">
                <p class="rex-flLeft" id="slice'. $RE_CONTS[$I_ID] .'">'. $RE_MODUL_NAME[$I_ID] .'</p>
                <ul class="rex-flRight">
                  <li><a href="index.php?page=content&amp;article_id='. $this->article_id .'&amp;mode=edit&amp;slice_id='. $RE_CONTS[$I_ID] .'&amp;function=edit&amp;clang='. $this->clang .'&amp;ctype='. $this->ctype .'#slice'. $RE_CONTS[$I_ID] .'" class="rex-clr-grn">'. $I18N->msg('edit') .' <span class="rex-hide">'. $RE_MODUL_NAME[$I_ID] .'</span></a></li>
                  <li><a href="index.php?page=content&amp;article_id='. $this->article_id .'&amp;mode=edit&amp;slice_id='. $RE_CONTS[$I_ID] .'&amp;function=delete&amp;clang='. $this->clang .'&amp;ctype='. $this->ctype .'&amp;save=1#slice'. $RE_CONTS[$I_ID] .'" class="rex-clr-red" onclick="return confirm(\''.$I18N->msg('delete').' ?\')">'. $I18N->msg('delete') .' <span class="rex-hide">'. $RE_MODUL_NAME[$I_ID] .'</span></a></li>
              ';

              if ($REX_USER->hasPerm('moveSlice[]'))
              {
                $mne  .= '
                  <li><a href="index.php?page=content&amp;article_id='. $this->article_id .'&amp;mode=edit&amp;slice_id='. $RE_CONTS[$I_ID] .'&amp;function=moveup&amp;clang='. $this->clang .'&amp;ctype='. $this->ctype .'&amp;upd='. time() .'#slice'. $RE_CONTS[$I_ID] .'" class="green12b"><img src="pics/file_up.gif" width="16" height="16" alt="move up" title="move up" /> <span class="rex-hide">'. $RE_MODUL_NAME[$I_ID] .'</span></a></li>
                  <li><a href="index.php?page=content&amp;article_id='. $this->article_id .'&amp;mode=edit&amp;slice_id='. $RE_CONTS[$I_ID] .'&amp;function=movedown&amp;clang='. $this->clang .'&amp;ctype='. $this->ctype .'&amp;upd='. time() .'#slice'. $RE_CONTS[$I_ID] .'" class="green12b"><img src="pics/file_down.gif" width="16" height="16" alt="move down" title="move down" /> <span class="rex-hide">'. $RE_MODUL_NAME[$I_ID] .'</span></a></li>';
              }
              
              $mne .= '</ul></div>';

              $slice_content .= $mne;
              if($this->function=="edit" && $this->slice_id == $RE_CONTS[$I_ID])
              {
                $slice_content .= $this->editSlice($RE_CONTS[$I_ID],$RE_MODUL_IN[$I_ID],$RE_CONTS_CTYPE[$I_ID]);
              }else
              {
                $slice_content .= '
                <!-- *** OUTPUT OF MODULE-OUTPUT - START *** -->
                <div class="rex-cnt-moduleout">';
                
                $slice_content .= $RE_MODUL_OUT[$I_ID];
                
                $slice_content .= '
                </div>
                <!-- *** OUTPUT OF MODULE-OUTPUT - END *** -->
                ';
              }
              $slice_content = $this->sliceIn($slice_content);

            }else
            {
              // ----- hat keine rechte an diesem modul
              $mne = '
			  	<div class="rex-cnt-editmode-slc">
                <p class="rex-flLeft" id="slice'. $RE_CONTS[$I_ID] .'">'. $RE_MODUL_NAME[$I_ID] .'</p>
                <ul class="rex-flRight">
                  <li>'. $I18N->msg('no_editing_rights') .' <span class="rex-hide">'. $RE_MODUL_NAME[$I_ID] .'</span></li>
                </ul>
				  </div>';
                
              $slice_content .= $mne. $RE_MODUL_OUT[$I_ID];
              $slice_content = $this->sliceIn($slice_content);
            }

          }else
          {

            // ----- wenn mode nicht edit
            if($this->getSlice){
                while(list($k, $v) = each($RE_CONTS))
                  $I_ID = $k;
            }
            
            $slice_content .= $RE_MODUL_OUT[$I_ID];
            $slice_content = $this->sliceIn($slice_content);
          }
          // --------------- ENDE EINZELNER SLICE

          // ---------- slice in ausgabe speichern wenn ctype richtig
            if ($this->ctype == -1 or $this->ctype == $RE_CONTS_CTYPE[$I_ID])
            {
              $this->article_content .= $slice_content;
            }

          // ----- zwischenstand: ctype .. wenn ctype neu dann if
          if ($this->mode != "edit" && isset($RE_CONTS_CTYPE[$RE_CONTS[$I_ID]]) && $RE_CONTS_CTYPE[$I_ID] != $RE_CONTS_CTYPE[$RE_CONTS[$I_ID]] && $RE_CONTS_CTYPE[$RE_CONTS[$I_ID]] != "")
          {
            $this->article_content .= "<?php } if(\$this->ctype == '".$RE_CONTS_CTYPE[$RE_CONTS[$I_ID]]."' || \$this->ctype == '-1'){ ?>";
          }

          // zum nachsten slice
          $I_ID = $RE_CONTS[$I_ID];
          $PRE_ID = $I_ID;

        }

        // ----- end: ctype unterscheidung
        if ($this->mode != "edit" && $i>0) $this->article_content .= "<?php } ?>";

        // ----- add module im edit mode
        if ($this->mode == "edit")
        {
          $form_url = 'index.php';
          if ($this->setanker) $form_url .= '#addslice';
          
          $amodule = '
            <form action="'. $form_url .'" method="get">
              <fieldset>
                <legend><span class="rex-hide">'. $I18N->msg("add_block") .'</span></legend>
                <input type="hidden" name="article_id" value="'. $this->article_id .'" />
                <input type="hidden" name="page" value="content" />
                <input type="hidden" name="mode" value="'. $this->mode .'" />
                <input type="hidden" name="slice_id" value="'. $I_ID .'" />
                <input type="hidden" name="function" value="add" />
                <input type="hidden" name="clang" value="'.$this->clang.'" />
                <input type="hidden" name="ctype" value="'.$this->ctype.'" />

                <p>
                  '. $MODULESELECT->out() .'
                  <noscript><input type="submit" class="rex-fsubmit" name="btn_add" value="'. $I18N->msg("add_block") .'" /></noscript>
                </p>

              </fieldset>
            </form>
          ';

          if($this->function=="add" && $this->slice_id == $I_ID)
          {
            $slice_content = $this->addSlice($I_ID,$module_id);
          }else
          {
            $slice_content = $amodule;
          }
          $this->article_content .= $slice_content;
        }

        // -------------------------- schreibe content
        if ($this->mode == "generate") echo $this->article_content;
        else eval("?>".$this->article_content);

      }else
      {
        echo $I18N->msg('no_article_available');
      }
    }

    // ----- end: article caching
    $CONTENT = ob_get_contents();
    ob_end_clean();

    return $CONTENT;
  }

  // ----- Template inklusive Artikel zur�ckgeben
  function getArticleTemplate()
  {
    global $FORM,$REX;
    ob_start();
    if ($this->getTemplateId() == 0 and $this->article_id != 0)
    {
      echo $this->getArticle();
    }elseif ($this->getTemplateId() != 0 and $this->article_id != 0)
    {
      $template_name = $REX['INCLUDE_PATH']."/generated/templates/".$this->getTemplateId().".template";
      if ($fd = fopen ($template_name, "r"))
      {
        $template_content = fread ($fd, filesize ($template_name));
        fclose ($fd);
      }else
      {
        $template_content = $this->getTemplateId()." not found";
      }
      $template_content = $this->replaceCommonVars( $template_content);
      $template_content = $this->replaceLinks($template_content);
      eval("?>".$template_content);
    }else
    {
      echo "no template";
    }
    $CONTENT = ob_get_contents();
    ob_end_clean();
    return $CONTENT;
  }

  // ----- ADD Slice
  function addSlice($I_ID,$module_id)
  {
    global $REX,$REX_ACTION,$FORM,$I18N;
    $MOD = new sql;
    $MOD->setQuery("select * from ".$REX['TABLE_PREFIX']."modultyp where id=$module_id");
    if ($MOD->getRows() != 1)
    {
      $slice_content = '<p class="rex-warning>'. $I18N->msg('module_doesnt_exist'). '</p>';
    }else
    {
      $slice_content = '
        <a name="addslice"></a>
        <form action="index.php#slice'. $I_ID .'" method="post" id="REX_FORM" enctype="multipart/form-data">
          <fieldset>
            <legend>'. $I18N->msg('add_block').'</legend>
            <input type="hidden" name="article_id" value="'. $this->article_id .'" />
            <input type="hidden" name="page" value="content" />
            <input type="hidden" name="mode" value="'. $this->mode .'" />
            <input type="hidden" name="slice_id" value="'. $I_ID .'" />
            <input type="hidden" name="function" value="add" />
            <input type="hidden" name="module_id" value="'. $module_id .'" />
            <input type="hidden" name="save" value="1" />
            <input type="hidden" name="clang" value="'. $this->clang .'" />
            <input type="hidden" name="ctype" value="'.$this->ctype .'" />
            <h2>'. $I18N->msg('add_block').'</h2>
            <p>
              Modul: '. $MOD->getValue("name") .'
            </p>
            <div class="rex-mdl-inp">
              '. $MOD->getValue("eingabe") .'
            </div>
            <p>
              <input type="submit" value="'. $I18N->msg('add_block') .'" />
            </p> 
          </fieldset>
        </form>
      ';

      $dummysql = new rex_dummy_sql();
      $dummysql->setValue($REX['TABLE_PREFIX'].'article_slice.clang',$this->clang);
      $dummysql->setValue($REX['TABLE_PREFIX'].'article_slice.ctype',$this->ctype);
      $dummysql->setValue($REX['TABLE_PREFIX'].'article_slice.modultyp_id',$module_id);
      $dummysql->setValue($REX['TABLE_PREFIX'].'article_slice.article_id',$this->article_id);
      
      $slice_content = $this->replaceVars($dummysql,$slice_content);
    }
    return $slice_content;
  }

  // ----- EDIT Slice
  function editSlice($RE_CONTS, $RE_MODUL_IN, $RE_CTYPE)
  {
    global $REX, $REX_ACTION, $FORM, $I18N;
    
    $slice_content = '
      <a name="editslice"></a>
      <form enctype="multipart/form-data" action="index.php#slice'.$RE_CONTS.'" method="post" id="REX_FORM">
        <fieldset>
          <legend>'. $I18N->msg('edit_block') .'</legend>
          <input type="hidden" name="article_id" value="'.$this->article_id.'" />
          <input type="hidden" name="page" value="content" />
          <input type="hidden" name="mode" value="'.$this->mode.'" />
          <input type="hidden" name="slice_id" value="'.$RE_CONTS.'" />
          <input type="hidden" name="ctype" value="'.$RE_CTYPE.'" />
          <input type="hidden" name="function" value="edit" />
          <input type="hidden" name="save" value="1" />
          <input type="hidden" name="update" value="0" />
          <input type="hidden" name="clang" value="'.$this->clang.'" />
          '.$RE_MODUL_IN.'
          <p>
            <input type="submit" value="'.$I18N->msg('save_block').'" />
            <input type="submit" value="'.$I18N->msg('update_block').'" onClick="REX_FORM.update.value=1" />
          </p>
        </fieldset>
      </form>';

    $slice_content = $this->sliceIn($slice_content);
    return $slice_content;
  }

  // ----- Modulvarianblen werden ersetzt
  function sliceIn($content)
  {
    $content = $this->replaceVars($this->CONT,$content);
    $content = $this->replaceLinks($content);
    $content = $this->replaceCommonVars($content);
    return $content;
  }

  // ----- REX_VAR Ersetzungen
  function replaceVars(&$sql,$content)
  {
  	global $REX;
    
    $tmp = '';
  	foreach($REX['VARIABLES'] as $key => $value)
  	{
  		$var = new $value();
  		if ($this->mode == 'edit')
  		{
  		  if (($this->function == 'add' && $sql->getValue($REX['TABLE_PREFIX'].'article_slice.id') == '') || ($this->function == 'edit' && $sql->getValue($REX['TABLE_PREFIX'].'article_slice.id') == $this->slice_id))
  		  {
  		  	$tmp = $var->getBEInput($sql,$content);
  		  }else
  		  {
  		  	$tmp = $var->getBEOutput($sql,$content);
  		  }
  		}else
      {
  			$tmp = $var->getFEOutput($sql,$content);
  		}
      
      // hier mit TMP Variable arbeiten, 
      // falls in einer der Vars kein RETURN Value gesetzt wurde,
      // damit nicht die Ausgabe davon besch�digt wird.
      if($tmp != '')
      {
        $content = $tmp;
      }
  	}
    
	  return $content;
  }

  function replaceCommonVars($content) {
    static $search = array(
       'REX_ARTICLE_ID',
       'REX_CATEGORY_ID',
       'REX_CLANG_ID',
       'REX_TEMPLATE_ID'
    );

    $replace = array(
      $this->article_id,
      $this->category_id,
      $this->clang,
      $this->getTemplateId()
    );
    return str_replace($search, $replace,$content);
  }

  function replaceLinks($content)
  {
      // -- preg match redaxo://[ARTICLEID] --
      preg_match_all("/redaxo:\/\/([0-9]*)\/?/im",$content,$matches);
      if ( isset ($matches[0][0]) and $matches[0][0] != ''){
          for ($m = 0; $m < count($matches[0]); $m++){
              $url = rex_getURL($matches[1][$m]);
              $content = str_replace($matches[0][$m],$url,$content);
          }
      }
  
      return $content;
  }

}

/**
 * @access private
 */
class rex_dummy_sql extends sql
{
	var $dummyvalues = array();
	function getValue($name)
	{
		if (isset($this->dummyvalues[$name])) return $this->dummyvalues[$name];
		return '';
	}
	
	function setValue($name,$value)
	{
		$this->dummyvalues[$name] = $value;
	}
}

?>