<?php

/**
 * Textile Addon
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo4
 * @version $Id: index.inc.php,v 1.10 2007/10/13 13:52:01 kills Exp $
 */

require $REX['INCLUDE_PATH'].'/layout/top.php';

rex_title('Textile');


$mdl_help = '<?php rex_a79_help_overview(); ?>';


$mdl_ex ='<?php
if(OOAddon::isAvailable("textile"))
{
  if(REX_IS_VALUE[1])
  {
// Diese 3 Zeilen d�rfen keine f�hrenden Leerzeichen besitzen!
$textile =<<<EOD
REX_HTML_VALUE[1]
EOD;

    echo rex_a79_textile($textile);
  }
}
else
{
  echo rex_warning(\'Dieses Modul ben�tigt das "textile" Addon!\');
}
?>';

?>

<div class="rex-addon-output">
	<h2><?php echo $I18N_A79->msg('code_for_module_input'); ?></h2>

	<div class="rex-addon-content">
		<p><?php echo $I18N_A79->msg('module_intro_help'); ?></p>

		<code><?php echo htmlspecialchars($mdl_help); ?></code>

		<p><?php echo $I18N_A79->msg('module_rights'); ?></p>
	</div>

	<h2><?php echo $I18N_A79->msg('code_for_module_output'); ?></h2>

	<div class="rex-addon-content">
		<p><?php echo $I18N_A79->msg('module_intro_moduleoutput'); ?></p>

		<h3><?php echo $I18N_A79->msg('example_for'); ?> REX_VALUE[1]</h3>
		<?php highlight_string($mdl_ex); ?>
	</div>
</div>

<?php
require $REX['INCLUDE_PATH'].'/layout/bottom.php';
?>