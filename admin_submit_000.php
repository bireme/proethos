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
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Unit Register
 */
require("cab.php");

if (strlen($dd[90])>0)
	{
		$_SESSION['admin_amendment'] = $dd[90];
		$adm = $dd[90];
	} else {
		$adm = $_SESSION['admin_amendment'];
	}
if (strlen($adm) == 0)
	{
		return('admin.php');
	}
/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}


/* Redireciona se 008 */
if ($adm == '008')
	{
		redirecina('admin_submit_blocked.php');
		exit;
	}
require("_class/_class_submit_manuscrito_field.php");

	/* Dados da Classe */
	$clx = new fields;
	$tabela = $clx->tabela;
	
	echo '<h1>'.msg('amendment_'.$adm).'</h1>';
	
	/* Nao alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'admin_submit_000_ed.php'; 
	//$http_ver = 'pibic_bolsa_tipo_detalhe.php'; 
	$editar = True;
	$http_redirect = page();
	$clx->row();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	if ($order == 0) { $order  = $cdf[1]; }
	
	$order = ' sub_pag, sub_pos, sub_ordem ';
	
	$pre_where = " sub_projeto_tipo = '".strzero($adm,5)."' ";
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';
	echo '</div>';

echo $hd->foot();
?>