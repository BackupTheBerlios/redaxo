<?php

/** 
 * Layout Fuß des Backends
 * @package redaxo3
 * @version $Id: bottom.php,v 1.7 2007/02/21 18:12:15 kills Exp $
 */
 
if (!(isset( $open_header_only) && $open_header_only == true)):
?>

	</div>
<!-- *** OUTPUT OF CONTENT - END *** -->

</div><!-- END #rex-wrapper -->
	
	<div id="rex-ftr">
		<ul>
			<li><a href="http://www.pergopa.de" target="_blank" class="black">pergopa kristinus gbr</a> | </li>
      <li><a href="http://www.redaxo.de" target="_blank" class="black">redaxo.de</a> | </li>
      <li><a href="http://forum.redaxo.de">?</a></li>
		</ul>
		<p><?php echo showScripttime() ?> sec | <?php echo rex_formatter :: format(time(), 'strftime', 'date'); ?></p>
	</div>
<?php
endif;
?>
   </body>
</html>