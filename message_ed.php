<?php
 /**
  * Menssages
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2013 - sisDOC.com.br
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Menssages
 */
require('cab.php');
$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'_class_form.php');
$form = new form;

	$cl = new message;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	
	$http_edit = 'message_ed.php';
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edição */
	
	echo '<CENTER><font class=lt5>'.msg($tabela).'</font></CENTER>';
	$tela = $form->editar();
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('message.php');
		}
	echo '</div>';
echo $hd->foot();
?>

