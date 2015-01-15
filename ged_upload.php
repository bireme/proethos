<?
    /**
     * Ged - upload file
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
	 * @access public
     * @version v0.11.29
	 * @package index
	 * @subpackage ged
    */
    
require("db.php");
require($include.'sisdoc_debug.php');

//require($include.'sisdoc_windows.php');
/* Mensagens do sistema */
require("_class/_class_message.php");
$LANG = $lg->language_read();

$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }
$edit_mode = round($_SESSION['editmode']);
?>
<head>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<title>:: Upload - GED ::</title>
</head>
<style>
body
	{
	font-family:Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 130%;
	}
</style>

<?php
	/* Mensagens */
	$tabela = 'ged_upload';
	$link_msg = 'messages/msg_'.$tabela.'.php';
	if (file_exists($link_msg)) { require($link_msg); }
	
$tipo = $dd[3];
$compl = trim($dd[5]);
if (file_exists($compl))
	{
		require($compl);
	} else {
		require("_ged_config.php");
	}
echo $ged->file_attach_form();
?>
