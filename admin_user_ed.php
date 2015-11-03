<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage user
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require('form_css.php');

	$cl = new users;
	$cp = $cl->cp_admin();
	$tabela = $cl->tabela;
	
	$http_edit = 'admin_user_ed.php';
	$http_redirect = '';

	/** Comandos de Edicao */
	
	echo '<CENTER><h2>'.msg('users').'</h2></CENTER>';
	$tela = $form->editar($cp,$tabela);	
	/** Caso o registro seja validado */
	if ($form->saved > 0)
		{
			$cl->updatex();
			redirecina('admin_user.php');
		} else {
			echo $tela;
		}
	echo '</div>';
echo $hd->foot();
?>
