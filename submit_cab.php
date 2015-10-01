<?
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


echo '<div class="proto_menu">';
$edit_mode_old = $edit_mode; 

$cls = array('','prevStep','currentStep','','','','','','','','');
$cls = array('','','','','','','','','','','');

$ini = $pag;

for ($r=0;$r <= $ini;$r++) {$cls[$r] = 'prevStep'; }
$cls[$ini] = 'currentStep';
echo '<table width="100%" cellpadding=0 cellspacing=0 border=0 class="lt1">';

/* informa o total de paginas do Header */
/* Old - for ($r=1;$r < 7;$r++) */ 

for ($r=1;$r <= $tot_paginas;$r++)
	{
		//$edit_mode = True;
		if ($doc_tipo != 'PROJE')
			{
				/* Label para monitoreo */
				$op = msg("top_submit_".$doc_tipo."_".$r);
			} else {
				/* Label para projeto */
				$op = msg("top_submit_menu_".$r);		
			}
		
		$name="item".$r;
		$class_name="topmenu_off";
		if ($ini == $r) { $class_name = 'topmenu_on'; }
		echo '<TD align="center" class="'.$class_name.'" height=30>';
		if ($protocolo != '0000000') { echo '<A HREF="submit.php?dd91='.$r.'">'; }
		echo '<center><font class="'.$class_name.'">';
		echo $op; 
		echo '</A></center>';
		echo '<TD class="'.$class_name.'" width="20">';
		echo '<img src="img/topmenu_sp.png">';
	}
echo '</table>';
$edit_mode = $edit_mode_old;

/* Omite título se não for projeto */
if ($doc_tipo == 'PROJE')
	{
		echo '<H1>'.msg("submit_process").'</h1>';
	}

/* Le dados do protocolo */
$proj->le($protocolo);

/* Classe que mostra os dados do protocolo */
echo $proj->protocolo_mostrar();

$proto_cep = strzero($_SESSION['proto_cep'], 7);

// print "<pre>";
// var_dump($proj);

$clinic = round($proj->doc_clinic);
?>