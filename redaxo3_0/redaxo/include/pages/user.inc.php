<?

/*

----------------------------- todos


sprachen zugriff
englisch / deutsch / ...



allgemeine zugriffe (array + addons)
	mediapool[]templates[] ...

optionen
	advancedMode[]expertMode[]

zugriff auf folgende categorien
	catstructure[2]

mulselect zugriff auf mediapool
	catmedia[2]

mulselect module
- liste der module
	module[2]module[3]

*/

if ($user_id != "")
{
	$sql = new sql;
	$sql->setQuery("select * from rex_user where user_id='$user_id'");
	if ($sql->getRows()!=1) uset($user_id);
}



// Allgemeine Permissions setzen
$sel_all = new select;
$sel_all->multiple(1);
$sel_all->set_style("width:100%;");
$sel_all->set_size(10);
$sel_all->set_name("userperm_all[]");
for($i=0;$i<count($REX[PERM]);$i++)
{
	if($i==0) reset($REX[PERM]);
	$sel_all->add_option(current($REX[PERM]),current($REX[PERM]));
	next($REX[PERM]);
}

// optionen
$REX[EXTPERM][] = "advancedMode[]";
$REX[EXTPERM][] = "caching[]";
$REX[EXTPERM][] = "module[php]";
$REX[EXTPERM][] = "module[html]";
$sel_ext = new select;
$sel_ext->multiple(1);
$sel_ext->set_style("width:100%;");
$sel_ext->set_size(10);
$sel_ext->set_name("userperm_ext[]");
for($i=0;$i<count($REX[EXTPERM]);$i++)
{
	if($i==0) reset($REX[EXTPERM]);
	$sel_ext->add_option(current($REX[EXTPERM]),current($REX[EXTPERM]));
	next($REX[EXTPERM]);
}

// zugriff auf categorien
$sel_cat = new select;
$sel_cat->multiple(1);
$sel_cat->set_style("width:100%;");
$sel_cat->set_size(20);
$sel_cat->set_name("userperm_cat[]");

$cat_ids = array();
if ($rootCats = OOCategory::getRootCategories())
{
	foreach( $rootCats as $rootCat) {
	    add_cat_options( $sel_cat, $rootCat, $cat_ids);
	}
}

function add_cat_options( &$select, &$cat, &$cat_ids, $groupName = '') {
    if( empty( $cat)) {
        return;
    }
    
    $cat_ids[] = $cat->getId();
    $select->add_option($cat->getName(),$cat->getId(), $groupName);
    $childs = $cat->getChildren();
  
    if ( is_array( $childs)) {  
        foreach ( $childs as $child) {
            add_cat_options( $select, $child, $cat_ids, $cat->getName());
        }
    }
}

// zugriff auf mediacategorien
$sel_media = new select;
$sel_media->multiple(1);
$sel_media->set_style("width:100%;");
$sel_media->set_size(20);
$sel_media->set_name("userperm_media[]");
$sqlmedia = new sql;
$sqlmedia->setQuery("select * from rex_file_category where clang=0");
for ($i=0;$i<$sqlmedia->getRows();$i++)
{
	$name = $sqlmedia->getValue("name");
	// $c = substr_count($sql->getValue("path"),"|");	
	$sel_media->add_option($name,$sqlmedia->getValue("id"));
	$sqlmedia->next();	
}

// zugriff auf module
$sel_module = new select;
$sel_module->multiple(1);
$sel_module->set_style("width:100%;");
$sel_module->set_size(10);
$sel_module->set_name("userperm_module[]");
$sqlmodule = new sql;
$sqlmodule->setQuery("select * from rex_modultyp order by name");
for ($i=0;$i<$sqlmodule->getRows();$i++)
{
	$name = $sqlmodule->getValue("name");	
	$sel_module->add_option($name,$sqlmodule->getValue("id"));
	$sqlmodule->next();
}



title($I18N->msg("title_user"),"");

// --------------------------------- FUNCTIONS

if ($FUNC_UPDATE != "")
{
	$updateuser = new sql;
	$updateuser->setTable("rex_user");
	$updateuser->where("user_id='$user_id'");
	$updateuser->setValue("name",$username);
	$updateuser->setValue("psw",$userpsw);
	$updateuser->setValue("description",$userdesc);

	$perm = "";
	if ($useradmin == 1) $perm .= "admin[]";
	if ($devadmin == 1) $perm .= "dev[]";
	if ($allcats == 1) $perm .= "catstructure[all]";
	if ($allmcats == 1) $perm .= "catmedia[all]";

	// userperm_all
	for($i=0;$i<count($userperm_all);$i++)
	{
		$perm .= current($userperm_all);
		next($userperm_all);
	}
	// userperm_ext
	for($i=0;$i<count($userperm_ext);$i++)
	{
		$perm .= current($userperm_ext);
		next($userperm_ext);
	}
	// userperm_cat
	for($i=0;$i<count($userperm_cat);$i++)
	{
		$perm .= "catstructure[".current($userperm_cat)."]";
		next($userperm_cat);
	}
	// userperm_media
	for($i=0;$i<count($userperm_media);$i++)
	{
		$perm .= "catmedia[".current($userperm_media)."]";
		next($userperm_media);
	}
	// userperm_module
	for($i=0;$i<count($userperm_module);$i++)
	{
		$perm .= "module[".current($userperm_module)."]";
		next($userperm_module);
	}
	$updateuser->setValue("rights",$perm);
	$updateuser->update();
	unset($user_id);
	unset($FUNC_UPDATE);
	$message = $I18N->msg("user_data_updated");

}elseif($FUNC_DELETE != "")
{
	if ($REX_USER->getValue("user_id")!=$user_id)
	{
		$deleteuser = new sql;
		$deleteuser->query("delete from rex_user where user_id='$user_id'");
		$message = $I18N->msg("user_deleted");
	}else
	{
		$message = "**** Sie k�nnen sich nicht selbst l�schen!";	
	}

}elseif($FUNC_ADD != "" && $save == 1)
{
	$adduser = new sql;
	$adduser->setQuery("select * from rex_user where login='$userlogin'");

	if ($adduser->getRows()==0 and $userlogin != "")
	{
		$adduser = new sql;
		$adduser->setTable("rex_user");
		$adduser->setValue("name",$username);
		$adduser->setValue("psw",$userpsw);
		$adduser->setValue("login",$userlogin);
		$adduser->setValue("description",$userdesc);
		
		$perm = "";
		if ($useradmin == 1) $perm .= "admin[]";
		if ($devadmin == 1) $perm .= "dev[]";
		if ($allcats == 1) $perm .= "catstructure[all]";
		if ($allmcats == 1) $perm .= "catmedia[all]";
	
		// userperm_all
		for($i=0;$i<count($userperm_all);$i++)
		{
			$perm .= current($userperm_all);
			next($userperm_all);
		}
		// userperm_ext
		for($i=0;$i<count($userperm_ext);$i++)
		{
			$perm .= current($userperm_ext);
			next($userperm_ext);
		}
		// userperm_cat
		for($i=0;$i<count($userperm_cat);$i++)
		{
			$perm .= "catstructure[".current($userperm_cat)."]";
			next($userperm_cat);
		}
		// userperm_media
		for($i=0;$i<count($userperm_media);$i++)
		{
			$perm .= "catmedia[".current($userperm_media)."]";
			next($userperm_media);
		}
		// userperm_module
		for($i=0;$i<count($userperm_module);$i++)
		{
			$perm .= "module[".current($userperm_module)."]";
			next($userperm_module);
		}
		
		$adduser->setValue("rights",$perm);
		$adduser->insert();
		$user_id = 0;
		unset($FUNC_ADD);
		$message = $I18N->msg("user_added");
	}else
	{
		
		if ($useradmin == 1) $adminchecked = " checked";
		if ($devadmin == 1) $devchecked = " checked";
		if ($allcats == 1) $allcatschecked = " checked";
		if ($allmcats == 1) $allmcatschecked = " checked";
		
		
		// userperm_all
		for($i=0;$i<count($userperm_all);$i++)
		{
			$sel_all->set_selected(current($userperm_all));
			next($userperm_all);
		}
		// userperm_ext
		for($i=0;$i<count($userperm_ext);$i++)
		{
			$sel_ext->set_selected(current($userperm_ext));
			next($userperm_ext);
		}
		// userperm_cat
		for($i=0;$i<count($userperm_cat);$i++)
		{
			$sel_cat->set_selected(current($userperm_cat));
			next($userperm_cat);
		}
		// userperm_media
		for($i=0;$i<count($userperm_media);$i++)
		{
			$sel_media->set_selected(current($userperm_media));
			next($userperm_media);
		}
		// userperm_module
		for($i=0;$i<count($userperm_module);$i++)
		{
			$sel_module->set_selected(current($userperm_module));
			next($userperm_module);
		}
		
		$message = $I18N->msg("user_login_exists");
	}
}


// ---------------------------------- ERR MSG

if ($message != "")
{
	echo "<table border=0 cellpadding=5 cellspacing=1 width=770><tr><td align=center class=warning width=20><img src=pics/warning.gif width=16 height=16></td><td colspan=3 class=warning>$message</td></tr></table><br>";
}


// --------------------------------- FORMS

$SHOW = true;

if ($FUNC_ADD)
{
	$SHOW = false;

	echo "	<table border=0 cellpadding=5 cellspacing=1 width=770>
		<form action=index.php method=post>
		<input type=hidden name=page value=user>
		<input type=hidden name=save value=1>
		<input type=hidden name=FUNC_ADD value=1>
		<tr><th align=left colspan=4><b>".$I18N->msg("create_user")."</b></th></tr>
		
		<tr>
			<td class=grey width=100>".$I18N->msg("login_name")."</td>
			<td class=grey width=250><input style='width:100%' type=text size=20 name=userlogin value=\"".stripslashes(htmlentities($userlogin))."\"></td>
			<td class=grey width=100>".$I18N->msg("password")."</td>
			<td class=grey><input style='width:100%' type=text size=20 name=userpsw value=\"".stripslashes(htmlentities($userpsw))."\"></td>
		</tr>

		<tr>
			<td class=grey>".$I18N->msg("name")."</td>
			<td class=grey><input style='width:100%' type=text size=20 name=username value=\"".stripslashes(htmlentities($username))."\"></td>
			<td class=grey>".$I18N->msg("description")."</td>
			<td class=grey><input style='width:100%' type=text size=20 name=userdesc value=\"".stripslashes(htmlentities($userdesc))."\"></td>
		</tr>
		<tr>
			<td class=grey align=right><input type=checkbox name=useradmin value=1 $adminchecked></td>
			<td class=grey>Admin (Alle Kategorien/Alle Module/Alle Medien/User)</td>
			<td class=grey align=right><input type=checkbox name=devadmin value=1 $devchecked></td>
			<td class=grey>Developer (Templates/Moduledit/AddOn)</td>
		</tr>
		<tr>
			<td class=grey valign=top>Allgemein</td>
			<td class=grey>".$sel_all->out()."</td>
			<td class=grey valign=top>Optionen</td>
			<td class=grey>".$sel_ext->out()."</td>
		</tr>
		<tr>
			<td class=grey align=right><input type=checkbox name=allcats value=1 $allcatschecked></td>
			<td class=grey>Alle Kategorien)</td>
			<td class=grey align=right><input type=checkbox name=allmcats value=1 $allmcatschecked></td>
			<td class=grey>Alle Medienkategorien</td>
		</tr>
		<tr>
			<td class=grey valign=top>Kategorien</td>
			<td class=grey>".$sel_cat->out()."</td>
			<td class=grey valign=top>Medienordner</td>
			<td class=grey>".$sel_media->out()."</td>
		</tr>
		<tr>
			<td class=grey valign=top>Module</td>
			<td class=grey>".$sel_module->out()."</td>
			<td class=grey valign=top colspan=2>&nbsp;</td>
		</tr>
		
		<tr>
			<td class=grey>&nbsp;</td>
			<td class=grey colspan=3><input type=submit name=function value='".$I18N->msg("add_user")."'></td>
		</tr>
		</form>
		</table>";


}elseif($user_id != "")
{

	$sql = new sql;
	$sql->setQuery("select * from rex_user where user_id='$user_id'");

	if ($sql->getRows()==1)
	{

		// ----- EINLESEN DER PERMS
		if ($sql->isValueOf("rights","admin[]")) $adminchecked = "checked";
		else $adminchecked = "";

		if ($sql->isValueOf("rights","dev[]")) $devchecked = "checked";
		else $devchecked = "";

		if ($sql->isValueOf("rights","catstructure[all]")) $allcatschecked = "checked";
		else $allcatschecked = "";
		
		if ($sql->isValueOf("rights","catmedia[all]")) $allmcatschecked = "checked";
		else $allmcatschecked = "";

		// Allgemeine Permissions setzen
		for($i=0;$i<count($REX[PERM]);$i++)
		{
			if($i==0) reset($REX[PERM]);
			if ($sql->isValueOf("rights",current($REX[PERM]))) $sel_all->set_selected(current($REX[PERM]));
			next($REX[PERM]);
		}
		
		// optionen
		for($i=0;$i<count($REX[EXTPERM]);$i++)
		{
			if($i==0) reset($REX[EXTPERM]);
			if ($sql->isValueOf("rights",current($REX[EXTPERM]))) $sel_ext->set_selected(current($REX[EXTPERM]));
			next($REX[EXTPERM]);
		}
	
		foreach ( $cat_ids as $cat_id) {
            $name = "catstructure[".$cat_id."]";
            if ($sql->isValueOf("rights",$name)) $sel_cat->set_selected($cat_id);
        }

		$sqlmedia->resetCounter();
		for ($i=0;$i<$sqlmedia->getRows();$i++)
		{
			$name = "catmedia[".$sqlmedia->getValue("id")."]";
			if ($sql->isValueOf("rights",$name)) $sel_media->set_selected($sqlmedia->getValue("id"));
			$sqlmedia->next();	
		}
		
		$sqlmodule->resetCounter();
		for ($i=0;$i<$sqlmodule->getRows();$i++)
		{
			$name = "module[".$sqlmodule->getValue("id")."]";
			if ($sql->isValueOf("rights",$name)) $sel_module->set_selected($sqlmodule->getValue("id"));
			$sqlmodule->next();
		}

		// ----- FORM UPDATE AUSGABE

		echo "
		<table border=0 cellpadding=5 cellspacing=1 width=770>
		<form action=index.php method=post>
		<input type=hidden name=page value=user>
		<input type=hidden name=user_id value=$user_id>
		<tr><th align=left colspan=4><b>".$I18N->msg("edit_user")."</b></th></tr>
		<tr>
			<td class=grey width=100>".$I18N->msg("login_name")."</td>
			<td class=grey width=250><b>".htmlentities($sql->getValue("rex_user.login"))."</b></td>
			<td class=grey width=100>".$I18N->msg("password")."</td>
			<td class=grey><input style='width:100%' type=text size=20 name=userpsw value=\"".htmlentities($sql->getValue("rex_user.psw"))."\"></td>
		</tr>

		<tr>
			<td class=grey>".$I18N->msg("name")."</td>
			<td class=grey><input style='width:100%' type=text size=20 name=username value=\"".htmlentities($sql->getValue("rex_user.name"))."\"></td>
			<td class=grey>".$I18N->msg("description")."</td>
			<td class=grey><input style='width:100%' type=text size=20 name=userdesc value=\"".htmlentities($sql->getValue("rex_user.description"))."\"></td>
		</tr>
		<tr>
			<td class=grey align=right><input type=checkbox name=useradmin value=1 $adminchecked></td>
			<td class=grey>Admin (Alle Kategorien/Alle Module/Alle Medien/User)</td>
			<td class=grey align=right><input type=checkbox name=devadmin value=1 $devchecked></td>
			<td class=grey>Developer (Templates/Moduledit/AddOn)</td>
		</tr>
		<tr>
			<td class=grey valign=top>Allgemein</td>
			<td class=grey>".$sel_all->out()."</td>
			<td class=grey valign=top>Optionen</td>
			<td class=grey>".$sel_ext->out()."</td>
		</tr>
		<tr>
			<td class=grey align=right><input type=checkbox name=allcats value=1 $allcatschecked></td>
			<td class=grey>Alle Kategorien</td>
			<td class=grey align=right><input type=checkbox name=allmcats value=1 $allmcatschecked></td>
			<td class=grey>Alle Medienordner</td>
		</tr>
		<tr>
			<td class=grey valign=top>Kategorien</td>
			<td class=grey>".$sel_cat->out()."</td>
			<td class=grey valign=top>Medienordner</td>
			<td class=grey>".$sel_media->out()."</td>
		</tr>
		<tr>
			<td class=grey valign=top>Module</td>
			<td class=grey>".$sel_module->out()."</td>
			<td class=grey valign=top>&nbsp;</td>
			<td class=grey>&nbsp;</td>
		</tr>

		<tr>
			<td class=grey>&nbsp;</td>
			<td class=grey><input type=submit name=FUNC_UPDATE value='".$I18N->msg("update")."'></td>
			<td class=grey colspan=2>";
		if ($REX_UID!=$user_id) echo "<input type=submit name=FUNC_DELETE value='".$I18N->msg("delete")."'>";
		else echo "&nbsp;";
		echo "</td></tr>
		</form>
		</table>";

		$SHOW = false;
	}

}


















// ---------------------------------- Userliste

if ($SHOW)
{

	echo "	<table border=0 cellpadding=5 cellspacing=1 width=770>
		<tr>
			<th width=30><a href=index.php?page=user&FUNC_ADD=1><img src=pics/user_plus.gif width=16 height=16 border=0></a></th>
			<th align=left width=300>Name</th>
			<th align=left>Login</th>
			<th align=left>Letzter Login</th>

		</tr>";

	$sql = new sql;
	$sql->setQuery("select * from rex_user order by rex_user.name");

	for($i=0;$i<$sql->getRows();$i++)
	{
		echo "	<tr>
			<td class=grey align=center><a href=index.php?page=user&user_id=".$sql->getValue("rex_user.user_id")."><img src=pics/user.gif width=16 height=16 border=0></a></td>
			<td class=grey><a href=index.php?page=user&user_id=".$sql->getValue("rex_user.user_id").">".htmlentities($sql->getValue("rex_user.name"))."</a></td>
			<td class=grey>".$sql->getValue("rex_user.login")."</td>
			<td class=grey>".$sql->getValue("rex_user.lasttrydate")."</td>
			</tr>";
		$sql->counter++;
	}
	echo "</table>";

}


?>
