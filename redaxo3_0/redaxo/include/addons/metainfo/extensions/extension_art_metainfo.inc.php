<?php

/**
 * MetaForm Addon
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: extension_art_metainfo.inc.php,v 1.1 2007/02/23 13:14:45 kills Exp $
 */
 
rex_register_extension('ART_META_FORM', 'rex_a62_metainfo_form');

/**
 * Erweitert das Meta-Formular um die neuen Meta-Felder	
 */
function rex_a62_metainfo_form($params)
{
  global $article_id, $clang, $REX;
  
  $s = '';
  $debug = false;
  
  $fields = new rex_sql();
//  $fields->debugsql = true;
  $fields->setQuery('SELECT * FROM '. $REX['TABLE_PREFIX'] .'62_params p,'. $REX['TABLE_PREFIX'] .'62_type t WHERE `p`.`type` = `t`.`id` AND `p`.`name` LIKE "art_%"');
  
  $params = rex_a62_metainfo_handleSave($params, $fields);
  $article = $params['article'];
  
  for($i = 0; $i < $fields->getRows(); $i++)
  {
  	$name = $fields->getValue('name');
  	$label = htmlspecialchars($name);
  	$id = preg_replace('/[^a-zA-Z\-0-9_]/', '_', $label);
		$params = $fields->getValue('params');
		$attr = $fields->getValue('attributes');
		$dbvalues = explode('|+|', $article->getValue($name));
		$labelIt = true;
		
			
  	$field = '';
  	switch($fields->getValue('label'))
  	{
  		case 'text':
  		{
  			$field = '<input type="'. $fields->getValue('label') .'" name="'. $name .'" value="'. $dbvalues[0] .'" id="'. $id .'" '. $attr .' />';
  			break;
  		}
  		case 'checkbox':
  			$name .= '[]';
  		case 'radio':
  		{
  		  $labelIt = false;
  			$values = array();
  			if(strpos($params, '|') !== false)
  			{
  				$value_groups = explode('|', $params);
  				foreach($value_groups as $value_group)
  				{
  					if(strpos($value_group, ':') !== false)
  					{
  						$temp = explode(':', $value_group);
  						$values[$temp[0]] = $temp[1];
  					}
  					else
  					{
  						$values[$value_group] = $value_group;
  					}
  				}
  			}
  			else
  			{
  				$sql = new rex_sql();
  				$value_groups = $sql->getArray($params, MYSQL_NUM);
  				foreach($value_groups as $value_group)
  				{
  					if(isset($value_group[1]))
  					  $values[$value_group[1]] = $value_group[0];
  					else
  					  $values[$value_group[0]] = $value_group[0];
  				}
  			}
  			
  			$field .= '<span>'. $label .'</span>';
  			foreach($values as $key => $value)
  			{
  				$id = preg_replace('/[^a-zA-Z\-0-9_]/', '_', $id . $key);
  				
	  			$selected = '';
	  			if(in_array($value, $dbvalues))
	  				$selected = ' checked="checked"';
	  				
          $field .= '<label for="'. $id .'">'. htmlspecialchars($key) .'</label>';
	  			$field .= '<input type="'. $fields->getValue('label') .'" name="'. $name .'" value="'. $value .'" id="'. $id .'" '. $attr . $selected .' />'."\n";
	  			
  			}
  			break;
  		}
  		case 'select':
  		{
  			$select = new rex_select();
  			$select->setName($name);
  			$select->setId($id);
  			$select->setSelected($dbvalues);

  			foreach(explode(' ',$attr) as $pair)
  			{
  				$temp = explode('=', $attr);
  				$select->setAttribute($temp[0], str_replace(array('"', "'"),'',$temp[1]));
  				
  				if($temp[0] == 'multiple')
  				  $select->setName($name.'[]');
  			}

  			if(strpos($params, '|') !== false)
  			{
	  			$values = array();
  				$value_groups = explode('|', $params);
  				foreach($value_groups as $value_group)
  				{
  					if(strpos($value_group, ':') !== false)
  					{
  						$temp = explode(':', $value_group);
  						$values[$temp[0]] = $temp[1];
  					}
  					else
  					{
  						$values[$value_group] = $value_group;
  					}
  				}
  				$select->addOptions($values);
  			}
  			else
  			{
  				$select->addSqlOptions($params);
  			}
  			
  			
  			$field .= $select->get();
  			break;
  		}
  		case 'textarea':
  		{
  			$field = '<textarea name="'. $name .'" id="'. $id .'" '. $attr .' >'. $dbvalues[0] .'</textarea>';
  			break;
  		}
  		case 'REX_MEDIA_BUTTON':
  		case 'REX_MEDIALIST_BUTTON':
  		case 'REX_LINK_BUTTON':
  	}
  	
    $s .= '<p>'. "\n";
    
  	if($labelIt)
      $s .= '<label for="'. $id .'">'. $label .'</label>'. "\n";
      
    $s .= $field. "\n";
    $s .= '</p>'. "\n";
           
    $fields->next();
  }
  
  return $s;
}

function rex_a62_metainfo_handleSave($params, $fields)
{
	if($_SERVER['REQUEST_METHOD'] != 'POST') return $params;
	
	global $REX;
	
	$article = rex_sql::getInstance();
//	$article->debugsql = true;
	$article->setTable($REX['TABLE_PREFIX']. 'article');
	$article->setWhere('id='. $params['id'] .' AND clang='. $params['clang']);
	
	for($i = 0;$i < $fields->getRows(); $i++)
	{
		$fieldName = $fields->getValue('name');
		$postValue = rex_post($fieldName, 'array');
		$saveValue = implode('|+|', $postValue);
		
		// Wert in SQL zum speichern
		$article->setValue($fieldName, $saveValue);
		// Wert in das SQL Objekt speichern, dass zur Anzeige verwendet wird
		$params['article']->setValue($fieldName, $saveValue);
		
		$fields->next();
	}
	
	$article->update();
	
	return $params;
}
?>