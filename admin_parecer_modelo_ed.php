<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Dictamen Model
 */
require('cab.php');
require('_class/_class_dictamen.php');

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
$form = new form;
require("form_css.php");

	$cl = new dictamen;
	$cp = $cl->cp_modelo();
	
	$http_edit = 'admin_parecer_modelo_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");


	/** Comandos de Edicao */
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	echo '<table width="100%"><TR><TD>';
	$tela = $form->editar($cp,$tabela);
	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			$cl->updatex();
			redirecina('admin_parecer_modelo.php');
		} else {
			echo $tela;
		}
	echo '</table>';
	echo '</div>';
echo $hd->foot();	
?>

