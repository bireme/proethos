<?php
$pgi = 1;
$pgf = 6;

$xok = 1;
echo '<table width="100%" cellpadding=3 cellspacing=0 border=1 class="lt1">';
echo '<TR><TH>' . msg('fieldset') . '<TH align="center">' . msg('check');

/*
 * Validar equipe e autores autores
 *
 * REGRA # - Mínimo de um autor
 *
 */
$sql = "select * from cep_submit_team
						inner join usuario on ct_author = us_codigo
						left join ajax_pais on us_country = pais_codigo
						where ct_protocol = '$protocolo'
						order by ct_type
				";
$yrlt = db_query($sql);
$cont = 0;
while ($line = db_read($yrlt)) {
	$cont++;
}
echo '<TR>';
echo '<TD>';
echo msg('team') . ' (' . $cont . ' ' . msg('members') . ')';
echo '<TD align="center">';
if ($cont > 0) {
	echo '<font color="green">OK</font>';
} else {
	echo $link;
	echo '<font color="red">ERROR</font>';
	echo '</A>';
	$xok = 0;
}

/*
 * Validar arquivos
 *
 * REGRA # - Mínimo de um arquivo
 *
 *
 * */
$sql = "select * from " . $ged -> tabela;
$sql .= " left join " . $ged -> tabela . "_tipo on doc_tipo = doct_codigo ";
$sql .= " where doc_dd0 = '" . $protocolo . "' and doc_ativo=1 
			
		";
$yrlt = db_query($sql);
$cont = 0;
while ($line = db_read($yrlt)) {
	$cont++;
}
echo '<TR>';
echo '<TD>';
echo msg('files_submited') . ' (' . $cont . ' ' . msg('files') . ')';
echo '<TD align="center">';
if ($cont > 0) {
	echo '<font color="green">OK</font>';
} else {
	echo $link;
	echo '<font color="red">ERROR</font>';
	echo '</A>';
	$xok = 0;
}

/*
 * Fields
 *
 *
 */
$sql = "SELECT * FROM cep_submit_manuscrito_field
	left join (select * from cep_submit_documento_valor where (spc_projeto = '" . $protocolo . "' and spc_ativo = 1)) as tabela on spc_codigo = sub_codigo 
	where (sub_pag >= $pgi and sub_pag < $pgf) and sub_ativo = 1
			and sub_projeto_tipo = '00001'
	order by sub_pag, sub_pos, sub_ordem ";

$amendment_type = $proj -> amendment_type;
if (round($amendment_type) > 0) {
	$sql = "SELECT * FROM cep_submit_manuscrito_field
			left join (select * from cep_submit_documento_valor where (spc_projeto = '" . $protocolo . "' and spc_ativo = 1)) as tabela on spc_codigo = sub_codigo 
			where ((sub_pag = 1) or (sub_pag = " . (2 + 10 * round($amendment_type)) . " ))
			and sub_ativo = 1 
			order by sub_pag, sub_pos, sub_ordem ";
}
$rlt = db_query($sql);

while ($line = db_read($rlt)) {
	$obrig = round($line['sub_obrigatorio']);
	$cont = trim($line['spc_content']);
	$ativo = trim($line['spc_ativo']);
	$ref = trim($line['sub_id']);
	
	$msg_ok = '<font color="green">'.msg('validated').'</font>';
	$msg_nok = '<font color="red">'.msg('no_validated').'</font>';

	if (($clinic == 0) and ($ref == 'CLINIC')) { $cont = 'ok';
	}

	if (($obrig == 1) and (($ativo == 1) or (strlen($ativo) == 0))) {
		$link = '<A HREF="submit.php?dd91=' . $line['sub_pag'] . '#' . $line['sub_codigo'] . '">';

		switch ($ref) {
			/*
			 * Enrollment
			 */
			case 'ENROLL' :
				if ($LANG == 'en_US') { $date = ustos($cont);
				} else { $date = brtos($cont);
				}

				echo '<TR>';
				echo '<TD>';
				echo msg($line['sub_descricao']) . ' - ' . $cont;

				/* CHECK DATE THE EROLLMENT */
				if ($date < date("Ymd")) {
					$cont = '';
				}

				if (strlen($cont) > 0) {
					echo '<TD align="center">' . $msg_ok;
				} else {
					/* ISSUE #89# */
					echo ' <font color="red">';
					echo msg('date_less_than_current');
					echo '</font>';
					echo '<TD align="center">';
					echo $link;
					echo $msg_nok;
					echo '</A>';
					$xok = 0;
				}
				break;
			/* DEFAULT CONDITION */
			default :
				echo '<TR>';
				echo '<TD>';
				echo msg($line['sub_descricao']);

				echo '<TD align="center">';
				if (strlen($cont) > 0) {
					echo $msg_ok;
				} else {
					echo $link;
					echo $msg_nok;
					echo '</A>';
					$xok = 0;
				}
				break;
		}

		/* Data do recrutamento */
		//ENROLL
		if ($ref == 'ENROLL') {

		}

	}
}

echo '</table>';
?>