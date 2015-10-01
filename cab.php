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


header("Expires: ".gmdate('D, d M Y H:i:s', 0));
require ("db.php");
require ("_db/db_proethos.php");

require ($include . 'sisdoc_debug.php');
/* Sistema de Mensagens */
require ("_class/_class_message.php");
$message = 'messages/msg_' . $LANG . '.php';
if (file_exists($message)) {
	require ($message);
}

/* Security */

/* Logos */
function logo($tp) {
	global $LANG;
	switch ($tp) {
		case '1' :
			$file = 'document/proethos_logo_1.jpg';
			if (file_exists($file))
				{
					return($file);
				} else {
					$file = 'img/logo_dictamen.jpg';
					return($file);
				}
			break;
		case '2' :
			$file = 'document/proethos_logo_1.png';					
			if (file_exists($file))
				{
					return($file);
				} else {
					$file = 'img/proethos_logo_1.png';
					$file = 'img/logo_inst_mini_'.$LANG.'.png';
					return($file);
				}
			break;
		case '3' :
			$file = 'document/proethos_logo_2.png';			
			if (file_exists($file))
				{
					return($file);
				} else {
					$file = 'img/proethos_logo_2.png';
					return($file);
				}
			break;		
	}
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
/* security */
$page = ' ' . page(); 
if (empty($nosec)) { $nosec = ''; }
$nosec = round(strpos($page, 'login.php')) + $nosec;
$nosec = $nosec + round(strpos($page, 'login_new_user.php'));

$sc = $ss -> security();
$su = trim($ss->user_nome);
if (($nosec == 0) and (($sc == false) or (strlen($su)==0))) { redirecina('login.php');
}

/* Build Head */
echo $hd -> head();
require ("cab_menu.php");
require("_email_smtp.php");

echo '<CENTER>';
echo '<DIV id="content">';
?>