<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Unit Register
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}


require("_class/_class_submit_manuscrito_field.php");

	/* Dados da Classe */
	$clx = new fields;
	$tabela = $clx->tabela;
	
	/* Nao alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'admin_submit_1_ed.php'; 
	//$http_ver = 'pibic_bolsa_tipo_detalhe.php'; 
	$editar = True;
	$http_redirect = 'admin_submit_1.php';
	$clx->row();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	if ($order == 0) { $order  = $cdf[1]; }
	
	$order = ' sub_pag, sub_pos, sub_ordem ';
	
	$pre_where = " sub_projeto_tipo = '00001' ";
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';
	echo '</div>';

echo $hd->foot();
?>
