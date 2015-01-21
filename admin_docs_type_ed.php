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
$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;

require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	require("_ged_documents.php");
	$tabela = $ged->tabela.'_tipo';
	$cp = $ged->cp();
		
	$http_edit = 'admin_docs_type_ed.php';
	$http_ver = 'admin_docs_type_ver.php';
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
			redirecina('admin_docs_type.php');
		} else {
			echo $tela;
		}
echo $hd->foot();	
?>

