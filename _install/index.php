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


require("cab_install.php");
require("_class_install.php");
$inst = new install;

/* Header */
echo '<h1>Config at Data Base</h1>';

/* Check if directory exist */
$chk = $inst->check_directory_privileges('../_db');

/* Mostrar erro se $chk for diferente de 1 */
if ($chk != 1)
	{
		echo '<div class="erro">';
		echo $chk;
		echo '</div>';
		exit;
	}

/* Formulario */
require($include."_class_form.php");
$form = new form;

/* Formulário Campos */
$ops = '';
$ops .= ' : ';
$ops .= '&mysql:MYSQL';
$ops .= '&mysqlPDO:MySQL(PDO)';
$cp = array();
array_push($cp,array('$H8','','',False,True));
array_push($cp,array('$O '.$ops,'','Base type',False,True));
array_push($cp,array('$S40','','Database host',False,True));
array_push($cp,array('$S30','','Database name',False,True));
array_push($cp,array('$S30','','User name',False,True));
array_push($cp,array('$P30','','Password',False,True));

/* param */
$form->ajax = 1;
$form->frame = 'answer';
$form->form_name = 'answer';

$tela = $form->editar($cp,'');
echo $tela;

echo '<div id="answer">';
echo '<div id="answer_main"></div>';
echo '<div id="config_file"></div>';
echo '</div>';

?>