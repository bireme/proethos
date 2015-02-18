<?php
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
