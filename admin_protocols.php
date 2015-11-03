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

?>

<?php
 /**
  * Admin Menu
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v0.13.46
  * @package ProEthos-Admin
  * @subpackage protocols
 */
require("cab.php");
require('_class/_class_cep.php');

/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok==0) {
	redirecina('main.php');
}

$tp = new message;
//$tp->language_set('pt_BR');


global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_debug.php');

	$clx = new cep;
	$tabela = $clx->tabela;
	
	$label = msg("protocols");
	$http_edit = troca(page(),'.php','_ed.php'); 
	$http = page();
	$editar = True;
	
	$http_redirect = page();
	
	//$http_ver = 'cliente_ver.php';
	$clx->row();	
	$busca = true;
	$offset = 20;
	//$pre_where = " e_mailing = '".$cl->mail_codigo."' ";
	
	
	
	echo '<h1>'.msg('cep_protocol').'</h1>';
	echo '<fieldset><legend>'.msg('protocol').'</legend>';
	echo '<TABLE width="100%" align="center"><TR><TD>';
	require($include.'sisdoc_row.php');
	
	echo '</table>';
	echo '</fieldset>';
		
	echo '</div>';

echo $hd->foot();		
?> 
<script>
	
</script>