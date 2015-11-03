<?php
 /**
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Menssages
 */
require('cab.php');
require($include.'sisdoc_debug.php');

global $acao,$dd,$cp,$tabela;
require("_class/_class_cep_amendment_type.php");
require($include.'_class_form.php');
$form = new form;
require("form_css.php");

	$cl = new cep_amendment_type;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	
	$http_edit = page();
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edicao */
	
	echo '<CENTER><font class=lt5>'.msg($tabela).'</font></CENTER>';
	$tela = $form->editar($cp,$tabela);
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('admin_cep_amendment_type.php');
		} else {
			echo $tela;
		}
	echo '</div>';
echo $hd->foot();
?>

