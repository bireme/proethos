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
 * Mensagens
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.12.07
 * @package Class
 * @subpackage mensagens
 */

$ido = array('pt_BR', 'en_US', 'es', 'fr');
if (!(empty($_SERVER['PATH_INFO']))) { $idio = trim($_SERVER['PATH_INFO']);
}

$idio_valid = '';
/* set idioma if empty */
if (empty($idio)) { $idio = '';
}

if (strlen($idio) > 0) {
	$idio = troca($idio, '/', '');
	for ($r = 0; $r < count($ido); $r++) {
		//echo '<BR>'.$ido[$r].'-'.$idio;
		if ($idio == $ido[$r]) { $idio_valid = $ido[$r];
		}
	}
	if (strlen($idio_valid) == 0) {
		require ("_noaccess.php");
		exit ;
	}
}

$lg = new message;

$lg -> language_set($idio_valid);
$LANG = $lg -> language_read();

if (strlen($LANG) == 0) {
	$idiona = $lg -> language_detect();
	$lg -> language_set($idioma);
}

//$LANG = 'en_US';
class message {
	/**
	 * Classe de mensagens
	 */
	var $LANG = 'en';
	var $tabela = '_messages';

	function mostra_page($id) {
		$sx = '';
		$sql = "select * from " . $this -> tabela . " where id_msg = " . sonumero($id);
		$rlt = db_query($sql);
		$line = db_read($rlt);
		$pag = $line['msg_pag'];
		$pag_array = unserialize($pag);
		for ($r = 0; $r < count($pag_array); $r++) {
			$sx .= $pag_array[$r] . '<br>';
		}
		return ($sx);
	}

	function convert_to_utf8() {
		$sql = "select * from " . $this -> tabela;
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			$tx = trim($line['msg_content']);
			$tx2 = $tx;
			$tchar = codificacao($tx);
			if ($tchar == 'ISO-8859-1') {
				$tx2 = utf8_encode($tx);
				$sql = "update " . $this -> tabela . " 
									set msg_content = '" . $tx2 . "'
									where id_msg = " . $line['id_msg'];
				$rrr = db_query($sql);
				echo '<BR>' . $tx . '-' . $tx2;
				echo '==' . codificacao($tx);
			}

		}
	}

	public function __construct() {
		$ipserver = trim($_SERVER['SERVER_ADDR']);
		if ($ipserver == '50.22.37.205') {
			$this -> tabela = 'sisdocco_cip._messages';
		} else {
			$this -> tabela = '_messages';
		}
	}

	/**
	 * Identificacao de idioma
	 */

	function edit_mode($op) {
		global $edit_mode;
		$edit_mode = round($op);
		$mm = 'edmode_0';
		if ($edit_mode > 0) { $edit_mode = 1;
			$mm = 'edmode_2';
		}
		$_SESSION['editmode'] = $op;
		$sx = msg($mm);
		return ($sx);
	}

	function language_detect() {
		$idioma = 'en';
		$idm = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		if (strpos($idm, ',') > 0) { $idm = substr($idm, 0, strpos($idm, ','));
		}
		if (strpos($idm, ';') > 0) { $idm = substr($idm, 0, strpos($idm, ','));
		}
		$ida = array(
		/** Ingles **/
		'en' => 'en_US', 'en-us' => 'en_US', 'en-GB' => 'en_US', 'us' => 'en_US', 'en-gb' => 'en_US', 'en-za' => 'en_US', 'en-ie' => 'en_US', 'en-ca' => 'en_US', 'en-au' => 'en_US',
		/** Alemao **/
		'de' => 'de', 'de-at' => 'de', 'de-lu' => 'de', 'de-ch' => 'de', 'de-li' => 'de',
		/** Espanhol e Casteliano **/
		'es' => 'es',
		/** Portugues **/
		'pt-br' => 'pt_BR', 'pt' => 'pt_BR');
		$idm = $ida[$idm];
		if (strlen($idm) > 0) { $idioma = $idm;
		}
		return ($idioma);
	}

	/**
	 * Campos de edicao e alteracao da tabela
	 */
	function cp() {
		$cp = array();
		array_push($cp, array('$H8', 'id_msg', 'key', False, True));
		array_push($cp, array('$H8', 'msg_pag', msg('page'), False, False));
		array_push($cp, array('$O pt_BR:Portugues Brasil&en_US:English&es:Spanish', 'msg_language', msg('language'), False, False));
		array_push($cp, array('$S40', 'msg_field', msg('field'), False, False));
		array_push($cp, array('$T60:4', 'msg_content', msg('content'), True, True));
		array_push($cp, array('$O 1:YES&0:NO', 'msg_ativo', msg('active'), True, True));
		array_push($cp, array('$HV', 'msg_update', date("Ymd"), True, True));
		return ($cp);
	}

	/**
	 * Carrega todas as mensagens de uma pagina e referencia
	 */

	function message_name_all($ref, $page) {
		$msg = array();
		$sql = "select * from " . $this -> tabela;
		$sql .= " where (msg_field = '" . $ref . "') ";
		$sql .= " and (msg_ativo = 1) ";
		$sql .= " order by id_msg ";
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			array_push($msg, array($line['id_msg'], $line['msg_language'], $line['msg_content']));
		}
		return ($msg);
	}

	/**
	 * Idiomas do sistema
	 */

	function idioma() {
		$idi = array('pt_BR' => 'Portugues', 'en_US' => 'English (USA)', 'es' => 'Spanish', 'fr' => 'Frensh');
		return ($idi);
	}

	/**
	 * Formulario para selecao de idioma
	 */
	function idioma_form() {
		global $LANG;
		$ido = $this -> idioma();
		$sx = '';
		foreach ($ido as $key => $value) {
			$sel = '';
			if (trim($LANG) == trim($key)) { $sel = 'selected';
			}
			$sx .= ' <option value="' . $key . '" ' . $sel . '>' . $value . '</option>';
		}
		return ($sx);

	}

	/* Recupera linguagem */
	function language_read() {
		global $LANG;
		$LANG = 'es';
		$lng = $_SESSION['language'];
		if (strlen($lng) > 0) { $LANG = $lng;
		}
		return ($LANG);
	}

	/* Seleciona a Linguagem */
	function language_set($lg) {
		global $LANG;
		$lg = troca($lg, '/', '');
		if (strlen($lg) > 0) {
			$_SESSION['language'] = $lg;
			redirecina('../' . page());
			exit ;
		}
		return (1);
	}

	/**
	 * Exportacao - criar arquivo com mensagens das paginas
	 */
	function language_page_create() {
		$cr = chr(13) . chr(10);

		$domtree = new DOMDocument('1.0', 'UTF-8');
		/* create the root element of the xml tree */
		$xmlRoot = $domtree -> createElement("xml");
		/* append it to the document created */
		$xmlRoot = $domtree -> appendChild($xmlRoot);

		$pags = array();
		$sql = "select msg_language from " . $this -> tabela . " group by msg_language";
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) { array_push($pags, $line['msg_language']);
		}

		/* Constroi as paginas */
		for ($ro = 0; $ro < count($pags); $ro++) {
			$sql = "select * from " . $this -> tabela . " where (msg_ativo = 1) ";
			$sql .= " and (msg_language = '" . $pags[$ro] . "') ";
			$sql .= " order by msg_language, msg_field ";
			$rlt = db_query($sql);

			$sx = '';

			/* Construi arquivo */
			$sv = '';
			/* validacoes de traduca */
			$sv .= '$messav = array(' . $cr;
			$sx = '<?php
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

' . $cr;
			$sx .= '/* Arquivo de Mensagens das paginas */' . $cr;
			$sx .= '$messa = array(' . $cr;
			$idio = "xxx";
			$it = 0;
			echo '<table width="100%" class="border01">';
			echo '<tr><td>';
			echo 'Language: ' . $pags[$ro] . '<BR>';

			/* Create XML */

			while ($xline = db_read($rlt)) {
				$xlan = trim($xline['msg_language']);
				$xfile = trim($xline['msg_field']);
				$xpage = trim($xline['msg_content']);
				$xfile = troca($xfile,'&','[e]');
				$xpage = troca($xpage,'&','[e]');
				if (strlen($xfile) > 0) {
					if ($xfile != $xpage)
						{
						$currentReg = $domtree -> createElement("reg");
						$xmlRoot -> appendChild($currentReg);
						$currentReg -> appendChild($domtree -> createElement('msg_language', $xlan));
						$currentReg -> appendChild($domtree -> createElement('msg_field', $xfile));
						$currentReg -> appendChild($domtree -> createElement('msg_content', $xpage));
						}
					
				}

				if ($xlan != $idio) {
					if ($it > 0) { $sx .= $cr . ') ,';
					}
					if ($it > 0) { $sv .= $cr . ') ,';
					}
					/* mensagens */

					/* validacao */
					$sv .= $cr;
					$sv .= '/* New Language ' . $xline['msg_language'] . ' */';
					$sv .= $cr;
					$sv .= "'" . $xline['msg_language'] . "'=>";
					$sv .= " array(" . $cr;

					/* mensagens */
					$sx .= $cr;
					$sx .= '/* New Language ' . $xline['msg_language'] . ' */';
					$sx .= $cr;
					$sx .= "'" . $xline['msg_language'] . "'=>";
					$sx .= " array(" . $cr;
					$it = 0;
					$idio = $xlan;

				}

				if ($it > 0) { $sx .= ',' . $cr;
				}
				if ($it > 0) { $sv .= ',' . $cr;
				}

				$page_banco = $line['msg_pag'];
				if (!strlen(trim($page_banco)) == 0) {
					$page_banco = unserialize($page_banco);
				} else {
					$page_banco = array();
				}

				$pages = ' array(';
				$i = 0;
				foreach ($page_banco as $key => $value) {
					if ($i > 0) { $pages .= ', ';
					}
					$pages .= "'$key' => '$value' ";
					$i++;
				}
				$pages .= ')';

				$sx .= "             '" . trim($xline['msg_field']) . "'=>'" . trim(($xline['msg_content'])) . "' ";
				$sv .= "             '" . trim($xline['msg_field']) . "'=>" . $pages . " ";
				$it++;
				//echo '<BR>'.trim($xline['msg_field']);
				echo '. ';
			}
			echo '</table>';
			$sx .= $cr . ')';
			$sx .= '); ';
			$sx .= $cr;

			$sv .= $cr . ')';
			$sv .= '); ';
			$sv .= $cr;

			/* Salvar arquivo */
			$arq = 'messages/msg_' . trim($pags[$ro]);
			$fld = fopen($arq . '.php', 'w+');
			fwrite($fld, $sx);
			fwrite($fld, $sv);
			fwrite($fld, '?>');
			fclose($fld);
		}

		/* XML */
		$arq = 'messages/msg.xml';
		$domtree -> save($arq);
	}

	/** Gerar codigo das mensagens */
	function updatex() {
	}

	/* Modelagem da strutura da tabela */
	function structure() {
		$sql = "CREATE TABLE " . $this -> tabela . " (
			id_msg serial NOT NULL,
			msg_pag CHAR(50),
			msg_language CHAR(5),
			msg_field CHAR(40),
			msg_content TEXT,
			msg_ativo INT
			)";
		$rlt = db_query($sql);
		return ($sql);
	}

}

/**
 * Mostra mensagem de texto conforme o conteï¿½do gravado
 * Caso nao exista a mensagem, envia para funcao de cadastrar nova
 */
function msg($s, $ed = 0) {
	global $LANG;
	global $messa, $messav;
	global $gerar, $edit_mode;
	$s = substr($s, 0, 40);
	$gerar = 0;

	/* verifica se existe $s no array de traducao */
	if (isset($messa[$LANG][$s])) {

		/* se mode de edicao habilitado */
		if (($edit_mode == 1) and ($ed == 0)) {
			/* valida se existe pagina dentro do array de validacao */
			if (!in_array(page(), $messav[$LANG][$s])) {

				$sql = "select msg_pag from _messages where msg_field = '$s'";
				$rlt = db_query($sql);
				$line = db_read($rlt);

				$array_check = $line['msg_pag'];

				if (strlen(trim($array_check)) == 0) {
					$array_check = array();
				} else {
					$array_check = unserialize($array_check);
				}

				if (!is_array($array_check)) { $array_check = array();
				}

				if (!in_array(page(), $array_check)) {
					array_push($array_check, page());
				}

				$page = serialize($array_check);
				$sql = "update _messages set msg_pag = '$page' where msg_field = '$s' ";
				$rlt = db_query($sql);
			}
		}

		/* salva */

		/* Campos para editar mensagens */
		if ($ed == 0) {
			$img = '<A href="javascript:newxy2(';
			$img .= "'message_ed_pop.php?dd2=" . page() . "&dd1=" . $s;
			$img .= "',600,600);";
			$img .= '">';
			$img .= '<img src=img/icone_alert.png width=10 border=0>';
			$img .= '</A>';
			if ($edit_mode != 1) { $img = '';
			}
			$link = $img;
		} else {
			$link = '';
		}
		return ($messa[$LANG][$s] . $link);
	} else {
		$msg = new message;
		$ido = $msg -> idioma();
		foreach ($ido as $key => $value) {
			//echo '<HR>NOVO:'.$s.'<HR>';
			$tela = msg_insert($s, $key);
		}
		return ($s);
	}
	/**
	 * Inserir nova mensagem se nao cadastrada
	 */
}

function msg_insert($s, $idioma) {
	global $edit_mode, $ln;

	if (!(empty($ln -> tabela))) {
		$tabela = $ln -> tabela;
	} else {
		$tabela = "_messages";
	}
	$s = substr($s, 0, 40);
	$sql = "select * from " . $tabela . " 
				where msg_language='$idioma' and msg_field ='" . $s . "' ";
	$txt = $s;
	$rlt = db_query($sql);
	if (!($line = db_read($rlt))) {
		if (!($edit_mode == 1)) {
			$sqlx = "insert into " . $tabela . " ";
			$sqlx .= "(msg_pag,msg_field,msg_language,msg_content,msg_ativo)";
			$sqlx .= "values ";
			/* pt_BR */
			$sql = $sqlx . "('','" . $s . "','" . $idioma . "','" . $txt . "',1);";

			$rlt = db_query($sql);
		}
	}
	return (1);
}
?>