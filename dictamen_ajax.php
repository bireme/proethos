<?
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


require("db.php");
require($include.'sisdoc_debug.php');
global $messa;

require('_class/_class_ged.php');
$ged = new ged;

require('_class/_class_cep.php');
$cep = new cep;

require('_class/_class_dictamen.php');
$dict = new dictamen;

/* Mensagens do sistema */
require("_class/_class_message.php");
$edit_mode = round($_SESSION['editmode']);
$file = 'messages/msg_'.$LANG.'.php';
$LANG = $lg->language_read();
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

if (strlen($acao) > 0)
	{
 		$ok = $dict->dictamen_save($dd);

		$proto = $dd[1];
		$caae = $dd[1];
		$cep->caae = $caae;
		$cep->protocolo = $proto;
		$cep->status = 'D';
				
		$cep->cep_historic_append('PAE',msg('emited_dictamen'));
		$dict->protocol = $proto;
				
		$dict->create_pdf($proto);
		$dict->ged_delete_old($proto);
		$dict->save_ged();
				
		$cep->protocolo = $proto;
		$cep->caae = $dd[1];
				
//		$cep->cep_status_alter('E');
		$cep->cep_update_date_dictamen(date("Ymd"));

		echo '</A>';			
		echo '
			<script>
				$(window.location).attr(\'href\', \'protocol_detalhe.php\');
			</script>
		';			
		exit;
	} else {
		$dict->dictamen_recupera($dd);
	}
echo $dict->dictamen_form();
?>