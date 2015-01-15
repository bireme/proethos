<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage protocols
 */
require("cab.php");
require("_class/_class_cep.php");

global $acao,$dd,$cp,$tabela;
require($include.'_class_form.php');
$form = new form;
require($include.'sisdoc_data.php');

	$cl = new cep;
	$cp = $cl->cep_manual();
	$tabela = $cl->tabela;
	
	$http_edit = page();
	$http_redirect = '';
	

	/** Comandos de Edicao */
	
	$tela = $form->editar($cp,$tabela);

	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('admin_protocols.php');
		} else {
			echo $tela;
		}
	echo '</div>';
echo $hd->foot();
?>
