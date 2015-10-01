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
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Menssages
 */
require("cab.php");

$file = '../messages/msg_message.php';
if (file_exists($file)) { require($file); }

$tp = new message;
//$tp->language_set('pt_BR');


global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');

//$sql = "delete from _messages where 1=1";
//$rlt = db_query($sql);

	$clx = new message;
	$cp = $clx->cp();
	$tabela = $clx->tabela;
	
	$label = msg("mensagens");
	$http_edit = 'message_ed.php';
	$http_ver = 'message_ed.php'; 
	$editar = True;
	
	//$http_ver = 'cliente_ver.php';
	
	$http_redirect = 'message.php?dd98='.$dd[98].'&dd97='.$dd[97];
	
	$cdf = array('id_msg','msg_field','msg_language','msg_content');
	$cdm = array('cod',msg('field'),msg('language'),msg('content'));
	$masc = array('','','','','','','');
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	
	//$dd[97] = 'pt_BR';
	if (strlen($dd[98]) > 0)
		{ $pre_where = "msg_pag = '".$dd[98]."' "; }
	if (strlen($dd[97]) > 0)
		{ $pre_where = "msg_language = '".$dd[97]."' "; }
	$pre_where = "msg_language = '".$LANG."' ";
	$order  = "msg_pag";
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
	echo '</div>';
	
	

echo $hd->foot();		
?>