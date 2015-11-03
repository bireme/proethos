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
require("db.php");
require("_class/_class_message.php");
require($include.'sisdoc_colunas.php');
$ref=$dd[6];
$protocol = $dd[1];
$autor=$dd[3];
$campo = $dd[4];
$unit = $dd[10];
$number = $dd[11];

$file = '../messages/msg_'.page();
if (file_exists($file)) { require($file); }

require('_class/_class_team.php');
$team = new team;

/**** Funções ****/	
if ($dd[2]=='add') { $team->dados_add($protocol,$unit,$number);  }
if ($dd[2]=='del') { $team->dados_del($protocol,$number); }

/** Mostra os registros e formulario **/

$ops = $team->lista();
$op = '';
for ($r=0;$r < count($ops);$r++)
	{
		$op .= '<option value="'.$ops[$r][0].'">';
		$op .= $ops[$r][1];
		$op .= '</option>';
	}
	
$ops = $team->lista_action();
$opa = '';
for ($r=0;$r < count($ops);$r++)
	{
		$opa .= '<option value="'.$ops[$r][0].'">';
		$opa .= msg($ops[$r][1]);
		$opa .= '</option>';
	}
	
$reg_id = $ref_.'_op';
$linka = 'register_unit_ajax.php?dd1='.$protocol.'&dd2=add&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
$linkr = 'register_unit_ajax.php?dd1='.$protocol.'&dd2=del&dd3='.$autor.'&dd4='.$campo.'&dd6='.$ref.'&dd90='.checkpost($protocol.$campo);
?>
<table width="100%" class="lt1" cellspacing="0" cellpadding="3" border=1>
	<TR><TD><?=msg('team_name');?></TD><TD><select name="<?=$reg_id;?>a" id="<?=$reg_id;?>a"><?=$op;?></select></TD></TR>
	<TR><TD><?=msg('team_action');?></TD><TD><select name="<?=$reg_ida;?>a" id="<?=$reg_id;?>b"><?=$opa;?></select></TD></TR>
	<TR><TD><input type="button" name="<?=$reg_id;?>z" id="<?=$reg_id;?>z" value="<?=msg('reg_botao');?>" class="botao-submit" />
	</td></TR>
</table>
<BR><BR>

<?
/**
 * Listar dados cadastrados de registros
 */
	echo '<table width="100%" class="lt1" cellspacing="0" cellpadding="3" border=1>';
	echo '<TR><TH>'.msg('member_unit').'</TH><TH>'.msg('member_action').'</TH>';
	echo '<TH>'.msg('acao');
	echo '</TR>';
	
	$regs = $team->dados_lista($protocol);
	for ($r=0;$r < count($regs);$r++)
		{
			$line = $regs[$r];
			echo '<TR>';
			echo '<TD>'.$line['ru_name'];
			echo '<TD>'.$line['csru_number'];
			echo '<TD align="center">';
			$onclick = 'onclick="remove_register('.$line['id_csru'].')" ';
			echo '<img src="img/icone_remove.png" '.$onclick.'>';
		}
	?>
	</table>
<BR><BR>	
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
			var dd12='<?=$dd[1];?>';
			var link_call = '<?=$linka;?>'+ '&dd10='+dd10+'&dd11='+dd11+'&dd12='+dd12;;
								 
			var $tela01 = $.ajax(link_call)
				.done(function(data) { $("#<?=$ref;?>").html(data); })
				.always(function(data) { $("#<?=$ref;?>").html(data); });	
		} );
</script>