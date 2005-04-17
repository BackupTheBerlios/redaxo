<?php

/**
* todos: regelt die Rechte an den einzelnen Kategorien und gibt den Pfad aus
* Kategorien = Startartikel und Bez�ge
*
**/

$KATebene = 0; // aktuelle Ebene: default
$KatMaxEbenen = 6; // Maximale Unterebenen
$KATPATH = "|"; // Standard f�r path eintragungen in db

$KAT = new sql;
$KAT->setQuery("select * from rex_article where id=$category_id and startpage=1 and clang=$clang");

if ($KAT->getRows()==1)
{
	$KPATH = explode("|",$KAT->getValue("path"));
	$KATebene = count($KPATH)-1;
	for ($ii=1;$ii<$KATebene;$ii++)
	{
		$SKAT = new sql;
		$SKAT->setQuery("select * from rex_article where id=".$KPATH[$ii]." and startpage=1 and clang=$clang");
		$KATout .= " : <a href=index.php?page=structure&category_id=".$SKAT->getValue("id")."&clang=$clang>".$SKAT->getValue("catname")."</a>";
		$KATPATH .= $KPATH[$ii]."|";
	}
	$KATout .= " : <a href=index.php?page=structure&category_id=$category_id&clang=$clang>".$KAT->getValue("catname")."</a>";
	$KATPATH .= "$category_id|";
}
$KATout = "&nbsp;&nbsp;&nbsp;".$I18N->msg("path")." : <a href=index.php?page=structure&category_id=0&clang=$clang>Homepage</a>".$KATout;

// ***** aktuellen Artikel anzeigen

if ($article_id > 0 and $page == "content")
{
	if ($article->getValue("startpage")==1) $KATout .= " &nbsp;&nbsp;&nbsp;".$I18N->msg("start_article")." : ";
	else $KATout .= " &nbsp;&nbsp;&nbsp;".$I18N->msg("article")." : ";
	$KATout .= "<a href=index.php?page=content&article_id=$article_id&mode=edit&clang=$clang>".str_replace(" ","&nbsp;",$article->getValue("name"))."</a>";
	// $KATout .= " [$article_id]";
}



?>