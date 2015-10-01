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
  * Protocol
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Protocol
 */
require("cab.php");
require($include.'sisdoc_data.php');
require('_class/_class_oms.php');

require('_class/_class_cep.php');
$cep=new cep;

require('_class/_class_cep_submit.php');
$submit=new submit;

require('_class/_class_cep_email.php');
$comm = new comunication;

$ID = strzero($dd[0],7);
$submit->le($ID);

/* ACtion */
$acao = $dd[5];
if ($acao == 'TO_SUBMIT')
	{
		$submit->protocolo_to_submit();
		redirecina('submit.php?dd0='.$dd[0].'&dd90='.checkpost($dd[0])); 
	}


echo $submit->protocolo_mostrar();
$status = trim($submit->doc_status);

echo '<BR>';
echo '<h2>'.msg('status').': '.msg('caption_status_'.$status).'</h2>';
echo '<BR>';
require("_ged_config.php");
$ged->protocol = $ID;
echo $ged->filelist();


if (trim($status) == '$')
	{
	echo '<Table width="100%">';
	echo '<TR><TD class="lt1">'.msg('message_$_inf');
	echo '</table>';
	
	echo '<form method="post">';
	echo '<input type="hidden" name="dd0" value="'.$dd[0].'">';
	echo '<input type="hidden" name="dd1" value="'.$dd[1].'">';
	echo '<input type="hidden" name="dd2" value="'.$dd[2].'">';
	echo '<input type="hidden" name="dd5" value="TO_SUBMIT">';
	echo '<input type="submit" value="'.msg('submit_send_to_edit',1).'" class="form_submit">';
	echo '</form>';
	}

$comm->protocolo = $submit->doc_protocolo;
echo $comm->display();

echo '</div>';
echo $hd->foot();
?>
<script>
	
</script>