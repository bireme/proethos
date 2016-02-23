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

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}


require("_class/_class_submit_manuscrito_field.php");

	/* Dados da Classe */
	$clx = new fields;
	$tabela = $clx->tabela;
	
	$pag = round('0'.$dd[10]);
	if ($pag < 2) { $pag = 2; } 
	if ($pag > 7) { $pag = 7; }
	
	/* Nao alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'admin_submit_1_ed.php'; 
	//$http_ver = 'pibic_bolsa_tipo_detalhe.php'; 
	$editar = True;
	$http_redirect = 'admin_submit_1.php';
	$clx->row2();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	if ($order == 0) { $order  = $cdf[1]; }
	
	$order = ' sub_pag, sub_pos, sub_ordem ';
	
	/* SQL Filter */
	$pre_where = " sub_projeto_tipo = '00001' ";
	$pre_where .= " AND sub_pag = '".$pag."' ";
	
	/* Mostra páginas */
	echo '<table width="100%" class="tabela00" cellspacing="20">';
	for ($r=1;$r <= 7;$r++)
		{
			$bg = '';
			if ($r==$pag)
					{
						$bg = "bg_silver";
					}
			$link = '<A href="admin_submit_1.php?dd10='.$r.'" class="link lt6">';
			echo '<td class="lt0 border1 pad5 radius5 '.$bg.'" align="center">'.msg('submit_page').'<br>'.$link.$r.'</a></td>';
		}
	echo '</table>';
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_fld.php');	
	echo '</table>';
	echo '</div>';

echo $hd->foot();
?>