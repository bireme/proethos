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
 * @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
 * @copyright @ Pan American Health Organization, 2013. All rights reserved.
 * @version 0.16.07
 * @access public
 * @package INCLUDEs
 * @subpackage Table Row
 */

if (!(function_exists('format_fld'))) {
	function format_fld($x = '', $y = '') {
		return ($x);
	}

}

global $secu;
echo '
<style>
	TEXTAREA, INPUT {
		background: #F9F9F9;
		border: 1px solid Gray;
		padding: 1px 1px 1px 1px;
		text-align: left;
		text-decoration: none;
		font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-size: 12px;
		font-weight: normal;
		letter-spacing: 0px;
	}
</style>
';
$page = page();

if (strlen($http_redirect) > 0) {
	global $dd, $base;

	$pg_cookie = $page;
	$pg_cookie = troca($pg_cookie, '.php', '');

	/******** Salva Session */
	/* Filtro ativado */
	if (strlen($dd[50]) > 0) {
		if (substr($dd[50], 0, 1) == 'c') {
			$_SESSION[$page . '_filtro'] = '';
			$_SESSION[$page . '_pos'] = '';
			$_SESSION[$page . '_ordem'] = '';
			$dd[1] = '';
			$dd[4] = '';
			$clean = 0;
		} else {
			if (strlen($dd[1]) > 0) {
				$_SESSION[$page . '_filtro'] = $dd[1];
				$_SESSION[$page . '_field'] = $dd[2];
				$_SESSION[$page . '_pos'] = $dd[4];
				if (strlen($dd[5]) > 0) { $_SESSION[$page . '_ordem'] = $dd[5];
				}
				$clean = 1;
			} else {
				$_SESSION[$page . '_filtro'] = '';
				$_SESSION[$page . '_field'] = $dd[2];
				$_SESSION[$page . '_pos'] = '';
				$_SESSION[$page . '_ordem'] = '';
				$dd[1] = '';
				$clean = 0;
			}
		}
	} else {
		$dd[1] = $_SESSION[$page . '_filtro'];
		$dd[2] = $_SESSION[$page . '_field'];
		$dd[4] = $_SESSION[$page . '_pos'];
		$dd[5] = $_SESSION[$page . '_ordem'];
		$clean = 1;
	}

	/*  alterado SN no display em 08/10/2007 */
	$bb1 = " busca ";
	global $dd, $base;
	/* Titulo do Row se existir Label */
	if (strlen($label) > 0) {
		echo '<TABLE width="' . $tab_max . '" cellpadding="2" cellspacing="0">';
		echo '<TR><TD>';
		echo '<font class=lt5>' . $label . '</font>';
		echo '</TD></TR>';
		echo '</TABLE>';
	}

	if (strlen($dd[1]) > 0) {
		if ($base == 'mysql') { $where = "upper(" . $dd[2] . ") like '%" . UpperCaseSQL(trim($dd[1])) . "%'";
		} else { $where = "upper((" . $dd[2] . ")) like '%" . UpperCaseSQL(trim($dd[1])) . "%'";
		}
	}

	if (strlen($pre_where) > 0) {
		if (strlen($where) > 0) {
			$where = "(" . $pre_where . ") and (" . $where . ") ";
		} else { $where = $pre_where;
		}
	}

	/* Calcula total de registro */
	$total = 0;
	$xsql = "select count(*) as total from " . $tabela . " ";
	if (strlen($where) > 0) { $xsql = $xsql . ' where ' . $where;
	}
	$xrlt = db_query($xsql);

	if ($xline = db_read($xrlt)) { $total = $xline['total'];
	}
	for ($k = 0; $k <= intval($total / $offset); $k++) {
		$ini = $k * $offset + 1;
		$fim = ($k + 1) * $offset;
		if ($fim > $total) { $fim = $total;
		}
		$sel = '';
		if ($ini == ($dd[4] + 1)) { $sel = 'selected';
		}
		$cp_max = $cp_max . '<option value="' . ($ini - 1) . '" ' . $sel . '>' . $ini . '-' . $fim . '</option>';
	}

	if (strlen($dd[4]) > 0) {
		if (intval($dd[4]) > $total) { $dd[4] = '';
		}
	}

	/* Recupera registros */
	$cp_ed = '';
	$sql = "select ";
	if ($base == 'mssql') {$sql .= ' top ' . $offset . ' ';
	}
	if (strlen($dd[3]) == 0) { $dd[3] = $cdf[1];
	}
	for ($kx = 0; $kx < count($cdf); $kx++) {
		if ($kx > 0) { $sql = $sql . ', ';
		}
		$sql = $sql . trim($cdf[$kx]) . ' ';
		$sele = '';
		if (TRIM($dd[2]) == trim($cdf[$kx])) { $sele = ' selected ';
		}
		if ($kx > 0) { $cp_ed = $cp_ed . '<option value="' . trim($cdf[$kx]) . '" ' . $sele . '>' . trim($cdm[$kx]) . '</option>';
		}
	}

	/* Gera consulta */
	$sql = $sql . ' from ' . $tabela;
	if (strlen($where) > 0) { $sql = $sql . ' where ' . $where;
	}

	/* Order by */
	if (strlen($dd[5]) > 0) {
		$ord = abs($dd[5]);
		$ord = ' order by ' . $cdf[$ord];
		if ($dd[5] < 0) { $ord .= ' desc ';
		}
		$sql .= $ord;
	} else {
		/* Utiliza filtro padrao */
		if (strlen($order) > 0) { $sql = $sql . ' order by ' . $order;
		} else { $sql = $sql . ' order by ' . $cdf[1];
		}
	}

	/* Para banco de dados MS-Sql */
	if ($base != 'mssql') {
		$sql = $sql . ' limit ' . $offset;
		if (strlen($dd[4]) > 0) { $sql = $sql . ' offset ' . $dd[4];
		}
	}
	/* realiza consulta */
	$rlt = db_query($sql);

	/* Se a busca estiver habilitada mostra cabe�alho */
	if ($busca == true) {
		/* Labels - Idiomas */
		$bt_filter = msg('filter');
		$bt_filter_clear = msg('filter_clean');
		$bt_new = msg('new_record');
		$bt_search = msg('search');
		$cap_show = msg('show');

		/* Motagem dos dados */

		echo '<TABLE width="' . $tab_max . '" border="0" cellpadding="3" cellspacing="0" class="tabela01 lt3">';

		/* Header */
		echo '<TR class="bg_silver lt2" align="center">';
		if ($editar) { array_push($cdm, '');
		}
		$ord = round(abs($dd[5]));

		for ($k = 1; $k < count($cdm); $k++) {
			$page = page();
			echo '<TD><B><font color=Black>' . $cdm[$k];
		}
		echo '</TD></TR>';

		while ($line = db_read($rlt)) {
			$link = '<A HREF="' . $http_edit . '?dd0=' . $line[$cdf[0]] . $http_edit_para . '&dd90=' . checkpost($line[$cdf[0]]) . '">';
			$link = '<A HREF="' . $http_edit . '?dd0=' . $line[$cdf[0]] . $http_edit_para . '">';
			if (strlen($http_ver) > 0) { $linkv = '<A HREF="' . $http_ver . '?dd0=' . $line[$cdf[0]] . $http_ver_para . '&dd90=' . checkpost($line[$cdf[0]]) . '" class=lt1 >';
			}
			echo chr(13) . chr(10) . '<TR ' . $xcol . ' valign=top>';
			for ($kx = 1; $kx < count($cdf); $kx++) {
				$ncp = $cdf[$kx];
				$vlr = $line[$ncp];
				$aln = '';
				/* Mascara */
							
				
				if (($kx == 1) or ($kx == 2))
					{
						$vlr = msg($vlr);
					}
				echo '<TD ' . $aln . '>' . $linkv;

				if (substr($vlr, 0, 1) == '#') { $vlr = msg($vlr);
				};
				echo format_fld($vlr, $masc[$kx]);
			}
			if ($editar) {
				echo '<TD width="20">' . $link . '<img src="' . $include . 'img/icone_editar.gif" width="20" height="19" alt="" border="0"></TD>';
			}
			echo '</TR>';
		}
		echo '<TR><TD colspan="10"><B>Total de ' . $total . '</B></TD></TR>';
		echo '</TABLE>';
	}
}
?>
<style>
	.border_abnt {
		border-top: 1px solid #000000;
		border-bottom: 1px solid #000000;
		padding: 5px 0px 5px 0px;
	}
</style>