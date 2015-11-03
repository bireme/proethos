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
 * Admin Menu
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos-Admin
 * @subpackage calender
 */
require ("cab.php");

/* Admin Common */

/* Admin Common */
$ok = (($perfil -> valid('#ADM')));
if ($ok == 0) {
	redirecina('main.php');
}

echo '<h1>Clear Tables of System</h1>';

if ($dd[0] != '1') {echo '<img src="img/icone_alert.png">';
	echo 'All tables will be excluded!';
	echo '<BR>';
	echo 'Confirm? <A href="' . page() . '?dd0=1">YES</A>';

} else {
	$tb = array();
	array_push($tb, 'cep_comment');
	array_push($tb, 'cep_dictamen');
	array_push($tb, 'cep_email');
	array_push($tb, 'cep_ged_documento');
	array_push($tb, 'cep_parecer');
	array_push($tb, 'cep_protocolos');
	array_push($tb, 'cep_protocolos_historic');
	array_push($tb, 'cep_protocol_log');
	array_push($tb, 'cep_submit_country');
	array_push($tb, 'cep_submit_crono');
	array_push($tb, 'cep_submit_documento');
	array_push($tb, 'cep_submit_ged_files');
	array_push($tb, 'cep_submit_documento_valor');
	array_push($tb, 'cep_submit_grupos');
	array_push($tb, 'cep_submit_institution_dados');
	array_push($tb, 'cep_submit_orca');
	array_push($tb, 'cep_submit_register_unit');
	array_push($tb, 'cep_submit_team');
	array_push($tb, 'cep_submit_valor');
	array_push($tb, 'cep_survey');
	array_push($tb, 'cep_team');
	array_push($tb, 'ged_documento');

	for ($r = 0; $r < count($tb); $r++) {
		$sql = "delete from " . $tb[$r] . ' where 1=1 ';
		$rlt = db_query($sql);
		echo '<BR>';
		echo 'Clear ' . $tb[$r];
	}
}
require ("foot.php");
?>