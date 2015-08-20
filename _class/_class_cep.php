<?
/**
 * Ethics
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.11.29
 * @package Class
 * @subpackage ethics
 */
$bgcor = '#F0F0F0';
class cep {
	var $id_cep;
	var $protocolo;
	var $protocolo_submission;
	var $line;
	var $codigo;
	var $status;
	var $cep_dictamen;
	var $versao;
	var $caae;
	var $autor_principal;
	var $protocolo_cep;

	var $amendment_protocol;
	var $tabela = 'cep_protocolos';

	function transfere_autores() {
		$tm = new team;

		$proto_submit = $this -> protocolo_submission;
		$protocol = $this -> protocolo_cep;

		$sql = "select * from cep_submit_team where ct_protocol='" . $proto_submit . "' ";
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			$author = trim($line['ct_author']);
			$type = trim($line['ct_type']);
			$table = "cep_team";
			
			$tm -> team_insert_author($author, $protocol, $table, $type);
		}
	}

	function updatex() {
		global $base;
		$c = 'cep';
		$c1 = 'id_' . $c;
		$c2 = $c . '_codigo';
		$c3 = 7;
		$sql = "update cep_protocolos 
					set $c2 = lpad(round(1000000)+$c1,$c3,0) 
					, cep_protocol = lpad(round(1000000)+$c1,$c3,0)
					where $c2='' ";
		if ($base == 'pgsql') { $sql = "update cep_protocolos set $c2 = trim(to_char(round(1000000+id_" . $c . "),'" . strzero(0, $c3) . "')) where $c2='' ";
		}
		$rlt = db_query($sql);
	}

	function cp_monitoreo() {

		$cp = array();
		array_push($cp, array('$H8', 'id_cep', '', False, True));
		array_push($cp, array('$D', 'cep_recrutamento', msg('monitoreo_recrutamento'), True, True));
		array_push($cp, array('$O pending:#pending &recruiting:#recruiting &suspended:#suspended &completed:#completed &other:#other', 'cep_recrutamento_status', msg('monitoreo_recrutamento_status'), True, True));

		return $cp;
	}

	function cep_manual() {
		global $tabela, $messa;
		$tabela = 'cep_protocolos';
		$this -> tabela = $tabela;
		$typex = 'PRO:' . msg('prj_type_PRO');
		$typex .= '&AME:' . msg('prj_type_AME');
		$typex .= '&001:' . msg('amendment_001');
		$typex .= '&002:' . msg('amendment_002');
		$typex .= '&003:' . msg('amendment_003');
		$typex .= '&004:' . msg('amendment_004');
		$typex .= '&005:' . msg('amendment_005');
		$typex .= '&006:' . msg('amendment_006');
		$typex .= '&007:' . msg('amendment_007');
		$sta = 'A:Aberto';

		/* Status */
		$sql = "select * from cep_status order by ess_status";
		$rlt = db_query($sql);
		$sta = ' : ';
		while ($line = db_read($rlt)) {
			$sta .= '&';
			$sta .= trim($line['ess_status']);
			$sta .= ':';
			$sta .= msg(trim($line['ess_descricao_1']));
		}
		$cp = array();
		array_push($cp, array('$H8', 'id_cep', '', False, True));
		array_push($cp, array('$H8', 'cep_codigo', '', False, True));
		array_push($cp, array('$T80:3', 'cep_titulo', msg('title_main'), True, True));
		array_push($cp, array('$T80:3', 'cep_titulo_public', msg('title_public'), True, True));
		array_push($cp, array('$S20', 'cep_caae', msg('caae'), True, True));
		array_push($cp, array('$U8', 'cep_atualizado', '', False, True));
		array_push($cp, array('$D8', 'cep_reuniao', msg('meet_data'), False, True));
		array_push($cp, array('$D8', 'cep_dt_ciencia', msg('data_ciencia'), False, True));
		array_push($cp, array('$D8', 'cep_dt_liberacao', 'liberado', False, True));
		array_push($cp, array('$D8', 'cep_monitoring', 'monitoring', False, True));

		array_push($cp, array('$D8', 'cep_aproved', msg('dict_aproved'), False, True));
		array_push($cp, array('$D8', 'cep_dt_parecer', 'dt.parecer', False, True));
		array_push($cp, array('$O ' . $sta, 'cep_status', msg('status'), False, True));
		array_push($cp, array('$O ' . $typex, 'cep_tipo', msg('type'), False, True));

		array_push($cp, array('$H8', 'cep_protocol', '', False, True));
		array_push($cp, array('$[1-99]', 'cep_versao', msg('version'), False, True));
		array_push($cp, array('$U8', 'cep_data', '', False, True));
		array_push($cp, array('$O : &1:' . msg("yes") . '&0:' . msg('no'), 'cep_clinic', msg('q_clinic_study'), False, True));
		return ($cp);

	}

	function row() {
		global $cdf, $cdm, $masc;
		$cdf = array('id_cep', 'cep_caae', 'cep_titulo');
		$cdm = array('cod', msg('caae'), msg('title'));
		$masc = array('', '', '', '', '', 'SN');
		return (1);
	}

	function search_by_word($field, $words) {
		$wd = UpperCaseSql($words);
		$wd = troca($wd, ' ', ';') . ';';
		$wd = splitx(';', $wd);
		$wh = '';
		for ($r = 0; $r < count($wd); $r++) {
			/* recupera word do termo */
			$term = $wd[$r];
			if ($r > 0) {
				$wh .= ' and ';
			}
			$wh .= " ($field  like '%$term%') ";
		}
		return ($wh);
	}

	function protocolos_search($sta) {
		global $ss;
		$sta = trim($sta);
		$us = strzero(round($ss -> user_id), 7);

		/* Protocolos de Pesquisa */
		$sql = "select * from " . $this -> tabela . " 
					 left join usuario on us_codigo = cep_pesquisador
					 where (cep_titulo like '%" . $sta . "%') 
					 or (" . $this -> search_by_word('cep_titulo_public', $sta) . ")
					 or (cep_caae  like '%" . $sta . "%')
					 or (cep_codigo like '%" . $sta . "%')
					 or (" . $this -> search_by_word('us_nome', $sta) . ")
					 order by cep_tipo desc
					 ";
		$rlt = db_query($sql);
		$dta = 19000101;
		$tot = 0;
		/* Header to Protocol */
		$trp = '<TR><TH>' . msg('protocol');
		$trp .= '<TH>' . msg('project_title');
		$trp .= '<TH>' . msg('status');

		/* Header to Amen */
		$tra = '<TR><TH>' . msg('protocol');
		$tra .= '<TH>' . msg('amen_title');
		$tra .= '<TH>' . msg('status');

		$xtipo = '';
		while ($line = db_read($rlt)) {
			$tipo = trim($line['cep_tipo']);

			if ($xtipo != $tipo) {
				$xtipo = $tipo;
				if ($tipo == 'PRO') { $sx .= $trp;
				}
				if ($tipo == 'AME') { $sx .= $tra;
				}
			}
			$tot++;
			$sx .= $this -> mostra($line);
		}
		echo '<table width=96% class="table_normal" border=0>';

		echo $sx;
		echo '<TR><TD colspan=5>' . msg('found') . ' ' . $tot . ' ' . msg('records');
		echo '</table>';
	}

	function form_search() {
		global $dd;
		$sx = '';
		//$sx .= '<h3>'.msg('locate_a_project').'</h3>';
		$sx .= '<div id="form_search">';
		$sx .= '<form action="protocol_search.php" method="get">';
		$sx .= '<h2>' . msg('find_a_term') . '</h2>';
		$sx .= '<table cellpadding=0 cellspacing=0 width="100%" >';
		$sx .= '<TR valign="top">
					<TD rowspan=3>
					<img src="images/icone_search.png" height="50">
					<TD>';
		$sx .= '<input type="text" id="dd50" 
						name="dd50" 
						value="' . strip_tags($dd[50]) . '" size="80" 
						style="width: 100%;" 
						class="form_search_input"
						>';
		$sx .= '<TD>';
		$sx .= '<input 
						type="submit" 
						value="' . strip_tags(msg('search')) . '" 
						class="form_search_input_button"
						style="width: 120px;"
						>';
		$id = round($dd[10]);
		$chk = array('', '', '', '', '', '', '', '', '');
		if ($id == 0) { $id = 1;
		}
		if ($id > 0) { $chk[$id] = 'checked';
		}
		$sx .= '<TR><TD colspan=2 class="lt0">';
		$sx .= '<input type="radio" name="dd10" value="1" ' . $chk[1] . '>' . msg('all') . '&nbsp;';
		$sx .= '<input type="radio" name="dd10" value="2" ' . $chk[2] . '>' . msg('in analysis') . '&nbsp;';
		$sx .= '<input type="radio" name="dd10" value="3" ' . $chk[3] . '>' . msg('approved') . '&nbsp;';
		$sx .= '<input type="radio" name="dd10" value="4" ' . $chk[4] . '>' . msg('not approved') . '&nbsp;';
		$sx .= '</table>';
		$sx .= '</form>';
		$sx .= '</div>';
		return ($sx);
	}

	function form_send_amendment() {
		global $dd;
		$cr = chr(13);
		$sx = '<fieldset><legend>' . msg('amendment') . '</legend>';
		/* OPtions */
		$sx .= '<div style="float: right">
				<input type="button" value="' . msg("bottom_monitoring") . '" id="monitoring_bottom">
				</div>';
		$sx .= '
				<script>
					$("#monitoring_bottom").click(function() {
						$("#monitoring").toggle("slow");
					});
				</script>
				';

		/* descript */
		$sx .= '<h2>' . msg('wdyd_amend') . '</h2>';
		$sx .= msg('wdyd_amend_inf');

		$sx .= '<div id="monitoring" style="display: none;">';
		if (strlen($dd[1]) == 0) {
			$sx .= '<form action="' . page() . '">' . $cr;
			//$sx .= '<select name="dd1">' . $cr;
			/* Busca emandas do SQL */
			$sql = "select * from cep_amendment_type
							 where amt_ativo = 1 
							order by amt_ord ";
			$rlt = db_query($sql);

			while ($line = db_read($rlt)) {
				$btn = 'amendment_' . trim($line['amt_codigo']);
				$btn = trim($line['amt_descrip']);

				$sx .= '<input type="radio" name="dd1" id="dd1" 
							value="' . '001' . trim($line['amt_codigo']) . '"
							>' . msg($btn) . '</br>' . $cr;
			}

			$sx .= '<input type="submit" value="' . msg('send_monitoreo') . '"  class="form_submit">' . $cr;
			$sx .= '</form>';
		} else {
			$act = substr($dd[1], 0, 3);
			$form = substr($dd[1], 3, 3);

			if ($form == '00001') { $sx .= $this -> gp_form_00001($act);
			}
			if ($form != '00001') { $sx .= $this -> gp_form($form, $act);
			}
		}
		$sx .= '</div>';
		$sx .= '</fieldset>';
		return ($sx);
	}

	/* Formulario de Submissão */
	function gp_form($form, $act) {
		$this -> create_amendment($form);
		$protocolo = round($this -> amendment_protocol);

		/* Redirecionamento */
		$link = 'protocol_submit.php?dd0=' . $protocolo . '&dd5=TO_SUBMIT&dd90' . checkpost($protocolo);
		redirecina($link);
		return ($sx);

	}

	/* Show Amendments */
	function show_amendment() {
		$caae = $this -> line['cep_caae'];
		if (strlen($caae) > 0) {
			$caaep = substr($caae, 0, 12);
			$sqlx = "select * from cep_submit_documento where 
						doc_status = '@' and doc_caae like '$caaep%'
				";

			$rlt = db_query($sqlx);
			$id = 0;
			$sx = '<table width="100%" class="table_proj lt1">';
			$sx .= '<TR class="hd"><TD colspan=5>' . msg('prj_type_AME');
			$sx .= '<TR>';
			$sx .= '<TH>' . msg('protocol');
			$sx .= '<TH>' . msg('amendment_type');
			$sx .= '<TH><nobr>' . msg('last_update');
			$sx .= '<TH><nobr>' . msg('status');
			$sx .= '<TH><nobr>' . msg('result');
			while ($line = db_read($rlt)) {
				$id++;
				$result = trim($line['cep_pr_protocol']);

				$idx = $line['id_cep'];
				$link = '<A HREF="protocol_detalhe.php?dd0=' . $idx . '&dd90=' . checkpost($idx) . '">';

				$sta = $line['doc_status'];
				if ($sta == '@') { $sta = msg('cep_status_@');
				}

				$msgt = 'amendment_' . substr($line['doc_tipo'], 0, 3);
				$sx .= '<TR>';
				//$sx .= '<TD>'.$line['doc_caae'];
				$sx .= '<TD align="center">' . $link . $line['doc_protocolo'];
				$sx .= '<TD align="center">' . msg($msgt);
				$sx .= '<TD width="5%" align="center">' . stodbr($line['doc_dt_atualizado']);
				$sx .= '<TD align="center"><nobr>' . msg($sta);
				$sx .= '<TD align="center"><nobr>' . msg($result);
			}

			$sql = "select * from cep_protocolos where 
						cep_caae like '$caaep%' 
						and cep_tipo = 'AME' 
						order by cep_caae desc ";
			$rlt = db_query($sql);
			while ($line = db_read($rlt)) {
				$idx = $line['id_cep'];
				$link = '<A HREF="protocol_detalhe_investigator.php?dd0=' . $idx . '&dd90=' . checkpost($idx) . '">';

				$id++;
				$sta = $line['cep_status'];
				$str = trim($line['cep_pr_protocol']);
				//if ($sta=='@') { $sta = msg('cep_status_@'); }
				$msgt = 'amendment_' . trim($line['cep_tipo']);
				$sx .= '<TR>';
				$sx .= '<TD>' . $link . $line['cep_caae'];
				$sx .= '<TD>' . $link . msg($msgt);
				$sx .= '<TD width="5%">' . $link . stodbr($line['cep_atualizado']);
				$sx .= '<TD><nobr>' . msg('cep_status_' . $sta);
				$sx .= '<TD align="center"><nobr>' . msg($str);

			}
			$sx .= '</table>';
			if ($id == 0) { $sx = '';
			}
		}
		return ($sx);
	}

	/* Amendment Investigation */
	function gp_form_00001($act) {
		global $dd;
		$this -> create_amendment($act);
		$protocolo = round($this -> amendment_protocol);
		redirecina('protocol_submit.php?dd0=' . $protocolo . '&dd90' . checkpost($protocolo));
		return ($sx);
	}

	function create_amendment($tp) {

		$this -> updatex_submit();
		$title = $this -> line['cep_titulo'];
		$titlep = $this -> line['cep_titulo_public'];

		$type = $tp;
		$caae = $this -> line['cep_caae'];
		$update = date("Ymd");
		$investigator = $this -> line['cep_pesquisador'];
		$data = date("Ymd");
		$hora = date("H:i");
		$human = '0';
		$clinic = round($this -> line['cep_clinic']);

		$sqlx = "select * from cep_submit_documento where 
					doc_status = '@' and doc_caae = '$caae'
			";
		$rlt = db_query($sqlx);
		if ($line = db_read($rlt)) {
			$protocol = $line['doc_protocolo'];
			$sql = "update cep_submit_documento set 
						doc_type = '$tp' ,
						doc_tipo = '$tp' ,
						doc_dt_atualizado = " . date("Ymd") . "
						where id_doc = " . round($line['id_doc']);
			$rlt = db_query($sql);
		} else {
			$sql = "insert into cep_submit_documento 
					(
					doc_1_titulo, doc_1_titulo_public, doc_protocolo,
					doc_tipo, doc_human, doc_clinic,
					doc_data, doc_hora, doc_dt_atualizado,
					doc_autor_principal, doc_research_main, doc_status,
					doc_xml, doc_type, doc_caae
					) values (
					'$title','$titlep','',
					'$type', $human, $clinic,
					$data,'$hora',$update,
					'$investigator','$investigator','@',
					'','$tp','$caae'
					)";
			$rlt = db_query($sql);
			$this -> updatex_submit();
		}
		$rlt = db_query($sqlx);
		if ($line = db_read($rlt)) { $protocol = $line['doc_protocolo'];
		}
		$this -> amendment_protocol = $protocol;

		/* Recupera autores */
		$this -> copy_authors($this -> protocolo, $this -> amendment_protocol = $protocol);

		return ($sx);

	}

	function copy_authors($from, $to) {
		$sql = "select * from cep_team where ct_protocol = '$from' and ct_ativo = 1";
		$rlt = db_query($sql);
		$sqli = '';
		while ($line = db_read($rlt)) {
			$author = $line['ct_author'];
			$type = $line['ct_type'];
			$data = $line['ct_data'];
			$sqli .= "insert into cep_team 
								(ct_protocol, ct_author, ct_type, ct_data, ct_ativo)
								values
								('$to','$author','$type',$data,1);
								";
		}
		if (strlen($sqli) > 0) {
			$sql = "update cep_team set ct_ativo = 0 where ct_protocol = '$to' ";
			$rlt = db_query($sql);
			/* Execute Insert */
			$rrr = db_query($sqli);
		}
		return (1);
	}

	function updatex_submit() {
		$c = 'doc';
		$c1 = 'id_' . $c;
		$c2 = $c . '_protocolo';
		$c3 = 7;
		$sql = "update cep_submit_documento set $c2 = lpad($c1,$c3,0) where $c2='' ";
		$rlt = db_query($sql);
	}

	function protocol_in_investigation() {
		$investigator = $this -> autor_principal;
		$sql = "select * from " . $this -> tabela . " where cep_pesquisador = '" . $investigator . "' 
				and cep_tipo = 'PRO' and cep_status = 'P' ";
		$rlt = db_query($sql);
		$sx = $this -> protocol_show($rlt);
		return ($sx);
	}

	function protocol_show($rlt) {
		$id = 0;
		$sx .= '<table class="tabela01" width="100%" bgcolor="#FFFFFF">';
		$sx .= '<TR class="lt0">
				<TD colspan=4 align="center">
					<font class="lt3">' . msg('approved_protocols') . '</font>';

		$sx .= '<TR class="lt1">
				<TH width="10%">' . msg('caae') . '</td>
				<TH align="left">' . msg('protocol_title') . '</td>
				<TH width="10%">' . msg('last_update') . '</td>
				<TH width="7%">' . msg('status');

		while ($line = db_read($rlt)) {

			$id++;
			$link = '<A HREF="protocol_detalhe_investigator.php?dd0=' . $line['id_cep'] . '&dd90=' . checkpost($line['id_cep']) . '" class="link lt2">';
			$link2 = '<A HREF="protocol_detalhe_investigator.php?dd0=' . $line['id_cep'] . '&dd90=' . checkpost($line['id_cep']) . '" class="link lt1">';
			$sx .= chr(13);

			$sx .= '<tr valign="top">
					<td class="border01 lt1">' . $link2 . $line['cep_caae'] . '</A></td>
					<td class="border01 lt2 padding5">' . $link . $line['cep_titulo'] . '</A></td>
					<td class="lt1 border01" align="center">' . stodbr($line['cep_atualizado']) . '</td>
					<td class="lt1 border01">' . msg($line['cep_pr_protocol']) . '</td>
					</tr>';

			//$sx .= '<TD class="tabela01">';
			//$sx .= $this -> mostra_status($line['cep_status']);

		}
		if ($id == 0) { $sx = '';
		}
		$sx .= '</table>';
		return ($sx);
	}

	function bloqueio_etico() {
		global $ss;

		if (trim($this -> line['cep_pesquisador']) == trim($ss -> user_codigo)) {
			return (1);
		}
		return (0);
	}

	function recupera_protocolo_submissao($protocolo, $versao = '1') {
		$sql = "select * from " . $this -> tabela . " 
				where cep_fr = '" . $protocolo . "' and cep_versao = '$versao' ";

		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			return ($line['cep_protocol']);
		}
		return ('');
	}

	function next_caae($caae) {
		$caaep = trim(substr($caae, 0, 12));
		if (strlen($caaep) > 0) {
			$sql = "select cep_caae from cep_protocolos where cep_caae like '" . $caaep . "%' order by cep_caae desc limit 1";
			$rlt = db_query($sql);
			if ($line = db_read($rlt)) {
				$caaen = round(substr($line['cep_caae'], 12, 3));
				$caaep .= strzero(($caaen + 1), 3);
				$caae = $caaep;
			}
		}
		return ($caae);
	}

	function get_cep_recrutamento($proto_cep) {

		$sql = "SELECT cep_recrutamento FROM cep_protocolos WHERE cep_codigo = '$proto_cep'";
		$query = db_query($sql);

		if ($line = db_read($query)) {
			return $line['cep_recrutamento'];
		}

		return NULL;

	}

	function cadastra_protocolo($protocolo, $titulo, $autor, $versao = '1') {
		$type = 'PRO';

		$sql = "select * from cep_submit_documento 
				where doc_protocolo = '" . $protocolo . "' 
				and doc_status = '@' ";

		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$research = $line['doc_autor_principal'];
			$title_work = $line['doc_1_titulo'];
			$title_public = $line['doc_1_titulo_public'];
			$type = trim($line['doc_tipo']);
			$caae = $this -> next_caae(trim($line['doc_caae']));
			$clinic = round($line['doc_clinic']);
			$doc_type = trim($line['doc_tipo']);
			if (substr($doc_type, 0, 1) == '0') { $type = 'AME';
			} else { $type = 'PRO';
			}
		} else {
			echo '<h2><font color="red">Error: Document already posted</font></h2>';
			echo '<BR>';
			return (False);
		}
		$sql = "select * from " . $this -> tabela . " 
				where cep_fr = '" . $protocolo . "' ";
		$rlt = db_query($sql);
		if (!($line = db_read($rlt))) {

			$versao = 1;
			$data = date("Ymd");
			$hora = date("H:i");
			$sql = "select max(id_cep) as proto from " . $this -> tabela;
			$rlt = db_query($sql);
			if ($line = db_read($rlt)) { $protocep = strzero($line['proto'] + 1, 6);
			}

			$this -> protocolo_cep = $protocep;

			$sql = "insert into cep_protocolos (
					cep_titulo, cep_titulo_public, 
					cep_codigo, cep_tipo, cep_protocol,
					cep_fr, cep_versao, cep_data,
					
					cep_hora, cep_resumo, cep_pesquisador,
					cep_local_realizacao, cep_status, cep_ata,
					cep_dt_parecer, cep_titulacao, cep_grupo,
					
					cep_conhecimento, cep_caae, cep_atualizado,
					cep_atual, cep_relator, cep_reuniao,
					cep_st_parecer, cep_nr_parecer, cep_revisor,
					
					cep_submit, cep_dt_ciencia, cep_dt_liberacao,
					cep_sinte, cep_clinic, cep_study_type, cep_goal,
					cep_comment_pos, cep_comment_neg, cep_dictamen,
					cep_approved, cep_xml, cep_recrutamento,
					cep_monitoring, cep_aproved
					) values (
					'$title_work','$title_public',
					'$protocolo','$type','$protocep',
					'$protocolo','$versao','$data',
					
					'$hora','$resumo','$research',
					'','A','',
					19000101,'','I',
					
					'','$caae',$data,
					'','',19000101,
					'','','',
					
					'',19000101,19000101,
					'','$clinic','','',
					0,0,0,
					0,'',0,
					0,0				
					)";
			$rlt = db_query($sql);
		} else {
			$versao = (round($line['cep_versao']) + 1);
			$this -> protocolo_cep = trim($line['cep_protocol']);

			$sql = "update " . $this -> tabela . " set ";
			$sql .= " cep_status = 'A', ";
			$sql .= " cep_titulo = '" . $title_work . "', ";
			$sql .= " cep_titulo_public = '" . $title_public . "', ";
			$sql .= " cep_data = " . date("Ymd") . ', ';
			$sql .= " cep_hora = '" . date("H:i") . "', ";
			$sql .= " cep_versao = '$versao', ";
			$sql .= " cep_caae = '$caae', ";
			$sql .= " cep_tipo = '$type', ";
			$sql .= " cep_pesquisador = '$research', ";
			$sql .= " cep_clinic = '" . $clinic . "' ";
			$sql .= " where id_cep = " . $line['id_cep'] . " and cep_status = '@' ";

			$rlt = db_query($sql);
		}
		return (1);
	}

	function cep_create_caae() {

	}

	function status_cor($sta) {
		$at = array('@' => 0, 'A' => 1, 'B' => 2, 'C' => 3, 'X' => 5);
		$st = $at[$sta];
		$co = $this -> cep_cores();
		return ($co[$st]);
	}

	function cep_cores() {
		$cor = array('#D8FFD8', '#D8D8FF', '#FFD8FF', '#FFD858', '', '#808080');
		return ($cor);
	}

	function action_001() {
		global $dd;
		$this -> cep_historic_append($ac, msg('protocol_accept'));
		$this -> cep_status_alter('A');
		redirecina('protocol_detalhe.php');
		return (1);
	}

	/* 003 - Recusar trabalho e devolver para autor*/
	function action_003() {
		global $dd, $acao, $bgcor;
		$bb1 = msg('action_rejection');
		$sc .= '<Table width="100%" class="lt1" bgcolor="' . $bgcor . '">' . chr(13);
		$sc .= '<TR><TH><h2><A name="A003">' . msg('action_accept_rejected') . '</h2>';
		$sc .= '<TD width=25 ><img src="img/icone_close.png" width="25" id="A003i" style="cursor: pointer;">';
		$sx .= $sc;
		$sx .= '<TR><TD class="lt0">' . msg('action_accept_rejected_inf');
		$sx .= '<TR><TD><form method="post" action="' . page() . '#A003">';
		$sx .= '<input type="hidden" name="dd3" value="003">';
		$sx .= '<TR><TD><B>' . msg('action_reason_rejected');
		$sx .= '<TR><TD><textarea name="dd15" cols=60 rows=4>' . $dd[15] . '</textarea>';
		if ((strlen($acao) > 0) and (strlen($dd[15]) == 0)) {
			$sx .= '<TR><TD><font class="error_1">' . msg('required_field');
		}
		$sx .= '<TR><TD><input name="acao" type="submit" value="' . $bb1 . '"  class="form_submit">';
		$sx .= '<TR><TD></form>';
		$sx .= '</table>';

		if ((strlen($acao) > 0) and (strlen($dd[15]) > 0)) {
			$comm = new comunication;
			$comm -> protocolo = $this -> protocolo_submission;
			$comm -> email_save($dd[15], msg('accept_rejected'));
			$this -> communication_research(msg('email_return_to_submission'), $dd[15]);
			$this -> cep_historic_append($ac, msg('return_to_submission'));
			$this -> cep_submit_status_alter('$');
			$this -> cep_status_alter('@');
			redirecina(page());
		}
		return ($sx);
	}

	/* recption in committee */
	function action_009() {
		global $dd, $acao, $bgcor;
		
		$type = trim($this -> line['cep_tipo']);
		$bb1 = msg('action_send_botton');
		$sc .= '<Table width="100%" class="lt1" bgcolor="' . $bgcor . '">' . chr(13);
		$sc .= '<TR><TH><h2><A name="A009">' . msg('action_accept_manuscrit');
		$sc .= '<TD width=25 ><img src="img/icone_close.png" width="25" id="A009i" style="cursor: pointer;">';
		$sx .= $sc;
		$sx .= '<TR><TD class="lt0">' . msg('action_accept_manuscrit_inf');
		
		$sx .= '<TR><TD><form method="post" action="' . page() . '#A009">';
		$sx .= '<input type="hidden" name="dd3" value="009">';
		$sx .= '<TR><TD><input name="dd4" type="radio" value="1">' . msg('action_need_consultation');
		$sx .= '<TR><TD><input name="dd4" type="radio" value="2">' . msg('action_accept_direct');
		if ($type == 'AME') {
			$sx .= '<TR><TD><input name="dd4" type="radio" value="3">' . msg('action_notification_only');
		}
		$sx .= '<TR><TD><input name="acao" type="submit" value="' . $bb1 . '"  class="form_submit">';
		$sx .= '<TR><TD></form>';
		/* Save Action */
		
		if (($acao == $bb1) and (strlen($dd[3]) > 0)) {
			/* Necessita de Revisao */
			if ($dd[4] == '1') {
				$sx = $sc . '<TR><TD>';
				$this -> altera_status_submit("Z");
				$sx .= $this -> communication_members("email_new_avaliation");
				$this -> cep_historic_append('009', "need_consultation_to_accept");
				$this -> cep_status_alter("H");
				redirecina(page(), 5);
			}
			/* Nao aceita direto */
			if ($dd[4] == '2') {
				$sx = $sc . '<TR><TD>';
				$this -> altera_status_submit("Z");
				$this -> communication_research("email_manuscipt_accept");
				$this -> cep_historic_append('010', "manuscript_accepted");
				$this -> cep_status_alter("B");
				redirecina(page());
			}
			if ($dd[4] == '3') {
				$sx = $sc . '<TR><TD>';
				$this -> altera_status_submit("Y");
				$this -> cep_submit_status_alter('Z');
				$this -> approved_documment(2);
				$this -> communication_research("email_manuscipt_notify");
				$this -> cep_historic_append('018', "notification_document");
				$this -> cep_status_alter("Z");
				redirecina(page());
			}

		}
		$sx .= '</Table>' . chr(13);
		return ($sx);
	}

	function altera_status_submit($status) {
		$proto_submit = strzero($this -> protocolo, 7);
		$sql = "update cep_submit_documento set doc_status = '$status' 
						where doc_protocolo = '$proto_submit' ";
		$rlt = db_query($sql);
	}

	function cep_update_date_dictamen($nt) {
		$protocolo = $this -> protocolo;
		$sql = "update " . $this -> tabela . " set cep_dt_parecer = " . $nt . " 
				where cep_protocol = '" . $protocolo . "' ";
		$rlt = db_query($sql);
	}

	function approved_documment($nt) {
		$protocolo = $this -> protocolo;
		$sql = "update " . $this -> tabela . " set cep_approved = " . $nt . " 
				where cep_protocol = '" . $protocolo . "' ";
		$rlt = db_query($sql);
	}

	function surver_resume() {
		$proto = $this -> protocolo_submission;

		$sql = "select sum(sr_yes) as yes, sum(sr_no) as no from cep_survey
					where sr_protocolo = '$proto'
					group by sr_protocolo ";
		$rlt = db_query($sql);

		if ($line = db_read($rlt)) {
			$sx .= '<table width="250" cellpadding=0 cellspacing=3 border=0 class="lt1">';
			$sx .= '<TR align="center"><TD>' . msg('result_survey');
			$sx .= '<TD>' . msg('yes') . ': ' . $line['yes'];
			$sx .= '<TD>' . msg('no') . ': ' . $line['no'];
			$sx .= '</table>';
		} else {
			$sx .= msg('survey_not_avaliable');
		}

		return ($sx);
	}

	function survey_check_vote() {
		global $ss, $ip;

		$nuser = $ss -> user_codigo;
		$proto = $this -> protocolo_submission;
		$sql = "select * from cep_survey where
					sr_protocolo = '$proto' and sr_member = '$nuser' 
					";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			return (1);
		} else {
			return (0);
		}
	}

	function survey_save($vt) {
		global $ss, $ip;
		$nuser = $ss -> user_codigo;
		$proto = $this -> protocolo_submission;
		$date = date("Ymd");
		$hora = date("H:i");
		$ip = $_SERVER['REMOTE_ADDR'];

		if ($vt == 1) { $yes = 1;
			$no = 0;
		}
		if ($vt == 0) { $yes = 0;
			$no = 1;
		}
		if ($this -> survey_check_vote()) {

		} else {
			$sql = "insert into cep_survey (
						sr_protocolo, sr_member, sr_yes, 
						sr_no, sr_date, sr_time, sr_ip
						) values (
						'$proto','$nuser',$yes,
						$no, $date, '$hora', '$ip'
						)";
			$rlt = db_query($sql);
		}
		return (1);
	}

	/* SURVEY */
	function action_015() {
		global $dd, $acao, $perfil, $ss;

		$sx .= $this -> survey_show();
		
		/* Solo membros puende opinar */
		if (!($perfil -> valid('#MEM'))) {
			return ($sx);
		}

		$bb1 = msg('action_survey');
		$sc .= '<Table width="100%" class="lt1">' . chr(13);
		$sc .= '<TR><TH colspan=2><h3><A name="A015">' . msg('action_accept_015');
		$sx .= $sc;
		$sx .= '<TR><TD><form method="post" action="' . page() . '#A015">';
		$sx .= '<input type="hidden" name="dd3" value="015">';
		$sx .= '<TR><TD>' . msg('accept_manu_survey');
		if ($this -> survey_check_vote()) {
			$sx .= '<TR><TD align="left">' . $this -> surver_resume();
		} else {
			$sx .= '<TR><TD>';
			$sx .= '<input type="radio" value="1" name="dd6">' . msg('yes');
			$sx .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$sx .= '<input type="radio" value="0" name="dd6">' . msg('no');
			$sx .= '<TD align="right">' . $this -> surver_resume();
			$sx .= '<TR><TD><input name="acao" type="submit" value="' . $bb1 . '"  class="form_submit">';
		}
		$sx .= '<TR><TD></form>';
		$sx .= '</table>';

		if ((strlen($acao) > 0) and (strlen($dd[6]) > 0)) {
			$this -> survey_save($dd[6]);
			if ($dd[6] == 1) {
				/* SIM */
				/* Regra para caso um decida SIM, envia automático */
				/* Omitida em 03-02-2015 */
				//$this -> cep_historic_append("015", "manuscript_accepted");
				//$this -> cep_status_alter("B");
				//$this -> communication_research("email_manuscipt_accept");
			}
			redirecina(page());
		}
		
		return ($sx);
	}

	function survey_show() {
		$proto = $this -> protocolo_submission;
		$sql = "select * from cep_survey
					inner join usuario on sr_member = us_codigo 
						where sr_protocolo = '$proto' ";
		$rlt = db_query($sql);

		$sx .= '<table width="100%" class="tabela00 lt1">';
		$sx .= '<TR>';
		$sx .= '<Td><B>' . msg('members') . '</B></td>';
		$sx .= '<Td><B>' . msg('institution') . '</B></td>';
		$sx .= '<Td colspan=2 align="center"><B>' . msg('result') . '</B></td>';
		//$sx .= '<Th>'.msg('member').'</th>';

		while ($line = db_read($rlt)) {
			$sx .= '<TR>';
			$sx .= '<TD class="border1">';
			$sx .= $line['us_nome'];
			$sx .= '<TD class="border1">';
			$sx .= $line['us_instituition'];

			$bgy = '';
			$bgn = '';
			$bgyn = '';
			$bgnn = '';

			$rs = $line['sr_yes'];
			$rn = $line['sr_no'];
			if ($rs == '1') { $bgy = ' bgcolor="#AAffAA" ';
			}
			if ($rn == '1') { $bgn = ' bgcolor="FFAAAA" ';
			}

			$sx .= '<TD ' . $bgy . ' width="20" align="center" class="border1">' . msg("yes");
			$sx .= '<TD ' . $bgN . ' width="20" align="center" class="border1">' . msg('no');

		}
		$sx .= '</table>';
		return ($sx);
	}

	function cep_salva_decision($caae, $acomp, $situacao='') {
		$data = date("Ymd");
		$sql = "select * from cep_protocolos where cep_caae = '$caae' ";
		$rlt = db_query($sql);
		$line = db_read($rlt);
		print_r($line);
		echo '<HR>';
		if (strlen($situacao) > 0)
			{
				$up = ", cep_pr_protocol = 'pm_$situacao' ";
			}
		$sql = "update cep_protocolos set 
							cep_monitoring = " . round($acomp) . ",
							cep_atualizado = $data,
							cep_aproved = $data,
							cep_dt_parecer = $data
							$up
					where cep_caae = '$caae' ";

		$rlt = db_query($sql);
					echo $sql;
					exit;		
		return (1);
	}

	function action_016() {
		global $dd, $acao, $perfil;

		$bb1 = msg('action_survey');
		$sc .= '<Table width="100%" class="lt1">' . chr(13);
		$sc .= '<TR><TH align="center"><h3><A name="A016">' . msg('action_accept_016');
		$sx .= $sc;
		$sx .= '<TR><TD><form method="post" action="' . page() . '#A016">';
		$sx .= '<input type="hidden" name="dd3" value="016">';
		$sx .= '<TR><TD>' . msg('accept_manu_survey_direct');
		$sx .= '<TR><TD>';
		$sx .= '<input type="radio" value="1" name="dd8">' . msg('yes_accept');
		$sx .= '&nbsp;&nbsp;&nbsp;';
		$sx .= '<input type="radio" value="2" name="dd8">' . msg('yes_isento');

		$sx .= '<TD align="right">' . $this -> surver_resume();
		$sx .= '<TR><TD><input name="acao" type="submit" value="' . $bb1 . '"  class="form_submit">';
		$sx .= '<TR><TD></form>';
		$sx .= '</table>';
		
		if ((strlen($acao) > 0) and (strlen($dd[8]) > 0)) {
			if ($dd[8] == '1') {
				$this -> cep_historic_append("016", "manuscript_accepted_direct");
				$this -> cep_status_alter("B");
				redirecina(page());
			}
			if ($dd[8] == '2') {
					
				/* gera numero automatico do caae */
				$this -> niec_save('', 1, 1);

				/* recupera numero do caae */
				$caae = $this->caae;

				/* salva historic */
				$this -> cep_historic_append("016", "manuscript_isent");
				
				/* Salva decision */
				$this->cep_salva_decision($caae, '-1', 'NOA');
				
				/* Altera Status do protocolo */
				//$this -> cep_status_alter("D");
				redirecina(page());
			}
		}
		return ($sx);
	}

	/* Informa o número do CAAE */
	function action_017() {
		global $dd, $acao;

		/* Se ja existe numero do Caae, salva automaticamente */
		$caae = trim($this -> line['cep_caae']);
		if (strlen($caae) > 0) {
			$dd[5] = '0';
			$dd[6] = $caae;
			$versao = -999;
			$acao = 'save';
		}

		$bb1 = msg('save_next');
		$sc .= '<Table width="100%" class="lt1">' . chr(13);
		$sc .= '<TR><TH><h2><A name="A017">' . msg('action_accept_manuscrit') . '</h2>';
		$sx .= $sc;
		$sx .= '<TR><TD><form method="post" action="' . page() . '#A017">';
		$sx .= '<input type="hidden" name="dd3" value="017">';
		$sx .= '<TR><TD>' . msg('informe_caae_number');
		$sx .= '<TR>';
		$sx .= gets('dd6', $dd[4], '$S20', '', 0, 1);
		$sx .= '<TR>';
		$sx .= gets('dd5', $dd[5], '$C', msg('automatically_create'), '', '', '');
		$sx .= '<TR><TD><input name="acao" type="submit" value="' . $bb1 . '"  class="form_submit">';
		$sx .= '<TR><TD></form>';
		$sx .= '</table>';

		if ((strlen($acao) > 0) and ((strlen($dd[6]) > 0)) or (strlen($dd[5]) > 0)) {
			$versao = 1;
			/* Ja existe numero do CAAE, pula esta fase */
			if (strlen($caae) > 0) {
				$this -> cep_status_alter("C");
				$this -> communication_research("email_assign_record_number");
				redirecina(page());
			}
			/* Gera e salva o numero do CAAE */
			if ($this -> niec_save($dd[6], $dd[5], $versao)) {
				$this -> cep_historic_append("017", "assign_record_number");
				$this -> cep_status_alter("C");
				$this -> communication_research("email_assign_record_number");
				redirecina(page());
			}
		}
		return ($sx);
	}

	function niec_save($nr, $auto, $ver = 1) {
		global $committe, $hd;
		$auto = round($auto);
		$committe = $hd -> prefix;
		$ver = strzero($ver, 3);
		if ($auto == 1) {
			$caae = trim($committe) . '.' . $this -> protocolo . '.' . $ver;
		} else {
			$caae = $nr;
		}

		$sql = "select * from cep_protocolos where cep_caae = '" . $caae . "' ";
		$rlt = db_query($sql);
		if (!($line = db_read($rlt))) {
			$sql = "update cep_protocolos set cep_caae = '" . trim($caae) . "' where id_cep = " . $this -> id_cep;
			$rlt = db_query($sql);
			$this->caae = trim($caae);
			return (1);
		} else {
			if ($line['id_cep'] == $this -> id_cep) {
				$sql = "update cep_protocolos set cep_caae = '" . trim($caae) . "' where id_cep = " . $this -> id_cep;
				$rlt = db_query($sql);
				$this->caae = trim($caae);
				return (1);
			} else {
				echo '<img src="img/icone_error.png" width=64 align="left">';
				echo msg('caae_already_exist');
				echo '<meta HTTP-EQUIV="Refresh" CONTENT="5; URL = ' . page() . '">';
				exit ;
			}
		}

	}

	function action_004() {
		global $dd;
		$this -> cep_historic_append($ac, msg('send_to_assign'));
		$this -> cep_create_caae();
		//$this->cep
		$this -> cep_status_alter('B');
		$this -> comunication_research(msg('email_accepted_evaluation'));
		redirecina('protocol_detalhe.php');
		return (1);
	}

	function action_005() {
		global $dd, $acao, $_POST, $date;
		$proto = $this -> protocolo;
		$author = $this -> line['cep_pesquisador'];
		$sql = "select * from usuario 
					left join cep_dictamen on (us_codigo = pp_avaliador and pp_protocolo = '$proto' )
					left join institutions on it_codigo = us_empresa
					where us_ativo = 1 and us_perfil like '%#ADC%' 
					and us_codigo <> '$author'
					";
		$qrlt = db_query($sql);
		$sel = 0;
		$sql = array();
		while ($line = db_read($qrlt)) {
			$id = $line['id_us'];
			$ddx = $_POST['dda' . $id];
			$dds = '';
			if (strlen($ddx) > 0) {
				$data = date("Ymd");
				$hora = date("H:i");
				$avaliador = $line['us_codigo'];
				$dds = 'checked';
				$sel++;
				$sql = "select * from cep_dictamen 
										where pp_avaliador = '$avaliador' and
										pp_protocolo = '$proto' ";
				$rrlt = db_query($sql);
				if (!($rline = db_read($rrlt))) {
					$this -> cep_historic_append('010', msg('indicate_avaliation_to'));
					/** Indicate new avaliation */
					$sql = "insert into cep_dictamen 
									( pp_nrparecer, pp_tipo, pp_protocolo,
									  pp_protocolo_mae, pp_avaliador, pp_revisor,
									  pp_status, pp_pontos, pp_pontos_pp,
									  pp_data, pp_hora, pp_parecer_data, pp_parecer_hora, 
									  pp_data_leitura 
									) values (
									 '','PAREC','$proto',
									 '','$avaliador','$revisor',
									 '@',0,0,
									 $data,'$hora',19000101,'00:00',
									 19000101)";
					$xrlt = db_query($sql);
				} else {
					$this -> cep_historic_append('011', msg('renew_avaliation_to'));
					/* Renew avaliation */
					$sql = "update cep_dictamen
											set pp_status = '@',
											pp_data = $data,
											pp_hora = '$hora'
											where pp_avaliador = '$avaliador' and
										pp_protocolo = '$proto' ";
					$xrlt = db_query($sql);

				}
				/* Enviar e-mail */
				$ic = new ic;
				$codi = 'indicate_adhoc_email';
				$icr = $ic -> ic($codi);
				$txt = $icr['text'];
				$protocol = trim($this -> line['cep_caae']);
				$subject = $icr['title'];
				$nnn = trim($line['us_nome']);
				$txt = mst(troca($txt, '$name', $nnn));
				$txt = mst(troca($txt, '$protocol', $protocol));
				$txt = mst(troca($txt, '$title', $this -> line['cep_titulo']));
				$txt = mst(troca($txt, '$link', $link));

				/* Enviar e-mail */
				$email1 = trim($line['us_email']);
				$email2 = trim($line['us_email_alt]']);
				if (strlen($email1) > 0) { enviaremail($email1, '', $subject, $txt);
				}
				if (strlen($email2) > 0) { enviaremail($email2, '', $subject, $txt);
				}
			}

			$sx .= '<TR>';
			$sx .= '<TD width="5">';
			$sx .= '<input type="checkbox" name="dda' . $id . '" value=1 ' . $dds . '>';
			$sx .= '<TD>';
			$sx .= $line['us_nome'];
			$sx .= '<TD>';
			$sx .= $line['it_nome'];
			$sx .= '<TD>';
			$sx .= $line['us_email'];
			$sx .= '<TD align="center">';
			$data = $line['pp_data'];
			if ($data > 20000101) { $data = $date -> stod($data);
			} else { $data = '';
			}
			$sx .= $data;

			/* Status */
			$sx .= '<TD align="center">';
			$pp_status = $line['pp_status'];
			if (strlen($pp_status) > 0) {
				if ($pp_status == '@') { $sx .= msg('dic_sta_@');
				}
				if ($pp_status == 'A') { $sx .= msg('dic_sta_A');
				}
				if ($pp_status == 'B') { $sx .= msg('dic_sta_B');
				}
				if ($pp_status == 'X') { $sx .= msg('dic_sta_X');
				}
			} else {
				$sx .= '-';
			}
		}
		/**
		 *
		 */
		if ($sel > 0) {
			//$this->cep_status_alter('C');
			redirecina(page());
		}

		$sa = '<table width="100%" class="lt1" class="table_proj">';
		$sa .= '<TR><TD><form method="post" action="' . page() . '">';
		$sa .= '
				<input type="hidden" name="dd1" value="' . $dd[1] . '">
				<input type="hidden" name="dd2" value="' . $dd[2] . '">
				<input type="hidden" name="dd3" value="' . $dd[3] . '">
				<input type="hidden" name="dd90" value="' . $dd[90] . '">
				';

		$sa .= '<TR bgcolor="#808080"><TH>sel<TH>' . msg('name');
		$sa .= '<TH>' . msg('instituion');
		$sa .= '<th>e-mail<TH>' . msg('indicate_data');
		$sa .= '<TH>' . msg('indicate_status');
		$sa .= $sx;
		$sa .= '<TR><TD colspan=5><input type="submit" value="' . msg('define_evaluator_btn') . '" name="dd6"  class="form_submit">';
		$sa .= '<TR><TD></form>';
		$sa .= '</table>';
		//$this->cep_historic_append($ac,msg('protocol_accept'));
		//$this->cep_status_alter('A');
		return ($sa);
	}

	function action_090() {
		global $dd;
		$this -> cep_historic_append($ac, msg('exenta_avaliation'));
		$this -> cep_status_alter('Y');
		redirecina('protocol_detalhe.php');
		return (1);
	}

	function action_099() {
		global $dd;
		$this -> cep_historic_append($ac, msg('close_avaliation'));
		$this -> cep_status_alter('Z');
		redirecina('protocol_detalhe.php');
		return (1);
	}

	function action_011() {
		global $dd, $acao, $ss;
		$act = msg('confirm_metting');
		if (($acao == $act) and (strlen($dd[2]) > 0)) {
			$sql = "update " . $this -> tabela . " set
							cep_reuniao = " . round($dd[2]) . "
					where id_cep = " . $this -> id_cep;
			$rlt = db_query($sql);
			$this -> cep_historic_append('011', msg('indicate_to_meeting'));
			$this -> cep_status_alter('D');
			redirecina(page());
		}
		$sx .= '<fieldset><legend>' . msg('action_001') . '</legend>';
		$sx .= '<form>';
		$sx .= msg('inform_meeting_date');
		$sx .= ' ';
		$sx .= '<select name="dd2">';
		$sql = "select * from calender where cal_date >= " . date("Ymd");
		$sql .= " and cal_cod = '001' order by cal_date ";
		$rlt = db_query($sql);

		while ($line = db_read($rlt)) {
			$sx .= '<option value="' . $line['cal_date'] . '">';
			$sx .= stodbr($line['cal_date']);
			$sx .= '</option>';
		}
		$sx .= '</select>';
		$sx .= '<BR>';
		$sx .= '<input type="submit" name="acao" value="' . $act . '"  class="form_submit">';
		$sx .= '</form>';

		$sx .= '<br>' . '<A HREF="admin_calender.php" target="new" class="link lt1">' . msg("change") . ' ' . msg('scheduled_meeting') . '</A>';
		$sx .= '</fieldset>';
		return ($sx);
	}

	function action_012() {
		global $dd, $acao, $ss;

		$sql = "select * from cep_ged_documento where doc_dd0 = '" . $this -> protocolo . "' 
				and doc_tipo = 'DICTM' and doc_ativo = 1";
		$rlt = db_query($sql);
		$exist = 0;
		if (!($line = db_read($rlt))) {
			$act = msg('submit');
			$sx .= '<fieldset><legend><A NAME="dictame"></A>' . msg('action_012') . '</legend>';
			$sx .= '<div id="dictame">';
			$protocol = $this -> line['cep_protocol'];
			$tipo = $this -> line['cep_tipo'];

			$sx .= $this -> dictame_show($protocol, $tipo);
			$sx .= '</div>';
			$sx .= '</fieldset>';
		}
		return ($sx);
	}

	function action_014() {
		global $dd, $acao, $ss;
		$act = msg('reedit_draft_opinion');
		if ($acao == $act) {
			$this -> cep_historic_append('013', msg('return_to_edition'));
			$this -> cep_status_alter('D');
			redirecina(page());
		}
		$sx .= '<fieldset><legend>' . msg('action_014') . '</legend>';
		$sx .= '<form>';
		$sx .= msg('reedit_draft_opinion_inf');
		$sx .= ' ';
		$sx .= '<BR>';
		$sx .= '<input type="submit" name="acao" value="' . $act . '"  class="form_submit">';
		$sx .= '</form>';
		$sx .= '</fieldset>';
		return ($sx);
	}

	function salvar_decisao_no_protocolo() {
		$proto = $this -> protocolo;
		$sql = "select * from cep_parecer where pr_protocol = '$proto' order by id_pr desc ";
		$rlt = db_query($sql);
		$line = db_read($rlt);
		$tipo = trim($line['pr_situacao']);
		$sql = "update cep_protocolos set 
					cep_pr_protocol = 'pm_" . $tipo . "'
					where cep_protocol = '$proto' 
		";
		$rlt = db_query($sql);
		return (1);
	}

	function action_021() {
		global $acao, $dd;
		$act = msg('finish_avaliation_act');
		if ($acao == $act) {
			$this -> salvar_decisao_no_protocolo();
			$this -> avaliaca_declinar();
			$this -> cep_historic_append('021', msg('finish_avaliation'));
			$this -> cep_status_alter('E');
			redirecina(page());
		}

		$sx .= '<fieldset><legend>' . msg('action_021') . '</legend>';
		$sx .= '<form>';
		$sx .= msg('finish_avaliation');
		$sx .= ' ';
		$sx .= '<BR>';
		$sx .= '<input type="submit" name="acao" value="' . $act . '"  class="form_submit">';
		$sx .= '</form>';

		$sx .= '</fieldset>';
		return ($sx);
	}

	function action_020() {
		global $dd, $acao, $ss;
		$act = msg('reedit_draft_opinion');
		if ($acao == $act) {
			$this -> cep_historic_append('020', msg('upload_draft_opinion'));
			$this -> cep_status_alter('D');
			redirecina(page());
		}
		$sx .= '<fieldset><legend>' . msg('action_020') . '</legend>';
		$sql = "select * from cep_ged_documento where doc_dd0 = '" . $this -> protocolo . "' and doc_tipo = 'DICTM' and doc_ativo = 1";
		$rlt = db_query($sql);
		$exist = 0;
		if ($line = db_read($rlt)) {
			$exist = 1;
			$idd = $line['id_doc'];
		}

		if ($exist == 1) {
			/* Remove */
			$sx .= msg('remove_draft_opinion_inf');
			$sx .= ' ';
			$sx .= '<BR>';

			$onclick = 'onclick="newwin2(\'ged_remove_restrict.php?dd0=' . $idd . '&dd90=' . checkpost($idd) . '&dd1=' . $this -> protocolo . '&dd2=DICTM\',100,100);" ';
			$sx .= '<input type="button" class="form_submit" value="' . msg('remove_dictamen') . '" ' . $onclick . '>';
		} else {
			/* Upload */
			$sx .= msg('upload_draft_opinion_inf');
			$sx .= ' ';
			$sx .= '<BR>';

			$onclick = 'onclick="newwin2(\'ged_upload_restrict.php?dd1=' . $this -> protocolo . '&dd2=DICTM\',800,400);" ';
			$sx .= '<input type="button" class="form_submit" value="' . msg('upload_dictamen') . '" ' . $onclick . '>';
		}
		$sx .= '</fieldset>';
		return ($sx);
	}

	function avaliaca_declinar() {
		/* Declinar avaliacao nao realizada */
		$proto = $this -> protocolo;
		$sql = "update cep_dictamen set pp_status ='D' 
				where (pp_protocolo = '$proto') and (pp_status = '@')
				";
		$rlt = db_query($sql);
	}

	function email_communicate_investigator() {
		global $ic;
		$ttt = $ic -> ic("communicate_investig");
		$subj = $ttt['title'];
		$txt = $ttt['text'];

		$nome = $this -> line['us_nome'];
		$email1 = $this -> line['us_email'];
		$email2 = $this -> line['us_email_alt'];
		$caae = $this -> line['cep_caae'];

		$txt = troca($txt, '$caae', $caae);
		$txt = troca($txt, '$nome', $nome);

		if (strlen($email1) > 0) { enviaremail($email1, '', $subj, $txt);
		}
		if (strlen($email2) > 0) { enviaremail($email2, '', $subj, $txt);
		}
		echo 'e-mail enviado';
		echo '<BR><B>' . $subj . '</B>';
		echo '<BR>' . $txt;
	}

	function action_013() {
		global $dd, $acao, $ss;
		$act = msg('communicate_013');
		if ($acao == $act) {
			$sql = "update " . $this -> tabela . " set
							cep_dt_parecer = " . date("Ymd") . ",
							cep_dt_liberacao = " . date("Ymd") . ",
							cep_atualizado = " . date("Ymd") . "
					where id_cep = " . $this -> id_cep;
			$rlt = db_query($sql);

			$this -> altera_status_submissao('Z');
			$this -> cep_historic_append('013', msg('investigator_reported'));
			$this -> cep_status_alter('P');
			$this -> libera_tipo_parecer();
			$this -> email_communicate_investigator();

			redirecina(page());
		}
		$sx .= '<fieldset><legend>' . msg('action_013') . '</legend>';
		$sx .= '<form>';
		$sx .= msg('communicate_investigator_inf');
		$sx .= ' ';
		$sx .= '<BR>';
		$sx .= '<input type="submit" name="acao" value="' . $act . '"  class="form_submit">';
		$sx .= '</form>';
		$sx .= '</fieldset>';
		return ($sx);
	}

	function altera_status_submissao($para) {
		$proto = $this -> line['cep_fr'];
		$sql = "update cep_submit_documento set doc_status = '$para' where doc_protocolo = '$proto' ";
		$rlt = db_query($sql);
	}

	function dictame_show($caae, $tipo) {
		$sx = '
			<script>
			var v2 = "post";
			
			$.ajax({
			 				url: "dictamen_ajax.php",
			 				type: "POST",
			 				data: { dd1: "' . $caae . '", dd41: "' . $tipo . '", dd90: v2  }
			 		 }) 
					.fail(function() { alert("error #05"); })
			 		.success(function(data) { $("#dictame").html(data); });
			</script>
			';
		return ($sx);
	}

	function action_002() {
		global $dd, $acao, $_POST, $date;
		$proto = $this -> protocolo;
		$author = $this -> line['cep_pesquisador'];
		$sql = "select * from usuario 
					left join cep_dictamen on (us_codigo = pp_avaliador and pp_protocolo = '$proto' )
					left join institutions on it_codigo = us_empresa
					where us_ativo = 1 and us_perfil like '%#MEM%' 
					and us_codigo <> '$author'
					";
		$qrlt = db_query($sql);
		$sel = 0;
		$sql = array();
		while ($line = db_read($qrlt)) {
			$id = $line['id_us'];
			$ddx = $_POST['dda' . $id];
			$dds = '';
			if (strlen($ddx) > 0) {
				$data = date("Ymd");
				$hora = date("H:i");
				$avaliador = $line['us_codigo'];
				$dds = 'checked';
				$sel++;
				$sql = "select * from cep_dictamen 
										where pp_avaliador = '$avaliador' and
										pp_protocolo = '$proto' ";
				$rrlt = db_query($sql);
				if (!($rline = db_read($rrlt))) {
					$this -> cep_historic_append('010', msg('indicate_avaliation_to'));
					/** Indicate new avaliation */
					$sql = "insert into cep_dictamen 
									( pp_nrparecer, pp_tipo, pp_protocolo,
									  pp_protocolo_mae, pp_avaliador, pp_revisor,
									  pp_status, pp_pontos, pp_pontos_pp,
									  pp_data, pp_hora, pp_parecer_data, pp_parecer_hora, 
									  pp_data_leitura 
									) values (
									 '','PAREC','$proto',
									 '','$avaliador','$revisor',
									 '@',0,0,
									 $data,'$hora',19000101,'00:00',
									 19000101)";
					$xrlt = db_query($sql);
				} else {
					$this -> cep_historic_append('011', msg('renew_avaliation_to'));
					/* Renew avaliation */
					$sql = "update cep_dictamen 
											set pp_status = '@',
											pp_data = $data,
											pp_hora = '$hora'
											where pp_avaliador = '$avaliador' and
										pp_protocolo = '$proto' ";
					$xrlt = db_query($sql);

				}
				/* Enviar e-mail */
				$ic = new ic;
				$codi = 'indicate_email';
				$icr = $ic -> ic($codi);
				$txt = $icr['text'];
				$protocol = trim($this -> line['cep_caae']);
				$subject = $icr['title'];
				$nnn = trim($line['us_nome']);
				$txt = mst(troca($txt, '$name', $nnn));
				$txt = mst(troca($txt, '$protocol', $protocol));
				$txt = mst(troca($txt, '$title', $this -> line['cep_titulo']));
				$txt = mst(troca($txt, '$link', $link));

				/* Enviar e-mail */
				$email1 = trim($line['us_email']);
				$email2 = trim($line['us_email_alt]']);
				if (strlen($email1) > 0) { enviaremail($email1, '', $subject, $txt);
				}
				if (strlen($email2) > 0) { enviaremail($email2, '', $subject, $txt);
				}
				enviaremail('renefgj@gmail.com', '', $subject, $txt);
			}

			$sx .= '<TR>';
			$sx .= '<TD width="5">';
			$sx .= '<input type="checkbox" name="dda' . $id . '" value=1 ' . $dds . '>';
			$sx .= '<TD>';
			$sx .= $line['us_nome'];
			$sx .= '<TD>';
			$sx .= $line['it_nome'];
			$sx .= '<TD>';
			$sx .= $line['us_email'];
			$sx .= '<TD align="center">';
			$data = $line['pp_data'];
			if ($data > 20000101) { $data = $date -> stod($data);
			} else { $data = '';
			}
			$sx .= $data;

			/* Status */
			$sx .= '<TD align="center">';
			$pp_status = $line['pp_status'];
			if (strlen($pp_status) > 0) {
				if ($pp_status == '@') { $sx .= msg('dic_sta_@');
				}
				if ($pp_status == 'A') { $sx .= msg('dic_sta_A');
				}
				if ($pp_status == 'B') { $sx .= msg('dic_sta_B');
				}
				if ($pp_status == 'X') { $sx .= msg('dic_sta_X');
				}
			} else {
				$sx .= '-';
			}
		}
		/**
		 *
		 */
		if ($sel > 0) {
			//$this->cep_status_alter('C');
			redirecina(page());
		}

		$sa = '<table width="100%" class="lt1" class="table_proj">';
		$sa .= '<TR><TD><form method="post" action="' . page() . '">';
		$sa .= '
				<input type="hidden" name="dd1" value="' . $dd[1] . '">
				<input type="hidden" name="dd2" value="' . $dd[2] . '">
				<input type="hidden" name="dd3" value="' . $dd[3] . '">
				<input type="hidden" name="dd90" value="' . $dd[90] . '">
				';

		$sa .= '<TR bgcolor="#808080"><TH>sel<TH>' . msg('name');
		$sa .= '<TH>' . msg('instituion');
		$sa .= '<th>e-mail<TH>' . msg('indicate_data');
		$sa .= '<TH>' . msg('indicate_status');
		$sa .= $sx;
		$sa .= '<TR><TD colspan=5><input type="submit" value="' . msg('define_evaluator_btn') . '" name="dd6" class="form_submit" >';
		$sa .= '<TR><TD></form>';
		$sa .= '</table>';
		//$this->cep_historic_append($ac,msg('protocol_accept'));
		//$this->cep_status_alter('A');
		return ($sa);
	}

	function libera_tipo_parecer() {
		$sql = "update cep_ged_documento set 
					doc_tipo = 'DICT' 
					where doc_tipo = 'DICTM' 
						and doc_dd0 = '" . $this -> protocolo . "'
						and doc_ativo = 1 ";
		$rlt = db_query($sql);
		return (1);
	}

	function action_display($bt) {
		global $dd, $acao, $ss, $perfil;
		$js = '';
		$sx .= '<table width="100%" class="lt2">';
		for ($r = 0; $r < count($bt); $r++) {
			$action = $bt[$r][1];
			$color = $bt[$r][2];
			$caption = $bt[$r][0];

			$sx .= chr(13) . '<TR>';
			$sx .= '<TD width=5>';
			$sx .= '<input type="button" id="chk' . $r . '" value="' . msg($caption) . '" style="width: 300px; height: 30px;">';
			$hd = 'style="display: none;"';

			/* Não ocultar */
			if ($action == '015') { $hd = '';

			}
			if ($dd[3] == $action) { $hd = '';
			}
			$sx .= '<TR><TD>';
			$sx .= chr(13);
			$sx .= '<div id="chkdiv' . $r . '" ' . $hd . '>' . chr(13);

			/* */
			if ($action == '003') { $sx .= $this -> action_003();
			}

			/* Indicar para Reunião */
			if ($action == '011') { $sx .= $this -> action_011();
			}

			/* Aceitar projeto para avaliação */
			if ($action == '009') { $sx .= $this -> action_009();
			}

			/* Somente to Admin and Secretary */
			if ($perfil -> valid('#ADM#SCR#COO')) {
				/* Indicar avaliadores */
				if ($action == '002') { $sx .= $this -> action_002();
				}
				/* Indicar avaliadores adhoc */
				if ($action == '005') { $sx .= $this -> action_005();
				}
				/* Informar o número do NIEC */
				if ($action == '017') { $sx .= $this -> action_017();
				}
			}
			if ($action == '015') { $sx .= $this -> action_015();
			}
			if ($action == '016') { $sx .= $this -> action_016();
			}
			if ($action == '012') { $sx .= $this -> action_012();
			}
			if ($action == '013') { $sx .= $this -> action_013();
			}
			if ($action == '014') { $sx .= $this -> action_014();
			}
			if ($action == '020') { $sx .= $this -> action_020();
			}
			if ($action == '021') { $sx .= $this -> action_021();
			}
			$sx .= '<font class="lt0">' . $action . '</font>';
			$sx .= '</div>' . chr(13);

			$js .= chr(13) . ' $("#chk' . $r . '").click(function () {
							 $("#chkdiv' . $r . '").toggle(\'slow\'); }); 
					';
			$js .= chr(13) . ' $("#A' . $action . 'i").click(function () {
							 $("#chkdiv' . $r . '").toggle(\'slow\'); }); 
					';
		}
		$sx .= '</table>';

		$sx .= chr(13) . '<script>';
		$sx .= $js;
		$sx .= chr(13) . '</script>';

		return ($sx);
	}

	function action_options($ac) {
		global $user, $perfil;
		$bt = array();
		$btx = array();
		/* se status @ */

		/* valida se já exist dictamen */
		$sql = "select * from cep_ged_documento where doc_dd0 = '" . $this -> protocolo . "' and doc_tipo = 'DICTM' and doc_ativo = 1";
		$rlt = db_query($sql);
		$exist = 0;
		$wh = '';
		if ($line = db_read($rlt)) {
			$exist = 1;
			$wh = " and actionp_action <> '012' ";
		} else {
			$exist = 0;
			$wh = " and actionp_action <> '021' ";
		}

		/* Seleciona Action */
		$sql = "select * from cep_action 
				inner join cep_action_permission on action_code = actionp_action 
			where action_status = '$ac' and action_ativa = 1 $wh
			order by actionp_action
			";

		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			$code = $line['action_code'];
			$perf = trim($line['actionp_perfil']);

			if ($perfil -> valid($perf)) {
				$xok = round('0' . in_array($code, $btx));
				if (!($xok == 1)) {
					array_push($bt, array(trim($line['action_caption']), $code, $line['action_color']));
					array_push($btx, $code);
				}
			}
		}
		return ($bt);

	}

	function communication_research($msg) {
		return (True);
	}

	function communication_members($msg) {
		$ic = new ic;
		$msg = $ic -> ic('survey_email');

		$title = $this -> line['cep_titulo'];

		$email_title = $msg['title'];
		$email_body = $msg['text'];

		$email_body = troca($email_body, '$TITLE', $titulo);

		$sql = "SELECT * FROM usuario_perfis_ativo
						inner join usuario on up_usuario  = us_cracha
					where up_perfil = '#MEM' and up_ativo = 1
				";
		$rlt = db_query($sql);
		$sx .= '<h4>' . msg('members') . '</h4>';
		$sx .= '<font class="lt1">';
		while ($line = db_read($rlt)) {
			$email = trim($line['us_email']);

			$sx .= msg('communicate') . ' ' . trim($line['us_nome']) . ' ';

			if (strlen($email)) {
				$sx .= '<font color="green">ok</font><BR>';
				enviaremail($email, '', $email_title, $email_body);
			} else {
				$sx .= '<font color="red">error</font><BR>';
			}
		}
		return ($sx);
	}

	function action($ac) {

		/* Indique avaliation */
		if ($ac == '099') { $this -> action_099();
		}

		/* Indique avaliation */
		if ($ac == '090') { $this -> action_090();
		}

		/* Indique avaliation */
		if ($ac == '002') { $this -> action_002();
		}
		/* Accept to Meet */
		if ($ac == '019') {
			$this -> cep_historic_append($ac, msg('accept_to_meet'));
			$this -> cep_status_alter('C');
			redirecina('protocol_detalhe.php');
		}

		/* Accept Submission */
		if ($ac == '001') { $this -> action_001();
		}

		/* Accept Submission */
		if ($ac == '004') { $this -> action_004();
		}

		/* Cancelar protocolo */
		if ($ac == '999') {
			$this -> cep_historic_append($ac, msg('protocol_cancel'));
			$this -> cep_status_alter('X');
			redirecina('protocol_detalhe.php');
		}
		return (1);
	}

	function change_status_files_submited() {
		$versao = $this -> versao;
		$proto = $this -> protocolo_submission;
		$sql = "update cep_ged_documento set doc_status = 'A' ";
		$sql .= " where doc_dd0 =  '$proto'
						and doc_ativo = 1 ";
		$rlt = db_query($sql);

		$proto = $this -> protocolo;
		$sql = "update cep_ged_documento set doc_status = 'A' ";
		$sql .= " where doc_dd0 =  '$proto'
						and doc_versao = '$versao'
						and doc_ativo = 1
						";
		$rlt = db_query($sql);
		return (1);
	}

	/* e-mail de confirmação de envio de protocolo */
	function confirm_submission_by_email() {
		global $LANG;
		$ic = new ic;
		$ic = $ic -> ic('email_confirm_subm');
		
		$this->le($this->protocolo_cep);
		$sx = $this -> mostra_email($this->line);

		$texto = mst(utf8_decode($ic['text']));
		$subject = utf8_decode($ic['title']);
		
		$texto = troca($texto,'$TITLE',$sx);
		
		$texto = troca($texto,'$INFORMACION_DEL_PROTOCOLO',$sx);
		$texto = troca($texto,'$PROTOCOL_INFORMATION',$sx);
		
		$texto = troca($texto,'$INFORMACION_DEL_COMITTE',$sx);
		$texto = troca($texto,'$COMMITTEE_INFORMATION',$sx);		

		$emails = $this -> email_autores();
		
		for ($r=0;$r < count($emails);$r++)
			{
				$email = $emails[$r];
				//echo '<BR>'.msg('send_to_email').':'.$email;
				enviaremail($email, '', $subject, $texto);		
			}		
	}
	
	function confirm_notify_by_email() {
		global $LANG, $hd;
		
		$email_cep = $hd->email_replay;
		$email_nome = $hd->title;
		
		$ic = new ic;
		$ic = $ic -> ic('email_notify_subm');
		
		$this->le($this->protocolo_cep);
		$sx = $this -> mostra_email($this->line);

		$texto = mst(utf8_decode($ic['text']));
		$subject = utf8_decode($ic['title']);
		
		$texto = troca($texto,'$INFORMACION_DEL_PROTOCOLO',$sx);
		$texto = troca($texto,'$PROTOCOL_INFORMATION',$sx);
		$texto = troca($texto,'$TITLE',$sx);
		
		$texto = troca($texto,'$INFORMACION_DEL_COMITTE',$sx);
		$texto = troca($texto,'$COMMITTEE_INFORMATION',$sx);		

		$emails = array();
		array_push($emails,$email_cep);

		for ($r=0;$r < count($emails);$r++)
			{
				$email = $emails[$r];
				//echo '<BR>'.msg('send_to_email').':'.$email;
				enviaremail($email, '', $subject, $texto);		
			}		
	}	

	function email_autores() {
		$proto = $this -> protocolo_cep;
		$sql = "select * from cep_team 
						inner join usuario on ct_author = us_codigo
					where ct_protocol = '$proto'
			";
		$rlt = db_query($sql);
		$emails = array();
		while ($line = db_read($rlt)) {
			$email1 = trim($line['us_email']);
			$email2 = trim($line['us_email_alt']);
			if (strlen($email1) > 0) { array_push($emails, $email1);
			}
			if (strlen($email2) > 0) { array_push($emails, $email2);
			}
		}
		return ($emails);
	}

	function envia_arquivos_submissao_apreciacao() {
		$protocolo = $this -> protocolo_submission;
		$sql = "select * from cep_ged_documento
				where doc_dd0 = '$protocolo' and doc_ativo = 1 ";
		$rlt = db_query($sql);

		$ged = new ged;
		$ged -> tabela = 'cep_ged_documento';
		$ged -> protocol = $this -> protocolo;

		while ($line = db_read($rlt)) {
			$ged -> file_type = $line['doc_tipo'];
			$ged -> file_name = $line['doc_filename'];
			$ged -> file_data = date("Ymd");
			$ged -> file_time = date("H:i");
			$ged -> file_saved = $line['doc_arquivo'];
			$ged -> file_size = $line['doc_size'];
			$ged -> versao = $this -> versao;
			$ged -> save();
		}
		return (1);
	}

	/* Create a PDF file with Submit Project */
	function limpa_projetos_anteriores() {
		$versao = $this -> versao;
		$proto = $this -> protocolo_submission;
		$sql = "update cep_ged_documento set doc_ativo = 0 ";
		$sql .= " where doc_dd0 =  '$proto'
						and doc_tipo = 'PROJ' ";
		$rlt = db_query($sql);

		$proto = $this -> protocolo;
		$sql = "update cep_ged_documento set doc_ativo = 0 ";
		$sql .= " where doc_dd0 =  '$proto'
						and doc_versao = '$versao'";
		$rlt = db_query($sql);
		return (1);
	}

	function create_pdf_submit_file() {
		global $dd, $include, $ged;
		$destino = 'document/' . date("Y") . '/' . date("m") . '/';
		$fdestino .= $this -> protocolo_submission . '-' . substr(md5($this -> protocolo_submission . date("Ymdhis")), 0, 5) . '-' . $this -> versao . '-project.pdf';
		$destino = $destino . $fdestino;
		$dd[0] = $this -> protocolo_submission;
		require ("submit_pdf_projeto.php");
		$ged = new ged;
		$ged -> tabela = 'cep_ged_documento';
		$ged -> protocol = $this -> protocolo_submission;
		$ged -> file_type = 'PROJ';
		$ged -> file_name = 'Proposal_' . $this -> protocolo . '_v' . $this -> versao . '.pdf';
		$ged -> file_data = date("Ymd");
		$ged -> file_time = date("H:i");
		$ged -> file_saved = $destino;
		$ged -> file_size = filesize($destino);
		$ged -> save();
		return ($destino);
	}

	function cep_submit_status_alter($op) {
		$sql = "update cep_submit_documento set doc_status = '" . $op . "' where doc_protocolo = '" . $this -> protocolo_submission . "' ";
		$rlt = db_query($sql);
		return (1);
	}

	function cep_status_alter($op) {
		$caae = $this -> caae;

		if (strlen($caae) > 0) {
			$sql = "update " . $this -> tabela . " 
					set cep_status = '" . $op . "' 
					where (cep_caae = '$caae') 
					and cep_status = '" . $this -> status . "' ";
			$this -> status = $op;
		} else {
			$sql = "update " . $this -> tabela . " 
					set cep_status = '" . $op . "' 
					where id_cep = " . round($this -> id_cep) . "  
					and cep_status = '" . $this -> status . "' ";
			$this -> status = $op;
		}
		$rlt = db_query($sql);
		return (1);
	}

	function le($id = '') {
		if (strlen($id) > 0) { $this -> id_cep = $id;
		}
		$sql = "select * from " . $this -> tabela . " ";
		$sql .= " left join usuario on us_codigo = cep_pesquisador ";
		$sql .= " left join ajax_pais on us_country = pais_codigo ";
		$sql .= " left join cep_status on cep_status = ess_status ";
		$sql .= " where id_cep = " . sonumero("0" . $this -> id_cep);

		$rlt = db_query($sql);
		$line = db_read($rlt);
		$this -> line = $line;
		$this -> protocolo = trim($this -> line['cep_protocol']);
		$this -> codigo = $this -> line['cep_codigo'];
		$this -> status = $this -> line['cep_status'];
		$this -> cep_dictamen = $this -> line['cep_dictamen'];
		$this -> protocolo_submission = $this -> line['cep_fr'];
		$this -> caae = trim($line['cep_caae']);

		return (1);
	}

	function cep_historic_append($cod, $comment) {
		global $ss;
		$time = date("H:i");
		$data = date("Ymd");
		$protocol = $this -> protocolo;
		$caae = $this -> caae;
		$log = $ss -> user_codigo;

		$sql = "select * from cep_protocolos_historic 
					where his_data = $data and his_protocol = '$protocol'
					and his_codigo = '$cod'	and his_caae = '$caae' ";
		$rlt = db_query($sql);
		if (!($line = db_read($rlt))) {
			$sql = "insert into cep_protocolos_historic
					(his_data, his_time, his_codigo, 
					his_comment, his_log, his_protocol, his_caae )
					values
					($data,'$time','$cod',
					'$comment','$log','$protocol', '$caae' )";
			$rlt = db_query($sql);

			$sql = "update " . $this -> tabela . " set cep_atualizado = " . date("Ymd");
			$sql .= " where cep_protocol = '" . $this -> protocolo . "' ";
			$rlt = db_query($sql);
		}
	}

	function cep_historic() {
		global $messa;
		$sql = "select * from cep_protocolos_historic 
				where his_protocol = '" . $this -> protocolo . "' 
				order by his_data, his_time, id_his ";
		$rlt = db_query($sql);

		$sx .= '<table width="100%" class="lt1" cellpadding=2 cellspacing=0 border=1>';
		$sx .= '<TR>';
		$sx .= '<TH width="7%">' . msg('hd_data');
		$sx .= '<TH width="7%">' . msg('hd_hora');
		$sx .= '<TH width="70%">' . msg('hd_comment');
		//$sx .= '<TH width="6%">'.msg('hd_log');
		$to = 0;
		while ($line = db_read($rlt)) {
			$to++;
			$sx .= '<TR>';
			$sx .= '<TD align="center">';
			$sx .= stodate($line['his_data']);
			$sx .= '<TD align="center">';
			$sx .= $line['his_time'];
			$sx .= '<TD>';
			$sx .= $line['his_comment'];
			//$sx .= '<TD>';
			//$sx .= $line['his_log'];
		}
		if ($to == 0) { $sx .= msg('not_log');
		}
		$sx .= '</table>';
		return ($sx);
	}

	function parecer() {
		$sql = "select * from " . $this -> tabela . " ";
		//$sql .= " left join ".$parecer." on (pr_protocol = cep_protocol) and (pr_versao = cep_versao) ";
		$sql .= " left join usuario on cep_relator = us_codigo ";
		$sql .= " where cep_protocol = '" . trim($this -> protocolo) . "' order by cep_versao desc ";
		$frlt = db_query($sql);
		$sp = '';
		$st = msg('hist_parecer');
		$sp .= '	<TR class="lt0"><TH>' . msg('parecer_nr') . '</TH><TH>' . msg('protocol_version') . '</TH><TH>' . msg('date') . '</TH><TH>' . msg('hour') . '</TH>';
		$sp .= '<TH>' . msg('relator') . '</TH><TH>' . msg('cep_dt_ciencia_pesq') . '</TH><TH>Obs</TH></TR>';
		$col = 1;
		while ($fline = db_read($frlt)) {
			$enf = '';
			if (trim($versao) == trim($fline['cep_versao'])) { $enf = '<B>';
			}
			$link = $enf . '<A HREF="parecer_mostrar.php?dd0=' . $fline['id_cep'] . '&dd1=' . $fline['pr_data'] . '&dd2=' . $fline['pr_hora'] . '" target="_blank">';
			$link2 = '<A HREF="protocol_detalhe.php?dd0=' . $fline['id_cep'] . '&dd90=' . checkpost($fline['id_cep']) . '" >';
			$sp .= '<TR valign="top"class="lt1" >';

			$sp .= '<TD align="center">';
			$sp .= $link;
			$sp .= ($fline['pr_nr']);

			$sp .= '<TD align="center">';
			$sp .= $link2;
			$sp .= trim($fline['cep_protocol']);
			$sp .= '</A> ';
			$sp .= $link2 . 'v.';
			$sp .= trim($fline['cep_versao']);

			$dtc = $fline['pr_data'];
			if ($dtc > 19000101) { $dtc = stodbr($dtc);
			} else { $dtc = '-';
			}
			$sp .= '<TD align="center">' . $dtc . '</TD>';

			$sp .= '<TD align="center">';
			$sp .= trim($fline['pr_hora']);

			$sp .= "<TD>" . $fline['us_nome'] . '</TD>';
			$dtc = $fline['cep_dt_ciencia'];
			if ($dtc > 19000101) { $dtc = stodbr($dtc);
			} else { $dtc = '-';
			}
			$sp .= '<TD align="center">' . $dtc . '</TD>';

			$dtv = '<font color=red >Parecer da v.' . trim($fline['cep_versao']) . '</font>';

			if (strlen(trim($fline['pr_nr'])) == 0) { $dtv = '<font color="#00cc99" ><B>sem parecer</B>';
			}
			$sp .= '<TD align="center">' . $dtv . '</TD>';
		}
		$sx = $sp;
		return ($sx);
	}

	function mostra_status($st) {
		$sta = msg('cep_status_' . $st);
		return ($sta);
	}

	function investigadores($line) {
		$sql = "select * from cep_team 
			inner join usuario on us_codigo = ct_author
			left join ajax_pais on us_country = pais_codigo
				where ct_protocol = '" . $this -> protocolo . "' 
				order by ct_type
			";
		$rlt = db_query($sql);
		$sp = '';
		while ($line = db_read($rlt)) {
			if (strlen($sp) > 0) { $sp .= '; ';
			}
			$spn = trim($line['us_nome']);
			$tp = trim($line['ct_type']);
			$spa = '';
			$spc = trim($line['pais_nome']);
			if ($tp == 'A') { $spa .= ' (' . msg('contact') . ')';
			}
			$sp .= '<A HREF="#" title="' . $spc . '">';
			$sp .= $spn;
			$sp .= '</A>';
		}

		//us_instituition;

		if (strlen($sp) == 0) { $sp = msg('no_investigator');
		}
		return ($sp);
	}

	function dados() {
		global $date, $LANG, $tab_max;
		$oms = new oms;
		$line = $this -> line;
		$gr = trim($line['cep_grupo']);
		$versao = $line['cep_versao'];
		$codigo = $line['cep_codigo'];
		$clinic_st = round($line['cep_clinic']);
		$protocol_cep = trim($line['cep_protocol']);

		$oms = new oms;

		if ($clinic_st == 1) {
			$clinic = msg('clinic_study');
		} else {
			$clinic = '';
		}
		$status = 'cep_status_' . trim($line['cep_status']);

		$protocol_id = $this -> protocolo;
		/* Estatus */
		$sp = '';
		$sp .= '<table width="100%" border=0 cellpadding=0 cellspacing=0 class="table_normal">';
		$sp .= '<TR><TD>' . msg('protocol') . ' <B>' . $clinic . '</B><TD align="right">' . msg('status') . ': ' . msg($status);
		$sp .= '</table></B>';

		/* CAAE */
		$sp .= '<table width="100%" border=0 class="lt0">';
		$sp .= '<TR><Td colspan=4 >' . msg('caae');
		$sp .= '    <Td colspan=4 >' . msg('project_type');
		$sp .= '<TR><Td colspan=4 class="table_proj" ><B>';
		$sp .= trim($line['cep_caae']);
		$sp .= '    <Td colspan=3 class="table_proj">';
		$sp .= msg('amendment__' . trim($line['cep_tipo']));
		$sp .= '    <Td colspan=1 class="table_proj" align="right">';
		if ($clinic_st == 1) {
			$sp .= $oms -> icone($protocol_id);
		}

		$sp .= '</table>';

		/* Title */
		$sp .= '<table width="100%" border=0 class="lt0">';
		$sp .= '<TR><Td colspan=7 class="lt0">' . msg('project_title');
		$sp .= '<TR><Td colspan=7 class="table_proj"><B>';
		$sp .= trim($line['cep_titulo']);
		$sp .= '</table>';

		/* Investigador */
		$sp .= '<table width="100%" border=0 class="lt0">';
		$sp .= '<TR><Td colspan=6>' . msg('project_investigador');
		$sp .= '<Td align="right" width="10%">' . msg('protocol');
		$sp .= '<TR><Td colspan=6 class="table_proj">';
		{
			$sp .= '<img src="img/icone_plus.png" align="right" height="16" id="new_author" alt="include_investigator">';
			//$sp .= '<TR><TD colspan=2>';

			$sp .= chr(13) . '<script type="text/javascript">';
			$sp .= chr(13) . '$("#new_author").click(function() {
							$("#new_author").hide();
							$("#team").show();
							var $tela = $.ajax({ url: "team_ajax_cep.php", type: "POST", 
								data: { dd11: "' . $protocol_id . '", dd10: "team" ,dd12: "' . $protocol_id . '" }
								})
								.fail(function() { alert("error"); })
 								.success(function(data) { $("#team").html(data); });
							});';
			$sp .= chr(13) . '</script>';
		}

		$sp .= $this -> investigadores($line);

		/* Protocolo de submissão */
		$sp .= '&nbsp;' . chr(13);
		$sp .= '<Td align="rigth" class="table_proj" >
					<div style="width:100%; text-align: right;">' . $protocol_id . '</div>';
		$sp .= '</table>';

		/* Inser new investigator */
		$sp .= '<table width="100%" border=0 class="lt0">';
		$sp .= '<TR><TD colspan=7>';
		$sp .= '<div id="team" style="display: none; ">';
		$sp .= '</div>';

		/* INstitution */
		$sp .= '<TR><Td colspan=1 width="50%" class="lt0">' . msg('institution');
		$sp .= '<Td align="left" colspan=1 width="25%" class="lt0" width="10%">' . msg('country');
		$sp .= '<Td align="left" colspan=1 width="25%" class="lt0" width="10%">' . msg('result');

		/* dados da instituicao */
		$sp .= '<TR><Td colspan=1 class="table_proj">';
		$sp .= trim($line['us_instituition']);
		$sp .= '&nbsp;' . chr(13);
		$sp .= '<Td class="table_proj">';
		$sp .= trim($line['pais_nome']) . '&nbsp;';

		$sp .= '<Td class="table_proj">';
		$sp .= msg(trim($line['cep_pr_protocol'])) . '&nbsp;';

		$sp .= '&nbsp;' . chr(13);
		if (strlen($clinic) > 0) {
			/* XML OMS */
			//$sp .= '<Td colspan=1 class="lt2"><NOBR>';
			//$sp .= $oms -> icone($this -> line['id_cep']);
			//$sp .= '&nbsp;' . chr(13);
		}
		$sp .= '</table>';

		$sp .= '<table width="100%" border=0 class="lt0">';
		$sp .= '<TR>';
		$sp .= '<TD width="10%">' . msg('date_accept');
		$sp .= '<TD width="10%">' . msg('date_update');
		$sp .= '<TD width="10%">' . msg('meet_data');
		$sp .= '<TD width="10%">' . msg('dictamen_date');

		$sp .= '<TD width="10%">' . msg('aware_date');
		$sp .= '<TD width="10%">' . msg('date_reclutamiento');
		$sp .= '<TD width="10%">' . msg('date_amendment');
		$sp .= '<TD>' . msg('monitoring');

		$sp .= '<TR class="lt2" valign="top">';
		$sp .= '<Td class="table_proj lt2" align="left" >';
		$sp .= '&nbsp;' . stodbr($line['cep_data']);

		$sp .= '<Td class="table_proj lt2" align="left">';
		$sp .= '&nbsp;' . stodbr($line['cep_atualizado']);

		$sp .= '<Td class="table_proj lt2" align="left">';
		$sp .= '&nbsp;' . stodbr($line['cep_reuniao']);

		$sp .= '<Td class="table_proj lt2" align="left">';
		$sp .= '&nbsp;' . stodbr($line['cep_dt_parecer']);

		$sp .= '<Td class="table_proj lt2" align="left">';
		$sp .= '&nbsp;' . stodbr($line['cep_dt_ciencia']);

		$sp .= '<Td class="table_proj lt2" align="left">';

		/* dados sobre recutramento */
		$dtr = $line['cep_recrutamento'];
		if ($dtr < 20000000) {
			$sp .= '&nbsp;' . msg('no_start');
		} else {
			$sp .= '&nbsp;' . stodbr($line['cep_recrutamento']);
			$sp .= '<BR><font class="lt1">';
			$sp .= msg($line['cep_recrutamento_status']);
			$sp .= '</font>';
		}

		$sp .= '<Td class="table_proj lt2" align="left">';
		$sp .= '&nbsp;' . stodbr($line['cep_dt_liberacao']);

		$sp .= '<Td class="table_proj lt2" align="right"><center>';
		$sp .= '&nbsp;' . $this -> monitoring($line['cep_monitoring']);

		$sp .= '</table>';

		$sp .= '</table>';
		return ($sp);
	}

	function monitoring($d) {
		$acop = array();
		$acop[''] = '';
		$acop[180] = msg('semiannual');
		$acop[365] = msg('annual');
		$acop[-1] = msg('end_of_the_investigation');
		return ($acop[$d]);
	}

	function protocolos_sua_avaliacao() {
		global $user;
		$sta = $user -> user_id;
		$sql = "select * from " . $this -> tabela . " 
					 where cep_relator = '$sta' 
					 order by cep_reuniao 
					 ";
		$rlt = db_query($sql);
		$dta = 19000101;
		$tot = 0;
		while ($line = db_read($rlt)) {
			$tot++;
			$data = $line['cep_reuniao'];
			if ($data != $dta) { $sx .= '<TR><TD colspan=4 align="center" class="lt2"><center>' . msg('meet_data') . ' ' . stodate($data);
				$dta = $data;
			}
			$sx .= $this -> mostra($line);
		}
		$sa .= $sx;
		$sa .= '</table>';

		if ($tot == 0) {$sa = '';
		}
		return ($sa);
	}

	function protocolos_avaliacao($sta, $tipo = '') {
		global $ss;

		$us = strzero(round($ss -> user_id), 7);
		if (strlen($tipo) > 0) {
			$wh = " and (cep_tipo = '$tipo' )";
		} else {
			$wh = '';
		}
		if ($sta == 'Z') {
			$sql = "select * from " . $this -> tabela . " 
					 inner join cep_dictamen on pp_protocolo = cep_protocol 
					 where 
					 (cep_status = '@' or cep_status = 'A' or cep_status = 'B' or cep_status = 'C' or cep_status = 'D')
					 and pp_avaliador = '$us' 
					 and (pp_status <> 'B' and pp_status <> 'X')
					 $wh
					 order by cep_reuniao ";
		} else {
			$sql = "select * from " . $this -> tabela . " 
					 left join usuario on us_codigo = cep_pesquisador
					 where cep_status = '$sta' 
					 $wh
					 order by cep_reuniao 
					 ";
		}

		$rlt = db_query($sql);
		$dta = 19000101;
		$tot = 0;
		while ($line = db_read($rlt)) {
			$tot++;
			$data = $line['cep_reuniao'];
			if ($data != $dta) { $sx .= '<TR><TD colspan=4 align="center" class="lt2"><center>' . msg('meet_data') . ' ' . stodate($data);
				$dta = $data;
			}
			$sx .= $this -> mostra($line);
		}

		$sa = '<table width=96% class="table_normal" border=0>';
		$sa .= '<TR><TH>' . msg('protocol');
		$sa .= '<TH>' . msg('project_title');
		$sa .= '<TH>' . msg('status');
		$sa .= $sx;
		$sa .= '<TR><TD colspan=5>' . msg('found') . ' ' . $tot . ' ' . msg('records');
		$sa .= '</table>';
		if ($tot == 0) {
			$sa = '';
		}
		return ($sa);
	}

	function mostra($line) {
		global $edit_mode;
		$vs = 2;
		$sta = trim($line['cep_status']);
		/* investigador */
		$sx .= '<TR class="lt2"><TD>' . msg('research_name') . ': <B>' . $line['us_nome'] . '</B>';
		$vs = 3;

		$status = trim($line['cep_status']);
		$parecer = trim($line['cep_pr_protocol']);

		$dias = $line['cep_atualizado'];
		$data = date("Ymd");
		$df = round(DiffDataDias($dias, $data));
		$para = 'dd0=' . $line['id_cep'] . '&dd90=' . checkpost($line['id_cep']);
		$link2 = '<a href="protocol_detalhe.php?' . $para . '" class="protocol">';
		$link = '<a href="protocol_detalhe.php?' . $para . '" class="comment">';

		/* Line 1*/
		$s .= '<TR valign="top"  class="table_proj">';

		/* CAAE - NIEC */
		$s .= '<td rowspan=' . $vs . ' width="5%" class="caae"><NOBR>';
		$caae = trim($line['cep_caae']);
		if (strlen($caae) > 0) { $s .= $caae . '<BR>';
		}
		$s .= trim($line['cep_protocol']);
		$s .= '/';
		$s .= trim($line['cep_versao']);

		/* icon type */
		$type = trim($line['cep_tipo']);
		$s .= '<BR>' . $this -> mostra_icone_tipo_projeto($type);

		/* title */
		$s .= '<TD><B><I>';
		$s .= $link2;
		$s .= $line['cep_titulo'];
		$s .= '</A>';

		/* status */
		switch ($parecer) {
			case 'pm_APR' :
				$s .= '<TD align="center" width="100">';
				$s .= msg('aproved');
				break;

			case 'pm_NOT' :
				$s .= '<TD align="center" width="100">';
				$s .= msg('not_aproved');
				break;
			default :
				$s .= '<TD align="center" width="100">';
				$s .= '<font class="lt1">' . msg('in_review_list') . '</font><BR>';
				$s .= '<font class="lt3">' . $corf . $df . '</font>
					<BR>
					<font class="lt0">
					' . msg('days') . '</font>';
				break;
		}
		$s .= '<TD rowspan=' . $vs . ' align="center" width="50">';

		$s .= $sx;
		$s .= '<BR><I>';
		$s .= '<nobr>';
		if (1 == 2) {
			$s .= $link . '<img src="img/icone_coment_ok.png" title="' . msg('comment_ok') . '" border=0 >:' . $line['cep_comment_pos'] . '</A> ';
			$s .= $link . '<img src="img/icone_coment_nook.png" title="' . msg('comment_nook') . '" border=0>:' . $line['cep_comment_neg'] . '</A> ';
			$s .= '</nobr>';
			$s .= '&nbsp;&nbsp;&nbsp;&nbsp;';
			$s .= $link . '<img src="img/icone_coment_edit.png" title="' . msg('comment_edit') . '" border=0>&nbsp;<?A>';
		} else {
			$s .= '<TR><TD class="lt1">';
			$s .= (round($line['cep_comment_pos']) + round($line['cep_comment_neg'])) . '&nbsp';
			$s .= msg('comment') . '</A> - ';
		}
		$s .= msg('cep_status_' . $line['cep_status']);
		$s .= '<tr><TD colspan=4>';
		$s .= '<HR size=1 width=50% >';
		return ($s);
	}

	function mostra_email($line) {
		global $edit_mode;
		$vs = 2;
		$sta = trim($line['cep_status']);
		/* investigador */
		$sx = '<TR><TD>' . msg('research_name') . ': <B>' . $line['us_nome'] . '</B>';
		$vs = 3;

		$status = trim($line['cep_status']);
		$parecer = trim($line['cep_pr_protocol']);

		$dias = $line['cep_atualizado'];

		/* Line 1*/
		$s = '<table width="100%" cellpadding=5 cellspacing=0 border=0>';
		$s .= '<TR valign="top"  class="table_proj">';

		/* CAAE - NIEC */
		$s .= '<td rowspan=' . $vs . ' width="5%" class="caae"><NOBR>';
		$caae = trim($line['cep_caae']);
		if (strlen($caae) > 0) { $s .= $caae . '<BR>';
		}
		$s .= trim($line['cep_protocol']);
		$s .= '/';
		$s .= trim($line['cep_versao']);

		/* icon type */
		$type = trim($line['cep_tipo']);

		/* title */
		$s .= '<TD><B><I>';
		$s .= $line['cep_titulo'];

		$s .= '<TD rowspan=' . $vs . ' align="center" width="50">';

		$s .= $sx;
		$s .= '<BR><I>';
		$s .= '<tr><TD colspan=4>';
		$s .= '</table>';
		$s .= '<HR size=1 width=50% >';
		return ($s);
	}

	function mostra_icone_tipo_projeto($tipo = '') {
		switch($tipo) {
			case 'PRO' :
				$img = '<img src="images/icone_PRO.png" height="50">';
				break;
			case 'AME' :
				$img = '<img src="images/icone_AME.png" height="50">';
				break;
		}
		return ($img);
	}

	function resumo_status() {
		global $edit_mode;
		$sql = "select count(*) as total, cep_status 
					from " . $this -> tabela . " 
					where (cep_status = '@' or cep_status = 'A' 
					or cep_status = 'B' or cep_status = 'C')
					group by cep_status ";
		$rlt = db_query($sql);

		$sta = array('@' => 0, 'A' => 1, 'B' => 2, 'C' => 3);
		$rst = array(0, 0, 0, 0);
		while ($line = db_read($rlt)) {
			$total = $line['total'];
			$stb = $sta[trim($line['cep_status'])];
			$rst[$stb] = $total;
		}
		return ($rst);

	}

	function resumo_query() {
		global $edit_mode;
		global $nucleo;
		$sql = "select total, cep_status, ess_descricao_1 as ps_nome from (";
		$sql .= "select count(*) as total, cep_status ";
		$sql .= " from " . $this -> tabela;
		$sql .= " group by cep_status ";
		$sql .= ") as tabela ";
		$sql .= " left join cep_status on ess_status = cep_status and ess_nucleo = '" . $nucleo . "' ";
		$sql .= " order by cep_status ";
		$rlt = db_query($sql);
		$rst = array();
		while ($line = db_read($rlt)) {
			array_push($rst, $line);
		}
		return ($rst);
	}

	function resumo() {
		global $colunas;
		global $edit_mode;
		$rst = $this -> resumo_query();
		$sc = '<table class="lt1">';
		$sc .= '<TR>';
		$sc .= '<TH>' . msg('total');
		$sc .= '<TH>' . msg('tipo');
		for ($r = 0; $r < count($rst); $r++) {
			$status = trim($line['cep_status']);
			$link = 'protocolo_status.php?dd52=' . $status;
			$link = '<A HREF="' . $link . '">';
			$name = trim($line['ps_nome']);
			if (strlen($name) == 0) { $name = $line['cep_status'];
			}
			$line = $rst[$r];
			$sc .= '<TR>';
			$sc .= '<TD align="center"><B>';
			$sc .= $line['total'];
			$sc .= '<TD>';
			$sc .= $link;
			$sc .= $name;
			$sc .= '</A>';
			$sc .= ' (' . $status . ')';
			$sc .= '<TD>';
		}
		$sc .= '</table>';
		return ($sc);
	}

	function structure() {
		$sql = "CREATE TABLE cep_protocolos_historic (
				id_his SERIAL NOT NULL ,
				his_protocol CHAR( 15 ) NOT NULL ,
				his_codigo CHAR( 3 ) NOT NULL ,
				his_data INT NOT NULL ,
				his_time CHAR( 8 ) NOT NULL ,
				his_comment CHAR( 100 ) NOT NULL ,
				his_log CHAR( 8 ) NOT NULL
				)";
	}

}
?>
