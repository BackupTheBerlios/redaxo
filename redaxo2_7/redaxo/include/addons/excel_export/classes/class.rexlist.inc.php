<?

// class liste 1.0 [redaxo/prozer]
// 
// erstellt 01.12.2003
// pergopa kristinus gbr
// lange strasse 31
// 60311 Frankfurt/M.
// www.pergopa.de
// ersteller: j.kristinus

// todos:
// aufraeumen/ vereinfachen/ vereinheitlichen
// 
// noch viel sinnloses/altes von anderen projekten drin


class rexlist
{

	var $data;   		// fuer die angezeigten felder
	var $data_name; 	// fuer die feldbezeichungen
	var $data_num; 		// fuer die anzahl der felder
	var $connect;		// connect fuer verknuepfung zb.
	var $link_to;		// link nach
	var $link_field;	// setzt zum link letztes feld z.b. id
	var $format;		// welche formatierung
	var $format_value1;	// formatierungswert
	var $format_value2;	// formatierungswert
	var $format_value3;	// formatierungswert
	var $list_amount;	// wieviel reihen gleichzeitig anzeigen ?
	var $column_link;	// spalte hinzufuegen mit festen wert
	var $column_linkadd;	// welches feld soll hinzu
	var $column_name;	// name des links
	var $column_num;	// name des links
	var $type;		// listtyp
	var $blaettern_link;	// blaettern zusatz
	var $anzeige;		// wenn 0 dann als echo sonst als return
	var $query;		// den select direkt eingeben
	var $page;
	var $DB;
	var $addonlink;
	var $rows;
	var $sql;
	
	// ------------------------------------------------ CONTSTRUCTOR
	
	function rexlist()
	{
		$this->anzeige = 0;
		$this->list_amount = 10;
		$this->column_num = 0;
		$this->DB = 1;
        $this->setGlobalLink();
	}
	
	// ------------------------------------------------ HEADER NACH <TABLE> HINZUFUEGEN
	
	function setTableHeader($table_header){
		$this->table_header = $table_header;
	}

	// ------------------------------------------------ HEADER VOR </TABLE> HINZUFUEGEN
	
	function setTableFooter($table_footer){
		$this->table_footer = $table_footer;
	}
	
	// ------------------------------------------------ LISTEN QUERY SETZEN
	
	function setQuery($query){
		$this->query = $query;
		// $this->sql = new sql($this->DB);
		// $this->sql->setQuery($this->query);
		// $this->rows = $this->sql->getRows();
	}
	
	// ------------------------------------------------ ROW QUERY SETZEN
	
	function setRowQuery($query)
	{
		// select count(id) from table
		$this->sql = new sql($this->DB);
		$this->sql->setQuery($query);		
		if ($this->sql->getRows()==1) $this->rows = $this->sql->getValue("rows");
	}
	
	// ------------------------------------------------ WELCHE DATENBANK . DEFAULT = 1
	
	function setDB($DB){
		$this->DB = $DB;
	}
	
	// ------------------------------------------------ ZUSÄTZLICHE LINKS
	
	function setGlobalLink($addonlink = '')
	{
        if ( $addonlink == '') {
            global $page, $subpage;
            
            $addonlink = 'index.php?page='. $page .'&subpage='. $subpage .'&next=';
        }
        
		$this->addonlink = $addonlink;
	}
	
	// ------------------------------------------------ SPALTE SETZEN MIT DATENBANKFELD
	
	function setValue($showname,$fieldname){
		$this->data_num++;
		$this->data[$this->data_num] 		= $fieldname;
		$this->data_name[$this->data_num] 	= $showname;
		$this->connect[$this->data_num] 	= " value";
		$this->link[$this->data_num]		= "";
	}
	
	// ------------------------------------------------ SPALTE SETZEN - EVENTUEL OHNE DB
	
	function addColumn($showname,$link_ref,$link_add,$link_end = "")
	{
		$this->column_num++;
		$this->column_link[$this->data_num]	= $link_ref;
		$this->column_name[$this->data_num]	= $showname;
		$this->column_linkadd[$this->data_num]	= $link_add;
		$this->column_linkend[$this->data_num]	= $link_end;
	}
	
	// ------------------------------------------------ FORMATIERUNG SETZEN - WIRD IN SHOWALL() DEFINIERT
	
	function setFormat($format,$format_value1="",$format_value2="",$format_value3="",$format_value4="")
	{
		$this->format[$this->data_num] = $format;
		$this->format_value1[$this->data_num] = $format_value1;
		$this->format_value2[$this->data_num] = $format_value2;
		$this->format_value3[$this->data_num] = $format_value3;
		$this->format_value4[$this->data_num] = $format_value4;
	}
	
	// ------------------------------------------------ LINK SETZEN FUER EINZELNE SPALTE

	function setLink($link_to,$what)
	{
		$this->link_to[$this->data_num] 	= $link_to;
		$this->link_field[$this->data_num]	= $what;
	}
	
	
	// ------------------------------------------------ ANZAHL DER REIHEN
	
	function setList($amount)
	{
		$this->list_amount = $amount;
	}
	
	// ------------------------------------------------ LISTENAUSGABE
	
	function showall($next)
	{
		
		global $REX;
		
		// ------------- FALLS KEIN ROWSELECT ALLE DATENSAETZE HOLEN UND ANZAHL SETZEN
		
		if ($this->rows == "")
		{
			$this->sql = new sql($this->DB);
			//$this->sql->debugsql = true;
			$this->sql->setQuery($this->query);			
			$this->rows = $this->sql->getRows();
		}		
		
		$echo =	"<table width=770 cellpadding=5 cellspacing=1 border=0 bgcolor=#ffffff>";
		$echo.= $this->table_header;
		
		// ------------- HEADER

		$echo .= "<tr><td colspan=".($this->data_num+$this->column_num)." class=lgrey><b>";
	
		// ------------- BLAETTERN

		if (!($next>0 && $next <= $this->rows))
		{
			$next = 0;
		}
		$list_start = $next;		
		$list_end = $next+$this->list_amount;
		if ($list_end>$this->rows) $list_end = $this->rows;
		$before = $next-$this->list_amount;
		if ($before<0) $before=0;
		$next = $next+$this->list_amount;
		if ($next>$this->rows) $next = $next-$this->list_amount;
		if ($next<0) $next=0;
		$echo .= "<a href=".$this->addonlink."$before><img src=$REX[HTDOCS_PATH]/pics/back.gif width=24 height=13 border=0></a> ";
		$echo .= "<a href=".$this->addonlink."$next><img src=$REX[HTDOCS_PATH]/pics/forward.gif width=24 height=13 border=0></a>";
		$echo .= " &nbsp; &nbsp; &nbsp; &nbsp; $list_start - $list_end of $this->rows ";
		$echo .= "</b></td></tr>";

		// ------------ QUERY NEU ERSTELLEN MIT LIMIT

		$limit = "LIMIT ".$list_start.",".$this->list_amount;
		$SQL = new sql($this->DB);
		
		$SQL->setQuery("$this->query $limit");
	
		// ------------ <TH>HEADLINES

		$echo .= "<tr>";
		for($i=1;$i<=$this->data_num;$i++)
		{
			$echo .= "<th>";
			$echo .= $this->data_name[$i];
			$echo .= "</th>";
			if ($this->column_name[$i]!="") $echo .= "<th>&nbsp;</th>";
		}
		$echo .= "</tr>";

		// ------------ ERSTELLUNG DER LISTE
	
		for($j=0;$j<$SQL->getRows();$j++)
		{
			// $echo .= "<tr onmouseover=\"setPointer(this,'#d8dca5')\" onmouseout=\"setPointer(this,'#f0efeb')\">";
			$echo .= "<tr id=tr$j>";
			for($i=1;$i<=$this->data_num;$i++)
			{
				
				$echo .= "<td class=grey valign=top>";

				switch($this->format[$i])
				{
					case("replace_value"):
						$stype = explode("|",$this->format_value1[$i]);
						$value = $SQL->getValue($this->data[$i]);
						for ($k=0;$k<count($stype);$k++)
						{
							$svalue = $stype[$k];
							$k++;
							$sname = $stype[$k];
							if ($SQL->getValue($this->data[$i])==$svalue) $value = $sname;
						}					
						break;
					
					case("activestatus"):
						if ($SQL->getValue($this->data[$i])==0) $value = "inactive";
						else $value = "active";
						break;
					case("minute2hour"):
						$hours = intval($SQL->getValue($this->data[$i])/60);
						$minutes = ($SQL->getValue($this->data[$i]) - ($hours*60))/60*100;
						if ($minutes<10) $minutes="0$minutes";
						elseif ($minutes==0) $minutes = "00";
						$value = "$hours,$minutes";
						break;
					case("time"):
						$value = substr($SQL->getValue($this->data[$i]),0,2).":".substr($SQL->getValue($this->data[$i]),2,2)."";
						break;
					case("unixToDateTime"):
						$value = date("d.M.Y H:i:s",$SQL->getValue($this->data[$i]));
						break;
					case("nl2br"):
						$value = nl2br($SQL->getValue($this->data[$i]));
						break;
					case("content"):
						$value = $this->data[$i];
						break;
					default:
						$value = htmlentities($SQL->getValue($this->data[$i]));
				}
				
				if ($value==""){ $value = "&nbsp;"; }
				
				if ($this->link_to[$i]!="")
				{
					$link = $this->link_to[$i];
					$link_field = $this->link_field[$i];
					if ($this->link_field[$i]!=""){ $value = "<a href=".$this->link_to[$i].urlencode($SQL->getValue($link_field))." class=yel>$value</a>";
					}else{ $value = value; }
				}
	
				$echo .= $value;
	
				$echo .= "</td>\n";
	
				if ($this->column_name[$i]!=""){
					$link_name	= $this->column_link[$i];
					$link_field	= $this->column_linkadd[$i];
					$column_name	= $this->column_name[$i];
					$column_ausgabe = "<td class=grey valign=top><a href=$link_name";
					$column_ausgabe .= $SQL->getValue($link_field);
					$column_ausgabe .= $this->column_linkend[$i];
					$column_ausgabe .= " class=yel>$column_name</a></td>";
	
					$echo .= $column_ausgabe;
				}
			}
			$echo .= "</tr>";
	
	
			$SQL->next();
	
		}
	
		$echo.= $this->table_footer;
		$echo .= "</table>";
		
		return $echo;
	}
}

?>