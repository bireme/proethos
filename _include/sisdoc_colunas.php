<?php
/**
* @author Rene F. Gabriel Junior <rene@sisdoc.com.br>
* @version 0.15.03
* @access public
* @package INCLUDEs
* @subpackage Coluns
*/

if (strlen($sisdoc_colunas) == 0)
{
$sisdoc_colunas = True;

if ($mostar_versao == True) { array_push($sis_versao,array("sisDOC (Colunas)","0.0a",20080520)); }

global $vcol, $est_col;
$vcol = 0;
$est_col = "onMouseOver=\"this.style.backgroundColor='#e4f7fa'\" onMouseOut=\"this.style.backgroundColor=''\"";

function Coluna()
	{
	global $vcol, $est_col;	
	if ($vcol ==0)
		{
		$xvcol = "";
		$vcol=1;
		}
	else
		{
		$xvol = ' bgcolor="#F0F0F0" ';
		$vcol=0;
		}
		$xvol = $xvol . $est_col;
		return($xvol  );
	}
}
?>