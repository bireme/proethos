<?php
 /**
  * Scheduled Popup
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Scheduled
 */
require ("db.php");
require ("_db/db_proethos.php");

require ($include . 'sisdoc_debug.php');
/* Sistema de Mensagens */
require ("_class/_class_message.php");
$message = 'messages/msg_' . $LANG . '.php';
if (file_exists($message)) {
	require ($message);
}

/* User Class */
require ('_class/_class_user.php');
$ss = new users;

require ('_class/_class_user_perfil.php');
$perfil = new user_perfil;

/* Header Class */
require ("_class/_class_header_proethos.php");
$hd = new header;
/* load configuration committe */
$hd->load_committe();

echo $hd->head();

//* Class Printer */
require($include.'sisdoc_email.php');

//* Class Printer */
require('_class/_class_printer.php');
$pr = new printer;

require($include.'sisdoc_data.php');
/* Mensagens do sistema */

require("_class/_class_meeting.php");
$mt = new meeting;

$data = round($dd[1]);
$pag = round($dd[2]);

$sx .= '<div id="content">';
$sx .= $mt->mostra($data,$pag);
$sx .=  '</div>';

echo $pr->view($sx);
	
?>
