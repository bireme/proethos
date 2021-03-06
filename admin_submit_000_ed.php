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

require("cab.php");

/* Recupera tipo do formulario */
$adm = $_SESSION['admin_amendment'];
if (strlen($adm) == 0)
	{
		return('admin.php');
	}

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}


require("_class/_class_submit_manuscrito_field.php");

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require("form_css.php");

echo '<h1>'.msg('amendment_'.$adm).'</h1>';
$dd[12] = strzero($adm,5);

	$cl = new fields;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	$http_edit = 'admin_submit_ed.php';
	$http_redirect = '';

	/** Comandos de Edicao */
	
	$tela = $form->editar($cp,$tabela);	
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('admin_submit_000.php');
		} else {
			echo $tela;
		}
	echo '</div>';
echo $hd->foot();
?>