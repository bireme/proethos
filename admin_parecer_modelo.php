<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage Dictamen Model
 */
require("cab.php");
global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_debug.php');

	/* Dados da Classe */
	require('_class/_class_dictamen.php');

	$clx = new dictamen;
	$cp = $clx->cp_modelo();
	
	/* N�o alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'admin_parecer_modelo_ed.php';
	//$http_ver = 'pibic_bolsa_tipo_detalhe.php'; 
	$editar = True;
	$http_redirect = 'admin_parecer_modelo.php';
	$clx->row_modelo();
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	if ($order == 0) { $order  = $cdf[3].' ,'.$cdf[2]; }

	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
echo '</div>';

echo $hd->foot();		
?> 