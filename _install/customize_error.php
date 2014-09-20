<?php
set_error_handler("errorHandler");
register_shutdown_function("shutdownHandler");

function errorHandler($error_level, $error_message, $error_file, $error_line, $error_context) {
	$error = '<FONT COLOR="RED"><B>ERROR</B></font>';
	$er = '';
	$er .= $error_message;
	$er .= $error_file;
	$er .= $error_line;
	//$er .= $error_context;
	
	switch ($error_level) {
		case E_ERROR :
		case E_CORE_ERROR :
		case E_COMPILE_ERROR :
		case E_PARSE :
			log_erro($error, "fatal");
			break;
		case E_USER_ERROR :
		case E_RECOVERABLE_ERROR :
			log_erro($error, "error");
			break;
		case E_WARNING :
		case E_CORE_WARNING :
		case E_COMPILE_WARNING :
		case E_USER_WARNING :
			log_erro($error, "warn");
			break;
		case E_NOTICE :
		case E_USER_NOTICE :
			log_erro($error, "info");
			break;
		case E_STRICT :
			log_erro($error, "debug");
			break;
		default :
			log_erro($error, "warn", $er);
	}
}

function shutdownHandler()//will be called when php script ends.
{
	$lasterror = error_get_last();
	switch ($lasterror['type']) {
		case E_ERROR :
		case E_CORE_ERROR :
		case E_COMPILE_ERROR :
		case E_USER_ERROR :
		case E_RECOVERABLE_ERROR :
		case E_CORE_WARNING :
		case E_COMPILE_WARNING :
		case E_PARSE :
			$error = '<FONT COLOR="RED"><B>ERROR</B></font>' . "<BR>msg:" . $lasterror['message'];
			$error .= $error_file;
			$error .= $error_line;
			$error .= $error_context;
			
			log_erro($error, "fatal");
			exit;
	}
}

function log_erro($s1, $s2 , $s3='') {
	echo $s1;
	echo '<HR>';
	switch ($s2)
		{
		case 'fatal': echo '<font class="font_error_big">FATAL ERROR</font>' ; break;
		case 'warn': echo '<font class="font_error_big">ALERT</font> '.$s3; break;
		default: echo '<font class="font_error_big">'.$s2.'</font> '; break;
		}
	exit;
}
?>