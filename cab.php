<?php
require("db.php");
require("_db/db_proethos.php");

/* Sistema de Mensagens */
require("_class/_class_message.php");
$message = 'messages/msg_'.$LANG.'.php';
if (file_exists($message)) { require($message); }

/* Security */
/* User Class */
require('_class/_class_user.php');
$ss = new users;

require('_class/_class_user_perfil.php');
$perfil = new user_perfil;

/* Header Class */
require("_class/_class_header_proethos.php");
$hd = new header;


/* security */
$page = ' '.page();
$nosec = round(strpos($page,'login.php')) + $nosec;
$nosec = $nosec + round(strpos($page,'login_new_user.php'));


$sc = $ss->security();
if (($nosec == 0) and ($sc == false))
	{ redirecina('login.php'); }

/* Build Head */
echo $hd->head();
require("cab_menu.php");

echo '<CENTER>';
echo '<DIV id="content">';
?>
