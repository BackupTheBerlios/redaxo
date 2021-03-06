<?php

/** 
 * Object Oriented Framework: Bildet eine Kategorie im Medienpool ab
 * @package redaxo3
 * @version $Id: class.oomediacategory.inc.php,v 1.1 2008/03/26 13:35:37 kills Exp $
 */

class OOMediaCategory
{
  // id
  var $_id = "";
  // re_id
  var $_parent_id = "";

  // name
  var $_name = "";
  // path
  var $_path = "";
  // hide
  var $_hide = "";

  // createdate
  var $_createdate = "";
  // updatedate
  var $_updatedate = "";

  // createuser
  var $_createuser = "";
  // updateuser
  var $_updateuser = "";

  // child categories
  var $_children = "";
  // files (media)
  var $_files = "";

  /**
  * @access protected
  */
  function OOMediaCategory($id = null)
  {
    $this->getCategoryById($id);
  }

  /**
   * @access protected
   */
  function _getTableName()
  {
    global $REX;
    return $REX['TABLE_PREFIX'].'file_category';
  }

  /**
   * @access public
   */
  function & getCategoryById($id)
  {
    $id = (int) $id;
    if (!is_numeric($id))
    {
      return null;
    }

    $query = 'SELECT * FROM '.OOMediaCategory :: _getTableName().' WHERE id = '.$id;

    $sql = new sql();
    //        $sql->debugsql = true;
    $result = $sql->get_array($query);
    $result = $result[0];

    if (count($result) == 0)
    {
      // Zuerst einer Variable zuweisen, da RETURN BY REFERENCE
      $return = null;
      return $return;
    }

    $cat = & new OOMediaCategory();

    $cat->_id = $result['id'];
    $cat->_parent_id = $result['re_id'];

    $cat->_name = $result['name'];
    $cat->_path = $result['path'];
    $cat->_hide = $result['hide'];

    $cat->_createdate = $result['createdate'];
    $cat->_updatedate = $result['updatedate'];

    $cat->_createuser = $result['createuser'];
    $cat->_updateuser = $result['updateuser'];

    $cat->_children = null;
    $cat->_files = null;

    return $cat;
  }

  /**
   * @access public
   */
  function & getRootCategories($ignore_offlines = true)
  {
    $qry = 'SELECT id FROM '.OOMediaCategory :: _getTableName().' WHERE re_id = 0 order by name';
    $sql = new sql();
    $sql->setQuery($qry);
    $result = $sql->get_array();

    $rootCats = array ();
    if (is_array($result))
    {
      foreach ($result as $line)
      {
        $rootCats[] = & OOMediaCategory :: getCategoryById($line['id']);
      }
    }

    return $rootCats;
  }

  function & searchCategoryByName($name)
  {
    return OOMediaCategory :: getCategoryByName($name);
  }
  /**
   * @access public
   */
  function & getCategoryByName($name)
  {
    $query = 'SELECT id FROM '.OOMediaCategory :: _getTableName().' WHERE name = "'.$name.'"';
    $sql = new sql();
    //$sql->debugsql = true;
    $result = $sql->get_array($query);

    $media = array ();
    if (is_array($result))
    {
      foreach ($result as $line)
      {
        $media[] = & OOMediaCategory :: getCategoryById($line['id']);
      }
    }

    return $media;
  } /**
            * @access public
            */
  function toString()
  {
    return 'OOMediaCategory, "'.$this->getId().'", "'.$this->getName().'"'."<br/>\n";
  } /**
            * @access public
            */
  function getId()
  {
    return $this->_id;
  } /**
            * @access public
            */
  function getName()
  {
    return $this->_name;
  } /**
            * @access public
            */
  function getPath()
  {
    return $this->_path;
  } /**
            * @access public
            */
  function getUpdateUser()
  {
    return $this->_updateuser;
  } /**
            * @access public
            */
  function getUpdateDate()
  {
    return $this->_updatedate;
  } /**
            * @access public
            */
  function getCreateUser()
  {
    return $this->_createuser;
  } /**
            * @access public
            */
  function getCreateDate()
  {
    return $this->_createdate;
  } /**
            * @access public
            */
  function getParentId()
  {
    return $this->_parent_id;
  } /**
            * @access public
            */
  function getParent()
  {
    return OOMediaCategory :: getCategoryById($this->getParentId());
  } /**
            * @access public
            */
  function getChildren()
  {
    if ($this->_children === null)
    {
      $this->_children = array ();
      $qry = 'SELECT id FROM '.OOMediaCategory :: _getTableName().' WHERE re_id = '.$this->getId().' ORDER BY name ';
      $sql = new sql();
      $sql->setQuery($qry);
      $result = $sql->get_array();
      if (is_array($result))
      {
        foreach ($result as $row)
        {
          $id = $row['id'];
          $this->_children[] = & OOMediaCategory :: getCategoryById($id);
        }
      }
    }

    return $this->_children;
  } /**
            * @access public
            */
  function countChildren()
  {
    return count($this->getChildren());
  } /**
            * @access public
            */
  function getFiles()
  {
    if ($this->_files === null)
    {
      $this->_files = array ();
      $qry = 'SELECT file_id FROM '.OOMedia :: _getTableName().' WHERE category_id = '.$this->getId();
      $sql = new sql();
      $sql->setQuery($qry);
      $result = $sql->get_array();
      if (is_array($result))
      {
        foreach ($result as $line)
        {
          $this->_files[] = & OOMedia :: getMediaById($line['file_id']);
        }
      }
    }

    return $this->_files;
  } /**
            * @access public
            */
  function countFiles()
  {
    return count($this->getFiles());
  } /**
            * @access public
            */
  function isHidden()
  {
    return $this->_hide;
  } /**
            * @access public
            */
  function isRootCategory()
  {
    return $this->hasParent() === false;
  } /**
            * @access public
            */
  function isParent($mediaCat)
  {
    if (is_int($mediaCat))
    {
      return $mediaCat == $this->getParentId();
    }
    elseif (OOMediaCategory :: isValid($mediaCat))
    {
      return $this->getParentId() == $mediaCat->getId();
    }
    return null;
  } /**
            * @access public
            */
  function isValid($mediaCat)
  {
    return is_object($mediaCat) && is_a($mediaCat, 'oomediacategory');
  } /**
            * @access public
            */
  function hasParent()
  {
    return $this->getParentId() != 0;
  } /**
            * @access public
            */
  function hasChildren()
  {
    return count($this->getChildren()) > 0;
  } /**
            * @access public
            */
  function hasFiles()
  {
    return count($this->getFiles()) > 0;
  } /**
            * @access protected
            */
  function _getSQLSetString()
  {
    $set = ' SET'.'  re_id = "'.$this->getParentId().'"'.', name = "'.$this->getName().'"'.', path = "'.$this->getPath().'"'.', hide = "'.sql :: escape($this->isHidden()).'"'.', updatedate = "'.sql :: escape($this->getUpdateDate()).'"'.', createdate = "'.sql :: escape($this->getCreateDate()).'"'.', updateuser = "'.sql :: escape($this->getUpdateUser()).'"'.', createuser = "'.sql :: escape($this->getCreateUser()).'"';
    return $set;
  } /**
            * @access protected
            * @return Returns <code>true</code> on success or <code>false</code> on error
            */
  function _insert()
  {
    $qry = 'INSERT INTO '.$this->_getTableName();
    $qry .= $this->_getSQLSetString();
    $sql = new sql(); //        $sql->debugsql = true;
    //        echo $qry;
    //        return;
    $sql->query($qry);
    return $sql->getError();
  } /**
            * @access protected
            * @return Returns <code>true</code> on success or <code>false</code> on error
            */
  function _update()
  {
    $qry = 'UPDATE '.$this->_getTableName();
    $qry .= $this->_getSQLSetString();
    $qry .= ' WHERE id = "'.$this->getId().'" LIMIT 1';
    $sql = new sql(); //        $sql->debugsql = true;
    //        echo $qry;
    //        return;
    $sql->query($qry);
    return $sql->getError();
  } /**
            * @access protected
            * @return Returns <code>true</code> on success or <code>false</code> on error
            */
  function _save()
  {
    if ($this->getId() !== null)
    {
      return $this->_update();
    }
    else
    {
      return $this->_insert();
    }
  } /**
         * @access protected
         * @return Returns <code>true</code> on success or <code>false</code> on error
         */
  function _delete($recurse = false)
  {
      // Rekursiv l�schen?
  if ($recurse)
    {
      if ($this->hasChildren())
      {
        $childs = $this->getChildren();
        foreach ($childs as $child)
        {
          $child->_delete($recurse);
        }
      }
    } // Alle Dateien l�schen
    if ($this->hasFiles())
    {
      $files = $this->getFiles();
      foreach ($files as $file)
      {
        $file->_delete();
      }
    }

    $qry = 'DELETE FROM '.$this->_getTableName().' WHERE id = '.$this->getId().' LIMIT 1';
    $sql = new sql(); //        $sql->debugsql = true;
    //        echo $qry;
    //        return;
    $sql->query($qry);
    return $sql->getError();
  }
}
?>