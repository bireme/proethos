<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt


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