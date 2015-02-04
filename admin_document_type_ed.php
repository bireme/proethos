<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage document+type
 */
 
require('cab.php');

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require('form_css.php');

require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	require("_ged_config.php");
	$tabela = $ged->tabela.'_tipo';
	$cp = $ged->cp();
		
	$http_edit = 'admin_document_type_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edicao */
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	$tela = $form->editar($cp,$tabela);
	
echo '</div>';	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			$ged->updatex();
			redirecina('admin_document_type.php');
		} else {
			echo $tela;
		}
echo $hd->foot();	
?>

