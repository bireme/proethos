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

<?
 /**
  * Register Unit
  * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
  * @copyright © Pan American Health Organization, 2013. All rights reserved.
  * @access public
  * @version v.0.13.46
  * @package Proethos
  * @subpackage Ajax
 */
require("db.php");
require($include.'sisdoc_colunas.php');

$ref=$dd[6];
$protocol = $dd[1];
$autor=$dd[3];
$data=$dd[6];
$campo = $dd[4];
$unit = $dd[10];
$number = $dd[11];
$data = $dd[13];

/* Mensagens do sistema */
require("_class/_class_message.php");
$file = 'messages/msg_'.$LANG.'.php';
if (file_exists($file)) { require($file); } else { echo 'message not found '.$file; }

$LANG = $lg->language_read();
$edit_mode = round($_SESSION['editmode']);
require('_class/_class_register_unit.php');
$register = new register_unit;
/**** Funções ****/	
if ($dd[2]=='add') { $register->dados_add($protocol,$unit,$number,$data);  }
if ($dd[2]=='del') { $register->dados_del($protocol,$number); }

/** Mostra os registros e formulario **/

$ops = $register->lista('P');
$op = '';
for ($r=0;$r < count($ops);$r++)
	{
		$op .= '<option value="'.$ops[$r][0].'" class="form_select_option">';
		$op .= $ops[$r][1];
		$op .= '</option>';
	}
$reg_id = $ref_.'_op';
$reg_data = $ref_.'_od';
$linka = 'register_unit_ajax.php?dd1='.$protocol.'&dd2=add&dd9='.$reg_data.'&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
$linkr = 'register_unit_ajax.php?dd1='.$protocol.'&dd2=del&dd9='.$reg_data.'&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
?>
<table width="100%" class="tabela01 lt1" cellspacing="0" cellpadding="3" border=0>
	<TR><TD><?=msg('reg_unit');?></TD><TD><select name="<?=$reg_id;?>a" id="<?=$reg_id;?>a" class="form_select"><?=$op;?></select></TD></TR>
	<TR><TD><?=msg('reg_number');?></TD><td><input type="text" size=20 maxlength="20" id="<?=$reg_id;?>b" class="form_select">
	<TR><TD><?=msg('reg_date');?></TD><td><input type="text" size=10 maxlength="10" id="<?=$reg_id;?>c" class="form_select">
		<input type="button" name="<?=$reg_id;?>z" id="<?=$reg_id;?>z" value="<?=msg('reg_botao');?>"  />
	</td></TR>
</table>
<BR><BR>

<?
/**
 * Listar dados cadastrados de registros
 */
	echo '<table width="100%" class="tabela01" cellspacing="0" cellpadding="3" border=1>';
	echo '<TR><TH>'.msg('register_unit').'</TH><TH>'.msg('number').'</TH><TH>'.msg('data').'</TH>';
	echo '<TH>'.msg('acao');
	echo '</TR>';
	
	$regs = $register->dados_lista($protocol,'P');
	for ($r=0;$r < count($regs);$r++)
		{
			$line = $regs[$r];
			echo '<TR>';
			echo '<TD>'.$line['ru_name'];
			echo '<TD>'.$line['csru_number'];
			echo '<TD>'.$line['csru_data'];
			echo '<TD align="center">';
			$onclick = 'onclick="remove_register('.$line['id_csru'].')" ';
			echo '<img src="img/icone_remove.png" '.$onclick.'>';
		}
	?>
	</table>
<script>
	function remove_register(id)
		{
			var link_call = '<?=$linkr;?>'+ '&dd11='+id;
								 
			var $tela01 = $.ajax(link_call)
				.done(function(data) { $("#<?=$ref;?>").html(data); })
				.always(function(data) { $("#<?=$ref;?>").html(data); });			
		}
	$("#<?=$reg_id;?>z").click(function() 
		{
			var dd10=$("#<?=$reg_id;?>a").val();
			var dd11=$("#<?=$reg_id;?>b").val();
			var dd13=$("#<?=$reg_id;?>c").val();
			var dd12='<?=$dd[1];?>';
			var link_call = '<?=$linka;?>'+ '&dd10='+dd10+'&dd11='+dd11+'&dd13='+dd13+'&dd12='+dd12;;
								 
			var $tela01 = $.ajax(link_call)
				.done(function(data) { $("#<?=$ref;?>").html(data); })
				.always(function(data) { $("#<?=$ref;?>").html(data); });	
		} );
</script>