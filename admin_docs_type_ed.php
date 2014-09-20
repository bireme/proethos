<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright Copyright (c) 2012 - sisDOC.com.br
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage document+type
 */
require('cab.php');
$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	require("_ged_documents.php");
	$tabela = $ged->tabela.'_tipo';
	$cp = $ged->cp();
		
	$http_edit = 'admin_docs_type_ed.php';
	$http_ver = 'admin_docs_type_ver.php';
	$http_redirect = '';
	$tit = msg("titulo");

	/** Comandos de Edicao */
	echo '<CENTER><font class=lt5>'.msg('titulo').'</font></CENTER>';
	
	?><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	
	editar();

	echo '</TD></TR></TABLE>';
	echo '</div>';
		
	/** Caso o registro seja validado */
	if ($saved > 0)
		{
			echo 'Salvo';
			$ged->updatex();
			redirecina('admin_docs_type.php');
		}
echo $hd->foot();	
?>

