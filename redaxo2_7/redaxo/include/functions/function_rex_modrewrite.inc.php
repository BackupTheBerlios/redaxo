<?php

##########################################################
# Generate Mod Rewrite Name for Article
# Get Url for an Article ID
##########################################################

function ModRewriteName($article_name) {
    $url = str_replace(" ","_",$article_name);
    $url = str_replace("�","ae",$url);
    $url = str_replace("�","oe",$url);
    $url = str_replace("�","ue",$url);
    $url = str_replace("�","Ae",$url);
    $url = str_replace("�","Oe",$url);
    $url = str_replace("�","Ue",$url);
    $url = str_replace("/","-",$url);
    $url = str_replace("&","-",$url);
    $url = urlencode($url);
    return $url;
}

function getURLbyID($ArticleID){
	global $REX;
	if($REX[MOD_REWRITE]){
		$db = new sql;
		$sql = "SELECT name FROM rex_article WHERE id='$ArticleID'";
		$res = $db->get_array($sql);
		$url = $ArticleID."-".ModRewriteName($res[0][name]);
	} else {
		$url = '/?article_id='.$ArticleID;
	}
	return $url;
}

?>