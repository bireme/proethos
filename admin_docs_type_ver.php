<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
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
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	require("_ged_documents.php");

$ged->protocol  = strzero($dd[0],7);
$type = strzero($dd[0],5);
$protocol = $ged->protocol;

echo '<h2>'.msg('documents_title').'</h2>';
echo $ged->file_list();

echo $ged->upload_botton_with_type($protocol,'_ged_documents.php',$type,'');
echo '</div>';	
	/** Caso o registro seja validado */
echo $hd->foot();	
?>

