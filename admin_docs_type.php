<?
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2015 -  Pan-American Health Organization / World Health Organization (PAHO/WHO)
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage document+type
 */

require("cab.php");
global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_debug.php');


	/* Dados da Classe */
	require("_ged_documents.php");
	$tabela = $ged->tabela.'_tipo';

	/* Nao alterar - dados comuns */
	$label = msg($tabela);
	$http_edit = 'admin_docs_type_ed.php'; 
	$http_ver = 'admin_docs_type_ver.php'; 
	$editar = True;
	$http_redirect = 'admin_docs_type.php';
	$ged->row();
	$busca = true;
	$offset = 20;

	$pre_where = " doct_ativo = 1 ";
	if ($order == 0) { $order  = $cdf[1]; }
	
	echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');	
	echo '</table>';	
echo '</div>';
echo $hd->foot();		
?> 