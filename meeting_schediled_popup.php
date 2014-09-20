<?php
 /**
  * Scheduled Popup
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Scheduled
 */
require("db.php");
?>
<head>
	<title>:: <?php echo $institution_name;?> :: ProEthos ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset;?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $institution_site;?>favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/letras_pr.css" />
</head>
<?
/* Class Printer */
require('_class/_class_printer.php');
$pr = new printer;

require($include.'sisdoc_data.php');
/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
$LANG = $lg->language_read();
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

require("_class/_class_meeting.php");
$mt = new meeting;

$data = round($dd[1]);
$pag = round($dd[2]);

$sx .= '<div id="content">';
$sx .= $mt->mostra($data,$pag);
$sx .=  '</div>';

echo $pr->view($sx);
	
?>
