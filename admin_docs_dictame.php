<?
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
 * Admin Menu
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright © Pan American Health Organization, 2013. All rights reserved.
 * @access public
 * @version v0.13.46
 * @package ProEthos-Admin
 * @subpackage document+type
 */

require ("cab.php");
$chkp = trim(md5(date("Ymdh")));
$dd[2] = trim($dd[2]);
/* Admin Common */
$ok = (($perfil -> valid('#ADM')) or ($perfil -> valid('#SCR')) or ($perfil -> valid('#COO')));
if ($ok == 0) {
	redirecina('main.php');
}
$css = array();

$dir = 'document/templates/';
$filter = '(' . $LANG . ')';
echo '<h1>' . msg('document_models') . '</h1>';

if (strlen($dd[2]) > 0) {
	if ($dd[2] == $chkp) {
		$nomet = $_FILES['arquivo']['name'];
		$temp = $_FILES['arquivo']['tmp_name'];
		$size = $_FILES['arquivo']['size'];
		$nome = $dd[1];
		$check = $dd[3];
		
		if (move_uploaded_file($temp,$dir.$nome) == 1)
			{
				echo '<font color="green">';
				echo $nome.' '.msg('file_saved');
				echo '</font>';	
			} else {
				echo '<font color="red">';
				echo $nome.' '.msg('file_not_saved');
				echo '</font>';
				exit;					
			}
		redirecina(page());
	} else {
		echo '<BR>Erro de check';
		echo '<BR>'.$dd[2];
		echo '<BR>'.$chkp;
	}
}

echo '<HR>';
$sx = '<Table class="tabela00" width="100%">';
if (is_dir($dir)) {
	if ($handle = opendir($dir)) {
		$sigla = array('', 'k', 'M', 'G', 'T', 'P');

		/* Esta na forma correta de varrer o diretorio */
		$id = 0;
		$js = '';
		while (false !== ($file = readdir($handle))) {

			$file = trim($file);

			if (is_dir($dir . $file)) {
				// $sx .= '<TR>';
				// $sx .= '<TD>'. utf8_encode($file);
				// $sx .= '<TD align="center" width="100">[DIR]';
			} else {
				$size = filesize($dir . $file);
				$dv = 0;
				while ($size >= 1024) {
					$size = ($size / 1024);
					$dv++;
				}

				/* Valida idioma */
				$linkf = '<a href="' . $dir . utf8_encode($file) . '" target="_new" class="link">';

				if (strpos($file, $filter) > 0) {
					$id++;
					$sx .= '<TR valign="top">';
					$sx .= '<TD>' . $linkf . utf8_encode($file) . '</A>';
					$sx .= '<div id="fl' . $id . 'm" style="display: none;">';
					$sx .= show_update_form($file);
					$sx .= '</div>';
					$sx .= '<td align="right" width="150">' . number_format($size, 1) . $sigla[$dv] . ' byte';
					$sx .= '<TD width="32">';
					$sx .= '<img src="img/icone_data_transfer.png" width="24" id="fl' . $id . '" style="cursor: pointer;">';

					$js .= '$("#fl' . $id . '").click(function() { $("#fl' . $id . 'm").toggle("slow"); }); ' . chr(13) . chr(10);

				}
			}

			if ((substr($file, 0, 1) != '.') and (!(is_dir($dir . '/' . $file)))) {
				//echo "<BR>==>$dir/$file\n";
				//echo '<font class="blue">ok</font>';
				array_push($css, $dir . '/' . $file);
			}
		}
		closedir($handle);
		$sx .= '</table>';
		$sx .= "
		<script>
			$js
		</script>
		";
		echo $sx;
	} else {
		echo 'Directory not found';
		exit ;
	}
}
echo '</div>';
echo $hd -> foot();

function show_update_form($file) {
	global $chkp;
	$file = trim($file);

	$sx .= '<form id="upload" action="' . page() . '" method="post" enctype="multipart/form-data">
	    			<nobr><fieldset><legend>' . msg('upload_submit') . '</legend> 
    				<span id="post"><input type="file" name="arquivo" id="arquivo" /></span>
    				<input type="hidden" name="dd0" value=""> 
    				<input type="hidden" name="dd1" value="' . $file . '">
    				<input type="hidden" name="dd2" value="' . $chkp . '">
    				<input type="hidden" name="dd3" value="' . checkpost($file) . '">
    				<input type="submit" value="enviar arquivo" name="acao" id="idbotao" />
    				</fieldset>  
    				<BR>';
	$sx .= '</fieldset></form>';
	return ($sx);
}
?>