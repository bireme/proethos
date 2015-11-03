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

?>

<?
 /**
  * Protocol
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */
require('db.php');

/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
$LANG = $lg->language_read();

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require('form_css.php');
require($include.'sisdoc_debug.php');
require($include.'sisdoc_data.php');

/* Mensagens do sistema */
//require("_class/_class_message.php");
//$file = 'messages/msg_'.$LANG.'.php';
//$LANG = $lg->language_read();

?><head>
	<title>::CIP::</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="http://cip.pucpr.br/favicon.ico" />
	<link rel="STYLESHEET" type="text/css" href="../css/letras.css">
	<link rel="STYLESHEET" type="text/css" href="css/support.css">
	<script language="JavaScript" type="text/javascript" src="../js/jquery-1.7.1.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/jquery.corner.js"></script>
</head><?

$cp = array();
$tabela = "cep_protocolos";
array_push($cp,array('$H8','id_cep','',False,True));
array_push($cp,array('$M','',msg('nr_dictames_inf'),False,True));
array_push($cp,array('$[0-10]','cep_dictamen',msg("nr_dictames"),True,True));

$tela = $form->editar($cp,$tabela);
echo $tela;

if ($form->saved > 0) { require("close.php"); }
?>