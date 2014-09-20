<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Unit Register
 */
require("cab.php");
require("_class/_class_register_unit.php");

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');

	$cl = new register_unit;
	$cp = $cl->cp();
	$tabela = $cl->tabela;
	
	$http_edit = 'admin_register_unit_ed.php';
	$http_redirect = '';
	$tit = msg("tit_".$cl->tabela);

	/** Comandos de Edi��o */
	
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?	
	
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$cl->updatex();
			redirecina('admin_submit.php');
		}
	echo '</div>';
echo $hd->foot();
?>
