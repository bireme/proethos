<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage calender
 */
require("cab.php");

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

/* Load Library */
require($include.'sisdoc_data.php');

/* Load class */
	require("_class/_class_calender.php");
	$clx = new calendar;
	$tabela = $clx->tabela;
	
	$label = msg('tit_'.$tabela);
	$http_edit = 'admin_calender_ed.php'; 
	$editar = True;
	
	$http_ver = '';
	
	$http_redirect = page().'?dd98='.$dd[98].'&dd97='.$dd[97];
	
	$clx->row();
	$busca = true;
	$offset = 20;
	$order = " cal_date desc ";
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";

	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
	echo '</div>';

	echo $hd->foot(); 
?>