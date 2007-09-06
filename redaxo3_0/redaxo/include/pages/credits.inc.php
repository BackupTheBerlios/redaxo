<?php

/**
 * Creditsseite. Auflistung der Credits an die Entwickler von REDAXO und den AddOns.
 * @package redaxo3
 * @version $Id: credits.inc.php,v 1.2 2007/09/06 19:25:03 kristinus Exp $
 */

rex_title($I18N->msg("credits"), "");

?><div class="rex-addon-output">
<div class="rex-addon-content">
<?

include_once $REX['INCLUDE_PATH']."/functions/function_rex_other.inc.php";
include_once $REX['INCLUDE_PATH']."/functions/function_rex_addons.inc.php";

?>
<pre style="font-size:14px">

<b>REDAXO:</b>

<b>Jan Kristinus</b>, jan.kristinus@redaxo.de
Erfinder und Coreentwickler
Yakamara Media GmbH & Co KG, <a href="http://www.yakamara.de">www.yakamara.de</a>

<b>Markus Staab</b>, markus.staab@redaxo.de
Coreentwickler
???

<b>Thomas Blum</b>, thomas.blum@redaxo.de
CSS Entwickler, <a href="http://www.blumbeet.com">www.blumbeet.com</a>
???


<b><?php echo $I18N->msg("addon"); ?>:</b>

<table>
<?php

$ADDONS = rex_read_addons_folder();

foreach ($ADDONS as $cur)
{
  	if (isset($REX['ADDON']['page'][$cur])) $cl = 'rex-clr-grn';
		else $cl = 'rex-clr-red';
  	echo '<tr><td class="'.$cl.'">'.$cur.'</td><td class="'.$cl.'">'; 
  	if (isset($REX['ADDON']['version'][$cur])) echo '['.$REX['ADDON']['version'][$cur].']';
  	echo '</td><td class="'.$cl.'">';
  	if (isset($REX['ADDON']['author'][$cur])) echo $REX['ADDON']['author'][$cur];
  	if (!isset($REX['ADDON']['page'][$cur])) echo 'AddOn inaktiv';
  	echo '</td><td class="'.$cl.'">';
  	if (isset($REX['ADDON']['supportpage'][$cur])) echo '<a href="'.$REX['ADDON']['supportpage'][$cur].'">'.$REX['ADDON']['supportpage'][$cur].'</a>';
	echo '</td></tr>';
}
?></table>


</pre>


<?php

?>  </div>
</div>