<?php

/**
 * PHPMailer Addon
 *  
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 * 
 * 
 * @package redaxo4
 * @version $Id: example.inc.php,v 1.1 2008/03/26 13:34:13 kills Exp $
 */

$mdl_ex =<<<EOD
<?php

\$mail = new rex_mailer();
\$sql = new rex_sql();

\$query  = "SELECT full_name, email, photo FROM employee WHERE id=\$id";
\$sql->setQuery(\$query);

for(\$i = 0; \$i < \$sql->getRows(); \$i++)
{
    // HTML body
    \$body  = "Hello <font size=\"4\">" . \$sql->getValue("full_name") . "</font>, <p>";
    \$body .= "<i>Your</i> personal photograph to this message.<p>";
    \$body .= "Sincerely, <br />";
    \$body .= "phpmailer List manager";

    // Plain text body (for mail clients that cannot read HTML)
    \$text_body  = "Hello " . \$sql->getValue("full_name") . ", \\n\\n";
    \$text_body .= "Your personal photograph to this message.\\n\\n";
    \$text_body .= "Sincerely, \\n";
    \$text_body .= "phpmailer List manager";

    \$mail->Body    = \$body;
    \$mail->AltBody = \$text_body;
    \$mail->AddAddress(\$sql->getValue("email"), \$sql->getValue("full_name"));
    \$mail->AddStringAttachment(\$sql->getValue("photo"), "YourPhoto.jpg");

    if(!\$mail->Send())
        echo "There has been a mail error sending to " . \$sql->getValue("email") . "<br>";

    // Clear all addresses and attachments for next loop
    \$mail->ClearAddresses();
    \$mail->ClearAttachments();
    
    \$sql->next();
}

?>
EOD;


?>
<div class="rex-addon-output">
	<h2><?php echo $I18N_A93->msg('example_headline'); ?></h2>
	<div class="rex-addon-content">
		<?php highlight_string($mdl_ex); ?>
	</div>
</div>