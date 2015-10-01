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


/**
 * Admin Menu
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos-Admin
 * @subpackage committee
 */
 
/* Add Styles */
$style_add = array('proethos_form.css');
require ("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

/* Form Library */
require ($include . '_class_form.php');
$form = new form;
require("form_css.php");

/* Committee Library */
require_once ("_class/_class_committee.php");
$cm = new committee;
$cp = $cm -> cp();

/* Recover ID */
if ($cm -> config_exist()) { $dd[0] = $cm -> id;
}

$tabela = "_committee";
echo '<h2>' . msg("configuration_committe") . '</h2>';
$tela = $form -> editar($cp, $tabela);

if ($form -> saved > 0) {
	$cm -> save_arq();
	echo '<h3>' . msg('saved') . '</h3>';
	redirecina('contact.php');
} else {
	echo $tela;
}

echo '</div>';

echo $hd -> foot();
?>