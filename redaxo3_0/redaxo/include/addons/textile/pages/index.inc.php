<?php
/**
 * 
 * @package redaxo3
 * @version $Id: index.inc.php,v 1.1 2006/09/08 14:55:25 kills Exp $
 */
 
require $REX['INCLUDE_PATH'].'/layout/top.php';

rex_title('Textile');

$mdl_ex =<<<EOD
if (REX_IS_VALUE[1]) 
{
  \$textile =<<<EOD
  REX_HTML_VALUE[1]
  EOD;
  echo rex_a79_textile(\$textile);
}
EOD;

$mdl_help = '<?php rex_a79_help_overview(); ?>';

?>

<p>
Einfach mit folgendem Code in die Ausgabe eines beliebigen Moduls einbinden
</p>

<h2>Beispiel f�r REX_VALUE[1]</h2>
<code><?php echo nl2br(htmlspecialchars($mdl_ex)) ?></code>

<p>
Um eine Tabelle mit einer Anleitung und Hinweisen in ein Modul einzubinden, 
einfach folgenden Funktionsaufruf einf�gen:
</p>

<code><?php echo htmlspecialchars( $mdl_help) ?></code>
<?php

require $REX['INCLUDE_PATH'].'/layout/bottom.php';
?>