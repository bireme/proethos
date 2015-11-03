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
require($include.'_class_form.php');
require($include.'sisdoc_data.php');
$form = new form;

require("form_css.php");

	$cl = new calendar;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	$http_edit = page();
	$http_redirect = '';
	$label = msg('tit_'.$tabela);

	/** Edit */
	
	echo '<h2>'.$label.'</h2>';
	$tela = $form->editar($cp,$tabela);
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			redirecina('admin_calender.php');
		} else {
			echo $tela;
		}

echo $hd->foot();
?>
