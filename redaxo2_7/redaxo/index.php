<?php

unset($REX);

$REX[HTDOCS_PATH] = "../";
$REX[GG] = false;
$REX[BC] = false;
$REX[REDAXO] = true;

include "include/master.inc.php";

session_start();

// ----------------- auth
if ($REX[SETUP])
{
	$page_name = $I18N->msg("setup");
	$page = "setup";
	$dl = false;
}else
{
	$REX_LOGIN = new login();
	$REX_LOGIN->setSqlDb(1);
	$REX_LOGIN->setSysID("redaxo");	// fuer redaxo
	$REX_LOGIN->setSessiontime(3000); // 3600 sekunden = 60 min
	$REX_LOGIN->setLogin($REX_ULOGIN,$REX_UPSW);
	if ($FORM[logout] == 1) $REX_LOGIN->setLogout(true);
	$REX_LOGIN->setUserID("rex_user.user_id");
	$REX_LOGIN->setUserquery("select * from rex_user where user_id='USR_UID'");
	$REX_LOGIN->setLoginquery("select * from rex_user where login='USR_LOGIN' and psw='USR_PSW'");
	if (!$REX_LOGIN->checkLogin())
	{
		header("Location: login.php?"."&FORM[loginmessage]=".urlencode($REX_LOGIN->message));
		$LOGIN = FALSE;
		exit;
	}else
	{
		$LOGIN = TRUE;
		$REX_USER = $REX_LOGIN->USER;
	}
	$dl = false;
	$page = strtolower($page);
	
	if ($page=="addon" && $REX_USER->isValueOf("rights","addon[]"))
	{
		$page_name = $I18N->msg("addon");
	}elseif ($page=="specials" && $REX_USER->isValueOf("rights","specials[]"))
	{
		$page_name = $I18N->msg("specials");
	}elseif ($page=="module" && $REX_USER->isValueOf("rights","module[]"))
	{
		$page_name = $I18N->msg("module");
	}elseif ($page=="template" && $REX_USER->isValueOf("rights","template[]"))
	{
		$page_name = $I18N->msg("template");
	}elseif ($page=="user" && $REX_USER->isValueOf("rights","user[]"))
	{
		$page_name = $I18N->msg("user");
	}elseif ($page=="community" && $REX_USER->isValueOf("rights","community[]"))
	{
		$page_name = $I18N->msg("community");
	}elseif ($page=="stats" && $REX_USER->isValueOf("rights","stats[]"))
	{
		$page_name = "Statistiken";
	}elseif ($page=="medienpool")
	{
		$dl = true;
	}elseif ($page=="linkmap")
	{
		$dl = true;
	}elseif ($page=="content")
	{
		$page_name = $I18N->msg("content");
	}elseif ($page=="structure")
	{
		$page_name = $I18N->msg("structure");
	}else
	{
		// addon check
		$as = array_search($page,$REX[ADDON][page]);
		if ($as === false)
		{
			// addon not aktive or not found
			$page_name = $I18N->msg("structure");
			$page = "structure";
		}else
		{
			// addon gefunden	
			$perm = $REX[ADDON][perm][$as];
			// right checken zurerst $perm damit kein fehler bei bei rights
			if($perm == "" or $REX_USER->isValueOf("rights",$perm))
			{
				include $REX[INCLUDE_PATH]."/addons/$page/pages/index.inc.php";
				exit;
			}else
			{
				// no perms to this addon
				$page_name = $I18N->msg("structure");
				$page = "structure";
			}
		}
	}
}

if (!$dl) include $REX[INCLUDE_PATH]."/layout_redaxo/top.php";
include $REX[INCLUDE_PATH]."/pages/$page.inc.php";
if (!$dl) include $REX[INCLUDE_PATH]."/layout_redaxo/bottom.php";

?>