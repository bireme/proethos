<?php
require("db.php");
ini_set('display_errors', 255);
ini_set('error_reporting', 255);
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

require($include.'sisdoc_data.php');

$check = $dd[90];
$chk = checkpost($dd[0].$secu);

if ($check == $chk)
	{
	require("submit_pdf_projeto.php");
	} else {
		echo '<font color="red">CSRF Injection</font>';
	}
?>
