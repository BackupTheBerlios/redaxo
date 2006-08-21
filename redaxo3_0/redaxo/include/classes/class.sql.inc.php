<?php


// class sql 1.0
//
// erstellt 01.12.2001
// pergopa kristinus gbr
// lange strasse 31
// 60311 Frankfurt/M.
// www.pergopa.de
// ersteller: j.kristinus

/**
 * Klasse zur Verbindung und Interatkion mit der Datenbank
 * @version $Id: class.sql.inc.php,v 1.34 2006/08/21 12:12:26 kills Exp $ 
 */
class sql
{
  var $values; // Werte von setValue

  var $table; // Tabelle setzen
  var $wherevar; // WHERE Bediengung
  var $select; // letzter Query String
  var $counter; // select: welcher datensatz ist dran
  var $rows; // select: anzahl der treffer
  var $result; // select: alle angaben gespeichert
  var $last_insert_id; // zuletzt angelegte auto_increment nummer
  var $debugsql; // debug schalter
  var $identifier; // Datenbankverbindung
  var $DBID; // ID der Verbindung

  var $error; // Fehlertext
  var $errno; // Fehlernummer

  function sql($DBID = 1)
  {
    global $REX;

    $this->identifier = @ mysql_pconnect($REX['DB'][$DBID]['HOST'], $REX['DB'][$DBID]['LOGIN'], $REX['DB'][$DBID]['PSW']);
    $this->debugsql = false;
    $this->DBID = $DBID;
    $this->selectDB();
    $this->zaehler = 0;
    $this->counter = 0;

    // MySQL Version bestimmen
    if ($REX['MYSQL_VERSION'] == '')
    {
      $this->setQuery('SELECT VERSION() as VERSION');
      $res = $this->get_array();
      $arr = array ();
      preg_match('/([0-9]+\.([0-9\.])+)/', $res[0]['VERSION'], $arr);
      $REX['MYSQL_VERSION'] = $arr[1];
    }
  }

  /**
   * Stellt die Verbindung zur Datenbank her
   */
  function selectDB()
  {
    global $REX;

    if (!@ mysql_select_db($REX['DB'][$this->DBID]['NAME']))
    {
      echo "<font style='color:red; font-family:verdana,arial; font-size:11px;'>Class SQL 1.1 | Database down. | Please contact <a href=mailto:".$REX['ERROR_EMAIL'].">".$REX['ERROR_EMAIL']."</a>\n | Thank you!\n</font>";
      exit;
    }
  }

  /**
   * Setzt eine Abfrage (SQL) ab
   * @param $query Abfrage 
   */
  function setQuery($qry)
  {
    $this->counter = 0;
    $this->last_insert_id = 0;
    $this->select = $qry;
    $this->selectDB();
    $this->result = @ mysql_query($qry);
    
    if(eregi("^[ ]*(SELECT|UPDATE|INSERT) ",$qry,$matches = array()))
    {
      switch(strtoupper($matches[1]))
      {
        case 'SELECT':
        {
          $this->rows = mysql_num_rows($this->result);
          break;          
        }
        case 'UPDATE' :
        {
          $this->rows = mysql_affected_rows();
          break;          
        }
        case 'INSERT' :
        {
          $this->rows = mysql_affected_rows();
          $this->last_insert_id = @ mysql_insert_id();
          break;          
        }
      }
    }
    
    $this->error = @ mysql_error();
    $this->errno = @ mysql_errno();

    if ($this->debugsql)
    {
      $this->printError($qry);
    }
  }

  /**
   * Setzt den Tabellennamen
   * @param $table Tabellenname
   */
  function setTable($table)
  {
    $this->table = $table;
  }

  /**
   * Setzt den Wert eine Spalte
   * @param $feldname Spaltenname
   * @param $wert Wert
   */
  function setValue($feldname, $wert)
  {
    $this->values[$feldname] = $wert;
  }

  /**
   * Pr�ft den Wert einer Spalte der aktuellen Zeile ob ein Wert enthalten ist
   * @param $feld Spaltenname des zu pr�fenden Feldes
   * @param $prop Wert, der enthalten sein soll
   */
  function isValueOf($feld, $prop)
  {
    if ($prop == "")
    {
      return TRUE;
    }
    else
    {
      return strpos($this->getValue($feld), $prop) !== false;
    }
  }

  /**
   * Setzt die WHERE Bedienung der Abfrage
   */
  function where($where)
  {
    $this->wherevar = "where $where";
  }

  /**
   * Gibt den Wert einer Spalte im ResultSet zur�ck
   * @param $value Name der Spalte
   * @param [$row] Zeile aus dem ResultSet
   */
  function getValue($value, $row = null)
  {
      // wenn db verwechslungen, dann hier aktiv setzen
    // $this->selectDB();
  $_row = $this->counter;
    if (is_int($row))
    {
      $_row = $row;
    }

    $back = @ mysql_result($this->result, $_row, $value);

    return $back;
  }

  /**
   * Gibt die Anzahl der Zeilen zur�ck, die vom letzten SQL betroffen sind
   */
  function getRows()
  {
    return $this->rows;
  }

  /**
   * Setzt den Cursor des Resultsets auf die n�chst h�here Stelle
   * @see #next();
   */
  function nextValue()
  {
    $this->counter++;
  }

  /**
   * Setzt den Cursor des Resultsets zur�ck zum Anfang
   */
  function resetCounter()
  {
    $this->counter = 0;
  }
  
  function buildSetQuery()
  {
    $qry = '';
    if (is_array($this->values))
    {
      foreach ($this->values as $fld_name => $value)
      {
        if ($qry != '')
        {
          $qry .= ',';
        }
        $qry .= '`'.$fld_name.'`=\''. $value .'\'';
      }
    }
    
    return $qry;
  }

  /**
   * Setzt eine Update-Anweisung auf die angegebene Tabelle 
   * mit den angegebenen Werten und WHERE Parametern ab
   * 
   * @see #setTable()
   * @see #setValue()
   * @see #where()
   */
  function update()
  {
    $this->setQuery('UPDATE `'. $this->table .'` SET '.$this->buildSetQuery() . $this->wherevar);
  }

  /**
   * Setzt eine Insert-Anweisung auf die angegebene Tabelle 
   * mit den angegebenen Werten ab
   * 
   * @see #setTable()
   * @see #setValue()
   */
  function insert()
  {
    $this->setQuery('INSERT INTO `'. $this->table .'` SET '.$this->buildSetQuery() . $this->wherevar);
  }

  /**
   * Setzt eine Replace-Anweisung auf die angegebene Tabelle 
   * mit den angegebenen Werten ab
   * 
   * @see #setTable()
   * @see #setValue()
   */
  function replace()
  {
    $this->setQuery('REPLACE INTO `'. $this->table .'` SET '.$this->buildSetQuery() . $this->wherevar);
  }
  
  /**
   * Setzt eine Delete-Anweisung auf die angegebene Tabelle 
   * mit den angegebenen WHERE Parametern ab
   * 
   * @see #setTable()
   * @see #where()
   */
  function delete()
  {
    $this->selectDB();
    $this->result = mysql_query("delete from $this->table $this->wherevar");
    $this->error = @ mysql_error();
  }

  /**
   * Stellt alle Werte auf den Ursprungszustand zur�ck
   */
  function flush()
  {
    $this->table = "";
    $this->error = "";
    $this->wherevar = "";
    $this->select = "";
    $this->counter = 0;
    $this->rows = 0;
    $this->result = "";
  }

  /**
   * Sendet eine Abfrage an die Datenbank
   * @deprecated 3.3 - 21.08.2006
   */
  function query($qry)
  {
    $this->setQuery($qry);
  }

  /**
   * Setzt den Cursor des Resultsets auf die n�chst h�here Stelle
   */
  function next()
  {
    $this->counter++;
  }

  /**
   * Gibt die letzte InsertId zur�ck
   */
  function getLastID()
  {
    return $this->last_insert_id;
  }

  /**
   * L�dt das komplette Resultset in ein Array und gibts dieses zur�ck 
   */
  function get_array($sql = "", $fetch_type = MYSQL_ASSOC)
  {

    if ($sql != "")
    {
      $this->setQuery($sql);
    }

    $data = null;

    while ($row = @ mysql_fetch_array($this->result, $fetch_type))
    {
      $data[] = $row;
    }

    return $data;
  }

  /**
   * Gibt die zuletzt aufgetretene Fehlernummer zur�ck 
   */
  function getErrno()
  {
    return $this->errno;
  }

  /**
   * Gibt den zuletzt aufgetretene Fehlernummer zur�ck 
   */
  function getError()
  {
    return $this->error;
  }

  /**
   * Gibt die letzte Fehlermeldung aus 
   */
  function printError($select)
  {
    if($this->debugsql === 2 && strlen($this->getError()) > 0 || $this->debugsql === true)
    {
      echo '<hr />'."\n";
      echo 'Query: '.nl2br(htmlspecialchars($select))."<br />\n";
  
      if (strlen($this->getRows()) > 0)
      {
        echo 'Affected Rows: '.$this->getRows()."<br />\n";
      }
      if (strlen($this->getError()) > 0)
      {
        echo 'Error Message: '.htmlspecialchars($this->getError())."<br />\n";
        echo 'Error Code: '.$this->getErrno()."<br />\n";
      }
    }
  }

  /**
   * Setzt eine Spalte auf den n�chst m�glich auto_increment Wert
   * @param $field Name der Spalte 
   */
  function setNewId($field)
  {
    $result = mysql_query("SELECT `$field` FROM `$this->table` ORDER BY `$field` DESC LIMIT 1");
    if (@ mysql_num_rows($result) == 0)
      $id = 0;
    else
      $id = mysql_result($result, 0, $field);
      
    $id++;
    $this->setValue($field, $id);
    return $id;
  }

  /**
   * Gibt die Spaltennamen des ResultSets zur�ck 
   */
  function getFieldnames()
  {
    $fields = array ();
    $numFields = mysql_num_fields($this->result);
    for ($i = 0; $i < $numFields; $i++)
    {
      $fields[] = mysql_field_name($this->result, $i);
    }
    return $fields;
  }
  
  function escape($value)
  {
    // Quote if not a number or a numeric string
    if (!is_numeric($value)) {
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
  }
}
?>