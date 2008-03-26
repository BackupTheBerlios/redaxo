<?php

/** 
 * Zeit Funktionen  
 * @package redaxo3 
 * @version $Id: function_rex_time.inc.php,v 1.1 2008/03/26 13:35:36 kills Exp $ 
 */ 

function showScripttime()
{
	global $scriptTimeStart;
	$scriptTimeEnd = getCurrentTime();
	$scriptTimeDiv = intval(($scriptTimeEnd - $scriptTimeStart)*1000)/1000;
	return $scriptTimeDiv;
}

function getCurrentTime()
{ 
	$time = explode(" ",microtime()); 
	return ($time[0]+$time[1]);
} 

function startScripttime()
{
	global $scriptTimeStart;
	$scriptTimeStart = getCurrentTime();
}

startScripttime();

?>