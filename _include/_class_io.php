<?php
/**
 * Header
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com>
 * @access public
 * @version 0.15.03
 * @package INCLUDEs
 * @subpackage IO
 */
 
/* Class IO */
class io {
	var $up_maxsize = 2048012;

	var $upload_path = '_repositorio/';
	var $up_month_control = 1;
	var $filename;

	/* Load file */
	function loadfile($file, $method = 'L') {
		if ($method == 'L') {
			$sx = $this -> load_file_local($file);
		}
		return ($sx);
	}

	function load_file_local($file) {
		$sx = '';
		$fld = fopen($file, 'r');
		while (!(feof($fld))) {
			$sx .= fread($fld, 1024);
		}
		fclose($fld);
		return ($sx);
	}

	/* checa e cria diretorio */
	function dir($dir) {
		if (is_dir($dir)) { $ok = 1;
		} else {
			mkdir($dir);
			$rlt = fopen($dir . '/index.php', 'w');
			fwrite($rlt, 'acesso restrito');
			fclose($rlt);
		}
		return ($ok);
	}

	function upload_file_save() {
		global $dd, $messa, $acao, $tipo;
		$page = page() . '?';
		$page .= 'dd0=' . $dd[0] . '&dd5=' . $dd[5] . '&dd2=' . $dd[2] . '&dd1=' . $dd[1] . '&dd90=' . $dd[90];
		$saved = 0;

		if (strlen($acao) > 0) {
			$tipo = $dd[2];
			$nome = lowercasesql($_FILES['arquivo']['name']);
			$temp = $_FILES['arquivo']['tmp_name'];
			$size = $_FILES['arquivo']['size'];

			$path = $this -> upload_path;
			$extensoes = $this -> upload_format;

			/* valida extensao */
			$ext = strtolower($nome);
			while (strpos(' ' . $ext, '.') > 0) { $ext = substr($ext, strpos($ext, '.') + 1, strlen($ext));
			}
			$ext = '.' . $ext;

			/* diretorio */
			$nome = substr($nome, 0, strlen($nome) - 4);
			$nome = lowercasesql(troca($nome, ' ', '_'));
			$nome .= $ext;

			$this -> dir($path);
			if ($this -> up_month_control == 1) {
				$path .= date("Y") . '/';
				$this -> dir($path);
				$path .= date("m") . '/';
				$this -> dir($path);
			}

			/* caso nao apresente erro */
			if (strlen($erro) == 0) {
				$compl = $dd[1] . '-' . substr(md5($nome . date("His")), 0, 5) . '-';
				$compl = troca($compl, '/', '-');
				$this -> filename = $path . $compl . $nome;
				if (move_uploaded_file($temp, $path . $compl . $nome)) 
				{
					return(1);
				} 
				else 
				{
					$sx = 'Erro de salvamento';
					return(0); 
				}
			} else {
				echo '<center>' . msg($erro) . '</center>';
			}
			return(0);

		}
	}

	function upload_file_form() {
		$sx .= '<form id="upload" action="' . $page . '" method="post" enctype="multipart/form-data">
    				<BR>
	    			<nobr><fieldset><legend>' . msg('attach_file') . '</legend> 
    				<span id="post"><input type="file" name="arquivo" id="arquivo" /></span>
    				<input type="hidden" name="dd0" value="' . $dd[0] . '"> 
    				<input type="hidden" name="dd1" value="' . $dd[1] . '">
    				<input type="hidden" name="dd5" value="' . $dd[5] . '">  
    				<input type="hidden" name="dd90" value="' . $dd[90] . '"> 
    				<input type="submit" value="enviar arquivo" name="acao" id="idbotao" />
    				</fieldset>  
    				<BR>
    				<fieldset><legend>' . msg('file_tipo') . '</legend>
    				MaxSize: <B>' . number_format($this -> up_maxsize / (1024 * 1024), 0, ',', '.') . 'MByte</B>
    				&nbsp;&nbsp;&nbsp;';
		$sx .= '</fieldset></form>';
		return ($sx);
	}

}
?>
