<?php
// This file is part of the ProEthos Software. 
// 
// Copyright 2013, PAHO. All rights reserved. You can redistribute it and/or modify
// ProEthos under the terms of the ProEthos License as published by PAHO, which
// restricts commercial use of the Software. 
// 
// ProEthos is distributed in the hope that it will be useful, but WITHOUT ANY
// WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
// PARTICULAR PURPOSE. See the ProEthos License for more details. 
// 
// You should have received a copy of the ProEthos License along with the ProEthos
// Software. If not, see
// https://raw.githubusercontent.com/bireme/proethos/master/LICENSE.txt


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

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

$ln = new message;

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

	require("_ged_documents.php");
	
/* Excluir Arquivo */
if ($dd[21]=='DEL')
	{
		$chk = checkpost($dd[20].$secu);
		if ($dd[22]==$chk)
			{
				$ged->id_doc = $dd[20];
				$ged->file_delete();
			}
	}

$ged->protocol  = strzero($dd[0],7);
$type = strzero($dd[0],5);
$protocol = $ged->protocol;

//file_delete

echo '<h2>'.msg('documents_title').'</h2>';
echo $ged->file_list();

echo $ged->upload_botton_with_type($protocol,'_ged_documents.php',$type,'');
echo '</div>';	
	/** Caso o registro seja validado */
echo $hd->foot();	
?>