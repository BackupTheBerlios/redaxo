<?php

/**
 * TinyMCE Addon
 *  
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * 
 * @author Dave Holloway
 * @author <a href="http://www.GN2-Netwerk.de">www.GN2-Netwerk.de</a>s
 * 
 * @package redaxo3
 * @version $Id: index.inc.php,v 1.11 2007/05/07 14:06:17 tbaddade Exp $
 */

include $REX['INCLUDE_PATH']."/layout/top.php";

$subline = '
<ul>
  <li><a href="http://tinymce.moxiecode.com" target="_blank">'.$I18N_A52->msg('website').'</a> | </li>
  <li><a href="http://tinymce.moxiecode.com/tinymce/docs/index.html" target="_blank">'.$I18N_A52->msg('documentation').'</a> | </li>
  <li><a href="http://tinymce.moxiecode.com/tinymce/docs/reference_plugins.html" target="_blank">'.$I18N_A52->msg('list_of_plugins').'</a></li>
</ul>
';

rex_title($I18N_A52->msg('title'), $subline);

$install = rex_get('install', 'string');
if($install != '')
{
	include_once $REX['INCLUDE_PATH'] . '/addons/tinymce/functions/function_pclzip.inc.php';


	switch ($install) {
  	case 'compressor': 
  	{
  		rex_a52_extract_archive('include/addons/tinymce/js/tinymce_compressor.zip');
  		break;
  	}
  	case 'spellchecker': 
  	{
  		rex_a52_extract_archive('include/addons/tinymce/js/tinymce_spellchecker.zip');
  		break;
  	}
  }
}


$mdl_1 =<<<EOD
<?php
if (REX_IS_VALUE[1]) 
{
  \$editor=new tiny2editor();
  \$editor->id=1;
  \$editor->content="REX_VALUE[1]";
  \$editor->show();
}
?>
EOD;



$mdl_2 =<<<EOD
<?php
if (REX_IS_VALUE[1]) 
{
  \$editor1=new tiny2editor();
  \$editor1->id=1;
  \$editor1->content="REX_VALUE[1]";
  \$editor1->editorCSS = "../files/tinymce/content.css";
  \$editor1->disable="justifyleft,justifycenter,justifyright,justifyfull";
  \$editor1->buttons3="tablecontrols,separator,search,replace,separator,print";
  \$editor1->add_validhtml="img[myspecialtag]";
  \$editor1->show();

  \$editor2=new tiny2editor();
  \$editor2->id=2;
  \$editor2->content="REX_VALUE[2]";
  \$editor2->show();

}
?>
EOD;



$mdl_3 =<<<EOD
<?php
if (REX_IS_VALUE[1]) 
{
  echo '<div class="section">';
  \$content =<<<EOD
  REX_HTML_VALUE[1]
  EOD;
  
  if (\$REX['REDAXO'])
  {
    \$content=str_replace('src="files/','src="../files/',\$content);
    echo '<link rel="stylesheet" type="text/css" href="../files/tinymce/content.css" />';
  }
  echo \$content;
  echo '</div>';
}
?>
EOD;


?>

<div class="rex-addon-output">
	<h2><?php echo $I18N_A52->msg('install_extensions'); ?></h2>

	<div class="rex-addon-content">
		
		<p>
			<a href="?page=tinymce&amp;install=compressor">GZip Compressor</a>
			<br />
			<a href="?page=tinymce&amp;install=spellchecker">Spellchecker</a>
		</p>
	</div>
	
	<h2><?php echo $I18N_A52->msg('moduleinput_simple'); ?></h2>

	<div class="rex-addon-content">
		<?php highlight_string($mdl_1); ?>
	</div>

<h2><?php echo $I18N_A52->msg('moduleinput_extends'); ?></h2>

	<div class="rex-addon-content">
		<?php highlight_string($mdl_2); ?>
	</div>

<h2><?php echo $I18N_A52->msg('moduleoutput'); ?></h2>

	<div class="rex-addon-content">
		<?php highlight_string($mdl_3); ?>
	</div>

	<div class="rex-addon-content">
		<p>
			<a href="http://www.gn2-netwerk.de">GN2-Netwerk</a>
			<br />
			<a href="http://www.public-4u.de">Public-4u e.K.</a>
		</p>
	</div>

<?php

include $REX['INCLUDE_PATH']."/layout/bottom.php";

?>