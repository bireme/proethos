<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Table Row
*/

if (!(function_exists('format_fld')))
	{
		function format_fld($x='',$y='')
			{
				return($x);
			}
	}
 
 
global $secu;
echo '
<script language="javascript1.2">
	img5=new Image();
	img5.src="' . $include . 'img/bt_clean.png";
	img6=new Image();
	img6.src="' . $include . 'img/bt_clean_on.png";
	img3=new Image();
	img3.src="' . $include . 'img/bt_busca.png";
	img4=new Image();
	img4.src="' . $include . 'img/bt_busca_on.png";
	img1=new Image();
	img1.src="' . $include . 'img/bt_novo.png";
	img2=new Image();
	img2.src="' . $include . 'img/bt_novo_on.png";
</script>

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
	/* Título do Row se existir Label */
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
		/* Utiliza filtro padrão */
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

	/* Se a busca estiver habilitada mostra cabeçalho */
	if ($busca == true) {
		/* Labels - Idiomas */
		$bt_filter = 'Filtrar';
		$bt_filter_clear = 'Limpar filtro';
		$bt_new = 'Novo';
		$bt_search = 'Filtrar';
		$cap_show = 'Mostrar';

		echo '<TABLE width="' . $tab_max . '" cellpadding="0" cellspacing="0" class="lt0" border="0" class="row_table">';
		echo '<TR valign="top" >';

		/* Formulário */
		echo '<TD class="border_abnt"><form name="row" method="post" ';
		echo 'action="' . $http_redirect . $http_redirect_para . '" ></TD>';
		echo '<TD width="5" class="border_abnt"><NOBR>' . $bt_search . '</nobr></TD>';
		echo '<TD width="5" class="border_abnt">';
		echo '<input type="text" name="dd1" value="' . $dd[1] . '" ';
		echo 'size="15" maxlength="80" style="width: 130px; height: 22px;">';

		/* Botão Pesquisar */
		echo '<TD width="95" class="border_abnt">';
		echo '<A  title="Filtrar" href="javascript:document.row.submit();" alt="Submit"';
		echo 'onMouseOver="document.images[' . chr(39) . 'dd51' . chr(39) . '].src=img4.src;"';
		echo 'onMouseOut="document.images[' . chr(39) . 'dd51' . chr(39) . '].src=img3.src;"';
		echo '>';
		echo '<input type="button" value="' . $bt_filter . '" name="dd51" class="row_button">';
		echo '<input type="hidden" name="dd50" value="filtrar">';

		/* Pesquisar em */
		echo '<TD width="5" class="border_abnt"><NOBR>&nbsp;em&nbsp;</TD>';
		echo '<TD width="5" class="border_abnt"><select name="dd2" size="1" class="IMG">';
		echo $cp_ed;
		echo '</select>';
		echo '<TD class="border_abnt">&nbsp;&nbsp;';

		/* Botão Limpar */
		if ($clean == 1) {
			echo '<TD width="5" class="border_abnt"><NOBR>';
			echo '<A  title="Limpar Filtro/Clean Filter" href="#" onclick="document.row.dd50.value=' . chr(39) . 'clean' . chr(39) . '; document.row.submit();" alt="Submit"';
			echo 'onMouseOver="document.images[' . chr(39) . 'dd52' . chr(39) . '].src=img6.src;"';
			echo 'onMouseOut="document.images[' . chr(39) . 'dd52' . chr(39) . '].src=img5.src;"';
			echo '>';
			echo '<input type="button" value="' . $bt_filter_clear . '" name="dd52" class="row">';
		}

		/* Seleção mostrar */
		echo '<TD width="5" align="right" class="border_abnt"><NOBR>' . $cap_show . '</nobr></TD>';

		/* Close form */
		echo '</form>';

		/* $http_redirect.'?dd1='.$dd[1].'&dd4='. */
		echo '<TD width="5" class="border_abnt">';
		echo '<select name="dd4" size="1" class="IMG"  ';
		if (strpos($http_redirect, '?') > 0) {
			echo 'onChange="location=' . chr(39) . $http_redirect . '&';
		} else {
			echo 'onChange="location=' . chr(39) . $http_redirect . '?';
		}
		echo 'dd1=' . $dd[1] . '&dd2=' . $dd[2] . '&dd50=busca&dd4=' . chr(39);
		echo '+this.options[this.selectedIndex].value;">';
		echo $cp_max;
		echo '</select>';

		/* Espaço Livre */
		echo '<TD width="90%" class="lt0 border_abnt">&nbsp;';

		/**** Editar */
		if (strlen($http_edit_para) > 0) { $http_ch = '?';
		}
		if ($editar) {
			echo '<TD align="right" class="border_abnt">';
			echo '<input type="button" value="' . $bt_new . '" name="dd53" class="row" onclick="window.location = \'' . $http_edit . $http_ch . $http_edit_para . '\';">';
		}

		/* Barra final */
		echo '</TABLE>';

		/* Motagem dos dados */

		echo '<TABLE width="' . $tab_max . '" border="0" cellpadding="3" cellspacing="0" class="lt1">';

		/* Cabeçalho */
		echo '<TR bgcolor="#c0c0c0" valign="top" align="center" class="lt0">';
		if ($editar) { array_push($cdm, '');
		}
		$ord = round(abs($dd[5]));

		for ($k = 1; $k < count($cdm); $k++) {
			$page = page();
			$linka = '<A href="' . $page . '?';
			$linka .= 'dd1=' . $dd[1] . '&dd2=' . $dd[2] . '&dd50=busca&dd4=' . $dd[4];
			$linka .= '&dd5=' . $k;
			$linka .= '&' . $http_edit_para;
			$linka .= '">';

			$linkb = '<A href="' . $page . '?';
			$linkb .= 'dd1=' . $dd[1] . '&dd2=' . $dd[2] . '&dd50=busca&dd4=' . $dd[4];
			$linkb .= '&dd5=-' . $k;
			$linkb .= '&' . $http_edit_para;
			$linkb .= '">';

			echo '<TD><B><font color=Black>' . $cdm[$k];
			if (strlen($cdm[$k]) > 0) {
				echo ' ';
				if (($ord != $k) or ($dd[5] < 0)) {
					echo $linka;
					echo '<img src="' . $include . 'img/bt_order_down.png" border=0 >';
					echo '</A>';
				} else {
					echo '<img src="' . $include . 'img/bt_order_down_s.png" border=0 >';
				}
				if (($ord != $k) or ($dd[5] > 0)) {
					echo $linkb;
					echo '<img src="' . $include . 'img/bt_order_up.png" border=0 >';
					echo '</A>';
				} else {
					echo '<img src="' . $include . 'img/bt_order_up_s.png" border=0 >';
				}
			}
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
				$aln = '';
				if (substr($masc[$kx], 0, 1) == '$') { $aln = 'align="right" ';
				}
				//////////// exceções
				if (substr($masc[$kx], 0, 2) == 'CB') { $linkv = '';
				}
				if (substr($masc[$kx], 0, 2) == 'H1') { $aln = $aln . ' colspan=10 ';
				}
				if (substr($masc[$kx], 0, 1) == '$') { $aln = 'align="right" ';
				}
				echo '<TD ' . $aln . '>' . $linkv;
				echo format_fld($line[$ncp], $masc[$kx]);
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