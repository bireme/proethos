<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage IComunication
 */
require('cab.php');

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

require('_class/_class_ic.php');

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require('form_css.php');

require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	$cl = new ic;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	$http_edit = 'admin_ic_ed.php';
	$http_redirect = '';
	$tit = msg("tit".$tabela);
	
	/** Comandos de Edicao */
	$tela = $form->editar($cp,$tabela);

	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			//$cl->updatex();
			redirecina('admin_ic.php');
		} else {
			echo $tela;
		}
echo $hd->foot();	
?>

