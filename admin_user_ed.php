<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage user
 */
require("cab.php");

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');

	$cl = new users;
	$cp = $cl->cp_admin();
	$tabela = $cl->tabela;
	
	$http_edit = 'admin_user_ed.php';
	$http_redirect = '';

	/** Comandos de Edicao */
	
	echo '<CENTER><h2>'.msg('users').'</h2></CENTER>';
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('admin_user.php');
		}
	echo '</div>';
echo $hd->foot();
?>
