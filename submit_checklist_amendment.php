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


$pgi = 1;
$pgf = 6;

$xok = 1;
echo '<table width="100%" cellpadding=3 cellspacing=0 border=1 class="lt1">';
echo '<TR><TH>' . msg('fieldset') . '<TH align="center">' . msg('check');

/* Validar arquivos */
$sql = "select * from ".$ged->tabela;
$sql .= " left join ".$ged->tabela."_tipo on doc_tipo = doct_codigo ";
$sql .= " where doc_dd0 = '".$protocolo."' and doc_ativo=1 ";
$yrlt = db_query($sql);
$cont = 0;
while ($line = db_read($yrlt)) {
	$cont++;
}
echo '<TR>';
echo '<TD>';
echo msg('files_submited').' ('.$cont.' '.msg('files').')';
echo '<TD align="center">';
if ($cont > 0) {
	echo '<font color="green">OK</font>';
} else {
	echo $link;
	echo '<font color="red">ERROR</font>';
	echo '</A>';
	$xok = 0;
}

/* Fields */
$sql = "SELECT * FROM cep_submit_manuscrito_field
	left join (select * from cep_submit_documento_valor where (spc_projeto = '" . $protocolo . "' and spc_ativo = 1)) as tabela on spc_codigo = sub_codigo 
	where (sub_pag >= $pgi and sub_pag < $pgf) and sub_ativo = 1
	order by sub_pag, sub_pos, sub_ordem ";

$amendment_type = $proj -> amendment_type;
$doct = '00'.$proj -> amendment_type;
if (round($amendment_type) > 0) {
	$sql = "SELECT * FROM cep_submit_manuscrito_field
			left join (select * from cep_submit_documento_valor where (spc_projeto = '" . $protocolo . "' and spc_ativo = 1)) as tabela on spc_codigo = sub_codigo 
			where sub_ativo = 1 and sub_projeto_tipo = '$doct'
			order by sub_pag, sub_pos, sub_ordem ";
}
$rlt = db_query($sql);

while ($line = db_read($rlt)) {
	$obrig = round($line['sub_obrigatorio']);
	$cont = trim($line['spc_content']);
	$ativo = trim($line['spc_ativo']);
	$ref = trim($line['sub_id']);

	if (($clinic == 0) and ($ref == 'CLINIC')) { $cont = 'ok';
	}

	if (($obrig == 1) and (($ativo == 1) or (strlen($ativo) == 0))) {
		$link = '<A HREF="submit.php?dd91=' . $line['sub_pag'] . '#' . $line['sub_codigo'] . '">';
		echo '<TR>';
		echo '<TD>';
		echo msg($line['sub_descricao']);

		echo '<TD align="center">';
		if (strlen($cont) > 0) {
			echo '<font color="green">OK</font>';
		} else {
			echo $link;
			echo '<font color="red">ERROR</font>';
			echo '</A>';
			$xok = 0;
		}
	}
}

echo '</table>';
?>