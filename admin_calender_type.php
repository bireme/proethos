<?
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

require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');

ini_set('display_errors', 255);
ini_set('error_reporting', 255);

	require("_class/_class_calender.php");
	$clx = new calendar;
	$tabela = $clx->tabela_type;
	
	$label = msg('tit_'.$tabela);
	$http_edit = 'admin_calender_type_ed.php'; 
	$editar = True;
	
	$http_ver = '';
	
	$http_redirect = page().'?dd98='.$dd[98].'&dd97='.$dd[97];
	
	$clx->row_type();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	
	$order  = "";
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
	echo '</div>';

	echo $hd->foot(); 
?>