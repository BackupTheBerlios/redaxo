<?php

/** 
 *  
 * @package redaxo3
 * @version $Id: login.inc.php,v 1.5 2006/07/25 06:53:22 tbaddade Exp $
 */ 

rex_title("Login","");

if (isset($FORM['loginmessage']) and $FORM['loginmessage'] != "")
{
  echo '<p class="rex-warning">'.$FORM['loginmessage'].'</p>'."\n";
}

if (!isset($REX_ULOGIN)) 
{ 
  $REX_ULOGIN = ''; 
}

echo '

<!-- *** OUTPUT OF LOGIN-FORM - START *** -->
<div class="rex-lgn-frm">
<form action="index.php" method="post" id="loginformular">
  <fieldset>
    <legend class="rex-lgnd">Login</legend>
    <input type="hidden" name="page" value="structure" />
    <p>
      <label for="REX_ULOGIN">'.$I18N->msg('login_name').':</label>
      <input type="text" value="'.$REX_ULOGIN.'" id="REX_ULOGIN" name="REX_ULOGIN" />
    </p>
    <p>
      <label for="REX_UPSW">'.$I18N->msg('password').':</label>
      <input type="password" name="REX_UPSW" id="REX_UPSW" />
	  <input class="rex-sbmt" type="submit" value="'.$I18N->msg('login').'" />
    </p>
  </fieldset>
</form>
</div>
<script type="text/javascript"> 
   <!-- 
   var needle = new getObj("REX_ULOGIN");
   needle.obj.focus();
   //--> 
</script>
<!-- *** OUTPUT OF LOGIN-FORM - END *** -->

';

?>