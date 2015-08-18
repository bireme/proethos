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

/* Chave ID do registro*/
$dd[0] = $proto_cep;

$form = new form;
$tela = $form->editar($cp, 'cep_protocolos');

if($form->saved > 0) {

    $cep->protocolo = strzero($proto_cep,6);
    $log = $cep->cep_historic_append("CHG", msg("recruiting_" . $dd[2] ) .', ' . msg("date_reclutamiento") . ":" . stodbr($dd[1]));

    redirecina('submit_end_monitoreo_008.php');

} else {
    echo $tela;
}

echo '<TR><TD colspan=2>'; 
require('submit_pages.php');
echo '</table>';

if (($ok > 0) and (strlen($acao) > 0))
	{
		$_SESSION['proj_page'] = ($pag+1);
		redirecina('submit.php?time'.date("dmYhis"));
	}
?>
