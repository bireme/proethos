<?php
require("cab.php");
require("_class/_class_submit_manuscrito_field.php");

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require("form_css.php");

echo '<h1>'.msg('amendment_003').'</h1>';
$dd[12] = '00003';

	$cl = new fields;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	$http_edit = 'admin_submit_ed.php';
	$http_redirect = '';

	/** Comandos de Edicao */
	
	$tela = $form->editar($cp,$tabela);	
	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('admin_submit_003.php');
		} else {
			echo $tela;
		}
	echo '</div>';
echo $hd->foot();
?>
