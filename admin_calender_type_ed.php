<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage calender
 */
require("cab.php");
require("_class/_class_calender.php");

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'_class_form.php');
$form = new form;
require("form_css.php");

	$cl = new calendar;
	$cp = $cl->cp_type();
	$tabela = $cl->tabela_type;
	
	$http_edit = page();
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edicao */
	
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	$tela = $form->editar($cp,$tabela);
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			$cl->updatex();
			redirecina('admin_calender_type.php');
		} else {
			echo $tela;
		}
	echo '</div>';

	echo $hd->foot();
?>
