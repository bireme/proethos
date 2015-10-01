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
 * Protocol
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v.0.13.46
 * @package Proethos
 * @subpackage Protocol
 */
require ("cab.php");

/* Date Library */
require ($include . 'sisdoc_data.php');

/* CEP Class */
require ("_class/_class_cep.php");
$cep = new cep;

$ok1 = (($perfil -> valid('#ADM')) or ($perfil -> valid('#MAS')) or ($perfil -> valid('#MEM')) or ($perfil -> valid('#SCR')));
$ok2 = (($perfil -> valid('#ADC')) and ($dd[1] == 'Z'));

if ($ok1 or $ok2) {
	
	/* Protocolos de pesquisa */
	$sx = $cep -> protocolos_avaliacao($dd[1], 'PRO');
	if (strlen($sx) > 0) {
		echo '<H2>' . msg('protocolos') . '</h2>';
		echo '<H4>' . msg('cep_status_' . $dd[1]) . '</h4>';
		echo $sx;
		echo '<BR>';
	}

	/* Monitoreo */
	$sx = $cep -> protocolos_avaliacao($dd[1], 'AME');
	if (strlen($sx) > 0) {
		echo '<h2>' . msg('monitoreo_protocolos') . '</h2>';
		echo '<H4>' . msg('cep_status_' . $dd[1]) . '</h4>';
		echo $sx;
	}
}

echo '</div>';

echo $hd -> foot();
?>
<script></script>