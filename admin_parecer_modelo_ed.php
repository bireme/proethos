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
  * @subpackage Dictamen Model
 */
require('cab.php');

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

require('_class/_class_dictamen.php');

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
$form = new form;
require("form_css.php");

	$cl = new dictamen;
	$cp = $cl->cp_modelo();
	
	$http_edit = 'admin_parecer_modelo_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");


	/** Comandos de Edicao */
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	echo '<table width="100%"><TR><TD>';
	$tela = $form->editar($cp,$tabela);
	
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo "SALVO";
			$cl->updatex();
			redirecina('admin_parecer_modelo.php');
		} else {
			echo $tela;
		}
	echo '</table>';
	echo '</div>';
echo $hd->foot();	
?>