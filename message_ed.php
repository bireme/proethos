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
require($include.'_class_form.php');
$form = new form;

	$cl = new message;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	
	$http_edit = 'message_ed.php';
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
			redirecina('message.php');
		} else {
			echo '<table width="100%" class="lt1">';
			echo '<tr valign="top">';
			echo '<td>';
			echo $tela;
			echo '<td width="300">';
			echo '<B>'.msg('message_page').'</b><HR>';
			echo $cl->mostra_page($dd[0]);
			echo '</table>';
		}
	echo '</div>';
echo $hd->foot();
?>

