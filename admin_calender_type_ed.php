<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage calender
 */
require("cab.php");
require("_class/_class_calender.php");

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_form2.php');

	$cl = new calendar;
	$cp = $cl->cp_type();
	$tabela = $cl->tabela_type;
	
	$http_edit = page();
	$http_redirect = '';
	$tit = msg("titulo");

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
			redirecina('admin_calender_type.php');
		}
	echo '</div>';

	echo $hd->foot();
?>
