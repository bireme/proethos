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

<?php
 /**
  * Sumissão de protocolo de pesquisa
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.12.22
  * @package Class
  * @subpackage UC0001 - Sumissao de protocolo de pesquisa
 */

ECHO '<H1>'.msg('amendment_'.$doc_tipo).'</h1>';
require('submit_00_field.php');

	if (strlen($acao) > 0) 
		{ 
		require('submit_save.php');
		}

echo $s;

require("_class/_class_cep.php");

$cep = new cep;

// data CEP
$cep_recrutamento = $cep->get_cep_recrutamento($proto_cep);

$cp =$cep->cp_monitoreo();

/* Chave ID do register_shutdown_function(function)*/
$dd[0] = $proto_cep;

$form = new form;
require("form_css.php");

$tela = $form->editar($cp, 'cep_protocolos');

if($form->saved > 0) {

    $cep->protocolo = strzero($proto_cep,6);
    $log = $cep->cep_historic_append("CHG", msg("recruiting_" . $dd[2] ) .', ' . msg("date_reclutamiento") . ":" . stodbr($dd[1]));

    redirecina('submit_end_monitoreo_008.php');

} else {
    echo $tela;
}

echo '</table>';

if (($ok > 0) and (strlen($acao) > 0))
	{
		$_SESSION['proj_page'] = ($pag+1);
		redirecina('submit.php?time'.date("dmYhis"));
	}
?>